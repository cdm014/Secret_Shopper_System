<html>
<head>
<link rel="stylesheet" type="text/css" href="http://www.rpl.org/secret_shopper/assets/css/secret_shopper.css">
<title>Form Select</title>
</head>
<body>
<h1>Form Select</h1>
<p><span style="font-weight:bold">Instructions:</span> please select the appropriate form for your review. </p>
<ul>
<?php foreach($quizzes as $quiz):?>
<li><?php echo $quiz;?></li>
<?php endforeach;?>
<ul>

<!-- This view is in shopper/select_form.php -->
</body>
</html>
