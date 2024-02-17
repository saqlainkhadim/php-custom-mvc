<h1>Create new Account</h1>
<form action="" method="post">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>first name</label>
                <input type="text" name="first_name" value="<?php echo $model->first_name ?? ""; ?>"
                       class="form-control <?php echo $model->hasError('first_name') ? 'is-invalid' :''; ;?>" \>
                <div class="invalid-feedback">
                    <?php echo $model->getFirstError('first_name') ?>
                </div>


            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>last name</label>
                <input type="text" name="last_name" class="form-control" \>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="form-group">
        <label>password</label>
        <input type="password" name="password" class="form-control"/>
    </div>
    <div class="form-group">
        <label>confirm password</label>
        <input type="password" name="confirm_password" class="form-control"/>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
</form>