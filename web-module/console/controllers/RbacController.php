<?php

namespace console\controllers;

use common\models\User;
use yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Clear all existing permissions, roles and assignments
        $auth->removeAll();

        // Initialize all entity permissions
        $this->initEntityPermissions($auth);

        // Initialize roles
        $this->initRepairTechnician($auth);
        $this->initClient($auth);
        $this->initManager($auth);
        $this->initStoreOwner($auth);

        $this->initUsersWithRoles($auth);

        echo "RBAC configuration completed.\n";
    }

    private function initUsersWithRoles()
    {
        $auth = Yii::$app->authManager;
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@localhost.test';
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $auth->assign($auth->getRole('storeOwner'), $user->id);
        $user->save();

        $user = new User();
        $user->username = 'manager';
        $user->email = 'manager@localhost.test';
        $user->setPassword('manager');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $auth->assign($auth->getRole('manager'), $user->id);
        $user->save();

        $user = new User();
        $user->username = 'repairman';
        $user->email = 'repairman@localhost.test';
        $user->setPassword('repairman');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $auth->assign($auth->getRole('repairTechnician'), $user->id);
        $user->save();

        $user = new User();
        $user->username = 'client';
        $user->email = 'client@localhost.test';
        $user->setPassword('client');
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $auth->assign($auth->getRole('client'), $user->id);
        $user->save();

        echo "Users created with roles.\n";
    }

    private function initEntityPermissions($auth)
    {
        // Define all entities that need permissions
        $entities = [
            'Parts',
            'Clients',
            'Managers',
            'Invoices',
            'Repairs',
            'Budgets',
            'Repairmen',
            'Sales',
            'Suppliers',
            'Products',
            'ProductCategories',
            'ProductsFavorites'
        ];

        // Define standard operations
        $operations = [
            'create' => 'Create new',
            'update' => 'Update existing',
            'delete' => 'Delete existing',
            'view' => 'View details of',
            'list' => 'List all'
        ];

        // Create permissions for each entity
        foreach ($entities as $entity) {
            foreach ($operations as $operation => $description) {
                $permissionName = lcfirst($operation . $entity);
                echo "Creating permission: $permissionName\n";
                $this->addPermission(
                    $auth,
                    $permissionName,
                    "$description $entity"
                );
            }
        }

        echo "Base permissions created for all entities.\n";
    }

    private function initRepairTechnician($auth)
    {
        $repairTechnician = $auth->createRole('repairTechnician');
        $auth->add($repairTechnician);

        // Repair permissions
        $auth->addChild($repairTechnician, $auth->getPermission('listRepairs'));
        $auth->addChild($repairTechnician, $auth->getPermission('viewRepairs'));
        $auth->addChild($repairTechnician, $auth->getPermission('updateRepairs'));

        // Parts permissions
        $auth->addChild($repairTechnician, $auth->getPermission('listParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('createParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('updateParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('deleteParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('viewParts'));

        // Budget permissions
        $auth->addChild($repairTechnician, $auth->getPermission('createBudgets'));
        $auth->addChild($repairTechnician, $auth->getPermission('updateBudgets'));
        $auth->addChild($repairTechnician, $auth->getPermission('viewBudgets'));

        echo "RBAC configured for Repair Technician.\n";
    }

    private function initClient($auth)
    {
        $clientRole = $auth->createRole('client');
        $auth->add($clientRole);

        // Products permissions
        $auth->addChild($clientRole, $auth->getPermission('listProducts'));
        $auth->addChild($clientRole, $auth->getPermission('viewProducts'));

        // Product Categories permissions
        $auth->addChild($clientRole, $auth->getPermission('listProductCategories'));
        $auth->addChild($clientRole, $auth->getPermission('viewProductCategories'));

        // Products Favorites permissions
        $auth->addChild($clientRole, $auth->getPermission('listProductsFavorites'));
        $auth->addChild($clientRole, $auth->getPermission('viewProductsFavorites'));
        $auth->addChild($clientRole, $auth->getPermission('createProductsFavorites'));
        $auth->addChild($clientRole, $auth->getPermission('deleteProductsFavorites'));

        // Products permissions
        $auth->addChild($clientRole, $auth->getPermission('listSales'));
        $auth->addChild($clientRole, $auth->getPermission('viewSales'));

        // Repairs permissions
        $auth->addChild($clientRole, $auth->getPermission('createRepairs'));
        $auth->addChild($clientRole, $auth->getPermission('viewRepairs'));
        $auth->addChild($clientRole, $auth->getPermission('listRepairs'));

        // Budgets permissions
        $auth->addChild($clientRole, $auth->getPermission('listBudgets'));
        $auth->addChild($clientRole, $auth->getPermission('viewBudgets'));
        $auth->addChild($clientRole, $auth->getPermission('updateBudgets'));

        // Invoices permissions
        $auth->addChild($clientRole, $auth->getPermission('viewInvoices'));
        $auth->addChild($clientRole, $auth->getPermission('listInvoices'));

        echo "RBAC configured for Client role.\n";
    }

    private function initManager($auth)
    {
        $managerRole = $auth->createRole('manager');
        $auth->add($managerRole);

        $entities = ['Parts', 'Clients', 'Invoices', 'Repairs', 'Budgets',
            'ProductCategories', 'Repairmen', 'Sales', 'Suppliers', 'Products'];

        foreach ($entities as $entity) {
            $operations = ['create', 'update', 'delete', 'view', 'list'];
            foreach ($operations as $operation) {
                $permissionName = lcfirst($operation . $entity);
                $auth->addChild($managerRole, $auth->getPermission($permissionName));
            }
        }

        echo "RBAC configured for Manager role.\n";
    }

    private function initStoreOwner($auth)
    {
        $storeOwnerRole = $auth->createRole('storeOwner');
        $auth->add($storeOwnerRole);

        // Store owner has all permissions
        $entities = ['Parts', 'Clients', 'Managers', 'Invoices', 'Repairs',
            'Budgets', 'Repairmen', 'Sales', 'Suppliers', 'Products', 'ProductCategories'];

        foreach ($entities as $entity) {
            $operations = ['create', 'update', 'delete', 'view', 'list'];
            foreach ($operations as $operation) {
                $permissionName = lcfirst($operation . $entity);
                $auth->addChild($storeOwnerRole, $auth->getPermission($permissionName));
            }
        }

        echo "RBAC configured for Store Owner role.\n";
    }

    protected function addPermission($auth, $name, $description)
    {
        if (!$auth->getPermission($name)) {
            $permission = $auth->createPermission($name);
            $permission->description = $description;
            $auth->add($permission);
        }
    }
}