<h1>Create new Account</h1>
<?php $form = \app\core\form\Form::begin(['method' => 'post']) ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->field($model, 'first_name'); ?></div>
    <div class="col-sm-6">
        <?php echo $form->field($model, 'last_name'); ?>
    </div>
</div>

<?php echo $form->field($model, 'email')->emailField(); ?>
<?php echo $form->field($model, 'password')->passwordField(); ?>
<?php echo $form->field($model, 'confirm_password')->passwordField(); ?>
<button type="submit" class="btn btn-primary">Register</button>

<?php \app\core\form\Form::end() ?>
