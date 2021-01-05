<!DOCTYPE html>  
    <html>  
    <head>  
        <title>Sign Up Page</title>  
    </head>  
    <body>  
        <h1>Sign In</h1>  
      
        <?php  
      
        echo form_open('Main/signin_validation');  
      
        echo validation_errors();  
      
        echo "<p>Username:";  
        echo form_input('email');  
        echo "</p>";  
      
        echo "<p>Password:";  
        echo form_password('password');  
        echo "</p>";  
      
        echo "<p>Confirm Password:";  
        echo form_password('cpassword');  
        echo "</p>";  
      
        echo "<p>";  
        echo form_submit('signin_submit', 'Sign In');  
        echo "</p>";  
      
        echo form_close();  
      
        ?>  
      
    </body>  
    </html>  