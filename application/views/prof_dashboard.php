<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>

<body>
    <h1>Welcome, You are successfully logged in.PROFESORES</h1>

    <?php
    echo "<div class='container'>";
    echo $alumnes;
    $formAlu = form_open('Prof/printAlumnes');
    $formAlu .= validation_errors();

    $formAlu .= form_label('Email', 'mail');
    $formAlu .= form_input(['name' => 'mail']);

    $formAlu .= form_label('Nom', 'name');
    $formAlu .= form_input(['name' => 'nom']);

    $formAlu .= form_label('Telefon', 'telf');
    $formAlu .= form_input(['name' => 'telf']);

    $formAlu .= form_label('Curs FCT', 'cic_impar');
    $formAlu .= form_input(['name' => 'fct']);

    $formAlu .= form_submit('btnSubmit', 'Crear alumne');

    $formAlu .= form_close();

    echo $formAlu;
    ?>
    </div>

    <a href='<?php echo base_url() . "index.php/Main/logout"; ?>'>Logout</a>

</body>

</html>