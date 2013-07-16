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
<?= form_hidden('action','update');?>
<?= form_hidden('valid_id',1);?>
<?= form_hidden('ss_id',$shopper->id);?>
<p>Name: <?=form_input('name', $shopper->name);?></p>
<p>Phone: <?=form_input('phone',$shopper->phone);?></p>
<p>eMail: <?=form_input('eMail',$shopper->email);?></p>
<p>What branches are they willing to visit?<?=br()?>
<?=form_input("branches",$shopper->branches);?></p>

<?=form_submit("submit","Submit Shopper Data");?>
<?= form_close();?>
</body>
</html>