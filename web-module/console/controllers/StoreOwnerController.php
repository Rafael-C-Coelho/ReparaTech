<?php

namespace console\controllers;

use yii\console\Controller;
use yii\filters\AccessControl;

class StoreOwnerController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['manage-clients', 'manage-technicians', 'manage-suppliers', 'manage-managers'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['storeOwner'],
                    ],
                ],
            ],
        ];
    }

    public function actionManageClients()
    {
        //lógica para gerir clientes
    }

    public function actionManageTechnicians()
    {
        //lógica para gerir técnicos
    }

    public function actionManageSuppliers()
    {

        //lógica para gerir fornecedores
    }

    public function actionManageManagers()
    {
        //lógica para gerir managers
    }

}