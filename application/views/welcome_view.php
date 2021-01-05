<!DOCTYPE html>  
<html>  
<head>  
    <title></title>  
</head>  
<body>  
    Welcome <?php echo $this->session->userdata('user'); ?>   
<br>  
    <?php echo anchor('Login/logout', 'Logout'); ?>  
  
  
</body>  
</html> 