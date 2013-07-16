<html>
<head>

<title>Secret Shopper - Create a new shopper</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){
	
});

function generate_ID() {
	
	var test_id = Math.floor(Math.random() * 99999) + 1;
	$.ajax({ 
		'url': "<?= $this->config->site_url();?>/shopper/check_ID/"+test_id,
	}).done(function(response){
		if (response == 1) {
			$('#ss_id').val(test_id);
			alert("Secret Shopper Code is "+test_id);
		} else {
			generate_ID();
		}
	});
	return false;

}
</script>
</head>
<body>
<?=anchor('manager/main','return to main manager view');?>
<?= form_open('manager/insert_shopper'); ?>
<?= form_hidden('action','create');?>
<?= form_hidden('valid_id',0);?>
<p>Name: <?=form_input('name');?></p>
<p>Phone: <?=form_input('phone');?></p>
<p>eMail: <?=form_input('eMail');?></p>
<p>What branches are they willing to visit?<?=br()?>
<?=form_input("branches");?></p>
<p><?=form_button("gen_id",'Generate Secret Shopper Code','onClick="return generate_ID()"');?><?=br()?>
Secret Shopper Code: <?=br()?><?=form_input('ss_id','','id="ss_id"');?></p>
<?=form_submit("submit","Submit Shopper Data");?>
<?= form_close();?>

</body>
</html>