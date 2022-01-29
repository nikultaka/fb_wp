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
		background: #fff;
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
		background: #727cb6;
		font-size: 30px;
		color: #fff;
		margin: auto;
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox .service-icon span i {
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox:hover .service-icon span i {
		transform: rotate(-45deg);
	}

	.serviceBox .service-content {
		background: #fff;
		border: 1px solid #e7e7e7;
		border-radius: 3px;
		padding: 55px 15px;
		position: relative;
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
		font-size: 17px;
		font-weight: 500;
		color: #324545;
		text-transform: uppercase;
		margin: 0 0 25px 0;
		position: relative;
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox:hover .title {
		color: #727cb6;
	}

	.serviceBox .description {
		font-size: 14px;
		font-weight: 500;
		line-height: 24px;
		margin-bottom: 0;
	}

	.serviceBox .read-more {
		display: block;
		width: 80px;
		height: 60px;
		line-height: 38px;
		border-radius: 50%;
		background: #fff;
		border: 2px solid #e7e7e7;
		font-size: 14px;
		color: #c4c2c2;
		margin: 0 auto;
		position: absolute;
		bottom: -17px;
		left: 0;
		right: 0;
		transition: all 0.3s ease-out 0s;
	}

	.serviceBox .read-more:hover {
		border: 1px solid #727cb6;
		color: #727cb6;
		text-decoration: none;
	}

	.serviceBox:hover .read-more {
		border: 2px solid #727cb6;
		color: #727cb6;
	}
</style>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<div class="row d-grid gap-3">
	<div id="matchlistdata">
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xsx-6">
			<div class="serviceBox">
				<div class="service-icon">
					<span><i class="fa fa-id-card-o"></i></span>
				</div>
				<div class="row service-content">
					<span class="kode-subtitle col-sm-4">sport<h3>sportname</h3></span>
					<span class="kode-subtitle col-sm-4 ">League<h3>leaguename</h3></span>
					<span class="kode-subtitle col-sm-4">Round<h3>roundname</h3><br></span>
					<div class="col-md-6">
						<h3 class="title">Web Desinging</h3>
						<a href="WebDesigning.html" class="read-more" data-toggle="tooltip" title="Read More">Join</a>
					</div>
					<div class="col-md-6">
						<h3 class="title">Web Desinging</h3>
						<a href="WebDesigning.html" class="read-more" data-toggle="tooltip" title="Read More">Join</a>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<button class="btn btn-sm" onclick="history.back()">Go Back</button>

<script type="text/javascript">
	var $ = jQuery;
	var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
	$(document).ready(function() {
		match_list(<?php echo $_GET['id'] ?>);
	})
</script>