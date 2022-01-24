<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<div class="container-fluid mt-5">
<table class="table" id="matchlistdata-table"> 
		<thead>
			<!-- <th>ID</th> -->
			<th>Round</th>
            <th>Team1</th>
            <th>Team2</th>
		</thead>
</table>
<div>


<div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-3867c19" data-id="3867c19" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-f7faee0 elementor-widget elementor-widget-events-list" data-id="f7faee0" data-element_type="widget" data-widget_type="events-list.default">
				<div class="elementor-widget-container">
					<div class="events-item-wrapper events-f7faee0">
			<div class="kode-result-list shape-view">
					<div class="kode-inner-fixer">
						<div class="kode-team-match">
							<ul>
								<li>
									<a href="http://localhost/fb_wp/team/manchester-city-f-c/"><img alt="" src="http://localhost/fb_wp/wp-content/uploads/2015/09/team-logo-4-1.png">
									</a>
								</li>
								<li class="home-kode-vs"><a class="kode-modren-btn thbg-colortwo" href="http://kodeforest.com/wp-demo/kickoff/events/arsenal-f-c-vs-liverpool-f-c-3/">vs</a></li>
								<li>
									<a href="http://localhost/fb_wp/team/england-national/"><img alt="" src="http://localhost/fb_wp/wp-content/uploads/2015/09/team-logo-7-1.png">
									</a>
								</li>
							</ul>
							<div class="clearfix"></div>
							<h3><a href="http://kodeforest.com/wp-demo/kickoff/events/arsenal-f-c-vs-liverpool-f-c-3/">Manchester City F.C. VS England national</a></h3>
							<span class="kode-subtitle">Match Between Both Big Teams Starts <br>Thu Sep 15 2022 00:00:00 </span>
						</div>
					</div>					
					</div>		</div>
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