<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>

<body>
    <h1>Welcome, You are successfully logged in.PROFESORES</h1>
    <div class='container w-75'>

        <?php

        echo '<table class="  p-3 table table-bordered table-hover">';
        echo '    
        <thead>
        <tr>
        <th>id Empresa</th><th>Nom</th><th>CIF</th><th>Persona Contacte</th><th>Elimina</th> <th>Modifica</th></tr>
        </thead>';
        foreach ($taula as $empresa) {
            $url_delete = site_url('/Prof/deleteEmp/' . $empresa['idEmpresa']);
            $url_edit = site_url('/Prof/editEmp/' . $empresa['idEmpresa']);
            echo "<tr>
                <td>" . $empresa['idEmpresa'] ."</td>
                <td>" . $empresa['nom'] ."</td>
                <td>" . $empresa['CIF'] ."</td>
                <td>" . $empresa['idPersona'] ."</td>
                <td><a class='btn btn-danger btn-sm' href='" . $url_delete . "'>Elimina</a></td>
                <td><a class='btn btn-warning btn-sm' href='" . $url_edit . "'>Modifica</a></td>
                </tr>";
        }
        echo '</table >';
        echo validation_errors();
        echo $form;
        ?>

        <a class="btn btn-primary btn-sm" href='<?php echo base_url() . $func; ?>'><?php echo $funcName; ?></a>
        <a class="btn btn-primary btn-sm" href='<?php echo base_url() . "index.php/Main/logout"; ?>'>Logout</a>
    </div>
</body>

</html>