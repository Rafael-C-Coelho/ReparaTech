<div class="mt-3 mb-5">
    <h1 class="text-center"> Client Panel</h1>
</div>

<div>
    <div class="">
        <div class="btn-group btn-group-lg m-3 col-12" role="group" aria-label="Large button group">
            <a href="<?= \yii\helpers\Url::to(['site/information']) ?>" class="btn btn-outline-primary text-dark custom-border p-4 mx-3 col-4"><strong>Personal Information</strong></a>
            <a href="<?= \yii\helpers\Url::to(['site/repair']) ?>" class="btn btn-outline-primary text-dark custom-border p-4 mx-3 col-4"><strong>Repairs</strong></a>
            <a href="<?= \yii\helpers\Url::to(['site/order']) ?>" class="btn btn-outline-primary text-dark custom-border p-4 mx-3 col-4"><strong>Orders</strong></a>
        </div>
        <br>
        <br>
    </div>
</div>