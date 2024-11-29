<?php

/** @var yii\web\View $this */

$this->title ="Damage Button";
?>

<div class="mt-3 mb-4">
    <h1 class="text-center"><?= $this->title ?></h1>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="<?= Yii::getAlias('@web') ?>/img/laptopSoftwareIssue" class="d-block custom-img" alt="laptopSoftwareIssue" width="800" height="400">
                </div>
            </div>
            <div class="carousel-item">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="<?= Yii::getAlias('@web') ?>/img/mobileSoftwareIssue" class="d-block custom-img" alt="mobileSoftwareIssue" width="800" height="400">
                </div>
            </div>
            <div class="carousel-item">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="<?= Yii::getAlias('@web') ?>/img/softwareVirus" class="d-block custom-img" alt="softwareVirus" width="800" height="400">
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
                        <p style="color:grey"><strong>MOBILE PHONES SOLUTIONS</strong></p>
                    </button>
                </h2>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <ul>
                        <li>Software updates (Android and iOS).</li>
                        <li>System restore and factory reset.</li>
                        <li>Fixing problems with applications.</li>
                        <li>Virus and malware removal.</li>
                        <li>Unlocking devices (PIN, pattern, account).</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <p style="color:grey"><strong>TABLETS SOLUTIONS</strong></p>
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <ul>
                        <li>Software updates (Android and iOS).</li>
                        <li>System restore and factory reset.</li>
                        <li>Fixing problems with applications.</li>
                        <li>Virus and malware removal.</li>
                        <li>Unlocking devices (PIN, pattern, account).</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <p style="color:grey"><strong>DESKTOPS AND LAPTOPS SOLUTIONS</strong></p>
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <ul>
                        <li>Operating system errors (Windows, macOS, Linux).</li>
                        <li>Blue screen (BSOD) or boot errors.</li>
                        <li>Updating or installing operating systems.</li>
                        <li>Virus and malware removal.</li>
                        <li>Software installation and configuration.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingFour">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <p style="color:grey"><strong>WEARABLES SOLUTIONS</strong></p>
                    </button>
                </h2>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="card-body">
                    <ul>
                        <li>Software updates that fail or crash.</li>
                        <li>Bug fixes for wearable operating systems.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="headingFive">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        <p style="color:grey;"><strong>HOW LONG DOES A REPAIR TAKE?</strong></p>
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
                        <p style="color:grey;"><strong>HOW MUCH WILL THE REPAIR COST?</strong></p>
                    </button>
                </h2>
            </div>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                <div class="card-body">
                    The price of a repair depends on the type of equipment and brand. Request a personalised quote.
                </div>
            </div>
        </div>
    </div>