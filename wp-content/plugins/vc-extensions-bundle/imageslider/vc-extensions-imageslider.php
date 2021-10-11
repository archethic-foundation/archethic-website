<?php
if (!class_exists('VC_Extensions_ImageSlider')){
    class VC_Extensions_ImageSlider{
        private $dotstr, $dotcolor, $minwidth, $bordercolor, $dotanimation;
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Image Slider", 'cq_allinone_vc'),
            "base" => "cq_vc_imageslider",
            "class" => "cq_vc_imageslider",
            "icon" => "cq_vc_imageslider",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_imageslider_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Auto slide with dot navigation', 'js_composer'),
            "params" => array(
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Dot navigation animation", "cq_allinone_vc"),
                 "param_name" => "dotanimation",
                 "value" => array("Fill up" => "fillup", "Scale up" => "scaleup", "Stroke" => "stroke", "Fill in" => "fillin", "Circle grow" => "circlegrow", "Dot stroke" => "dotstroke", "Draw circle" => "drawcircle", "Small dot stroke" => "smalldotstroke", "Puff" => "puff", "Tooltip" => "tooltip", "Dot move" => "dotmove", "Fall" => "fall"),
                 "std" => "fillup",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                "edit_field_class" => "vc_col-xs-6 vc_column",
                'heading' => esc_attr__('Auto hide the tooltip?', 'cq_allinone_vc' ),
                'param_name' => 'autohide',
                'std' => 'yes',
                'description' => esc_attr__("", 'cq_allinone_vc' ),
                'dependency' => array('element' => 'dotanimation', 'value' => 'tooltip'),
                'value' => array( esc_attr__( 'Yes, auto hide the tooltip after mouse out', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Navigation dot default color", 'cq_allinone_vc'),
                "param_name" => "dotcolor",
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("min-width for the tooltip", 'cq_allinone_vc'),
                "param_name" => "minwidth",
                "value" => "",
                "description" => esc_attr__("Default is 80 (in pixel).", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Dot border color (if any)", 'cq_allinone_vc'),
                "param_name" => "bordercolor",
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Navigation active dot color style:", "cq_allinone_vc"),
                "param_name" => "dotstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent (content with white background)" => "cq-transparent", "Customized color:" => "customized"),
                'std' => 'aqua',
                "description" => esc_attr__("", "cq_allinone_vc")
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
                'type' => 'checkbox',
                "edit_field_class" => "vc_col-xs-6 vc_column",
                'heading' => esc_attr__('Display the arrow navigation? ', 'cq_allinone_vc' ),
                'param_name' => 'isarrow',
                'std' => 'no',
                'description' => esc_attr__("", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Navigation arrow color", 'vc_coverslider_cq'),
                "param_name" => "arrowcolor",
                "value" => '',
                'dependency' => array('element' => 'isarrow', 'value' => 'yes'),
                "description" => esc_attr__("Default is white.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Navigation arrow hover color", 'vc_coverslider_cq'),
                "param_name" => "arrowhovercolor",
                "value" => '',
                'dependency' => array('element' => 'isarrow', 'value' => 'yes'),
                "description" => esc_attr__("Default is white.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => esc_attr__("Display the navigation arrow on the:", "cq_allinone_vc"),
                "param_name" => "navposition",
                "value" => array("left (float)" => "float-left", "right (float)" => "float-right"),
                'std' => 'float-left',
                "dependency" => Array('element' => "isarrow", 'value' => array('yes')),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Arrow navigation color style:", "cq_allinone_vc"),
                "param_name" => "arrowstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent (content with white background)" => "cq-transparent", "Customized color:" => "customized"),
                'std' => 'aqua',
                "dependency" => Array('element' => "isarrow", 'value' => array('yes')),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
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
             "name" => esc_attr__("Image Item","cq_allinone_vc"),
             "base" => "cq_vc_imageslider_item",
             "class" => "cq_vc_imageslider_item",
             "icon" => "cq_vc_imageslider_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image and (optional) text","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_imageslider'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tooltip for the dot (optional, only available on the tooltip animation)", "cq_allinone_vc"),
                "param_name" => "tooltip",
                "value" => "",
                "description" => esc_attr__("For example, a name, John Smith", "cq_allinone_vc")
              ),
              array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Background image:", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                "type" => "vc_link",
                "heading" => esc_attr__("URL (Optional link for the image)", "cq_allinone_vc"),
                "param_name" => "imagelink",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__( 'Resize the image?', 'cq_allinone_vc' ),
                'param_name' => 'isresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Caption", "cq_allinone_vc"),
                "param_name" => "content",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Optional caption under the image (support youtube/vimeo embed code too).", "cq_allinone_vc")
              )

              ),
            )
        );

          add_shortcode('cq_vc_imageslider', array($this,'cq_vc_imageslider_func'));
          add_shortcode('cq_vc_imageslider_item', array($this,'cq_vc_imageslider_item_func'));

      }

      function cq_vc_imageslider_func($atts, $content=null) {
        $css_class = $css = $dotanimation = $autoslide = $isarrow = $arrowcolor = $arrowhovercolor = $arrowstyle = $extraclass = '';
        $imageposition = $navposition = $buttonsize = $dotstr = $minwidth = $dotstyle = $dotcolor = $bordercolor = '';
        $this -> dotstr = '';
        $this -> dotcolor = '';
        $this -> minwidth = '';
        $this -> bordercolor = '';
        $this -> dotanimation = '';
        extract(shortcode_atts(array(
          "dotstyle" => "aqua",
          "arrowstyle" => "aqua",
          "autohide" => "yes",
          "minwidth" => "",
          "dotcolor" => "",
          "bordercolor" => "transparent",
          "dotanimation" => "fillup",
          "imageposition" => "top",
          "navposition" => "float-left",
          "buttonsize" => "btn-large",
          "autoslide" => "no",
          "isarrow" => "no",
          "arrowcolor" => "",
          "arrowhovercolor" => "",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_imageslider', $atts);
        wp_register_style( 'vc-extensions-imageslider-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-imageslider-style' );


        wp_register_style('slick', plugins_url('../testimonialcarousel/slick/slick.css', __FILE__));
        wp_enqueue_style('slick');

        wp_register_script('slick', plugins_url('../testimonialcarousel/slick/slick.min.js', __FILE__), array("jquery"));
        wp_enqueue_script('slick');


        wp_register_script('vc-extensions-imageslider-script', plugins_url('js/init.js', __FILE__), array("jquery", "slick"));
        wp_enqueue_script('vc-extensions-imageslider-script');

        $this -> dotcolor = $dotcolor;
        $this -> minwidth = $minwidth;
        $this -> bordercolor = $bordercolor;
        $this -> dotanimation = $dotanimation;

        $output .= '<div class="cq-imageslider '.$arrowstyle.' navigation-'.$navposition.' '.$extraclass.' '.$css_class.'" data-autoslide="'.$autoslide.'" data-autohide="'.$autohide.'" data-dotanimation="'.$dotanimation.'" data-arrowcolor="'.$arrowcolor.'" data-arrowhovercolor="'.$arrowhovercolor.'">';

        $navigation_str = '';
        $image_str = '';
        $content_str = '';
        $area_str = '';
        $dots_str = '';

        if($isarrow == "yes"){
            $navigation_str .= '<div class="cq-imageslider-navigation '.$buttonsize.'">';
            $navigation_str .= '<div class="imageslider-navigation-prev">';
            $navigation_str .= '<i class="cq-imageslider-icon entypo-icon entypo-icon-left-open-big"></i>';
            $navigation_str .= '</div>';
            $navigation_str .= '<div class="imageslider-navigation-next">';
            $navigation_str .= '<i class="cq-imageslider-icon entypo-icon entypo-icon-right-open-big"></i>';
            $navigation_str .= '</div>';
            $navigation_str .= '</div>';
        }

        $image_str .= '<div class="cq-imageslider-cover">';
        $image_str .= '<div class="cq-imageslider-itemcontainer">';
        $content_str .= '<div class="cq-imageslider-content">';

        $image_str .= do_shortcode($content);

        $image_str .= '</div>';
        $image_str .= '</div>';

        $content_str .= '</div>';


        $area_str .= '<div class="cq-imageslider-area '.$buttonsize.'">';
        if($imageposition=="bottom"){
            $area_str .= $content_str.$image_str;
        }else{
            $area_str .= $image_str.$content_str;
        }
        $area_str .= '</div>';

        if($navposition=="float-left"){
            $output .= $navigation_str.$area_str;
        }else{
            $output .= $area_str.$navigation_str;
        }

        $output .='<div class="cq-imageslider-navcontainer cq-imageslider-'.$dotstyle.'">';
        $output .='<ul class="cq-imageslider-dot cq-imageslider-dot-'.$dotanimation.' cq-imageslider-hide-'.$autohide.'">';
        $output .= $this -> dotstr;
        if($dotanimation == "dotmove"){
            $output .= '<li></li>';
        }
        $output .= '</ul>';
        $output .= '</div>';

        $output .= '</div>';
        return $output;

      }


      function cq_vc_imageslider_item_func($atts, $content=null, $tag) {
          $output = $image = $imagesize = $videowidth = $isresize = $tooltip =  $itembgcolor =  $css = $imagelink =  "";
            extract(shortcode_atts(array(
              "faceicon" => "entypo",
              "image" => "",
              "imagesize" => "",
              "isresize" => "no",
              "iscaption" => "",
              "tooltip" => "",
              "itembgcolor" => "",
              "imagelink" => "",
              "css" => ""
            ), $atts));

          vc_icon_element_fonts_enqueue($faceicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content


          $imagelink = vc_build_link($imagelink);

          $img = $thumbnail = "";

          $fullimage = wp_get_attachment_image_src($image, 'full');
          $attachment = get_post($image);
          $thumbnail = $fullimage[0];
          if($isresize=="yes"&&$imagesize!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($image, null, $imagesize, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage[0];
              }
          }


          $output = '';
          $output .= '<div class="cq-imageslider-imageitem cq-imageslider-initstate" data-image="'.$thumbnail.'" title="'.esc_html($tooltip).'">';

          if($imagelink["url"]!=""){
              $output .= '<a href="'.$imagelink["url"].'" title="'.$imagelink["title"].'" target="'.$imagelink["target"].'" class="cq-imageslider-imagelink" rel="'.$imagelink["rel"].'">';
          }

          $output .= '<img src="'.$thumbnail.'" class="cq-imageslider-image" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'">';
          if($content != ""){
            $output .= '<div class="cq-imageslider-text" style="color:;">';
            $output .= do_shortcode($content);
            $output .= '</div>';
          }
          if($imagelink["url"]!=""){
            $output .= '</a>';
          }
          $output .= '</div>';
          $notooltip = '';
          $notooltip_dotcolor = '';
          $tooltip_minwidth = '';
          if($this -> dotanimation == "tooltip"){
              $notooltip_dotcolor = 'background-color:'.$this -> dotcolor.';';
              if((int) preg_replace('/\D/', '', $this -> minwidth) > 0) $tooltip_minwidth = ' min-width:'.(int) preg_replace('/\D/', '', $this -> minwidth).'px;';
          }
          if($tooltip == "") {
              $notooltip = " cq-imageslider-notooltip";
          }
          $border_style = '';
          if($this -> dotanimation == "dotstroke"){
              $border_style = ' box-shadow: inset 0 0 0 2px '.$this -> bordercolor.';';
          }else{
              $border_style = ' border-color: '.$this -> bordercolor.';';
          }
          $this -> dotstr .= '<li style="'.$notooltip_dotcolor.'">';
          $this -> dotstr .= '<a class="cq-imageslider-linkdot'.$notooltip.'" href="#" style="'.$tooltip_minwidth.' background-color:'.$this -> dotcolor.';border-color:'.$this -> bordercolor.'; '.$border_style.'">';
          if($tooltip!=""){
              $this -> dotstr .= $tooltip;
          }
          $this -> dotstr .= '</a>';
          if($this -> dotanimation == "drawcircle"){
              $this -> dotstr .= '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 16 16" preserveAspectRatio="none"><circle cx="8" cy="8" fill="'.$this -> dotcolor.'" r="6.215"/></svg>';
          }
          $this -> dotstr .= '</li>';
          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_imageslider')) {
    class WPBakeryShortCode_cq_vc_imageslider extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_imageslider_item')) {
    class WPBakeryShortCode_cq_vc_imageslider_item extends WPBakeryShortCode {
    }
}

?>
