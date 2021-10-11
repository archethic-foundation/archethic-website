<?php
if (!class_exists('VC_Extensions_LoadingSlideShow')){
    class VC_Extensions_LoadingSlideShow{
        private $image_position = "left";
        private $item_height = "";
        private $text_color = "";
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Loading SlideShow", 'cq_allinone_vc'),
            "base" => "cq_vc_loadingslideshow",
            "class" => "cq_vc_loadingslideshow",
            "icon" => "cq_vc_loadingslideshow",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_loadingslideshow_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Slidehshow w/ loading animation', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Image position:", "cq_allinone_vc"),
                "param_name" => "imageposition",
                "value" => array("left" => "left", "right" => "right"),
                "std" => "left",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Loading bar position:", "cq_allinone_vc"),
                "param_name" => "barposition",
                "value" => array("top" => "top", "bottom" => "bottom", "none" => "none"),
                "std" => "top",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Text color:", 'cq_allinone_vc'),
                "param_name" => "textcolor",
                "value" => "",
                "description" => esc_attr__("Color for the slide text.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Animation bar color:", 'cq_allinone_vc'),
                "param_name" => "barcolor",
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Default bar background color:", 'cq_allinone_vc'),
                "param_name" => "barbgcolor",
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Auto delay slideshow", "cq_allinone_vc"),
                 "param_name" => "autoslide",
                 "value" => array("no", "2", "3", "4", "5", "6", "7", "8"),
                 "std" => "no",
                 "description" => esc_attr__("In seconds, default is no, which is disabled.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_column vc_col-xs-6",
                 "heading" => esc_attr__("Avatar size (in pixel)", "cq_allinone_vc"),
                 "param_name" => "avatarsize",
                 "value" => array("80", "100", "120", "160", "200", "240", "320"),
                 "std" => "100",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Transition style", "cq_allinone_vc"),
                 "param_name" => "transition",
                 "value" => array("Slide" => "slide", "Flip" => "flip", "Coverflow" => "coverflow", "Cube" => "cube"),
                 "std" => "slide",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Avatar shape", "cq_allinone_vc"),
                "param_name" => "shape",
                "value" => array('Rounded' => 'rounded', 'Square' => 'square', 'Round' => 'round'),
                'std' => 'square',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Loading bar shape", "cq_allinone_vc"),
                "param_name" => "barshape",
                "value" => array('Rounded' => 'rounded', 'Square' => 'square'),
                'std' => 'square',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Dot size", "cq_allinone_vc"),
                "param_name" => "dotsize",
                "value" => array('16' => '16', '24' => '24', '32' => '32', '48' => '48'),
                'std' => '24',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Active dot color", "cq_allinone_vc"),
                "param_name" => "activestyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
                'std' => 'grass',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Default dot border color", "cq_allinone_vc"),
                "param_name" => "borderstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
                'std' => 'mediumgray',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Auto height? ', 'cq_allinone_vc' ),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                'param_name' => 'autoheight',
                'std' => 'yes',
                'description' => esc_attr__("Check this if you want the slide to be auto height.", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              ),
              array(
                "type" => "css_editor",
                "heading" => esc_attr__( "CSS", "cq_allinone_vc" ),
                "param_name" => "css",
                "description" => esc_attr__("It's recommended to use this to customize the padding/margin only.", "cq_allinone_vc"),
                "group" => esc_attr__( "Design options", "cq_allinone_vc" ),
             )
           )
        ));

        vc_map(
          array(
             "name" => esc_attr__("Slide Item","cq_allinone_vc"),
             "base" => "cq_vc_loadingslideshow_item",
             "class" => "cq_vc_loadingslideshow_item",
             "icon" => "cq_vc_loadingslideshow_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image, text and button","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_loadingslideshow'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Display the avatar with", "cq_allinone_vc"),
                 "param_name" => "avatartype",
                 "value" => array("icon", "image"),
                 "std" => "image",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                  "type" => "attach_image",
                  "edit_field_class" => "vc_column vc_col-xs-6",
                  "heading" => esc_attr__("Avatar Image:", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                "edit_field_class" => "vc_column vc_col-xs-6",
                'heading' => esc_attr__( 'Resize the image?', 'cq_allinone_vc' ),
                'param_name' => 'isresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
              ),
              array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'avataricon',
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'fontawesome',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'fontawesome',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'openiconic',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'typicons',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'linecons',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false,
                  // default true, display an "EMPTY" icon?
                  'type' => 'material',
                  'iconsPerPage' => 100,
                  // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'material',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Avatar Icon Color:", 'cq_allinone_vc'),
                "param_name" => "iconcolor",
                "dependency" => array("element" => "avatartype", "value" => "icon"),
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Avatar Background Color:", 'cq_allinone_vc'),
                "param_name" => "iconbg",
                "dependency" => array("element" => "avatartype", "value" => "icon"),
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Content", "cq_allinone_vc"),
                "param_name" => "content",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Tooltip for the avatar (optional)", "cq_allinone_vc"),
                "param_name" => "avatartitle",
                "dependency" => array("element" => "avatartype", "value" => "icon"),
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Tooltip for the dot navigation (optional)", "cq_allinone_vc"),
                "param_name" => "tooltip",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "vc_link",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("URL (Optional link for the avatar)", "cq_allinone_vc"),
                "param_name" => "imagelink",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              )


              ),
            )
        );

          add_shortcode('cq_vc_loadingslideshow', array($this,'cq_vc_loadingslideshow_func'));
          add_shortcode('cq_vc_loadingslideshow_item', array($this,'cq_vc_loadingslideshow_item_func'));

      }

      function cq_vc_loadingslideshow_func($atts, $content=null) {
        $css_class = $css = $autoslide = $autoheight = $shape = $barshape = $dotsize = $transition = $activestyle = $borderstyle = $backgroundcolor = $bordertype = $imageposition = $barposition = $textcolor = $avatarsize = $extraclass = '';
        extract(shortcode_atts(array(
          "shape" => "sqaure",
          "barshape" => "sqaure",
          "dotsize" => "24",
          "autoslide" => "no",
          "autoheight" => "yes",
          "transition" => "slide",
          "activestyle" => "grass",
          "borderstyle" => "mediumgray",
          "imageposition" => "left",
          "barposition" => "top",
          "textcolor" => "",
          "avatarsize" => "120",
          "barcolor" => "",
          "barbgcolor" => "",
          "backgroundcolor" => "",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $this -> image_position = $imageposition;
        $this -> text_color = $textcolor;

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_loadingslideshow', $atts);

        wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
        wp_enqueue_style('tooltipster');

        wp_register_style('swiper', plugins_url('../cardslider/css/swiper.css', __FILE__));
        wp_enqueue_style('swiper');

        wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('tooltipster');
        wp_register_script('swiper', plugins_url('../cardslider/js/swiper.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('swiper');

        wp_register_style( 'vc-extensions-loadingslideshow-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-loadingslideshow-style' );


        wp_register_script('vc-extensions-loadingslideshow-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
        wp_enqueue_script('vc-extensions-loadingslideshow-script');

        $output .= '<div class="cq-loadingslideshow cq-loadingslideshow-image-'.$imageposition.' cq-loadingslideshow-shape-'.$shape.' cq-loadingslideshow-avatar-'.$avatarsize.' cq-loadingslideshow-barposition-'.$barposition.' cq-loadingslideshow-bar-'.$shape.' cq-loadingslideshow-active-'.$activestyle.' cq-loadingslideshow-border-'.$borderstyle.' cq-loadingslideshow-dotsize-'.$dotsize.' '.$extraclass.' '.$css_class.'" data-autoslide="'.$autoslide.'" data-autoheight="'.$autoheight.'" data-transition="'.$transition.'" style="background-color:'.$backgroundcolor.'">';
        $output .= '<div class="swiper-wrapper">';
        $output .= do_shortcode($content);
        $output .= '</div>';

        $output .= '<div class="cq-loadingslideshow-nav"></div>';
        if($barposition != "none" && $autoslide != "no"){
          $output .= '<div class="cq-loadingslideshow-progressbar">
                      <span class="cq-loadingslideshow-bar" style="background-color:'.$barbgcolor.';">
                        <span class="cq-loadingslideshow-progress cq-isloading-'.$autoslide.'" style="background-color:'.$barcolor.';"></span>
                      </span>
                    </div>';
        }
        $output .= '</div>';
        return $output;

      }


      function cq_vc_loadingslideshow_item_func($atts, $content=null, $tag) {
          $output = $faceicon = $image = $imagesize = $imagelink = $videowidth = $isresize = $tooltip = $avatartitle =  $backgroundcolor = $backgroundhovercolor = $itembgcolor =  $iconsize =  $css = $bgstyle =  $buttoncolor = $buttontext = $buttonshape = $buttonsize = $buttonlink = $iconcolor = $iconbg = $avatartype = $avataricon = "";
          $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = $icon_monosocial = "";
            extract(shortcode_atts(array(
              "faceicon" => "entypo",
              "image" => "",
              "imagesize" => "",
              "imagelink" => "",
              "isresize" => "no",
              "iscaption" => "",
              "tooltip" => "",
              "avatartitle" => "",
              "bgstyle" => "aqua",
              "backgroundcolor" => "",
              "backgroundhovercolor" => "",
              "itembgcolor" => "",
              "avatartype" => "image",
              "avataricon" => "entypo",
              "icon_fontawesome" => "fa fa-user",
              "icon_openiconic" => "vc-oi vc-oi-dial",
              "icon_typicons" => "typcn typcn-adjust-brightness",
              "icon_entypo" => "entypo-icon entypo-icon-user",
              "icon_linecons" => "vc_li vc_li-heart",
              "icon_material" => "vc-material vc-material-cake",
              "icon_pixelicons" => "",
              "icon_monosocial" => "",
              "iconsize" => "",
              "buttontext" => "",
              "buttoncolor" => "blue",
              "buttonsize" => "xs",
              "buttonshape" => "rounded",
              "buttonstyle" => "modern",
              "buttonlink" => "",
              "iconcolor" => "",
              "iconbg" => "",
              "css" => ""
            ), $atts));

          vc_icon_element_fonts_enqueue($faceicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $img = $thumbnail = "";

          vc_icon_element_fonts_enqueue($avataricon);

          $fullimage = wp_get_attachment_image_src($image, 'full');
          $thumbnail = $fullimage[0];
          if($isresize=="yes"&&$imagesize!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($image, null, $imagesize, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage[0];
              }
          }


          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $image_str = '';
          $text_str = '';

          $imagelink = vc_build_link($imagelink);
          $output = '';
          if(intval($this -> item_height) > 0){
            $image_str .= '<div class="cq-loadingslideshow-imgcontainer" style="height:'.intval($this -> item_height).'px" title="'.$tooltip.'">';
          }else{
            $image_str .= '<div class="cq-loadingslideshow-imgcontainer" title="'.$tooltip.'">';
          }

            if($imagelink["url"]!=""){
                $image_str .= '<a href="'.$imagelink["url"].'" title="'.$imagelink["title"].'" target="'.$imagelink["target"].'" rel="'.$imagelink["rel"].'" class="cq-loadingslideshow-imagelink">';
            }
            if($avatartype == "image"){
              $image_str .= '<div class="cq-loadingslideshow-avatar" style="background-image:url('.$thumbnail.');background-color:'.$iconbg.'; title="'.$avatartitle.'">';

            }else if($avatartype=="icon"){
              $image_str .= '<div class="cq-loadingslideshow-avatar" style="background-color:'.$iconbg.';" title="'.$avatartitle.'">';
              if(isset(${'icon_' . $avataricon})&&esc_attr(${'icon_' . $avataricon})!=""){
                $image_str .= '<i class="cq-loadingslideshow-icon '.esc_attr(${'icon_' . $avataricon}).'" style="color:'.$iconcolor.';font-size:'.$iconsize.'"></i>';
              }
          }
          $image_str .= '</div>';

          if($imagelink["url"]!="") $image_str .= '</a>';
          $image_str .= '</div>';

          $output .= '<div class="cq-loadingslideshow-item swiper-slide">';

          $text_str .= '<div class="cq-loadingslideshow-content" style="color:'.$this -> text_color.';">';
          $text_str .= do_shortcode($content);
          $text_str .= '</div>';

          if($this -> image_position == "left"){
            $output .= $image_str . $text_str;
          } else{
            $output .= $text_str . $image_str;
          }
          $output .= '</div>';
          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_loadingslideshow')) {
    class WPBakeryShortCode_cq_vc_loadingslideshow extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_loadingslideshow_item')) {
    class WPBakeryShortCode_cq_vc_loadingslideshow_item extends WPBakeryShortCode {
    }
}

?>
