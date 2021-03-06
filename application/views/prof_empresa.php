<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Profesores</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() . $func; ?>"><?php echo $funcName; ?></a>
                    </li>
                </ul>
                <a class="btn btn-primary btn-sm" href='<?php echo base_url() . "index.php/Main/logout"; ?>'>Logout</a>
            </div>
        </div>
    </nav>
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
                <td>" . $empresa['idEmpresa'] . "</td>
                <td>" . $empresa['nom'] . "</td>
                <td>" . $empresa['CIF'] . "</td>
                <td>" . $empresa['idPersona'] . "</td>
                <td><a class='btn btn-danger btn-sm' href='" . $url_delete . "'>Elimina</a></td>
                <td><a class='btn btn-warning btn-sm' href='" . $url_edit . "'>Modifica</a></td>
                </tr>";
        }
        echo '</table >';
        echo validation_errors();
        echo $form;
        ?>


    </div>
</body>

</html>
