<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 28-11-2016
 * Time: 14:13
 */
function geefProductGroot () {
	$titel = 'Product van de dag';
	$plaatje = '../www/images/box.png';
	$prijs = '6,50';
	$resttijd = '00:39:20';
	?>
	<div class="col-sm-6 col-sm-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4><a href="#" class="panelheader-link"><?=$titel?></a></h4>
			</div>
			<div class="panel-body text-center">
				<img src="<?=$plaatje?>" class="img-thumbnail img-responsive img-thumbnail-primary" alt="img"><br/>
			</div>
			<div class="panel-footer">
				<table class="table table-responsive">
					<tr>
						<th class="text-center">&euro;<?=$prijs?></th>
						<th class="text-danger text-center"><?=$resttijd?></th>
						<th class="text-center"><a href="#" class="btn btn-xs btn-danger">Bied</a></th>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>
