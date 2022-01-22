<?php
	/*	
	*	Kodeforest Admin Panel
	*	---------------------------------------------------------------------
	*	This file create the class that help you create the controls admin  
	*	option for custom theme
	*	---------------------------------------------------------------------
	*/	
	
	$kode_countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
	
	if( !class_exists('kode_generate_admin_html') ){
		
		class kode_generate_admin_html{
			
			// decide to generate each option by type
			function kode_generate_html($settings = array()){
				echo '<div class="kode-option-wrapper ';
				echo (isset($settings['wrapper-class']))? $settings['wrapper-class'] : '';
				echo '">';
				
				$description_class = empty($settings['description'])? '': 'with-description';
				echo '<div class="kode-option ' . esc_attr($description_class) . '">';
				
				// option title
				if( !empty($settings['title']) ){
					echo '<div class="kode-option-title">' . esc_attr($settings['title']) . '</div>';
				}
				
				// input option
				switch ($settings['type']){
					case 'text': $this->show_text_input($settings); break;
					case 'server-config': $this->show_simple_text($settings); break;
					case 'import-first': $this->kode_show_importer_first_default($settings); break;
					case 'export-widgets': $this->kode_show_export_widgets($settings); break;
					case 'importer': $this->kode_show_importer($settings); break;
					case 'default-importer': $this->kode_show_importer_default($settings); break;
					case 'textarea': $this->show_textarea($settings); break;
					case 'combobox': $this->show_combobox($settings); break;					
					case 'combobox_sidebar': $this->show_combobox_sidebar($settings); break;					
					case 'multi-combobox': $this->show_multi_combobox($settings); break;
					case 'checkbox': $this->show_checkbox($settings); break;
					case 'radioimage': $this->show_radio_image($settings); break;
					case 'radioheader': $this->show_radio_header_image($settings); break;
					case 'colorpicker': $this->show_color_picker($settings); break;					
					case 'sliderbar': $this->show_slider_bar($settings); break;
					case 'slider': $this->show_slider($settings); break;
					case 'gallery': $this->show_gallery($settings); break;
					case 'sidebar': $this->kode_show_sidebar_data($settings); break;
					case 'font_option': $this->print_font_combobox($settings); break;
					case 'upload': $this->show_upload_box($settings); break;
					case 'header': $this->show_header_box($settings); break;
					case 'custom': $this->show_custom_option($settings); break;
					case 'player-lineup': $this->show_players_lineup($settings); break;
					case 'player-lineup-second': $this->show_players_lineup_second($settings); break;
					
					case 'date-picker': $this->show_date_picker($settings); break;
				}
				
				// input descirption
				if( !empty($settings['description']) ){
					echo '<div class="kode-input-description"><span>' . esc_attr($settings['description']) . '<span></div>';
					echo '<div class="clear"></div>';
				}
				
				echo '</div>'; // kode-option
				echo '</div>'; // kode-option-wrapper				
			}
			
			function show_players_lineup($settings = array()){
				$option_value = kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
				if( !empty($option_value) ){
					$option_value = json_decode( $option_value, true );					
				}
				
				echo '<div class="kode-option-input">';
				echo '<div class="kode-player-tabs">
				<table class="kode-table">
					<thead>
					<tr>
						<th>Select</th>
						<th class="player-name-sec">Player</th>
						<th>Goals</th>
						<th>Assist</th>
						<th>OG</th>
						<th>Penalty</th>
						<th>Pos</th>
						<th>YC</th>
						<th>RC</th>
						<th>POTM</th>
					</tr>
				</thead>	
				<tbody>';
					// while($query->have_posts()) :
						// $query->the_post();
					$args = array('post_type'=>'player', 'posts_per_page' => -1);
					$posts = get_posts($args);
					foreach($posts as $post){
						
						$selected_team_id = get_post_meta($post->ID,'select_national',true);
						if(!empty($option_value['select_team_first'])){
							if($option_value['select_team_first'] == $selected_team_id){
								$player_pos = '';
								if(!empty($option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)])){
									$player_pos = $option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)];						
								}
								
								$player_sel = '';
								if(!empty($option_value[$settings['slug'].'-player-'.esc_attr($post->ID)])){
									$player_sel = $option_value[$settings['slug'].'-player-'.esc_attr($post->ID)];
								}
								$player_selected = '';
								if($player_sel == 'enable'){
									$player_selected = 'checked';
								}
								$player_goal = '';
								if(!empty($option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)])){
									$player_goal = $option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)];						
								}
								$player_goal_assit = '';
								if(!empty($option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)])){
									$player_goal_assit = $option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)];						
								}
								$player_own_goal = '';
								if(!empty($option_value[$settings['slug'].'-og-'.esc_attr($post->ID)])){
									$player_own_goal = $option_value[$settings['slug'].'-og-'.esc_attr($post->ID)];						
								}
								$player_penalty = '';
								if(!empty($option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)])){
									$player_penalty = $option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)];						
								}
								$player_yellow = '';
								if(!empty($option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)])){
									$player_yellow = $option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)];						
								}
								$player_red = '';
								if(!empty($option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)])){
									$player_red = $option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)];
								}
								
								$player_om = 'off';
								if(isset($option_value[$settings['slug'].'-pom']) && $option_value[$settings['slug'].'-pom'] == $settings['slug'].'-pom-'.esc_attr($post->ID)){
									$player_om = 'checked';
								}
								
								
								
								// Ailier Gauche / Left winger
								// Ailier Droit / Right Winger
								// Gardien de but / Goalkeeper
								// Arrière Gauche / Left Back
								// Arrière Droit / Right Back
								// Pivot / Centre midfielder
								// Demi centre / Centre back
								
								echo '<tr class="player-row">
									<td><input type="checkbox" '.esc_attr($player_selected).' class="player_selected" name="'.$settings['slug'].'-player-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-player-'.esc_attr($post->ID).'" /></td>
									<td>'.esc_attr($post->post_title).'<input type="hidden" value="'.$post->ID.'" name="'.$settings['slug'].'-name-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-name-'.esc_attr($post->ID).'" /> </td>
									<td><input disabled="disabled" type="text" title="Goals" name="'.$settings['slug'].'-pg-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-pg-'.esc_attr($post->ID).'" value="'.$player_goal.'" /></td>
									<td><input disabled="disabled" type="text" title="Assit" name="'.$settings['slug'].'-ag-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-ag-'.esc_attr($post->ID).'" value="'.$player_goal_assit.'" /></td>
									<td><input disabled="disabled" type="text" title="Own Goal" name="'.$settings['slug'].'-og-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-og-'.esc_attr($post->ID).'" value="'.$player_own_goal.'" /></td>
									<td><input disabled="disabled" type="text" title="Penalty" name="'.$settings['slug'].'-ps-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-ps-'.esc_attr($post->ID).'" value="'.$player_penalty.'" /></td>
									<td>
									<select disabled="disabled" class="select-pos" name="'.$settings['slug'].'-pos-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-pos-'.esc_attr($post->ID).'">
										<option '.(($player_pos=='no-pos')?'selected="selected"':"").' value="no-pos">No Pos</option>
										<option '.(($player_pos=='GK')?'selected="selected"':"").' value="GK">GK</option>
										<option '.(($player_pos=='LB')?'selected="selected"':"").' value="LB">LB</option>
										<option '.(($player_pos=='LWB')?'selected="selected"':"").' value="LWB">LWB</option>
										<option '.(($player_pos=='CB')?'selected="selected"':"").' value="CB">CB</option>
										<option '.(($player_pos=='RB')?'selected="selected"':"").' value="RB">RB</option>
										<option '.(($player_pos=='RWB')?'selected="selected"':"").' value="RWB">RWB</option>
										<option '.(($player_pos=='LM')?'selected="selected"':"").' value="LM">LM</option>
										<option '.(($player_pos=='CM')?'selected="selected"':"").' value="CM">CM</option>
										<option '.(($player_pos=='CDM')?'selected="selected"':"").' value="CDM">CDM</option>
										<option '.(($player_pos=='RM')?'selected="selected"':"").' value="RM">RM</option>
										<option '.(($player_pos=='LW')?'selected="selected"':"").' value="LW">LW</option>
										<option '.(($player_pos=='RW')?'selected="selected"':"").' value="RW">RW</option>
										<option '.(($player_pos=='LF')?'selected="selected"':"").' value="LF">LF</option>
										<option '.(($player_pos=='CF')?'selected="selected"':"").' value="CF">CF</option>
										<option '.(($player_pos=='RF')?'selected="selected"':"").' value="RF">RF</option>
										<option '.(($player_pos=='ST')?'selected="selected"':"").' value="ST">ST</option>
										
										<option '.(($player_pos=='Ailier Gauche')?'selected="selected"':"").' value="Ailier Gauche">'.esc_attr__('Ailier Gauche','kickoff').'</option>
										<option '.(($player_pos=='Ailier Droit')?'selected="selected"':"").' value="Ailier Droit">'.esc_attr__('Ailier Droit','kickoff').'</option>
										<option '.(($player_pos=='Gardien de but')?'selected="selected"':"").' value="Gardien de but">'.esc_attr__('Gardien de but','kickoff').'</option>
										<option '.(($player_pos=='Arrière Gauche')?'selected="selected"':"").' value="Arrière Gauche">'.esc_attr__('Arrière Gauche','kickoff').'</option>
										<option '.(($player_pos=='Arrière Droit')?'selected="selected"':"").' value="Arrière Droit">'.esc_attr__('Arrière Droit','kickoff').'</option>
										<option '.(($player_pos=='Pivot')?'selected="selected"':"").' value="Pivot">'.esc_attr__('Pivot','kickoff').'</option>
										<option '.(($player_pos=='Demi centre')?'selected="selected"':"").' value="Demi centre">'.esc_attr__('Demi centre','kickoff').'</option>
										<option '.(($player_pos=='Left winger')?'selected="selected"':"").' value="Left winger">'.esc_attr__('Left winger','kickoff').'</option>
										<option '.(($player_pos=='Right winger')?'selected="selected"':"").' value="Right winger">'.esc_attr__('Right winger','kickoff').'</option>
										<option '.(($player_pos=='Goalkeeper')?'selected="selected"':"").' value="Goalkeeper">'.esc_attr__('Goalkeeper','kickoff').'</option>
										<option '.(($player_pos=='Left Back')?'selected="selected"':"").' value="Left Back">'.esc_attr__('Left Back','kickoff').'</option>
										<option '.(($player_pos=='Right Back')?'selected="selected"':"").' value="Right Back">'.esc_attr__('Right Back','kickoff').'</option>
										<option '.(($player_pos=='Centre midfielder')?'selected="selected"':"").' value="Centre midfielder">'.esc_attr__('Centre midfielder','kickoff').'</option>
										<option '.(($player_pos=='Centre back')?'selected="selected"':"").' value="Centre back">'.esc_attr__('Centre back','kickoff').'</option>
									</select>
									</td>
									<td><input disabled="disabled" type="text" title="Yellow Card" name="'.$settings['slug'].'-yc-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-yc-'.esc_attr($post->ID).'" value="'.$player_yellow.'" /></td>
									<td><input disabled="disabled" type="text" title="Red Card" name="'.$settings['slug'].'-rc-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-rc-'.esc_attr($post->ID).'" value="'.$player_red.'" /></td>
									<td><input disabled="disabled" '.esc_attr($player_om).' type="radio" title="player of the match" name="'.esc_attr($settings['slug']).'-pom" data-slug="'.esc_attr($settings['slug']).'-pom" value="'.esc_attr($settings['slug']).'-pom-'.esc_attr($post->ID).'" /></td>
								</tr>';
							}
						}else{
							
							$player_pos = '';
							if(!empty($option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)])){
								$player_pos = $option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)];						
							}
							
							$player_sel = '';
							if(!empty($option_value[$settings['slug'].'-player-'.esc_attr($post->ID)])){
								$player_sel = $option_value[$settings['slug'].'-player-'.esc_attr($post->ID)];
							}
							$player_selected = '';
							if($player_sel == 'enable'){
								$player_selected = 'checked';
							}
							$player_goal = '';
							if(!empty($option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)])){
								$player_goal = $option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)];						
							}
							$player_goal_assit = '';
							if(!empty($option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)])){
								$player_goal_assit = $option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)];						
							}
							$player_own_goal = '';
							if(!empty($option_value[$settings['slug'].'-og-'.esc_attr($post->ID)])){
								$player_own_goal = $option_value[$settings['slug'].'-og-'.esc_attr($post->ID)];						
							}
							$player_penalty = '';
							if(!empty($option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)])){
								$player_penalty = $option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)];						
							}
							$player_yellow = '';
							if(!empty($option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)])){
								$player_yellow = $option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)];						
							}
							$player_red = '';
							if(!empty($option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)])){
								$player_red = $option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)];
							}
							
							$player_om = 'off';
							if(isset($option_value[$settings['slug'].'-pom']) && $option_value[$settings['slug'].'-pom'] == $settings['slug'].'-pom-'.esc_attr($post->ID)){
								$player_om = 'checked';
							}
							
							
							echo '<tr class="player-row">
								<td><input type="checkbox" '.esc_attr($player_selected).' class="player_selected" name="'.$settings['slug'].'-player-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-player-'.esc_attr($post->ID).'" /></td>
								<td>'.esc_attr($post->post_title).'<input type="hidden" value="'.$post->ID.'" name="'.$settings['slug'].'-name-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-name-'.esc_attr($post->ID).'" /> </td>
								<td><input disabled="disabled" type="text" title="Goals" name="'.$settings['slug'].'-pg-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-pg-'.esc_attr($post->ID).'" value="'.$player_goal.'" /></td>
								<td><input disabled="disabled" type="text" title="Assit" name="'.$settings['slug'].'-ag-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-ag-'.esc_attr($post->ID).'" value="'.$player_goal_assit.'" /></td>
								<td><input disabled="disabled" type="text" title="Own Goal" name="'.$settings['slug'].'-og-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-og-'.esc_attr($post->ID).'" value="'.$player_own_goal.'" /></td>
								<td><input disabled="disabled" type="text" title="Penalty" name="'.$settings['slug'].'-ps-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-ps-'.esc_attr($post->ID).'" value="'.$player_penalty.'" /></td>
								<td>
								<select disabled="disabled" class="select-pos" name="'.$settings['slug'].'-pos-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-pos-'.esc_attr($post->ID).'">
									<option '.(($player_pos=='no-pos')?'selected="selected"':"").' value="no-pos">No Pos</option>
									<option '.(($player_pos=='GK')?'selected="selected"':"").' value="GK">GK</option>
									<option '.(($player_pos=='LB')?'selected="selected"':"").' value="LB">LB</option>
									<option '.(($player_pos=='LWB')?'selected="selected"':"").' value="LWB">LWB</option>
									<option '.(($player_pos=='CB')?'selected="selected"':"").' value="CB">CB</option>
									<option '.(($player_pos=='RB')?'selected="selected"':"").' value="RB">RB</option>
									<option '.(($player_pos=='RWB')?'selected="selected"':"").' value="RWB">RWB</option>
									<option '.(($player_pos=='LM')?'selected="selected"':"").' value="LM">LM</option>
									<option '.(($player_pos=='CM')?'selected="selected"':"").' value="CM">CM</option>
									<option '.(($player_pos=='CDM')?'selected="selected"':"").' value="CDM">CDM</option>
									<option '.(($player_pos=='RM')?'selected="selected"':"").' value="RM">RM</option>
									<option '.(($player_pos=='LW')?'selected="selected"':"").' value="LW">LW</option>
									<option '.(($player_pos=='RW')?'selected="selected"':"").' value="RW">RW</option>
									<option '.(($player_pos=='LF')?'selected="selected"':"").' value="LF">LF</option>
									<option '.(($player_pos=='CF')?'selected="selected"':"").' value="CF">CF</option>
									<option '.(($player_pos=='RF')?'selected="selected"':"").' value="RF">RF</option>
									<option '.(($player_pos=='ST')?'selected="selected"':"").' value="ST">ST</option>
									
									<option '.(($player_pos=='Ailier Gauche')?'selected="selected"':"").' value="Ailier Gauche">'.esc_attr__('Ailier Gauche','kickoff').'</option>
									<option '.(($player_pos=='Ailier Droit')?'selected="selected"':"").' value="Ailier Droit">'.esc_attr__('Ailier Droit','kickoff').'</option>
									<option '.(($player_pos=='Gardien de but')?'selected="selected"':"").' value="Gardien de but">'.esc_attr__('Gardien de but','kickoff').'</option>
									<option '.(($player_pos=='Arrière Gauche')?'selected="selected"':"").' value="Arrière Gauche">'.esc_attr__('Arrière Gauche','kickoff').'</option>
									<option '.(($player_pos=='Arrière Droit')?'selected="selected"':"").' value="Arrière Droit">'.esc_attr__('Arrière Droit','kickoff').'</option>
									<option '.(($player_pos=='Pivot')?'selected="selected"':"").' value="Pivot">'.esc_attr__('Pivot','kickoff').'</option>
									<option '.(($player_pos=='Demi centre')?'selected="selected"':"").' value="Demi centre">'.esc_attr__('Demi centre','kickoff').'</option>
									<option '.(($player_pos=='Left winger')?'selected="selected"':"").' value="Left winger">'.esc_attr__('Left winger','kickoff').'</option>
									<option '.(($player_pos=='Right winger')?'selected="selected"':"").' value="Right winger">'.esc_attr__('Right winger','kickoff').'</option>
									<option '.(($player_pos=='Goalkeeper')?'selected="selected"':"").' value="Goalkeeper">'.esc_attr__('Goalkeeper','kickoff').'</option>
									<option '.(($player_pos=='Left Back')?'selected="selected"':"").' value="Left Back">'.esc_attr__('Left Back','kickoff').'</option>
									<option '.(($player_pos=='Right Back')?'selected="selected"':"").' value="Right Back">'.esc_attr__('Right Back','kickoff').'</option>
									<option '.(($player_pos=='Centre midfielder')?'selected="selected"':"").' value="Centre midfielder">'.esc_attr__('Centre midfielder','kickoff').'</option>
									<option '.(($player_pos=='Centre back')?'selected="selected"':"").' value="Centre back">'.esc_attr__('Centre back','kickoff').'</option>
								</select>
								</td>
								<td><input disabled="disabled" type="text" title="Yellow Card" name="'.$settings['slug'].'-yc-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-yc-'.esc_attr($post->ID).'" value="'.$player_yellow.'" /></td>
								<td><input disabled="disabled" type="text" title="Red Card" name="'.$settings['slug'].'-rc-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-rc-'.esc_attr($post->ID).'" value="'.$player_red.'" /></td>
								<td><input disabled="disabled" '.esc_attr($player_om).' type="radio" title="player of the match" name="'.esc_attr($settings['slug']).'-pom" data-slug="'.esc_attr($settings['slug']).'-pom" value="'.esc_attr($settings['slug']).'-pom-'.esc_attr($post->ID).'" /></td>
							</tr>';
						}						
					} wp_reset_postdata();
					
				echo '
				<tbody>
				</table></div></div>';
				wp_reset_query();
				
			}
			
			
			function show_players_lineup_second($settings = array()){
				$option_value = kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));				
				if( !empty($option_value) ){
					$option_value = json_decode( $option_value, true );					
				}

				echo '<div class="kode-option-input">';
				echo '<div class="kode-player-tabs">
				<table class="kode-table">
					<thead>
					<tr>
						<th>Select</th>
						<th class="player-name-sec">Player</th>
						<th>Goals</th>
						<th>Assist</th>
						<th>OG</th>
						<th>Penalty</th>
						<th>Pos</th>
						<th>YC</th>
						<th>RC</th>
						<th>POTM</th>
					</tr>
				</thead>	
				<tbody>';
					$args = array('post_type'=>'player', 'posts_per_page' => -1);
					$posts = get_posts($args);
					foreach($posts as $post){
						
						$selected_team_id = get_post_meta($post->ID,'select_national',true);
						if(!empty($option_value['select_team_second'])){
							if($option_value['select_team_second'] == $selected_team_id){
								$player_pos = '';
								if(!empty($option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)])){
									$player_pos = $option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)];						
								}
								
								$player_sel = '';
								if(!empty($option_value[$settings['slug'].'-player-'.esc_attr($post->ID)])){
									$player_sel = $option_value[$settings['slug'].'-player-'.esc_attr($post->ID)];
								}
								$player_selected = '';
								if($player_sel == 'enable'){
									$player_selected = 'checked';
								}
								$player_goal = '';
								if(!empty($option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)])){
									$player_goal = $option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)];						
								}
								$player_goal_assit = '';
								if(!empty($option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)])){
									$player_goal_assit = $option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)];						
								}
								$player_own_goal = '';
								if(!empty($option_value[$settings['slug'].'-og-'.esc_attr($post->ID)])){
									$player_own_goal = $option_value[$settings['slug'].'-og-'.esc_attr($post->ID)];						
								}
								$player_penalty = '';
								if(!empty($option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)])){
									$player_penalty = $option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)];						
								}
								$player_yellow = '';
								if(!empty($option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)])){
									$player_yellow = $option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)];						
								}
								$player_red = '';
								if(!empty($option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)])){
									$player_red = $option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)];
								}
								
								$player_om = 'off';
								if(isset($option_value[$settings['slug'].'-pom']) && $option_value[$settings['slug'].'-pom'] == $settings['slug'].'-pom-'.esc_attr($post->ID)){
									$player_om = 'checked';
								}
								
								
								echo '
								<div class="notice-info"></div>
								<div class="kode-player-loader"></div>
								
								<tr class="player-row">
									<td><input type="checkbox" '.esc_attr($player_selected).' class="player_selected" name="'.esc_attr($settings['slug']).'-player-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-player-'.esc_attr($post->ID).'" /></td>
									<td>'.esc_attr($post->post_title).'<input type="hidden" value="'.$post->ID.'" name="'.$settings['slug'].'-name-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-name-'.esc_attr($post->ID).'" /> </td>
									<td><input disabled="disabled" type="text" title="Goals" name="'.esc_attr($settings['slug']).'-pg-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-pg-'.esc_attr($post->ID).'" value="'.esc_attr($player_goal).'" /></td>
									<td><input disabled="disabled" type="text" title="Assit" name="'.esc_attr($settings['slug']).'-ag-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-ag-'.esc_attr($post->ID).'" value="'.esc_attr($player_goal_assit).'" /></td>
									<td><input disabled="disabled" type="text" title="Own Goal" name="'.esc_attr($settings['slug']).'-og-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-og-'.esc_attr($post->ID).'" value="'.esc_attr($player_own_goal).'" /></td>
									<td><input disabled="disabled" type="text" title="Penalty" name="'.esc_attr($settings['slug']).'-ps-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-ps-'.esc_attr($post->ID).'" value="'.esc_attr($player_penalty).'" /></td>
									<td>
									<select disabled="disabled" class="select-pos" name="'.esc_attr($settings['slug']).'-pos-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-pos-'.esc_attr($post->ID).'">
										<option '.(($player_pos=='no-pos')?'selected="selected"':"").' value="no-pos">No Pos</option>
										<option '.(($player_pos=='GK')?'selected="selected"':"").' value="GK">GK</option>
										<option '.(($player_pos=='LB')?'selected="selected"':"").' value="LB">LB</option>
										<option '.(($player_pos=='LWB')?'selected="selected"':"").' value="LWB">LWB</option>
										<option '.(($player_pos=='CB')?'selected="selected"':"").' value="CB">CB</option>
										<option '.(($player_pos=='RB')?'selected="selected"':"").' value="RB">RB</option>
										<option '.(($player_pos=='RWB')?'selected="selected"':"").' value="RWB">RWB</option>
										<option '.(($player_pos=='LM')?'selected="selected"':"").' value="LM">LM</option>
										<option '.(($player_pos=='CM')?'selected="selected"':"").' value="CM">CM</option>
										<option '.(($player_pos=='CDM')?'selected="selected"':"").' value="CDM">CDM</option>
										<option '.(($player_pos=='RM')?'selected="selected"':"").' value="RM">RM</option>
										<option '.(($player_pos=='LW')?'selected="selected"':"").' value="LW">LW</option>
										<option '.(($player_pos=='RW')?'selected="selected"':"").' value="RW">RW</option>
										<option '.(($player_pos=='LF')?'selected="selected"':"").' value="LF">LF</option>
										<option '.(($player_pos=='CF')?'selected="selected"':"").' value="CF">CF</option>
										<option '.(($player_pos=='RF')?'selected="selected"':"").' value="RF">RF</option>
										<option '.(($player_pos=='ST')?'selected="selected"':"").' value="ST">ST</option>
										
										<option '.(($player_pos=='Ailier Gauche')?'selected="selected"':"").' value="Ailier Gauche">'.esc_attr__('Ailier Gauche','kickoff').'</option>
										<option '.(($player_pos=='Ailier Droit')?'selected="selected"':"").' value="Ailier Droit">'.esc_attr__('Ailier Droit','kickoff').'</option>
										<option '.(($player_pos=='Gardien de but')?'selected="selected"':"").' value="Gardien de but">'.esc_attr__('Gardien de but','kickoff').'</option>
										<option '.(($player_pos=='Arrière Gauche')?'selected="selected"':"").' value="Arrière Gauche">'.esc_attr__('Arrière Gauche','kickoff').'</option>
										<option '.(($player_pos=='Arrière Droit')?'selected="selected"':"").' value="Arrière Droit">'.esc_attr__('Arrière Droit','kickoff').'</option>
										<option '.(($player_pos=='Pivot')?'selected="selected"':"").' value="Pivot">'.esc_attr__('Pivot','kickoff').'</option>
										<option '.(($player_pos=='Demi centre')?'selected="selected"':"").' value="Demi centre">'.esc_attr__('Demi centre','kickoff').'</option>
										<option '.(($player_pos=='Left winger')?'selected="selected"':"").' value="Left winger">'.esc_attr__('Left winger','kickoff').'</option>
										<option '.(($player_pos=='Right winger')?'selected="selected"':"").' value="Right winger">'.esc_attr__('Right winger','kickoff').'</option>
										<option '.(($player_pos=='Goalkeeper')?'selected="selected"':"").' value="Goalkeeper">'.esc_attr__('Goalkeeper','kickoff').'</option>
										<option '.(($player_pos=='Left Back')?'selected="selected"':"").' value="Left Back">'.esc_attr__('Left Back','kickoff').'</option>
										<option '.(($player_pos=='Right Back')?'selected="selected"':"").' value="Right Back">'.esc_attr__('Right Back','kickoff').'</option>
										<option '.(($player_pos=='Centre midfielder')?'selected="selected"':"").' value="Centre midfielder">'.esc_attr__('Centre midfielder','kickoff').'</option>
										<option '.(($player_pos=='Centre back')?'selected="selected"':"").' value="Centre back">'.esc_attr__('Centre back','kickoff').'</option>
									</select>
									</td>
									<td><input disabled="disabled" type="text" title="Yellow Card" name="'.esc_attr($settings['slug']).'-yc-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-yc-'.esc_attr($post->ID).'" value="'.esc_attr($player_yellow).'" /></td>
									<td><input disabled="disabled" type="text" title="Red Card" name="'.esc_attr($settings['slug']).'-rc-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-rc-'.esc_attr($post->ID).'" value="'.esc_attr($player_red).'" /></td>
									<td><input disabled="disabled" '.esc_attr($player_om).' type="radio" title="player of the match" name="'.esc_attr($settings['slug']).'-pom" data-slug="'.esc_attr($settings['slug']).'-pom" value="'.esc_attr($settings['slug']).'-pom-'.esc_attr($post->ID).'" /></td>
								</tr>';
							}
						}else{
							
							$player_pos = '';
							if(!empty($option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)])){
								$player_pos = $option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)];						
							}
							
							$player_sel = '';
							if(!empty($option_value[$settings['slug'].'-player-'.esc_attr($post->ID)])){
								$player_sel = $option_value[$settings['slug'].'-player-'.esc_attr($post->ID)];
							}
							$player_selected = '';
							if($player_sel == 'enable'){
								$player_selected = 'checked';
							}
							$player_goal = '';
							if(!empty($option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)])){
								$player_goal = $option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)];						
							}
							$player_goal_assit = '';
							if(!empty($option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)])){
								$player_goal_assit = $option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)];						
							}
							$player_own_goal = '';
							if(!empty($option_value[$settings['slug'].'-og-'.esc_attr($post->ID)])){
								$player_own_goal = $option_value[$settings['slug'].'-og-'.esc_attr($post->ID)];						
							}
							$player_penalty = '';
							if(!empty($option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)])){
								$player_penalty = $option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)];						
							}
							$player_yellow = '';
							if(!empty($option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)])){
								$player_yellow = $option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)];						
							}
							$player_red = '';
							if(!empty($option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)])){
								$player_red = $option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)];
							}
							
							$player_om = 'off';
							if(isset($option_value[$settings['slug'].'-pom']) && $option_value[$settings['slug'].'-pom'] == $settings['slug'].'-pom-'.esc_attr($post->ID)){
								$player_om = 'checked';
							}
							
							echo '<tr class="player-row">
								<td><input type="checkbox" '.esc_attr($player_selected).' class="player_selected" name="'.$settings['slug'].'-player-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-player-'.esc_attr($post->ID).'" /></td>
								<td>'.esc_attr($post->post_title).'<input type="hidden" value="'.$post->ID.'" name="'.$settings['slug'].'-name-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-name-'.esc_attr($post->ID).'" /> </td>
								<td><input disabled="disabled" type="text" title="Goals" name="'.esc_attr($settings['slug']).'-pg-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-pg-'.esc_attr($post->ID).'" value="'.esc_attr($player_goal).'" /></td>
								<td><input disabled="disabled" type="text" title="Assit" name="'.esc_attr($settings['slug']).'-ag-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-ag-'.esc_attr($post->ID).'" value="'.esc_attr($player_goal_assit).'" /></td>
								<td><input disabled="disabled" type="text" title="Own Goal" name="'.esc_attr($settings['slug']).'-og-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-og-'.esc_attr($post->ID).'" value="'.esc_attr($player_own_goal).'" /></td>
								<td><input disabled="disabled" type="text" title="Penalty" name="'.esc_attr($settings['slug']).'-ps-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-ps-'.esc_attr($post->ID).'" value="'.esc_attr($player_penalty).'" /></td>
								<td>
								<select disabled="disabled" class="select-pos" name="'.esc_attr($settings['slug']).'-pos-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-pos-'.esc_attr($post->ID).'" >
									<option '.(($player_pos=='no-pos')?'selected="selected"':"").' value="no-pos">No Pos</option>
									<option '.(($player_pos=='GK')?'selected="selected"':"").' value="GK">GK</option>
									<option '.(($player_pos=='LB')?'selected="selected"':"").' value="LB">LB</option>
									<option '.(($player_pos=='LWB')?'selected="selected"':"").' value="LWB">LWB</option>
									<option '.(($player_pos=='CB')?'selected="selected"':"").' value="CB">CB</option>
									<option '.(($player_pos=='RB')?'selected="selected"':"").' value="RB">RB</option>
									<option '.(($player_pos=='RWB')?'selected="selected"':"").' value="RWB">RWB</option>
									<option '.(($player_pos=='LM')?'selected="selected"':"").' value="LM">LM</option>
									<option '.(($player_pos=='CM')?'selected="selected"':"").' value="CM">CM</option>
									<option '.(($player_pos=='CDM')?'selected="selected"':"").' value="CDM">CDM</option>
									<option '.(($player_pos=='RM')?'selected="selected"':"").' value="RM">RM</option>
									<option '.(($player_pos=='LW')?'selected="selected"':"").' value="LW">LW</option>
									<option '.(($player_pos=='RW')?'selected="selected"':"").' value="RW">RW</option>
									<option '.(($player_pos=='LF')?'selected="selected"':"").' value="LF">LF</option>
									<option '.(($player_pos=='CF')?'selected="selected"':"").' value="CF">CF</option>
									<option '.(($player_pos=='RF')?'selected="selected"':"").' value="RF">RF</option>
									<option '.(($player_pos=='ST')?'selected="selected"':"").' value="ST">ST</option>
									
									<option '.(($player_pos=='Ailier Gauche')?'selected="selected"':"").' value="Ailier Gauche">'.esc_attr__('Ailier Gauche','kickoff').'</option>
									<option '.(($player_pos=='Ailier Droit')?'selected="selected"':"").' value="Ailier Droit">'.esc_attr__('Ailier Droit','kickoff').'</option>
									<option '.(($player_pos=='Gardien de but')?'selected="selected"':"").' value="Gardien de but">'.esc_attr__('Gardien de but','kickoff').'</option>
									<option '.(($player_pos=='Arrière Gauche')?'selected="selected"':"").' value="Arrière Gauche">'.esc_attr__('Arrière Gauche','kickoff').'</option>
									<option '.(($player_pos=='Arrière Droit')?'selected="selected"':"").' value="Arrière Droit">'.esc_attr__('Arrière Droit','kickoff').'</option>
									<option '.(($player_pos=='Pivot')?'selected="selected"':"").' value="Pivot">'.esc_attr__('Pivot','kickoff').'</option>
									<option '.(($player_pos=='Demi centre')?'selected="selected"':"").' value="Demi centre">'.esc_attr__('Demi centre','kickoff').'</option>
									<option '.(($player_pos=='Left winger')?'selected="selected"':"").' value="Left winger">'.esc_attr__('Left winger','kickoff').'</option>
									<option '.(($player_pos=='Right winger')?'selected="selected"':"").' value="Right winger">'.esc_attr__('Right winger','kickoff').'</option>
									<option '.(($player_pos=='Goalkeeper')?'selected="selected"':"").' value="Goalkeeper">'.esc_attr__('Goalkeeper','kickoff').'</option>
									<option '.(($player_pos=='Left Back')?'selected="selected"':"").' value="Left Back">'.esc_attr__('Left Back','kickoff').'</option>
									<option '.(($player_pos=='Right Back')?'selected="selected"':"").' value="Right Back">'.esc_attr__('Right Back','kickoff').'</option>
									<option '.(($player_pos=='Centre midfielder')?'selected="selected"':"").' value="Centre midfielder">'.esc_attr__('Centre midfielder','kickoff').'</option>
									<option '.(($player_pos=='Centre back')?'selected="selected"':"").' value="Centre back">'.esc_attr__('Centre back','kickoff').'</option>
								</select>
								</td>
								<td><input disabled="disabled" type="text" title="Yellow Card" name="'.esc_attr($settings['slug']).'-yc-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-yc-'.esc_attr($post->ID).'" value="'.esc_attr($player_yellow).'" /></td>
								<td><input disabled="disabled" type="text" title="Red Card" name="'.esc_attr($settings['slug']).'-rc-'.esc_attr($post->ID).'" data-slug="'.esc_attr($settings['slug']).'-rc-'.esc_attr($post->ID).'" value="'.esc_attr($player_red).'" /></td>
								<td><input disabled="disabled" '.esc_attr($player_om).' type="radio" title="player of the match" name="'.esc_attr($settings['slug']).'-pom" data-slug="'.esc_attr($settings['slug']).'-pom" value="'.$settings['slug'].'-pom-'.esc_attr($post->ID).'" /></td>
							</tr>';
						}						
					} wp_reset_postdata();
					
				echo '
				<tbody>
				</table></div></div>';
				wp_reset_query();
				
			}
			
			
			
			function kode_show_export_widgets($settings = array()){
				$widget_list = array(0=>'sidebars_widgets');
				$widget_array = kode_get_widget_name_value();
				if(!empty($widget_array)){
					foreach($widget_array as $widget){
						$widget_list[] = $widget;
					}	
				}
				
				$widget_data = array();
				if(!empty($widget_list)){
					foreach($widget_list as $widget){
						$widget_data[$widget] = get_option($widget);
					}
				}
				
				echo '<div class="export_widgets kode-option-input ';
				echo (!empty($settings['class']))? esc_attr($settings['class']): '';
				echo '">';
				
				echo '<textarea ';
				echo (!empty($settings['class']))? 'class="' . esc_attr($settings['class']) . '"': '';
				echo '>';
				print_r(serialize($widget_data));
				echo '</textarea>';
				echo '</div>';
				
				
			}
			
			function kode_show_importer_default($settings = array()){
				$ret = '';
				$ret .= '
				<div class="kode-importer-more">
					<input type="hidden" class="dummy_url" data-slug="'.esc_attr($settings['dummy']).'"/>
					<div data-ajax="' . esc_url(AJAX_URL) . '" data-action="load_demo_data_default" class="kode-import-more">
						<img class="now-loading" src="' . esc_attr(KODE_PATH) . '/framework/include/backend_assets/images/admin-panel/loading.gif" alt="loading" />
						<a class="import-now">Import Now</a>
					</div>
				</div>';
				
				echo $ret;
				
			}
			
			function kode_show_importer_first_default($settings = array()){
				$ret = '';
				$ret .= '
				<div class="kode-importer-default-first">
					<div class="kode-import-progress">
						<img src="' . esc_url(KODE_PATH) . '/framework/include/backend_assets/images/admin-panel/dummy-loader.gif" alt="loading" />
						<h2 class="import-pro-head">Import in Progress</h2>
						<p>Please wait it will take a while to import the dummy data.</p>
					</div>
					<div class="kode-import-completed">
						<img src="' . esc_url(KODE_PATH) . '/framework/include/backend_assets/images/tick.png" alt="complete" />
						<h2 class="import-pro-head">Import is Completed!</h2>
						<p>View <a href="'.esc_url(home_url('/')).'">Front Page</a> - Go to <a href="'.esc_url(admin_url()).'admin.php?page='.KODE_SLUG.'">Theme Options</a>.</p>
						<div class="abc-import"></div>
					</div>
				</div>';
				
				echo $ret;
				
			}
			
			
			function kode_show_importer($settings = array()){
				$ret = '';
				$ret .= '
				<img class="now-loading" src="' . esc_url(KODE_PATH) . '/framework/include/backend_assets/images/admin-panel/loading.gif" alt="loading" />
				<div  class="kode-importer-image">
					<div class="figure">
						<img src="'.esc_url($settings['image']).'" alt="'.esc_attr($settings['title']).'" / >
					</div>
					<div class="kode-importer-head">
						<h3>'.esc_attr($settings['title']).'</h3>
						<span>'.esc_attr($settings['desc']).'</span>
					</div>
					<input type="hidden" class="dummy_url" data-slug="'.esc_attr($settings['dummy']).'"/>
					<input type="hidden" class="options_url" data-slug="'.esc_attr($settings['options']).'"/>
					<input type="hidden" class="widgets_url" data-slug="'.esc_attr($settings['widgets']).'"/>
					<div data-ajax="' . esc_url(AJAX_URL) . '" data-action="demo_data_load" class="kode-import-now">
						<img class="now-loading" src="' . esc_url(KODE_PATH) . '/framework/include/backend_assets/images/admin-panel/loading.gif" alt="loading" />
						<a class="import-now">'.esc_attr__('Import Now','kickoff').'</a>
						<a target="_blank" href="' . esc_url($settings['live']) . '" class="live-url">'.esc_attr__('Live URL','kickoff').'</a>
					</div>
				</div>';
				
				echo $ret;
				
			}
			
			function kode_show_sidebar_data($settings = array()){
				global $kode_theme_option;
				// print_R($kode_theme_option);
				// print_r($settings);
				
				echo '<div class="kode-option-input">';
				echo '<input type="text" class="kode-upload-box-input" data-slug="' . esc_attr($settings['slug']) . '" value="' . esc_attr($settings['placeholder']) . '" rel="' . esc_attr($settings['placeholder']) . '">';
				echo '<div id="' . esc_attr($settings['slug']) . '" class="kdf-button">'.esc_html__('Add','kickoff').'</div>';
				
				echo '<div class="clear"></div>';
				echo '</div>';
					
				echo '<div id="selected-sidebar" class="sidebar-default-k">';
					echo '<div class="default-sidebar-item" id="sidebar-item">';
						echo '<div class="panel-delete-sidebar"></div>';
						echo '<div class="slider-item-text"></div>';
						echo '<input type="hidden" id="sidebar">';
					echo '</div>';
					if(!empty($kode_theme_option['sidebar-element'])){
						if(isset($settings['value'] )){
							foreach($settings['value'] as $item){
								echo '
								<div id=" " class="sidebar-item" style="">
									<div class="panel-delete-sidebar"></div>
									<div class="slider-item-text">'.esc_attr($item).'</div>
									<input type="hidden" id="sidebar" name="' . esc_attr($settings['slug']) . '[]" data-slug="' . esc_attr($settings['slug']) . '[]" value="'.esc_attr($item).'">
								</div>';
							}
						}
					}
				echo '</div>';	

			
			}
			
			// print custom option
			function show_simple_text($settings = array()){
				echo '<div class="kode-simple-text">';
				 if ( function_exists( 'wp_get_theme' ) ) {
					$theme_data = wp_get_theme();
					$item_uri = $theme_data->get( 'ThemeURI' );
					$theme_name = $theme_data->get( 'Name' );
					$version = $theme_data->get( 'Version' );
				}
				echo '<div class="kode-system-diagnose"><ul>';
					echo'<li><strong>Theme Name:</strong><span>'.$theme_name.'</span></li>';
					echo '<li><strong>Theme Version:</strong><span>'.$version.'</span></li>';
					echo'<li><strong>Site URL:</strong><span>'.home_url().'</span></li>';
					echo '<li><strong>Author URL:</strong><span>'.$item_uri.'</span></li>';

					if ( is_multisite() ) {
						echo '<li><strong>WordPress Version:</strong><span>'. 'WPMU ' . get_bloginfo( 'version' ).'</span></li>';
					} else {
						echo '<li><strong>WordPress Version:</strong><span>'. 'WP ' . get_bloginfo( 'version' ).'</span></li>';
					}
					echo '<li><strong>Web Server Info:</strong><span>'.esc_html( $_SERVER['SERVER_SOFTWARE'] ).'</span></li>';
					if ( function_exists( 'phpversion' ) ) {
						echo '<li><strong>PHP Version:</strong><span>'. esc_html( phpversion() ).'</span></li>';
					}
					if ( function_exists( 'size_format' ) ) {
						echo '<li><strong>WP Memory Limit:</strong>';
						$mem_limit = WP_MEMORY_LIMIT;
						if ( $mem_limit < 67108864 ) {
							echo '<span class="error">' . size_format( $mem_limit ) .' - Recommended memory limit should be at least 64MB. Please refer to : <a target="_blank" href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP">Increasing memory allocated to PHP</a> for more information</span>';
						} else {
							echo '<span>' . size_format( $mem_limit ) . '</span>';
						}
						echo '</li>';
						echo'<li><strong>WP Max Upload Size:</strong><span>'. size_format( wp_max_upload_size() ) .'</span></li>';
					}
					if ( function_exists( 'ini_get' ) ) {
						echo '<li><strong>PHP Time Limit:</strong><span>'. ini_get( 'max_execution_time' ) .'</span></li>';
					}
					if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
						echo '<li><strong>WP Debug Mode:</strong><span>Enabled</span></li>';
					} else {
						echo '<li><strong>WP Debug Mode:</strong><span class="error">Disabled</span></li>';
					}
					echo '</ul></div>';
				echo '</div>';
			}
			
			
			// print custom option
			function show_custom_option($settings = array()){
				echo '<div class="kode-option-input">';
				echo $settings['option'];
				echo '</div>';
			}
			
			
			
			// print the input text
			function show_text_input($settings = array()){
				echo '<div class="kode-option-input">';
				echo '<input type="text" class="kdf-text-input" name="' . esc_attr($settings['name']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
				if( isset($settings['value']) ){
					echo 'value="' . esc_attr($settings['value']) . '" ';
				}else if( !empty($settings['default']) ){
					echo 'value="' . esc_attr($settings['default']) . '" ';
				}
				echo '/>';
				echo '</div>';
			}
			
			//Header Box
			function show_header_box($settings = array()){
				echo '<div class="page-builder-head-wrapper">
					<h4 class="page-builder-head add-content">'.$settings['header_title'].'</h4>
				</div>';
			}
			
			
			// print the date picker
			function show_date_picker($settings = array()){
				echo '<div class="kode-option-input">';
				echo '<input type="text" class="kdf-text-input kode-date-picker" name="' . esc_attr($settings['name']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
				if( isset($settings['value']) ){
					echo 'value="' . esc_attr($settings['value']) . '" ';
				}else if( !empty($settings['default']) ){
					echo 'value="' . esc_attr($settings['default']) . '" ';
				}
				echo '/>';
				echo '</div>';
			}			
			
			// print the textarea
			function show_textarea($settings = array()){
				echo '<div class="kode-option-input ';
				echo (!empty($settings['class']))? esc_attr($settings['class']): '';
				echo '">';
				
				echo '<textarea name="' . esc_attr($settings['slug']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
				echo (!empty($settings['class']))? 'class="' . esc_attr($settings['class']) . '"': '';
				echo '>';
				if( isset($settings['value']) ){
					echo esc_attr($settings['value']);
				}else if( !empty($settings['default']) ){
					echo esc_attr($settings['default']);
				}
				echo '</textarea>';
				echo '</div>';
			}		

			// print the combobox
			function show_combobox($settings = array()){
				global $post;
				echo '<div class="kode-option-input">';
				
				$value = '';
				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}
				
				if(isset($settings['ajax']) && !empty($settings['ajax'])){
					echo '<div data-settings="'.$settings['settings'].'" data-ajax="' . AJAX_URL . '" data-id="' . $post->ID . '" data-action="'.$settings['ajax'].'" class="kode-combobox-wrapper">';	
				}else{
					echo '<div class="kode-combobox-wrapper">';	
				}
				
				echo '<select name="' . esc_attr($settings['name']) . '" data-slug="' . esc_attr($settings['slug']) . '" >';
				foreach($settings['options'] as $slug => $name ){
					echo '<option value="' . esc_attr($slug) . '" ';
					echo ($value == $slug)? 'selected ': '';
					echo '>' . esc_attr($name) . '</option>';
				
				}
				echo '</select>';
				echo '</div>'; // kode-combobox-wrapper
				
				echo '</div>';
			}
			
			// print the combobox
			function show_combobox_sidebar($settings = array()){
				echo '<div class="kode-option-input">';
				
				$value = '';
				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}
				
				echo '<div class="kode-combobox-wrapper">';
				echo '<select name="' . esc_attr($settings['name']) . '" data-slug="' . esc_attr($settings['name']) . '" >';
				foreach($settings['options'] as $slug => $name ){
					echo '<option value="' . esc_attr($name) . '" ';
					echo ($value == $name)? 'selected ': '';
					echo '>' . esc_attr($name) . '</option>';
				
				}
				echo '</select>';
				echo '</div>'; // kode-combobox-wrapper
				
				echo '</div>';
			}
			
			// print the combobox
			function show_multi_combobox($settings = array()){
				echo '<div class="kode-option-input">';

				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}else{
					$value = array();
				}

				echo '<div class="kode-multi-combobox-wrapper">';
				echo '<select name="' . esc_attr($settings['name']) . '[]" data-slug="' . esc_attr($settings['slug']) . '" multiple >';
				foreach($settings['options'] as $slug => $name ){
					echo '<option value="' . esc_attr($slug) . '" ';
					echo (in_array($slug, $value))? 'selected ': '';
					echo '>' . esc_attr($name) . '</option>';
				
				}
				echo '</select>';
				echo '</div>'; // kode-combobox-wrapper
				
				echo '</div>';
			}			

			
			// print the checkbox ( enable / disable )
			function show_checkbox($settings = array()){
				echo '<div class="kode-option-input">';
				
				$value = 'enable';
				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}
				echo '
					<div class="onoffswitch primary inline-block">
						<div class="checkbox-appearance ' . esc_attr($value) . '" > </div>
						<input type="hidden" name="' . esc_attr($settings['name']) . '" value="disable" />
						<input type="checkbox" name="' . esc_attr($settings['name']) . '" class="onoffswitch-checkbox" id="' . esc_attr($settings['slug']) . '-id" data-slug="' . esc_attr($settings['slug']) . '" ';
						echo ($value == 'enable')? 'checked': '';
						echo ' value="enable">
						<label class="onoffswitch-label" for="' . esc_attr($settings['slug']) . '-id">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>';
			}		

			// print the radio image
			function show_radio_image($settings = array()){
				echo '<div class="kode-option-input">';
				
				$value = '';
				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}
				
				$i = 0;
				foreach($settings['options'] as $slug => $name ){
					echo '<label for="' . esc_attr($settings['slug']) . '-id' . $i . '" class="radio-image-wrapper ';
					echo ($value == $slug)? 'active ': '';
					echo '">';
					echo '<img src="' . esc_url($name) . '" alt="" />';
					echo '<div class="selected-radio"></div>';

					echo '<input type="radio" name="' . esc_attr($settings['name']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
					echo 'id="' . esc_attr($settings['slug']) . '-id' . $i . '" value="' . esc_attr($slug) . '" ';
					echo ($value == $slug)? 'checked ': '';
					echo ' />';
					
					echo '</label>';
					
					$i++;
				}
				
				echo '<div class="clear"></div>';
				echo '</div>';
			}
			
			
			// print the radio image
			function show_radio_header_image($settings = array()){
				echo '<div class="kode-option-input">';
				
				$value = '';
				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}
				
				$i = 0;
				foreach($settings['options'] as $slug => $name ){
					echo '<label for="' . esc_attr($settings['slug']) . '-id' . $i . '" class="radio-image-wrapper radio-header-wrapper ';
					echo ($value == $slug)? 'active ': '';
					echo '">';
					echo '<img src="' . esc_url($name) . '" alt="" />';
					echo '<div class="selected-radio"></div>';

					echo '<input type="radio" name="' . esc_attr($settings['name']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
					echo 'id="' . esc_attr($settings['slug']) . '-id' . $i . '" value="' . esc_attr($slug) . '" ';
					echo ($value == $slug)? 'checked ': '';
					echo ' />';
					
					echo '</label>';
					
					$i++;
				}
				
				echo '<div class="clear"></div>';
				echo '</div>';
			}
			
			

			// print color picker
			function show_color_picker($settings = array()){
				echo '<div class="kode-option-input">';
				
				echo '<input type="text" class="wp-color-picker" name="' . esc_attr($settings['name']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
				if( !empty($settings['value']) ){
					echo 'value="' . esc_attr($settings['value']) . '" ';
				}else if( !empty($settings['default']) ){
					echo 'value="' . esc_attr($settings['default']) . '" ';
				}
				
				if( !empty($settings['default']) ){
					echo 'data-default-color="' . esc_attr($settings['default']) . '" ';
				}
				echo '/>';
				
				echo '</div>';
			}	
			
			
			// print slider bar
			function show_slider_bar($settings = array()){
				echo '<div class="kode-option-input">';
				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}
				
				// create a blank box for javascript
				echo '<div class="kode-sliderbar" data-value="' . esc_attr($value) . '" ></div>';
				
				echo '<input type="text" class="kode-sliderbar-text-hidden" name="' . esc_attr($settings['name']) . '" ';
				echo 'data-slug="' . esc_attr($settings['slug']) . '" value="' . esc_attr($value) . '" />';
				
				// this will be the box that shows the value
				echo '<div class="kode-sliderbar-text">' . esc_attr($value) . 'px</div>';
				
				echo '<div class="clear"></div>';
				echo '</div>';			
			}

			// print slider
			function show_slider($settings = array()){
				echo '<div class="kode-option-input ';
				echo (!empty($settings['class']))? esc_attr($settings['class']): '';
				echo '">';
				
				echo '<textarea name="' . esc_attr($settings['slug']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
				echo 'class="kode-input-hidden kode-slider-selection" data-overlay="true" data-caption="true" >';
				if( isset($settings['value']) ){
					echo esc_attr($settings['value']);
				}else if( !empty($settings['default']) ){
					echo esc_attr($settings['default']);
				}
				echo '</textarea>';
				echo '</div>';
			}	

			// print Gallery
			function show_gallery($settings = array()){
				echo '<div class="kode-option-input ';
				echo (!empty($settings['class']))? esc_attr($settings['class']): '';
				echo '">';
				
				echo '<textarea name="' . esc_attr($settings['slug']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
				echo 'class="kode-input-hidden kode-gallery-selection" data-overlay="true" data-caption="true" >';
				if( isset($settings['value']) ){
					echo esc_attr($settings['value']);
				}else if( !empty($settings['default']) ){
					echo esc_attr($settings['default']);
				}
				echo '</textarea>';
				echo '</div>';
			}				
			
			// print upload box
			function show_upload_box($settings = array()){
				echo '<div class="kode-option-input">';
				
				$value = ''; $file_url = '';
				$settings['data-type'] = empty($settings['data-type'])? 'image': $settings['data-type'];
				$settings['data-type'] = ($settings['data-type']=='upload')? 'image': $settings['data-type'];
				
				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}
				
				if( is_numeric($value) ){ 
					$file_url = wp_get_attachment_url($value);
				}else{
					$file_url = $value;
				}
				
				// example image url
				echo '<img class="kode-upload-img-sample ';
				echo (empty($file_url) || $settings['data-type'] != 'image')? 'blank': '';
				echo '" ';
				echo (!empty($file_url) && $settings['data-type'] == 'image')? 'src="' . esc_url($file_url) . '" ': ''; 
				echo '/>';
				echo '<div class="clear"></div>';
				
				// input link url
				echo '<input type="text" class="kode-upload-box-input" value="' . esc_url($file_url) . '" />';					
				
				// hidden input
				echo '<input type="hidden" class="kode-upload-box-hidden" ';
				echo 'name="' . esc_attr($settings['name']) . '" data-slug="' . esc_attr($settings['slug']) . '" ';
				echo 'value="' . esc_attr($value) . '" />';
				
				// upload button
				echo '<input type="button" class="kode-upload-box-button kdf-button" ';
				echo 'data-title="' . esc_attr($settings['title']) . '" ';
				echo 'data-type="' . esc_attr($settings['data-type']) . '" ';				
				echo 'data-button="';
				echo (empty($settings['button']))? esc_html__('Insert Image', 'kickoff'):$settings['button'];
				echo '" ';
				echo 'value="' . esc_html__('Upload', 'kickoff') . '"/>';
				
				echo '<div class="clear"></div>';
				echo '</div>';
			}			

			// print the font combobox
			function print_font_combobox($settings = array()){
				echo '<div class="kode-option-input">';
				
				$value = '';
				if( !empty($settings['value']) ){
					$value = $settings['value'];
				}else if( !empty($settings['default']) ){
					$value = $settings['default'];
				}
				
				echo '<input class="kode-sample-font" ';
				echo 'value="' . esc_attr( esc_html__('Sample Font', 'kickoff') ) . '" ';
				echo (!empty($value))? 'style="font-family: ' . $value . ';" />' : '/>';
				
				echo '<div class="kode-combobox-wrapper">';
				echo '<select name="' . $settings['name'] . '" data-slug="' . $settings['slug'] . '" class="kode-font-combobox" >';
				do_action('kode_print_all_font_list', $value);
				echo '</select>';
				echo '</div>'; // kode-combobox-wrapper
				
				echo '</div>';
			}	
			
			
		}

	}
		
?>