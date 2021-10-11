<?php
if (!class_exists('VC_Extensions_BorderHover')){
    class VC_Extensions_BorderHover{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Border Hover", 'cq_allinone_vc'),
            "base" => "cq_vc_borderhover",
            "class" => "cq_vc_borderhover",
            "controls" => "full",
            "icon" => "cq_vc_borderhover",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "show_settings_on_create" => true,
            'description' => esc_attr__('Hover image with border', 'js_composer'),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Element height", "cq_allinone_vc"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("The height of the image (in pixel), default is 240(px) (leave it to be blank). min-height is 200px.", "cq_allinone_vc")
              ),
              array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Image", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Resize the image?", "cq_allinone_vc"),
                 "param_name" => "isresize",
                 "value" => array("no", "yes"),
                 "std" => "no",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this size: ", "cq_allinone_vc"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "description" => esc_attr__("Width in pixel.", "cq_allinone_vc")
      		    ),
	            array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "holder" => "",
                 "heading" => esc_attr__("Border type when user hover", "cq_allinone_vc"),
                 "param_name" => "bordertype",
                 "value" => array("solid", "dashed", "dotted", "none"),
                 "std" => "solid",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "holder" => "",
                 "heading" => esc_attr__("Border animation style", "cq_allinone_vc"),
                 "param_name" => "borderanimation",
                 "value" => array("cross hand 1" => "crosshand1", "cross hand 2" => "crosshand3", "clock wise" => "crosshand2", "anti clock wise" => "crosshand4"),
                 "std" => "crosshand1",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Border color", "cq_allinone_vc"),
                "param_name" => "bordercolor",
                "value" => "",
                "description" => esc_attr__("Default is white.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Titile (optional).", "cq_allinone_vc"),
                "param_name" => "title",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size of the title", "cq_allinone_vc"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Default is 14px, support other value like 1.2em etc.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Title color", "cq_allinone_vc"),
                "param_name" => "titlecolor",
                "value" => "",
                "description" => esc_attr__("Default is dark gray.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Label under the title (optional).", "cq_allinone_vc"),
                "param_name" => "label",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("font size of the label", "cq_allinone_vc"),
                "param_name" => "labelsize",
                "value" => "",
                "description" => esc_attr__("Default is 14px, support other value like 1.2em etc.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Label color", "cq_allinone_vc"),
                "param_name" => "labelcolor",
                "value" => "",
                "description" => esc_attr__("Default is dark gray.", "cq_allinone_vc")
              ),
              array(
                "type" => "checkbox",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Hide the short border under the title?", "cq_allinone_vc"),
                "param_name" => "hidetitleborder",
                "value" => "no",
                "description" => esc_attr__("There is small border under the title by default. You can check here to hide them.", "cq_allinone_vc")
              ),
              array(
                "type" => "checkbox",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Hide the caption by default?", "cq_allinone_vc"),
                "param_name" => "hidetext",
                "value" => "no",
                "description" => esc_attr__("The caption is displayed by default. You can check here to hide them, and display while user mouse hover.", "cq_allinone_vc")
              ),
              array(
                "type" => "checkbox",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Add transparent gray overlay to the image when user hover?", "cq_allinone_vc"),
                "param_name" => "isoverlay",
                "value" => "no",
                "dependency" => Array('element' => "hidetext", 'value' => array('true')),
                "description" => esc_attr__("There is no transparent gray overlay by default. Check here is you want it.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Overlay color", "cq_allinone_vc"),
                "param_name" => "overlaycolor",
                "dependency" => Array('element' => "isoverlay", 'value' => array('true')),
                "value" => "",
                "description" => esc_attr__("Default is transparent gray.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "heading" => esc_attr__("Open the link as", "cq_allinone_vc"),
                "param_name" => "linktype",
                "value" => array(esc_attr__("Open lightbox (same image in large size)", "cq_allinone_vc") => "lightbox", esc_attr__("Custom lightbox (support different image or YouTube/Vimeo video too, specify URL below)", "cq_allinone_vc") => "lightbox_custom", esc_attr__("Custom link (specify link below)", "cq_allinone_vc") => "url_custom",  esc_attr__("Do nothing", "cq_allinone_vc") => "none"),
                "std" => "none",
                "group" => "Link",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "heading" => esc_attr__("Select lightbox mode", "cq_allinone_vc"),
                "param_name" => "lightboxmode",
                "value" => array(esc_attr__("prettyPhoto", "cq_allinone_vc") => "prettyphoto", esc_attr__("boxer", "cq_allinone_vc") => "boxer"),
                "std" => "boxer",
                "group" => "Link",
                "dependency" => Array('element' => "linktype", 'value' => array('lightbox')),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'custom URL', 'cq_allinone_vc' ),
                'param_name' => 'custom_url',
                "dependency" => Array('element' => "linktype", 'value' => array('url_custom')),
                'group' => 'Link',
                'description' => esc_attr__( '', 'cq_allinone_vc' )
              ),
              array(
                'type' => 'textfield',
                'heading' => esc_attr__( 'lightbox URL, support image or YouTube/Vimeo video', 'cq_allinone_vc' ),
                'param_name' => 'lightbox_url',
                "dependency" => Array('element' => "linktype", 'value' => array('lightbox_custom')),
                'group' => 'Link',
                'description' => esc_attr__( 'Just copy and paste the page URL of the YouTube or Vimeo video, something like https://www.youtube.com/watch?v=pNSKQ9Qp36M&autoplay=1 or https://vimeo.com/127081676?autoplay=1. Add the autoplay=1 in the URL to auto play the video. Also support custom image link. ', 'cq_allinone_vc' )
              ),
              array(
                'type' => 'textfield',
                'heading' => esc_attr__( 'video width, default is 640', 'cq_allinone_vc' ),
                'param_name' => 'videowidth',
                "dependency" => Array('element' => "linktype", 'value' => array('lightbox_custom')),
                'value' => '640',
                'group' => 'Link',
                'description' => esc_attr__( '', 'cq_allinone_vc' )
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("lightbox margin", "cq_allinone_vc"),
                "param_name" => "lightboxmargin",
                "value" => "",
                "dependency" => Array('element' => "linktype", 'value' => array('lightbox', 'lightbox_custom')),
                'group' => 'Link',
                "description" => esc_attr__("The margin of the lightbox image, default is 20 (in pixel).", "cq_allinone_vc")
              ),
              array(
                "type" => "css_editor",
                "heading" => esc_attr__( "CSS", "cq_allinone_vc" ),
                "param_name" => "css",
                "description" => esc_attr__("It's recommended to use this to customize the background only.", "cq_allinone_vc"),
                "group" => esc_attr__( "Design options", "cq_allinone_vc" ),
             )
           )
        ));


        add_shortcode('cq_vc_borderhover', array($this,'cq_vc_borderhover_func'));

      }

      function cq_vc_borderhover_func($atts, $content=null) {
        $titlesize = $labelsize = $elementheight = $title = $titlecolor = $label = $labelsize = $labelcolor = $tolerance = $css_class = $css = $hidetext = $linktype = $lightboxmode = $custom_url = $lightboxmargin = $lightbox_url = $videowidth = $bordertype = $borderanimation = $isoverlay = $overlaycolor = $bordercolor = $hidetitleborder = $extraclass = '';
        extract(shortcode_atts(array(
          "image" => "",
          "isresize" => "",
          "imagesize" => "",
          "title" => "",
          "label" => "",
          "titlesize" => "",
          "titlecolor" => "",
          "labelsize" => "",
          "labelcolor" => "",
          "elementheight" => "",
          "tolerance" => "14",
          "link" => "",
          "css" => "",
          "hidetext" => "",
          "linktype" => "none",
          "lightboxmargin" => "",
          "lightboxmode" => "boxer",
          "lightbox_url" => "",
          "videowidth" => "640",
          "custom_url" => "",
          "bordertype" => "solid",
          "borderanimation" => "crosshand1",
          "isoverlay" => "",
          "overlaycolor" => "",
          "bordercolor" => "",
          "hidetitleborder" => "",
          "extraclass" => ""
        ),$atts));

        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_borderhover', $atts);
        wp_register_style( 'vc-extensions-borderhover-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-borderhover-style' );

        wp_register_style('formstone-lightbox', plugins_url('../videocover/css/lightbox.css', __FILE__));
        wp_enqueue_style('formstone-lightbox');
        wp_register_style('fs.boxer', plugins_url('../depthmodal/css/jquery.fs.boxer.css', __FILE__));
        wp_enqueue_style('fs.boxer');

        wp_register_style('prettyphoto', vc_asset_url( 'lib/prettyphoto/css/prettyPhoto.min.css' ), array(), WPB_VC_VERSION );
        wp_enqueue_style('prettyphoto');

        wp_register_script('fs.boxer', plugins_url('../depthmodal/js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('fs.boxer');
        wp_register_script('formstone-lightbox', plugins_url('../videocover/js/lightbox.js', __FILE__));
        wp_enqueue_script('formstone-lightbox');
        wp_register_script('prettyphoto', vc_asset_url( 'lib/prettyphoto/js/prettyPhoto.min.js' ), array(), WPB_VC_VERSION );
        wp_enqueue_script('prettyphoto');

        wp_register_script('vc-extensions-borderhover-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "fs.boxer", "formstone-lightbox", "prettyphoto"));
        wp_enqueue_script('vc-extensions-borderhover-script');

        $custom_url = vc_build_link($custom_url);

        $img1 = $thumb_image = "";

        $full_image = wp_get_attachment_image_src($image, 'full');
        $thumb_image = $full_image[0];
        if($isresize=="yes"&&$imagesize!=""){
            if(function_exists('wpb_resize')){
                $img1 = wpb_resize($image, null, $imagesize, null);
                $thumb_image = $img1['url'];
                if($thumb_image=="") $thumb_image = $full_image[0];
            }
        }


        $output = "";
      	$output .= '<div class="cq-borderhover cq-bordertype-'.$bordertype.' cq-borderhover-hidetext'.$hidetext.' '.$extraclass.' '.$css_class.'" data-tolerance="'.$tolerance.'" data-elementheight="'.$elementheight.'" data-titlesize="'.$titlesize.'" data-labelsize="'.$labelsize.'" data-titlecolor="'.$titlecolor.'" data-overlaycolor="'.$overlaycolor.'" data-lightboxmargin="'.$lightboxmargin.'" data-bordercolor="'.$bordercolor.'">';
        $output .= '<div class="cq-borderhover-item cq-'.$borderanimation.'">';
        $output .= '<div class="cq-borderhover-background" style="background:url('.$thumb_image.');background-size:cover;background-position:center center;"></div>';
        $gallery_rand_id = "prettyPhoto";
        if($linktype=="lightbox"){
                  if($lightboxmode=="prettyphoto"){
                        $output .= '<a href="'.$full_image[0].'" data-rel="'.$gallery_rand_id.'" class="cq-borderhover-link cq-borderhover-prettyphoto" rel="'.$gallery_rand_id.'" data-linktype="'.$linktype.'">';
                  }else{
                        $output .= '<a href="'.$full_image[0].'" class="cq-borderhover-link cq-borderhover-lightbox" data-linktype="'.$linktype.'">';
                   }
          }else if($linktype=="lightbox_custom"){
              if(isset($lightbox_url)){
                  $output .= '<a href="'.$lightbox_url.'" class="cq-borderhover-link cq-borderhover-lightbox" data-linktype="'.$linktype.'" data-videowidth="'.$videowidth.'">';
              }
          }else {
              if(isset($custom_url['url'])){
                  $output .= '<a href="'.$custom_url['url'].'" class="cq-borderhover-link" title="'.$custom_url["title"].'" target="'.$custom_url["target"].'" rel="'.$custom_url["rel"].'">';
              }else{

                  $output .= '<a href="" class="cq-borderhover-link">';
              }
          }

        if($isoverlay!=""&&$hidetext!="")$output .= '<div class="cq-borderhover-overlay" style="background-color:'.$overlaycolor.'">';

        $output .= '<span class="cq-borderhover-leftborder"></span>
                    <span class="cq-borderhover-topborder"></span>
                    <span class="cq-borderhover-rightborder"></span>
                    <span class="cq-borderhover-bottomborder"></span>';
        $output .= '<div class="cq-borderhover-textcontainer">';
        if($title!=""){
            $output .= '<h3 class="cq-borderhover-title" style="color:'.$titlecolor.';font-size:'.$titlesize.'">'.$title.'</h3>';
            if(!$hidetitleborder)$output .= '<span class="cq-borderhover-titleborder" style="border-bottom-color:'.$titlecolor.';"></span>';
        }
        if($label!=""){
            $output .= '<p class="cq-borderhover-label" style="color:'.$labelcolor.';font-size:'.$labelsize.'">'.$label.'</p>';
        }
        if($isoverlay!="")$output .= '</div>';
        $output .= '</div>';
        $output .= '</a>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;

      }



  }
}
?>
