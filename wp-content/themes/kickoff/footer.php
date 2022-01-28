	<?php global $kode_theme_option; ?>
	<div class="clear" ></div>
	</div>
	<?php 
	if(isset($kode_theme_option['show-footer']) && $kode_theme_option['show-footer'] == 'enable'){ 
		if(isset($kode_theme_option['footer-newsletter']) && $kode_theme_option['footer-newsletter'] == 'enable'){ 
			if(isset($kode_theme_option['footer-newsletter-style']) && $kode_theme_option['footer-newsletter-style'] == 'style-1'){ ?>
				<div class="kode-newslatter kode-bg-color">
					<span class="kode-halfbg thbg-color"></span>
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<h3><?php esc_html_e('Subscribe Our Monthly Newsletter','kickoff')?></h3>
							</div>
							<div class="col-md-6">
								<?php echo '
									<form method="post" id="kode-submit-form" data-ajax="' . esc_url(AJAX_URL) . '" data-security="' . wp_create_nonce(KODE_SMALL_TITLE . '-create-nonce') . '" data-action="newsletter_mailchimp">
										<input type="text" id="email" name="email" placeholder="Subscribe Email">										
										<label><input type="submit" value=""></label>
										<p class="status"></p>
									</form>';
								?>
							</div>
						</div>
					</div>
				</div>
			<?php }else{ ?>
			<div class="crkt-midbar">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<div class="input-dec">
								<form method="post" id="kode-submit-form" data-ajax="<?php echo esc_url(AJAX_URL) ?>" data-security="<?php echo wp_create_nonce(KODE_SMALL_TITLE . '-create-nonce') ?>" data-action="newsletter_mailchimp">
									<span><?php esc_attr_e('Subscribe','kickoff');?></span>
									<input type="text" id="email" name="email" placeholder="<?php esc_attr_e('Subscribe Email','kickoff');?>">
									<input type="submit" value="<?php esc_attr_e('Subscribe','kickoff');?>" class="thbg-color">
									<p class="status"></p>
								</form>
							</div>
						</div>
						<div class="col-md-6">
							<div class="cricket-social-profile">
								<span><?php esc_attr_e('Follow Us','kickoff');?></span>
								<?php echo kode_print_header_social_icon('crkt-social-2');?>							
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 	
			} // Newsletter layout
		}// Newsletter Hide or Show
	if(isset($kode_theme_option['kode-footer-style']) && $kode_theme_option['kode-footer-style'] == 'footer-style-1'){ ?>
	<footer  class="footer-bottom-<?php echo esc_attr($kode_theme_option['footer-layout']);?>" id="footer1">
		<!--Footer Medium-->
		<div class="footer-medium">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar('Footer'); ?>		
				</div>
			</div>
		</div>
		<!--Footer Medium End-->
	</footer>
	
	<div class="kode-bottom-footer">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
             <?php if($kode_theme_option['show-copyright'] == 'enable'){ ?>
				<p><?php echo esc_attr($kode_theme_option['kode-copyright-text']);?></p>
			<?php }?>	
            </div>
            <div class="col-md-6">
              <a class="thbg-colortwo" id="kode-topbtn" href="#"><i class="fa fa-angle-up"></i></a>
            </div>
          </div>
        </div>
	</div>
	<div class="clear clearfix"></div>
	<?php }else if(isset($kode_theme_option['kode-footer-style']) && $kode_theme_option['kode-footer-style'] == 'footer-style-2'){ ?>
	<footer  class="footer-bottom-<?php echo esc_attr($kode_theme_option['footer-layout']);?>" id="footer1">
		<div class="kode_football_footer_wraper">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar('Footer'); ?>
					<div class="kode_football_footer_social_icon">
						<?php echo kode_print_header_social_icon('simple-social-style');?>	
					</div>
				</div>
			</div>
		</div>
	</footer>	
	<div class="kode_football_copyright_wraper">
		<div class="container">
		<?php if($kode_theme_option['show-copyright'] == 'enable'){ ?>
			<div class="kode_football_copyright_caption">
				<p><?php echo esc_attr($kode_theme_option['kode-copyright-text']);?></p>
			</div>
		<?php }?>		
		</div>
	</div>
	<?php }else if(isset($kode_theme_option['kode-footer-style']) && $kode_theme_option['kode-footer-style'] == 'footer-style-3'){ ?>
		<footer class="footer-layout-<?php echo esc_attr($kode_theme_option['footer-layout']);?> crkt-footer">
			<div class="crkt-main-footer">
				<div class="container">
					<div class="row">
						<?php dynamic_sidebar('Footer'); ?>
					</div>
				</div>
			</div>
			<?php if($kode_theme_option['show-copyright'] == 'enable'){ ?>
			<div class="container">
				<div class="crkt-copyright">
					<p><?php echo esc_attr($kode_theme_option['kode-copyright-text']);?></p>
				</div>
			</div>
			<?php }?>
		</footer>
	<?php }else { ?>
		<footer  class="footer-bottom-<?php echo esc_attr($kode_theme_option['footer-layout']);?>" id="footer1">
			<!--Footer Medium-->
			<div class="footer-medium">
				<div class="container">
					<div class="row">
						<?php dynamic_sidebar('Footer'); ?>		
					</div>
				</div>
			</div>
			<!--Footer Medium End-->
		</footer>
		
		<div class="kode-bottom-footer">
			<div class="container">
			  <div class="row">
				<div class="col-md-6">
				 <?php if($kode_theme_option['show-copyright'] == 'enable'){ ?>
					<p><?php echo esc_attr($kode_theme_option['kode-copyright-text']);?></p>
				<?php }?>	
				</div>
				<div class="col-md-6">
				  <a class="thbg-colortwo" id="kode-topbtn" href="#"><i class="fa fa-angle-up"></i></a>
				</div>
			  </div>
			</div>
		</div>
	<?php } //Footer Layout Condition 
	} //Footer Condition Show or Hide
	?>
	<div class="clear clearfix"></div>
</div> <!-- body-wrapper -->
<?php wp_footer(); ?>
</body>
</html>