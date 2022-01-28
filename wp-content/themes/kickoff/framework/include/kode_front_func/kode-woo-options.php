<?php
	/*	
	*	Kodeforest Woo Option file
	*	---------------------------------------------------------------------
	*	This file creates all post options to the post page
	*	---------------------------------------------------------------------
	*/
	
	//Woo Listing
	if( !function_exists('kode_get_woo_item_slider') ){
		function kode_get_woo_item_slider( $settings ){
			
			// query posts section
			$args = array('post_type' => 'product', 'suppress_filters' => false);
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;
			
			$settings['woo-style'] = (empty($settings['woo-style']))? 'woo-style-1': $settings['woo-style'];
			$settings['woo-column-size'] = (empty($settings['woo-column-size']))? '3': $settings['woo-column-size'];
			//$settings['woo-style'];
			if( !empty($settings['category']) || (!empty($settings['tag'])) ){
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'product_cat', 'field'=>'slug'));
				}
				// if( !empty($settings['tag'])){
					// array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'product_tag', 'field'=>'slug'));
				// }
			}			
			$query = new WP_Query( $args );

			// create the woo filter
			
			$settings['num-title-fetch'] = empty($settings['num-title-fetch'])? '25': $settings['num-title-fetch'];
			
			$size = 4;
			$kode_woo  = '<div class="kode-woo kode-shop-list col-md-12">';
			if($settings['header-title'] <> ''){
				$kode_woo .= '
				<div class="kode-maintitle kode-tstitle">
					<h2>'.esc_attr($settings['header-title']).'</h2>
				</div>';
			}
			$kode_woo .= '
			<div data-slide="'.esc_attr($settings['woo-column-size']).'" class="owl-carousel owl-theme kode-shop-list next-prev-style">';
			
			$current_size = 0;
			while($query->have_posts()){ $query->the_post();
				global $kode_post_option,$post,$kode_post_settings,$product;	
				$kode_option = json_decode(kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true)), true);
				$prices_precision = wc_get_price_decimals();
				$price = wc_format_decimal( $product->get_price(), $prices_precision );
				$price_regular = wc_format_decimal( $product->get_regular_price(), $prices_precision );
				$price_sale = $product->get_sale_price() ? floatval(wc_format_decimal( $product->get_sale_price(), $prices_precision )) : null;
				if(empty($price_sale)){
					$price_sale = $price_regular;
				}
				$rating_count = $product->get_rating_count();
				$review_count = $product->get_review_count();
				$average      = $product->get_average_rating();
				// if( $current_size % $size == 0 ){
					// $woo .= '<li class="clear"></li>';
				// }	
				if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-1'){
				$kode_woo .= '
				 <div class="item">
				  <div class="kode-ux">
					<div class="kode-pro-inner">
						<figure>
							<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, 'kode-blog-small-size').'</a>
							<figcaption>
								<h4><a href="'.esc_url(get_permalink()).'">'.esc_attr(substr(get_the_title(),0,$settings['num-title-fetch'])).'</a></h4>
								<p class="kode-pro-cat"><a href="'.esc_url(get_permalink()).'">'.esc_html__('Categories','kickoff').'</a></p>
							</figcaption>
						</figure>
						<div class="kode-pro-info">';
							$kode_woo .= 
							apply_filters( 'woocommerce_loop_add_to_cart_link',
								sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="add_to_cart cart button %s product_type_%s"><i class="fa fa-shopping-cart"></i> '.esc_html__('Add To Cart','kickoff').'</a>',
									esc_url( $product->add_to_cart_url() ),
									esc_attr( isset( $quantity ) ? $quantity : 1 ),
									esc_attr( $product->get_id() ),
									esc_attr( $product->get_sku() ),
									esc_attr( isset( $class ) ? $class : 'button' ),
									esc_html( $product->add_to_cart_text() )
								),
								$product );
							$kode_woo .= '
							<span>$'.esc_attr($price_sale).'</span>
						</div>
					</div>
				</div>
				</div>
				';
				}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-2'){
					$kode_woo .= '
					 <div class="item">
					<!--PRODUCT LIST ITEM START-->
					<div class="kode_football_product_fig">
						<figure>
							<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(350,350)).'</a>
							<ul class="kode_football_product_icon">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
								<li><a href="#"><i class="fa  fa-rss"></i></a></li>
							</ul>
						</figure>
						<div class="kode_football_product_caption">
							<h5><a href="'.esc_url(get_permalink()).'">'.esc_attr(substr(get_the_title(),0,$settings['num-title-fetch'])).'</a></h5>
							<span>$'.esc_attr($price_sale).'</span>
							<ul class="kode_football_product_star">
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star-half-o"></i></a></li>
							</ul>
						</div>
					</div>
					</div>
					<!--PRODUCT LIST ITEM END-->';
				}else{
					$kode_woo .= '
				 <div class="item">
				  <div class="kode-ux">
					<div class="kode-pro-inner">
						<figure>
							<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, 'kode-blog-small-size').'</a>
							<figcaption>
								<h4><a href="'.esc_url(get_permalink()).'">'.esc_attr(substr(get_the_title(),0,$settings['num-title-fetch'])).'</a></h4>
								<p class="kode-pro-cat"><a href="'.esc_url(get_permalink()).'">'.esc_html__('Categories','kickoff').'</a></p>
							</figcaption>
						</figure>
						<div class="kode-pro-info">';
							$kode_woo .= 
							apply_filters( 'woocommerce_loop_add_to_cart_link',
								sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="add_to_cart cart button %s product_type_%s"><i class="fa fa-shopping-cart"></i> '.esc_html__('Add To Cart','kickoff').'</a>',
									esc_url( $product->add_to_cart_url() ),
									esc_attr( isset( $quantity ) ? $quantity : 1 ),
									esc_attr( $product->get_id() ),
									esc_attr( $product->get_sku() ),
									esc_attr( isset( $class ) ? $class : 'button' ),
									esc_html( $product->add_to_cart_text() )
								),
								$product );
							$kode_woo .= '
							<span>$'.esc_attr($price_sale).'</span>
						</div>
					</div>
				</div>
				</div>
				';
				}	
				$current_size++;
			}
			wp_reset_postdata();

			$kode_woo .= '</div></div>';
			
			return $kode_woo;
		}
	}
	
	
	
	if( !function_exists('kode_get_woo_item') ){
		function kode_get_woo_item($settings = array()){
			$args = array('post_type' => 'product', 'suppress_filters' => false);
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;
			
			$settings['woo-column-size'] = (empty($settings['woo-column-size']))? '3': $settings['woo-column-size'];
			//$settings['woo-style'];
			if( !empty($settings['category']) || (!empty($settings['tag'])) ){
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'product_cat', 'field'=>'slug'));
				}
				// if( !empty($settings['tag'])){
					// array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'product_tag', 'field'=>'slug'));
				// }
			}			
			$query = new WP_Query( $args );
			$kode_woo = '';
			$size = 3;			
			if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-1'){
				$kode_woo .= '<div class="kode-shop-list col-md-12"><ul class="row">';
				$size = $settings['woo-column-size'];
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-2'){
				$kode_woo .= '<ul class="product-listing row padding-none">';
				$size = $settings['woo-column-size'];
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-3'){
				$kode_woo .= '<ul class="children-sec-list row padding-none">';
				$size = $settings['woo-column-size'];
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-4'){
				$kode_woo .= '<div class="product-listing2"><ul class="row padding-none">';
				$size = $settings['woo-column-size'];
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-5'){
				$kode_woo .= '<div class="product-listing2"><ul class="row padding-none">';
				$size = $settings['woo-column-size'];
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-6'){
				$kode_woo .= '<ul class="new-products row padding-none">';
				$size = $settings['woo-column-size'];
			}
			$current_size = 0;
			while($query->have_posts()){ $query->the_post();
				global $kode_post_option,$post,$kode_post_settings,$product;
				if( $current_size % $size == 0 ){
					$kode_woo .= '<li class="clear"></li>';
				}	
				
				// print_r($product);
				$kode_option = json_decode(kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true)), true);
				$prices_precision = wc_get_price_decimals();
				$price = wc_format_decimal( $product->get_price(), $prices_precision );
				$price_regular = wc_format_decimal( $product->get_regular_price(), $prices_precision );
				$price_sale = $product->get_sale_price() ? floatval(wc_format_decimal( $product->get_sale_price(), $prices_precision )) : null;
				if(empty($price_sale)){
					$price_sale = $price_regular;
				}
				
				if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-1'){
					$kode_woo .= '
					<!--PRODUCT LIST ITEM START-->
					<li class="col-sm-6 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">
						<div class="kode-ux">
							<div class="kode-pro-inner">
								<figure>
									<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, 'kode-blog-small-size').'</a>
									<figcaption>
										<h4><a href="'.esc_url(get_permalink()).'">'.esc_attr(substr(get_the_title(),0,18)).'</a></h4>
										<p class="kode-pro-cat"><a href="'.esc_url(get_permalink()).'">'.esc_html__('Categories','kickoff').'</a></p>
									</figcaption>
								</figure>
								<div class="kode-pro-info">';
									$kode_woo .= 
									apply_filters( 'woocommerce_loop_add_to_cart_link',
										sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="add_to_cart cart button %s product_type_%s"><i class="fa fa-shopping-cart"></i> '.esc_html__('Add To Cart','kickoff').'</a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( isset( $quantity ) ? $quantity : 1 ),
											esc_attr( $product->get_id() ),
											esc_attr( $product->get_sku() ),
											esc_attr( isset( $class ) ? $class : 'button' ),
											esc_html( $product->add_to_cart_text() )
										),
										$product );
									
									$kode_woo .= '
									<span>$'.esc_attr($price_sale).'</span>
								</div>
							</div>
						</div>
					</li>';
				}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-2'){
					$kode_woo .= '
					<li class="col-sm-6 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">
					<!--PRODUCT LIST ITEM START-->
					<div class="kode_football_product_fig">
						<figure>
							<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(350,350)).'</a>
							<ul class="kode_football_product_icon">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
								<li><a href="#"><i class="fa  fa-rss"></i></a></li>
							</ul>
						</figure>
						<div class="kode_football_product_caption">
							<h5><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h5>
							<span>$'.esc_attr($price_sale).'</span>
							<ul class="kode_football_product_star">
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star-half-o"></i></a></li>
							</ul>
						</div>
					</div>
					<!--PRODUCT LIST ITEM END-->
					</li>
					';
				}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-3'){
					$kode_woo .= '
					<li class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">
						<div class="child-products kode-ux">
							<div class="thumb">
								<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(350,350)).'</a>
							</div>
							<div class="text">
								<h3><a href="'.esc_url(get_permalink()).'">'.substr(get_the_title(),0,20).'</a></h3>';
								$kode_woo .= 
								apply_filters( 'woocommerce_loop_add_to_cart_link',
									sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="cart button %s product_type_%s"><i class="fa fa-shopping-cart"></i></a>',
										esc_url( $product->add_to_cart_url() ),
										esc_attr( isset( $quantity ) ? $quantity : 1 ),
										esc_attr( $product->get_id() ),
										esc_attr( $product->get_sku() ),
										esc_attr( isset( $class ) ? $class : 'button' ),
										esc_html( $product->add_to_cart_text() )
									),
									$product );
							$kode_woo .= '</div>
						</div>
					</li>';
				}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-4'){
					$kode_woo .= '
						<li class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">
							<div class="kf-products-2 kode-ux">
								<div class="thumb">
									'.get_the_post_thumbnail($post->ID, array(350,350)).'
									<a class="zoom" href="'.esc_url(get_permalink()).'"><i class="fa fa-search"></i></a>
								</div>
								<div class="text">
									<div class="btns">';
										$kode_woo .= 
										apply_filters( 'woocommerce_loop_add_to_cart_link',
										sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="cart button %s product_type_%s"><i class="fa fa-shopping-cart"></i></a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( isset( $quantity ) ? $quantity : 1 ),
											esc_attr( $product->get_id() ),
											esc_attr( $product->get_sku() ),
											esc_attr( isset( $class ) ? $class : 'button' ),
											esc_html( $product->add_to_cart_text() )
										),
										$product ); 
										$kode_woo .= kode_pro_favorite($post);
										$kode_woo .= '
									</div>
									<h3><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h3>
									<p>$'.esc_attr($price_sale).'</p>
								</div>
							</div>
						</li>';
				}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-5'){
					$kode_woo .= '<li class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">
							<div class="kf-products ">
								<div class="kode-ux">
									<div class="thumb">
										<div class="new-tag">
											'.esc_html__('New','kickoff').'
										</div>
										'.get_the_post_thumbnail($post->ID, array(350,350)).'
										<div class="caption">
											<p>'.esc_attr(substr(get_the_content(),0,25)).'</p>
											<h3>Discount Upto</h3>
											<h3>50%</h3>
											<a class="zoom" href="'.esc_url(get_permalink()).'"><i class="fa fa-search"></i></a>
										</div>
									</div>
									<div class="text">
										<div class="kf-price">
											<div>
												<i class="fa fa-shopping-cart"></i>
											   $'.esc_attr($price_sale).'
											</div>
										</div>
										<h3><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h3>
										<p>'.esc_attr(substr(get_the_content(),0,10)).'</p>
									</div>
								</div>	
							</div>
						</li>';
				}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-6'){
					$kode_woo .= '
					<li class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">
						<div class="all-product-container kode-ux">
							<div class="thumb">
								<div class="new-tag">'.esc_html__('New','kickoff').'</div>
								<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(350,350)).'</a>
								<div class="btn-container">
									<div class="compare">';
										$kode_woo .= kode_pro_favorite($post);
									$kode_woo .= '</div>
									<span class="price">$'.$price_sale.'</span>';
									$kode_woo .= 
									apply_filters( 'woocommerce_loop_add_to_cart_link',
										sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="cart button %s product_type_%s"><i class="fa fa-shopping-cart"></i></a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( isset( $quantity ) ? $quantity : 1 ),
											esc_attr( $product->get_id() ),
											esc_attr( $product->get_sku() ),
											esc_attr( isset( $class ) ? $class : 'button' ),
											esc_html( $product->add_to_cart_text() )
										),
										$product );
							   $kode_woo .= ' </div>
							</div>
							<div class="text">
								<h2><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h2>
								<p>'.esc_attr(substr(get_the_content(),0,10)).'</p>
								<a class="detail" href="'.esc_url(get_permalink()).'"><i class="fa fa-file-text-o"></i></a>
							</div>
						</div>
					</li>';
				}else{
					$kode_woo .= '
					<li class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">
					<!--PRODUCT LIST ITEM START-->
					<div class="kode_football_product_fig">
						<figure>
							<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(350,350)).'</a>
							<ul class="kode_football_product_icon">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
								<li><a href="#"><i class="fa  fa-rss"></i></a></li>
							</ul>
						</figure>
						<div class="kode_football_product_caption">
							<h5><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h5>
							<span>$'.esc_attr($price_sale).'</span>
							<ul class="kode_football_product_star">
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star"></i></a></li>
								<li><a href="#"><i class="fa fa-star-half-o"></i></a></li>
							</ul>
						</div>
					</div>
					<!--PRODUCT LIST ITEM END-->
					</li>
					';
				}
				$current_size++;
			} wp_reset_postdata();	
			if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-1'){
				$kode_woo .= '</ul></div>';
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-2'){
				$kode_woo .= '</ul>';
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-3'){
				$kode_woo .= '</ul>';
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-4'){
				$kode_woo .= '</ul></div>';
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-5'){
				$kode_woo .= '</ul></div>';
			}else if(isset($settings['woo-style']) && $settings['woo-style'] == 'woo-style-6'){
				$kode_woo .= '</ul>';
			}
			if( $settings['pagination'] == 'enable' ){
				$kode_woo .= kode_get_pagination($query->max_num_pages, $args['paged']);
			}
			//$kode_woo .= '</div>';
			wp_reset_query();	
			return $kode_woo;
		}
	}	
	
	
	if( !function_exists('kode_wish_products') ){
		function kode_wish_products($post){
			$kode_woo = '';
			$kode_woo .= '
			<script>
			jQuery(document).ready(function($){
			"use strict";
				$("a#add-to-wish-'.esc_js($post->ID).'").click(function(e){
					e.preventDefault(); //
					var $star = $(this).find("i");
					var add_to_fav_opptions = {
						target:        "#fav_target-wish-'.esc_js($post->ID).'",   // target element(s) to be updated with server response
						beforeSubmit:  function(){
							$star.addClass("fa-spin");
						},  // pre-submit callback
						success:       function(){
							$star.removeClass("fa-spin");
							$("#add-to-wish-'.esc_js($post->ID).'").hide(0,function(){
								$("#fav_output-wish-'.esc_js($post->ID).'").delay(200).show();
							});
						}
					};
					$("#add-to-wish-form-'.esc_js($post->ID).'").ajaxSubmit( add_to_fav_opptions );
				});
			});	
			</script>';
			$kode_woo .= '<!-- Add to wish -->
			<span class="add-to-fav">';
				if( is_user_logged_in() ){
					$user_id = get_current_user_id();
					$k_product_id = $post->ID;
					if ( is_added_to_wish_products( $user_id, $k_product_id ) ) {													
						$kode_woo .= '<div id="fav_output-wish-'.esc_attr($post->ID).'" class="fav_output show k_hide_fav"><i class="fa fa-eye dim"></i></div>';
					} else {
						$kode_woo .= '
						<form class="k_hide_fav" action="'.esc_url(admin_url('admin-ajax.php')).'" method="post" id="add-to-wish-form-'.esc_attr($post->ID).'">
							<input type="hidden" name="user_id" value="'.esc_attr($user_id).'" />
							<input type="hidden" name="k_product_id" value="'.esc_attr($k_product_id).'" />
							<input type="hidden" name="action" value="add_to_wish_products" />
						</form>
						<div id="fav_output-wish-'.esc_attr($post->ID).'" class="k_hide_fav fav_output"><span id="fav_target-wish-'.esc_attr($post->ID).'" class="dim fav_target"><i class="fa fa-eye dim"></i></span></div>
						<a id="add-to-wish-'.esc_attr($post->ID).'" href="#"><i class="fa fa-eye"></i></a>';
					}
				}else{
					$kode_woo .= '<a href="#login-modal" data-toggle="modal"><i class="fa fa-eye"></i></a>';
				}
			return $kode_woo .= '</span>';
		}
	}
	
	if( !function_exists( 'kode_remove_wish_products' ) ){
		function kode_remove_wish_products($post){
			$user_id = get_current_user_id();
			$html_remove = '<a class="remove-from-wish" data-product-id="'.esc_attr($post->ID).'" data-user-id="'.esc_attr($user_id).'" href="'.esc_url(admin_url('admin-ajax.php')).'" title="'. esc_html__('Remove from Wishlist','kickoff').'"><i class="fa fa-trash-o"></i></a>';
			$html_remove .=  '<span class="loader"><i class="fa fa-spinner fa-spin"></i></span><div class="ajax-response"></div>';
			return $html_remove;
		}
	}
	
	/*	Add to favourite */
	add_action('wp_ajax_add_to_wish_products', 'add_to_wish_products');
	if( !function_exists( 'add_to_wish_products' ) ){
		function add_to_wish_products(){
			if( isset($_POST['k_product_id']) && isset($_POST['user_id']) ){
				$k_product_id = intval($_POST['k_product_id']);
				$user_id = intval($_POST['user_id']);
				if( $k_product_id > 0 && $user_id > 0 ){
					//$prev_value = get_user_meta($user_id,'wish_products', $k_product_id );
					if( add_user_meta($user_id,'wish_products', $k_product_id ) ){
						//update_user_meta( $user_id, 'wish_products', $k_product_id, $prev_value );
						echo '<i class="fa fa-eye"><i>';
					}else{
						echo '<i class="fa fa-arrow yellow"><i>';
					}
				}
			}else{
				esc_html_e('Invalid Paramenters!', 'kickoff');
			}
			die;
		}
	}

	/*	Already added to favourite	*/
	if( !function_exists( 'is_added_to_wish_products' ) ){
		function is_added_to_wish_products( $user_id, $k_product_id ){
			global $wpdb;
			$results = $wpdb->get_results( "SELECT * FROM $wpdb->usermeta WHERE meta_key='wish_products' AND meta_value=".$k_product_id." AND user_id=". $user_id );
			if( isset($results[0]->meta_value) && ($results[0]->meta_value == $k_product_id) ){
				return true;
			}else{
				return false;
			}
		}
	}

	// Remove from favourites
	add_action( 'wp_ajax_remove_from_wish', 'remove_from_wish' );
	if( !function_exists( 'remove_from_wish' ) ){
		function remove_from_wish(){
			if( isset($_POST['product_id']) && isset($_POST['user_id']) ){
				$product_id = intval($_POST['product_id']);
				$user_id = intval($_POST['user_id']);
				if( $product_id > 0 && $user_id > 0 ){
					if( delete_user_meta( $user_id, 'wish_products', $product_id ) ){
						echo 3;
						/* Removed successfully! */
					}else{
						echo 2;
						/* Failed to remove! */
					}
				}else{
					echo 1;
					/* Invalid parameters! */
				}
			}else{
				echo 1;
				/* Invalid parameters! */
			}
			die;
		}
	}
	
	// Remove from favourites
	add_action( 'wp_ajax_remove_from_favorites', 'remove_from_favorites' );
	if( !function_exists( 'remove_from_favorites' ) ){
		function remove_from_favorites(){
			if( isset($_POST['product_id']) && isset($_POST['user_id']) ){
				$product_id = intval($_POST['product_id']);
				$user_id = intval($_POST['user_id']);
				if( $product_id > 0 && $user_id > 0 ){
					if( delete_user_meta( $user_id, 'favorite_products', $product_id ) ){
						echo 3;
						/* Removed successfully! */
					}else{
						echo 2;
						/* Failed to remove! */
					}
				}else{
					echo 1;
					/* Invalid parameters! */
				}
			}else{
				echo 1;
				/* Invalid parameters! */
			}
			die;
		}
	}
	
	//Product Favourite
	if( !function_exists('kode_pro_favorite') ){
		function kode_pro_favorite($post){
			$kode_woo = '';
			$kode_woo .= '
			<script>
			jQuery(document).ready(function($){
			"use strict";
				$("a#add-to-favorite-'.esc_js($post->ID).'").click(function(e){
					e.preventDefault(); //
					var $star = $(this).find("i");
					var add_to_fav_opptions = {
						target:        "#fav_target-'.esc_js($post->ID).'",   // target element(s) to be updated with server response
						beforeSubmit:  function(){
							$star.addClass("fa-spin");
						},  // pre-submit callback
						success:       function(){
							$star.removeClass("fa-spin");
							$("#add-to-favorite-'.esc_js($post->ID).'").hide(0,function(){
								$("#fav_output-'.esc_js($post->ID).'").delay(200).show();
							});
						}
					};
					$("#add-to-favorite-form-'.esc_js($post->ID).'").ajaxSubmit( add_to_fav_opptions );
				});
			});	
			</script>';
			$kode_woo .= '<!-- Add to favorite -->
			<span class="add-to-fav">';
				if( is_user_logged_in() ){
					$user_id = get_current_user_id();
					$k_product_id = $post->ID;
					if ( is_added_to_favorite( $user_id, $k_product_id ) ) {													
						$kode_woo .= '<div id="fav_output-'.esc_attr($post->ID).'" class="fav_output show k_hide_fav"><i class="fa fa-heart dim"></i></div>';
					} else {
						$kode_woo .= '
						<form class="k_hide_fav" action="'.esc_url(admin_url('admin-ajax.php')).'" method="post" id="add-to-favorite-form-'.esc_attr($post->ID).'">
							<input type="hidden" name="user_id" value="'.esc_attr($user_id).'" />
							<input type="hidden" name="k_product_id" value="'.esc_attr($k_product_id).'" />
							<input type="hidden" name="action" value="add_to_favorite" />
						</form>
						<div id="fav_output-'.esc_attr($post->ID).'" class="k_hide_fav fav_output"><span id="fav_target-'.esc_attr($post->ID).'" class="dim fav_target"><i class="fa fa-star dim"></i></span></div>
						<a id="add-to-favorite-'.esc_attr($post->ID).'" href="#"><i class="fa fa-heart"></i></a>';
					}
				}else{
					$kode_woo .= '<a href="#login-modal" data-toggle="modal"><i class="fa fa-heart"></i></a>';
				}
			return $kode_woo .= '</span>';
		}
	}
	
	//Remove from Favourite
	if( !function_exists( 'kode_remove_favorite' ) ){
		function kode_remove_favorite($post){
			$user_id = get_current_user_id();
			$html_remove = '<a class="remove-from-favorite" data-product-id="'.$post->ID.'" data-user-id="'.$user_id.'" href="'.admin_url('admin-ajax.php').'" title="'. esc_html__('Remove from favorties','kickoff').'"><i class="fa fa-trash-o"></i></a>';
			$html_remove .=  '<span class="loader"><i class="fa fa-spinner fa-spin"></i></span><div class="ajax-response"></div>';
			return $html_remove;
		}
	}
	
	/*	Add to favourite */
	add_action('wp_ajax_add_to_favorite', 'add_to_favorite');
	if( !function_exists( 'add_to_favorite' ) ){
		function add_to_favorite(){
			if( isset($_POST['k_product_id']) && isset($_POST['user_id']) ){
				$k_product_id = intval($_POST['k_product_id']);
				$user_id = intval($_POST['user_id']);
				if( $k_product_id > 0 && $user_id > 0 ){
					if( add_user_meta($user_id,'favorite_products', $k_product_id ) ){
						echo '<i class="fa fa-heart"><i>';
					}else{
						echo '<i class="fa fa-arrow yellow"><i>';
					}
				}
			}else{
				esc_html_e('Invalid Paramenters!', 'kickoff');
			}
			die;
		}
	}

	/*	Already added to favourite	*/
	if( !function_exists( 'is_added_to_favorite' ) ){
		function is_added_to_favorite( $user_id, $k_product_id ){
			global $wpdb;
			$results = $wpdb->get_results( "SELECT * FROM $wpdb->usermeta WHERE meta_key='favorite_products' AND meta_value=".$k_product_id." AND user_id=". $user_id );
			if( isset($results[0]->meta_value) && ($results[0]->meta_value == $k_product_id) ){
				return true;
			}else{
				return false;
			}
		}
	}
	
	// Remove from favourites
	add_action( 'wp_ajax_remove_from_favorites', 'remove_from_favorites' );
	if( !function_exists( 'remove_from_favorites' ) ){
		function remove_from_favorites(){
			if( isset($_POST['product_id']) && isset($_POST['user_id']) ){
				$product_id = intval($_POST['product_id']);
				$user_id = intval($_POST['user_id']);
				if( $product_id > 0 && $user_id > 0 ){
					if( delete_user_meta( $user_id, 'favorite_products', $product_id ) ){
						echo 3;
						/* Removed successfully! */
					}else{
						echo 2;
						/* Failed to remove! */
					}
				}else{
					echo 1;
					/* Invalid parameters! */
				}
			}else{
				echo 1;
				/* Invalid parameters! */
			}
			die;
		}
	}
	
	// use for printing product slider
	if( !function_exists('kode_get_product_slider_item') ){
		function kode_get_product_slider_item( $settings ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			
			$slide_order = array();
			$slide_data = array();
			
			// query posts section
			$args = array('post_type' => 'product', 'suppress_filters' => false);
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['ignore_sticky_posts'] = 1;

			if( is_numeric($settings['category']) ){
				$args['category'] = (empty($settings['category']))? '': $settings['category'];	
			}else{ 
				if( !empty($settings['category']) || !empty($settings['tag']) ){
					$args['tax_query'] = array('relation' => 'OR');
					
					if( !empty($settings['category']) ){
						array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'product_cat', 'field'=>'slug'));
					}
					// if( !empty($settings['tag']) ){
						// array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'product_tag', 'field'=>'slug'));
					// }				
				}	
			}
			$query = new WP_Query( $args );	
			
			// set the excerpt length
			global $kode_theme_option, $kode_excerpt_length, $kode_excerpt_read_more; 
			$kode_excerpt_read_more = false;
			$kode_excerpt_length = $settings['num-excerpt'];
			$ret = '<div class="owl-banner owl-theme owl-slider">';
			global $post;
			while($query->have_posts()){ $query->the_post();
				$image_id = get_post_thumbnail_id();
				
				if( !empty($image_id) ){
				$ret .= '
					<!--BANNER ITEM START-->
					<div class="item">
						<div class="banner-slide">
							<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, 'product-size').'</a>
							<div class="banner-caption">
								<h3>20% Discount on</h3>
								<h2>'.esc_attr(get_the_title()).'</h2>
							</div>
						</div>
					</div>
					<!--BANNER ITEM END-->';
				}
			}	
			$ret .= '</div>';
		
			return $ret;
		}
	}
	
	
	if( !function_exists('kode_track_order_detail') ){
		function kode_track_order_detail($settings){
		
			if(class_exists('Woocommerce')){
				if(!isset($_GET['order_number']) && $_GET['order_number'] == ''){
					echo '<div class="order-track-submit">';
						echo '<form method="GET" id="track_order">';
						echo '<h2>Track Order</h2>';
							echo '<input type="text" name="order_number" value="" id="order_number" />';							
							echo '<input type="submit" value="Submit" class="btn_submit">';
						echo '</form>';
					echo '</div>';
				}else{
					$settings['order-status-pending'] = (empty($settings['order-status-pending']))? 'Order is Pending!': $settings['order-status-pending'];
					$settings['order-status-processing'] = (empty($settings['order-status-processing']))? 'Order is processing!': $settings['order-status-processing'];
					$settings['order-status-on-hold'] = (empty($settings['order-status-on-hold']))? 'Order is on-hold!': $settings['order-status-on-hold'];
					$settings['order-status-completed'] = (empty($settings['order-status-completed']))? 'Order is completed!': $settings['order-status-completed'];
					$settings['order-status-cancelled'] = (empty($settings['order-status-cancelled']))? 'Order is cancelled!': $settings['order-status-cancelled'];
					$settings['order-status-refunded'] = (empty($settings['order-status-refunded']))? 'Order is refunded!': $settings['order-status-refunded'];
					$settings['order-status-failed'] = (empty($settings['order-status-failed']))? 'Order is failed!': $settings['order-status-failed'];
					
					$order_id = esc_attr($_GET['order_number']);
					$order = new WC_Order( $order_id );
					$order_status = '';
					//Order Condition
					if($order->post_status == 'wc-pending'){
						$order_status = $settings['order-status-pending'];
					}else if($order->post_status == 'wc-processing'){
						$order_status = $settings['order-status-processing'];
					}else if($order->post_status == 'wc-on-hold'){
						$order_status = $settings['order-status-on-hold'];
					}else if($order->post_status == 'wc-completed'){
						$order_status = $settings['order-status-completed'];
					}else if($order->post_status == 'wc-cancelled'){
						$order_status = $settings['order-status-cancelled'];
					}else if($order->post_status == 'wc-refunded'){
						$order_status = $settings['order-status-refunded'];
					}else if($order->post_status == 'wc-failed'){
						$order_status = $settings['order-status-failed'];
					}else{
						$order_status = 'No order match with your request!';
					}	
					//echo '<div class="kd-table">';
						echo '<h2>Order Number: #'.esc_attr($order_id).'</h2>';
						if(!empty($order->post_status)){
							echo '
							<table class="table_head">
								<tr>
									<th>Product Name</th>
									<th>Price</th>
									<th>Quality</th>
									<th>Status</th>
								</tr>';
								if(!empty($order)){
									$items = $order->get_items();
									foreach ( $items as $item ) {
										echo '<tr class="table_body">';
											echo '<td><a href="'.get_permalink($item['product_id']).'">'.$item['name'].'</a></td>';
											echo '<td>'.esc_attr($item['line_total']).'</td>';
											echo '<td>'.esc_attr($item['qty']).'</td>';
											echo '<td>'.esc_attr($order_status).'</td>';
										echo '</tr>';
									}
								}
							echo '</table>';
						}else{
							echo '<h3>'.esc_attr($order_status).'</h3>';
						}
						echo '<div class="order-track-submit">';
							echo '<form method="GET" id="track_order">';
							echo '<h2>Track Order</h2>';
								echo '<input type="text" name="order_number" value="'.esc_attr($order_id).'" id="order_number" />';							
								echo '<input type="submit" value="Submit" class="btn_submit">';
							echo '</form>';
						echo '</div>';
					//echo '</div>';
				}
			}
			//order_tracking
		}
	}
	
	// add work in page builder area
	add_filter('kode_page_builder_option', 'kode_register_woo_item');
	if( !function_exists('kode_register_woo_item') ){
		function kode_register_woo_item( $page_builder = array() ){
			global $kode_spaces;
			$page_builder['content-item']['options']['woo'] = array(
				'title'=> esc_html__('Woo', 'kickoff'), 
				'icon'=> 'fa-shopping-cart', 
				'type'=>'item',
				'options'=> array(					
					'category'=> array(
						'title'=> esc_html__('Category' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> kode_get_term_list('product_cat'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'tag'=> array(
						'title'=> esc_html__('Tag' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> kode_get_term_list('product_tag'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'num-excerpt'=> array(
						'title'=> esc_html__('Num Excerpt (Word)' ,'kickoff'),
						'type'=> 'text',	
						'default'=> '25',
						'description'=> esc_html__('This is a number of word (decided by spaces) that you want to show on the post excerpt. <strong>Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag</strong>.', 'kickoff')
					),	
					'num-fetch'=> array(
						'title'=> esc_html__('Num Fetch' ,'kickoff'),
						'type'=> 'text',	
						'default'=> '8',
						'description'=> esc_html__('Specify the number of posts you want to pull out.', 'kickoff')
					),										
					'woo-style'=> array(
						'title'=> esc_html__('Woo Style' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'woo-style-1' => esc_html__('Style 1', 'kickoff'),
							'woo-style-2' => esc_html__('Style 2', 'kickoff'),
							// 'woo-style-3' => esc_html__('Style 3', 'kickoff'),
							// 'woo-style-4' => esc_html__('Style 4', 'kickoff'),
							// 'woo-style-5' => esc_html__('Style 5', 'kickoff'),
							// 'woo-style-6' => esc_html__('Style 6', 'kickoff'),
						),
						'default'=>'woo-full'
					),		
					'woo-column-size'=> array(
						'title'=> esc_html__('Woo Column Size' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'2' => esc_html__('Column 2', 'kickoff'),
							'3' => esc_html__('Column 3', 'kickoff'),
							'4' => esc_html__('Column 4', 'kickoff'),
						),
						'default'=>'woo-full'
					),	
					'order'=> array(
						'title'=> esc_html__('Order' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'desc'=>esc_html__('Descending Order', 'kickoff'), 
							'asc'=> esc_html__('Ascending Order', 'kickoff'), 
						)
					),									
					'pagination'=> array(
						'title'=> esc_html__('Enable Pagination' ,'kickoff'),
						'type'=> 'checkbox'
					),										
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kickoff'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item', 'kickoff')
					),					
				)
			);
			
			$page_builder['content-item']['options']['woo-slider'] = array(
				'title'=> esc_html__('Woo Slider', 'kickoff'), 
				'icon'=>'fa-opencart',
				'type'=>'item',
				'options'=>array(					
					'category'=> array(
						'title'=> esc_html__('Category' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> kode_get_term_list('product_cat'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'tag'=> array(
						'title'=> esc_html__('Tag' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> kode_get_term_list('product_tag'),
						'description'=> esc_html__('Will be ignored when the woo filter option is enabled.', 'kickoff')
					),	
					'woo-style'=> array(
						'title'=> esc_html__('Woo Style' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'woo-style-1' => esc_html__('Style 1', 'kickoff'),
							'woo-style-2' => esc_html__('Style 2', 'kickoff'),
							// 'woo-style-3' => esc_html__('Style 3', 'kickoff'),
							// 'woo-style-4' => esc_html__('Style 4', 'kickoff'),
							// 'woo-style-5' => esc_html__('Style 5', 'kickoff'),
							// 'woo-style-6' => esc_html__('Style 6', 'kickoff'),
						),
						'default'=>'woo-full'
					),						
					'num-title-fetch'=> array(
						'title'=> esc_html__('Num Fetch' ,'kickoff'),
						'type'=> 'text',	
						'default'=> '25',
						'description'=> esc_html__('Specify the number of title word you want to pull out.', 'kickoff')
					),	
					'orderby'=> array(
						'title'=> esc_html__('Order By' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'date' => esc_html__('Publish Date', 'kickoff'), 
							'title' => esc_html__('Title', 'kickoff'), 
							'rand' => esc_html__('Random', 'kickoff'), 
						)
					),
					'order'=> array(
						'title'=> esc_html__('Order' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'desc'=>esc_html__('Descending Order', 'kickoff'), 
							'asc'=> esc_html__('Ascending Order', 'kickoff'), 
						)
					),
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kickoff'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item', 'kickoff')
					),				
				)
			);
			// $page_builder['content-item']['options']['order_tracking'] = array(
				// 'title'=> esc_html__('Track Order', 'kickoff'), 
				// 'icon'=>'fa-truck',
				// 'type'=>'item',
				// 'options'=>  array(
					
					// 'order-status-pending'=> array(
						// 'title'=> esc_html__('Order Status Pending text' ,'kickoff'),
						// 'type'=> 'text',
						// 'description'=> esc_html__('Add custom text for if status is pending what user will see the status of order.', 'kickoff')
					// ),	
					// 'order-status-on-hold'=> array(
						// 'title'=> esc_html__('Order Status on-hold text' ,'kickoff'),
						// 'type'=> 'text',
						// 'description'=> esc_html__('Add custom text for if status is on-hold what user will see the status of order.', 'kickoff')
					// ),	
					// 'order-status-cancelled'=> array(
						// 'title'=> esc_html__('Order Status cancelled text' ,'kickoff'),
						// 'type'=> 'text',
						// 'description'=> esc_html__('Add custom text for if status is cancelled what user will see the status of order.', 'kickoff')
					// ),	
					// 'order-status-refunded'=> array(
						// 'title'=> esc_html__('Order Status refunded text' ,'kickoff'),
						// 'type'=> 'text',
						// 'description'=> esc_html__('Add custom text for if status is refunded what user will see the status of order.', 'kickoff')
					// ),	
					// 'order-status-processing'=> array(
						// 'title'=> esc_html__('Order Status In Progress Text' ,'kickoff'),
						// 'type'=> 'text',
						// 'description'=> esc_html__('Add custom text for if status is In Progress what user will see the status of order.', 'kickoff')
					// ),	
					// 'order-status-failed'=> array(
						// 'title'=> esc_html__('Order Status On Hold Text' ,'kickoff'),
						// 'type'=> 'text',
						// 'description'=> esc_html__('Add custom text for if status is On Hold what user will see the status of order.', 'kickoff')
					// ),	
					// 'order-status-completed'=> array(
						// 'title'=> esc_html__('Order Status Complete text' ,'kickoff'),
						// 'type'=> 'text',
						// 'description'=> esc_html__('Add custom text for if status is Complete what user will see the status of order.', 'kickoff')
					// ),	
					// 'margin-bottom' => array(
						// 'title' => esc_html__('Margin Bottom', 'kickoff'),
						// 'type' => 'text',
						// 'default' => '',
						// 'description' => esc_html__('Spaces after ending of this item', 'kickoff')
					// ),										
				// )
			// );	
			
			return $page_builder;
		}
	}
	
	
	
	
?>