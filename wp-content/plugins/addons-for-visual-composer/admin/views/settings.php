<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$theme_color = lvca_get_option( 'lvca_theme_color', '#f94213' );
$theme_hover_color = lvca_get_option( 'lvca_theme_hover_color', '#888888' );
$debug_mode = lvca_get_option( 'lvca_enable_debug', false );
$custom_css = lvca_get_option( 'lvca_custom_css', '' );
/* Deactivation of WPBakery Page Builder Elements */
$deactivate_element_accordion = lvca_get_option( 'lvca_deactivate_element_accordion', false );
$deactivate_element_carousel = lvca_get_option( 'lvca_deactivate_element_carousel', false );
$deactivate_element_clients = lvca_get_option( 'lvca_deactivate_element_clients', false );
$deactivate_element_heading = lvca_get_option( 'lvca_deactivate_element_heading', false );
$deactivate_element_odometers = lvca_get_option( 'lvca_deactivate_element_odometers', false );
$deactivate_element_piecharts = lvca_get_option( 'lvca_deactivate_element_piecharts', false );
$deactivate_element_portfolio = lvca_get_option( 'lvca_deactivate_element_portfolio', false );
$deactivate_element_posts_carousel = lvca_get_option( 'lvca_deactivate_element_posts_carousel', false );
$deactivate_element_pricing_table = lvca_get_option( 'lvca_deactivate_element_pricing_table', false );
$deactivate_element_spacer = lvca_get_option( 'lvca_deactivate_element_spacer', false );
$deactivate_element_services = lvca_get_option( 'lvca_deactivate_element_services', false );
$deactivate_element_stats_bar = lvca_get_option( 'lvca_deactivate_element_stats_bar', false );
$deactivate_element_tabs = lvca_get_option( 'lvca_deactivate_element_tabs', false );
$deactivate_element_team = lvca_get_option( 'lvca_deactivate_element_team', false );
$deactivate_element_testimonials = lvca_get_option( 'lvca_deactivate_element_testimonials', false );
$deactivate_element_testimonials_slider = lvca_get_option( 'lvca_deactivate_element_testimonials_slider', false );
?>

<div class="lvca-settings">

    <div class="postbox">

        <!-------------------
        OPTIONS HOLDER START
        -------------------->
        <div class="lvca-menu-options settings-options">

            <div class="lvca-inner">

                <!-------------------  LI TABS -------------------->

                <ul class="lvca-tabs-wrap">
                    <li class="lvca-tab selected" data-target="general"><i
                            class="lvca-icon dashicons dashicons-admin-generic"></i><?php 
echo  __( 'General', 'livemesh-vc-addons' ) ;
?>
                    </li>
                    <li class="lvca-tab" data-target="elements"><i
                                class="lvca-icon dashicons dashicons-admin-settings"></i><?php 
echo  __( 'Elements', 'livemesh-vc-addons' ) ;
?>
                    </li>
                    <li class="lvca-tab" data-target="custom-css"><i
                            class="lvca-icon dashicons dashicons-editor-code"></i><?php 
echo  __( 'Custom CSS', 'livemesh-vc-addons' ) ;
?>
                    </li>
                    <li class="lvca-tab" data-target="debugging"><i
                            class="lvca-icon dashicons dashicons-warning"></i><?php 
echo  __( 'Debugging', 'livemesh-vc-addons' ) ;
?>
                    </li>
                    <li class="lvca-tab" data-target="premium-version"><i
                            class="lvca-icon dashicons dashicons-yes"></i><?php 
echo  __( 'Premium Version', 'livemesh-vc-addons' ) ;
?>
                    </li>
                </ul>

                <!-------------------  GENERAL TAB -------------------->

                <div class="lvca-tab-content general lvca-tab-show">

                    <!---- Theme Colors -->
                    <div class="lvca-box-side">
                        <h3><?php 
echo  __( 'Theme Colors', 'livemesh-vc-addons' ) ;
?></h3>
                    </div>
                    <div class="lvca-inner lvca-box-inner">
                        <div class="lvca-row lvca-field">
                            <label
                                class="lvca-label"><?php 
echo  __( 'Theme Color Scheme', 'livemesh-vc-addons' ) ;
?></label>
                            <p class="lvca-desc"><?php 
echo  __( 'Most themes use a single color as a major color across the site. This color is often used for links, titles, buttons, icons, highlights etc. <br> To maintain the consistent look with the theme, specify the default color used by the theme activated on your site. This color will be applied to the addon elements by default. <br>The hover color refers to the color set for links on mouse hover.', 'livemesh-vc-addons' ) ;
?></p>
                        </div>

                        <div class="lvca-clearfix"></div>

                        <!---- Theme color -->
                        <div class="lvca-row lvca-field lvca-type-color">
                            <label class="lvca-label"><?php 
echo  __( 'Theme Color', 'livemesh-vc-addons' ) ;
?></label>
                            <p class="lvca-desc"><?php 
echo  __( 'Select the default theme color.', 'livemesh-vc-addons' ) ;
?></p>
                            <div class="lvca-spacer" style="height: 5px"></div>
                            <input class="lvca-colorpicker" name="lvca_theme_color" type="text"
                                   data-default="#f94213" value="<?php 
echo  $theme_color ;
?>"/>
                        </div>


                        <div class="lvca-spacer"></div>

                        <!---- Theme Hover color -->
                        <div class="lvca-row lvca-field lvca-type-color">
                            <label class="lvca-label"><?php 
echo  __( 'Theme Hover Color', 'livemesh-vc-addons' ) ;
?></label>
                            <p class="lvca-desc"><?php 
echo  __( 'Select the default hover color for your theme.', 'livemesh-vc-addons' ) ;
?></p>
                            <div class="lvca-spacer" style="height: 5px"></div>
                            <input class="lvca-colorpicker" name="lvca_theme_hover_color" type="text"
                                   data-default="#888888" value="<?php 
echo  $theme_hover_color ;
?>"/>
                        </div>



                    </div>

                    <div class="lvca-clearfix"></div>
                    

                </div>



                <!-------------------  ELEMENTS TAB -------------------->

                <div class="lvca-tab-content elements">

                    <!---- Auto activate WPBakery Page Builder Addons -->
                    <div class="lvca-box-side">

                        <h3><?php 
echo  __( 'Optimize Plugin', 'livemesh-vc-addons' ) ;
?></h3>

                    </div>

                    <div class="lvca-inner lvca-box-inner">


                        <div class="lvca-row lvca-field">
                            <label class="lvca-label"><?php 
echo  __( 'Deactivate elements for better performance', 'livemesh-vc-addons' ) ;
?></label>

                            <p class="lvca-desc"><?php 
echo  __( 'You can deactivate those elements that you do not intend to use to avoid loading scripts and files related to those elements.', 'livemesh-vc-addons' ) ;
?></p>
                        </div>

                        <div class="lvca-spacer" style="height: 15px"></div>

                        <div class="lvca-elements-deactivate">

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Accordion', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the accordion element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox"
                                           name="lvca_deactivate_element_accordion"
                                           id="lvca_deactivate_element_accordion" data-default=""
                                           value="<?php 
echo  $deactivate_element_accordion ;
?>" <?php 
echo  checked( !empty($deactivate_element_accordion), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_accordion"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Carousel', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the carousel element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox" name="lvca_deactivate_element_carousel"
                                           id="lvca_deactivate_element_carousel" data-default=""
                                           value="<?php 
echo  $deactivate_element_carousel ;
?>" <?php 
echo  checked( !empty($deactivate_element_carousel), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_carousel"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Clients', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the clients element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox" name="lvca_deactivate_element_clients"
                                           id="lvca_deactivate_element_clients" data-default=""
                                           value="<?php 
echo  $deactivate_element_clients ;
?>" <?php 
echo  checked( !empty($deactivate_element_clients), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_clients"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Heading', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the heading element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox" name="lvca_deactivate_element_heading"
                                           id="lvca_deactivate_element_heading" data-default=""
                                           value="<?php 
echo  $deactivate_element_heading ;
?>" <?php 
echo  checked( !empty($deactivate_element_heading), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_heading"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Odometers', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the odometers element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox"
                                           name="lvca_deactivate_element_odometers"
                                           id="lvca_deactivate_element_odometers" data-default=""
                                           value="<?php 
echo  $deactivate_element_odometers ;
?>" <?php 
echo  checked( !empty($deactivate_element_odometers), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_odometers"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Piecharts', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the piecharts element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox"
                                           name="lvca_deactivate_element_piecharts"
                                           id="lvca_deactivate_element_piecharts" data-default=""
                                           value="<?php 
echo  $deactivate_element_piecharts ;
?>" <?php 
echo  checked( !empty($deactivate_element_piecharts), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_piecharts"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Portfolio', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the portfolio element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox"
                                           name="lvca_deactivate_element_portfolio"
                                           id="lvca_deactivate_element_portfolio" data-default=""
                                           value="<?php 
echo  $deactivate_element_portfolio ;
?>" <?php 
echo  checked( !empty($deactivate_element_portfolio), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_portfolio"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Posts Carousel', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the posts carousel element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox"
                                           name="lvca_deactivate_element_posts_carousel"
                                           id="lvca_deactivate_element_posts_carousel" data-default=""
                                           value="<?php 
echo  $deactivate_element_posts_carousel ;
?>" <?php 
echo  checked( !empty($deactivate_element_posts_carousel), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_posts_carousel"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Pricing Table', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the pricing table element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox"
                                           name="lvca_deactivate_element_pricing_table"
                                           id="lvca_deactivate_element_pricing_table" data-default=""
                                           value="<?php 
echo  $deactivate_element_pricing_table ;
?>" <?php 
echo  checked( !empty($deactivate_element_pricing_table), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_pricing_table"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Spacer', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the spacer element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox" name="lvca_deactivate_element_spacer"
                                           id="lvca_deactivate_element_spacer" data-default=""
                                           value="<?php 
echo  $deactivate_element_spacer ;
?>" <?php 
echo  checked( !empty($deactivate_element_spacer), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_spacer"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Services', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the services element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox" name="lvca_deactivate_element_services"
                                           id="lvca_deactivate_element_spacer" data-default=""
                                           value="<?php 
echo  $deactivate_element_services ;
?>" <?php 
echo  checked( !empty($deactivate_element_services), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_services"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Stats Bars', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the stats bars element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox"
                                           name="lvca_deactivate_element_stats_bar"
                                           id="lvca_deactivate_element_stats_bar" data-default=""
                                           value="<?php 
echo  $deactivate_element_stats_bar ;
?>" <?php 
echo  checked( !empty($deactivate_element_stats_bar), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_stats_bar"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Tabs', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the tabs element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox" name="lvca_deactivate_element_tabs"
                                           id="lvca_deactivate_element_tabs" data-default=""
                                           value="<?php 
echo  $deactivate_element_tabs ;
?>" <?php 
echo  checked( !empty($deactivate_element_tabs), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_tabs"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Team', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the team element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox" name="lvca_deactivate_element_team"
                                           id="lvca_deactivate_element_team" data-default=""
                                           value="<?php 
echo  $deactivate_element_team ;
?>" <?php 
echo  checked( !empty($deactivate_element_team), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_team"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Testimonials', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the testimonials element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox"
                                           name="lvca_deactivate_element_testimonials"
                                           id="lvca_deactivate_element_testimonials" data-default=""
                                           value="<?php 
echo  $deactivate_element_testimonials ;
?>" <?php 
echo  checked( !empty($deactivate_element_testimonials), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_testimonials"></label>
                                </div>
                            </div>

                            <div class="lvca-row lvca-type-checkbox lvca-field">
                                <label class="lvca-label"><?php 
echo  __( 'Deactivate Testimonials Slider', 'livemesh-vc-addons' ) ;
?></label>
                                <p class="lvca-desc"><?php 
echo  __( 'Deactivate the testimonials slider element.', 'livemesh-vc-addons' ) ;
?></p>
                                <div class="lvca-spacer" style="height: 5px"></div>
                                <div class="lvca-toggle">
                                    <input type="checkbox" class="lvca-checkbox"
                                           name="lvca_deactivate_element_testimonials_slider"
                                           id="lvca_deactivate_element_testimonials_slider" data-default=""
                                           value="<?php 
echo  $deactivate_element_testimonials_slider ;
?>" <?php 
echo  checked( !empty($deactivate_element_testimonials_slider), 1, false ) ;
?>>
                                    <label for="lvca_deactivate_element_testimonials_slider"></label>
                                </div>
                            </div>
                            
                            <?php 
?>

                        </div>

                    </div>

                    <div class="lvca-spacer"></div>

                    <div class="lvca-clearfix"></div>

                </div>

                <!------------------- Custom CSS TAB -------------------->

                <div class="lvca-tab-content custom-css">

                    <!---- Custom CSS -->
                    <div class="lvca-box-side">
                        <h3><?php 
echo  __( 'Custom CSS', 'livemesh-vc-addons' ) ;
?></h3>
                    </div>
                    <div class="lvca-inner lvca-box-inner">

                        <div class="lvca-row lvca-field lvca-custom-css">
                            <label
                                class="lvca-label"><?php 
echo  __( 'Custom CSS', 'livemesh-vc-addons' ) ;
?></label>
                            <div class="lvca-spacer" style="height: 5px"></div>
                            <p class="lvca-desc"><?php 
echo  __( 'Please enter custom CSS for custom styling of elements', 'livemesh-vc-addons' ) ;
?></p>

                            <div class="lvca-spacer" style="height: 15px"></div>

                            <textarea class="lvca-textarea" name="lvca_custom_css" id="lvca_custom_css" rows="20" cols="120"><?php 
echo  $custom_css ;
?></textarea>

                        </div>
                    </div>

                    <div class="lvca-clearfix"></div>

                </div>

                <!------------------- Debugging TAB -------------------->

                <div class="lvca-tab-content debugging">

                    <!---- Enable script debugging -->
                    <div class="lvca-box-side">
                        <h3><?php 
echo  __( 'Debug Mode', 'livemesh-vc-addons' ) ;
?></h3>
                    </div>
                    <div class="lvca-inner lvca-box-inner">
                        <div class="lvca-spacer" style="height: 15px"></div>
                        <label
                            class="lvca-label lvca-label-outside"><?php 
echo  __( 'Enable Script Debug Mode', 'livemesh-vc-addons' ) ;
?></label>
                        <div class="lvca-row lvca-type-checkbox lvca-field">
                            <p class="lvca-desc"><?php 
echo  __( 'Use unminified Javascript files instead of minified ones to help developers debug an issue', 'livemesh-vc-addons' ) ;
?></p>
                            <div class="lvca-toggle">
                                <input type="checkbox" class="lvca-checkbox" name="lvca_enable_debug" id="lvca_enable_debug"
                                       data-default="" value="<?php 
echo  $debug_mode ;
?>" <?php 
echo  checked( !empty($debug_mode), 1, false ) ;
?>>
                                <label for="lvca_enable_debug"></label>
                            </div>
                        </div>
                    </div>

                    <div class="lvca-clearfix"></div>

                    <!---- System Info -->
                    <div class="lvca-box-side">
                        <h3><?php 
echo  __( 'System Info', 'livemesh-vc-addons' ) ;
?></h3>
                    </div>
                    <div class="lvca-inner lvca-box-inner">

                        <div class="lvca-row lvca-field">
                            <label
                                class="lvca-label"><?php 
echo  __( 'System Information', 'livemesh-vc-addons' ) ;
?></label>
                            <p class="lvca-desc"><?php 
echo  __( 'Server setup information useful for debugging purposes.', 'livemesh-vc-addons' ) ;
?></p>

                            <div class="lvca-spacer" style="height: 15px"></div>

                            <p class="debug-info"><?php 
echo  nl2br( lvca_get_sysinfo() ) ;
?></p>
                        </div>

                    </div>

                    <div class="lvca-clearfix"></div>

                </div>

                <!------------------- PREMIUM VERSION TAB -------------------->

                <div class="lvca-tab-content premium-version">

                    <!---- Premium Version Information -->
                    <div class="lvca-box-side">
                        <h3><?php 
echo  __( 'Premium Version', 'livemesh-vc-addons' ) ;
?></h3>
                    </div>
                    <div class="lvca-inner lvca-box-inner">


                        <div class="lvca-row lvca-field lvca_premium_version">

                            <?php 

if ( lvca_fs()->is_not_paying() ) {
    ?>

                                <label class="lvca-label"><?php 
    echo  __( 'Why upgrade to Premium Version of the plugin?!', 'livemesh-vc-addons' ) ;
    ?></label>

                            <?php 
} else {
    ?>

                                <label class="lvca-label"><?php 
    echo  __( 'Thanks for upgrading to the Premium Version of the plugin!', 'livemesh-vc-addons' ) ;
    ?></label>

                            <?php 
}

?>
                            
                            <p>The premium version helps us to continue development of this plugin incorporating even
                                more features and enhancements along with offering more responsive support. Following are
                                some of the benefits you enjoy by upgrading to the premium version of this plugin.</p>

                            <label class="lvca-label">New Premium Widgets</label>

                            <p>Although the free version of the Addons for WPBakery Page Builder features a large repertoire of
                                premium quality elements with its numerous styles, the premium version does even more.</p>

                            <ul>
                                <li><strong>Image Slider</strong> - Create a responsive slider of images with support
                                    for captions,
                                    multiple slider types like Nivo, Flex, Slick and lightweight sliders, thumbnail
                                    navigation etc.
                                </li>
                                <li><strong>Image Gallery</strong> - Create a gallery of images with options for masonry
                                    or fit rows, pagination, lazy load, lightbox support etc.
                                </li>
                                <li><strong>Video Gallery</strong> - Create a beautiful gallery of videos to help
                                    showcase a collection of YouTube/Vimeo videos on your site.
                                </li>
                                <li><strong>Image Carousel</strong> - Build a responsive carousel of images.</li>
                                <li><strong>Video Carousel</strong> - Build a responsive carousel of YouTube/Vimeo
                                    videos.
                                </li>
                                <li><strong>Countdown</strong> - Use countdown element to display a countdown timer on
                                    your site pages such as those that feature events or under construction/coming soon
                                    pages.
                                </li>
                                <li><strong>Buttons</strong> - Animated buttons with great choice of colors.
                                </li>
                                <li><strong>Icon Lists</strong> - Create a list of icons with description and link - for social media profiles,
                                    for showcasing services or features as well with icons or images.
                                </li>
                                <li><strong>FAQ</strong> - Create a set of Frequently Asked Questions for display in a
                                    page.
                                </li>
                                <li><strong>Features Widget</strong> for showcasing product features or services
                                    provided by an agency/business.
                                </li>
                            </ul>

                            <div class="lvca-spacer" style="height: 15px"></div>

                            <?php 

if ( lvca_fs()->is_not_paying() ) {
    ?>

                                <a class="lvca-button purchase" href="<?php 
    echo  lvca_fs()->get_upgrade_url() ;
    ?>"><i class="dashicons dashicons-cart"></i><?php 
    echo  __( 'Purchase Now', 'livemesh-vc-addons' ) ;
    ?></a>

                                <div class="lvca-spacer" style="height: 25px"></div>

                            <?php 
}

?>

                            <label class="lvca-label">Additional Features</label>

                            <p>Along with incorporating many new elements into premium version, the pro version is being
                                updated with additional features for existing elements -</p>

                            <ul>
                                <li><strong>Lazy Load</strong> - The portfolio/post grid and image gallery elements
                                    incorporate option to lazy load posts/images with the click of a Load More button.
                                </li>
                                <li><strong>Pagination</strong> - Create a grid of posts or custom post types with AJAX
                                    based pagination support.
                                </li>
                                <li><strong>Lightbox Support</strong> - The premium version comes with support for
                                    Lightbox for grid and carousel elements.
                                </li>
                                <li><strong>Customizations</strong> - Ability to choose custom font sizes and colors for
                                    certain elements like services and icon lists.
                                </li>
                                <li><strong>Custom Animations</strong> - Choose from over <strong>40+ animations</strong>
                                    for most elements (excludes sliders, carousels and grid). The animations display on
                                    user scrolling to the element or when the element becomes visible in the browser window.
                                </li>
                                <li><strong>Sample Data</strong> - Sample data that you can import into your site to get
                                    started quickly on the addon elements and some sample layouts.
                                </li>
                            </ul>

                            <label class="lvca-label">Premium Support</label>

                            <p>We offer premium support for our paid customers with following benefits - </p>

                            <ul>
                                <li><strong>Dedicated Support Portal</strong> - The customers will be provided access to a
                                    dedicated support portal powered by Freshdesk.
                                </li>
                                <li><strong>Private Tickets</strong> - Private tickets help you work with us
                                    directly regarding the issues you are facing in your site by sharing the details of
                                    your site securely.
                                </li>
                                <li><strong>Faster turnaround</strong> - The threads opened by paid customers will be
                                    attended to within 24 hours of opening a ticket.
                                </li>
                                <li><strong>Bug fixes and Enhancements</strong> - Any fixes and enhancements made to the
                                    elements will be prioritized to arrive quicker on the premium version.
                                </li>
                                <li><strong>Proven Expertize</strong> - Having served over <strong>12,000+
                                        customers</strong> of our themes over past 3 years, the support provided by us
                                    is proven in competence and commitment.
                                </li>
                            </ul>

                            <div class="lvca-spacer" style="height: 25px"></div>

                            <?php 

if ( lvca_fs()->is_not_paying() ) {
    ?>

                                <a class="lvca-button purchase" href="<?php 
    echo  lvca_fs()->get_upgrade_url() ;
    ?>"><i class="dashicons dashicons-cart"></i><?php 
    echo  __( 'Go Premium', 'livemesh-vc-addons' ) ;
    ?></a>

                            <?php 
} else {
    ?>

                                <a class="lvca-button know-more" href="https://livemeshwp.com/wpbakery-addons/"><i class="dashicons dashicons-external"></i><?php 
    echo  __( 'Know More', 'livemesh-vc-addons' ) ;
    ?></a>

                            <?php 
}

?>
                            
                        </div>

                    </div>

                </div>

                <!-------------------  OPTIONS HOLDER END  -------------------->
            </div>
            
        </div>

        <!------------------- BUILD PANEL SETTINGS -------------------->

    </div>

</div>
