<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\models\ProductCategory;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
$categories = ProductCategory::find()->all();
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Free HTML Templates" name="keywords">
        <meta content="Free HTML Templates" name="description">

        <!-- Favicon -->
        <link href="./img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Favicon -->
        <link href="./img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="<?= Yii::getAlias('@web') ?>/lib/animate/animate.min.css" rel="stylesheet">
        <link href="<?= Yii::getAlias('@web') ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="<?= Yii::getAlias('@web') ?>/css/style.css" rel="stylesheet">
    </head>
    <body class="d-flex flex-column h-100">

    <?php if (Yii::$app->controller->route !== "site/signup" && Yii::$app->controller->route !== "site/login") { ?>
        <div class="container-fluid p-0">
            <div class="container-fluid bg-dark">
                <div class="row px-xl-5">
                    <div class="col-lg-3 d-none d-lg-block m-auto text-center">
                        <a href="<?= \yii\helpers\Url::to(["site/index"]) ?>" class="text-decoration-none">
                            <span class="h1 text-uppercase text-primary bg-dark px-2">Repara</span>
                            <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Tech</span>
                        </a>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block">
                        <a class="btn d-flex align-items-center justify-content-between bg-primary w-100"
                           data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                            <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                            <i class="fa fa-angle-down text-dark"></i>
                        </a>
                    <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                         id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                        <div class="navbar-nav w-100">
                            <?php foreach ($categories as $category) { ?>
                                <div class="nav-item dropdown">
                                    <a href="<?= \yii\helpers\Url::to(["product/shop", "category_id" => $category->id]) ?>"
                                       class="nav-link"><?= $category->name ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    </nav>
                    </div>
                    <div class="col-lg-6">
                        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                    data-target="#navbarCollapse">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                                <div class="navbar-nav ml-auto py-0">
                                    <div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Account <i
                                                    class="fa fa-angle-down mt-1"></i></a>
                                        <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                            <?php if (Yii::$app->user->isGuest) { ?>
                                                <a href="<?= \yii\helpers\Url::to(['site/login']) ?>"
                                                   class="dropdown-item">Sign in</a>
                                                <a href="<?= \yii\helpers\Url::to(['site/signup']) ?>"
                                                   class="dropdown-item">Sign up</a>
                                            <?php } else { ?>
                                                <a href="<?= \yii\helpers\Url::to(['site/logout']) ?>"
                                                   class="dropdown-item">Log Out</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <a href="<?= Yii::$app->user->isGuest ? \yii\helpers\Url::to(["site/login"]) : \yii\helpers\Url::to(["site/index"]) /* TODO: CHANGE THE URL */ ?>"
                                       class="nav-item nav-link">
                                        <i class="fas fa-heart text-primary"></i>
                                        <?php if (!Yii::$app->user->isGuest) { ?>
                                        <span class="badge text-secondary border border-secondary rounded-circle"
                                              style="padding-bottom: 2px;"><?= Yii::$app->user->identity->getFavoriteProductsCount() > 9 ? "9+" : Yii::$app->user->identity->getfavoriteProductsCount() ?></span>
                                        <?php } ?>
                                    </a>
                                    <a href="<?= \yii\helpers\Url::to(["site/index"]) /* TODO: CHANGE THE URL */ ?>"
                                       class="nav-item nav-link">
                                        <i class="fas fa-shopping-cart text-primary"></i>
                                        <span class="badge text-secondary border border-secondary rounded-circle"
                                              style="padding-bottom: 2px;"><?php
                                                if (sizeof(Yii::$app->session->get("cart", [])) > 0) {
                                                    $quantity = 0;
                                                    foreach (Yii::$app->session->get("cart", []) as $item) {
                                                        $quantity += $item["quantity"];
                                                    }
                                                    echo $quantity > 9 ? "9+" : $quantity;
                                                } else {
                                                    echo "0";
                                                }
                                            ?></span>
                                    </a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $this->beginBody() ?>

    <header>
        <?php
        /*
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItems,
        ]);
        if (Yii::$app->user->isGuest) {
            echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
        } else {
            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout text-decoration-none']
                )
                . Html::endForm();
        }
        NavBar::end();
        */
        ?>
    </header>

    <main role="main" class="flex-shrink-0 m-4">
        <div class="">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>


    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container justify-content-between d-flex">
            <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            <p class="float-end"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Yii::getAlias('@web') ?>/lib/easing/easing.min.js"></script>
    <script src="<?= Yii::getAlias('@web') ?>/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="<?= Yii::getAlias('@web') ?>/mail/jqBootstrapValidation.min.js"></script>
    <script src="<?= Yii::getAlias('@web') ?>/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="<?= Yii::getAlias('@web') ?>/js/main.js"></script>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
