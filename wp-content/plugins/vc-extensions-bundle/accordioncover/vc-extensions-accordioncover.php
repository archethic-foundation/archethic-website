<?php
if (!class_exists('VC_Extensions_AccordionCover')) {
    class VC_Extensions_AccordionCover{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Accordion Cover", 'vc_accordioncover_cq'),
            "base" => "cq_vc_accordioncover",
            "class" => "wpb_cq_vc_extension_accordioncover",
            "icon" => "cq_allinone_accordioncover",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Image list with lightbox support', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => esc_attr__("Cover images:", "vc_accordioncover_cq"),
                "param_name" => "images",
                "value" => "",
                "group" => "Image",
                "description" => esc_attr__("Select image(s) from media library, support multiple images.", "vc_accordioncover_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_accordioncover_cq",
                "heading" => esc_attr__("Image on click", "vc_accordioncover_cq"),
                "param_name" => "onclick",
                "value" => array(esc_attr__("Open lightbox", "vc_accordioncover_cq") => "lightbox", esc_attr__("Do nothing", "vc_accordioncover_cq") => "none", esc_attr__("Open custom link", "vc_accordioncover_cq") => "customlink"),
                "std" => "none",
                "group" => "Image",
                "description" => esc_attr__("", "vc_accordioncover_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_accordioncover_cq",
                "heading" => esc_attr__("Custom link for each image", 'vc_accordioncover_cq'),
                "param_name" => "customlinks",
                "value" => esc_attr__("", 'vc_accordioncover_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('customlink')),
                "group" => "Image",
                "description" => esc_attr__("Divide with linebreak (Enter), available with open custom link option.", 'vc_accordioncover_cq')
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Custom link target", "vc_accordioncover_cq"),
                "param_name" => "customlinktarget",
                "description" => esc_attr__('Select how to open custom link.', 'vc_accordioncover_cq'),
                "dependency" => Array('element' => "onclick", 'value' => array('customlink')),
                "group" => "Image",
                'value' => array(esc_attr__("Same window", "vc_accordioncover_cq") => "_self", esc_attr__("New window", "vc_accordioncover_cq") => "_blank")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Resize the image?", "vc_accordioncover_cq"),
                "param_name" => "isresize",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "std" => "no",
                "group" => "Image",
                "description" => esc_attr__("", "vc_accordioncover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_accordioncover_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "group" => "Image",
                "description" => esc_attr__("Default we will use the original image, specify a width. For example, 200 will resize the image to width 200. ", "vc_accordioncover_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_accordioncover_cq",
                "heading" => esc_attr__("Title for each caption (optional)", 'vc_accordioncover_cq'),
                "param_name" => "titles",
                "value" => esc_attr__("", 'vc_accordioncover_cq'),
                "group" => "Caption",
                "description" => esc_attr__("Divide with linebreak (Enter)", 'vc_accordioncover_cq')
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Caption content, divide each one with <strong>[captionitem][/captionitem]</strong>, please try to edit in text mode:", "vc_accordioncover_cq"),
                "param_name" => "content",
                "group" => "Caption",
                "value" => esc_attr__("", "vc_accordioncover_cq"), "description" => esc_attr__("", "vc_accordioncover_cq"),
                "std" => '[captionitem]item caption 1[/captionitem]
[captionitem]item caption 2[/captionitem]
[captionitem]item caption 3[/captionitem]'
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_accordioncover_cq",
                "heading" => esc_attr__("The caption overlay background:", "vc_accordioncover_cq"),
                "param_name" => "overlaystyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Or you can customized background color below:" => "customized"),
                'std' => 'lavender',
                "description" => esc_attr__("", "vc_accordioncover_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color the caption", 'vc_accordioncover_cq'),
                "param_name" => "contentcolor",
                "value" => "",
                'dependency' => array('element' => 'overlaystyle', 'value' => 'customized'),
                "description" => esc_attr__("Default is white.", 'vc_accordioncover_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Customize caption overlay background color", 'vc_accordioncover_cq'),
                "param_name" => "captionbackground",
                "value" => '',
                'dependency' => array('element' => 'overlaystyle', 'value' => 'customized'),
                "description" => esc_attr__("", 'vc_accordioncover_cq')
              ),array(
                "type" => "textfield",
                "heading" => esc_attr__("Element height", "vc_accordioncover_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("The height of whole element, default is <strong>320px</strong>. You can specify other value here, like <strong>100vh</strong>, which stand for 100% of viewport height of the browser.", "vc_accordioncover_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_accordioncover_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_accordioncover_cq")
              )

           )
        ));

        add_shortcode('cq_vc_accordioncover', array($this,'cq_vc_accordioncover_func'));

      }


      function cq_vc_accordioncover_func($atts, $content=null, $tag) {
          extract(shortcode_atts(array(
            "images" => "",
            "imagewidth" => "",
            "isresize" => "no",
            "contentcolor" => "",
            "isshadow" => "tinyshadow",
            "onclick" => "none",
            "customlinks" => "",
            "customlinktarget" => "",
            "titles" => "",
            "contentstyle" => "",
            "overlaystyle" => "lavender",
            "captionbackground" => "",
            "contentcolor" => "",
            "elementheight" => "",
            "extraclass" => ""
          ), $atts));

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue('entypo');
          }else{
          }



          wp_register_script('fs.boxer', plugins_url('../depthmodal/js/jquery.fs.boxer.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('fs.boxer');
          wp_register_style('fs.boxer', plugins_url('../depthmodal/css/jquery.fs.boxer.css', __FILE__));
          wp_enqueue_style('fs.boxer');

          wp_register_style( 'vc-extensions-accordioncover-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-accordioncover-style' );

          wp_register_script('vc-extensions-accordioncover-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "fs.boxer"));
          wp_enqueue_script('vc-extensions-accordioncover-script');

          $content = str_replace('[/captionitem]', '', trim($content));
          $contentarr = explode('[captionitem]', trim($content));
          array_shift($contentarr);
          $imagesArr = explode(',', $images);

          $i = -1;
          $output = "";

          $customlinks = explode( ',', $customlinks);
          $titles = explode( ',', $titles);

          $image_str = '';

          $output .= '<div class="cq-accordioncover '.$overlaystyle.' '.$extraclass.'" data-overlaystyle="'.$overlaystyle.'" data-elementheight="'.$elementheight.'" data-captionbackground="'.$captionbackground.'" data-contentcolor="'.$contentcolor.'">';
          foreach ($imagesArr as $key => $theimage) {
              $i++;
              $imageLocation = wp_get_attachment_image_src($theimage, 'full');
              $img = $thumbnail = "";

              $fullimage = $imageLocation[0];
              $thumbnail = $fullimage;
              if($isresize=="yes"&&$imagewidth!=""){
                  if(function_exists('wpb_resize')){
                      $img = wpb_resize($theimage, null, $imagewidth, null);
                      $thumbnail = $img['url'];
                      if($thumbnail=="") $thumbnail = $fullimage;
                  }
              }

              $thecontent = "";
              $attachment = get_post($theimage);
              if($onclick=="customlink"){
                if(isset($customlinks[$i])&&$customlinks[$i]!="") $image_str .= '<a href="'.$customlinks[$i].'" target="'.$customlinktarget.'" class="cq-accordioncover-link">';
              }else if($onclick=="lightbox"){
                if($imageLocation[0]!="") $image_str .= '<a href="'.$imageLocation[0].'" class="cq-accordioncover-link cq-accordioncover-lightbox">';
              }
              if($imageLocation[0]!=""){
                    $image_str .= '<div class="cq-accordioncover-item cq'.count($imagesArr).'" data-image="'.$thumbnail.'">';
                      $image_str .= '<div class="cq-accordioncover-background"></div>';
                      $image_str .= '<div class="cq-accordioncover-overlay">';
                      $image_str .= '<div class="cq-accordioncover-textcontainer">';
                      if(isset($titles[$i])&&$titles[$i]!=""){
                          $image_str .= '<h4 class="cq-accordioncover-title">';
                          $image_str .= $titles[$i];
                          $image_str .= '</h4>';
                      }
                      if(isset($contentarr[$i])&&$contentarr[$i]!=""){
                        $thecontent = $contentarr[$i];
                        $thecontent = preg_replace("/(^)?(<br\s*\/?>\s*)+$/", "", $thecontent);
                        $thecontent = preg_replace('/^(<br \/>)*/', "", $thecontent);
                        $thecontent = preg_replace('/^(<\/p>)*/', "", $thecontent);
                        $image_str .= '<p class="cq-accordioncover-content">';
                        $image_str .= $thecontent;
                        $image_str .= '</p>';
                      }
                      $image_str .= '</div>';
                      $image_str .= '</div>';
                      $image_str .= '</div>';
              }

              if($onclick=="customlink"){
                if(isset($customlinks[$i])&&$customlinks[$i]!="") $image_str .= '</a>';
              }else if($onclick=="lightbox"){
                if($imageLocation[0]!="") $image_str .= '</a>';
              }


          }

          $output .= $image_str;

          $output .= '</div>';
          return $output;

        }
  }

}

?>
