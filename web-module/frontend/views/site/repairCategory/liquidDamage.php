<?php

/** @var yii\web\View $this */

$this->title = 'Liquid Damage';

?>

<style>
    .custom-img {
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .custom-img:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .title {
        color: #ffc107;
        text-align: center;
        margin-top: 8px;
        margin-bottom: 20px;
        font-weight: bold;

    }

    .text-container {
        border: 2px solid #e0e0e0; /* Cor suave para a borda */
        border-radius: 8px; /* Bordas arredondadas */
        padding: 10px; /* Espaçamento interno */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
        background-color: #f9f9f9; /* Fundo claro para separar do resto da página */
        max-width: 100%; /* Largura máxima para centralizar o conteúdo */
        margin: 20px auto; /* Centraliza horizontalmente com margem superior e inferior */
        text-align: center;
        margin-top: 5px;
        margin-bottom: 30px;

    }

</style>

<div class="text-container">
    <h1 class="title"><?= $this->title ?></h1>
</div>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="d-flex justify-content-center align-items-center">
                <img src="<?= Yii::getAlias('@web') ?>/img/"  class="d-block custom-img" alt="laptopSoftwareIssue" width="800" height="400">
            </div>
        </div>
        <div class="carousel-item">
            <div class="d-flex justify-content-center align-items-center">
                <img src="<?= Yii::getAlias('@web') ?>/img/" class="d-block custom-img" alt="mobileSoftwareIssue" width="800" height="400">
            </div>
        </div>
        <div class="carousel-item">
            <div class="d-flex justify-content-center align-items-center">
                <img src="<?= Yii::getAlias('@web') ?>/img/" class="d-block custom-img" alt="mobileSoftwareIssue" width="800" height="400">
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="fa fa-angle-left" aria-hidden="true" style="font-size:48px;color:#ffc107"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="fa fa-angle-right" aria-hidden="true" style="font-size:48px;color:#ffc107"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<p></p>

<div class="accordion" id="accordionExample">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button id="mobilePhonesButton" class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <p style="color:#ffc107"><strong>MOBILE PHONES SOLUTIONS</strong></p>
                </button>
            </h2>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <ul>
                    <li>Data recovery and/or replacement of microSD cards.</li>
                    <li>Cleaning the memory manually or using specialised tools.</li>
                    <li>Repair or replacement in case of internal storage failure (eMMC or UFS).</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <p style="color:#ffc107"><strong>TABLETS SOLUTIONS</strong></p>
                </button>
            </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <ul>
                    <li>Data recovery and/or replacement of microSD cards.</li>
                    <li>Cleaning the memory manually or using specialised tools.</li>
                    <li>Repair or replacement in case of internal storage failure (eMMC or UFS).</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingThree">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <p style="color:#ffc107"><strong>DESKTOPS AND LAPTOPS SOLUTIONS</strong></p>
                </button>
            </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                <ul>
                    <li>Diagnosis and replacement of a damaged Hard Disk Drive (HDD) or SSD.</li>
                    <li>Bad sectors on hard drives with Logical Repair (software) or physical replacement.</li>
                    <li>Installation of larger or faster discs (NVMe SSD, for example).</li>
                    <li>Disc-related boot problems such as operating system not found or boot failures.</li>
                    <li>Damaged SATA or NVMe connections are repaired or components replaced.</li>
                    <li>External disks not recognised or inaccessible.</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingFour">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <p style="color:#ffc107"><strong>WEARABLES SOLUTIONS</strong></p>
                </button>
            </h2>
        </div>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
            <div class="card-body">
                <ul>
                    <li>Freeing up space and reconfiguring synchronisation in the event of limited storage for data synchronisation.</li>
                    <li>Reinstalling or updating the device's software.</li>
                    <li>Failed to recognise internal or connected storage.</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingFive">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <p style="color:#ffc107"><strong>HOW LONG DOES A REPAIR TAKE?</strong></p>
                </button>
            </h2>
        </div>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
            <div class="card-body">
                Our repairs are carried out within 72 hours. The repair time depends on the type of issue and its complexity.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingSix">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    <p style="color:#ffc107"><strong>HOW MUCH WILL THE REPAIR COST?</strong></p>
                </button>
            </h2>
        </div>
        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
            <div class="card-body">
                The price of a repair depends on the time it takes to repair, the type of equipment and the brand. Request a personalised quote.
            </div>
        </div>
    </div>
</div>
