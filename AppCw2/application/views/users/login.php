    <h2>Users Login</h2>
    <hr/>
    <div class="row">
        <div class="col-lg-4 col-md-6">
        <?php echo form_open('AuthController/index'); ?>
            <div class="form-group">
                <label for="">Email id</label>
                <?= form_input(['name'=>'email', 'value'=>set_value('email'), 'class'=>'form-control', 'placeholder'=>'Enter email id']); ?>
                <?= form_error('email', '<div class="text-danger">','</div>'); ?>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <?= form_input(['name'=>'password', 'type'=>'password', 'class'=>'form-control', 'placeholder'=>'Enter password']); ?>
                <?= form_error('password', '<div class="text-danger">','</div>'); ?>
            </div>
            <div class="form-group">
                <?= form_submit(['class'=>'btn btn-primary', 'value'=>'Login']); ?>
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
