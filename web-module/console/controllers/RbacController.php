<?php

namespace console\controllers;

use yii; 
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Limpa todas as permissões, papéis e atribuições anteriores
        $auth->removeAll();

        $this->initRepairTechnician($auth);
        $this->initClient($auth);
        $this->initManager($auth);
        $this->initStoreOwner($auth);

        echo "RBAC configured for Repair Technician, Client, Manager and Store Owner roles.\n";
    }

    private function initRepairTechnician($auth)
    {
        // Criar permissões específicas para o Repair Technician
        $viewRepairs = $auth->createPermission('viewRepairs');
        $viewRepairs->description = 'View the list of their repairs';
        $auth->add($viewRepairs);

        $editRepair = $auth->createPermission('editRepair');
        $editRepair->description = 'Edit their own repairs';
        $auth->add($editRepair);

        $manageQuotation = $auth->createPermission('manageQuotation');
        $manageQuotation->description = 'Create and edit repair quotation';
        $auth->add($manageQuotation);

        $defineParts = $auth->createPermission('defineParts');
        $defineParts->description = 'Define parts needed for the repair';
        $auth->add($defineParts);


        $addComment = $auth->createPermission('addComment');
        $addComment->description = 'Add comments with or without photos on repair';
        $auth->add($addComment);

        $confirmSchedule = $auth->createPermission('confirmSchedule');
        $confirmSchedule->description = 'Confirm repair schedule';
        $auth->add($confirmSchedule);

        // Criar o papel Repair Technician
        $repairTechnician = $auth->createRole('repairTechnician');
        $auth->add($repairTechnician);

        // Atribuir permissões ao papel Repair Technician
        $auth->addChild($repairTechnician, $viewRepairs);
        $auth->addChild($repairTechnician, $editRepair);
        $auth->addChild($repairTechnician, $manageQuotation);
        $auth->addChild($repairTechnician, $defineParts);
        $auth->addChild($repairTechnician, $addComment);
        $auth->addChild($repairTechnician, $confirmSchedule);


        echo "RBAC configured for Repair Technician.\n";
        $auth->assign($repairTechnician, 3);

    }

    private function initClient($auth)
    {

        $viewAccessories = $auth->createPermission('viewAccessories');
        $viewAccessories->description = 'View list of accessories';
        $auth->add($viewAccessories);

        $registerClientAccount = $auth->createPermission('registerClientAccount');
        $registerClientAccount->description = 'Register a client account';
        $auth->add($registerClientAccount);

        $loginClientAccount = $auth->createPermission('loginClientAccount');
        $loginClientAccount->description = 'Login to client account';
        $auth->add($loginClientAccount);

        $addAccessoriesToCart = $auth->createPermission('addAccessoriesToCart');
        $addAccessoriesToCart->description = 'Add accessories to shopping cart';
        $auth->add($addAccessoriesToCart);

        $addAccessoriesToFavorites = $auth->createPermission('addAccessoriesToFavorites');
        $addAccessoriesToFavorites->description = 'Add accessories to favorites list';
        $auth->add($addAccessoriesToFavorites);

        $requestRepairQuotation = $auth->createPermission('requestRepairQuotation');
        $requestRepairQuotation->description = 'Request repair quotation';
        $auth->add($requestRepairQuotation);

        $viewOrderProgress = $auth->createPermission('viewOrderProgress');
        $viewOrderProgress->description = 'View order progress';
        $auth->add($viewOrderProgress);

        $viewRepairProgress = $auth->createPermission('viewRepairProgress');
        $viewRepairProgress->description = 'View repair progress';
        $auth->add($viewRepairProgress);

        $approveRejectQuotation = $auth->createPermission('approveRejectQuotation');
        $approveRejectQuotation->description = 'Approve or reject quotation';
        $auth->add($approveRejectQuotation);

        $makePayment = $auth->createPermission('makePayment');
        $makePayment->description = 'Make payment';
        $auth->add($makePayment);

        $updateOrderProgress = $auth->createPermission('updateOrderProgress');
        $updateOrderProgress->description = 'Update order progress';
        $auth->add($updateOrderProgress);

        $viewInvoice = $auth->createPermission('viewInvoice');
        $viewInvoice->description = 'View invoice';
        $auth->add($viewInvoice);


        $clientRole = $auth->createRole('client');
        $auth->add($clientRole);


        $auth->addChild($clientRole, $viewAccessories);
        $auth->addChild($clientRole, $registerClientAccount);
        $auth->addChild($clientRole, $loginClientAccount);
        $auth->addChild($clientRole, $addAccessoriesToCart);
        $auth->addChild($clientRole, $addAccessoriesToFavorites);
        $auth->addChild($clientRole, $requestRepairQuotation);
        $auth->addChild($clientRole, $viewOrderProgress);
        $auth->addChild($clientRole, $viewRepairProgress);
        $auth->addChild($clientRole, $approveRejectQuotation);
        $auth->addChild($clientRole, $makePayment);
        $auth->addChild($clientRole, $updateOrderProgress);
        $auth->addChild($clientRole, $viewInvoice);

        $auth->assign($clientRole, 4);

        echo "RBAC configured for Client role.\n";
    }

    private function initManager($auth) {

        $this->addPermission($auth, 'issueInvoice', 'Issue invoice');
        $this->addPermission($auth, 'manageAccessoryStock', 'Manage accessory stock');
        $this->addPermission($auth, 'managePartStock', 'Manage part stock');
        $this->addPermission($auth, 'manageOrders', 'Manage orders');
        $this->addPermission($auth, 'manageClients', 'Manage clients');
        $this->addPermission($auth, 'manageRepairTechnicians', 'Manage repair technicians');
        $this->addPermission($auth, 'manageSuppliers', 'Manage suppliers');
        $this->addPermission($auth, 'manageManagers', 'Manage managers');
        $this->addPermission($auth, 'updateOrderProgress', 'Update order progress');

        $managerRole = $auth->createRole('manager');
        $auth->add($managerRole);

        $auth->addChild($managerRole, $auth->getPermission('issueInvoice'));
        $auth->addChild($managerRole, $auth->getPermission('manageAccessoryStock'));
        $auth->addChild($managerRole, $auth->getPermission('managePartStock'));
        $auth->addChild($managerRole, $auth->getPermission('manageOrders'));
        $auth->addChild($managerRole, $auth->getPermission('manageClients'));
        $auth->addChild($managerRole, $auth->getPermission('manageRepairTechnicians'));
        $auth->addChild($managerRole, $auth->getPermission('manageSuppliers'));
        $auth->addChild($managerRole, $auth->getPermission('manageManagers'));
        $auth->addChild($managerRole, $auth->getPermission('updateOrderProgress'));


        $auth->assign($managerRole, 2);

        echo "RBAC configured for Manager role.\n";
    }

    private function initStoreOwner($auth) {
        $this->addPermission($auth, 'manageStore', 'Manage store');
        $this->addPermission($auth, 'manageStoreEmployees', 'Manage store employees');
        $this->addPermission($auth, 'manageStoreSuppliers', 'Manage store suppliers');
        $this->addPermission($auth, 'manageStoreOrders', 'Manage store orders');
        $this->addPermission($auth, 'manageStoreCustomers', 'Manage store customers');
        $this->addPermission($auth, 'manageStoreInventory', 'Manage store inventory');
        $this->addPermission($auth, 'manageStoreSales', 'Manage store sales');
        $this->addPermission($auth, 'manageStoreReports', 'Manage store reports');

        $storeOwnerRole = $auth->createRole('storeOwner');
        $auth->add($storeOwnerRole);

        $auth->addChild($storeOwnerRole, $auth->getPermission('manageStore'));
        $auth->addChild($storeOwnerRole, $auth->getPermission('manageStoreEmployees'));
        $auth->addChild($storeOwnerRole, $auth->getPermission('manageStoreSuppliers'));
        $auth->addChild($storeOwnerRole, $auth->getPermission('manageStoreOrders'));
        $auth->addChild($storeOwnerRole, $auth->getPermission('manageStoreCustomers'));
        $auth->addChild($storeOwnerRole, $auth->getPermission('manageStoreInventory'));
        $auth->addChild($storeOwnerRole, $auth->getPermission('manageStoreSales'));
        $auth->addChild($storeOwnerRole, $auth->getPermission('manageStoreReports'));

        $auth->assign($storeOwnerRole, 1);

        echo "RBAC configured for Store Owner role.\n";
    }



    protected function addPermission($auth, $name, $description)
    {
        if (!$auth->getPermission($name)) { // Se a permissão não existir
            $permission = $auth->createPermission($name);
            $permission->description = $description;
            $auth->add($permission);
        }
    }

}