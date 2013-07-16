<html>
<head>
<link rel="stylesheet" type="text/css" href="http://www.rpl.org/secret_shopper/assets/css/secret_shopper.css">

</head>
<body>
<h1>Review Form</h1>
<p>Welcome <?= $shopper->name; ?>!</p>

<?php 
$hidden_fields = array ('ss_id' => $shopper->id);
echo form_open('review/submit',array('class' => 'ReviewForm'),$hidden_fields); 
$branches = array(
	'bc' => 'Boyce',
	'gn' => 'Gunter',
	'hn' => 'Hineston',
	'jn' => 'Johnson',
	'kg' => 'King',
	'mn' => 'Main',
	'jw' => 'McDonald',
	'mr' => 'Martin',
	'rb' => 'Robertson',
	'wr' => 'Westside Regional'
	
);?>
<?=form_fieldset('Visit Information');?>
<p>Which branch did you visit?
<?= form_dropdown('branch',$branches,'');	?>

</p>
<p>
What was the date of your visit? (YYYY-MM-DD)
<?= form_input('date');?></p>
<p>
What time did you visit the branch?
<?=form_input('time');?></p>
<?=form_fieldset_close();?>
<?=form_fieldset('Employee Information');?>
<p>How many employees were at the counter when you entered?
<?=form_input('employee_count');?></p>
<p>Were you greeted as you entered?<br />
<?
$no_btn = array(
	'name' => 'greeted',
	'id' => 'NotGreeted',
	'value' => 0,
	'checked' => false
);
$yes_btn = array(
	'name' => 'greeted',
	'id' => 'Greeted',
	'value' => 1,
	'checked' => false
);
?>
<?=form_radio($no_btn);?><?=form_label("No","NotGreeted");?><?=form_radio($yes_btn);?><?=form_label("Yes","Greeted");?></p>
<p>By how many employees? <?=form_input('greet_count');?></p>
<p>What were the employees doing? <br/><?=form_textarea('employee_activity');?></p>
<p>How were they dressed? 
<? $emp_dressed = array(
	'p' => 'Professional',
	'bc' => 'Business Casual',
	'c' => 'Casual',
	'ec' => 'Extremely Casual'
);?>
<?=form_dropdown('employee_appearance',$emp_dressed);?><br />
Give examples if needed <br />
<?=form_textarea('employee_appearance_examples');?></p>

<p>Were the employees wearing name badges?<br />
<?=form_radio(array('name'=>'NameBadges','id'=>'NoBadge','value'=>0));?><?=form_label("No","NoBadge");?>
<?=form_radio(array('name'=>'NameBadges','id'=>'Badge','value'=>1));?><?=form_label("Yes",'Badge');?></p>

<p>Were you thanked or spoken to as you left the library?<br />
<?=form_radio(array('name'=>'thanked','id'=>'NotThanked','value'=>0));?><?=form_label("No","NotThanked");?>
<?=form_radio(array('name'=>'thanked','id'=>'Thanked','value'=>1));?><?=form_label("Yes",'Thanked');?></p>

<p>Were you made to feel welcome at the library?<br />
<?=form_radio(array('name'=>'welcome','id'=>'NotWelcome','value'=>0));?><?=form_label("No","NotWelcome");?>
<?=form_radio(array('name'=>'welcome','id'=>'Welcome','value'=>1));?><?=form_label("Yes",'Welcome');?></p>

<?=form_fieldset_close();?>
<?=form_fieldset("Service Information");?>
<p>Were you offered assistance while you were browsing?<br />
<?=form_radio(array('name'=>'assistance','id'=>'NoAssistance','value'=>0));?><?=form_label("No","NoAssistance");?>
<?=form_radio(array('name'=>'assistance','id'=>'Assistance','value'=>1));?><?=form_label("Yes","Assistance");?>
</p>
<p>When you asked for a particular book or subject area, did the employee take you to the book you asked for?<br/>
<?=form_radio(array('name'=>'escort','id'=>'NoEscort','value'=>0));?><?=form_label("No","NoEscort");?>
<?=form_radio(array('name'=>'escort','id'=>'Escort','value'=>1));?><?=form_label("Yes","Escort");?></p>
<p>Did you need a library card?<br />
<?=form_radio(array('name'=>'card','id'=>'NoCard','value'=>'No'));?><?=form_label("No","NoCard");?>
<?=form_radio(array('name'=>'card','id'=>'Card','value'=>'Yes'));?><?=form_label("Yes","Card");?></p>
<p>If yes, comment on the experience of obtaining a library card:<br />
<?=form_textarea('LibraryCardExperience');?></p>

<p>If the location had a self-check machine (Boyce, Johnson, Gunter, Hineston, Robertson, Westside), did the employee mention the self checkout to you?<br />
<?=form_radio(array('name'=>'selfcheck','id'=>'NotMentioned','value'=>0));?><?=form_label("No","NotMentioned");?>
<?=form_radio(array('name'=>'selfcheck','id'=>'Mentioned','value'=>1));?><?=form_label("Yes",'Mentioned');?></p>
<?=form_fieldset_close();?>
<?=form_submit("Submit","Submit Review");?>
</body>
</html>