<?php

namespace console\controllers;

use yii;
use yii\console\Controller;
use yii\filters\AccessControl;

class ManagerController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [ //ações do controlador que estarão sujeitas a esse comportamento de acesso. Neste caso, são listadas várias ações que requerem verificação de acesso
                    'issue-invoice', 'manage-accessory-stock', 'manage-part-stock',
                    'manage-orders', 'manage-clients', 'manage-repair-technicians',
                    'manage-suppliers', 'manage-managers', 'update-order-progress'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manager'], //apenas os managers podem aceder
                    ],
                ],
            ],
        ];
    }


    public function actionIssueInvoice()
    {
        // Código para emitir fatura
    }

    public function actionManageAccessoryStock()
    {
        // Código para gerir stocks de acessórios
    }

    public function actionManagePartStock()
    {
        // Código para gerir sotcks de peças
    }
}