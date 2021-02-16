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

                <a class="btn btn-primary btn-sm" href='<?php echo base_url() . "index.php/Main/logout"; ?>'>Logout</a>
            </div>
        </div>
    </nav>

    <div class='container'>


        <?php
			echo '<table class=" mx-auto p-3 table table-bordered table-hover" style="width: 1000px;">';
				echo "
					<tr>
						<td>" . $alumne[0]['idAlumne'] . "</td>
						<td>" . $alumne[0]['nom'] . "</td>
						<td>" . $alumne[0]['mail'] . "</td>
						<td>" . $alumne[0]['telefon']  . "</td>
						<td>" . $alumne[0]['curs'] . "</td>
						<td>" . $alumne[0]['anyCurs'] . "</td>
						
						
					</tr>";
			
			echo '</table >';
			
        ?>
		<form action="<?php echo base_url() . "index.php/Prof/editAlu/". $alumne[0]['idAlumne']; ?>" method="post" accept-charset="utf-8">
			<label for="mail">Email</label><input type="text" name="mail" value="<?php echo $alumne[0]['mail'];?>">
			<label for="name">Nom</label><input type="text" name="nom" value="<?php echo $alumne[0]['nom'];?>">
			<label for="telf">Telefon</label><input type="text" name="telf" value="<?php echo $alumne[0]['telefon'];?>">
			<br><label for="cic_impar">Curs</label><input type="text" name="cic_impar" value="<?php echo $alumne[0]['curs'];?>">
			<label for="anyCurs">Any Curs</label><input type="text" name="anyCurs" value="<?php echo $alumne[0]['anyCurs'];?>">
			<input type="submit" name="modAlu" value="Modificar alumne">
		</form>
    </div>
</body>

</html>
