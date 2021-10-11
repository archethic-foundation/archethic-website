<?php
if (!class_exists('VC_Extensions_Ribbon')) {

    class VC_Extensions_Ribbon {
        function __construct() {
          vc_map( array(
            "name" => esc_attr__("Ribbon", 'vc_ribbon_cq'),
            "base" => "cq_vc_ribbon",
            "class" => "wpb_cq_vc_extension_ribbon",
            "controls" => "full",
            "icon" => "cq_allinone_ribbon",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Image with ribbon', 'js_composer' ),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_ribbon_cq"),
                "param_name" => "image",
                "value" => "",
                "description" => esc_attr__("Select image from media library.", "vc_ribbon_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_ribbon_cq",
                "heading" => esc_attr__("Open image as:", "vc_ribbon_cq"),
                "param_name" => "openimageas",
                "value" => array(esc_attr__("fluidbox", "vc_ribbon_cq") => "fluidbox", esc_attr__("link", "vc_ribbon_cq") => "link", esc_attr__("none", "vc_ribbon_cq") => "none"),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                'type' => 'vc_link',
                "heading" => esc_attr__("Image link", "vc_ribbon_cq"),
                "param_name" => "imagelink",
                "value" => "",
                "dependency" => Array('element' => "openimageas", 'value' => array('link')),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Text under the image", "vc_ribbon_cq"),
                "param_name" => "content",
                "value" => esc_attr__("Here is the optional ribbon content, you can customize it in the backend editor. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, vel commodi neque.", "vc_ribbon_cq"),
                "description" => esc_attr__("Enter content for each block here. Divide each with paragraph (Enter).", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Ribbon text", "vc_ribbon_cq"),
                "param_name" => "label",
                "value" => "label",
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_ribbon_cq",
                "heading" => esc_attr__("Ribbon position", "vc_ribbon_cq"),
                "param_name" => "position",
                "value" => array(esc_attr__("left (rotate)", "vc_ribbon_cq") => "left", esc_attr__("right (rotate)", "vc_ribbon_cq") => "right", esc_attr__("left (no rotate)", "vc_ribbon_cq") => "left1", esc_attr__("right (no rotate)", "vc_ribbon_cq") => "right1"),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                'type' => 'vc_link',
                "heading" => esc_attr__("Ribbon link (optional)", "vc_ribbon_cq"),
                "param_name" => "ribbonlink",
                "value" => "",
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Ribbon width", "vc_ribbon_cq"),
                "param_name" => "ribbonwidth",
                "value" => "",
                "dependency" => Array('element' => "position", 'value' => array('left', 'right')),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Ribbon top", "vc_ribbon_cq"),
                "param_name" => "ribbontop_norotate",
                "value" => "10px",
                "dependency" => Array('element' => "position", 'value' => array('left1', 'right1')),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Ribbon bottom", "vc_ribbon_cq"),
                "param_name" => "ribbonbottom_norotate",
                "value" => "auto",
                "dependency" => Array('element' => "position", 'value' => array('left1', 'right1')),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Ribbon top", "vc_ribbon_cq"),
                "param_name" => "ribbontop1",
                "value" => "15px",
                "dependency" => Array('element' => "position", 'value' => array('left')),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Ribbon left", "vc_ribbon_cq"),
                "param_name" => "ribbonleft1",
                "value" => "-30px",
                "dependency" => Array('element' => "position", 'value' => array('left')),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Ribbon top", "vc_ribbon_cq"),
                "param_name" => "ribbontop2",
                "value" => "16px",
                "dependency" => Array('element' => "position", 'value' => array('right')),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Ribbon left", "vc_ribbon_cq"),
                "param_name" => "ribbonleft2",
                "value" => "10px",
                "dependency" => Array('element' => "position", 'value' => array('right')),
                "description" => esc_attr__("", "vc_ribbon_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Ribbon background color", 'vc_ribbon_cq'),
                "param_name" => "ribbonbg",
                "value" => "#f04256",
                "description" => esc_attr__("Specify the color of the ribbon.", 'vc_ribbon_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Ribbon font color", 'vc_ribbon_cq'),
                "param_name" => "ribboncolor",
                "value" => "",
                "description" => esc_attr__("Specify the color of the ribbon.", 'vc_ribbon_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Text (under the image) color", 'vc_ribbon_cq'),
                "param_name" => "textcolor",
                "value" => "",
                "description" => esc_attr__("Default is dark gray.", 'vc_ribbon_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Container background color", 'vc_ribbon_cq'),
                "param_name" => "containerbg",
                "value" => "",
                "description" => esc_attr__("Specify the color of the whole element.", 'vc_ribbon_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Margin top of the text under image", "vc_ribbon_cq"),
                "param_name" => "textmargintop",
                "value" => "",
                "description" => esc_attr__("CSS margin-top of the text under image. Default is 8px, you may have to specify other value in some theme.", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Container max width", "vc_ribbon_cq"),
                "param_name" => "width",
                "value" => "",
                "description" => esc_attr__("The container is 100% by default, you can specify a max-width for it here.", "vc_ribbon_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name for the container", "vc_ribbon_cq"),
                "param_name" => "extra_class",
                "description" => esc_attr__("You can append extra class to the container.", "vc_ribbon_cq")
              )

            )
        ));

        add_shortcode('cq_vc_ribbon', array($this,'cq_vc_ribbon_func'));
      }


      function cq_vc_ribbon_func($atts, $content=null, $tag) {
          extract( shortcode_atts( array(
            'image' => '',
            'width' => '',
            'label' => 'label',
            'ribbonwidth' => '',
            'position' => '',
            'ribbontop1' => '15px',
            'ribbonleft1' => '-30px',
            'ribbontop2' => '16px',
            'ribbonleft2' => '10px',
            'ribbontop_norotate' => '10px',
            'ribbonbottom_norotate' => 'auto',
            'ribbonbg' => '#f04256',
            'ribboncolor' => '',
            'openimageas' => 'fluidbox',
            'imagelink' => '',
            'ribbonlink' => '',
            'textcolor' => '',
            'containerbg' => '',
            'textmargintop' => '',
            'extra_class' => ''
          ), $atts ) );


          wp_register_style( 'vc_ribbon_cq_style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc_ribbon_cq_style' );

          wp_register_script('vc_ribbon_cq_script', plugins_url('js/jquery.ribbon.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc_ribbon_cq_script');

          $imagelink = vc_build_link($imagelink);
          $ribbonlink = vc_build_link($ribbonlink);

          if($openimageas=="fluidbox"){
              wp_register_script('fluidbox', plugins_url('../mediumgallery/js/jquery.fluidbox.min.js', __FILE__), array('jquery'));
              wp_enqueue_script('fluidbox');
              wp_enqueue_script('ribbonimage_init', plugins_url('js/ribbonimage_init.js', __FILE__), array('jquery'));
              wp_register_style( 'fluidbox', plugins_url('../mediumgallery/css/fluidbox.min.css', __FILE__) );
              wp_enqueue_style( 'fluidbox' );
          }

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $imageurl = wp_get_attachment_image_src($image, 'full');
          $attachment = get_post($image);
          $output = '';
          if($position=="left"){
             $ribbontop = $ribbontop1;
             $ribbonleft = $ribbonleft1;
          }else{
             $ribbontop = $ribbontop2;
             $ribbonleft = $ribbonleft2;
          }

          $output .= '<div class="cq-ribbon-container '.$extra_class.'" style="max-width:'.$width.';" data-ribbonwidth="'.$ribbonwidth.'" data-ribbontop="'.$ribbontop.'" data-ribbonleft="'.$ribbonleft.'"  data-ribboncolor="'.$ribboncolor.'" data-containerbg="'.$containerbg.'" data-textcolor="'.$textcolor.'" data-textmargintop="'.$textmargintop.'">';
          if($position=="left"||$position=="right"){
              if($ribbonlink["url"]!=""){
                $output .= '<div class="cq-ribbon '.$position.'"><div class="cq-ribbon-bg" style="background:'.$ribbonbg.';color:'.$ribboncolor.';"><a href="'.$ribbonlink["url"].'" target="'.$ribbonlink["target"].'">'.$label.'</a></div></div>';
              }else{
                $output .= '<div class="cq-ribbon '.$position.'"><div class="cq-ribbon-bg" style="background:'.$ribbonbg.';color:'.$ribboncolor.';">'.$label.'</div></div>';
              }
          }else{
            if($position=="left1"){
              if($ribbonlink["url"]!=""){
                $output .= '<div style="background:'.$ribbonbg.';color:'.$ribboncolor.';
background:'.$ribbonbg.';color:'.$ribboncolor.';top:'.$ribbontop_norotate.';bottom:'.$ribbonbottom_norotate.'" class="cq-ribbon3"><a href="'.$ribbonlink["url"].'" target="'.$ribbonlink["target"].'">'.$label.'</a><div class="arrow" style="border-color:transparent '.$ribbonbg.'"></div></div>';
              }else{
                $output .= '<div style="background:'.$ribbonbg.';color:'.$ribboncolor.';
background:'.$ribbonbg.';color:'.$ribboncolor.';top:'.$ribbontop_norotate.';bottom:'.$ribbonbottom_norotate.'" class="cq-ribbon3">'.$label.'<div class="arrow" style="border-color:transparent '.$ribbonbg.'"></div></div>';
              }
            }else{
              if($ribbonlink["url"]!=""){
                $output .= '<div style="background:'.$ribbonbg.';color:'.$ribboncolor.';
background:'.$ribbonbg.';color:'.$ribboncolor.';top:'.$ribbontop_norotate.';bottom:'.$ribbonbottom_norotate.'" class="cq-ribbon4"><a href="'.$ribbonlink["url"].'" target="'.$ribbonlink["target"].'">'.$label.'</a><div class="arrow" style="border-color:transparent '.$ribbonbg.'"></div></div>';
              }else{
                $output .= '<div style="background:'.$ribbonbg.';color:'.$ribboncolor.';
background:'.$ribbonbg.';color:'.$ribboncolor.';top:'.$ribbontop_norotate.';bottom:'.$ribbonbottom_norotate.'" class="cq-ribbon4">'.$label.'<div class="arrow" style="border-color:transparent '.$ribbonbg.'"></div></div>';
              }
            }
          }
          $output .= '<div class="cq-ribbon-content">';
          if($imageurl[0]!='') {
            if($openimageas=="fluidbox"){
              $output .= '<a href="'.$imageurl[0].'" class="ribbon-image">';
              $output .= '<img src="'.$imageurl[0].'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
              $output .= '</a>';
            }else if($openimageas=="link"){
              if($imagelink["url"]!=""){
                $output .= '<a href="'.$imagelink["url"].'" title="'.$imagelink["title"].'" target="'.$imagelink["target"].'">';
                $output .= '<img src="'.$imageurl[0].'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
                $output .= '</a>';
              }
            }else{
              $output .= '<img src="'.$imageurl[0].'" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />';
            }
          }
          if($content!="")$output .= '<p class="cq-ribbon-text">'.$content.'</p>';
          $output .= '</div>';
          $output .= '</div>';

          return $output;

        }

  }

}

?>
