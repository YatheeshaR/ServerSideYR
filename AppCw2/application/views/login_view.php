<h1>Log In</h1>
<?php echo form_open('AuthController/login'); ?>
<div>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" />
    <?php echo form_error('email'); ?>
</div>
<div>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" />
    <?php echo form_error('password'); ?>
</div>
<div>
    <input type="submit" value="Log In" />
</div>
<?php echo form_close(); ?>

<div>
    <!-- Sign Up button -->
    <a href="<?php echo site_url('AuthController/signup'); ?>">
        <button type="button">Sign Up</button>
    </a>
</div>
