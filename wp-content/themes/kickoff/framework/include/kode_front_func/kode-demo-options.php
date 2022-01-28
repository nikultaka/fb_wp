<?php
	/*	
	*	KodeForest Framework File
	*	---------------------------------------------------------------------
	*	This file contains the homepage loading button in page option area
	*	---------------------------------------------------------------------
	*/
	
	add_action('add_meta_boxes', 'kode_init_demo_page_option');
	if( !function_exists('kode_init_demo_page_option') ){
		function kode_init_demo_page_option(){
			add_meta_box( 'demo-page-option', 
				esc_html__('Load Demo Page', 'kickoff'), 
				'kode_create_demo_page_option',
				'page',
				'side',
				'default'
			);
		}
	}
	
	if( !function_exists('kode_create_demo_page_option') ){
		function kode_create_demo_page_option(){
			global $post;
		
			$buttons = array(
				'homepage-1' => esc_html__('Homepage 1', 'kickoff'),
			);
			echo '
			<div id="kode-save-settings" data-ajax="' . AJAX_URL . '" data-id="' . $post->ID . '" data-action="save_demo_pagebuilder">
				<input type="text" id="k-set-value" data-slug="custom_style_slug"/>
				<a class="kdf-button btn_save_set">'.esc_html__('Save Settings','kickoff').'</a>
			</div>';
			echo '<div class="custom-styles">';
				echo '<div class="panel-delete-sidebar"></div>';
				echo '<input type="hidden" id="kode-custom-style" />';
				echo '<input type="button" id="k_input_append" />';
			echo '</div>';
			echo '<div id="kode-load-demo" data-ajax="' . AJAX_URL . '" data-id="' . $post->ID . '" data-action="load_demo_pagebuilder">';
			echo '<em>';
			echo esc_html__('*This option allow you to set page item to following pages with one click. Note that to use this option will replace all your current page item setting in this page and <strong>This Can\'t Be Undone</strong>. ( Images are not included. )', 'kickoff');
			echo '</em><div class="clear"></div>';
			foreach( $buttons as $button_slug => $button_title ){
				echo '<input type="button" data-slug="' . $button_slug . '" value="' . $button_title . '" />';
			}
			$page_templates = get_option('page_templates');
			if(is_array($page_templates)){
				$data_slug = get_option('page_templates');
			}else{
				$data_slug = get_option('page_template');	
			}
			if(isset($data_slug['custom_style_slug'])){
				foreach($data_slug['custom_style_slug'] as $val){	
					$data_val = str_replace(' ','-',$val);
					$data_val = strtolower($data_val);			
					echo '
					<div class="custom-style">
						<div class="panel-delete-sidebar"></div>
						<input type="hidden" name="custom_style_slug[]" data-slug="custom_style_slug[]" value="'.esc_attr($val).'">
						<input type="button" id="k_input_append" value="'.esc_attr($val).'" data-slug="'.esc_attr($data_val).'">
					</div>';
				}
			}
			
			echo '</div>';

		}
	}

	
	add_action('wp_ajax_kode_delete_settings', 'kode_delete_settings');
	if( !function_exists('kode_delete_settings') ){
		function kode_delete_settings(){ 
		
			// $loaded_data = $default_data[$_POST['slug']];
			$count = 0;
			$value_array = array();
			$searcharray = array();
			if(isset($_POST['slug'])){
				if(isset($_POST['form_data'])){
					parse_str($_POST['form_data'], $searcharray);
					update_option('page_templates',$searcharray);
					// print_R($searcharray);
				}else{
					delete_option('page_template',$_POST['slug']);
				}
				parse_str($_POST['form_data'], $searcharray);
				foreach($searcharray['custom_style_slug'] as $val){
					delete_option($_POST['slug'].'_kode_content');	
				}
			}
		}
	}	
	
	
	
	add_action('wp_ajax_save_demo_pagebuilder', 'kode_save_demo_pagebuilder');
	if( !function_exists('kode_save_demo_pagebuilder') ){
		function kode_save_demo_pagebuilder(){ 
		
			// $loaded_data = $default_data[$_POST['slug']];
			$count = 0;
			$value_array = array();
			$searcharray = array();
			if(isset($_POST['slug'])){
				$value_array['kode_content'] = $_POST['kode_content'];
				$value_array['post_option'] = $_POST['post_option'];
				if(isset($_POST['form_data'])){
					parse_str($_POST['form_data'], $searcharray);
					update_option('page_templates',$searcharray);
					// print_R($searcharray);
				}else{
					update_option('page_template',$_POST['slug']);
				}
				update_option($_POST['slug'].'_kode_content',$value_array);				
			}
		}
	}	
		
	
	add_action('wp_ajax_load_demo_pagebuilder', 'kode_load_demo_pagebuilder');
	if( !function_exists('kode_load_demo_pagebuilder') ){
		function kode_load_demo_pagebuilder(){
			
			
			
			$default_data = array(
				'homepage-1' => array(
					'kode_content'=>'[{"item-type":"wrapper","item-builder-title":"Full Size Wrapper","type":"full-size-wrapper","items":[{"item-type":"item","item-builder-title":"Master Slider","type":"master-slider","option":{"page-item-id":"","id":"1","margin-bottom":"0px"}}],"option":{"page-item-id":"","background":"#ffffff","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"0px","padding-bottom":"0px"}},{"item-type":"wrapper","item-builder-title":"Background/Parallax Wrapper","type":"parallax-bg-wrapper","items":[{"item-type":"item","item-builder-title":"Title","type":"title","option":{"page-item-id":"","title-type":"center-divider","title":"The Amazing Wordpress Theme","caption":"Vestibulum id ligula porta felis euismod semper. Curabitur blandit tempus porttitor.","right-text":"Read All News","right-text-link":"","margin-bottom":"45px"}},{"item-type":"item","item-builder-title":"Image / Frame","type":"image-frame","option":{"page-item-id":"","image-id":"2808","thumbnail-size":"full","link-type":"none","url":"","frame-type":"none","frame-background":"#dddddd","margin-bottom":"0px"}}],"option":{"page-item-id":"","type":"image","background":"2745","background-speed":"0","pattern":"1","video":"","video-overlay":"0.5","video-player":"enable","skin":"no-skin","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"80px","padding-bottom":"0px"}},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"item","item-builder-title":"Title","type":"title","option":{"page-item-id":"","title-type":"center-divider","title":"Some Of Our Works","caption":"","right-text":"View All Works","right-text-link":"http://themes.goodlayers2.com/versatile/portfolio-modern-3-columns/","margin-bottom":"40px"}}],"option":{"page-item-id":"","background":"#2d2d2d","skin":"gdlr-skin-dark-skin","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"55px","padding-bottom":"5px"}},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"item","item-builder-title":"Portfolio","type":"portfolio","option":{"page-item-id":"","title-type":"none","title":"","caption":"","right-text":"Read All News","right-text-link":"","category":"","tag":"","portfolio-style":"modern-portfolio","num-fetch":"8","num-excerpt":"20","portfolio-size":"1/4","portfolio-layout":"carousel","portfolio-filter":"disable","thumbnail-size":"portfolio-portrait","orderby":"date","order":"desc","pagination":"disable","margin-bottom":"0px"}}],"option":{"page-item-id":"","background":"#eeeeee","skin":"no-skin","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"70px","padding-bottom":"5px"}},{"item-type":"wrapper","item-builder-title":"Background/Parallax Wrapper","type":"parallax-bg-wrapper","items":[{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-flag","title":"Sollicitudin Vestibulum","style":"type-2","content":"<p>Aenean lacinia bibendum nulla sed consectetur. Lm ipsum dolor sit amet, consectetur adipiscing elit. Donec sed odio dui. Nullam quis risus eget urnaoare.</p>","margin-bottom":"55px"}},{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-unlink","title":"Integer posuere erat","style":"type-2","content":"<p>Aenean lacinia bibendum nulla sed consectetur. Lm ipsum dolor sit amet, consectetur adipiscing elit. Donec sed odio dui. Nullam quis risus eget urnaoare.</p>","margin-bottom":"55px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-unlock-alt ","title":"Commodo Fringilla","style":"type-2","content":"<p>Aenean lacinia bibendum nulla sed consectetur. Lm ipsum dolor sit amet, consectetur adipiscing elit. Donec sed odio dui. Nullam quis risus eget urnaoare.</p>","margin-bottom":"55px"}},{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-location-arrow","title":"Pellentes Vestibulum ","style":"type-2","content":"<p>Aenean lacinia bibendum nulla sed consectetur. Lm ipsum dolor sit amet, consectetur adipiscing elit. Donec sed odio dui. Nullam quis risus eget urnaoare.</p>","margin-bottom":"55px"}}],"option":{},"size":"1/3"}],"option":{"page-item-id":"","type":"image","background":"2556","background-speed":"0","pattern":"1","video":"","video-overlay":"0.5","video-player":"enable","skin":"gdlr-skin-dark-skin","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"150px","padding-bottom":"85px"}},{"item-type":"wrapper","item-builder-title":"Full Size Wrapper","type":"full-size-wrapper","items":[{"item-type":"item","item-builder-title":"Title","type":"title","option":{"page-item-id":"","title-type":"center-divider","title":"Personnel Slider","caption":"","right-text":"Read All News","right-text-link":"","margin-bottom":"30px"}},{"item-type":"item","item-builder-title":"Master Slider","type":"master-slider","option":{"page-item-id":"","id":"10","margin-bottom":"20px"}}],"option":{"page-item-id":"","background":"#eeeeee","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"80px","padding-bottom":"40px"}},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-4","items":[{"item-type":"item","item-builder-title":"Skill Item","type":"skill-item","option":{"page-item-id":"","style":"normal","background":"#39dde3","text-color":"#ffffff","title":"120","caption":"Employees"}}],"option":{},"size":"1/4"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-4","items":[{"item-type":"item","item-builder-title":"Skill Item","type":"skill-item","option":{"page-item-id":"","style":"normal","background":"#39dde3","text-color":"#ffffff","title":"862","caption":"Finished Projects"}}],"option":{},"size":"1/4"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-4","items":[{"item-type":"item","item-builder-title":"Skill Item","type":"skill-item","option":{"page-item-id":"","style":"normal","background":"#ff3f3f","text-color":"#ffffff","title":"99%","caption":"Happy Clients"}}],"option":{},"size":"1/4"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-4","items":[{"item-type":"item","item-builder-title":"Skill Item","type":"skill-item","option":{"page-item-id":"","style":"normal","background":"#39dde3","text-color":"#ffffff","title":"954","caption":"Fanpage Likes"}}],"option":{},"size":"1/4"}],"option":{"page-item-id":"","background":"#ffffff","skin":"no-skin","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"75px","padding-bottom":"45px"}},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"item","item-builder-title":"Title","type":"title","option":{"page-item-id":"","title-type":"center-divider","title":"Sem Lorem Fermentum","caption":"","right-text":"Read All News","right-text-link":"","margin-bottom":"60px"}},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-2","items":[{"item-type":"item","item-builder-title":"Service With Image","type":"service-with-image","option":{"page-item-id":"","image":"2518","thumbnail-size":"full","align":"left","title":"Dolor Quam Amet","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem..</p>","margin-bottom":"45px"}},{"item-type":"item","item-builder-title":"Service With Image","type":"service-with-image","option":{"page-item-id":"","image":"2516","thumbnail-size":"full","align":"left","title":"Tortor Quam Cursus Etiam","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem..</p>","margin-bottom":"45px"}}],"option":{},"size":"1/2"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-2","items":[{"item-type":"item","item-builder-title":"Service With Image","type":"service-with-image","option":{"page-item-id":"","image":"2519","thumbnail-size":"full","align":"left","title":"Risus Consectetur Euismod","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem..</p>","margin-bottom":"45px"}},{"item-type":"item","item-builder-title":"Service With Image","type":"service-with-image","option":{"page-item-id":"","image":"2520","thumbnail-size":"full","align":"left","title":"Fermentum Porta","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem..</p>","margin-bottom":"45px"}}],"option":{},"size":"1/2"}],"option":{"page-item-id":"","background":"#f7f7f7","skin":"no-skin","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"85px","padding-bottom":"30px"}},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-off","title":"Dolor Quam Amet","style":"type-1","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur.</p>","margin-bottom":"25px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-list-ul","title":"Tristique Ipsum","style":"type-1","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur.</p>","margin-bottom":"25px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-star","title":"Nullam Fringilla Male","style":"type-1","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur.</p>","margin-bottom":"25px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-gift","title":"Vehicula Fermentum","style":"type-1","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur.</p>","margin-bottom":"25px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-home","title":"Cras Pellentesque Risus","style":"type-1","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur.</p>","margin-bottom":"25px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Column Service","type":"column-service","option":{"page-item-id":"","icon":"icon-signal","title":"Consectetur Dapibus","style":"type-1","content":"<p>Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur.</p>","margin-bottom":"25px"}}],"option":{},"size":"1/3"}],"option":{"page-item-id":"","background":"#ffffff","skin":"gdlr-skin-light-grey","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"90px","padding-bottom":"25px"}},{"item-type":"wrapper","item-builder-title":"Background/Parallax Wrapper","type":"parallax-bg-wrapper","items":[{"item-type":"item","item-builder-title":"Blog","type":"blog","option":{"page-item-id":"","title-type":"center-divider","title":"Latest News","caption":"","right-text":"Read All News","right-text-link":"http://themes.goodlayers2.com/versatile/blog-full-with-right-sidebar/","category":"","tag":"","num-excerpt":"25","num-fetch":"6","blog-style":"blog-1-3","blog-layout":"carousel","thumbnail-size":"blog-grid","orderby":"date","order":"desc","offset":"","pagination":"disable","enable-sticky":"disable","margin-bottom":"0px"}}],"option":{"page-item-id":"","type":"image","background":"2592","background-speed":"0.2","pattern":"1","video":"","video-overlay":"0.5","video-player":"enable","skin":"no-skin","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"80px","padding-bottom":"0px"}},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Content","type":"content","option":{"page-item-id":"","title-type":"none","title":"","caption":"","right-text":"Read All News","right-text-link":"","content":"","margin-bottom":"5px"}},{"item-type":"item","item-builder-title":"Image / Frame","type":"image-frame","option":{"page-item-id":"","image-id":"2522","thumbnail-size":"full","link-type":"none","url":"","frame-type":"none","frame-background":"#dddddd","margin-bottom":"65px"}}],"option":{},"size":"1/3"},{"item-type":"wrapper","item-builder-title":"Column Item","type":"column1-3","items":[{"item-type":"item","item-builder-title":"Content","type":"content","option":{"page-item-id":"","title-type":"none","title":"","caption":"","right-text":"Read All News","right-text-link":"","content":"","margin-bottom":"40px"}},{"item-type":"item","item-builder-title":"Accordion","type":"accordion","option":{"page-item-id":"","accordion":"[{|gq2|gdl-tab-title|gq2|:|gq2|Vestibulum Fringilla Adipiscing Pharetra|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Duis mollis, est non commodo luctus, nisi era. Cras justo odio, dapibus ac facilisis in, egestas eget.|gq2|},{|gq2|gdl-tab-title|gq2|:|gq2|Dapibus Adipiscing Parturient Nibh|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Duis mollis, est non commodo luctus, nisi era. Cras justo odio, dapibus ac facilisis in, egestas eget.|gq2|},{|gq2|gdl-tab-title|gq2|:|gq2|Risus Ultricies Commodo Vehicula Ullamcorper|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Duis mollis, est non commodo luctus, nisi era. Cras justo odio, dapibus ac facilisis in, egestas eget.|gq2|},{|gq2|gdl-tab-title|gq2|:|gq2|Mattis Consectetur Egestas Ullamcorper|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Duis mollis, est non commodo luctus, nisi era. Cras justo odio, dapibus ac facilisis in, egestas eget.|gq2|},{|gq2|gdl-tab-title|gq2|:|gq2|Etiam Euismod Tellus Cras|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Sed posuere consectetur est at lobortis. Duis mollis, est non commodo luctus, nisi era. Cras justo odio, dapibus ac facilisis in, egestas eget.|gq2|}]","title-type":"left","title":"Fusce Consectetur Venenatis","caption":"","initial-state":"1","style":"style-1","margin-bottom":"50px"}}],"option":{},"size":"2/3"},{"item-type":"wrapper","item-builder-title":"Color Wrapper","type":"color-wrapper","items":[{"item-type":"item","item-builder-title":"Testimonial","type":"testimonial","option":{"page-item-id":"","testimonial":"[{|gq2|gdl-tab-author-image-url|gq2|:|gq2||gq2|,|gq2|gdl-tab-author-image|gq2|:|gq2||gq2|,|gq2|gdl-tab-title|gq2|:|gq2|John Doe|gq2|,|gq2|gdl-tab-position|gq2|:|gq2|Architecture|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|Sed posuere consectetur est at lobortis. Donec id elit non mi porta gravida at eget metus. Aenean lacinia bibendum nulla c|g2n|onsectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Duis mollis, est non commodo luctus.|gq2|},{|gq2|gdl-tab-author-image-url|gq2|:|gq2||gq2|,|gq2|gdl-tab-author-image|gq2|:|gq2||gq2|,|gq2|gdl-tab-title|gq2|:|gq2|Jane Smith|gq2|,|gq2|gdl-tab-position|gq2|:|gq2|Accountant|gq2|,|gq2|gdl-tab-content|gq2|:|gq2||g2n|Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna.|g2n|Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Fusce dapibus, tellus ac cursus commodo, tortor mauris.|gq2|},{|gq2|gdl-tab-author-image-url|gq2|:|gq2||gq2|,|gq2|gdl-tab-author-image|gq2|:|gq2||gq2|,|gq2|gdl-tab-title|gq2|:|gq2|Paul Smith|gq2|,|gq2|gdl-tab-position|gq2|:|gq2|Engineer|gq2|,|gq2|gdl-tab-content|gq2|:|gq2|Sed posuere consectetur est at lobortis. Donec id elit non mi porta gravida at eget metus. Aenean lacinia bibendum nulla c|g2n|onsectetur. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Duis mollis, est non commodo luctus.|gq2|}]","title-type":"center","title":"Testimonial","caption":"","testimonial-columns":"1","testimonial-type":"carousel","testimonial-style":"large plain-style","margin-bottom":"20px"}}],"option":{"page-item-id":"","background":"#f7f7f7","skin":"no-skin","border":"none","border-top-color":"#e9e9e9","border-bottom-color":"#e9e9e9","padding-top":"80px","padding-bottom":"50px"}},{"item-type":"item","item-builder-title":"Banner","type":"banner","option":{"page-item-id":"","slider":"[[2523,2524,2525,2526,2527,2528,2529],{|gq2|2523|gq2|:{|gq2|title|gq2|:|gq2||gq2|,|gq2|caption|gq2|:|gq2||gq2|,|gq2|caption-position|gq2|:|gq2||gq2|,|gq2|slide-link|gq2|:|gq2||gq2|,|gq2|url|gq2|:|gq2||gq2|,|gq2|new-tab|gq2|:|gq2|enable|gq2|,|gq2|thumbnail|gq2|:|gq2|http://themes.goodlayers2.com/versatile/wp-content/uploads/2014/05/banner-2-150x33.png|gq2|,|gq2|width|gq2|:150,|gq2|height|gq2|:33},|gq2|2524|gq2|:{|gq2|title|gq2|:|gq2||gq2|,|gq2|caption|gq2|:|gq2||gq2|,|gq2|caption-position|gq2|:|gq2||gq2|,|gq2|slide-link|gq2|:|gq2||gq2|,|gq2|url|gq2|:|gq2||gq2|,|gq2|new-tab|gq2|:|gq2|enable|gq2|,|gq2|thumbnail|gq2|:|gq2|http://themes.goodlayers2.com/versatile/wp-content/uploads/2014/05/banner-3-150x37.png|gq2|,|gq2|width|gq2|:150,|gq2|height|gq2|:37},|gq2|2525|gq2|:{|gq2|title|gq2|:|gq2||gq2|,|gq2|caption|gq2|:|gq2||gq2|,|gq2|caption-position|gq2|:|gq2||gq2|,|gq2|slide-link|gq2|:|gq2||gq2|,|gq2|url|gq2|:|gq2||gq2|,|gq2|new-tab|gq2|:|gq2|enable|gq2|,|gq2|thumbnail|gq2|:|gq2|http://themes.goodlayers2.com/versatile/wp-content/uploads/2014/05/banner-4-150x28.png|gq2|,|gq2|width|gq2|:150,|gq2|height|gq2|:28},|gq2|2526|gq2|:{|gq2|title|gq2|:|gq2||gq2|,|gq2|caption|gq2|:|gq2||gq2|,|gq2|caption-position|gq2|:|gq2||gq2|,|gq2|slide-link|gq2|:|gq2||gq2|,|gq2|url|gq2|:|gq2||gq2|,|gq2|new-tab|gq2|:|gq2|enable|gq2|,|gq2|thumbnail|gq2|:|gq2|http://themes.goodlayers2.com/versatile/wp-content/uploads/2014/05/banner-5-150x47.png|gq2|,|gq2|width|gq2|:150,|gq2|height|gq2|:47},|gq2|2527|gq2|:{|gq2|title|gq2|:|gq2||gq2|,|gq2|caption|gq2|:|gq2||gq2|,|gq2|caption-position|gq2|:|gq2||gq2|,|gq2|slide-link|gq2|:|gq2||gq2|,|gq2|url|gq2|:|gq2||gq2|,|gq2|new-tab|gq2|:|gq2|enable|gq2|,|gq2|thumbnail|gq2|:|gq2|http://themes.goodlayers2.com/versatile/wp-content/uploads/2014/05/banner-6-150x38.png|gq2|,|gq2|width|gq2|:150,|gq2|height|gq2|:38},|gq2|2528|gq2|:{|gq2|title|gq2|:|gq2||gq2|,|gq2|caption|gq2|:|gq2||gq2|,|gq2|caption-position|gq2|:|gq2||gq2|,|gq2|slide-link|gq2|:|gq2||gq2|,|gq2|url|gq2|:|gq2||gq2|,|gq2|new-tab|gq2|:|gq2|enable|gq2|,|gq2|thumbnail|gq2|:|gq2|http://themes.goodlayers2.com/versatile/wp-content/uploads/2014/05/banner-7-150x27.png|gq2|,|gq2|width|gq2|:150,|gq2|height|gq2|:27},|gq2|2529|gq2|:{|gq2|title|gq2|:|gq2||gq2|,|gq2|caption|gq2|:|gq2||gq2|,|gq2|caption-position|gq2|:|gq2||gq2|,|gq2|slide-link|gq2|:|gq2||gq2|,|gq2|url|gq2|:|gq2||gq2|,|gq2|new-tab|gq2|:|gq2|enable|gq2|,|gq2|thumbnail|gq2|:|gq2|http://themes.goodlayers2.com/versatile/wp-content/uploads/2014/05/banner-1-150x36.png|gq2|,|gq2|width|gq2|:150,|gq2|height|gq2|:36}}]","thumbnail-size":"full","banner-columns":"5","margin-bottom":"45px"}}]',
					'post-option'=>'{"sidebar":"no-sidebar","left-sidebar":"Footer 1","right-sidebar":"Footer 1","page-style":"normal","show-title":"disable","page-caption":"","show-content":"disable","header-background":"","header-style":"transparent"}'
				),
			);
			
			$default_data = array();
			$templates = get_option('page_templates');
			foreach($templates['custom_style_slug'] as $val){
				$val = str_replace(' ','-',$val);
				$val = strtolower($val);
				$template = get_option($val.'_kode_content');
				$default_data[$val]['kode_content'] = kode_stopbackslashes(kode_stripslashes($template['kode_content']));
				$default_data[$val]['post-option'] = kode_stopbackslashes(kode_stripslashes($template['post_option']));		
			}	
			
			$loaded_data = $default_data[$_POST['slug']];
			foreach( $loaded_data as $meta_key => $meta_value ){
				update_post_meta($_POST['post_id'], $meta_key, $meta_value);
			}
		}
	}
?>