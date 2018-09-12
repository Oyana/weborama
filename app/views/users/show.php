<?php
view('includes/header');
?>

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center login-title">Hello <?= $user->name ?>, this is your profile</h1>
            <div class="text-center">
                You are using the <?= $theme ?> theme.
            </div>
        </div>
    </div>

<?php
view('includes/footer');
