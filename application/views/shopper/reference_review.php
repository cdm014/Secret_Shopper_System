<html>
<head>
<link rel="stylesheet" type="text/css" href="http://www.rpl.org/secret_shopper/assets/css/secret_shopper.css">

</head>
<body>
<h1>Review Form</h1>
<p>Welcome <?= $shopper->name; ?>!</p>
<!-- 
	This form is application/views/shopper/reference_review.php
	all the variable names are question codes in the questions table and the variables contain the html to generate the 
	form fields.
	
	The code for generating the form fields is in application/models/question_model.php get_form_field().
	
	This view is called from application/controllers/shopper.php reference_review().
-->
	
<?php $hidden_fields = array('ss_id' => $shopper->id);
echo form_open('review/ref_submit',array('class'=>'ReviewForm'),$hidden_fields);
?>
<?=form_fieldset('Visit Information'); ?>
<?=$date;?>
<?=$time;?>
<?=form_fieldset_close();?>
<?=form_fieldset('Employee Information');?>
<?=$guard;?>
<?=$guard_greet;?>
<?=$ref_greet;?>
<?=$ref_emp_count; ?>
<?=$employee_activity; ?>
<?=$employee_appearance;?>
<?=$employee_appearance_examples;?>
<?=$NameBadges;?>
<?=form_fieldset_close();?>
<?=form_fieldset('Service Information');?>
<?=$spec_comp;?>
<?=$offer_help;?>
<?=$escort;?>
<?=$all_info;?>
<?=$friendly;?>

<?=form_submit('Submit','Submit Review');?>

</body>
</html>