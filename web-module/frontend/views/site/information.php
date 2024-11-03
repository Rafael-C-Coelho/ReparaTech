<div class="mt-3 mb-5">
    <h1 class="text-center">Personal Information</h1>
</div>

<form>

    <div class="mb-3">
        <label for="username" class="form-label"><strong>Username</strong></label>
        <input type="text" class="form-control" id="username" placeholder="Enter your username">
    </div>

    <div class="mb-3">
        <label for="address" class="form-label"><strong>Address</strong></label>
        <input type="text" class="form-control" id="address" placeholder="Enter your address">
    </div>

    <div class="mb-3">
        <label for="contact" class="form-label"><strong>Contact</strong></label>
        <input type="number" class="form-control" id="contact" placeholder="+351">
    </div>

    <div class="mb-3">
        <label for="emailAddress" class="form-label"><strong>Email Address</strong></label>
        <input type="email" class="form-control" id="emailAddress" aria-describedby="emailHelp" placeholder="you@example.com">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label"><strong>Password</strong></label>
        <input type="password" class="form-control" id="password" placeholder="Enter your password">
    </div>

    <div class="mb-3">
        <label for="newPassword" class="form-label"><strong>New Password</strong></label>
        <input type="password" class="form-control" id="newPassword" placeholder="Enter your new password">
    </div>

    <button type="submit" class="btn btn-primary"><strong>Submit</strong></button>
    <a href="<?= \yii\helpers\Url::to(['site/painelClient']) ?>" type="button" style="background-color: #FFD333;"  class="btn btn-primary">
        <strong>Back</strong>
    </a>
</form>