<?php
if (!class_exists('VC_Extensions_VideoGallery')){
    class VC_Extensions_VideoGallery{
        private $thumbstr, $bgcolor, $thumbtextcolor, $captionsize, $thumbsize, $minheight;
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("YouTube or Vimeo Video Gallery", 'cq_allinone_vc'),
            "base" => "cq_vc_videogallery",
            "class" => "cq_vc_videogallery",
            "icon" => "cq_vc_videogallery",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_videogallery_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('YouTube or Vimeo', 'js_composer'),
            "params" => array(
                array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Display how many video thumbnail on the column?", "cq_allinone_vc"),
                 "param_name" => "videonum",
                 "value" => array("2", "3", "4", "5", "6", "7", "8", "9", "10"),
                 "std" => "4",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),

              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Thumbnail image size:", "cq_allinone_vc"),
                 "param_name" => "thumbsize",
                 "value" => array("48", "64", "80", "120", "160"),
                 "std" => "64",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),

              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Arrow color style:", "cq_allinone_vc"),
                "param_name" => "arrowstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent (content with white background)" => "cq-transparent", "Customized color:" => "customized"),
                'std' => 'aqua',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_coverslider_cq",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Arrow size", "vc_coverslider_cq"),
                "param_name" => "buttonsize",
                "value" => array("Small"=>"btn-small", "Medium"=>"btn-medium", "Large"=>"btn-large"),
                'std' => 'btn-medium',
                "description" => esc_attr__("", "vc_coverslider_cq")
              ),

              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Video Background color", 'cq_allinone_vc'),
                "param_name" => "bgcolor",
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Thumbnail Background color", 'cq_allinone_vc'),
                "param_name" => "thumbbg",
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Thumbnail text color", 'cq_allinone_vc'),
                "param_name" => "thumbtextcolor",
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),


              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Arrow color", 'vc_coverslider_cq'),
                "param_name" => "arrowcolor",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'vc_coverslider_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Arrow hover color", 'vc_coverslider_cq'),
                "param_name" => "arrowhovercolor",
                "value" => '',
                "description" => esc_attr__("Default is white.", 'vc_coverslider_cq')
              ),

              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("min-height for the video", 'cq_allinone_vc'),
                "param_name" => "minheight",
                "value" => "",
                "description" => esc_attr__("Default video height will fit to the thumbnails, you can customize it with a value too, default is 240.", 'cq_allinone_vc')
              ),

              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Thumbnail caption font size", "cq_allinone_vc"),
                "param_name" => "captionsize",
                "value" => "",
                "description" => esc_attr__("Default is 12px, support other value like 1em or 14px etc.", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__( 'Display the thumbnail as tooltip only?', 'cq_allinone_vc' ),
                'param_name' => 'istooltip',
                'description' => esc_attr__( 'The caption will be display side by the thumbnail, you can choose to hide them and display as tooltip only.', 'cq_allinone_vc' ),
                'std' => 'no',
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
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
             "name" => esc_attr__("Video Item","cq_allinone_vc"),
             "base" => "cq_vc_videogallery_item",
             "class" => "cq_vc_videogallery_item",
             "icon" => "cq_vc_videogallery_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add video and thumbnail","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_videogallery'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Select the video type:", "cq_allinone_vc"),
                 "param_name" => "videotype",
                 "value" => array("YouTube" => "youtube", "Vimeo" => "vimeo"),
                 "std" => "youtube",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Video ID:", "cq_allinone_vc"),
                "param_name" => "youtubeid",
                "value" => "",
                "dependency" => Array('element' => "videotype", 'value' => array('youtube')),
                "description" => esc_attr__("You can get it from the URL, for example, https://www.youtube.com/watch?v=ba2OnpjbncQ then the ID is ba2OnpjbncQ ", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Video URL ID:", "cq_allinone_vc"),
                "param_name" => "vimeoid",
                "value" => "",
                "dependency" => Array('element' => "videotype", 'value' => array('vimeo')),
                "description" => esc_attr__("For example, https://vimeo.com/355853531, then the ID is 355853531 ", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Thumbnail caption", "cq_allinone_vc"),
                "param_name" => "caption",
                "value" => "Default title",
                "description" => esc_attr__("Title for the video, can be displayed as tooltip too.", "cq_allinone_vc")
              ),
              array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Video thumbnail image:", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),

              ),
            )
        );

          add_shortcode('cq_vc_videogallery', array($this,'cq_vc_videogallery_func'));
          add_shortcode('cq_vc_videogallery_item', array($this,'cq_vc_videogallery_item_func'));

      }

      function cq_vc_videogallery_func($atts, $content=null) {
        $css_class = $css = $arrowcolor = $arrowhovercolor = $arrowstyle = $extraclass = '';
        $imageposition = $navposition = $buttonsize = $thumbstr = $minheight = $videonum = $bgcolor = $thumbbg = $thumbtextcolor = $captionsize = $istooltip = '';
        $this -> thumbstr = '';
        $this -> bgcolor = '';
        $this -> thumbtextcolor = '';
        $this -> captionsize = '';
        $this -> thumbsize = '';
        $this -> minheight = '';
        extract(shortcode_atts(array(
          "arrowstyle" => "aqua",
          "autohide" => "yes",
          "minheight" => "",
          "videonum" => "",
          "bgcolor" => "",
          "thumbbg" => "",
          "thumbtextcolor" => "",
          "captionsize" => "",
          "thumbsize" => "64",
          "imageposition" => "top",
          "navposition" => "float-left",
          "buttonsize" => "btn-medium",
          "arrowcolor" => "",
          "arrowhovercolor" => "",
          "istooltip" => "no",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_videogallery', $atts);
        wp_register_style( 'vc-extensions-videogallery-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-videogallery-style' );


        wp_register_style('slick', plugins_url('../testimonialcarousel/slick/slick.css', __FILE__));
        wp_enqueue_style('slick');
        wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
        wp_enqueue_style('tooltipster');

        wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('tooltipster');

        wp_register_script('slick', plugins_url('../testimonialcarousel/slick/slick.min.js', __FILE__), array("jquery"));
        wp_enqueue_script('slick');


        wp_register_script('vc-extensions-videogallery-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "slick", "tooltipster"));
        wp_enqueue_script('vc-extensions-videogallery-script');

        $this -> bgcolor = $bgcolor;
        $this -> thumbtextcolor = $thumbtextcolor;
        $this -> captionsize = $captionsize;
        $this -> thumbsize = $thumbsize;
        $this -> minheight = $minheight;

        $output .= '<div class="cq-videogallery '.$arrowstyle.' cq-videogallery-tooltip-'.$istooltip.' cq-videogallery-size-'.$thumbsize.' navigation-'.$navposition.' '.$extraclass.' '.$css_class.'" data-autohide="'.$autohide.'" data-arrowcolor="'.$arrowcolor.'" data-minheight="'.$minheight.'" data-bgcolor="'.$bgcolor.'" data-videonum="'.$videonum.'" data-arrowhovercolor="'.$arrowhovercolor.'" data-istooltip="'.$istooltip.'">';

        $navigation_str = '';
        $image_str = '';
        $content_str = '';
        $area_str = '';
        $dots_str = '';

        $navigation_str .= '<div class="cq-videogallery-navigation '.$buttonsize.'">';
        $navigation_str .= '<div class="videogallery-navigation-prev">';
        $navigation_str .= '<i class="cq-videogallery-icon entypo-icon entypo-icon-left-open-big"></i>';
        $navigation_str .= '</div>';
        $navigation_str .= '<div class="videogallery-navigation-next">';
        $navigation_str .= '<i class="cq-videogallery-icon entypo-icon entypo-icon-right-open-big"></i>';
        $navigation_str .= '</div>';
        $navigation_str .= '</div>';

        $image_str .= '<div class="cq-videogallery-cover">';
        $image_str .= '<div class="cq-videogallery-itemcontainer">';
        $content_str .= '<div class="cq-videogallery-content">';

        $image_str .= do_shortcode($content);

        $image_str .= '</div>';
        $image_str .= '</div>';

        $content_str .= '</div>';


        $area_str .= '<div class="cq-videogallery-area '.$buttonsize.'">';
        if($imageposition=="bottom"){
            $area_str .= $content_str.$image_str;
        }else{
            $area_str .= $image_str.$content_str;
        }
        $area_str .= '</div>';

        $navposition = "float-left";
        if($navposition=="float-left"){
            $output .= $navigation_str.$area_str;
        }else{
            $output .= $area_str.$navigation_str;
        }

        $output .='<div class="cq-videogallery-navcontainer">';
        $output .='<ul class="cq-videogallery-thumbcontainer cq-videogallery-hide-'.$autohide.'" style="background-color:'.$thumbbg.';color:'.$thumbtextcolor.';">';
        $output .= $this -> thumbstr;

        $output .= '</ul>';

        $output .= '</div>';

        $output .= '</div>';
        return $output;

      }


      function cq_vc_videogallery_item_func($atts, $content=null, $tag) {
          $output = $videotype = $youtubeid = $vimeoid = $image = $imagesize = $videowidth = $isresize = $caption =  $itembgcolor =  $css = $imagelink =  "";
            extract(shortcode_atts(array(
              "videotype" => "youtube",
              "youtubeid" => "",
              "vimeoid" => "",
              "faceicon" => "entypo",
              "image" => "",
              "imagesize" => "64",
              "isresize" => "yes",
              "iscaption" => "",
              "caption" => "Default title",
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
          $imagesize = $this -> thumbsize;
          if(function_exists('wpb_resize')){
              $img = wpb_resize($image, null, $imagesize*2, $imagesize*2, true);
              $thumbnail = $img['url'];
              if($thumbnail=="") $thumbnail = $fullimage[0];
          }



          $output = '';
          $output .= '<div class="cq-videogallery-item cq-videogallery-initstate" data-image="'.$thumbnail.'" title="'.esc_html($caption).'">';


            if($videotype == "youtube"){
              $output .= '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$youtubeid.'?enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="background-color:'.$this -> bgcolor.';"></iframe>';
            }else if($videotype == "vimeo"){
              $output .= '<iframe src="https://player.vimeo.com/video/'.$vimeoid.'" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="background-color:'.$this -> bgcolor.';"></iframe>';
            }

          $output .= '</div>';

          $border_style = '';
          $this -> thumbstr .= '<li class="cq-videogallery-thumbli cq-clearfix">';
          $this -> thumbstr .= '<a class="cq-videogallery-link" href="#">';

          $this -> thumbstr .= '<div class="cq-videogallery-thumbitem">';
          $this -> thumbstr .= '<img src="'.$thumbnail.'" alt="'.get_post_meta($image, '_wp_attachment_image_alt', true ).'" class="cq-videogallery-thumb" />';
          $this -> thumbstr .= '<span class="cq-videogallery-thumbcaption" style="font-size:'.$this -> captionsize.';color:'.$this -> thumbtextcolor.';">';
          $this -> thumbstr .= $caption;
          $this -> thumbstr .= '</span>';
          $this -> thumbstr .= '</div>';
          $this -> thumbstr .= '</a>';

          $this -> thumbstr .= '</li>';
          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_videogallery')) {
    class WPBakeryShortCode_cq_vc_videogallery extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_videogallery_item')) {
    class WPBakeryShortCode_cq_vc_videogallery_item extends WPBakeryShortCode {
    }
}

?>
