<?php

/** @var yii\web\View $this */

$this->title = 'Hardware Cleaning and Maintenance';

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
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="d-flex justify-content-center align-items-center">
                <img src="<?= Yii::getAlias('@web') ?>/img/clean_pc" class="d-block custom-img" alt="laptopSoftwareIssue" width="800" height="400">
            </div>
        </div>
        <div class="carousel-item">
            <div class="d-flex justify-content-center align-items-center">
                <img src="<?= Yii::getAlias('@web') ?>/img/cleanPhone" class="d-block custom-img" alt="mobileSoftwareIssue" width="800" height="400">
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
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <p style="color:#ffc107"><strong>MOBILE PHONES SOLUTIONS</strong></p>
                </button>
            </h2>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <ul>
                    <li>Cleaning the screen and surfaces.</li>
                    <li> Cleaning ports and connectors.</li>
                    <li>Lubricating connectors.</li>
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
                    <li>Cleaning the screen and surfaces.</li>
                    <li> Cleaning ports and connectors.</li>
                    <li>Lubricating connectors.</li>
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
                    <li>Internal cleaning (fans, boards and components)</li>
                    <li>Lubrication of fans and components</li>
                    <li>Cleaning connections (USB, HDMI...)</li>
                    <li>Cleaning the screen and keyboard</li>
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
                    <li>Cleaning the screen and sensors.</li>
                    <lI>Wristband cleaning.</lI>
                    <li>Button lubrication.</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingFive">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <p style="color:#ffc107;"><strong>HOW LONG DOES A REPAIR TAKE?</strong></p>
                </button>
            </h2>
        </div>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
            <div class="card-body">
                We clean the hardware and carry out maintenance within a maximum of 24 hours.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingSix">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    <p style="color:#ffc107;"><strong>HOW MUCH WILL THE REPAIR COST?</strong></p>
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