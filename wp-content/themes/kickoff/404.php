<?php
/**
 * The template for displaying 404 pages (Not Found).
 */
get_header(); ?>
	<!--// Main Content //-->
	<div class="kode-content">
		<!--// Page Content //-->
		<section class="kode-pagesection">
			<div class="container">
				<div class="row">
					<div class="kode-pagecontent col-md-12">
						<div class="kode-404-page">
							<img src="<?php echo KODE_PATH?>/images/404.png" alt="">
							<h2 class="thcolor"><?php esc_html_e('Are you lost Some Where?','kickoff');?></h2>
							<span><?php esc_html_e('You can go back to Home Page and search what you are looking for!','kickoff');?></span>
							<div class="kode-innersearch">
								<form class="kode-search" method="get" id="searchform" action="<?php  echo esc_url(home_url('/')); ?>/">
								<?php $search_val = get_search_query();
									if( empty($search_val) ){
										$search_val = esc_html__("Type keywords..." , "kickoff");
									} ?>
									<input type="text" name="s" id="s" autocomplete="off" data-default="<?php echo esc_attr($search_val); ?>" />
									<label><input type="submit" value=""></label>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--// Page Content //-->
	</div>
	<!--// Main Content //-->
<?php get_footer(); ?>