<?php
/**
 * Created by IntelliJ IDEA.
 * User: jipbr
 * Date: 16-12-2016
 * Time: 10:26
 */

require("scripts/header.php");
?>

<!--inloggen-->
			<div class="row">

				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading"><a href="#" class="panelheader-link">Verifiëren registreren</a></div>
						<form action="procesEmailverify.php">
							<div class="panel-body">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-9 col-sm-offset-2">
											<input type="email"  name="email" placeholder="Vul hier je e-mail in" class="form-control">
										</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-sm-6">
										<button type="submit" class="btn btn-default">Verifiëren</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>


