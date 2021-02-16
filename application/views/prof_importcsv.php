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
                        <a class="nav-link" href="<?php echo base_url() . "index.php/Prof/printAlumnes" ?>">Alumnes</a>
                    </li>
                </ul>
                <a class="btn btn-primary btn-sm" href='<?php echo base_url() . "index.php/Main/logout"; ?>'>Logout</a>
            </div>
        </div>
    </nav>

    <div class='container'>

        <?php
        echo '<table class="  p-3 table table-bordered table-hover">';
        echo '    
        <thead>
        <tr>
        <th>id Alumne</th><th>Nom</th><th>Mail</th><th>Telefon</th><th>Curs FCT</th><th>Any Curs</th></tr>
        </thead>';
        foreach ($taula as $alumne) {
            echo "<tr>
                    <td>" . $alumne['idAlumne'] . "</td>
                    <td>" . $alumne['nom'] . "</td>
                    <td>" . $alumne['mail'] . "</td>
                    <td>" . $alumne['telefon'] . "</td>
                    <td>" . $alumne['curs'] . "</td>
                    <td>" . $alumne['anyCurs'] . "</td>
                    </tr>";
        }
        echo '</table >';
        ?>
        <form action="<?php echo site_url(); ?>/Prof/importCsv" method="post" enctype="multipart/form-data" name="form1"
            id="form1">
            <table>
                <tr>
                    <td> Choose your file: </td>
                    <td>
                        <input type="file" class="form-control" name="userfile" id="userfile" align="center" />
                    </td>
                    <td>
                        <div class="col-lg-offset-3 col-lg-9">
                            <button type="submit" name="submit" class="btn btn-info">Save</button>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>
