<?php
 /** @var yii\web\View $this */

    $this->title = 'All Repair Categories';
?>


<style>

    .title {
        color: #FFD333;
        text-align: center;
        margin-top: 8px;
        margin-bottom: 20px;
        font-weight: bold;

    }

    #cardRepair {
        color: #FFD333;
        margin-top: 8px;
        font-size: 25px;
        margin-bottom: 20px;
        font-weight: bold;

    }


    .text-container {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /
        background-color: #f9f9f9;
        max-width: 100%;
        margin: 20px auto;
        text-align: center;
        margin-top: 5px;
        margin-bottom: 30px;

    }

    .card {
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%; /
        max-height: 400px;
        box-sizing: border-box;

    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    .card:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .card-text {
        text-align: justify;
    }

    .card-img-top {
        width: 100%;
        height: 235px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }

    .col {
        margin-bottom: 20px;
    }

</style>

<div class="text-container">
    <h1 class="title"><?= $this->title ?></h1>
</div>


<div class="row row-cols-1 row-cols-md-3 g-12">
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/headphonesPC.jpg" class="card-img-top" alt="headphonesPc">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/audioIssue'])?>" id="cardRepair" class="card-title" <strong>Audio</strong></a>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        </div>
    </div><div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/batteryProblems.jpg" class="card-img-top" alt=batteryProblems">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/batteryIssue'])?>" id="cardRepair" class="card-title" <strong>Battery</strong></a>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/buttonWatch.jpg" class="card-img-top" alt="buttonWatch">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/damageButton'])?>" id="cardRepair" class="card-title" <strong>Buttons</strong></a>
                <p class="card-text"> If your smartwatch or other device has damaged buttons, our team is ready to solve the problem with maximum efficiency and quality. See more.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/samsungScreen.jpg" class="card-img-top" alt="samsungScreen">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/brokenScreen'])?>" id="cardRepair" class="card-title" <strong>Broken Screen</strong></a>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/iphoneCamera.jpg" class="card-img-top" alt="iphoneCamera">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/cameraIssue'])?>" id="cardRepair" class="card-title" <strong>Camera</strong></a>
                <p class="card-text">If your smartphone or other device has camera damaged, our team is ready to solve the problem with maximum efficiency and quality. See more.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?> /img/connectivityIssue" class="card-img-top" alt="connectivityIssue">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/connectivityIssue'])?>" id="cardRepair" class="card-title" <strong>Connectivity</strong></a>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/dataRecoveryProcess.jpg" class="card-img-top" alt="dataRecoveryProcess">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/dataRecovery'])?>" id="cardRepair" class="card-title" <strong>Data Recovery</strong></a>
                <p class="card-text">Have you lost important photos or documents without making a backup?
                    Our team is ready to solve the problem with maximum efficiency and quality.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/clean_pc.jpg" class="card-img-top" alt="cleanPc">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/hardwareCleaningMaintenance'])?>" id="cardRepair" class="card-title" <strong>Hardware Cleaning</strong></a>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/iphoneWater.jpg" class="card-img-top" alt="pcWater">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/liquidDamage'])?>" id="cardRepair" class="card-title" <strong>Liquid Damage</strong></a>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/speedtest.jpg" class="card-img-top" alt="speedtest">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/networkIssue'])?>" id="cardRepair" class="card-title" <strong>Network</strong></a>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/softwareAlert.jpg" class="card-img-top" alt="softwareAlert">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/softwareIssue'])?>" id="cardRepair" class="card-title" <strong>Software</strong></a>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <img src="<?= Yii::getAlias('@web')?>/img/ssd.jpg" class="card-img-top" alt="ssdMemory">
            <div class="card-body">
                <a href="<?= yii\helpers\Url::to(['site/storageIssue'])?>" id="cardRepair" class="card-title" <strong>Storage</strong></a>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        </div>
    </div>
</div>
