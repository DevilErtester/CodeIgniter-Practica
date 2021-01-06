<!DOCTYPE html>  
    <html>  
    <head>  
        <title></title>  
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    </head>  
    <body>  
        <h1>Welcome, You are successfully logged in. ALUMNES</h1>  
      
        <?php  
        echo "<pre>";  
        echo print_r($this->session->all_userdata());  
        echo "</pre>";  
        ?>  
      
        <a href='<?php echo base_url()."index.php/Main/logout"; ?>'>Logout</a>  
      
    </body>  
    </html>  