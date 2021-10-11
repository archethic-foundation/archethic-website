<?php
if (!class_exists('VC_Extensions_CardSlider')){
    class VC_Extensions_CardSlider{
        private $image_position = "left";
        private $date_fontsize = "";
        private $title_fontsize = "";
        private $item_height = "";
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Card Slider", 'cq_allinone_vc'),
            "base" => "cq_vc_cardslider",
            "class" => "cq_vc_cardslider",
            "icon" => "cq_vc_cardslider",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_cardslider_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Responsive card slider', 'js_composer'),
            "params" => array(
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Auto delay slideshow", "cq_allinone_vc"),
                 "param_name" => "autoslide",
                 "value" => array("no", "2", "3", "4", "5", "6", "7", "8"),
                 "std" => "no",
                 "description" => esc_attr__("In seconds, default is no, which is disabled.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Transition style", "cq_allinone_vc"),
                 "param_name" => "transition",
                 "value" => array("Fade" => "fade", "Flip" => "flip", "Coverflow" => "coverflow"),
                 "std" => "fade",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Image height", "cq_allinone_vc"),
                 "param_name" => "itemsize",
                 "value" => array("80", "100", "120", "160", "200", "240", "280", "320", "400", "customize below" => "customized"),
                 "std" => "240",
                 "description" => esc_attr__("Select the built in image height (in pixels) or customize it below.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Customize image height", "cq_allinone_vc"),
                "param_name" => "itemheight",
                "value" => "",
                "dependency" => Array('element' => "itemsize", 'value' => array('customized')),
                "description" => esc_attr__('Enter image height in pixels, for example: 400. Leave empty to use default 240 (pixels).', "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Element shape", "cq_allinone_vc"),
                "param_name" => "shape",
                "value" => array('Rounded' => 'rounded', 'Square' => 'square', 'Round' => 'round'),
                'std' => 'rounded',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Image position", "cq_allinone_vc"),
                "param_name" => "imageposition",
                "value" => array("Left" => "left", "Right" => "right"),
                'std' => 'left',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Background color", "cq_allinone_vc"),
                "param_name" => "bgstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent (content with white background)" => "cq-transparent", "Customized color:" => "customized"),
                'std' => 'darkgray',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Customize the background color", 'cq_allinone_vc'),
                "param_name" => "backgroundcolor",
                "value" => "",
                "dependency" => Array('element' => "bgstyle", 'value' => array('customized')),
                "description" => esc_attr__("Default is medium gray. Note, the content only support white background with customized gird item background.", 'cq_allinone_vc')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Color of the current dot navigation bar", "cq_allinone_vc"),
                "param_name" => "dotstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent (same as the dot)" => "transparent"),
                'std' => 'aqua',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "class" => "",
                "heading" => esc_attr__("Default color of the dot navigation", "cq_allinone_vc"),
                "param_name" => "defaultdot",
                "value" => array("Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
                'std' => 'lightgray',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("date font-size", "cq_allinone_vc"),
                "param_name" => "datefontsize",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 1em, support a value like 12px or 1.2em", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Title font-size", "cq_allinone_vc"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 0.9em", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Auto height? ', 'cq_allinone_vc' ),
                'param_name' => 'autoheight',
                'std' => 'no',
                'description' => esc_attr__("Check this if you want the element auto height.", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
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
             "name" => esc_attr__("Slide Item","cq_allinone_vc"),
             "base" => "cq_vc_cardslider_item",
             "class" => "cq_vc_cardslider_item",
             "icon" => "cq_vc_cardslider_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image, text and button","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_cardslider'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-8",
                "heading" => esc_attr__("Date for the item (optional)", "cq_allinone_vc"),
                "param_name" => "datelabel",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("For example, 4 Sep 2018", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-4",
                "heading" => esc_attr__("Date color", 'cq_allinone_vc'),
                "param_name" => "datecolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-8",
                "heading" => esc_attr__("Title (optional)", "cq_allinone_vc"),
                "param_name" => "title",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-4",
                "heading" => esc_attr__("Title color", 'cq_allinone_vc'),
                "param_name" => "titlecolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Content", "cq_allinone_vc"),
                "param_name" => "content",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("The slide in content.", "cq_allinone_vc")
              ),
              array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Background image:", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "group" => "Image",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__( 'Resize the image?', 'cq_allinone_vc' ),
                'param_name' => 'isresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                "group" => "Image",
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "group" => "Image",
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tooltip for the image (optional)", "cq_allinone_vc"),
                "param_name" => "tooltip",
                "value" => "",
                "group" => "Image",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "vc_link",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("URL (Optional link for the image)", "cq_allinone_vc"),
                "param_name" => "imagelink",
                "value" => "",
                'group' => 'Image',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Button text", "cq_allinone_vc"),
                "param_name" => "buttontext",
                "value" => "",
                'group' => 'Button',
                "description" => esc_attr__("Optional button under the content", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "holder" => "",
                 "heading" => esc_attr__("Button color", "cq_allinone_vc"),
                 "param_name" => "buttoncolor",
                 "value" => array('Blue' => 'blue', 'Turquoise' => 'turquoise', 'Pink' => 'pink', 'Violet' => 'violet', 'Peacoc' => 'peacoc', 'Chino' => 'chino', 'Vista Blue' => 'vista_blue', 'Black' => 'black', 'Grey' => 'grey', 'Orange' => 'orange', 'Sky' => 'sky', 'Green' => 'green', 'Sandy brown' => 'sandy_brown', 'Purple' => 'purple', 'White' => 'white'),
                'std' => 'blue',
                'group' => 'Button',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "holder" => "",
                 "heading" => esc_attr__("Button size", "cq_allinone_vc"),
                 "param_name" => "buttonsize",
                 "value" => array('Mini' => 'xs', 'Small' => 'sm', 'Large' => 'lg'),
                 'std' => 'xs',
                 'group' => 'Button',
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => esc_attr__("Button shape", "cq_allinone_vc"),
                "param_name" => "buttonshape",
                "value" => array('Rounded' => 'rounded', 'Square' => 'square', 'Round' => 'round'),
                'std' => 'rounded',
                'group' => 'Button',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => esc_attr__("Button alignment", "cq_allinone_vc"),
                "param_name" => "align",
                "value" => array('Inline' => 'inline', 'Left' => 'left', 'Center' => 'center', 'Right' => 'right'),
                'std' => 'center',
                'group' => 'Button',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "vc_link",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("URL (Optional link for the button)", "cq_allinone_vc"),
                "param_name" => "buttonlink",
                "value" => "",
                'group' => 'Button',
                "description" => esc_attr__("", "cq_allinone_vc")
              )


              ),
            )
        );

          add_shortcode('cq_vc_cardslider', array($this,'cq_vc_cardslider_func'));
          add_shortcode('cq_vc_cardslider_item', array($this,'cq_vc_cardslider_item_func'));

      }

      function cq_vc_cardslider_func($atts, $content=null) {
        $css_class = $css = $autoslide = $itemsize = $itemheight = $autoheight = $datefontsize = $titlesize = $dotstyle = $defaultdot = $imageposition = $shape = $transition = $bgstyle = $backgroundcolor = $extraclass = '';
        extract(shortcode_atts(array(
          "shape" => "rounded",
          "dotstyle" => "aqua",
          "defaultdot" => "lightgray",
          "imageposition" => "left",
          "autoslide" => "no",
          "itemsize" => "240",
          "itemheight" => "",
          "autoheight" => "no",
          "datefontsize" => "",
          "titlesize" => "",
          "transition" => "fade",
          "bgstyle" => "darkgray",
          "backgroundcolor" => "",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $this -> image_position = $imageposition;
        $this -> date_fontsize = $datefontsize;
        $this -> title_fontsize = $titlesize;
        $this -> item_height = $itemheight;

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_cardslider', $atts);
        wp_register_style( 'vc-extensions-cardslider-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-cardslider-style' );

        wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
        wp_enqueue_style('tooltipster');

        wp_register_style('swiper', plugins_url('css/swiper.css', __FILE__));
        wp_enqueue_style('swiper');

        wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('tooltipster');
        wp_register_script('swiper', plugins_url('js/swiper.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('swiper');


        wp_register_script('vc-extensions-cardslider-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
        wp_enqueue_script('vc-extensions-cardslider-script');

        $output .= '<div class="cq-cardslider cq-cardslider-shape-'.$shape.' cq-cardslider-bg-'.$bgstyle.' cq-cardslider-defaultdot-'.$defaultdot.' cq-cardslider-dot-'.$dotstyle.' cq-cardslider-image-'.$imageposition.' cq-cardslider-'.$itemsize.' '.$extraclass.' '.$css_class.'" data-itemheight="'.$itemheight.'" data-autoslide="'.$autoslide.'" data-itemsize="'.$itemsize.'" data-autoheight="'.$autoheight.'" data-transition="'.$transition.'" style="background-color:'.$backgroundcolor.'">';
        $output .= '<div class="swiper-wrapper">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        $output .= '<div class="cq-cardslider-nav"></div>';
        // $output .= ' <div class="swiper-button-prev"></div> <div class="swiper-button-next"></div>';
        $output .= '</div>';
        return $output;

      }


      function cq_vc_cardslider_item_func($atts, $content=null, $tag) {
          $output = $faceicon = $image = $imagesize = $imagelink = $videowidth = $isresize = $tooltip =  $backgroundcolor = $backgroundhovercolor = $itembgcolor = $iconcolor = $iconsize =  $css = $bgstyle =  $datelabel = $title = $datecolor = $titlecolor = $buttoncolor = $buttontext = $buttonshape = $buttonsize = $buttonlink = $align = "";
          $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = $icon_monosocial = "";

            extract(shortcode_atts(array(
              "faceicon" => "entypo",
              "image" => "",
              "imagesize" => "",
              "imagelink" => "",
              "isresize" => "no",
              "iscaption" => "",
              "tooltip" => "",
              "bgstyle" => "aqua",
              "backgroundcolor" => "",
              "backgroundhovercolor" => "",
              "itembgcolor" => "",
              "icon_fontawesome" => "fa fa-user",
              "icon_openiconic" => "vc-oi vc-oi-dial",
              "icon_typicons" => "typcn typcn-adjust-brightness",
              "icon_entypo" => "entypo-icon entypo-icon-user",
              "icon_linecons" => "vc_li vc_li-heart",
              "icon_material" => "vc-material vc-material-cake",
              "icon_pixelicons" => "",
              "icon_monosocial" => "",
              "iconcolor" => "",
              "iconsize" => "",
              "datelabel" => "",
              "title" => "",
              "datecolor" => "",
              "titlecolor" => "",
              "datefontsize" => "",
              "buttontext" => "",
              "buttoncolor" => "blue",
              "buttonsize" => "xs",
              "buttonshape" => "rounded",
              "buttonstyle" => "modern",
              "buttonlink" => "",
              "align" => "center",
              "css" => ""
            ), $atts));

          vc_icon_element_fonts_enqueue($faceicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $img = $thumbnail = "";

          $fullimage = wp_get_attachment_image_src($image, 'full');
          $thumbnail = $fullimage[0];
          if($isresize=="yes"&&$imagesize!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($image, null, $imagesize, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage[0];
              }
          }

          if($bgstyle == "customized" && $backgroundcolor != ""){
          	$arrowstyle_str = "border-bottom:15px solid $backgroundcolor";
          }
          $itembgstyle_str = '';
          if($bgstyle == "customized" && $backgroundcolor != ""){
          	$itembgstyle_str = "background-color: $backgroundcolor";
          }

          $image_str = '';
          $text_str = '';

          $imagelink = vc_build_link($imagelink);
          $output = '';
          if(intval($this -> item_height) > 0){
            $image_str .= '<div class="cq-cardslider-imgcontainer" style="height:'.intval($this -> item_height).'px">';
          }else{
            $image_str .= '<div class="cq-cardslider-imgcontainer">';
          }

          if($imagelink["url"]!=""){
              $image_str .= '<a href="'.$imagelink["url"].'" title="'.$imagelink["title"].'" target="'.$imagelink["target"].'" rel="'.$imagelink["rel"].'" class="cq-cardslider-imagelink">';
          }
          if($thumbnail != "") $image_str .= '<img src="'.$thumbnail.'" class="cq-cardslider-img" title="'.$tooltip.'" alt="">';
          if($imagelink["url"]!="") $image_str .= '</a>';
          $image_str .= '</div>';
          $text_str .= '<div class="cq-cardslider-content">';
          if($datelabel != '')$text_str .= '<span class="cq-cardslider-date" style="color:'.$datecolor.';font-size:'.$this -> date_fontsize.'">'.$datelabel.'</span>';
          if($title != '')$text_str .= '<div class="cq-cardslider-title" style="color:'.$titlecolor.';font-size:'.$this -> title_fontsize.'">'.$title.'</div>';
          if($content != ''){
              $text_str .= '<div class="cq-cardslider-text">'.$content.'</div>';
          }
          if($buttontext!=""){
            $text_str .= do_shortcode('[vc_btn title="'.$buttontext.'" color="'.$buttoncolor.'" style="'.$buttonstyle.'" shape="'.$buttonshape.'" link="'.$buttonlink.'" align="'.$align.'" size="'.$buttonsize.'"]');
            }

          $text_str .= '</div>';

          $output .= '<div class="cq-cardslider-item swiper-slide">';
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
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_cardslider')) {
    class WPBakeryShortCode_cq_vc_cardslider extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_cardslider_item')) {
    class WPBakeryShortCode_cq_vc_cardslider_item extends WPBakeryShortCode {
    }
}

?>
