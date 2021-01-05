<!DOCTYPE html>  
    <html>  
    <head>  
        <title></title>  
    </head>  
    <body>  
        <h1>Welcome, You are successfully logged in.PROFESORES</h1>  
      
        <?php  
        echo "<pre>";  
        echo print_r($this->session->all_userdata());  
        echo "</pre>";  
        ?>  
      
        <a href='<?php echo base_url()."index.php/Main/logout"; ?>'>Logout</a>  
      
    </body>  
    </html>  