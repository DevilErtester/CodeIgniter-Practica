<!DOCTYPE html>  
    <html>  
    <head>  
        <title>Dashboard Admin</title>  
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    </head>  
    <body>  
        <h1>Welcome, You are successfully logged in. ADMIN</h1>  
      
        <?php  
        echo $tutors;
        $formTut = form_open('Admin/printTutores');  
        $formTut .= validation_errors();  
    
        $formTut .= form_label('Email', 'mail');
        $formTut .= form_input(['name' => 'mail']);

        $formTut .= form_label('Nom', 'name');
        $formTut .= form_input(['name' => 'nom']);

        $formTut .= form_label('Cicle impartit', 'cic_impar');
        $formTut .= form_input(['name' => 'cic_impar']);
        
        $formTut .= form_submit('btnSubmit', 'Create new tutor');
        
        $formTut .= form_close();
        echo $formTut;
        ?>  
        
        <a href='<?php echo base_url()."index.php/Admin/printAlumnes"; ?>'>PrintAlumnes</a>
        <a href='<?php echo base_url()."index.php/Admin/logout"; ?>'>Logout</a>  
      
    </body>  
    </html>  