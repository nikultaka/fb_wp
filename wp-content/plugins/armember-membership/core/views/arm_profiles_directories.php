<?php
global $wpdb, $ARMember, $arm_slugs, $arm_global_settings, $arm_members_directory, $arm_subscription_plans;
$member_templates = $arm_members_directory->arm_get_all_member_templates();
$defaultTemplates = $arm_members_directory->arm_default_member_templates();
$tempColorSchemes = $arm_members_directory->getTemplateColorSchemes();
$tempColorSchemes1 = $arm_members_directory->getTemplateColorSchemes1();
$subs_data = $arm_subscription_plans->arm_get_all_subscription_plans('arm_subscription_plan_id, arm_subscription_plan_name');
?>
<div class="wrap arm_page arm_profiles_directories_main_wrapper armPageContainer">
	<div class="content_wrapper arm_profiles_directories_container arm_min_height_500" id="content_wrapper">
        <div class="page_title"><?php _e('Profiles & Directories','ARMember'); ?></div>
        <div class="armclear"></div>
        <div class="arm_profiles_directories_templates_container">
            <div class="arm_profiles_directories_content arm_visible">
                <div id="arm_profile_templates_container" class="page_sub_content arm_profile_templates_container">
                    <div class="arm_belt_box">
                        <div class="arm_belt_block">
                            <div class="page_sub_title"><?php _e('Member Profile Templates', 'ARMember'); ?></div>
                        </div>
                        <div class="arm_belt_block" align="<?php echo is_rtl() ? 'left' : 'right'; ?>">
                            <div class="arm_membership_setup_shortcode_box" >
                                <span class="arm_font_size_18"><?php _e('Shortcode', 'ARMember'); ?></span>
                                <?php $shortCode = '[arm_template type="profile" id="1"]'; ?>
                                <div class="arm_shortcode_text arm_form_shortcode_box" style="width:auto;">
                                    <span class="armCopyText"><?php echo esc_attr($shortCode); ?></span>
                                    <span class="arm_click_to_copy_text" data-code="<?php echo esc_attr($shortCode); ?>"><?php _e('Click to copy', 'ARMember'); ?></span>
                                    <span class="arm_copied_text"><img src="<?php echo MEMBERSHIPLITE_IMAGES_URL; ?>/copied_ok.png" alt="ok"/><?php _e('Code Copied', 'ARMember'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="arm_profile_templates" class="arm_profile_templates arm_pdt_content">
                        <?php

                       

                        if (!empty($member_templates['profile'])) {
                            foreach ($member_templates['profile'] as $ptemp) {


                                $t_id = $ptemp['arm_id'];
                                $t_title = $ptemp['arm_title'];
                                $t_type = $ptemp['arm_type'];
                                $t_options = maybe_unserialize($ptemp['arm_options']);
                                $t_link_attr = ' data-id="' . $t_id . '" data-type="' . $t_type . '" ';
                                $t_container_class = '';
                                $t_img_url = MEMBERSHIPLITE_VIEWS_URL . '/templates/' . $ptemp['arm_slug'] . '.png';

                                $default = $ptemp['arm_default'];
                                $plan_names = "";
                                
                                if( $default == 1 ){
                                    $plan_names = __('Default Profile Template','ARMember');
                                } else {
                                    $subscription_plans = $ptemp['arm_subscription_plan'];
                                    if( $subscription_plans == '' ){
                                        $plan_names = "<strong>".__("Associated Plans:",'ARMember')."</strong><br/>".__("No plan selected",'ARMember');
                                    } else {
                                        $plan_name_array = explode(',',$subscription_plans);
                                        $plan_names_db = $wpdb->get_results("SELECT `arm_subscription_plan_name` FROM ".$ARMember->tbl_arm_subscription_plans." WHERE `arm_subscription_plan_id` IN (".$subscription_plans.")");
                                        $plan_names = "<strong>".__("Associated Plans:",'ARMember')." </strong><br/>";
                                        if( $plan_names_db != "" ){
                                            foreach($plan_names_db as $db_plan_name ){
                                                $plan_names .= $db_plan_name->arm_subscription_plan_name.', ';
                                            }
                                        } else {
                                            $plan_names .= " ".__('No Plan selected','ARMember');
                                        }
                                        $plan_names = rtrim($plan_names,', ');
                                    }
                                }

                                ?>
                                <div class="arm_template_content_wrapper arm_row_temp_<?php echo $t_id; ?> <?php echo $t_container_class; ?> armGridActionTD">
                                    <div class="arm_template_content_main_box">
                                        <a href="javascript:void(0)" class="arm_template_preview" <?php echo $t_link_attr; ?>><img alt="<?php echo $t_title; ?>" src="<?php echo $t_img_url; ?>"></a>
                                        <?php if(!empty($t_title)) { ?>
                                            <div class="arm_template_name_div">
                                                <?php echo $t_title; ?>
                                            </div>
                                        <?php } ?>
                                        <div class="arm_template_content_option_links">
                                            <a href="javascript:void(0)" class="arm_template_preview armhelptip" title="<?php _e('Click to preview', 'ARMember'); ?>" <?php echo $t_link_attr; ?>><img src="<?php echo MEMBERSHIPLITE_IMAGES_URL; ?>/dir_preview_icon.png" alt="" /></a>
                                            <a class="arm_template_edit_link armhelptip" title="<?php _e('Edit Template Options', 'ARMember'); ?>" href="<?php echo admin_url('admin.php?page='.$arm_slugs->profiles_directories.'&action=edit_profile&id='.$t_id) ?>" <?php echo $t_link_attr; ?>><img src="<?php echo MEMBERSHIPLITE_IMAGES_URL; ?>/dir_edit_icon.png" alt="" /></a>
                                           
                                        </div>
                                    </div>
                                   
                                    <div class="armclear"></div>
                                    <div class="arm_profile_template_associalated_plan"><?php echo $plan_names; ?></div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        
                    </div>
                    <div class="armclear"></div>
                    
                    <div class="page_sub_title arm_margin_top_10"><?php _e('Member Profile URL','ARMember'); ?></div>
                        <?php 
                        $permalink_base = (isset($arm_global_settings->global_settings['profile_permalink_base'])) ? $arm_global_settings->global_settings['profile_permalink_base'] : 'user_login';
                        if (get_option('permalink_structure')) {
                            $profileUrl = trailingslashit(untrailingslashit($arm_global_settings->profile_url));
                            if ($permalink_base == 'user_login') {
                                $profileUrl = $profileUrl . '<b>username</b>/';
                            } else {
                                $profileUrl = $profileUrl . '<b>user_id</b>/';
                            }
                        } else {
                            $profileUrl = $arm_global_settings->add_query_arg('arm_user', 'arm_base_slug', $arm_global_settings->profile_url);
                            if ($permalink_base == 'user_login') {
                                $profileUrl = str_replace('arm_base_slug', '<b>username</b>', $profileUrl);
                            } else {
                                $profileUrl = str_replace('arm_base_slug', '<b>user_id</b>', $profileUrl);
                            }
                        }
                        ?>
                        <span class="arm_info_text"><?php 
                            echo __('Current user profile URL pattern', 'ARMember') . ': ' . $profileUrl;
                            echo '&nbsp;&nbsp;<a href="' . admin_url('admin.php?page=' . $arm_slugs->general_settings . '#profilePermalinkBase') . '">' . __('Change Pattern', 'ARMember') . '</a>';
                        ?>
                        </span>





                </div>
                <div class="armclear"></div>
                <div class="arm_solid_divider"></div>
                <div id="arm_directory_templates_container" class="page_sub_content arm_directory_templates_container">
                    <div class="arm_belt_box">
                        <div class="arm_belt_block">
                            <div class="page_sub_title"><?php _e('Members Directory Templates', 'ARMember'); ?></div>
                        </div>
                    </div>
                    <div id="arm_directory_templates" class="arm_directory_templates arm_pdt_content">
                        <?php
                        if (!empty($member_templates['directory'])) {
                            foreach ($member_templates['directory'] as $dtemp) {
                                $t_id = $dtemp['arm_id'];
                                $t_title = $dtemp['arm_title'];
                                $t_type = $dtemp['arm_type'];
                                $t_options = maybe_unserialize($dtemp['arm_options']);
                                $t_link_attr = 'data-id="' . $t_id . '" data-type="' . $t_type . '"';
                                $t_container_class = '';
                                $t_img_url = MEMBERSHIPLITE_VIEWS_URL . '/templates/' . $dtemp['arm_slug'] . '.png';
                                ?>
                                <div class="arm_template_content_wrapper arm_row_temp_<?php echo $t_id; ?> <?php echo $t_container_class; ?> armGridActionTD">
                                    <div class="arm_template_content_main_box">
                                        <a href="javascript:void(0)" class="arm_template_preview" <?php echo $t_link_attr; ?>><img alt="<?php echo $t_title; ?>" src="<?php echo $t_img_url; ?>"></a>
                                        <?php if(!empty($t_title)) { ?>
                                            <div class="arm_template_name_div">
                                                <?php echo $t_title; ?>
                                            </div>
                                        <?php } ?>
                                        <div class="arm_template_content_option_links">
                                            <a href="javascript:void(0)" class="arm_template_preview armhelptip" title="<?php _e('Click to preview', 'ARMember'); ?>" <?php echo $t_link_attr; ?>><img src="<?php echo MEMBERSHIPLITE_IMAGES_URL; ?>/dir_preview_icon.png" alt="" /></a>
                                            <a href="javascript:void(0)" class="arm_template_edit_link armhelptip" title="<?php _e('Edit Template Options', 'ARMember'); ?>" <?php echo $t_link_attr; ?>><img src="<?php echo MEMBERSHIPLITE_IMAGES_URL; ?>/dir_edit_icon.png" alt="" /></a>
                                            
                                        </div>
                                    </div>
                                   
                                    <!--<span class="arm_template_title"><?php echo $t_title; ?></span>-->
                                    <div class="arm_short_code_detail">
                                        <span class="arm_shortcode_title"><?php _e('Short Code', 'ARMember'); ?>&nbsp;&nbsp;</span>
                                        <?php $shortCode = '[arm_template type="' . $t_type . '" id="' . $t_id . '"]'; ?>
                                        <div class="arm_shortcode_text arm_form_shortcode_box">
                                            <span class="armCopyText"><?php echo esc_attr($shortCode); ?></span>
                                            <span class="arm_click_to_copy_text" data-code="<?php echo esc_attr($shortCode); ?>"><?php _e('Click to copy', 'ARMember'); ?></span>
                                            <span class="arm_copied_text"><img src="<?php echo MEMBERSHIPLITE_IMAGES_URL; ?>/copied_ok.png" alt="ok"/><?php _e('Code Copied', 'ARMember'); ?></span>
                                        </div>
                                    </div>
                                    <div class="armclear"></div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                      
                    </div>
                </div>
                <div class="armclear"></div>
            </div>
            <div id="arm_add_profiles_directories_templates" class="arm_add_profiles_directories_templates">
                <?php
                $tempCS = 'blue';
                $tempType = 'profile';
                $backToListingIcon = MEMBERSHIPLITE_IMAGES_URL . '/back_to_listing_arrow.png';
                if (is_rtl()) {
                    $backToListingIcon = MEMBERSHIPLITE_IMAGES_URL . '/back_to_listing_arrow_right.png';
                }
                ?>
                <form method="POST" class="arm_admin_form arm_add_template_form" id="arm_add_template_form" onsubmit="return false;">
                    <div class="arm_sticky_top_belt" id="arm_sticky_top_belt">
                        <div class="arm_belt_box arm_template_action_belt">
                            <div class="arm_belt_block">
                                <a href="javascript:void(0)" class="arm_temp_back_to_list armemailaddbtn"><img src="<?php echo $backToListingIcon; ?>"/><?php _e('Back to listing', 'ARMember'); ?></a>
                            </div>
                            <div class="arm_belt_block arm_temp_action_btns" align="<?php echo (is_rtl()) ? 'left' : 'right'; ?>">
                                <button type="submit" class="arm_save_btn arm_add_template_submit" data-type="directory"><?php _e('Save', 'ARMember'); ?></button>
                                <a href="javascript:void(0)" class="arm_add_temp_preview_btn armemailaddbtn" data-type="directory"><?php _e('Preview', 'ARMember'); ?></a>
                            </div>
                            <div class="armclear"></div>
                        </div>
                    </div>
                    <div class="arm_belt_box arm_template_action_belt">
                        <div class="arm_belt_block">
                            <a href="javascript:void(0)" class="arm_temp_back_to_list armemailaddbtn"><img src="<?php echo $backToListingIcon; ?>"/><?php _e('Back to listing', 'ARMember'); ?></a>
                        </div>
                        <div class="arm_belt_block arm_temp_action_btns" align="<?php echo (is_rtl()) ? 'left' : 'right'; ?>">
                            <button type="submit" class="arm_save_btn arm_add_template_submit" data-type="directory"><?php _e('Save', 'ARMember'); ?></button>
                            <a href="javascript:void(0)" class="arm_add_temp_preview_btn armemailaddbtn" data-type="directory"><?php _e('Preview', 'ARMember'); ?></a>
                        </div>
                        <div class="armclear"></div>
                    </div>
                    <div class="armclear"></div>
                    <div class="arm_add_template_options_wrapper">
                        <div class="page_sub_title"><?php _e('Template Options', 'ARMember'); ?></div>
                        <div class="arm_solid_divider"></div>
                        <div class="arm_template_option_block">
                            <div class="arm_opt_title"><?php _e('Select Template', 'ARMember'); ?></div>
                            <div class="arm_opt_content">
                                <?php if (!empty($defaultTemplates)): ?>
                                    <?php
                                    $templateTypes = array();
                                    foreach ($defaultTemplates as $temp) {
                                        $templateTypes[$temp['arm_type']][] = $temp;
                                        if (is_file(MEMBERSHIPLITE_VIEWS_DIR . '/templates/' . $temp['arm_slug'] . '.css')) {
                                            wp_enqueue_style('arm_template_style_' . $temp['arm_slug'], MEMBERSHIPLITE_VIEWS_URL . '/templates/' . $temp['arm_slug'] . '.css', array(), MEMBERSHIPLITE_VERSION);
                                        }
                                    }
                                    ?>
                                    <?php
                                    $i = 0;
                                    foreach ($templateTypes as $type => $temps):
                                        ?>
                                        <?php foreach ($temps as $temp): ?>

                                            <label class="arm_tempalte_type_box arm_temp_<?php echo $type; ?>_options <?php echo ($i == 0) ? 'arm_active_temp' : ''; ?>" data-type="<?php echo $type; ?>" for="arm_temp_type_<?php echo $temp['arm_slug']; ?>" style="<?php echo ($type == $tempType ? '' : 'display:none;'); ?>">
                                                <input type="radio" name="template_options[<?php echo $type; ?>]" id="arm_temp_type_<?php echo $temp['arm_slug']; ?>" class="arm_temp_type_radio arm_temp_type_radio_<?php echo $type; ?>" value="<?php echo $temp['arm_slug']; ?>" <?php echo ($i == 0) ? 'checked="checked"' : ''; ?> data-type="<?php echo $type; ?>">
                                                <img alt="" src="<?php echo MEMBERSHIPLITE_VIEWS_URL . '/templates/' . $temp['arm_slug'] . '.png'; ?>"/>
                                                <span class="arm_temp_selected_text"><?php _e('Selected', 'ARMember'); ?></span>
                                            </label>
                                            <?php
                                            $i++;
                                        endforeach;
                                        ?>
                                        <?php $i = 0; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="arm_solid_divider"></div>
                        <div class="arm_template_option_block">
                            <div class="arm_opt_title"><?php _e('Color Scheme', 'ARMember'); ?></div>
                            <div class="arm_opt_content">
                                <div class="c_schemes arm_padding_left_5" >
                                    <?php foreach ($tempColorSchemes as $color => $color_opt): ?>
                                        <label class="arm_temp_color_scheme_block arm_temp_color_scheme_block_<?php echo $color; ?> <?php echo ($color == $tempCS) ? 'arm_color_box_active' : ''; ?>">
                                            <span style="background-color:<?php echo $color_opt['button_color']; ?>;"></span>
                                            <span style="background-color:<?php echo $color_opt['tab_bg_color']; ?>;"></span>
                                            <input type="radio" id="arm_temp_color_radio_<?php echo $color; ?>" name="template_options[color_scheme]" value="<?php echo $color; ?>" class="arm_temp_color_radio" data-type="<?php echo $temp['arm_type']; ?>" <?php checked($tempCS, $color); ?>/>
                                        </label>
                                    <?php endforeach; ?>
                                    <label class="arm_temp_color_scheme_block arm_temp_color_scheme_block_custom <?php echo ($color == 'custom') ? 'arm_color_box_active' : ''; ?>">
                                        <input type="radio" id="arm_temp_color_radio_custom" name="template_options[color_scheme]" value="custom" class="arm_temp_color_radio" data-type="<?php echo $tempType; ?>" <?php checked($tempCS, 'custom'); ?>/>
                                    </label>
                                </div>
                                <div class="armclear arm_height_1" ></div>
                                <div class="arm_temp_color_options" id="arm_temp_color_options" style="<?php echo ($color == 'custom') ? '' : 'display:none;'; ?>">
                                    <div class="arm_custom_color_opts">
                                        <label class="arm_opt_label"><?php _e('Title Color', 'ARMember'); ?></label>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[title_color]" id="arm_title_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['title_color'])) ? $tempColorSchemes[$tempCS]['title_color'] : '#000000'; ?>">
                                            <span><?php _e('Main Title', 'ARMember'); ?></span>
                                        </div>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[subtitle_color]" id="arm_subtitle_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['subtitle_color'])) ? $tempColorSchemes[$tempCS]['subtitle_color'] : '#000000'; ?>">
                                            <span><?php _e('Sub Title', 'ARMember'); ?></span>
                                        </div>
                                    </div>
                                    <div class="arm_custom_color_opts">
                                        <label class="arm_opt_label"><?php _e('Button Color', 'ARMember'); ?></label>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[button_color]" id="arm_button_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['button_color'])) ? $tempColorSchemes[$tempCS]['button_color'] : '#000000'; ?>">
                                            <span><?php _e('Background', 'ARMember'); ?></span>
                                        </div>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[button_font_color]" id="arm_button_font_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['button_font_color'])) ? $tempColorSchemes[$tempCS]['button_font_color'] : '#000000'; ?>">
                                            <span><?php _e('Text', 'ARMember'); ?></span>
                                        </div>
                                    </div>
                                    <div class="arm_custom_color_opts arm_temp_directory_options">
                                        <label class="arm_opt_label"><?php _e('Effect Color', 'ARMember'); ?></label>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[border_color]" id="arm_border_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['border_color'])) ? $tempColorSchemes[$tempCS]['border_color'] : '#000000'; ?>">
                                            <span><?php _e('Box Hover', 'ARMember'); ?></span>
                                        </div>
                                    </div>
                                    <div class="arm_custom_color_opts arm_temp_directory_options atm_temp_3_opt">
                                        <label class="arm_opt_label"><?php _e('Background Color', 'ARMember'); ?></label>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[box_bg_color]" id="arm_box_bg_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['box_bg_color'])) ? $tempColorSchemes[$tempCS]['box_bg_color'] : '#000000'; ?>">
                                            <span><?php _e('Top Belt', 'ARMember'); ?></span>
                                        </div>
                                    </div>
                                    <div class="arm_custom_color_opts arm_temp_profile_options">
                                        <label class="arm_opt_label"><?php _e('Tab Color', 'ARMember'); ?></label>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[tab_bg_color]" id="arm_tab_bg_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['tab_bg_color'])) ? $tempColorSchemes[$tempCS]['tab_bg_color'] : '#000000'; ?>">
                                            <span><?php _e('Background', 'ARMember'); ?></span>
                                        </div>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[tab_link_color]" id="arm_tab_link_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['tab_link_color'])) ? $tempColorSchemes[$tempCS]['tab_link_color'] : '#000000'; ?>">
                                            <span><?php _e('Link Text', 'ARMember'); ?></span>
                                        </div>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[tab_link_bg_color]" id="arm_tab_link_bg_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['tab_link_bg_color'])) ? $tempColorSchemes[$tempCS]['tab_link_bg_color'] : '#000000'; ?>">
                                            <span><?php _e('Link Background', 'ARMember'); ?></span>
                                        </div>
                                    </div>
                                    <div class="arm_custom_color_opts arm_temp_profile_options">
                                        <label class="arm_opt_label"><?php _e('Active Tab Color', 'ARMember'); ?></label>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[tab_link_hover_color]" id="arm_tab_link_hover_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['tab_link_hover_color'])) ? $tempColorSchemes[$tempCS]['tab_link_hover_color'] : '#000000'; ?>">
                                            <span><?php _e('Link Text', 'ARMember'); ?></span>
                                        </div>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[tab_link_hover_bg_color]" id="arm_tab_link_hover_bg_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['tab_link_hover_bg_color'])) ? $tempColorSchemes[$tempCS]['tab_link_hover_bg_color'] : '#000000'; ?>">
                                            <span><?php _e('Link Background', 'ARMember'); ?></span>
                                        </div>
                                    </div>
                                    <div class="arm_custom_color_opts">
                                        <label class="arm_opt_label"><?php _e('Other Link Color', 'ARMember'); ?></label>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[link_color]" id="arm_link_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['link_color'])) ? $tempColorSchemes[$tempCS]['link_color'] : '#000000'; ?>">
                                            <span><?php _e('Link Text', 'ARMember'); ?></span>
                                        </div>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[link_hover_color]" id="arm_link_hover_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['link_hover_color'])) ? $tempColorSchemes[$tempCS]['link_hover_color'] : '#000000'; ?>">
                                            <span><?php _e('Link Hover', 'ARMember'); ?></span>
                                        </div>
                                    </div>
                                    <div class="arm_custom_color_opts arm_temp_profile_options">
                                        <label class="arm_opt_label"><?php _e('Body Content Color', 'ARMember'); ?></label>
                                        <div class="arm_custom_color_picker">
                                            <input type="text" name="template_options[content_font_color]" id="arm_content_font_color" class="arm_colorpicker" value="<?php echo (isset($tempColorSchemes[$tempCS]['content_font_color'])) ? $tempColorSchemes[$tempCS]['content_font_color'] : '#000000'; ?>">
                                            <span><?php _e('Content Text', 'ARMember'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="arm_solid_divider"></div>
                        <div class="arm_template_option_block">
                            <div class="arm_opt_title"><?php _e('Font Settings', 'ARMember'); ?></div>
                            <div class="arm_opt_content">
                                <?php
                                $fontOptions = array(
                                    'title_font' => __('Title Font', 'ARMember'),
                                    'subtitle_font' => __('Sub Title Font', 'ARMember'),
                                    'button_font' => __('Button Font', 'ARMember'),
                                    'content_font' => __('Content Font', 'ARMember'),
                                );
                                ?>
                                <?php foreach ($fontOptions as $key => $value): ?>
                                    <div class="arm_temp_font_opts_box">
                                        <div class="arm_opt_label"><?php echo $value; ?></div>
                                        <div class="arm_temp_font_opts">
                                            <input type="hidden" id="arm_template_font_family_<?php echo $key; ?>" name="template_options[<?php echo $key; ?>][font_family]" value="<?php echo $fonts_option[$key]['font_family']; ?>"/>
                                            <dl class="arm_selectbox column_level_dd arm_margin_right_10 arm_width_230">
                                                <dt><span></span><input type="text" style="display:none;" value="" class="arm_autocomplete"  /><i class="armfa armfa-caret-down armfa-lg"></i></dt>
                                                <dd>
                                                    <ul data-id="arm_template_font_family_<?php echo $key; ?>"><?php echo $arm_member_forms->arm_fonts_list(); ?></ul>
                                                </dd>
                                            </dl>
                                            <?php
                                            $fontSize = '14';
                                            if ($key == 'content_font') {
                                                $fontSize = '16';
                                            }
                                            ?>
                                            <input type="hidden" id="arm_template_font_size_<?php echo $key; ?>" name="template_options[<?php echo $key; ?>][font_size]" value="<?php echo $fontSize; ?>"/>
                                            <dl class="arm_selectbox column_level_dd arm_margin_right_10 arm_width_90">
                                                <dt><span></span><input type="text" style="display:none;" value="" class="arm_autocomplete"  /><i class="armfa armfa-caret-down armfa-lg"></i></dt>
                                                <dd>
                                                    <ul data-id="arm_template_font_size_<?php echo $key; ?>">
                                                        <?php for ($i = 8; $i < 41; $i++): ?>
                                                            <li data-label="<?php echo $i; ?> px" data-value="<?php echo $i; ?>"><?php echo $i; ?> px</li>
                                                        <?php endfor; ?>
                                                    </ul>
                                                </dd>
                                            </dl>
                                            <div class="arm_font_style_options arm_template_font_style_options">
                                                <label class="arm_font_style_label" data-value="bold" data-field="arm_template_font_bold_<?php echo $key; ?>"><i class="armfa armfa-bold"></i></label>
                                                <input type="hidden" name="template_options[<?php echo $key; ?>][font_bold]" id="arm_template_font_bold_<?php echo $key; ?>" class="arm_template_font_bold_<?php echo $key; ?>" value="" />
                                                <label class="arm_font_style_label" data-value="italic" data-field="arm_template_font_italic_<?php echo $key; ?>"><i class="armfa armfa-italic"></i></label>
                                                <input type="hidden" name="template_options[<?php echo $key; ?>][font_italic]" id="arm_template_font_italic_<?php echo $key; ?>" class="arm_template_font_italic_<?php echo $key; ?>" value="" />

											<label class="arm_font_style_label arm_decoration_label" data-value="underline" data-field="arm_template_font_decoration_<?php echo $key;?>"><i class="armfa armfa-underline"></i></label>
											<label class="arm_font_style_label arm_decoration_label" data-value="line-through" data-field="arm_template_font_decoration_<?php echo $key;?>"><i class="armfa armfa-strikethrough"></i></label>
											<input type="hidden" name="template_options[<?php echo $key;?>][font_decoration]" id="arm_template_font_decoration_<?php echo $key;?>" class="arm_template_font_decoration_<?php echo $key;?>" value="" />
										</div>
									</div>
								</div>
								<?php endforeach;?>
							</div>
						</div>
                                                
						<div class="arm_solid_divider"></div>
						<div class="arm_template_option_block">
							<div class="arm_opt_title"><?php _e('Other Options','ARMember'); ?></div>
							<div class="arm_opt_content">
                                                                <div class="arm_temp_opt_box">
									<div class="arm_opt_label"><?php _e('Display Administrator Users?','ARMember');?></div>
									<div class="arm_opt_content_wrapper">
										<div class="arm_temp_switch_wrapper">
											<div class="armswitch arm_global_setting_switch">
												<input type="checkbox" id="arm_temp_show_admin_users" value="1" class="armswitch_input" name="template_options[show_admin_users]"/>
												<label for="arm_temp_show_admin_users" class="armswitch_label"></label>
											</div>
										</div>
									</div>
								</div>
								
                                                                <div class="arm_temp_opt_box">
									<div class="arm_opt_label"><?php _e('Display Joining Date?','ARMember');?></div>
									<div class="arm_opt_content_wrapper">
										<div class="arm_temp_switch_wrapper">
											<div class="armswitch arm_global_setting_switch">
												<input type="checkbox" id="arm_temp_show_joining" value="1" class="armswitch_input" name="template_options[show_joining]" checked="checked"/>
												<label for="arm_temp_show_joining" class="armswitch_label"></label>
											</div>
										</div>
									</div>
								</div>
                                                                <div class="arm_temp_opt_box arm_temp_directory_options">
									<div class="arm_opt_label"><?php _e('Redirect To Author Archive Page','ARMember');?></div>
									<div class="arm_opt_content_wrapper">
										<div class="arm_temp_switch_wrapper">
											<div class="armswitch arm_global_setting_switch">
												<input type="checkbox" id="arm_temp_redirect_to_author" value="1" class="armswitch_input" name="template_options[redirect_to_author]"/>
												<label for="arm_temp_redirect_to_author" class="armswitch_label"></label>
											</div>
                                            <div class="armclear arm_height_1" ></div>
                                            <span class="arm_info_text arm_width_450" >(<?php _e("If Author have no any post than user will be redirect to ARMember Profile Page", 'ARMember');?>)</span>
										</div>
									</div>
								</div>
                                                              
                                                                <div class="arm_temp_opt_box arm_temp_profile_options">
									<div class="arm_opt_label"><?php _e('Hide empty profile fields?','ARMember');?></div>
									<div class="arm_opt_content_wrapper">
										<div class="arm_temp_switch_wrapper">
											<div class="armswitch arm_global_setting_switch">
												<input type="checkbox" id="arm_temp_hide_empty_profile_fields" value="0" class="armswitch_input" name="template_options[hide_empty_profile_fields]"/>
												<label for="arm_temp_hide_empty_profile_fields" class="armswitch_label"></label>
											</div>
										</div>
									</div>
								</div>
								<div class="arm_temp_opt_box arm_subscription_plans_box">
									<div class="arm_opt_label"><?php _e('Select Membership Plans','ARMember');?></div>
									<div class="arm_opt_content_wrapper">
										<select id="arm_temp_plans" class="arm_chosen_selectbox arm_template_plans_select" name="template_options[plans][]" data-placeholder="<?php _e('Select Plan(s)..', 'ARMember');?>" multiple="multiple">
											<?php if (!empty($subs_data)): ?>
												<?php foreach ($subs_data as $sd): ?>
													<option class="arm_message_selectbox_op" value="<?php echo $sd['arm_subscription_plan_id'];?>"><?php echo stripslashes($sd['arm_subscription_plan_name']);?></option>
												<?php endforeach;?>
											<?php endif;?>
										</select>
										<div class="armclear arm_height_1" ></div>
                                        <span class="arm_temp_sub_plan_error arm_color_red" style="display:none;"><?php _e('Please select atleast one plan', 'ARMember'); ?></span>
										<span class="arm_info_text arm_temp_directory_options">(<?php _e("Leave blank to display all plan's members.", 'ARMember');?>)</span>
									</div>
								</div>
								<div class="arm_temp_opt_box arm_temp_directory_options">
									<div class="arm_opt_label"><?php _e('Filter Options','ARMember');?></div>
									<div class="arm_opt_content_wrapper arm_min_width_550">
										<div class="arm_temp_switch_wrapper">
											<div class="armswitch arm_global_setting_switch">
												<input type="checkbox" id="arm_temp_searchbox" value="1" class="armswitch_input" name="template_options[searchbox]" checked="checked"/>
												<label for="arm_temp_searchbox" class="armswitch_label"></label>
											</div>
											<label for="arm_temp_searchbox"><?php _e('Display Search Box?','ARMember');?></label>
										</div>
										<div class="arm_temp_switch_wrapper">
											<div class="armswitch arm_global_setting_switch">
												<input type="checkbox" id="arm_temp_sortbox" value="1" class="armswitch_input" name="template_options[sortbox]" checked="checked"/>
												<label for="arm_temp_sortbox" class="armswitch_label"></label>
											</div>
											<label for="arm_temp_sortbox"><?php _e('Display Sorting Options?','ARMember');?></label>
										</div>
									</div>
								</div>
                                <div class="arm_temp_opt_box arm_temp_directory_options">
									<div class="arm_opt_label"><?php _e('No. Of Members Per Page','ARMember');?></div>
									<div class="arm_opt_content_wrapper">
                                        <input id="arm_temp_per_page_users" type="text" onkeydown="javascript:return checkNumber(event)" value="10" name="template_options[per_page_users]" class="arm_width_70">
                                    </div>
                                </div>
                                <div class="arm_temp_opt_box arm_temp_directory_options">
                                    <div class="arm_opt_label"><?php _e('Pagination Style', 'ARMember'); ?></div>
                                    <div class="arm_opt_content_wrapper">
                                        <input type="radio" name="template_options[pagination]" value="numeric" id="arm_temp_pagination_numeric" class="arm_iradio" checked="checked"><label for="arm_temp_pagination_numeric"><span><?php echo _e('Numeric', 'ARMember'); ?></span></label>
                                        <input type="radio" name="template_options[pagination]" value="infinite" id="arm_temp_pagination_infinite" class="arm_iradio" checked="checked"><label for="arm_temp_pagination_infinite"><span><?php echo _e('Load More Link', 'ARMember'); ?></span></label>
                                    </div>
                                </div>
                                <!-- Socail Profile Fields Start-->
                                <div class="arm_temp_opt_box">
                                    <div class="arm_opt_label"><?php _e('Social Profile Fields', 'ARMember'); ?></div>
                                    <div class="arm_opt_content_wrapper">
                                        <div class="social_profile_fields">
                                            <?php 
                                            $socialProfileFields = $arm_member_forms->arm_social_profile_field_types();
											$activeSPF = array('facebook', 'twitter', 'linkedin');
											if (!empty($socialFieldsOptions)) {
											    $activeSPF = isset($socialFieldsOptions['arm_form_field_option']['options']) ? $socialFieldsOptions['arm_form_field_option']['options'] : array();
											}
											$activeSPF = (!empty($activeSPF)) ? $activeSPF : array(); ?>
											<div class="arm_social_profile_fields_list_wrapper">
								                <?php if (!empty($socialProfileFields)): ?>
								                    <?php foreach ($socialProfileFields as $spfKey => $spfLabel): ?>
								                        <div class="arm_social_profile_field_item">
								                            <input type="checkbox" class="arm_icheckbox arm_spf_active_checkbox" value="<?php echo $spfKey;?>" name="template_options[arm_social_fields][<?php echo $spfKey;?>]" id="arm_spf_<?php echo $spfKey;?>_status" <?php echo (in_array($spfKey, $activeSPF)) ? 'checked="checked"' : '';?>>
								                           <label for="arm_spf_<?php echo $spfKey;?>_status"><?php echo $spfLabel;?></label>
								                        </div>
								                    <?php endforeach;?>
								                <?php endif;?>
							                </div>
                                        </div>
									</div>
								</div>

								<!-- Socail Profile Fields End-->
                                                                
                                                                
                                                                
                                                                
                                                                <!-- Profile Fields Start-->
								<div class="arm_temp_opt_box arm_temp_directory_options">
									<div class="arm_opt_label"><?php _e('Search Members by Profile Fields','ARMember');?></div>
									<div class="arm_opt_content_wrapper">
                                        <div class="profile_search_fields">
                                            <?php 
                                                                                $dbProfileFields = $arm_members_directory->arm_template_profile_fields();
                                                                                
                                                                                
                                                                                
											$activePF = array('first_name', 'last_name');
											 ?>
											<div class="arm_profile_search_fields_list_wrapper">
								                <?php if (!empty($dbProfileFields)): ?>
                                                    <?php
                                                    foreach ($dbProfileFields as $pfKey => $pfLabel):
                                                        if (empty($pfKey) || $pfKey == 'user_pass' || in_array($pfLabel['type'], array('html', 'section', 'rememberme', 'file', 'avatar', 'password', 'roles'))) {
                                                            continue;
                                                        }
                                                        ?>
                                                        <div class="arm_profile_search_field_item">
                                                            <input type="checkbox" class="arm_icheckbox arm_pf_active_checkbox" value="<?php echo $pfKey; ?>" name="template_options[profile_fields][<?php echo $pfKey; ?>]" id="arm_pf_<?php echo $pfKey; ?>_status" <?php echo (in_array($pfKey, $activePF)) ? 'checked="checked"' : ''; ?>>
                                                            <label for="arm_pf_<?php echo $pfKey; ?>_status"><?php echo stripslashes($pfLabel['label']); ?></label>
                                                        </div>
    <?php endforeach; ?>
<?php endif; ?>
                                            </div>
                                        </div>
									</div>
								</div>

                                <!-- Profile Fields End-->
								
								<div class="armclear"></div>
								<div class="arm_temp_opt_box">
									<div class="arm_opt_label"></div>
									<div class="arm_opt_content_wrapper">
										<button type="submit" class="arm_save_btn arm_add_template_submit" data-type="directory"><?php _e('Save', 'ARMember');?></button>
									</div>
								</div>
							</div>
						</div>
						<div class="armclear"></div>
					</div>
				</form>
			</div>
                    
                    
    
               
                        
                        <?php 
                        
                        $temp_id = 1;
				$tempType =  'profile';
				if (!empty($temp_id) && $temp_id != 0) {
					$tempDetails = $arm_members_directory->arm_get_template_by_id($temp_id);
                                       
					if (!empty($tempDetails)) {
                                            
                                            
                                           
						$tempType = isset($tempDetails['arm_type']) ? $tempDetails['arm_type'] : 'directory';
						$tempOptions = $tempDetails['arm_options'];
						$popup = '<div class="arm_ptemp_add_popup_wrapper popup_wrapper" >';
                        $is_rtl_form = is_rtl() ? 'arm_add_form_rtl' : '';
						$popup .= '<form action="#" method="post" class="arm_profile_template_add_form arm_admin_form '.$is_rtl_form.'" onsubmit="return false;" id="arm_profile_template_add_form" data-temp_id="'.$temp_id.'">';
                                                        $popup .= '<table cellspacing="0">';
							$popup .= '<tr class="popup_wrapper_inner">';
								$popup .= '<td class="popup_header">';
									$popup .= '<span class="popup_close_btn arm_popup_close_btn arm_add_profile_template_popup_close_btn"></span>';
									$popup .= '<span>' . __('Select Profile Template', 'ARMember') . '</span>';
								$popup .= '</td>';
								$popup .= '<td class="popup_content_text">';
									$popup .= $arm_members_directory->arm_profile_template_options($tempType);
								$popup .= '</td>';
								$popup .= '<td class="popup_content_btn popup_footer">';
									$popup .= '<input type="hidden" name="id" id="arm_pdtemp_edit_id" value="'.$temp_id.'">';
									$popup .= '<div class="popup_content_btn_wrapper arm_temp_option_wrapper">';
                    $popup .= '<input type="hidden" id="arm_admin_url" value="'.admin_url('admin.php?page='.$arm_slugs->profiles_directories.'&action=add_profile').'" />';
                    $popup .= '<button class="arm_save_btn arm_profile_next_submit" data-id="' . $temp_id . '" type="submit" name="arm_add_profile" id="arm_profile_next_submit">' . __('OK', 'ARMember') . '</button>';
									$popup .= '<button class="arm_cancel_btn arm_profile_add_close_btn" type="button">'.__('Cancel', 'ARMember').'</button>';
									$popup .= '</div>';
									$popup .= '<div class="popup_content_btn_wrapper arm_temp_custom_class_btn hidden_section">';
									$backToListingIcon = MEMBERSHIPLITE_IMAGES_URL.'/back_to_listing_arrow.png';
									$popup .= '<a href="javascript:void(0)" class="arm_section_custom_css_detail_hide_template armemailaddbtn"><img src="' . $backToListingIcon . '"/>' . __('Back to template options', 'ARMember') . '</a>';
									$popup .= '</div>';
								$popup .= '</td>';
							$popup .= '</tr>';
							$popup .= '</table>';
						$popup .= '</form>';
						echo $popup .= '</div>';
                                                
                                                
                                                
						
					} 
				}
        ?>
		</div>
		<div class="armclear"></div>
        <?php wp_nonce_field( 'arm_wp_nonce' );?>
		<div id="arm_profile_directory_template_preview" class="arm_profile_directory_template_preview"></div>
		<div id="arm_pdtemp_edit_popup_container" class="arm_pdtemp_edit_popup_container"></div>
	</div>
	<div class="arm_section_custom_css_detail_container"></div>
        
        <?php 
		
		/* **********./Begin Bulk Delete Member Popup/.********** */
		$arm_template_change_message_popup_content = '<span class="arm_confirm_text">'.__("Plese confirm that while changing Template, all colors will be reset to default.",'ARMember' );
		$arm_template_change_message_popup_content .= '<input type="hidden" value="false" id="bulk_delete_flag"/>';
		$arm_template_change_message_popup_arg = array(
			'id' => 'arm_template_change_message',
			'class' => 'arm_template_change_message',
			'title' => __('Change Directory Template', 'ARMember'),
			'content' => $arm_template_change_message_popup_content,
			'button_id' => 'arm_template_change_message_ok_btn',
			'button_onclick' => "arm_template_change_message_action('bulk_delete_flag');",
		);
		echo $arm_global_settings->arm_get_bpopup_html($arm_template_change_message_popup_arg);
                ?>
</div>
<style type="text/css" title="currentStyle">
	#adminmenuback{z-index: 101;}
	#adminmenuwrap{z-index: 9990;}
</style>
<script type="text/javascript">
function armTempColorSchemes() {
	var tempColorSchemes = <?php echo json_encode($tempColorSchemes);?>;
	return tempColorSchemes;
}
function armTempColorSchemes1() {
	var tempColorSchemes = <?php echo json_encode($tempColorSchemes1);?>;
	return tempColorSchemes;
}
function setAdminStickyTopMenu() {
	var h = jQuery(document).height() - jQuery(window).height();
	var sp = jQuery(window).scrollTop();
	var p = parseInt(sp / h * 100);
	if (p >= 10) {
		if(jQuery('.arm_add_profiles_directories_templates.arm_visible .arm_sticky_top_belt').length > 0){
			jQuery('.arm_add_profiles_directories_templates.arm_visible .arm_sticky_top_belt').slideDown(600);
		} else {
			jQuery('.arm_sticky_top_belt').slideUp(600);
		}
	} else {
		jQuery('.arm_sticky_top_belt').slideUp(600);
	}
}
jQuery(document).ready(function (e) {
	setAdminStickyTopMenu();
});
jQuery(window).scroll(function () {
	setAdminStickyTopMenu();
});
jQuery(window).on("load", function(){
	var popupH = jQuery('.arm_template_preview_popup').height();
	jQuery('.arm_template_preview_popup .popup_content_text').css('height', (popupH - 60)+'px');
	var contentHeight = jQuery('.arm_visible').outerHeight();
	jQuery('.arm_profiles_directories_templates_container').css('height', contentHeight + 20);
});
jQuery(window).resize(function(){
	var popupH = jQuery('.arm_template_preview_popup').height();
	jQuery('.arm_template_preview_popup .popup_content_text').css('height', (popupH - 60)+'px');
	var contentHeight = jQuery('.arm_visible').outerHeight();
	jQuery('.arm_profiles_directories_templates_container').css('height', contentHeight + 20);
});
</script>