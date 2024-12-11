<?php

use yii\bootstrap4\Html;

?>


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    main {
        flex: 1;
    }
    footer.main-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 10px 20px;
        background-color: unset !important;
        border-top: unset !important;
        text-align: center;
        position: relative;
        bottom: 0;
    }
    html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }
</style>

<footer class="main-footer">

    <strong>Copyright &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>.</strong>
    All rights reserved.
    <div class="float-right d-none w-auto d-sm-inline-block">
        <b>Creators:</b> Diogo Gouveia, Rafael Coelho e Rafael Reis
    </div>
</footer>