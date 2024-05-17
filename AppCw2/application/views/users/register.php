    <h2>Users Signup</h2>
    <hr/>
    <div class="row">
        <div class="col-lg-4 col-md-6">
        <?php echo form_open('AuthController/register'); ?>
            <div class="form-group">
                <label for="">First Name</label>
                <?= form_input(['name'=>'fname', 'value'=>set_value('fname'), 'class'=>'form-control', 'placeholder'=>'Enter first name']); ?>
                <?= form_error('fname', '<div class="text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label for="">Last Name</label>
                <?= form_input(['name'=>'lname', 'value'=>set_value('lname'), 'class'=>'form-control', 'placeholder'=>'Enter last name']); ?>
                <?= form_error('lname', '<div class="text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label for="">Email id</label>
                <?= form_input(['name'=>'email', 'value'=>set_value('email'), 'class'=>'form-control', 'placeholder'=>'Enter email id']); ?>
                <?= form_error('email', '<div class="text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <?= form_input(['name'=>'password', 'type'=>'password', 'class'=>'form-control', 'placeholder'=>'Enter password']); ?>
                <?= form_error('password', '<div class="text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label for="">Re-password</label>
                <?= form_input(['name'=>'rpassword', 'type'=>'password', 'class'=>'form-control', 'placeholder'=>'Re-enter password']); ?>
                <?= form_error('rpassword', '<div class="text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <?= form_submit(['class'=>'btn btn-primary', 'value'=>'Submit']); ?>
                <?= form_reset(['class'=>'btn btn-danger', 'value'=>'Clear']); ?>
            </div>
        <?php echo form_close(); ?>
        <?php if($error = $this->session->flashdata('msg')):
            $class = $this->session->flashdata('msg_class') ?>
            <div class="alert <?= $class ?>">
                <?php echo $error; ?>
            </div>
        <?php endif ?>
        </div>
    </div>
