<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="/" class="d-block"><?= Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => array_filter([
                    Yii::$app->user->can("listRepairTechnician") ? [
                        'label' => 'Repair Technicians',
                        'icon' => 'hard-hat',
                        'url' => ['repair-technician/index'],
                    ] : [],
                    Yii::$app->authManager->getAssignment("repairTechnician", Yii::$app->user->id) ? [
                        'label' => 'You',
                        'icon' => 'hard-hat',
                        'url' => ['repair-technician/view', "id" => Yii::$app->user->id],
                    ] : [],
                    Yii::$app->user->can("listManagers") ? [
                        'label' => 'Managers',
                        'icon' => 'user-tie',
                        'url' => ['manager/index'],
                    ] : [],
                    Yii::$app->authManager->getAssignment("manager", Yii::$app->user->id) ? [
                        'label' => 'You',
                        'icon' => 'user-tie',
                        'url' => ['manager/view', 'id' => Yii::$app->user->id],
                    ] : [],
                    Yii::$app->user->can("listClients") ? [
                        'label' => 'Clients',
                        'icon' => 'users',
                        'url' => ['client/index'],
                    ] : [],
                    Yii::$app->user->can("listSuppliers") ? [
                        'label' => 'Suppliers',
                        'icon' => 'truck',
                        'url' => ['supplier/index'],
                    ] : [],
                    Yii::$app->user->can("listProductCategories") ? [
                        'label' => 'Product Categories',
                        'icon' => 'tags',
                        'url' => ['product-category/index'],
                    ] : [],
                    Yii::$app->user->can("listProducts") ? [
                        'label' => 'Products',
                        'icon' => 'box',
                        'url' => ['product/index'],
                    ] : [],
                    Yii::$app->user->can("listBudgets") ? [
                        'label' => 'Budgets',
                        'icon' => 'wallet',
                        'url' => ['budget/index'],
                    ] : [],
                    (Yii::$app->user->can("listBookings")) ? [
                        'label' => 'Bookings',
                        'icon' => 'calendar-alt',
                        'url' => ['booking/index'],
                    ] : [],
                    Yii::$app->user->can("listFavoriteProducts") ? [
                        'label' => 'Favorite Products',
                        'icon' => 'star',
                        'url' => ['favorite-product/index'],
                    ] : [],
                    Yii::$app->user->can("listComments") ? [
                        'label' => 'Comments',
                        'icon' => 'comment',
                        'url' => ['comment/index'],
                    ] : [],
                    Yii::$app->user->can("listInvoices") ? [
                        'label' => 'Invoices',
                        'icon' => 'file-invoice',
                        'url' => ['invoice/index'],
                    ] : [],
                    Yii::$app->user->can("listRepairs") ? [
                        'label' => 'Repairs',
                        'icon' => 'screwdriver',
                        'url' => ['repair/index'],
                    ] : [],
                    Yii::$app->user->can("listSales") ? [
                        'label' => 'Sales',
                        'icon' => 'box',
                        'url' => ['sale/index'],
                    ] : [],
                    /*
                    Yii::$app->user->can("listRepairParts") ? [
                        'label' => 'Repair Parts',
                        'icon' => 'toolbox',
                        'url' => ['repair/index'],
                    ] : [],

                    [
                        'label' => 'Settings',
                        'icon' => 'gear',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                            ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                        ]
                    ],
                    ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                    ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
                    ['label' => 'Level1'],
                    [
                        'label' => 'Level1',
                        'items' => [
                            ['label' => 'Level2', 'iconStyle' => 'far'],
                            [
                                'label' => 'Level2',
                                'iconStyle' => 'far',
                                'items' => [
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
                                ]
                            ],
                            ['label' => 'Level2', 'iconStyle' => 'far']
                        ]
                    ],
                    ['label' => 'Level1'],
                    ['label' => 'LABELS', 'header' => true],
                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'], */
                ])
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>