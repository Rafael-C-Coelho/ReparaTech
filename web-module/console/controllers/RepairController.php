<?php

namespace console\controllers;

use yii;
use yii\console\Controller;
use yii\filters\AccessControl;


class RepairController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['repairTechnician'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['edit-quote'],
                        'roles' => ['repairTechnician'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['manage-quote'],
                        'roles' => ['repairTechnician'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['define-parts'],
                        'roles' => ['repairTechnician'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add-comment'],
                        'roles' => ['repairTechnician'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['confirm-schedule'],
                        'roles' => ['repairTechnician'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        // Lógica para listar todas as reparações
    }

    public function actionViewQuote($id)
    {
        // Lógica para exibir detalhes de uma reparação
    }

    public function actionEditQuote($id)
    {
        // Lógica para editar um orçamento
    }

    public function actionSendQuoate($id)
    {
        // Lógica para enviar um orçamento
    }

    public function actionCreateRepairQuote() {

        // Lógica para criar um orçamento de reparação
    }

    public function actionAddComment($id)
    {
        // Lógica para adicionar comentários com ou sem fotos sobre a reparação
    }

}