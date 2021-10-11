<?php
if (!class_exists('VC_Extensions_SideBySideV2')){
    class VC_Extensions_SideBySideV2{
        private $slidenum = 1;
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Side by Side V2", 'cq_allinone_vc'),
            "base" => "cq_vc_sidebysidev2",
            "class" => "cq_vc_sidebysidev2",
            "icon" => "cq_vc_sidebysidev2",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_sidebysidev2_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('2 sides, different image, text', 'js_composer'),
            "params" => array(

        			array(
        			    "type" => "dropdown",
        			    "holder" => "",
        			    "class" => "cq_allinone_vc",
        			    "heading" => esc_attr__("Auto delay slide", "cq_allinone_vc"),
        			    "param_name" => "autodelay",
        			    'value' => array(2, 3, 4, 5, 7, 10, esc_attr__( 'Disable', 'cq_allinone_vc' ) => 0 ),
        			    'std' => 0,
        			    "description" => esc_attr__("Auto slide in each X seconds.", "cq_allinone_vc")
        			),
            	array(
  	            "type" => "textfield",
  	            "heading" => esc_attr__("width of the whole element", "cq_allinone_vc"),
  	            "param_name" => "elementwidth",
  	            "value" => "",
  	            "description" => esc_attr__("Default is 100%, you can specify other value like 80% etc here.", "cq_allinone_vc")
    	        ),
    	        array(
    	            "type" => "textfield",
    	            "heading" => esc_attr__("min-height of the whole element", "cq_allinone_vc"),
    	            "param_name" => "minheight",
    	            "value" => "",
    	            "description" => esc_attr__("Default is 320px.", "cq_allinone_vc")
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
             "name" => esc_attr__("Side Item","cq_allinone_vc"),
             "base" => "cq_vc_sidebysidev2_item",
             "class" => "cq_vc_sidebysidev2_item",
             "icon" => "cq_vc_sidebysidev2_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add content for each side","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_sidebysidev2'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Header image", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Resize image to this width?", "cq_allinone_vc"),
                  "param_name" => "imagewidth",
                  "value" => "",
                  "description" => esc_attr__("Default we will use the original image, specify a width. For example, 200 will resize the image to width 200. ", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__("Customize image overlay color", 'cq_allinone_vc'),
                  "param_name" => "overlaycolor",
                  "value" => '',
                  "description" => esc_attr__("", 'cq_allinone_vc')
                ),
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Title", "cq_allinone_vc"),
                  "param_name" => "title",
                  "value" => "",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "colorpicker",
                  "edit_field_class" => "vc_col-xs-6 vc_column",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__("Customize title color", 'cq_allinone_vc'),
                  "param_name" => "titlecolor",
                  "value" => '',
                  "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
                ),
                array(
                  "type" => "textfield",
                  "edit_field_class" => "vc_col-xs-6 vc_column",
                  "heading" => esc_attr__("font size of the title", "cq_allinone_vc"),
                  "param_name" => "titlesize",
                  "value" => "",
                  "description" => esc_attr__("Default is 1.4em, you can customize other size (like 16px, 1.8em) as you like.", "cq_allinone_vc")
                ),
                array(
                  "type" => "textarea_html",
                  "heading" => esc_attr__("Description", "cq_allinone_vc"),
                  "param_name" => "content",
                  "value" => "",
                  "description" => esc_attr__("Optional description under the title", "cq_allinone_vc")
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

          add_shortcode('cq_vc_sidebysidev2', array($this,'cq_vc_sidebysidev2_func'));
          add_shortcode('cq_vc_sidebysidev2_item', array($this,'cq_vc_sidebysidev2_item_func'));

      }

      function cq_vc_sidebysidev2_func($atts, $content=null) {
        $css_class = $css = $autodelay = $extraclass = $elementwidth = $minheight = '';
        $this -> slidenum = 1;
        extract(shortcode_atts(array(
          "autodelay" => "0",
          "elementwidth" => "",
          "minheight" => "",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_sidebysidev2', $atts);
        wp_register_style( 'vc-extensions-sidebysidev2-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-sidebysidev2-style' );

        wp_register_script('vc-extensions-sidebysidev2-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
        wp_enqueue_script('vc-extensions-sidebysidev2-script');

        $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content


        $output = '';
        $output .= '<div class="cq-sidebysidev2 '.$extraclass.'" style="width:'.$elementwidth.';margin:0 auto;" data-autodelay="'.$autodelay.'">';
        $output .= '<div class="cq-sidebysidev2-container" style="min-height:'.$minheight.'">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        $output .= '</div>';
        return $output;

      }


      function cq_vc_sidebysidev2_item_func($atts, $content=null, $tag) {
          $title = $titlecolor = $titlesize = $description = $image = $imagewidth = $overlaycolor = $buttoncolor = $buttontext = $buttonshape = $buttonsize = $buttonlink = $align = "";

          extract(shortcode_atts(array(
            "title" => "",
            "titlecolor" => "",
            "titlesize" => "",
            "description" => "",
            "image" => "",
            "imagewidth" => "",
            "overlaycolor" => "",
            "buttontext" => "",
            "buttoncolor" => "blue",
            "buttonsize" => "xs",
            "buttonshape" => "rounded",
            "buttonstyle" => "modern",
            "buttonlink" => "",
            "align" => "center",
            "css" => ""
          ), $atts));

          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

		  $slidenum = $this -> slidenum;

          $header_attachment = get_post($image);
          $headerimagearr = wp_get_attachment_image_src(trim($image), 'full');
          $header_image_temp = $header_image_url = "";
          $header_orgi_image = $headerimagearr[0];
          $header_image_url = $header_orgi_image;
          if( $imagewidth!="" ){
              if(function_exists('wpb_resize')){
                  $header_image_temp = wpb_resize($image, null, $imagewidth, null);
                  $header_image_url = $header_image_temp['url'];
                  if($header_image_url=="") $header_image_url = $header_orgi_image;
              }
          }


          $output = '';
          if($slidenum<=2){
	          $output .= '<div class="cq-sidebysidev2-side" style="background:url('.$header_image_url.') center center no-repeat;">';
	          $output .= '<div class="cq-sidebysidev2-sidebg" style="background:'.$overlaycolor.'">';
	          if($title!="") $output .= '<h4 class="cq-sidebysidev2-title" style="color:'.$titlecolor.';font-size:'.$titlesize.';"> '.$title.' </h4>';
	          if($content!="") $output .= $content;
	          if($buttontext!=""){
	              $output .= do_shortcode('[vc_btn title="'.$buttontext.'" color="'.$buttoncolor.'" style="'.$buttonstyle.'" shape="'.$buttonshape.'" link="'.$buttonlink.'" align="'.$align.'" size="'.$buttonsize.'"]');
	          }

	          $output .= '</div>';
	          $output .= '</div>';

          }
          $slidenum++;
          $this -> slidenum = $slidenum;

          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_sidebysidev2')) {
    class WPBakeryShortCode_cq_vc_sidebysidev2 extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_sidebysidev2_item')) {
    class WPBakeryShortCode_cq_vc_sidebysidev2_item extends WPBakeryShortCode {
    }
}

?>
