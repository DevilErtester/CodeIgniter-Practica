<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>

<body>
    <h1>Login</h1>

    <?php

    echo form_open('Main/login_action');

    echo validation_errors();

    echo "<p>Username: ";
    echo form_input('username', $this->input->post('username'));
    echo "</p>";

    echo "<p>Password: ";
    echo form_password('password');
    echo "</p>";

    echo "</p>";
    $data = array(
        'class' => 'btn btn-primary btn-sm'
    );
    echo form_submit('login_submit', 'Login', $data);
    echo "</p>";

    echo form_close();

    ?>

    <a class="btn btn-primary btn-sm" href='<?php echo base_url() . "index.php/Main/signin"; ?>'>Sign In</a>
</body>

</html>