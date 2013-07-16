<html>
<head>
<link rel="stylesheet" type="text/css" href="http://www.rpl.org/secret_shopper/assets/css/secret_shopper.css">

</head>
<body>

<?php 
$attrib = array('class' => 'login_form');
echo form_open('shopper/login',$attrib); 
?>
<h1>Rapides Parish Library Secret Shoppers!</h1>
<p>Enter your Secret Shopper ID code below</p>
<?php echo form_input('sscode','Secret Shopper Code');
echo form_submit('login','Login');
echo form_close();?>


</body>
</html>