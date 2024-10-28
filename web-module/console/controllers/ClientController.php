<?php

namespace console\controllers;

use yii;
use yii\console\Controller;
use yii\filters\AccessControl;


class ClientController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [  'view-accessories', 'register-account',
                                        'login', 'add-to-cart', 'add-to-favorites',
                                        'request-quotation', 'view-order-progress',
                                        'view-repair-progress', 'approve-quotation',
                                        'make-payment', 'update-order-progress', 'view-invoice'],
                        'roles' => ['@'], // Papel que pode realizar todas essas ações
                    ],
                ],
            ],
        ];
    }

    public function actionViewAccessories()
    {
        // Lógica para visualizar a lista de acessórios
    }

    public function actionRegisterAccount()
    {
        // Lógica para registrar conta cliente
    }

    public function actionLogin()
    {
        // Lógica para fazer login na conta cliente
    }

    public function actionAddToCart()
    {
        // Lógica para adicionar acessório(s) ao carrinho de compras
    }

    public function actionAddToFavorites()
    {
        // Lógica para adicionar acessório à lista de favoritos
    }

    public function actionRequestQuotation()
    {
        // Lógica para pedir orçamento de reparação
    }

    public function actionViewOrderProgress()
    {
        // Lógica para visualizar o progresso da encomenda
    }

    public function actionViewRepairProgress()
    {
        // Lógica para visualizar o progresso da reparação
    }

    public function actionApproveQuotation()
    {
        // Lógica para aprovar ou rejeitar orçamento
    }

    public function actionMakePayment()
    {
        // Lógica para realizar pagamento
    }

    public function actionUpdateOrderProgress()
    {
        // Lógica para atualizar o progresso da encomenda
    }

    public function actionViewInvoice()
    {
        // Lógica para visualizar a fatura
    }
}