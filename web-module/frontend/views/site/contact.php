<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \frontend\models\ContactForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <div class="contact-form bg-light p-30">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <!-- Campo para o nome -->
                <?= $form->field($model, 'name')->textInput([
                    'autofocus' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Your Name'
                ]) ?>

                <!-- Campo para o email -->
                <?= $form->field($model, 'email')->input('email', [
                    'class' => 'form-control',
                    'placeholder' => 'Your Email'
                ]) ?>

                <!-- Campo para o assunto -->
                <?= $form->field($model, 'subject')->textInput([
                    'class' => 'form-control',
                    'placeholder' => 'Subject'
                ]) ?>

                <!-- Campo para a mensagem -->
                <?= $form->field($model, 'body')->textarea([
                    'rows' => 8,
                    'class' => 'form-control',
                    'placeholder' => 'Message'
                ]) ?>

                <!-- Campo para o captcha -->
                <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <!-- Botão de envio -->
                <div class="form-group">
                    <?= Html::submitButton('Send Message', [
                        'class' => 'btn btn-primary py-2 px-4',
                        'name' => 'contact-button'
                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>