<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
    <?php
    echo isset($_SESSION['auth_message']) ? $_SESSION['auth_message'] : FALSE;
    ?>
    <h1>Register</h1>
    <?php
    echo form_open();
    echo form_label('First name:','first_name').'<br />';
    echo form_error('first_name');
    echo form_input('first_name',set_value('first_name')).'<br />';
    echo form_label('Last name:','last_name').'<br />';
    echo form_error('last_name');
    echo form_input('last_name',set_value('last_name')).'<br />';
    echo form_label('Username:','username').'<br />';
    echo form_error('username');
    echo form_input('username',set_value('username')).'<br />';
    echo form_label('Email:','email').'<br />';
    echo form_error('email');
    echo form_input('email',set_value('email')).'<br />';
    echo form_label('Password:', 'password').'<br />';
    echo form_error('password');
    echo form_password('password').'<br />';
    echo form_label('Confirm password:', 'confirm_password').'<br />';
    echo form_error('confirm_password');
    echo form_password('confirm_password').'<br /><br />';
    echo form_submit('register','Register');
    echo form_close();
    ?>
</div>
