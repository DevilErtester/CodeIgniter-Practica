<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

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
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() . "index.php/Prof/importCsv" ?>">Inserir grup
                            alumnes</a>
                    </li>
                </ul>
                <a class="btn btn-primary btn-sm" href='<?php echo base_url() . "index.php/Main/logout"; ?>'>Logout</a>
            </div>
        </div>
    </nav>

    <div class='container'>

        <form class="w-50 row g-3 form-inline" action="<?php echo base_url() . 'index.php/Prof/printAlumnes'; ?>"
            method="post">
            <div class="col">
                <select class="form-control" name="field">
                    <option selected="selected" disabled="disabled" value="">Filter By</option>
                    <option value="idAlumne">id Alumne</option>
                    <option value="nom">Nom</option>
                    <option value="mail">Email</option>
                    <option value="curs_FCT">Curs FCT</option>
                    <option value="telefon">Telefon</option>
                </select>
            </div>
            <input class="col form-control" type="text" name="search" value="" placeholder="Search...">
            <input class="col-auto btn btn-primary" type="submit" name="filter" value="Go">
        </form>

        <?php
        echo '<table class="  p-3 table table-bordered table-hover">';
        echo '    
                <thead>
                <tr>
                <th>id Alumne</th><th>Nom</th><th>Mail</th><th>Telefon</th><th>Curs FCT</th><th>Emparellament FCT</th><th>Elimina</th> <th>Modifica</th></tr>
                </thead>';
        foreach ($taula as $alumne) {
            $FCT = null;
            $url_delete = site_url('/Prof/delAlu/' . $alumne['idAlumne']);
            $url_edit = site_url('/Prof/editAlu/' . $alumne['idAlumne']);

            if (empty($alumne['id'])) {

                $FCT = form_open('Prof/printAlumnes');
                $FCT .= '<select class="form-control" name="curs">';
                $FCT .= '<option selected="selected" disabled="disabled" value="">Curs</option>';

                foreach ($empresas as $fcts) {
                    $FCT .= '<option value="' . $alumne['idAlumne'] . "/" . $fcts['idEmpresa'] . '">' . $fcts['nom'] . '</option>';
                }
                $FCT .= '</select>';

                $FCT .= form_submit('newCurs', 'Afegir curs');
                $FCT .= form_close();
            } else
                $FCT = $alumne['id'];
			echo "
				<tr>
					<td>" . $alumne['idAlumne'] . "</td>
					<td>" . $alumne['nom'] . "</td>
					<td>" . $alumne['mail'] . "</td>
					<td>" . $alumne['telefon']  . "</td>
					<td>" . $alumne['curs'] . "</td>
					<td>" . $FCT . "</td>
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
