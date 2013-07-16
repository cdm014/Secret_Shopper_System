<html>
<head>
<link rel="stylesheet" type="text/css" href="http://www.rpl.org/secret_shopper/assets/css/secret_shopper.css">

</head>
<body>

<?php 
$attrib = array('class' => 'login_form');
echo form_open('manager/index',$attrib); 
?>
<h1>Rapides Parish Library Secret Shoppers Management</h1>
<p>Enter the manager password below</p>
<?php echo form_input($cookie_name);
echo form_submit('login','Login');
echo form_close();?>


</body>
</html>