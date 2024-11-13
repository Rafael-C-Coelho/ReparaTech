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

    private function initUsersWithRoles($auth)
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@localhost.test';
        $user->name = 'Admin';
        $user->setPassword('admin');
        $user->password = 'admin';
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save();
        echo "Admin user created with ID: $user->id\n";
        $auth->assign($auth->getRole('storeOwner'), $user->id);
        $user->save();

        $user = new User();
        $user->username = 'manager';
        $user->email = 'manager@localhost.test';
        $user->name = 'Manager';
        $user->setPassword('manager');
        $user->password = 'manager';
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save();
        if ($user->errors) {
            echo json_encode($user->errors);
            return;
        }
        echo "Manager user created with ID: $user->id\n";
        $auth->assign($auth->getRole('manager'), $user->id);
        $user->save();

        $user = new User();
        $user->username = 'repairman';
        $user->email = 'repairman@localhost.test';
        $user->name = 'Repairman';
        $user->setPassword('repairman');
        $user->password = 'repairman';
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save();
        if ($user->errors) {
            echo json_encode($user->errors);
            return;
        }
        echo "RepairTechnician user created with ID: $user->id\n";
        $auth->assign($auth->getRole('repairTechnician'), $user->id);
        $user->save();

        $user = new User();
        $user->username = 'client';
        $user->email = 'client@localhost.test';
        $user->name = 'Client';
        $user->setPassword('client');
        $user->password = 'client';
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save();
        if ($user->errors) {
            echo json_encode($user->errors);
            return;
        }
        echo "Client user created with ID: $user->id\n";
        $auth->assign($auth->getRole('client'), $user->id);
        $user->save();

        echo "Users created with roles.\n";
    }

    private function initEntityPermissions($auth)
    {
        // Define all entities that need permissions
        $entities = [
            'Budgets',
            'BudgetParts',
            'Clients',
            'Comments',
            'FavoriteProducts',
            'Invoices',
            'Managers',
            'Parts',
            'ProductCategories',
            'Products',
            'Repairs',
            'RepairParts',
            'RepairTechnician',
            'Sales',
            'SaleProducts',
            'Suppliers',
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
        $auth->addChild($repairTechnician, $auth->getPermission('createRepairs'));
        $auth->addChild($repairTechnician, $auth->getPermission('updateRepairs'));
        $auth->addChild($repairTechnician, $auth->getPermission('deleteRepairs'));

        // Parts permissions
        $auth->addChild($repairTechnician, $auth->getPermission('listParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('createParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('updateParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('deleteParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('viewParts'));

        // Repair Parts permissions
        $auth->addChild($repairTechnician, $auth->getPermission('listRepairParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('createRepairParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('updateRepairParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('deleteRepairParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('viewRepairParts'));

        // Budget Parts permissions
        $auth->addChild($repairTechnician, $auth->getPermission('listBudgetParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('createBudgetParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('updateBudgetParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('deleteBudgetParts'));
        $auth->addChild($repairTechnician, $auth->getPermission('viewBudgetParts'));

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
        $auth->addChild($clientRole, $auth->getPermission('listFavoriteProducts'));
        $auth->addChild($clientRole, $auth->getPermission('viewFavoriteProducts'));
        $auth->addChild($clientRole, $auth->getPermission('createFavoriteProducts'));
        $auth->addChild($clientRole, $auth->getPermission('deleteFavoriteProducts'));

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

        $entities = [
            'Clients',
            'Invoices',
            'Parts',
            'ProductCategories',
            'Products',
            'Repairs',
            'Sales',
            'SaleProducts',
            'Suppliers',
        ];

        $entities = ['Parts', 'Clients', 'Invoices', 'Repairs', 'Budgets',
            'ProductCategories', 'RepairTechnician', 'Sales', 'Suppliers', 'Products'];

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
        $entities = [
            'Budgets',
            'BudgetParts',
            'Clients',
            'Comments',
            'FavoriteProducts',
            'Invoices',
            'Managers',
            'Parts',
            'ProductCategories',
            'Products',
            'Repairs',
            'RepairParts',
            'RepairTechnician',
            'Sales',
            'SaleProducts',
            'Suppliers',
        ];

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