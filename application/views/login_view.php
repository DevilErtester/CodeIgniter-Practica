<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</head>

<body>

    <div class="d-flex justify-content-center">
        <?php
        echo "<div>";
        echo "<h1 class='d-flex justify-content-center'>Login</h1>";
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
        echo '<div class="d-flex justify-content-center">';
        echo form_submit('login_submit', 'Login', $data);
        echo "</p>";

        echo form_close();

        ?>

        <a class="btn btn-primary btn-sm" href='<?php echo base_url() . "index.php/Main/signin"; ?>'>Sign In</a>
    </div>
    </div>
    </div>
</body>

</html>
