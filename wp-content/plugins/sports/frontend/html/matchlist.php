<style>
	.serviceBox {
		text-align: center;
		margin-top: 60px;
		position: relative;
		z-index: 1;
		margin-bottom: 21px;
	}

	.serviceBox .service-icon {
		width: 50px;
		height: 50px;
		border-radius: 3px;
		background: #58c333;
		margin: 0 auto;
		position: absolute;
		top: -24px;
		left: 0;
		right: 0;
		z-index: 1;
		transition: all 0.3s ease-out 0s;

	}

	.serviceBox:hover .service-icon {
		transform: rotate(45deg);
	}

	.serviceBox .service-icon span {
		display: inline-block;
		width: 38px;
		height: 38px;
		line-height: 30px;
		border-radius: 3px;
		background: #24890d;
		font-size: 22px;
		color: #fff;
		margin: auto;
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		transition: all 0.3s ease-out 0s;
		border: 3px solid #ffcc00;
	}

	.serviceBox .service-icon span i {
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox:hover .service-icon span i {
		transform: rotate(-45deg);
	}

	.serviceBox .service-content {
		background: #24890d;
		border: 1px solid #fff;
		border-radius: 25px;
		padding: 45px 15px;
		padding-top: 30px;
		position: relative;
		margin: 5px auto;
		height: auto;
	}

	.serviceBox .service-content:before {
		content: "";
		display: block;
		width: 50px;
		height: 50px;
		border: 1px solid #e7e7e7;
		border-radius: 3px;
		margin: 0 auto;
		position: absolute;
		top: -27px;
		left: 0;
		right: 0;
		z-index: -1;
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox:hover .service-content:before {
		transform: rotate(45deg);
	}

	.serviceBox .title {
		font-size: 16px;
		font-weight: 500;
		color: #fff;
		height: auto;
		text-transform: uppercase;
		margin: 0 0 25px 0;
		position: relative;
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox:hover .title {
		color: #fff;
	}

	.serviceBox .text {
		font-size: 15px;
		font-weight: 500;
		color: #fff;
		text-transform: uppercase;
		margin: 0 0 25px 0;
		position: relative;
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox:hover .text {
		color: #fff;
	}

	.serviceBox .text2 {
		font-size: 15px;
		font-weight: 500;
		color: #ffcc00;
		text-transform: uppercase;
		margin: 0 0 25px 0;
		position: relative;
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox:hover .text2 {
		color: #ffcc00;
	}

	.serviceBox .read-more {
		display: block;
		width: 115px;
		height: auto;
		line-height: 20px;
		border-radius: 7%;
		background: #24890d;
		border: 1px solid #fff;
		font-size: 15px;
		color: #fff;
		margin: 0 auto;
		position: absolute;
		padding: 5px;
		top: auto;
		left: 0;
		right: 0;
		margin-top: -20px;
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox .read-more:hover {
		border: 3px solid #ffcc00;
		background: #004700;
		color: #ffcc00;
		text-decoration: none;
	}

	.serviceBox:hover .read-more {
		border: 2px solid #ffcc00;

		color: #ffcc00;
	}

	.pointer {
		cursor: pointer;
	}

	.score112 {
		float: right;
		border-radius: 8px;
		width: 44%;
		height: 36px;
		margin-top: -4%;
		padding: 0px 0px;
		position: relative;
	}

	.score113 {
		float: right;
		width: 50%;
		height: auto;
		margin-top: -5%;
		margin-right: -15px;
		padding: 0px 0px;
		position: relative;
		border-radius: 15px;
	}

	.text23 {
		color: #fff;
		font-size: 22px;
		font-family: oswald;
	}

	.text114 {
		color: #ffcc00;
		font-size: 18px;
		font-family: oswald;
		text-transform: uppercase;
		letter-spacing: 1px;
	}

	.text113 {
		color: #fff;
		font-size: 14px;
		font-family: Arial, Helvetica, sans-serif;
		text-transform: uppercase;
	}


	.block {
		box-sizing: border-box;
		border: 2px solid #ffcc00;
		padding: 10px 0px 10px 0px;
		font-size: 15px;
		border-radius: 4px;
		margin: -3px;
		width: 240px;
		height: auto;
		font-weight: bold;
		overflow: hidden;
		color: #ffcc00 !important;
		background-color: #24890d;
	}

	.block2 {
		box-sizing: border-box;
		padding: 0px;
		width: 290px;
		border: 0px solid;
		overflow: hidden;
		color: #656D78;
		background-color: #fff;
		border: 2px solid #ffcc00;
		border-radius: 5px;
		margin: 15px;
		background-color: #24890d;
	}

	.bg-hover-grass:hover {
		background-color: #195d10;
		color: #fff !important;
	}


	.loaderball {
		position: fixed;
		opacity: 1;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('../wp-content/plugins/sports/images/6.gif')50% 50% no-repeat rgb(255 255 255 / 65%);
	}

	@media only screen and (max-width: 1200px) {

		.row {
			margin-right: 15px !important;
			margin-left: 15px !important;
		}

		.score112 {
			width: 40% !important;
			height: 25px;
		}

		.text24 {
			float: left !important;
		}

		.text23 {
			font-size: 15px !important;
		}

		.score113 {
			width: 100% !important;
			margin-right: 0px !important;
			height: auto;
		}

		.text113 {
			font-size: 12px !important;
		}

		.text114 {
			font-size: 15px !important;
		}

		.serviceBox .service-content {
			padding-top: 30px !important;
			padding: 40px 10px;
		}

		.matchlistdata span .title {
			font-size: 15px !important;
		}

		.buttonselect {
			margin-top: -44px !important;
			margin-left: 90px !important;
		}


		.buttonselect2 {
			margin-top: -36px !important;
			margin-left: 88px !important;
		}

	}

	@media only screen and (max-width: 990px) {

		.team2scl {
			margin-top: 50px !important;
		}

		.serviceBox .read-more {
			width: 80% !important;
			font-size: 12px;
			border-radius: 5% !important;
		}

		.serviceBox .title {
			font-size: 15px;
			height: auto;
		}

		.matchlistdata span .title123 {
			font-size: 13px !important;
		}

		.matchlistdata span .title12 {
			font-size: 6px !important;
		}

		.buttonselect {
			margin-top: -35px !important;
		}

		.selecteammodal {
			width: 770px !important;
		}

	}

	@media only screen and (max-width: 775px) {

		.score112 {
			width: 50% !important;
			height: 25px;
		}

		.score113 {
			background-color: #fff !important;
			margin-right: 0px !important;
		}

		.infotab {
			width: 30% !important;
			height: auto;
		}

		.matchlistdata span .title123 {
			font-size: 11px !important;
		}

		.matchlistdata span .title12 {
			font-size: 6px !important;
		}

		.selecteammodal {
			width: 550px !important;
		}

	}

	@media only screen and (max-width: 485px) {
		.infotab2 {
			/* top: 22px; */
		}

		.score113 {
			margin-top: -45px;
			margin-right: 0px !important;

		}
	}


	@media only screen and (max-width: 600px) {

		.serviceBox .service-content {
			padding-top: 40px !important;
		}

		.selecteammodal {
			width: auto;
		}

		.maindiv123 {
			margin-top: -49px !important;
		}

		.row {
			margin-right: 15px !important;
			margin-left: 15px !important;
		}

		.score112 {
			width: 100% !important;
			height: auto;
			margin-top: 15px;
		}

		.score113 {
			margin-top: -50px;
			margin-right: 0px !important;
		}

		.infotab {
			width: 90% !important;
			height: auto;
			border-radius: 15px 15px 15px 15px !important;
			margin: 5px;

		}

		.buttonselect {
			margin-top: -72px !important;
		}

		.buttonselect2 {
			margin-top: -72px !important;
			margin-left: 88px !important;
		}

		.text24 {
			float: left !important;
			height: auto;
		}

		.text23 {
			font-size: 15px !important;
			/* margin-left: -5px; */
		}

		.text113 {
			font-size: 12px !important;
		}

		.text114 {
			font-size: 15px !important;
		}

		.team2scl {
			margin-top: 50px !important;
		}

		.serviceBox .read-more {
			width: 80% !important;
			font-size: 12px;
			border-radius: 5% !important;
		}

		.matchlistdata span .title123 {
			font-size: 11px !important;
		}

		.matchlistdata span .title12 {
			font-size: 6px !important;
		}


		.serviceBox .title {
			font-size: 15px;
			height: auto;
		}

		.serviceBox {
			padding-top: 0px !important;
			padding: 0px 10px;
			top: 100px;
		}

		.selecteammodal {
			width: auto !important;
		}


	}

	@media only screen and (max-width: 370px) {

		.block2 {
			width: auto !important;
		}

	}

	@media only screen and (max-width: 335px) {
		.text23 {
			font-size: 13px !important;
		}
	}
</style>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <button type="button" class="btn btn-warning" onclick="send_mail_users_for_enddate()" >Send Mail</button> -->
</br>

<div id="loaderball" class="loaderball" style="display: none;"></div>

<div class="row d-grid gap-3">
	<div id="matchlistdata" class="matchlistdata">
	</div></br></br>
</div>



<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="false" id="selecteammodal" aria-labelledby="selecteammodallabel" aria-hidden="true">
	<div class="modal-dialog selecteammodal" role="document" style="width: 1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="font-size: 25px;" id="selecteammodallabel">Select Winning Team In Each Game</h5>
				<button type="button" class="btn" style="background-color: #fff; float: right; margin-top: -28px;" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2"><i class="fa fa-times" style="font-size:25px; color:#e0b404"></i></button>
			</div>
			<div class="modal-body">
				<div id="selectTeamListMainDiv">
					<div id="selectteamlistdata">
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn" style="background-color: #e0b404;" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2">Close</button>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
	var $ = jQuery;
	var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
	$(document).ready(function() {
		match_list(<?php echo $_GET['id'] ?>);
	})
</script>