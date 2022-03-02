<style>
	.serviceBox {
		text-align: center;
		margin-top: 60px;
		position: relative;
		z-index: 1;
		margin-bottom: 21px;
	}

	.serviceBox .service-icon {
		width: 78px;
		height: 78px;
		border-radius: 3px;
		background: #58c333;
		margin: 0 auto;
		position: absolute;
		top: -34px;
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
		width: 60px;
		height: 60px;
		line-height: 60px;
		border-radius: 3px;
		background: #24890d;
		font-size: 30px;
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
		padding: 60px 15px;
		padding-top: 55px;
		position: relative;
		margin: 5px auto;
		height: auto;
	}

	.serviceBox .service-content:before {
		content: "";
		display: block;
		width: 80px;
		height: 80px;
		border: 1px solid #e7e7e7;
		border-radius: 3px;
		margin: 0 auto;
		position: absolute;
		top: -37px;
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
		top: 74px;
		left: 0;
		right: 0;
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
		width: 44%;
		height: 32px;
		margin-top: -40px;
		margin-right: 330px;
		padding: 0px 0px;
		position: relative;
	}

	.text23 {
		color: #fff;
		font-size: 22px;
		font-family: oswald;
	}




	.serviceBox .read2-more {
		display: block;
		width: 105px;
		height: auto;
		line-height: 8px;
		border-radius: 7%;
		background: #24890d;
		border: 1px solid #fff;
		font-size: 11px;
		color: #fff;
		margin: 0 auto;
		position: absolute;
		padding: 6px;
		top: 48px;
		left: 0;
		right: 0;
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox .read2-more:hover {
		border: 3px solid #ffcc00;
		background: #004700;
		color: #ffcc00;
		text-decoration: none;
	}

	.serviceBox:hover .read2-more {
		border: 1px solid #ffcc00;
		font-weight: 700;
		color: #ffcc00;
	}
</style>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- <button type="button" class="btn btn-warning" onclick="send_mail_users_for_enddate()" >Send Mail</button> -->
</br>



<div class="row d-grid gap-3">
	<div id="matchlistdata">
	</div></br></br>

</div>

<script type="text/javascript">
	var $ = jQuery;
	var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
	$(document).ready(function() {
		match_list(<?php echo $_GET['id'] ?>);
	})
</script>