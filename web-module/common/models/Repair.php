<?php

namespace common\models;

use common\models\Budget;
use common\models\RepairPart;
use common\models\User;
use Dompdf\Dompdf;
use yii\helpers\FileHelper;
use Mpdf;


/**
 * This is the model class for table "repairs".
 *
 * @property int $id
 * @property string $device
 * @property string $progress
 * @property int $repairman_id
 * @property int $client_id
 * @property string $status
 * @property string $description
 *
 * @property Budget[] $budgets
 * @property User $client
 * @property User $repairman
 * @property RepairPart[] $repairsHasParts
 *
 */
class Repair extends \yii\db\ActiveRecord
{

    const STATUS_PENDING_ACCEPTANCE = "Pending Acceptance";
    const STATUS_CREATED = "Created";
    const STATUS_DENIED = "Denied";
    const STATUS_IN_PROGRESS = "In Progress";
    const STATUS_COMPLETED = "Completed";


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'repairs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device', 'progress', 'repairman_id', 'client_id', 'description'], 'required'],
            [['device', 'progress', 'description'], 'string'],
            [['repairman_id', 'client_id', 'hours_spent_working'], 'integer'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
            [['repairman_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['repairman_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device' => 'Device',
            'progress' => 'Progress',
            'hours_spent_working' => 'Hours Spent Working',
            'repairman_id' => 'Repairman ID',
            'client_id' => 'Client ID',
        ];
    }

    /**
     * Gets query for [[Budgets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudgets()
    {
        if (isset(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)["repairTechnician"])) {
            return $this->hasMany(Budget::class, ['repair_id' => 'id'])->where(["repairman_id" => \Yii::$app->user->id]);
        }
        return $this->hasMany(Budget::class, ['repair_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['id' => 'repair_id']);
    }

    /**
     * Gets query for [[Budgets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLastAcceptedBudget()
    {
        return $this->hasMany(Budget::class, ['repair_id' => 'id'])->where(["status" => Budget::STATUS_APPROVED])->orderBy(['id' => SORT_DESC]);
    }

    /**
     * Gets query for [[Invoices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::class, ['id' => 'repair_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Repairman]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepairman()
    {
        return $this->hasOne(User::class, ['id' => 'repairman_id']);
    }

    public static function getRepairs()
    {
        if (isset(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)["repairTechnician"])) {
            return Repair::find()->where(["repairman_id" => \Yii::$app->user->id])->all();
        }
        return Repair::find()->all();
    }

    public function getBooking(){
        return $this->hasMany(\common\models\Booking::class,['repair_id' => 'id']);
    }

    private function renderInvoiceHtml($items, $invoice)
    {
        return \Yii::$app->controller->renderPartial('invoice-repair', [
            'model' => $this,
            'items' => $items,
            'invoice' => $invoice
        ]);
    }

    public function beforeSave($insert)
    {
        if ($this->progress === Repair::STATUS_COMPLETED) {
            $path = \Yii::getAlias('@app/web/uploads/invoices');
            FileHelper::createDirectory($path);


            // Save file path to the model
            $invoice = new Invoice();
            $invoice->client_id = $this->client_id;
            $acceptedBudget = $this->getLastAcceptedBudget()->one();
            $items = [
                [
                    'name' => "Parts",
                    'description' => "Parts used for the repair",
                    'price' => $acceptedBudget->value,
                ],
                [
                    'name' => "Hours worked",
                    'description' => $this->hours_spent_working . " hours spent working",
                    'price' => $this->hours_spent_working * $this->getRepairman()->one()->value,
                ]
            ];
            $invoice->total = $this->hours_spent_working * $this->getRepairman()->one()->value + $acceptedBudget->value;
            $invoice->items = json_encode($items);
            $invoice->save();
            $fileName = 'invoice_' . $invoice->id . '.pdf';
            $filePath = $path . DIRECTORY_SEPARATOR . $fileName;
            $this->invoice_id = $invoice->id;

            $content = $this->renderInvoiceHtml($items, $invoice);
            $dompdf = new Dompdf();
            $dompdf->loadHtml($content);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Save PDF to file
            file_put_contents($filePath, $dompdf->output());

            $invoice->pdf_file = '/uploads/invoices/' . $fileName;
            $invoice->save();
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $user = User::find()->where(['id' => $this->client_id])->one();
        $comment = new Comment();
        $comment->repair_id = $this->id;
        if ($this->progress === Repair::STATUS_CREATED) {
            $comment->description = "Your repair has been created";
            $comment->save();
            \Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'createdRepair-html', 'text' => 'createdRepair-text'],
                    ['user' => $user]
                )
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setTo($this->client->email)
                ->setSubject('Your repair has been created at ' . \Yii::$app->name)
                ->send();
        } else if ($this->progress === Repair::STATUS_PENDING_ACCEPTANCE) {
            $comment->description = "Your repair is pending acceptance";
            $comment->save();
            \Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'pendingRepair-html', 'text' => 'pendingRepair-text'],
                    ['user' => $user]
                )
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setTo($this->repairman->email)
                ->setSubject('You have a repair to accept/deny at ' . \Yii::$app->name)
                ->send();
        } else if ($this->progress === Repair::STATUS_DENIED) {
            $comment->description = "Your repair has been denied";
            $comment->save();
            \Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'deniedRepair-html', 'text' => 'deniedRepair-text'],
                    ['user' => $user]
                )
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setTo($this->client->email)
                ->setSubject('Your repair has been denied at ' . \Yii::$app->name)
                ->send();
        } else if ($this->progress === Repair::STATUS_IN_PROGRESS) {
            $comment->description = "Your repair is in progress";
            $comment->save();
            \Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'inProgressRepair-html', 'text' => 'inProgressRepair-text'],
                    ['user' => $user]
                )
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setTo($this->client->email)
                ->setSubject('Your repair is in progress at ' . \Yii::$app->name)
                ->send();
        } else if ($this->progress === Repair::STATUS_COMPLETED) {
            $comment->description = "Your repair has been completed";
            $comment->save();
            \Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'completedRepair-html', 'text' => 'completedRepair-text'],
                    ['user' => $user]
                )
                ->attach(\Yii::getAlias('@app/web') . Invoice::find()->where(['id' => $this->invoice_id])->one()->pdf_file, ['fileName' => 'invoice.pdf', 'contentType' => 'application/pdf'])
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setTo($this->client->email)
                ->setSubject('Your repair has been completed at ' . \Yii::$app->name)
                ->send();
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
