<h1>Sign Up</h1>
<?php echo form_open('AuthController/signup'); ?>
<div>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" />
    <?php echo form_error('username'); ?>
</div>
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
    <input type="submit" value="Sign Up" />
</div>
<?php echo form_close(); ?>