<html>
<head>
<link rel="stylesheet" type="text/css" href="http://www.rpl.org/secret_shopper/assets/css/secret_shopper.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){
	$('.RevealShopper').click(function(){
		$('.ShopperData').show();
	});
	
	$('.HideShopper').click(function(){
		$('.ShopperData').hide();
	});
});


</script>
</head>
<body>
<h1>Secret Shopper Review of <?= $branch;?> on <?= $date;?></h1>

<p><?=$returnlink;?> <?=anchor('/manager/all_reviews','List of Reviews','id="ListReviews"');?></p>
<p></p>
<?=$table;?>
<a href="#" class="RevealShopper">Reveal Shopper Data</a>
<div class="ShopperData">
<a href="#" class="HideShopper">Hide Shopper Data</a>
<p>Name: <?= $shopper->name;?><?= br();?>
Phone: <?= $shopper->phone;?><?=br();?>
eMail: <?= auto_link($shopper->email);?></p>

</div>
</body>
</html>