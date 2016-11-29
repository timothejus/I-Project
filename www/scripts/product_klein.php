<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sjoerd
 * Date: 28-11-2016
 * Time: 13:37
 */

function geefProductKlein ($titel, $plaatje, $prijs, $resttijd) {
	?>
	<div class="col-sm-3">
		<div class="panel panel-default">
			<div class="panel-heading"><a href="#" class="panelheader-link"><?=$titel ?></a></div>
			<div class="panel-body text-center">
				<img src="<?=$plaatje ?>" class="img-thumbnail img-responsive img-thumbnail-overview" alt="img"><br/>
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
