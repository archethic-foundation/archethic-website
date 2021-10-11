<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2020 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

$esg_item_skin_cache = array();

class Essential_Grid_Item_Skin {

	public $grid_id = 0;

    private $id = '';
    private $name = '';
    private $handle = '';
    private $grid_type = 'even';
    private $params = array();
    private $layers = array();
    private $layer_values = false; //values to fill inside skin if we have custom selected. First false, becomes an array
    private $settings = array();
    private $filter = array();
    private $sorting = array();
    private $layers_css = array();
    private $layers_meta_css = array();
    private $cover_css = array();
    private $media_css = array();
    private $wrapper_css = array();
    private $content_css = array();
    private $media_poster_css = array();
    private $google_fonts = array();
    private $cover_image = '';
	private $cover_shadow = array();
	private $wrapper_shadow = array();
	private $media_shadow = array();
	private $content_shadow = array();

	/* 2.1.6.2 */
	private $grid_item_animation = 'none';
	private $grid_item_animation_other = 'none';
	private $grid_item_animation_zoomin = '125';
	private $grid_item_other_zoomin = '125';
	private $grid_item_animation_zoomout = '75';
	private $grid_item_other_zoomout = '75';
	private $grid_item_animation_fade = '75';
	private $grid_item_other_fade = '75';
	private $grid_item_animation_blur = '5';
	private $grid_item_other_blur = '5';
	private $grid_item_animation_shift = 'top';
	private $grid_item_other_shift = 'top';
	private $grid_item_animation_shift_amount = '10';
	private $grid_item_other_shift_amount = '10';
	private $grid_item_animation_rotate = '30';
	private $grid_item_other_rotate = '30';

	/* 2.2 */
	private $fancybox_three_options = array();

    private $default_image = '';
    private $default_image_attr = array();
    private $default_youtube_image = '';
    private $default_vimeo_image = '';
    private $default_html_image = '';
    private $media_sources = array();
	private $video_sizes = array('0' => array('height' => '480', 'width' => '640'), '1' => array('height' => '576', 'width' => '1024'));
    private $video_ratios = array('vimeo' => '1', 'youtube' => '1', 'wistia' => '1', 'html5' => '1');
    private $media_sources_type = 'full';
	private $item_media_type = ''; //gets the media type for later usage in advanced rules
    private $default_media_source_order = array();
    private $default_video_poster_order = array();
    private $default_lightbox_source_order = array();
    private $default_ajax_source_order = array();
    private $do_poster_cropping = false;
    private $lightbox_additions = array('items' => array(), 'base' => 'off'); //lightbox addition off
    private $lightbox_thumbnail = '';
    private $lb_rel = false;
    private $loaded_skins = array(); //holds all loaded skins that can be switchted to. Make sure that default skin is also present on init
    private $item_counter = 0; //for custom grids, holds the ID that is needed for search results and to give each Item a unique class

    private $add_css_tags = array(); //example usage: $this->add_css_tags[$unique_class]['a'] = true; //this will give the inner a tags styling informations
    private $add_css_wrap = array(); //example usage: $this->add_css_wrap[$unique_class]['wrap'] = true; //this will give the wrapping div element position and other stylings

    private $post = array();
    private $post_meta = array();

    private $load_more_element = false;
	private $lazy_load = false;
	private $lazy_load_blur = false;

	private $load_lightbox = false;

	public $ajax_loading = false;

    /**
     * init item skin by json data
     */
    public function init_by_data($data){

		$data = apply_filters('essgrid_init_by_data_item_skin', $data);

		$this->add_to_skin_list($data);

		$this->id = $data['id'];
		$this->name = $data['name'];
		$this->handle = $data['handle'];
		$this->params = $data['params'];
		$this->layers = $data['layers'];
		$this->settings = $data['settings'];

        $this->sort_item_skins();

    }


    /**
     * init item skin by id
     */
    public function init_by_id($id){
		global $wpdb;

		$id = intval($id);
		if($id == 0) return false;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;

		$skin = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);

		$skin = apply_filters('init_by_id', $skin, $id);

		if(!empty($skin)){
			$this->id = $skin['id'];
			$this->name = $skin['name'];
			$this->handle = $skin['handle'];
			$params = Essential_Grid_Base::stripslashes_deep(@json_decode($skin['params'], true));
			$this->params = $params;
			$layers = @json_decode($skin['layers'], true);
			if(!empty($layers) && is_array($layers)){ //prevent overhead
				foreach($layers as $lkey => $layer){
					$layers[$lkey] = Essential_Grid_Base::stripslashes_deep($layer);
				}
			}
			$this->layers = $layers;
			//$this->layers = Essential_Grid_Base::stripslashes_deep(@json_decode($skin['layers'], true));
			$settings = Essential_Grid_Base::stripslashes_deep(@json_decode($skin['settings'], true));
			$this->settings = $settings;


			//add to skin list
			$skin['params'] = $params;
			$skin['layers'] = $layers;
			$skin['settings'] = $settings;

			$this->add_to_skin_list($skin);

		}

        $this->sort_item_skins();
    }


    /**
     * Return all item skins
     */
    public static function get_essential_item_skins($type = 'all', $do_decode = true){
        global $wpdb, $esg_item_skin_cache;

		$item_skins = array();

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;

        switch($type){
            case 'even':
            case 'masonry':
				//$item_skins = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE type = %s", $type), ARRAY_A);
            break;
            case 'all':
            default:
				if(empty($esg_item_skin_cache)){
					$item_skins = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
					$esg_item_skin_cache = $item_skins;
				}else{
					$item_skins = $esg_item_skin_cache;
				}
            break;
        }


		if(!empty($item_skins) && $do_decode){
			foreach($item_skins as $key => $skin){
				$item_skins[$key]['params'] = Essential_Grid_Base::stripslashes_deep(@json_decode($item_skins[$key]['params'], true));
				$layers = @json_decode($item_skins[$key]['layers'], true);

				if(!empty($layers) && is_array($layers)){ //prevent overhead
					foreach($layers as $lkey => $layer){
						$layers[$lkey] = Essential_Grid_Base::stripslashes_deep($layer);
					}
				}
				$item_skins[$key]['layers'] = $layers;
				//$item_skins[$key]['layers'] = Essential_Grid_Base::stripslashes_deep(@json_decode($item_skins[$key]['layers'], true));
				$item_skins[$key]['settings'] = Essential_Grid_Base::stripslashes_deep(@json_decode($item_skins[$key]['settings'], true));
			}
		}

		return apply_filters('essgrid_get_essential_item_skins', $item_skins, $type, $do_decode);
    }


    /**
	 * Get Item Skin handle by ID from database
	 * @since: 1.5.0
	 */
	public static function get_handle_by_id($id = 0){
		global $wpdb;

		$id = intval($id);
		if($id == 0) return false;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;

		$skin = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);

		return apply_filters('essgrid_get_handle_by_id', $skin, $id);
	}


    /**
	 * Get Item Skin ID by handle from database
	 * @since: 1.5.0
	 */
	public static function get_id_by_handle($handle = ''){
		global $wpdb;

		if($handle == '') return false;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;

		$skin = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s", $handle), ARRAY_A);

		return apply_filters('essgrid_get_id_by_handle', $skin, $handle);
	}



    /**
	 * Get Item Skin by ID from Database
	 */
	public static function get_essential_item_skin_by_id($id = 0){
		global $wpdb;

		$id = intval($id);
		if($id == 0) return false;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;

		$skin = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);

		if(!empty($skin)){
			$skin['params'] = Essential_Grid_Base::stripslashes_deep(@json_decode($skin['params'], true));
			$layers = @json_decode($skin['layers'], true);
			if(!empty($layers) && is_array($layers)){ //prevent overhead
				foreach($layers as $lkey => $layer){
					$layers[$lkey] = Essential_Grid_Base::stripslashes_deep($layer);
				}
			}
			$skin['layers'] = $layers;
			//$skin['layers'] = Essential_Grid_Base::stripslashes_deep(@json_decode($skin['layers'], true));
			$skin['settings'] = Essential_Grid_Base::stripslashes_deep(@json_decode($skin['settings'], true));
		}

		return apply_filters('essgrid_get_essential_item_skin_by_id', $skin, $id);
	}


	/**
	 * Switch between Item Skins to allow more than one Skin in a Grid
	 * @since: 2.0
     */
	public function switch_item_skin($skin_id){

		$skin_id = apply_filters('essgrid_switch_item_skin', $skin_id, $this->loaded_skins);

		$to_default = false;

		if($skin_id == -1){
			$to_default = true;
		}else{
			//1. Check if Skin is already loaded (new variable to check if ID is initialized)
			if(!isset($this->loaded_skins[$skin_id])){
				//2. If not, get it and set it with: get_essential_item_skin_by_id()
				$skin = $this->get_essential_item_skin_by_id($skin_id);
				if(empty($skin)){
					$to_default = true;
				}else{
					//3. Switch the current things to the new one with: init_by_data()
					$this->init_by_data($skin);
				}
			}elseif($this->id !== $skin_id){
				//3. Switch the current things to the new one with: init_by_data()
				$this->init_by_data($this->loaded_skins[$skin_id]);
			}
		}

		//switch to default skin, which means first in loaded_skins
		if($to_default){
			$data = reset($this->loaded_skins);
			//3. Switch the current things to the new one with: init_by_data()
			if($data !== false)
				$this->init_by_data($data);
		}
	}


	/**
	 * Add Skin to the loaded_skins if not already existing
	 * @since: 2.0
     */
	public function add_to_skin_list($data){
		$data = apply_filters('essgrid_add_to_skin_list', $data);

		if(!isset($this->loaded_skins[$data['id']]))
			$this->loaded_skins[$data['id']] = $data;
	}


    /**
	 * Update / Save Item Skins
	 */
    public static function update_save_item_skin($data){
        global $wpdb;

		$data = apply_filters('essgrid_update_save_item_skin', $data);

        $table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;
        if(isset($data['name'])){
            if(strlen($data['name']) < 2) return __('Invalid name. Name has to be at least 2 characters long.', EG_TEXTDOMAIN);
            if(strlen(sanitize_title($data['name'])) < 2) return __('Invalid name. Name has to be at least 2 characters long.', EG_TEXTDOMAIN);

        }else{
            return __('Invalid name. Name has to be at least 2 characters long.', EG_TEXTDOMAIN);
        }

        if(isset($data['id'])){
            if(intval($data['id']) == 0) return __('Invalid Item Skin. Wrong ID given.', EG_TEXTDOMAIN);
        }

        if(isset($data['layers'])){ //set back to array for testing and stripping
			$layers = json_decode(stripslashes($data['layers']));
			if(empty($layers)) $layers = json_decode($data['layers']);
			$data['layers'] = $layers;
		}

        if(!isset($data['params']) || empty($data['params'])) return __('No parameters found.', EG_TEXTDOMAIN);
        if(!isset($data['layers']) || empty($data['layers'])) $data['layers'] = array(); //allow empty layers

        if(isset($data['id']) && intval($data['id']) > 0){ //update
			//check if entry with id exists, because this is unique
			$skin = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %s ", $data['id']), ARRAY_A);

            //check if handle already exists in another entry
            $check = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s AND id != %s ", array(sanitize_title($data['name']), $data['id'])), ARRAY_A);

            //check if exists, if no, create
            if(!empty($check)){
                return __('Item skin with chosen name already exist. Please use a different name.', EG_TEXTDOMAIN);
            }

			//check if exists, if yes, update
			if(!empty($skin)){
				$response = $wpdb->update($table_name,
											array(
												'name' => $data['name'],
												'handle' => sanitize_title($data['name']),
												'params' => json_encode($data['params']),
												'layers' => json_encode($data['layers'])
												), array('id' => $data['id']));

				if($response === false) return __('Item skin could not be changed.', EG_TEXTDOMAIN);

				return true;
			}
		}else{

            //create
            $skin = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s ", sanitize_title($data['name'])), ARRAY_A);

            //check if exists, if no, create
            if(!empty($skin)){
                return __('Item skin with chosen name already exist. Please use a different name.', EG_TEXTDOMAIN);
            }

            //insert if function did not return yet
            $response = $wpdb->insert($table_name, array('name' => $data['name'], 'handle' => sanitize_title($data['name']), 'params' => json_encode($data['params']), 'layers' => json_encode($data['layers'])));

            if($response === false) return false;

            return true;
        }
    }


	/**
	 * Delete Item Skin
	 * @return    boolean	true
	 */
	public static function delete_item_skin_by_id($data){
		global $wpdb;

		$data = apply_filters('essgrid_delete_item_skin_by_id', $data);

		if(!isset($data['id']) || intval($data['id']) == 0) return __('Invalid ID', EG_TEXTDOMAIN);

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;

		$response = $wpdb->delete($table_name, array('id' => $data['id']));
		if($response === false) return __('Item Skin could not be deleted', EG_TEXTDOMAIN);

		return true;
	}


    /**
	 * Sort Item Skin and delete empty layers
	 * @return    boolean	true
	 */
    public function sort_item_skins(){

        if(!empty($this->layers)){

            //clean empty layers
            foreach($this->layers as $id => $layer){
                if(empty($layer)) unset($this->layers[$id]);
            }

            //order layers by order
            if(count($this->layers) >= 2)
                usort($this->layers, array('Essential_Grid_Base', 'sort_by_order'));
        }

		$this->layers = apply_filters('essgrid_sort_item_skins', $this->layers);
    }


    /**
	 * Set Lazy Loading Variable
	 */
    public function set_lazy_load($set_to){

		$this->lazy_load = apply_filters('essgrid_set_lazy_load', $set_to);

    }


    /**
	 * Set Lazy Loading Blur Variable
	 */
    public function set_lazy_load_blur($set_to){

		$this->lazy_load_blur = apply_filters('essgrid_set_lazy_load_blur', $set_to);

    }


    /**
	 * Set Lazy Loading Variable
	 */
    public function set_grid_type($grid_type){

		$this->grid_type = apply_filters('essgrid_set_grid_type', $grid_type);

    }


	/**
	 * Set Lazy Loading Variable
	 */
    public function set_lightbox_rel($rel){

		$this->lb_rel = apply_filters('essgrid_set_lightbox_rel', $rel);

    }


    /**
	 * Set default lightbox source order
	 */
    public function set_default_lightbox_source_order($order){

		$this->default_lightbox_source_order = apply_filters('essgrid_set_default_lightbox_source_order', $order);

    }


    /**
	 * Set default ajax source order
	 * @since: 1.5.0
	 */
    public function set_default_ajax_source_order($order){

		$this->default_ajax_source_order = apply_filters('essgrid_set_default_ajax_source_order', $order);

    }


    /**
	 * Set default media source order
	 */
    public function set_default_media_source_order($order){

		$this->default_media_source_order = apply_filters('essgrid_set_default_media_source_order', $order);

    }


    /**
	 * Set default media source order
	 */
    public function set_default_video_poster_order($order){

		$this->default_video_poster_order = apply_filters('essgrid_set_default_video_poster_order', $order);

    }


    /**
	 * Set default media source order
	 */
    public function set_poster_cropping($set_to){

		$this->do_poster_cropping = apply_filters('essgrid_set_poster_cropping', $set_to);

    }


	/**
	 * Set LightBox mode
	 * @since: 1.5.4
	 */
	public function set_lightbox_addition($addition){

		$this->lightbox_additions = apply_filters('essgrid_set_lightbox_addition', $addition);

	}

    /**
	 * Set Fancybox 3 Options
	 * @since: 2.2
	 */
	public function set_fancybox_three_options($title){

		$options = array('title' => $title);
		$this->fancybox_three_options = apply_filters('essgrid_set_fancybox_three_options', $options);

	}

    /**
	 * Set video ratios
	 */
    public function set_video_ratios($video_ratios){

		$video_ratios = apply_filters('essgrid_set_video_ratios', $video_ratios);

		if(isset($video_ratios['vimeo']))
			$this->video_ratios['vimeo'] = intval($video_ratios['vimeo']);

		if(isset($video_ratios['youtube']))
			$this->video_ratios['youtube'] = intval($video_ratios['youtube']);

		if(isset($video_ratios['wistia']))
			$this->video_ratios['wistia'] = intval($video_ratios['wistia']);

		if(isset($video_ratios['html5']))
			$this->video_ratios['html5'] = intval($video_ratios['html5']);

		if(isset($video_ratios['soundcloud']))
			$this->video_ratios['soundcloud'] = intval($video_ratios['soundcloud']);

		$this->video_ratios = apply_filters('essgrid_set_video_ratios_set', $this->video_ratios, $video_ratios);
    }


	/**
	 * Set Sorting Values
	 */
    public function set_sorting($data){
    	$this->sorting = $data + $this->sorting; //merges the array and preserves the key

        arsort($this->sorting);

		$this->sorting = apply_filters('essgrid_set_sorting', $this->sorting, $data);
    }


	/**
	 * Star Item Skin
	 * @return    boolean	true
	 */
	public static function star_item_skin_by_id($data){
		global $wpdb;

		$data = apply_filters('essgrid_star_item_skin_by_id', $data);

		if(!isset($data['id']) || intval($data['id']) == 0) return __('Invalid ID', EG_TEXTDOMAIN);

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;

        $item_skin = $wpdb->get_row($wpdb->prepare("SELECT settings FROM $table_name WHERE id = %s", $data['id']), ARRAY_A);

        if(empty($item_skin)) return __('Invalid Skin', EG_TEXTDOMAIN);

        $settings = json_decode($item_skin['settings'], true);

        if(!isset($settings['favorite']) || $settings['favorite'] == false)
            $settings['favorite'] = true;
        else
            $settings['favorite'] = false;

        $response = $wpdb->update($table_name,
                            array(
                                'settings' => json_encode($settings)
                                ), array('id' => $data['id']));

		if($response === false) return __('Could not change Favorite', EG_TEXTDOMAIN);

		return true;
	}


    /**
	 * Duplicate Item Skin
	 * @return    boolean	true
	 */
	public static function duplicate_item_skin_by_id($data){
		global $wpdb;

		if(!isset($data['id']) || intval($data['id']) == 0) return __('Invalid ID', EG_TEXTDOMAIN);

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;

		//check if ID exists
		$duplicate = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %s", $data['id']), ARRAY_A);

		if(empty($duplicate))
			return __('Item Skin could not be duplicated', EG_TEXTDOMAIN);

		//get handle that does not exist by latest ID in table and search until handle does not exist
		$result = $wpdb->get_row("SELECT * FROM $table_name ORDER BY id", ARRAY_A);

		if(empty($result))
			return __('Item Skin could not be duplicated', EG_TEXTDOMAIN);

		//check if name Item Skin ID + n does exist and get until it does not
		$i = $result['id'] - 1;

		do {
			$i++;
			$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE name = %s", 'Item Skin '.$i), ARRAY_A);

		} while(!empty($result));

		//now add new Entry
		unset($duplicate['id']);
		$duplicate['name'] = 'Item Skin '.$i;
		$duplicate['handle'] = 'item-skin-'.$i;

		$duplicate = apply_filters('essgrid_duplicate_item_skin_by_id', $duplicate);

		$response = $wpdb->insert($table_name, $duplicate);

		if($response === false) return __('Item Skin could not be duplicated', EG_TEXTDOMAIN);

		return true;
	}


    /**
	 * insert default Item Skins
	 */
	public static function propagate_default_item_skins($networkwide = false){
		$skins = self::get_default_item_skins();

		if(function_exists('is_multisite') && is_multisite() && $networkwide){ //do for each existing site
			global $wpdb;

			// $old_blog = $wpdb->blogid;

            // Get all blog ids and create tables
			$blogids = $wpdb->get_col("SELECT blog_id FROM ".$wpdb->blogs);

            foreach($blogids as $blog_id){
				switch_to_blog($blog_id);

				$skins = apply_filters('essgrid_propagate_default_item_skins_multisite', $skins, $blog_id);

				self::insert_default_item_skins($skins);

				// 2.2.5
				restore_current_blog();
            }

            // switch_to_blog($old_blog); //go back to correct blog

		}else{

			$skins = apply_filters('essgrid_propagate_default_item_skins', $skins);

			self::insert_default_item_skins($skins);

		}
	}


	/**
	 * All default Item Skins
	 */
	public static function get_default_item_skins(){
		$default = array();

		include('assets/default-item-skins.php');

		$default = apply_filters('essgrid_add_default_item_skins', $default); //backwards compatibility
		$default = apply_filters('essgrid_get_default_item_skins', $default);

		return $default;
	}


	/**
	 * Insert Default Skin if they are not already installed
	 */
	public static function insert_default_item_skins($data){
		global $wpdb;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_ITEM_SKIN;

		$data = apply_filters('essgrid_insert_default_item_skins', $data);

        if(!empty($data)){
			foreach($data as $skin){

				//create
				$check = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s ", $skin['handle']), ARRAY_A);

				//check if exists, if no, create
				if(!empty($check)) continue;

				//insert if function did not return yet
				$response = $wpdb->insert($table_name, array('name' => $skin['name'], 'handle' => $skin['handle'], 'params' => $skin['params'], 'layers' => $skin['layers']));

			}
		}

	}


	/**
	 * Set Skin to Load More, giving for example the LI a new class
	 */
	public function set_load_more(){

		$this->load_more_element = apply_filters('essgrid_set_load_more', true);

	}


	/**
	 * Returns all Layers that the Skin has
	 * @since: 1.2.0
	 */
	public function get_skin_layer(){

		return apply_filters('essgrid_get_skin_layer', $this->layers);

	}


	/**
	 * Get the Skin ID
	 * @since: 1.2.0
	 */
	public function get_skin_id(){

		return apply_filters('essgrid_get_skin_id', $this->id);

	}


    /**
	 * Output a full Skin with items by data
	 * @return    string	html
	 */
    public function output_item_skin($demo = false, $choosen_skin = 0){

        $base = new Essential_Grid_Base();
        $grid = new Essential_Grid();
        $m = new Essential_Grid_Meta();


		$is_post = (!empty($this->layer_values)) ? false : true;

		$this->import_google_fonts();
		$this->register_google_fonts();

		    $layer_type = $base->getVar($this->params, 'choose-layout', 'even');

        $filters = '';
        if(!empty($this->filter)){
            foreach($this->filter as $filter){
                $filters.= ' filter-'.Essential_Grid_Base::sanitize_utf8_to_unicode($filter['slug']);
            }
        }
		if($demo !== false && $demo !== 'preview'){ //add favorite filter if we are in a demo
			if(isset($this->settings['favorite']) && $this->settings['favorite'] == true)
                $filters.= ' filter-favorite';

			if($demo == 'skinchoose' && $choosen_skin == $this->id || $choosen_skin == '-1')
				$filters.= ' filter-selectedskin';

		}


		    $sortings = '';
        if($demo === false || $demo === 'preview'){
            if(!empty($this->sorting)){
                foreach($this->sorting as $handle => $value){
                    $sorting_content = is_numeric($value) ? $value : sanitize_title($value);
                    $sortings.= ' data-'.esc_attr($handle).'="'.$sorting_content.'"';

                }
            }
        }

		$container_class = ' eg-'.esc_attr($this->handle).'-container';
		$li_class = ' eg-'.esc_attr($this->handle).'-wrapper';
		$li_skin = ' data-skin="' . esc_attr($this->handle) . '"';

		$li_class .= ($is_post) ? ' eg-post-id-'.@$this->post['ID'] : ' eg-post-id-'.$this->item_counter;
		$li_id = ($is_post) ? 'eg-'.$this->grid_id.'-post-id-'.@$this->post['ID'] : 'eg-'.$this->grid_id.'-post-id-'.$this->item_counter;
		$grid_ids = $this->grid_id;
		$post_ids = $is_post ? @$this->post['ID'] : $this->item_counter;

		$this->item_counter++;

		//check for custom meta layout settings
		$meta_cover_bg_color = $this->get_meta_layout_change('cover-bg-color');
		$meta_item_bg_color = $this->get_meta_layout_change('item-bg-color');
		$meta_content_bg_color = $this->get_meta_layout_change('content-bg-color');

		/* 2.1.6 */
		if($demo === false || $demo === 'preview') {

			if($is_post) {

				$meta216 = $m->get_meta_value_by_handle($this->post['ID'], 'eg_custom_meta_216');

				// if post has not been modified since 2.1.6 update, legacy values still exist and need to be converted
				if($meta216 != 'true') {

					$container_background_color = $base->getVar($this->params, 'container-background-color', '#000000');
					$meta_cover_bg_opacity = $this->get_meta_layout_change('cover-bg-opacity');
					$color_processed = ESGColorpicker::process($container_background_color);

					if(!empty($color_processed) && is_array($color_processed) && count($color_processed) > 1) {

						$color_type = $color_processed[1];
						if($meta_cover_bg_color === false && $meta_cover_bg_opacity !== false) {

							if($color_type === 'rgb' || $color_type === 'rgba') {
								$rgb_values = ESGColorpicker::rgbValues($container_background_color, 3);
								if(!empty($rgb_values) && is_array($rgb_values) && count($rgb_values) > 2) {
									$meta_cover_bg_opacity = intval($meta_cover_bg_opacity) / 100;
									$meta_cover_bg_color = 'rgba(' . $rgb_values[0] . ', ' . $rgb_values[1] . ', ' . $rgb_values[2] . ', ' . $meta_cover_bg_opacity . ')';
								}
							}
							else if($color_type === 'hex') {
								$meta_cover_bg_color = ESGColorpicker::convert($container_background_color, $meta_cover_bg_opacity);
							}
						}
						else if($meta_cover_bg_color !== false && $meta_cover_bg_opacity === false) {

							if($color_type === 'rgb' || $color_type === 'rgba') {
								$rgb_values = ESGColorpicker::rgbValues($container_background_color, 4);
								if(!empty($rgb_values) && is_array($rgb_values) && count($rgb_values) > 3) {
									$meta_cover_bg_color = ESGColorpicker::processRgba($meta_cover_bg_color, $rgb_values[3]);
								}
							}
						}
						else if($meta_cover_bg_color !== false && $meta_cover_bg_opacity !== false) {
							$meta_cover_bg_color = ESGColorpicker::convert($meta_cover_bg_color, $meta_cover_bg_opacity);
						}
					}
				}
			}
		}

		if($meta_cover_bg_color !== false) $meta_cover_bg_color = ESGColorpicker::get($meta_cover_bg_color);
		if($meta_content_bg_color !== false) $meta_content_bg_color = ESGColorpicker::get($meta_content_bg_color);
		if($meta_item_bg_color !== false) $meta_item_bg_color = ESGColorpicker::get($meta_item_bg_color);

		$meta_cover_style = '';
		if(!empty($meta_cover_bg_color)) {
			$meta_cover_style = ' style="background: '.$meta_cover_bg_color.';"';
		}

		$meta_content_style = '';
		if($meta_content_bg_color !== false){
			$meta_content_style = ' style="background: '.$meta_content_bg_color.';"';
		}

		$meta_item_style = '';
		if($meta_item_bg_color !== false){
			$meta_item_style = ' style="background: '.$meta_item_bg_color.';"';
		}

        $cover_type = $base->getVar($this->params, 'cover-type', 'full');

        $cover_animation_top = '';
        $cover_animation_delay_top = '';
        $cover_animation_center = '';
        $cover_animation_delay_center = '';
        $cover_animation_bottom = '';
        $cover_animation_delay_bottom = '';

        $cover_animation_duration_top = '';
        $cover_animation_duration_center = '';
        $cover_animation_duration_bottom = '';

		$cover_animation_color_top = '';
		$cover_animation_color_center = '';
		$cover_animation_color_bottom = '';

		$cover_wrapper_overflow = '';
		$cover_blend_mode = $base->getVar($this->params, 'cover-blend-mode', 'normal');
		$cover_blend_mode = $cover_blend_mode === 'normal' ? '' : ' esg-cover-blend-' . $cover_blend_mode;

		/* 2.1.6 */
		$force_key = wp_is_mobile() ? 'cover-always-visible-mobile' : 'cover-always-visible-desktop';
		$force_show_cover = $base->getVar($this->params, $force_key, '');

        if($cover_type == 'full'){ //cover is for overlay container

			/* 2.1.6 */
			if(empty($force_show_cover) || $force_show_cover === 'false') {
				$cover_animation_center = 'esg-'.$base->getVar($this->params, 'cover-animation-center', 'fade').$base->getVar($this->params, 'cover-animation-center-type', '');

				/* 2.2.6 */
				if(preg_match('/spiral|circle/', $cover_animation_center)) $cover_wrapper_overflow = ' esg-cover-overflow';
				if(preg_match('/line|spiral|circle/', $cover_animation_center)) $cover_animation_color_center = ' data-animcolor="' . $base->getVar($this->params, 'cover-animation-color-center', '#FFFFFF') . '"';
			}
			else {
				$cover_animation_center = 'esg-none';
			}

            if($cover_animation_center != 'esg-none' && $cover_animation_center != ' esg-noneout') {
                $cover_animation_delay_center = ' data-delay="'.round($base->getVar($this->params, 'cover-animation-delay-center', 0, 'i') / 100, 2).'"';
				$cover_animation_duration_center = ' data-duration="'.$base->getVar($this->params, 'cover-animation-duration-center', 'default').'"';
			}

        }else{

			/* 2.1.6 */
			if(empty($force_show_cover) || $force_show_cover === 'false') {
				$cover_animation_top = 'esg-'.$base->getVar($this->params, 'cover-animation-top', 'fade').$base->getVar($this->params, 'cover-animation-top-type', '');
				$cover_animation_center = 'esg-'.$base->getVar($this->params, 'cover-animation-center', 'fade').$base->getVar($this->params, 'cover-animation-center-type', '');
				$cover_animation_bottom = 'esg-'.$base->getVar($this->params, 'cover-animation-bottom', 'fade').$base->getVar($this->params, 'cover-animation-bottom-type', '');

				/* 2.2.6 */
				if(preg_match('/spiral|circle/', $cover_animation_top) || preg_match('/spiral|circle/', $cover_animation_center) || preg_match('/spiral|circle/', $cover_animation_bottom)) {
					$cover_wrapper_overflow = ' esg-cover-overflow';
				}

				if(preg_match('/line|spiral|circle/', $cover_animation_top)) $cover_animation_color_top = ' data-animcolor="' . $base->getVar($this->params, 'cover-animation-color-top', '#FFFFFF') . '"';
				if(preg_match('/line|spiral|circle/', $cover_animation_center)) $cover_animation_color_center = ' data-animcolor="' . $base->getVar($this->params, 'cover-animation-color-center', '#FFFFFF') . '"';
				if(preg_match('/line|spiral|circle/', $cover_animation_bottom)) $cover_animation_color_bottom = ' data-animcolor="' . $base->getVar($this->params, 'cover-animation-color-bottom', '#FFFFFF') . '"';

			}
			else {
				$cover_animation_top = 'esg-none';
				$cover_animation_center = 'esg-none';
				$cover_animation_bottom = 'esg-none';
			}

            if($cover_animation_top != 'esg-none' && $cover_animation_top != ' esg-noneout') {
                $cover_animation_delay_top = ' data-delay="'.round($base->getVar($this->params, 'cover-animation-delay-top', 0, 'i') / 100, 2).'"';
				$cover_animation_duration_top = ' data-duration="'.$base->getVar($this->params, 'cover-animation-duration-top', 'default').'"';
			}

            if($cover_animation_center != 'esg-none' && $cover_animation_center != ' esg-noneout') {
                $cover_animation_delay_center = ' data-delay="'.round($base->getVar($this->params, 'cover-animation-delay-center', 0, 'i') / 100, 2).'"';
				$cover_animation_duration_center = ' data-duration="'.$base->getVar($this->params, 'cover-animation-duration-center', 'default').'"';
			}

            if($cover_animation_bottom != 'esg-none' && $cover_animation_bottom != ' esg-noneout') {
                $cover_animation_delay_bottom = ' data-delay="'.round($base->getVar($this->params, 'cover-animation-delay-bottom', 0, 'i') / 100, 2).'"';
				$cover_animation_duration_bottom = ' data-duration="'.$base->getVar($this->params, 'cover-animation-duration-bottom', 'default').'"';
			}

        }

		// 2.2.5
		if($cover_animation_top) {

			$data_transition_top = ' data-transition="' . $cover_animation_top . '"';
			$cover_animation_top = ' esg-transition';

		}
		else {
			$data_transition_top = '';
		}

		if($cover_animation_center) {

			$data_transition_center = ' data-transition="' . $cover_animation_center . '"';
			$cover_animation_center = ' esg-transition';

		}
		else {
			$data_transition_center = '';
		}

		if($cover_animation_bottom) {

			$data_transition_bottom = ' data-transition="' . $cover_animation_bottom . '"';
			$cover_animation_bottom = ' esg-transition';

		}
		else {
			$data_transition_bottom = '';
		}


		/*  2.1.6
			the following moved up a bit in the function so we can do more things in the foreach loop
		*/
		$c_layer = 0;
		$t_layer = 0;
		$b_layer = 0;
		$m_layer = 0;

		/* 2.1.6 */
		$visible_prop = wp_is_mobile() ? 'always-visible-mobile' : 'always-visible-desktop';
		$disable_group_animation = false;

		if(!empty($this->layers)){
            foreach($this->layers as $key => $layer){
				if(isset($layer['container'])){
					if(!isset($layer['settings']['position']) || $layer['settings']['position'] !== 'absolute'){
						switch($layer['container']){
							case 'c':
								$c_layer++;
							break;
							case 'tl':
								$t_layer++;
							break;
							case 'br':
								$b_layer++;
							break;
							case 'm':
								$m_layer++;
							break;
						}
					}else{
						//absolute element marking
					}
				}

				/* 2.1.6 */
				if(isset($layer['settings']) && !empty($layer['settings']) && isset($layer['settings'][$visible_prop]) && !empty($layer['settings'][$visible_prop]) && $layer['settings'][$visible_prop] == 'true') {
					$layer['settings']['transition'] = 'none';
					$this->layers[$key] = $layer;
					$disable_group_animation = true;
				}

			}
		}

        //group is for cover container
        $cover_group_animation_delay = '';
		$cover_group_animation_duration = '';

		/* 2.1.6 */
		if(empty($disable_group_animation)) {
			$cover_group_animation = 'esg-'.$base->getVar($this->params, 'cover-group-animation', 'fade');
		}
		else {
			$cover_group_animation = 'esg-none';
		}

        if($cover_group_animation != 'esg-none') {
            $cover_group_animation_delay = ' data-delay="'.round($base->getVar($this->params, 'cover-group-animation-delay', 0, 'i') / 100, 2).'"';
			$cover_group_animation_duration = ' data-duration="'.$base->getVar($this->params, 'cover-group-animation-duration', 'deafult').'"';
		}
        else {
            $cover_group_animation = '';
		}

		// 2.2.5
		if($cover_group_animation) {

			$data_transition_group = ' data-transition="' . $cover_group_animation . '"';
			$cover_group_animation = ' esg-transition';

		}
		else {
			$data_transition_group = '';
		}

        //media is for media container
        $media_animation_delay = '';
		$media_animation_duration = '';
        $media_animation = 'esg-'.$base->getVar($this->params, 'media-animation', 'fade');
		$media_blur = strpos($media_animation, 'blur') === false ? '' : ' data-bluramount="' . $base->getVar($this->params, 'media-animation-blur', '5') . '"';

        if($media_animation != 'esg-none') {
            $media_animation_delay = ' data-delay="'.round($base->getVar($this->params, 'media-animation-delay', 0, 'i') / 100, 2).'"';
			$media_animation_duration = ' data-duration="'.$base->getVar($this->params, 'media-animation-duration', 'default').'"';
		}
        else {
            $media_animation = '';
		}

		if($this->load_more_element == true) $li_class .= ' eg-newli';

		/* 2.1.6 Split Item Option */
		$splitItem = $base->getVar($this->params, 'splitted-item', 'none');
		if(!empty($splitItem) && $splitItem !== 'none') {
			$li_class .= ' esg-split-content esg-split-' . $splitItem;
		}

		//check if we are on cobble, if yes, get the data of entry for cobbles
		$cobbles_data = '';
		if($this->grid_type == 'cobbles'){

			if($this->layer_values === false){ //we are on post
				$cobbles = json_decode(get_post_meta($this->post['ID'], 'eg_cobbles', true), true);
				if(isset($cobbles[$this->grid_id]['cobbles']) && strpos($cobbles[$this->grid_id]['cobbles'], ':') !== false)
					$use_cobbles = $cobbles[$this->grid_id]['cobbles'];
				else
					$use_cobbles = '1:1';

			}else{
				//get the info from $this->layer_values
				$use_cobbles = $base->getVar($this->layer_values, 'cobbles-size', '1:1');
			}

			$use_cobbles = explode(':', $use_cobbles);
			$cobbles_data = ' data-cobblesw="'.$use_cobbles[0].'" data-cobblesh="'.$use_cobbles[1].'"';
		}

		// 2.1.6.2 itm hover animation
		$itm_anime = $this->grid_item_animation;
		$item_animation = '';

		if($itm_anime !== 'none') {
			$item_animation .= ' data-anime="esg-item-' . $itm_anime . '"';
			switch($itm_anime) {
				case 'zoomin':
					$item_animation .= ' data-anime-zoomin="' . $this->grid_item_animation_zoomin . '"';
				break;
				case 'zoomout':
					$item_animation .= ' data-anime-zoomout="' . $this->grid_item_animation_zoomout . '"';
				break;
				case 'fade':
					$item_animation .= ' data-anime-fade="' . $this->grid_item_animation_fade . '"';
				break;
				case 'blur':
					$item_animation .= ' data-anime-blur="' . $this->grid_item_animation_blur . '"';
				break;
				case 'shift':
					$item_animation .= ' data-anime-shift="' . $this->grid_item_animation_shift . '"';
					$item_animation .= ' data-anime-shift-amount="' . $this->grid_item_animation_shift_amount . '"';
				break;
				case 'rotate':
					$item_animation .= ' data-anime-rotate="' . $this->grid_item_animation_rotate . '"';
				break;
			}
		}

		// 2.1.6.2 itm hover animation
		$itm_anime_other = $this->grid_item_animation_other;
		if($itm_anime_other !== 'none') {
			$item_animation .= ' data-anime-other="esg-item-' . $itm_anime_other . '"';
			switch($itm_anime_other) {
				case 'zoomin':
					$item_animation .= ' data-anime-other-zoomin="' . $this->grid_item_other_zoomin . '"';
				break;
				case 'zoomout':
					$item_animation .= ' data-anime-other-zoomout="' . $this->grid_item_other_zoomout . '"';
				break;
				case 'fade':
					$item_animation .= ' data-anime-other-fade="' . $this->grid_item_other_fade . '"';
				break;
				case 'blur':
					$item_animation .= ' data-anime-other-blur="' . $this->grid_item_other_blur . '"';
				break;
				case 'shift':
					$item_animation .= ' data-anime-other-shift="' . $this->grid_item_other_shift . '"';
					$item_animation .= ' data-anime-other-shift-amount="' . $this->grid_item_other_shift_amount . '"';
				break;
				case 'rotate':
					$item_animation .= ' data-anime-other-rotate="' . $this->grid_item_other_rotate . '"';
				break;
			}
		}

        //echo '<!-- PORTFOLIO ITEM '.$this->id.' -->'."\n";

		$cltitle = '';
		if($demo === 'skinchoose') {

			$li_class .= ' eg-tooltip-wrap';
			$cltitle = 'title="'.__('Select Skin', EG_TEXTDOMAIN). '" ';

		}

        echo '<li ' . $cltitle . 'id="'.$li_id.'"'.$li_skin.' class="filterall'.$filters.$li_class;
		if($demo == 'custom') echo ' eg-newli'; //neccesary for refresh of preview grid if new li will be added
		echo '"'.$sortings.$meta_item_style.$cobbles_data.$item_animation.'>'."\n";

        if($demo == 'overview' || $demo == 'skinchoose'){
            //check if fav or not

			$showid = (isset($_GET['showid'])) ? ' (ID: '.$this->id.')' : '';
			$cl = ($demo == 'skinchoose') ? 'esg-screenselect-toolbar' : 'esg-skineditor-toolbar'; //show only in grid editor at skin chooser

            echo '<div class="'.$cl.'">'."\n";
            echo '          <div class="btn-wrap-item-skin-overview-'.$this->id.'">'."\n";
            echo '<div class="eg-item-skin-overview-name">'.$this->name.$showid."</div>\n";

			if($demo == 'overview'){
				$fav_class = (!isset($this->settings['favorite']) || $this->settings['favorite'] == false) ? 'eg-icon-star-empty' : 'eg-icon-star';

				echo '<a href="javascript:void(0);" title="'.__('Mark as Favorite', EG_TEXTDOMAIN).'" class="eg-ov-1 eg-overview-button eg-btn-star-item-skin esg-purple eg-tooltip-wrap" id="eg-star-'. $this->id .'"><i class="'.$fav_class.'"></i></a>';
				echo '<a href="'.Essential_Grid_Base::getViewUrl(Essential_Grid_Admin::VIEW_ITEM_SKIN_EDITOR, 'create='.$this->id).'" title="'.__('Edit Skin', EG_TEXTDOMAIN).'" class="eg-tooltip-wrap eg-ov-2 eg-overview-button esg-green "><i class="eg-icon-droplet"></i></a>';
				echo '<a href="javascript:void(0);" title="'.__('Duplicate Skin', EG_TEXTDOMAIN).'" class="eg-ov-3 eg-overview-button eg-btn-duplicate-item-skin esg-blue eg-tooltip-wrap " id="eg-duplicate-'. $this->id .'"><i class="eg-icon-picture"></i></a>';
				echo '<a href="javascript:void(0);" title="'.__('Delete Skin', EG_TEXTDOMAIN).'" class="eg-ov-4 eg-overview-button eg-btn-delete-item-skin esg-red eg-tooltip-wrap " id="eg-delete-'. $this->id .'"><i class="eg-icon-trash"></i></a>';
			}elseif($demo == 'skinchoose'){
				echo '<a href="admin.php?page=essential-grid&view=grid-item-skin-editor&create=' . $this->id . '" class="eg-edit-skin-button eg-overview-button revyellow eg-tooltip-wrap" target="_blank" title="' . __('Edit Skin', EG_TEXTDOMAIN) . '"><i class="eg-icon-tint"></i></a>';
				echo '<input class="eg-tooltip-wrap " style="position: absolute; right: 0; top: 0;" type="radio" value="'.$this->id.'" title="'. __('Choose Skin', EG_TEXTDOMAIN).'" name="entry-skin"';
				if($choosen_skin == '-1')
					echo ' checked="checked"';
				else
					checked($choosen_skin, $this->id); //echo checked if it is current ID

				echo ' />';
			}
            echo '          </div>'."\n";
            echo '          <div class="clear"></div>'."\n\n";
            echo '       </div>'."\n\n";
        }elseif($demo == 'preview'){
			$this->post['ID'] = isset($this->post['ID']) ? $this->post['ID'] : "";
			$is_visible = $grid->check_if_visible($this->post['ID'], $this->grid_id);
			$vis_icon = ($is_visible) ? 'eg-icon-eye' : 'eg-icon-eye-off';
			$vis_icon_color = ($is_visible) ? 'esg-blue' : 'esg-red';

			echo '<div class="esg-atoolbar">'."\n";
            echo '          <div class="btn-wrap-item-skin-overview-'.$this->post['ID'].'">'."\n";
            echo '<div class="eg-item-skin-overview-name">';
			echo '<a href="javascript:void(0);" class="eg-ov-2 eg-overview-button eg-btn-activate-post-item '.$vis_icon_color.' eg-tooltip-wrap" title="'.__('Show/Hide from Grid', EG_TEXTDOMAIN).'" id="eg-act-post-item-'. $this->post['ID'] .'"><i class="'.$vis_icon.'"></i></a>';
			echo '<a href="'.get_edit_post_link($this->post['ID']).'" class="eg-ov-3 eg-overview-button esg-purple eg-tooltip-wrap" title="'.__('Edit Post', EG_TEXTDOMAIN).'" target="_blank"><i class="eg-icon-pencil-1"></i></a>';
			echo '<a href="javascript:void(0);" class="eg-ov-4 eg-overview-button eg-btn-edit-post-item esg-green eg-tooltip-wrap" title="'.__('Edit Post Meta', EG_TEXTDOMAIN).'" id="eg-edit-post-item-'. $this->post['ID'] .'"><i class="eg-icon-cog"></i></a>';
			echo '</div>'."\n";
			echo '          </div>'."\n";
            echo '          <div class="clear"></div>'."\n\n";
            echo '       </div>'."\n\n";
		}elseif($demo == 'custom'){ //add info of what items do exist in the layer that can be edited
			$custom_layer_elements = array();
			$custom_layer_data = array();
			if(!empty($this->layers)){
				foreach($this->layers as $layer){
					if(isset($layer['settings']['source'])){

						switch($layer['settings']['source']){
							case 'post':
								$custom_layer_elements[$layer['settings']['source-post']] = '';
								break;
							case 'woocommerce':
								$custom_layer_elements[$layer['settings']['source-woocommerce']] = '';
								break;
						}
					}
				}
			}

			if(!empty($this->layer_values))
				$custom_layer_data = $this->layer_values;

			$custom_layer_elements = htmlentities(json_encode($custom_layer_elements));
			$custom_layer_data = htmlentities(json_encode($custom_layer_data));

			echo '<input class="esg-items-datas" type="hidden" name="layers[]" value="'.$custom_layer_data.'" />'; //has the values for this entry
			echo '<div class="esg-data-handler" data-exists="'.$custom_layer_elements.'" style="display: none;"></div>'; //has the information on what exists as layers in the skin #3498DB

			echo '<div class="esg-atoolbar" style="background-color: transparent;">'."\n";
			echo '          <div class="btn-wrap-item-skin-overview-0">'."\n";
			echo '<div class="eg-item-skin-overview-name">';

			echo '<div title="'.__('Move', EG_TEXTDOMAIN).'" style="cursor: move;" class="eg-ov-10 eg-overview-button esg-purple eg-tooltip-wrap "><i class="eg-icon-menu"></i></div>';
			echo '<div title="'.__('Move one before', EG_TEXTDOMAIN).'" class="eg-ov-11 eg-overview-button eg-btn-move-before-custom-element esg-purple eg-tooltip-wrap "><i class="eg-icon-angle-left"></i></div>';
			echo '<div title="'.__('Move one after', EG_TEXTDOMAIN).'" class="eg-ov-12 eg-overview-button eg-btn-move-after-custom-element esg-purple eg-tooltip-wrap "><i class="eg-icon-angle-right"></i></div>';
			echo '<div title="'.__('Move after #x', EG_TEXTDOMAIN).'" class="eg-ov-13 eg-overview-button eg-btn-switch-custom-element esg-purple eg-tooltip-wrap "><i class="eg-icon-angle-double-right"></i></div>';

			echo '<div title="'.__('Delete Element', EG_TEXTDOMAIN).'" class="eg-ov-4 eg-overview-button eg-btn-delete-custom-element esg-red eg-tooltip-wrap "><i class="eg-icon-trash"></i></div>';
			echo '<div title="'.__('Duplicate Element', EG_TEXTDOMAIN).'" class="eg-ov-3 eg-overview-button eg-btn-duplicate-custom-element esg-blue eg-tooltip-wrap "><i class="eg-icon-picture"></i></div>';
			echo '<div title="'.__('Edit Element', EG_TEXTDOMAIN).'" class="eg-ov-2 eg-overview-button eg-btn-edit-custom-element esg-green eg-tooltip-wrap "><i class="eg-icon-cog"></i></div>';

			echo '</div>'."\n";
			echo '          </div>'."\n";
			echo '          <div class="clear"></div>'."\n\n";
			echo '       </div>'."\n\n";
		}

		$is_video = false;
		$is_iframe = false;
		$lightbox_thumb = false;
		$echo_media = '';

		if($demo == false || $demo == 'preview' || $demo == 'custom'){
			$video_poster_src = '';
			$video_poster_attr = '';
			//check for video poster image

			if(!empty($this->default_video_poster_order)){
				foreach($this->default_video_poster_order as $order){
					if($order == 'no-image'){ //do not show image so set image empty
						$video_poster_src = '';
						break;
					}
					if(isset($this->media_sources[$order]) && $this->media_sources[$order] !== '' && $this->media_sources[$order] !== false){ //found entry
						$video_poster_src = $this->media_sources[$order];
						if(isset($this->media_sources[$order.'-width']) && intval($this->media_sources[$order.'-width']) > 0 && isset($this->media_sources[$order.'-height']) && intval($this->media_sources[$order.'-height']) > 0){
							$video_poster_attr = ' width="'.$this->media_sources[$order.'-width'].'" height="'.$this->media_sources[$order.'-height'].'"';
						}
						$lightbox_thumb = $video_poster_src;
						break;
					}
				}
			}

			if(!empty($this->default_media_source_order)){ //only show if something is checked
				foreach($this->default_media_source_order as $order){ //go through the order and set media as wished
					if(isset($this->media_sources[$order]) && $this->media_sources[$order] !== '' && $this->media_sources[$order] !== false){ //found entry
						$do_continue = false;
						switch($order){
							case 'featured-image':
							case 'alternate-image':
							case 'content-image':
								$img_dim = $this->get_media_attributes($order);

								if($this->lazy_load){
									$small_thumb = '';
									if($this->lazy_load_blur){
										if(isset($this->media_sources['alternate-image-preload-url']) && !empty($this->media_sources['alternate-image-preload-url'])){
											$small_thumb = ' data-lazythumb="'.esc_attr($this->media_sources['alternate-image-preload-url']).'"';
										}else{
											$small_thumb = ess_aq_resize($this->media_sources[$order], 25, 25, true, true, true);
											if($small_thumb !== $this->media_sources[$order]){
											//$lightbox_thumb = $small_thumb;
												$small_thumb = ' data-lazythumb="'.$small_thumb.'"';
											}else{
												$small_thumb = '';
											}
										}
									}

									$lightbox_thumb = $this->media_sources[$order];

									$echo_media = '<img src="'.EG_PLUGIN_URL.'public/assets/images/300x200transparent.png"'.$small_thumb.' data-no-lazy="1" data-lazysrc="'.esc_attr($this->media_sources[$order]).'" alt="'.esc_attr($this->media_sources[$order.'-alt']).'"'.$img_dim.'>';
								}else{
									$echo_media = '<img src="'.esc_attr($this->media_sources[$order]).'" data-no-lazy="1" alt="'.esc_attr($this->media_sources[$order.'-alt']).'"'.$img_dim.'>';
									$lightbox_thumb = esc_attr($this->media_sources[$order]);
								}
							break;
							case 'youtube':
							case 'content-youtube':
								$youtube_image_type = $this->get_video_image_type('youtube');
								switch($youtube_image_type){
									case 'default-youtube-image':
										$video_poster_src = $this->default_youtube_image;
									break;
									case 'youtube-image':
										$video_poster_src = '//img.youtube.com/vi/' . esc_attr($this->media_sources[$order]) . '/0.jpg';
									break;
								}

								//if we are masonry, we need to crop the image
								$video_poster_src = ($this->do_poster_cropping == true) ? ess_aq_resize($video_poster_src, $this->video_sizes[$this->video_ratios['youtube']]['width'], $this->video_sizes[$this->video_ratios['youtube']]['height'], true, true, true) : $video_poster_src;
								$lightbox_thumb = $video_poster_src;

								$echo_media = '<div class="esg-media-video" data-youtube="'.esc_attr($this->media_sources[$order]).'" width="'.esc_attr($this->video_sizes[$this->video_ratios['youtube']]['width']).'" height="'.esc_attr($this->video_sizes[$this->video_ratios['youtube']]['height']).'" data-poster="'.esc_attr($video_poster_src).'"></div>';
								$is_video = true;
							break;
							case 'vimeo':
							case 'content-vimeo':
									$vimeo_image_type = $this->get_video_image_type('vimeo');
									switch($vimeo_image_type){
										case 'default-vimeo-image':
											$video_poster_src = $this->default_vimeo_image;
										break;
										case 'vimeo-image':
											$video = json_decode(wp_remote_fopen('https://vimeo.com/api/v2/video/'.esc_attr($this->media_sources[$order]) . '.json'));
											if(isset($video[0]->thumbnail_large)){
												$video_poster_src = str_replace('http://','https://',$video[0]->thumbnail_large);
											}
										break;
									}

								//if we are masonry, we need to crop the image
								$video_poster_src = ($this->do_poster_cropping == true) ? ess_aq_resize($video_poster_src, $this->video_sizes[$this->video_ratios['vimeo']]['width'], $this->video_sizes[$this->video_ratios['vimeo']]['height'], true, true, true) : $video_poster_src;
								$lightbox_thumb = $video_poster_src;

								$echo_media = '<div class="esg-media-video" data-vimeo="'.esc_attr($this->media_sources[$order]).'" width="'.esc_attr($this->video_sizes[$this->video_ratios['vimeo']]['width']).'" height="'.esc_attr($this->video_sizes[$this->video_ratios['vimeo']]['height']).'" data-poster="'.esc_attr($video_poster_src).'"></div>';
								$is_video = true;

							break;
							case 'wistia':
							case 'content-wistia':
								//if we are masonry, we need to crop the image
								$video_poster_src = ($this->do_poster_cropping == true) ? ess_aq_resize($video_poster_src, $this->video_sizes[$this->video_ratios['wistia']]['width'], $this->video_sizes[$this->video_ratios['wistia']]['height'], true, true, true) : $video_poster_src;
								$lightbox_thumb = $video_poster_src;

								$echo_media = '<div class="esg-media-video" data-wistia="'.esc_attr($this->media_sources[$order]).'" width="'.esc_attr($this->video_sizes[$this->video_ratios['wistia']]['width']).'" height="'.esc_attr($this->video_sizes[$this->video_ratios['wistia']]['height']).'" data-poster="'.esc_attr($video_poster_src).'"></div>';
								/*<a href="http://fast.wistia.net/embed/iframe/'.$this->media_sources[$order].'?popover=true" class="client-video wistia-popover[height=450,playerColor=ef4135,width=800]"><img src="'.$video_poster_src.'" /></a><script src="//fast.wistia.com/assets/external/popover-v1.js" charset="ISO-8859-1"></script>';*/
								$is_video = true;
							break;
							case 'html5':
							case 'content-html5':
								if((!isset($this->media_sources[$order]['mp4']) || $this->media_sources[$order]['mp4'] == '')
									&& (!isset($this->media_sources[$order]['webm']) || $this->media_sources[$order]['webm'] == '')
									&& (!isset($this->media_sources[$order]['ogv']) || $this->media_sources[$order]['ogv'] == '')
									){ //not a single video is set, go to the next instead of the break
									$do_continue = true;
									continue 2;
								}

								$html5_image_type = $this->get_video_image_type('html');

								if($html5_image_type=='default-html-image'){
									$video_poster_src = $this->default_html_image;
								}

								//if we are masonry, we need to crop the image
								$video_poster_src = ($this->do_poster_cropping == true) ? ess_aq_resize($video_poster_src, $this->video_sizes[$this->video_ratios['html5']]['width'], $this->video_sizes[$this->video_ratios['html5']]['height'], true, true, true) : $video_poster_src;
								$lightbox_thumb = $video_poster_src;

								$echo_media = '<div class="esg-media-video" data-mp4="'.esc_attr(@$this->media_sources[$order]['mp4']).'" data-webm="'.esc_attr(@$this->media_sources[$order]['webm']).'" data-ogv="'.esc_attr(@$this->media_sources[$order]['ogv']).'" width="'.esc_attr($this->video_sizes[$this->video_ratios['html5']]['width']).'" height="'.esc_attr($this->video_sizes[$this->video_ratios['html5']]['height']).'" data-poster="'.esc_attr($video_poster_src).'"></div>';
								$is_video = true;
							break;
							case 'soundcloud':
							case 'content-soundcloud':
								//if we are masonry, we need to crop the image
								$video_poster_src = ($this->do_poster_cropping == true) ? ess_aq_resize($video_poster_src, $this->video_sizes[$this->video_ratios['soundcloud']]['width'], $this->video_sizes[$this->video_ratios['soundcloud']]['height'], true, true, true) : $video_poster_src;
								$lightbox_thumb = $video_poster_src;

								$echo_media = '<div class="esg-media-video" data-soundcloud="'.esc_attr($this->media_sources[$order]).'" width="'.esc_attr($this->video_sizes[$this->video_ratios['soundcloud']]['width']).'" height="'.esc_attr($this->video_sizes[$this->video_ratios['soundcloud']]['height']).'" data-poster="'.esc_attr($video_poster_src).'"></div>';
								$is_video = true;
							break;
							case 'iframe':
								$echo_media = html_entity_decode($this->media_sources[$order]);
								$is_iframe = true;
							break;
							case 'content-iframe':
								$echo_media = html_entity_decode($this->media_sources[$order]);
								$is_iframe = true;
							break;
						}

						$echo_media = apply_filters('essgrid_set_media_source', $echo_media, $order, @$this->media_sources);
						$is_iframe = apply_filters('essgrid_set_media_source_is_iframe', $is_iframe, $order);
						$is_video = apply_filters('essgrid_set_media_source_is_video', $is_video, $order);
						$video_poster_src = apply_filters('essgrid_set_media_source_video_poster_src', $video_poster_src, $order, @$this->video_sizes, @$this->video_ratios);
						$do_continue = apply_filters('essgrid_set_media_source_do_continue', $do_continue, $order);

						if($do_continue){
							continue;
						}
						break;
					}
				}
			}

			if($echo_media == ''){ //set default image if one is set

				if($this->default_image !== ''){
					$def_img_attr = $this->get_media_attributes(false);

					$echo_media = '<img src="'.esc_attr($this->default_image).'"'.$def_img_attr.' data-no-lazy="1" />';
					$lightbox_thumb = esc_attr($this->default_image);
					$this->item_media_type = 'default-image';
				}
				// 2.1.6 - no image should output when the post/item has no media sources assigned
				// if(empty($echo_media)) $echo_media = '<img class="esg-no-media" src="'. EG_PLUGIN_URL .'public/assets/images/300x200transparent.png">';

			}else{
				$this->item_media_type = $order;
			}

			/* 2.1.6 new hover image */
			/* hover images just get lazy-loaded immediately after the main image loads (whenever that happens) */
			$hover_image = $base->getVar($this->params, 'element-hover-image', '');
			if(!empty($hover_image) && $hover_image !== 'false' && !empty($this->media_sources) && isset($this->media_sources['alternate-image']) && !empty($this->media_sources['alternate-image'])) {

				$hover_image = $this->media_sources['alternate-image'];
				$hover_image_animation = 'esg-'.$base->getVar($this->params, 'hover-image-animation', 'fade');

				if($hover_image_animation != 'esg-none') {
					$hover_image_animation_delay = ' data-delay="'.round($base->getVar($this->params, 'hover-image-animation-delay', 0, 'i') / 100, 2).'"';
				}
				else {
					$hover_image_animation = '';
					$hover_image_animation_delay = '';
				}

				// 2.2.5
				if($hover_image_animation) {

					$data_transition_hover = ' data-transition="' . $hover_image_animation . '"';
					$hover_image_animation = ' esg-transition';

				}
				else {
					$data_transition_hover = '';
				}

				$echo_media .= '<div class="esg-hover-image' . $hover_image_animation . '" data-src="' . $hover_image . '"' . $hover_image_animation_delay . $data_transition_hover . '></div>';
			}

		}
		//set the lightbox thumbnail for the current item!
		$this->lightbox_thumbnail = $lightbox_thumb;

		//check if we have a full link
		$link_set_to = $base->getVar($this->params, 'link-set-to', 'none');

		$link_type_link = $base->getVar($this->params, 'link-link-type', 'none');
		$link_target = $base->getVar($this->params, 'link-target', '_self');
		if($link_target !== 'disabled')
			$link_target = ' target="'.esc_attr($link_target).'"';
		else
			$link_target = '';

		$link_wrapper = '';

		if($link_set_to !== 'none'){

			switch($link_type_link){
				case 'post':
					if($demo === false){
						if($is_post){
							$link_wrapper = '<a href="'.get_permalink( $this->post['ID'] ).'"'.$link_target.'>%REPLACE%</a>';
						}else{
							$get_link = $this->get_custom_element_value('post-link', '', ''); //get the post link
							if($get_link == '') {
								$link_wrapper = '<a href="javascript:void(0);"'.$link_target.'>%REPLACE%</a>';
							}
							else {

								/* 2.1.6 append "http" to manually written links starting with "www" */
								$get_link = esc_attr($get_link);
								if(strpos($get_link, '://') === false) {
									$get_link = !is_ssl() ? 'http://' . $get_link : 'https://' . $get_link;
								}

								$link_wrapper = '<a href="'.$get_link.'"'.$link_target.'>%REPLACE%</a>';
							}
						}

					}else{
						$link_wrapper = '<a href="javascript:void(0);"'.$link_target.'>%REPLACE%</a>';
					}
				break;
				case 'url':
					$lurl = $base->getVar($this->params, 'link-url-link', 'javascript:void(0);');
					if(strpos($lurl, '://') === false && trim($lurl) !== '' && $lurl !== 'javascript:void(0);'){
						$lurl = (is_ssl()) ? 'https://'.esc_attr($lurl) : 'http://'.esc_attr($lurl);
					}
					$link_wrapper = '<a href="'.esc_attr($lurl).'"'.$link_target.'>%REPLACE%</a>';
				break;
				case 'meta':

					if($demo === false){
						if($is_post){
							$meta_key = $base->getVar($this->params, 'link-meta-link', 'javascript:void(0);');

							$meta_link = $m->get_meta_value_by_handle($this->post['ID'], $meta_key);
							if($meta_link == ''){// if empty, link to nothing
								$link_wrapper = '<a href="javascript:void(0);"'.$link_target.'>%REPLACE%</a>';
							}else{

								/* 2.1.6 append "http" to manually written links starting with "www" */
								$meta_link = esc_attr($meta_link);
								if((strpos($meta_link, '://') === false) && (strpos($meta_link, 'mailto:') === false)){
									$meta_link = !is_ssl() ? 'http://' . $meta_link : 'https://' . $meta_link;
								}

								$link_wrapper = '<a href="'.$meta_link.'"'.$link_target.'>%REPLACE%</a>';
							}
						}else{
							$meta_key = $base->getVar($this->params, 'link-meta-link', 'javascript:void(0);');

							$get_link = $this->get_custom_element_value($meta_key, '', ''); //get the post link
							if($get_link == '') {
								$link_wrapper = '<a href="javascript:void(0);"'.$link_target.'>%REPLACE%</a>';
							}
							else {

								/* 2.1.6 append "http" to manually written links starting with "www" */
								$get_link = esc_attr($get_link);
								if(strpos($get_link, '://') === false) {
									$get_link = !is_ssl() ? 'http://' . $get_link : 'https://' . $get_link;
								}

								$link_wrapper = '<a href="'.$get_link.'"'.$link_target.'>%REPLACE%</a>';
							}
						}
					}else{
						$link_wrapper = '<a href="javascript:void(0);"'.$link_target.'>%REPLACE%</a>';
					}
				break;
				case 'javascript':
					$js_link = esc_attr($base->getVar($this->params, 'link-javascript-link', 'void(0);'));
					$link_wrapper = '<a href="javascript:'.esc_attr($js_link).'"'.$link_target.'>%REPLACE%</a>';
				break;
				case 'lightbox':
					$opt = get_option('tp_eg_use_lightbox', 'false');
					if($opt !== 'disabled'){ //enqueue only if default LightBox is selected
						wp_enqueue_script('themepunchboxext');
						wp_enqueue_style('themepunchboxextcss');
					}

					$lb_source = 'javascript:void(0);';
					$lb_owidth = '';
					$lb_oheight = '';
					$lb_class = '';
					$lb_addition = '';
					$lb_content = '';
					$lb_data = '';
					$lb_featured = '';
					$lb_post_title = '';
					$lb_rel = ($this->lb_rel !== false) ? ' data-esgbox="'.esc_attr($this->lb_rel).'"' : '';

					if(!empty($this->default_lightbox_source_order)){ //only show if something is checked
						foreach($this->default_lightbox_source_order as $order){ //go through the order and set media as wished

							$val = isset($this->media_sources[$order]) && $this->media_sources[$order] !== '' && $this->media_sources[$order] !== false;
							if($order === 'post-content' || !empty($val)){ //found entry

								$do_continue = false;
								if(!empty($this->lightbox_additions['items']) && $this->lightbox_additions['base'] == 'on') {
									$lb_source = $this->lightbox_additions['items'][0];
									$lb_class = ' esgbox';
								}
								else{

									switch($order){

										case 'featured-image':
										case 'alternate-image':
										case 'content-image':

											// 2.2.5
											$imgsource = explode('-', $order);
											$imgsource = $imgsource[0];

											if($order == 'content-image') $lb_source = $this->media_sources[$order];
											else $lb_source = $this->media_sources[$order.'-full'];
											$lb_class = ' esgbox';

											if(isset($this->media_sources[$imgsource . '-image-full-width'])) $lb_owidth = ' data-width="' . $this->media_sources[$imgsource . '-image-full-width'] . '" ';
											if(isset($this->media_sources[$imgsource . '-image-full-height'])) $lb_oheight = ' data-height="' . $this->media_sources[$imgsource . '-image-full-height'] . '" ';

										break;

										case 'youtube':
											$http = (is_ssl()) ? 'https' : 'http';
											$enable_youtube_nocookie = get_option('tp_eg_enable_youtube_nocookie', 'false');
											$lb_source = $enable_youtube_nocookie!='false' ? $http.'://www.youtube-nocookie.com/embed/'.$this->media_sources[$order] : $lb_source = $http.'://www.youtube.com/watch?v='.$this->media_sources[$order];
											$lb_addition = ($this->video_ratios['youtube'] == '1') ? '' : ' data-ratio="4:3"';
											$lb_class = ' esgbox';
										break;
										case 'vimeo':
											$http = (is_ssl()) ? 'https' : 'http';
											$lb_source = $http.'://vimeo.com/'.$this->media_sources[$order];
											$lb_addition = ($this->video_ratios['vimeo'] == '1') ? '' : ' data-ratio="4:3"';
											$lb_class = ' esgbox';
										break;
										case 'wistia':
											// $http = (is_ssl()) ? 'https' : 'http';
											$lb_source = '//fast.wistia.net/embed/iframe/'.$this->media_sources[$order];
											$lb_class = ' esgbox';
											$lb_data .= ' data-type="iframe"';
											$lb_addition = ($this->video_ratios['wistia'] == '1') ? '' : ' data-ratio="4:3"';
										break;
										case 'soundcloud':
											$lb_source = '//w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' . $this->media_sources[$order] . '&amp;color=%23ff5500&amp;auto_play=true&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;show_teaser=true&amp;visual=true';
											$lb_class = ' esgbox';
											$lb_data .= ' data-type="iframe"';
										break;
										case 'iframe':
											$lb_source = addslashes($this->media_sources[$order]);
											$lb_class = ' esgbox';
											$lb_data .= ' data-type="iframe"';
										break;
										case 'html5':
											if(trim($this->media_sources[$order]['mp4']) === '' && trim($this->media_sources[$order]['ogv']) === '' && trim($this->media_sources[$order]['webm'] === '')){
												$do_continue = true;
											}else{
												$lb_mp4 = $this->media_sources[$order]['mp4'];
												$lb_ogv = $this->media_sources[$order]['ogv'];
												$lb_webm = $this->media_sources[$order]['webm'];
												$lb_source = "";
												if(!empty($lb_mp4)){
													$lb_source = $lb_mp4;
												}
												elseif (!empty($lb_ogv)) {
													$lb_source = $lb_ogv;
												}
												elseif (!empty($lb_webm)) {
													$lb_source = $lb_webm;
												}
												$lb_class = ' esgbox esgboxhtml5';
												$vid_ratio = ($this->video_ratios['html5'] == '1') ? '' : ' data-ratio="4:3"';

												$lb_addition = ' data-mp4="'.esc_attr($lb_mp4).'" data-ogv="'.esc_attr($lb_ogv).'" data-webm="'.esc_attr($lb_webm).'"'.$vid_ratio;
												if($lightbox_thumb !== false){
													$lb_content = '<img style="display: none;" src="'.esc_attr($lightbox_thumb).'" />';
												}
											}
										break;

										case 'post-content':

											$lb_source = 'javascript:void(0);';
											$lb_class = ' esgbox esgbox-post';
											$lb_data = ' data-post="' . $post_ids . '"';
											$lb_data .= ' data-gridid="' . $grid_ids . '" data-ispost="' . $is_post . '"';

											$lb_post_title  = $is_post ? $base->getVar($this->post, 'post_title', '') : $this->get_custom_element_value('title', $separator, '');
											$lb_post_title = ' data-posttitle="' . $lb_post_title . '"';

											// if featured full is available
											if(isset($this->media_sources['featured-image-full']) && !empty($this->media_sources['featured-image-full'])) {
												$lb_featured = ' data-featured="' . esc_attr($this->media_sources['featured-image-full']) . '"';
											}
											// if featured regular size is available
											else if(isset($this->media_sources['featured-image']) && !empty($this->media_sources['featured-image'])) {
												$lb_featured = ' data-featured="' . esc_attr($this->media_sources['featured-image']) . '"';
											}
											// if global image is available
											else if(!empty($this->default_image)) {
												$lb_featured = ' data-featured="' . esc_attr($this->default_image) . '"';
											}

										break;

										case 'revslider':

											$lb_source = admin_url('admin-ajax.php');
											$lb_class = ' esgbox esgbox-post';
											$lb_data = ' data-post="' . $post_ids . '" data-revslider="' . $this->media_sources[$order] . '"';
											$lb_data .= ' data-gridid="' . $grid_ids . '" data-ispost="' . $is_post . '"';

										break;

										case 'essgrid':

											$lb_source = admin_url('admin-ajax.php');
											$lb_class = ' esgbox esgbox-post';
											$lb_data = ' data-post="' . $post_ids . '" data-lbesg="' . $this->media_sources[$order] . '"';
											$lb_data .= ' data-gridid="' . $grid_ids . '" data-ispost="' . $is_post . '"';

										break;

									}
								}
								if($do_continue){
									continue;
								}
								break;
							}

							/* 2.1.6 */
							if($order === 'featured-image') {
								$default_img = $this->default_image;
								if(!empty($default_img)) {
									$lb_source = $default_img;
									$lb_class = ' esgbox';
									$lb_owidth = ' data-width="' . $this->default_image_attr[0] . '" ';
									$lb_oheight = ' data-height="' . $this->default_image_attr[1] . '" ';
									break;
								}
							}
						}
					}

					if($demo !== false){
						$lb_title = __('demo mode', EG_TEXTDOMAIN);
					}else{
						if($is_post)
							$lb_title = $base->getVar($this->post, 'post_title', '');
						else
							$lb_title = $this->get_custom_element_value('title', '', ''); //the title from Post Title will be used
					}

					/* 2.2 */
					$lb_caption = isset($this->fancybox_three_options['title']) ? $this->fancybox_three_options['title'] : 'off';
					$lb_caption = $lb_caption === 'on' ? ' data-caption="' . esc_attr($lb_title) . '" ' : '';

					$link_wrapper = '<a class="'.$lb_class.'"'.$lb_addition.' href="'.esc_attr($lb_source).'" data-thumb="'. esc_attr( ess_aq_resize($this->lightbox_thumbnail, 200) ) .'" '.$lb_caption.$lb_owidth.$lb_oheight.$lb_rel.$lb_data.$lb_featured.$lb_post_title.'>'.$lb_content.'%REPLACE%</a>';

					$this->load_lightbox = true; //set that jQuery is written
				break;
				case 'ajax':
					$ajax_class = '';
					if(!empty($this->default_ajax_source_order)){ //only show if something is checked
						$ajax_class = ' eg-ajaxclicklistener';
						foreach($this->default_ajax_source_order as $order){ //go through the order and set media as wished
							$do_continue = false;
							if(isset($this->media_sources[$order]) && $this->media_sources[$order] !== '' && $this->media_sources[$order] !== false || $order == 'post-content'){ //found entry
								switch($order){
									case 'youtube':
										$vid_ratio = ($this->video_ratios['youtube'] == '0') ? '4:3' : '16:9';
										$ajax_attr = ' data-ajaxtype="youtubeid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
										$ajax_attr .= ' data-ajaxsource="'.esc_attr($this->media_sources[$order]).'"'; //depending on type
										$ajax_attr .= ' data-ajaxvideoaspect="'.$vid_ratio.'"'; //depending on type
									break;
									case 'vimeo':
										$vid_ratio = ($this->video_ratios['vimeo'] == '0') ? '4:3' : '16:9';
										$ajax_attr = ' data-ajaxtype="vimeoid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
										$ajax_attr .= ' data-ajaxsource="'.esc_attr($this->media_sources[$order]).'"'; //depending on type
										$ajax_attr .= ' data-ajaxvideoaspect="'.$vid_ratio.'"'; //depending on type
									break;
									case 'wistia':
										$vid_ratio = ($this->video_ratios['wistia'] == '0') ? '4:3' : '16:9';
										$ajax_attr = ' data-ajaxtype="wistiaid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
										$ajax_attr .= ' data-ajaxsource="'.esc_attr($this->media_sources[$order]).'"'; //depending on type
										$ajax_attr .= ' data-ajaxvideoaspect="'.$vid_ratio.'"'; //depending on type
									break;
									case 'html5':
										if($this->media_sources[$order]['mp4'] == ''
										&& $this->media_sources[$order]['webm'] == ''
										&& $this->media_sources[$order]['ogv'] == ''){
											$do_continue = true;
										}else{
											//mp4/webm/ogv
											$vid_ratio = ($this->video_ratios['html5'] == '0') ? '4:3' : '16:9';
											$ajax_attr = ' data-ajaxtype="html5vid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
											$ajax_attr .= ' data-ajaxsource="';
											$ajax_attr .= esc_attr(@$this->media_sources[$order]['mp4']).'|';
											$ajax_attr .= esc_attr(@$this->media_sources[$order]['webm']).'|';
											$ajax_attr .= esc_attr(@$this->media_sources[$order]['ogv']);
											$ajax_attr .= '"';
											$ajax_attr .= ' data-ajaxvideoaspect="'.$vid_ratio.'"'; //depending on type
										}
									break;
									case 'soundcloud':
										$ajax_attr = ' data-ajaxtype="soundcloudid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
										$ajax_attr .= ' data-ajaxsource="'.esc_attr($this->media_sources[$order]).'"'; //depending on type
									break;
									case 'post-content':
										if($is_post){
											$ajax_attr = ' data-ajaxtype="postid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
											$ajax_attr .= ' data-ajaxsource="'.@$this->post['ID'].'"'; //depending on type
										}else{
											$do_continue = true;
											//$ajax_class = '';
										}
									break;
									case 'featured-image':
									case 'alternate-image':
									case 'content-image':
										$img_url = '';
										if($order == 'content-image')
											$img_url = $this->media_sources[$order];
										else
											$img_url = $this->media_sources[$order.'-full'];

										$ajax_attr = ' data-ajaxtype="imageurl"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
										$ajax_attr .= ' data-ajaxsource="'.esc_attr($img_url).'"'; //depending on type
									break;
									default:
										$ajax_class = '';
										$do_continue = true;
									break;
								}
								if($do_continue){
									continue;
								}
								break;
							}else{ //some custom entry maybe
								$postobj = ($is_post) ? $this->post : false;

								$ajax_attr = apply_filters('essgrid_handle_ajax_content', $order, $this->media_sources, $postobj, $this->grid_id);
								if(empty($ajax_attr)){
									//$ajax_class = '';
									$do_continue = true;
								}

								if($do_continue){
									continue;
								}
								break;
							}
						}
					}

					if($ajax_class !== ''){ //set ajax loading to true so that the grid can decide to put ajax container in top/bottom
						$link_wrapper = '<a href="javascript:void(0);" '.$ajax_attr.'>%REPLACE%</a>';
						$this->ajax_loading = true;
					}

				break;
			}
		}

        if($m_layer > 0){
            $show_content = $base->getVar($this->params, 'show-content', 'bottom');

            if($show_content == 'top'){
                self::insert_masonry_layer($demo, $meta_content_style, $is_video, $grid_ids, $post_ids);
            }
        }

		if($is_iframe != false) //disable animation if we fill in iFrame
			$media_animation = '';

		if(isset($hover_image) && !empty($hover_image) && $hover_image !== 'false')
			$media_animation = '';

		// 2.2.5
		if($media_animation) {

			$data_transition_media = ' data-transition="' . $media_animation . '"';
			$media_animation = ' esg-transition';

		}
		else {
			$data_transition_media = '';
		}

        //echo '    <!-- THE CONTAINER FOR THE MEDIA AND THE COVER EFFECTS -->'."\n";
        echo '    <div class="esg-media-cover-wrapper' . $cover_wrapper_overflow . '">'."\n";
        //echo '            <!-- THE MEDIA OF THE ENTRY -->'."\n";
		if($demo == 'overview' || $demo == 'skinchoose'){
			echo '            <div class="esg-entry-media'.$media_animation.'"'.$media_animation_delay.$media_animation_duration.$media_blur.$data_transition_media.'><img src="'.EG_PLUGIN_URL.'admin/assets/images/'.$this->cover_image.'" data-no-lazy="1"></div>'."\n\n";
		}else{
			$echo_media = '<div class="esg-entry-media'.$media_animation.'"'.$media_animation_delay.$media_animation_duration.$media_blur.$data_transition_media.'>'.$echo_media.'</div>'."\n\n";
			//echo media from top here
			if($link_set_to == 'media' && $link_type_link !== 'none'){ //set link on whole media
				$echo_media = str_replace('%REPLACE%', $echo_media, $link_wrapper);
			}
			echo $echo_media;
		}

		//add absolute positioned elements here
		$link_inserted = false;

		if($is_iframe == false){ //if we are iFrame, no wrapper and no elements in media should be written
			//echo '            <!-- THE CONTENT OF THE ENTRY -->'."\n";
			if($cover_type == 'full' && $c_layer > 0 || ($t_layer > 0 || $c_layer > 0 || $b_layer > 0)){
				$cover_attr = '';
				if($link_set_to == 'cover' && $link_type_link !== 'none')
					$cover_attr = ' data-clickable="on"';

				echo '            <div class="esg-entry-cover'.$cover_group_animation.'"'.$cover_group_animation_delay.$cover_group_animation_duration.$cover_attr.$data_transition_group.'>'."\n\n";
				//echo '                <!-- THE COLORED OVERLAY -->'."\n";

				if($link_set_to == 'cover' && $link_type_link !== 'none'){
					if(strpos($link_wrapper, 'class="') !== false){
						echo str_replace(array('%REPLACE%', 'class="'), array('', 'class="eg-invisiblebutton '), $link_wrapper);
					}else{
						echo str_replace(array('%REPLACE%', '<a '), array('', '<a class="eg-invisiblebutton" '), $link_wrapper);
					}
					$link_inserted = true;
				}
			}
			if($cover_type == 'full'){
				$echo_c = '                <div class="esg-overlay'.$cover_animation_center.$container_class.$cover_blend_mode.'"'.$cover_animation_delay_center.$cover_animation_duration_center.$meta_cover_style.$data_transition_center.$cover_animation_color_center.'></div>'."\n\n";
				if($link_set_to == 'cover' && $link_type_link !== 'none' && $link_inserted === false){ //set link on whole cover
					$echo_c = str_replace('%REPLACE%', $echo_c, $link_wrapper);
				}
				echo $echo_c;
			}else{
				if($t_layer > 0){
					$echo_t = '                <div class="esg-overlay esg-top'.$cover_animation_top.$container_class.$cover_blend_mode.'"'.$cover_animation_delay_top.$cover_animation_duration_top.$meta_cover_style.$data_transition_top.$cover_animation_color_top.'></div>'."\n\n";
					if($link_set_to == 'cover' && $link_type_link !== 'none' && $link_inserted === false){ //set link on whole cover
						$echo_t = str_replace('%REPLACE%', $echo_t, $link_wrapper);
					}
					echo $echo_t;
				}
				if($c_layer > 0){
					$echo_c = '                <div class="esg-overlay esg-center'.$cover_animation_center.$container_class.$cover_blend_mode.'"'.$cover_animation_delay_center.$cover_animation_duration_center.$meta_cover_style.$data_transition_center.$cover_animation_color_center.'></div>'."\n\n";
					if($link_set_to == 'cover' && $link_type_link !== 'none' && $link_inserted === false){ //set link on whole cover
						$echo_c = str_replace('%REPLACE%', $echo_c, $link_wrapper);
					}
					echo $echo_c;
				}
				if($b_layer > 0){
					$echo_b = '                <div class="esg-overlay esg-bottom'.$cover_animation_bottom.$container_class.$cover_blend_mode.'"'.$cover_animation_delay_bottom.$cover_animation_duration_bottom.$meta_cover_style.$data_transition_bottom.$cover_animation_color_bottom.'></div>'."\n\n";
					if($link_set_to == 'cover' && $link_type_link !== 'none' && $link_inserted === false){ //set link on whole cover
						$echo_b = str_replace('%REPLACE%', $echo_b, $link_wrapper);
					}
					echo $echo_b;
				}
			}

			/*
			<!-- #########################################################################
					THE CLASSES FOR THE ALIGNS OF ANY ELEMENT IS:

					 esg-top, esg-topleft, esg-topright,
					 esg-left, esg-right,  esg-center
					 esg-bottom, esg-bottomleft, esg-bottomright

					 IF YOU HAVE MORE THAN ONE ELEMENT IN THE SAME ALIGNED CONTAINER,
					 THEY WILL BE ADDED UNDER EACH OTHER IN THE SAME ALIGNED CONTAINER
			#########################################################################  -->
			*/

			if(!empty($this->layers)){
				foreach($this->layers as $layer){  //add all but masonry elements
					if(!isset($layer['container']) || $layer['container'] == 'm') continue;
					$link_to = $base->getVar($layer, array('settings', 'link-type'), 'none');
					$hide_on_video = $base->getVar($layer, array('settings', 'hide-on-video'), 'false');

					if($demo === false && $this->layer_values === false){ //show element only if it is on sale or if featured
						if(Essential_Grid_Woocommerce::is_woo_exists()){
							$show_on_sale = $base->getVar($layer, array('settings', 'show-on-sale'), 'false');
							if($show_on_sale == 'true'){
								$sale = Essential_Grid_Woocommerce::check_if_on_sale($this->post['ID']);

								if(!$sale) continue;
							}

							$show_if_featured = $base->getVar($layer, array('settings', 'show-if-featured'), 'false');
							if($show_if_featured == 'true'){
								$featured = Essential_Grid_Woocommerce::check_if_is_featured($this->post['ID']);

								if(!$featured) continue;
							}
						}
					}

					if($link_to != 'embedded_video' && $hide_on_video == 'true' && $is_video == true) continue; //this element is hidden if media is video
					if($link_to != 'embedded_video' && $hide_on_video == 'show' && $is_video == false) continue; //this element is only shown if media is video

					if($demo == 'overview' || $demo == 'skinchoose' || $demo == 'custom'){
						self::insert_layer($layer, $demo, false, $grid_ids, $post_ids);
					}else{
						self::insert_layer($layer, false, false, $grid_ids, $post_ids);
					}
				}

			}

			if($this->load_lightbox === true){
				if(!empty($this->lightbox_additions['items'])){
					$lb_rel = ($this->lb_rel !== false) ? ' data-esgbox="'.esc_attr($this->lb_rel).'"' : '';

					echo '<div style="display: none" class="esgbox-additional">';
					foreach($this->lightbox_additions['items'] as $lb_key => $lb_img){
						if($this->lightbox_additions['base'] == 'on' && $lb_key == 0) continue; //if off, the first one is already written on the handle somewhere
						$thumg_src = (isset($this->lightbox_additions['thumbs'][$lb_key]) && !empty($this->lightbox_additions['thumbs'][$lb_key])) ? $this->lightbox_additions['thumbs'][$lb_key] : EG_PLUGIN_URL .'public/assets/images/300x200transparent.png';
						//echo '<a href="'.esc_attr($lb_img).'" class="esgbox" '.$lb_rel.'><img class="esg-lb-dummy" src="'. $thumg_src .'"></a>';
						echo '<a href="'.esc_attr($lb_img).'" data-thumb="'. str_replace(array(" ","(",")"),array("%20","%28","%29"),$thumg_src) .'" class="esgbox" '.$lb_rel.'><img class="esg-lb-dummy" src="'. $thumg_src .'"></a>';
					}
					echo '</div>';
				}
			}

			if($cover_type == 'full' && $c_layer > 0 || ($t_layer > 0 || $c_layer > 0 || $b_layer > 0)){
				echo '           </div>'."\n"; //<!-- END OF THE CONTENT IN THE ENTRY -->'."\n";
			}
        }

        if($m_layer > 0){
            if($show_content == 'bottom'){
                self::insert_masonry_layer($demo, $meta_content_style, $is_video, $grid_ids, $post_ids);
            }
        }

        echo '   </div>'."\n\n"; //<!-- END OF THE CONTAINER FOR THE MEDIA AND COVER/HOVER EFFECTS -->'."\n\n";

        echo '</li>'."\n"; //<!-- END OF PORTFOLIO ITEM -->'."\n";

    }


    public function get_video_image_type($video_type){
    	$video_image_array = array();
    	$this->default_video_poster_order = is_array($this->default_video_poster_order) ? $this->default_video_poster_order : array();
		$video_image_count = array_search($video_type.'-image',$this->default_video_poster_order);
		$video_default_image_count = array_search('default-'.$video_type.'-image',$this->default_video_poster_order);
		$no_image_count = array_search('no-image',$this->default_video_poster_order);
		$featured_image_count = array_search('featured-image',$this->default_video_poster_order);
		$alternate_image_count = array_search('alternate-image',$this->default_video_poster_order);
		$content_image_count = array_search('content-image',$this->default_video_poster_order);

		if($video_image_count!==false) $video_image_array[$video_image_count] = $video_type.'-image';
		if($video_default_image_count!==false) $video_image_array[$video_default_image_count] = 'default-'.$video_type.'-image';
		if($no_image_count!==false) $video_image_array[$no_image_count] = 'no-image';
		if($featured_image_count!==false) $video_image_array[$featured_image_count] = 'featured-image';
		if($alternate_image_count!==false) $video_image_array[$alternate_image_count] = 'alternate-image';
		if($content_image_count!==false) $video_image_array[$content_image_count] = 'content-image';

		ksort($video_image_array);
		$video_image_array = reset($video_image_array);

		return $video_image_array;
    }

	/**
     * output the add more markup
     */
	public function output_add_more(){
			echo apply_filters('essgrid_output_add_more', '<li class="filterall eg-addnewitem-wrapper ui-state-disabled">
			<div class="esg-media-cover-wrapper">
				<div class="esg-entry-media"><img src="'. EG_PLUGIN_URL .'public/assets/images/300x200transparent.png" data-no-lazy="1"></div>
				<div class="esg-entry-cover">
					<div class="esg-overlay esg-transition eg-addnewitem-container" data-transition="esg-fade" data-delay="0.18"></div>
					<div id="esg-add-new-custom-youtube" class="esg-open-edit-dialog esg-center eg-addnewitem-element-1 esg-transition" data-transition="esg-slideup" data-delay="0"><i class="eg-icon-youtube-squared"></i></div>
					<div class="esg-absolute eg-addnewitem-element-3 esg-transition" data-transition="esg-falldownout" data-delay="0.1"><i class="eg-icon-plus"></i></div>
					<div class="esg-bottom eg-addnewitem-element-2 esg-transition" data-transition="esg-flipup" data-delay="0.1">'. __('CHOOSE YOUR ITEM', EG_TEXTDOMAIN) .'</div>
					<div id="esg-add-new-custom-vimeo" class="esg-open-edit-dialog esg-center eg-addnewitem-element-1 eg-addnewitem-element-space esg-transition" data-transition="esg-slideup" data-delay="0.1"><i class="eg-icon-vimeo-squared"></i></div>
					<div id="esg-add-new-custom-html5" class="esg-open-edit-dialog esg-center eg-addnewitem-element-1 esg-transition" data-transition="esg-slideup" data-delay="0.2" style="visibility: hidden"><i class="eg-icon-video"></i></div>
					<div class="esg-center eg-addnewitem-element-4 esg-none esg-clear" style="height: 5px; visibility: hidden;"></div>
					<div id="esg-add-new-custom-image" class="esg-open-edit-dialog esg-center eg-addnewitem-element-1 esg-transition" data-transition="esg-slideup" data-delay="0.3"><i class="eg-icon-picture-1"></i></div>
					<div id="esg-add-new-custom-soundcloud" class="esg-open-edit-dialog esg-center eg-addnewitem-element-1 eg-addnewitem-element-5 esg-transition" data-transition="esg-slideup" data-delay="0.4"><i class="eg-icon-soundcloud"></i></div>
					<div id="esg-add-new-custom-text" class="esg-open-edit-dialog esg-center eg-addnewitem-element-1 eg-addnewitem-element-6 esg-transition" data-transition="esg-slideup" data-delay="0.5"><i class="eg-icon-font"></i></div>
					<div id="esg-add-new-custom-blank" class="esg-open-edit-dialog esg-center eg-addnewitem-element-1 esg-transition" data-transition="esg-slideup" data-delay="0.6"><i class="eg-icon-cancel"></i></div>
				</div>
			</div>
		</li>');
	}


    /**
     * return all current set filter as array
     */
    public function insert_masonry_layer($demo = false, $style = false, $is_video = false, $grid_ids = '', $post_ids = ''){
        $base = new Essential_Grid_Base();

		$content_class = ' eg-'.esc_attr($this->handle).'-content';

        //$content_background_color = $base->getVar($this->params, 'content-bg-color', '#FFF');
        //echo '<!-- THE CONTENT PART OF THE ENTRIES -->'."\n";
		do_action('essgrid_insert_masonry_layer_pre', $demo, $style, $is_video);

        echo '<div class="esg-entry-content'.$content_class.'"';
		if($style !== false){
			echo apply_filters('essgrid_insert_masonry_layer_style', $style);
		}
		echo '>'."\n";// style="background-color: '.$content_background_color.'"
        if(!empty($this->layers)){
            foreach($this->layers as $layer){
                if(!isset($layer['container']) || $layer['container'] != 'm') continue;
				$link_to = $base->getVar($layer, array('settings', 'link-type'), 'none');
				$hide_on_video = $base->getVar($layer, array('settings', 'hide-on-video'), 'false');

				if($link_to != 'embedded_video' && $hide_on_video == 'true' && $is_video == true) continue; //this element is hidden if media is video
				if($link_to != 'embedded_video' && $hide_on_video == 'show' && $is_video == false) continue; //this element is only shown if media is video

				if($demo === false){ //show element only if it is on sale or if featured
					if(Essential_Grid_Woocommerce::is_woo_exists()){
						$show_on_sale = $base->getVar($layer, array('settings', 'show-on-sale'), 'false');
						if($show_on_sale == 'true'){
							$sale = Essential_Grid_Woocommerce::check_if_on_sale($this->post['ID']);

							if(!$sale) continue;
						}

						$show_if_featured = $base->getVar($layer, array('settings', 'show-if-featured'), 'false');
						if($show_if_featured == 'true'){
							$featured = Essential_Grid_Woocommerce::check_if_is_featured($this->post['ID']);

							if(!$featured) continue;
						}
					}
				}

                if($demo == 'overview' || $demo == 'skinchoose' || $demo == 'custom'){
                    self::insert_layer($layer, $demo, true, $grid_ids, $post_ids);
                }else{
                    self::insert_layer($layer, false, true, $grid_ids, $post_ids);
                }
            }
        }
        echo '</div>';
		do_action('essgrid_insert_masonry_layer_post', $demo, $style, $is_video);
		//echo '<!-- END OF CONTENT PART OF THE ENTRIES -->'."\n";
    }


    /**
     * return all current set filter as array
     */
    public function get_filter_array(){

		return apply_filters('essgrid_get_filter_array', $this->filter);

    }


    /**
     * set all post values for post output
     */
    public function set_post_values($post){

		$this->post = apply_filters('essgrid_set_post_values', $post);

		$this->set_post_meta_values(); //set meta values

    }


    /**
     * set all post values for post output
     */
    public function set_layer_values($values){

        $this->layer_values = apply_filters('essgrid_set_layer_values', $values);

    }


    /**
     * get all post values / layer values at custom grid
	 * @since: 2.1.0
     */
    public function get_layer_values(){

        return apply_filters('essgrid_get_layer_values', $this->layer_values);

    }


    /**
     * set custom post meta values for post output
     */
    public function set_post_meta_values(){

		if(empty($this->post)) return false; //check if we have already a post

		$values = isset($this->post['ID']) ? get_post_custom($this->post['ID']) : false;
		if(!empty($values)) {

			$eg_settings_custom_meta_skin = isset($values['eg_settings_custom_meta_skin']) ? unserialize($values['eg_settings_custom_meta_skin'][0]) : "";
			$eg_settings_custom_meta_element = isset($values['eg_settings_custom_meta_element']) ? unserialize($values['eg_settings_custom_meta_element'][0]) : "";
			$eg_settings_custom_meta_setting = isset($values['eg_settings_custom_meta_setting']) ? unserialize($values['eg_settings_custom_meta_setting'][0]) : "";
			$eg_settings_custom_meta_style = isset($values['eg_settings_custom_meta_style']) ? unserialize($values['eg_settings_custom_meta_style'][0]) : "";

		}
		/* 2.2.6 */
		else {

			$values = $this->post;
			$eg_settings_custom_meta_skin = isset($values['eg_settings_custom_meta_skin']) ? $values['eg_settings_custom_meta_skin'] : "";
			$eg_settings_custom_meta_element = isset($values['eg_settings_custom_meta_element']) ? $values['eg_settings_custom_meta_element'] : "";
			$eg_settings_custom_meta_setting = isset($values['eg_settings_custom_meta_setting']) ? $values['eg_settings_custom_meta_setting'] : "";
			$eg_settings_custom_meta_style = isset($values['eg_settings_custom_meta_style']) ? $values['eg_settings_custom_meta_style'] : "";

		}

		$eg_meta = array();

		if(!empty($eg_settings_custom_meta_skin)){
			foreach($eg_settings_custom_meta_skin as $key => $val){
				$eg_meta[$key]['skin'] = @$val;
				$eg_meta[$key]['element'] = @$eg_settings_custom_meta_element[$key];
				$eg_meta[$key]['setting'] = @$eg_settings_custom_meta_setting[$key];
				$eg_meta[$key]['style'] = @$eg_settings_custom_meta_style[$key];
			}
		}

		unset($values['eg_settings_custom_meta_skin']);
		unset($values['eg_settings_custom_meta_element']);
		unset($values['eg_settings_custom_meta_setting']);
		unset($values['eg_settings_custom_meta_style']);

		$values['eg-meta-style'] = $eg_meta;
		$this->post_meta = apply_filters('essgrid_set_post_meta_values', $values);

    }


	/**
     * check if element has custom information set in post, if yes, return it
     */
	public function set_meta_element_changes($layer_id, $class){

		if(!empty($this->post_meta) && !empty($this->post_meta['eg-meta-style'])){

			//get all allowed meta keys
			$item_ele = new Essential_Grid_Item_Element();
			$metas = $item_ele->get_allowed_meta();

			foreach($this->post_meta['eg-meta-style'] as $entry){
				if($entry['skin'] == $this->id && $entry['element'] == $layer_id){

					$found = false;

					foreach($metas as $meta){
						if($meta['name']['handle'] == $entry['setting']){ //found, check if style, anim or layout, we only need style here
							if($meta['container'] == 'style') $found = true;

							break;
						}
					}

					if($found){ //only add if it is a style
						if(strpos($entry['setting'], '-hover') !== false){ //check if we are hover or not
							$style = 'hover';
							$entry['setting'] = str_replace('-hover', '', $entry['setting']);
						}else{
							$style = 'idle';
						}

						if($entry['setting'] == 'box-shadow'){
							$this->layers_meta_css[$style][$class]['-moz-'.$entry['setting']] = $entry['style'];
							$this->layers_meta_css[$style][$class]['-webkit-'.$entry['setting']] = $entry['style'];
							$this->layers_meta_css[$style][$class][$entry['setting']] = $entry['style'];
						}else{
							$this->layers_meta_css[$style][$class][$entry['setting']] = $entry['style'];
						}
					}
				}
			}
		}

	}


	/**
     * check if layout has custom information set in post, if yes, return it
     */
	public function get_meta_layout_change($setting){

		$found = false;

		if(!empty($this->post_meta) && !empty($this->post_meta['eg-meta-style'])){
			//get all allowed meta keys
			$item_ele = new Essential_Grid_Item_Element();
			$metas = $item_ele->get_allowed_meta();

			foreach($this->post_meta['eg-meta-style'] as $entry){
				if($entry['skin'] == $this->id){

					foreach($metas as $meta){
						if($meta['name']['handle'] == $entry['setting'] && $setting == $entry['setting']){ //found, check if layout
							if($meta['container'] == 'layout'){ //we only want layout here
								$found = $entry['style'];
							}
							break;
						}
					}
				}
			}
		}

		return $found;

	}


	/**
     * check if layout has custom information set in post, if yes, return it
     */
	public function get_meta_element_change($layer_id, $setting){

		$found = false;

		if(!empty($this->post_meta) && !empty($this->post_meta['eg-meta-style'])){
			//get all allowed meta keys
			$item_ele = new Essential_Grid_Item_Element();
			$metas = $item_ele->get_allowed_meta();

			foreach($this->post_meta['eg-meta-style'] as $entry){
				if($entry['skin'] == $this->id && $entry['element'] == $layer_id){

					foreach($metas as $meta){
						if($meta['name']['handle'] == $entry['setting'] && $setting == $entry['setting']){ //found, check if layout
							//if($meta['container'] == 'layout'){ //we only want layout here
								$found = $entry['style'];
							//}
							break;
						}
					}
				}
			}
		}

		return $found;

	}


	public function get_media_attributes($order){
		$base = new Essential_Grid_Base();

		$img_dim = '';

		$img_settings = array(
			'image-fit' => $base->getVar($this->params, 'image-fit', 'cover'),
			'image-repeat' => $base->getVar($this->params, 'image-repeat', 'no-repeat'),
			'image-align-horizontal' => $base->getVar($this->params, 'image-align-horizontal', 'center'),
			'image-align-vertical' => $base->getVar($this->params, 'image-align-vertical', 'center')
		);

		if($order !== false){
			if(isset($this->media_sources[$order.'-width']) && intval($this->media_sources[$order.'-width']) > 0 && isset($this->media_sources[$order.'-height']) && intval($this->media_sources[$order.'-height']) > 0){
				$img_dim = ' width="'.$this->media_sources[$order.'-width'].'" height="'.$this->media_sources[$order.'-height'].'"';
			}
		}else{
			$img_dim = (!empty($this->default_image_attr) && isset($this->default_image_attr[0]) && isset($this->default_image_attr[1])) ? ' width="'.$this->default_image_attr[0].'" height="'.$this->default_image_attr[1].'"' : '';
		}
		if(isset($this->media_sources['image-fit']) && $this->media_sources['image-fit'] !== '' && $this->media_sources['image-fit'] !== $img_settings['image-fit']){
			$img_dim .= ' data-bgsize="'.esc_attr($this->media_sources['image-fit']).'"';
		}

		if(isset($this->media_sources['image-repeat']) && $this->media_sources['image-repeat'] !== '' && $this->media_sources['image-repeat'] !== $img_settings['image-repeat']){
			$img_dim .= ' data-bgrepeat="'.esc_attr($this->media_sources['image-repeat']).'"';
		}

		$img_hor = (isset($this->media_sources['image-align-horizontal']) &&
					$this->media_sources['image-align-horizontal'] !== '' &&
					$this->media_sources['image-align-horizontal'] !== $img_settings['image-align-horizontal']
					) ? $this->media_sources['image-align-horizontal'] : '';
		$img_ver = (isset($this->media_sources['image-align-vertical']) &&
					$this->media_sources['image-align-vertical'] !== '' &&
					$this->media_sources['image-align-vertical'] !== $img_settings['image-align-vertical']
					) ? $this->media_sources['image-align-vertical'] : '';

		if($img_hor !== '' || $img_ver !== ''){
			if($img_hor == '') $img_hor = $img_settings['image-align-horizontal'];
			if($img_ver == '') $img_ver = $img_settings['image-align-vertical'];

			$img_dim .= ' data-bgposition="'.$img_hor.' '.$img_ver.'"';
		}

		return $img_dim;
    }

    /**
     * check if element is absolute positioned
     */
    public function is_absolute_position($ele_class){

		if(!empty($this->layers_css[$this->id]['idle'])){
            foreach($this->layers_css[$this->id]['idle'] as $class => $settings){
				if($class == $ele_class){
					if(!empty($settings)){
						foreach($settings as $style => $value){
							if($style == 'position'){
								if($value == 'absolute'){
									return true;
								}
								return false;
							}
						}
					}
					return false;
				}
            }
        }

		return false;
	}


	/**
     * clean styles that are not needed
	 * @since: 1.5.4
     */
	public function clean_up_styles($styles){
		if(isset($styles['display'])){
			if($styles['display'] == 'block'){
				if(isset($styles['float'])) unset($styles['float']);
			}
			if($styles['display'] == 'inline-block'){
				if(isset($styles['text-align'])) unset($styles['text-align']);
			}
		}
		return $styles;
	}


    /**
     * return all styles from all elements
     */
    public function generate_element_css($demo = false){
		$base = new Essential_Grid_Base();

		$allowed_wrap_styles = Essential_Grid_Item_Element::get_allowed_styles_for_wrap();
		$wait_for_styles = Essential_Grid_Item_Element::get_wait_until_output_styles();

		//echo '<!-- ESSENTIAL GRID SKIN CSS -->'."\n";

		if(!empty($this->layers_css)){
			foreach($this->layers_css as $layers_css){
				if(!empty($layers_css['idle'])){
					echo '<style type="text/css">';
					$css = '';
					foreach($layers_css['idle'] as $class => $settings){

						$wait = array();
						$forbidden = array();

						if(!empty($this->add_css_wrap) && isset($this->add_css_wrap[$class])) $forbidden = $allowed_wrap_styles; //write hover only if no tag inside the text exists

						$d_i = $layers_css['settings'][$class]['important']; //add important or not
						$position_found = false;

						if(!empty($settings)){
							$settings = $this->clean_up_styles($settings);
							$css .= '.'.$class.' {'."\n";
							foreach($settings as $style => $value){
								$jump_next = false;
								foreach($wait_for_styles as $k => $wf){ //check if we wait until end to write style, depending on what setting the other styles have
									if(in_array($style, $wf['wait'])){
										$wait[$k][] = array($style, $value);
										$jump_next = true;
									}
								}
								if($jump_next) continue;

								if(!in_array($style, $forbidden))
									$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";

								if($style == 'position') $position_found = true;
							}
							if(!$position_found) $css .= '	position: relative;'."\n";
							$css .= '	z-index: 2 !important;'."\n";

							if(!empty($this->add_css_wrap) && isset($this->add_css_wrap[$class]) && isset($this->add_css_wrap[$class]['a']) && $this->add_css_wrap[$class]['a']['display'] == true){
								$css .= '	display: block;'."\n";
							}
							if(!empty($wait)){
								foreach($wait as $wait_for => $wait_styles){
									if(isset($settings[$wait_for])){
										if(is_array($wait_for_styles[$wait_for]['not-if'])){
											$do_continue = false;
											foreach($wait_for_styles[$wait_for]['not-if'] as $wf){
												if(strpos($settings[$wait_for], $wf) !== false){
													$do_continue = true;
													break;
												}
											}

											if($do_continue) continue;
										}else{
											if($settings[$wait_for] === $wait_for_styles[$wait_for]['not-if']) continue;
										}

										foreach($wait_styles as $ww){
											if(!in_array($ww[0], $forbidden))
												$css .= '	'.$ww[0].': '.stripslashes($ww[1]).$d_i.';'."\n";
										}
									}
								}
							}

							$css .= '}'."\n";
						}
					}
					echo $base->compress_css($css);
					echo '</style>'."\n";
				}


				if(!empty($layers_css['hover'])){
					echo '<style type="text/css">';
					$css = '';
					foreach($layers_css['hover'] as $class => $settings){
						if(!empty($this->add_css_tags) && isset($this->add_css_tags[$class])) continue; //write hover only if no tag inside the text exists

						$wait = array();

						$d_i = $layers_css['settings'][$class]['important']; //add important or not

						if(!empty($settings)){
							$settings = $this->clean_up_styles($settings);
							$css .= '.'.$class.':hover {'."\n";
							foreach($settings as $style => $value){
								$jump_next = false;
								foreach($wait_for_styles as $k => $wf){ //check if we wait until end to write style, depending on what setting the other styles have
									if(in_array($style, $wf['wait'])){
										$wait[$k][] = array($style, $value);
										$jump_next = true;
									}
								}
								if($jump_next) continue;

								$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";
							}

							if(!empty($wait)){
								foreach($wait as $wait_for => $wait_styles){
									if(isset($settings[$wait_for]) && $settings[$wait_for] !== $wait_for_styles[$wait_for]['not-if']){
										if(is_array($wait_for_styles[$wait_for]['not-if'])){
											$do_continue = false;
											foreach($wait_for_styles[$wait_for]['not-if'] as $wf){
												if(strpos($settings[$wait_for], $wf) !== false){
													$do_continue = true;
													break;
												}
											}
											if($do_continue) continue;
										}else{
											if($settings[$wait_for] === $wait_for_styles[$wait_for]['not-if']) continue;
										}

										foreach($wait_styles as $ww){
											$css .= '	'.$ww[0].': '.stripslashes($ww[1]).$d_i.';'."\n";
										}
									}
								}
							}

							$css .= '}'."\n";
						}
					}
					echo $base->compress_css($css);
					echo '</style>'."\n";
				}

				//check for custom css on tags
				if(!empty($this->add_css_tags)){
					$allowed_styles = Essential_Grid_Item_Element::get_allowed_styles_for_tags();
					foreach($this->add_css_tags as $class => $tags){
						if(!empty($layers_css['idle'][$class])){ // we write the idle styles

							$d_i = $layers_css['settings'][$class]['important']; //add important or not

							foreach($tags as $tag => $do){
								echo '<style type="text/css">';
								$css = '';
								$css .= '.'.$class.' '.$tag.' {'."\n";

								$layers_css['idle'][$class] = $this->clean_up_styles($layers_css['idle'][$class]);

								foreach($layers_css['idle'][$class] as $style => $value){
									if(in_array($style, $allowed_styles))
										$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";
								}

								$css .= '}'."\n";
								echo $base->compress_css($css);
								echo '</style>'."\n";
							}
						}

						if(!empty($layers_css['hover'][$class])){ // we write the hover styles

							$d_i = $layers_css['settings'][$class]['important']; //add important or not

							foreach($tags as $tag => $do){
								echo '<style type="text/css">';
								$css = '';
								$css .= '.'.$class.' '.$tag.':hover {'."\n";

								$layers_css['hover'][$class] = $this->clean_up_styles($layers_css['hover'][$class]);

								foreach($layers_css['hover'][$class] as $style => $value){
									if(in_array($style, $allowed_styles))
										$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";
								}

								$css .= '}'."\n";
								echo $base->compress_css($css);
								echo '</style>'."\n";
							}
						}
					}
				}



				//check for custom css on wrappers for example
				if(!empty($this->add_css_wrap)){
					$allowed_cat_tag_styles = Essential_Grid_Item_Element::get_allowed_styles_for_cat_tag();
					foreach($this->add_css_wrap as $class => $tags){
						if(!empty($layers_css['idle'][$class])){ // we write the idle styles

							$d_i = $layers_css['settings'][$class]['important']; //add important or not

							foreach($tags as $tag => $do){
								echo '<style type="text/css">';
								$css = '';
								$css .= '.'.$class.'-'.$tag.' {'."\n";

								$position_found = false;

								if(!empty($this->add_css_wrap) && isset($this->add_css_wrap[$class]) && isset($this->add_css_wrap[$class]['a']) && $this->add_css_wrap[$class]['a']['full'] == true){ // set more styles (used for cat & tag list)
									$allowed_styles = array_merge($allowed_cat_tag_styles, $allowed_wrap_styles);
								}else{
									$allowed_styles = $allowed_wrap_styles;
								}

								$layers_css['idle'][$class] = $this->clean_up_styles($layers_css['idle'][$class]);

								foreach($layers_css['idle'][$class] as $style => $value){
									if(in_array($style, $allowed_styles)){
										$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";
										if($style == 'position') $position_found = true;
									}
								}

								if(!$position_found) $css .= '	position: relative;'."\n";

								$css .= '}'."\n";
								echo $base->compress_css($css);
								echo '</style>'."\n";
							}
						}

					}
				}
			}
		}

		if(!empty($this->media_css)){
			foreach($this->media_css as $skin_id => $media_css){
				if(!empty($media_css)){
					echo '<style type="text/css">';
					$css = '';
					$handle = $this->loaded_skins[$skin_id]['handle'];
					$css .= '.eg-'.esc_attr($handle).'-wrapper .esg-entry-media-wrapper {'."\n";

					$media_css = $this->clean_up_styles($media_css);

					foreach($media_css as $style => $value){
						$css .= '	'.$style.': '.stripslashes($value).';'."\n"; // !important;
					}
					$css .= '}'."\n";

					/* 2.2.6 */
					if(isset($this->media_shadow[$skin_id])) {

						$cover_duration = $base->getVar($this->params, 'cover-animation-duration-center', 300);
						if($cover_duration === 'default') $cover_duration = 300;

						$cover_delay = $base->getVar($this->params, 'cover-animation-delay-center', '0');
						$cover_duration = intval($cover_duration) * 0.001;
						$cover_delay = floatval($cover_delay);

						if(!$cover_delay) {
							$cover_delay = '';
						}
						else {
							$cover_delay = $cover_delay * 0.01;
							$cover_delay = (string)$cover_delay . 's';
						}

						$css .= '.eg-'.esc_attr($handle).'-wrapper .esg-entry-media-wrapper {'."\n";
						$css .= '	transition: box-shadow ' . $cover_duration . 's ease-out ' . $cover_delay . ';';
						$css .= '}'."\n";
						$css .= '.eg-'.esc_attr($handle).'-wrapper.esg-hovered .esg-entry-media-wrapper {'."\n";
						$css .= '	box-shadow: ' . $this->media_shadow[$skin_id] . ';'."\n";
						$css .= '}'."\n";

					}

					echo $base->compress_css($css);
					echo '</style>'."\n";
				}
			}
		}

		if(!empty($this->cover_css)){
			foreach($this->cover_css as $skin_id => $cover_css){
				if(!empty($cover_css)){
					echo '<style type="text/css">';
					$css = '';
					$handle = $this->loaded_skins[$skin_id]['handle'];
					$css .= '.eg-'.esc_attr($handle).'-container {'."\n";

					$cover_css = $this->clean_up_styles($cover_css);

					foreach($cover_css as $style => $value){
						$css .= '	'.$style.': '.stripslashes($value).';'."\n"; // !important;
					}
					$css .= '}'."\n";

					/* 2.2.6 */
					if(isset($this->cover_shadow[$skin_id])) {

						$cover_duration = $base->getVar($this->params, 'cover-animation-duration-center', 300);
						if($cover_duration === 'default') $cover_duration = 300;

						$cover_delay = $base->getVar($this->params, 'cover-animation-delay-center', '0');
						$cover_duration = intval($cover_duration) * 0.001;
						$cover_delay = floatval($cover_delay);

						if(!$cover_delay) {
							$cover_delay = '';
						}
						else {
							$cover_delay = $cover_delay * 0.01;
							$cover_delay = (string)$cover_delay . 's';
						}

						$css .= '.eg-'.esc_attr($handle).'-container {'."\n";
						$css .= '	transition: box-shadow ' . $cover_duration . 's ease-out ' . $cover_delay . ';';
						$css .= '}'."\n";
						$css .= '.esg-hovered .eg-'.esc_attr($handle).'-container {'."\n";
						$css .= '	box-shadow: ' . $this->cover_shadow[$skin_id] . ';'."\n";
						$css .= '}'."\n";

					}

					echo $base->compress_css($css);
					echo '</style>'."\n";
				}
			}
		}

		if(!empty($this->content_css)){
			foreach($this->content_css as $skin_id => $content_css){
				if(!empty($content_css)){
					echo '<style type="text/css">';
					$css = '';
					$handle = $this->loaded_skins[$skin_id]['handle'];
					$css .= '.eg-'.esc_attr($handle).'-content {'."\n";

					$content_css = $this->clean_up_styles($content_css);

					foreach($content_css as $style => $value){
						$css .= '	'.$style.': '.stripslashes($value).';'."\n"; // !important
					}
					$css .= '}'."\n";

					/* 2.2.6 */
					if(isset($this->content_shadow[$skin_id])) {

						$cover_duration = $base->getVar($this->params, 'cover-animation-duration-center', 300);
						if($cover_duration === 'default') $cover_duration = 300;

						$cover_delay = $base->getVar($this->params, 'cover-animation-delay-center', '0');
						$cover_duration = intval($cover_duration) * 0.001;
						$cover_delay = floatval($cover_delay);

						if(!$cover_delay) {
							$cover_delay = '';
						}
						else {
							$cover_delay = $cover_delay * 0.01;
							$cover_delay = (string)$cover_delay . 's';
						}

						$css .= '.eg-'.esc_attr($handle).'-content {'."\n";
						$css .= '	transition: box-shadow ' . $cover_duration . 's ease-out ' . $cover_delay . ';';
						$css .= '}'."\n";
						$css .= '.esg-hovered .eg-'.esc_attr($handle).'-content{'."\n";
						$css .= '	box-shadow: ' . $this->content_shadow[$skin_id] . ';'."\n";
						$css .= '}'."\n";

					}

					echo $base->compress_css($css);
					echo '</style>'."\n";
				}
			}
		}

		if(!empty($this->wrapper_css)){
			foreach($this->wrapper_css as $skin_id => $wrapper_css){
				if(!empty($wrapper_css)){
					echo '<style type="text/css">';
					$css = '';
					$handle = $this->loaded_skins[$skin_id]['handle'];
					$css .= '.esg-grid .mainul li.eg-'.esc_attr($handle).'-wrapper {'."\n";

					$wrapper_css = $this->clean_up_styles($wrapper_css);

					foreach($wrapper_css as $style => $value){
						$css .= '	'.$style.': '.stripslashes($value).';'."\n"; // !important
						if($style == 'overflow'){
							$css .= '-webkit-mask-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAA5JREFUeNpiYGBgAAgwAAAEAAGbA+oJAAAAAElFTkSuQmCC) !important;'."\n";
						}
					}
					$css .= '}'."\n";

					/* 2.2.6 */
					if(isset($this->wrapper_shadow[$skin_id])) {

						$cover_duration = $base->getVar($this->params, 'cover-animation-duration-center', 300);
						if($cover_duration === 'default') $cover_duration = 300;

						$cover_delay = $base->getVar($this->params, 'cover-animation-delay-center', '0');
						$cover_duration = intval($cover_duration) * 0.001;
						$cover_delay = floatval($cover_delay);

						if(!$cover_delay) {
							$cover_delay = '';
						}
						else {
							$cover_delay = $cover_delay * 0.01;
							$cover_delay = (string)$cover_delay . 's';
						}

						$css .= '.eg-'.esc_attr($handle).'-wrapper {'."\n";
						$css .= '	transition: box-shadow ' . $cover_duration . 's ease-out ' . $cover_delay . ';';
						$css .= '}'."\n";
						$css .= '.eg-'.esc_attr($handle).'-wrapper.esg-hovered {'."\n";
						$css .= '	box-shadow: ' . $this->wrapper_shadow[$skin_id] . ' !important;'."\n";
						$css .= '}'."\n";

					}

					echo $base->compress_css($css);
					echo '</style>'."\n";
				}
			}
		}

		if(!empty($this->media_poster_css)){
			foreach($this->media_poster_css as $skin_id => $media_poster_css){
				if(!empty($media_poster_css)){
					echo '<style type="text/css">';
					$css = '';
					$handle = $this->loaded_skins[$skin_id]['handle'];
					$css .= '.esg-grid .mainul li.eg-'.esc_attr($handle).'-wrapper .esg-media-poster {'."\n";

					$media_poster_css = $this->clean_up_styles($media_poster_css);

					foreach($media_poster_css as $style => $value){
						$css .= '	'.$style.': '.stripslashes($value).';'."\n"; // !important
					}
					$css .= '}'."\n";
					echo $base->compress_css($css);
					echo '</style>'."\n";
				}
			}
		}

		//echo '<!-- ESSENTIAL GRID END SKIN CSS -->'."\n\n";

		//check if post has custom settings for all elements
		//if($demo == false)
		//	$this->output_element_css_by_meta();
    }


	public function output_element_css_by_meta($id = false, $grid_preview = false){

		$base = new Essential_Grid_Base();

		$disallowed = array('transition', 'transition-delay');

		$allowed_wrap_styles = Essential_Grid_Item_Element::get_allowed_styles_for_wrap();

		$p_class = ($id === false) ? '' : '.eg-post-' . $id;

		if(!empty($this->layers_meta_css['idle'])){
			echo '<style type="text/css">';
			$css = '';
            foreach($this->layers_meta_css['idle'] as $class => $settings){

				$forbidden = array();

				if(!empty($this->add_css_wrap) && isset($this->add_css_wrap[$class])) $forbidden = $allowed_wrap_styles; //write hover only if no tag inside the text exists

				$d_i = $this->layers_css[$this->id]['settings'][$class]['important']; //add important or not

                if(!empty($settings)){

					// 2.2.6
					if(!empty($grid_preview) && !empty($this->grid_id)) $css .= '[id^="esg-grid-' . $this->grid_id . '"] ';

                    $css .= '.'.$class.$p_class.' {'."\n";
                    foreach($settings as $style => $value){
						if(!in_array($style, $forbidden) && !in_array($style, $disallowed))
							$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";
                    }
                    $css .= '}'."\n";
                }
            }
			echo $base->compress_css($css);
			echo '</style>'."\n";
        }

        if(!empty($this->layers_meta_css['hover'])){
			echo '<style type="text/css">';
			$css = '';
            foreach($this->layers_meta_css['hover'] as $class => $settings){

				if(!empty($this->add_css_tags) && isset($this->add_css_tags[$class])) continue; //write hover only if no tag inside the text exists

				$d_i = $this->layers_css[$this->id]['settings'][$class]['important']; //add important or not

                if(!empty($settings)){
                    $css .= '.'.$class.$p_class.':hover {'."\n";
                    foreach($settings as $style => $value){
						$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";
                    }
                    $css .= '}'."\n";
                }
            }
			echo $base->compress_css($css);
			echo '</style>'."\n";
        }

		//check for custom css on tags
		if(!empty($this->add_css_tags)){
			$allowed_styles = Essential_Grid_Item_Element::get_allowed_styles_for_tags();
			foreach($this->add_css_tags as $class => $tags){
				if(!empty($this->layers_meta_css['idle'][$class])){ // we write the idle styles

					$d_i = $this->layers_css[$this->id]['settings'][$class]['important']; //add important or not

					foreach($tags as $tag => $do){
						echo '<style type="text/css">';
						$css = '';
						$css .= '.'.$class.$p_class.' '.$tag.' {'."\n";

						foreach($this->layers_meta_css['idle'][$class] as $style => $value){
							if(in_array($style, $allowed_styles))
								$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";
						}

						$css .= '}'."\n";
						echo $base->compress_css($css);
						echo '</style>'."\n";
					}
				}

				if(!empty($this->layers_meta_css['hover'][$class])){ // we write the hover styles

					$d_i = $this->layers_css[$this->id]['settings'][$class]['important']; //add important or not

					foreach($tags as $tag => $do){
						echo '<style type="text/css">';
						$css = '';
						$css .= '.'.$class.$p_class.' '.$tag.':hover {'."\n";

						foreach($this->layers_meta_css['hover'][$class] as $style => $value){
							if(in_array($style, $allowed_styles))
								$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";
						}

						$css .= '}'."\n";
						echo $base->compress_css($css);
						echo '</style>'."\n";
					}
				}
			}
		}

		//check for custom css on wrappers for example
		if(!empty($this->add_css_wrap)){
			$allowed_cat_tag_styles = Essential_Grid_Item_Element::get_allowed_styles_for_cat_tag();
			foreach($this->add_css_wrap as $class => $tags){
				if(!empty($this->layers_meta_css['idle'][$class])){ // we write the idle styles

					$d_i = $this->layers_css[$this->id]['settings'][$class]['important']; //add important or not

					foreach($tags as $tag => $do){
						echo '<style type="text/css">'."\n";
						$css = '';
						$css .= '.'.$class.'-'.$tag.$p_class.' {'."\n";

						if(!empty($this->add_css_wrap) && isset($this->add_css_wrap[$class]) && isset($this->add_css_wrap[$class]['a']) && $this->add_css_wrap[$class]['a']['full'] == true){ // set more styles (used for cat & tag list)
							$allowed_styles = array_merge($allowed_cat_tag_styles, $allowed_wrap_styles);
						}else{
							$allowed_styles = $allowed_wrap_styles;
						}

						foreach($this->layers_meta_css['idle'][$class] as $style => $value){
							if(in_array($style, $allowed_styles)){
								$css .= '	'.$style.': '.stripslashes($value).$d_i.';'."\n";
							}
						}

						$css .= '}'."\n";
						echo $base->compress_css($css);
						echo '</style>'."\n";
					}
				}

			}
		}

		$this->layers_meta_css = array();

	}

	/**
     * parse the custom css field
     */
	/*public function parse_custom_css($css){
		$start = strpos($css, '{');
		$end = strpos($css, '}');
		if($start === false) return '';
		if($end === false) return '';

		$start += 1;

		echo substr($css, $start, $end - $start);

	}*/

	/**
     * register skin css styles, added for multiskin in one grid + load more
	 * @since: 2.0
     */
    public function register_skin_css(){
		$base = new Essential_Grid_Base();

		/* 2.1.6 */
		$container_background_color = $base->getVar($this->params, 'container-background-color', '#000');
		$contentBgColor = $base->getVar($this->params, 'content-bg-color', '#FFF');
		$fullBgColor = $base->getVar($this->params, 'full-bg-color', '#FFF');
		if(class_exists('ESGColorpicker')) {

			$container_background_color = ESGColorpicker::get($container_background_color);
			$contentBgColor = ESGColorpicker::get($contentBgColor);
			$fullBgColor = ESGColorpicker::get($fullBgColor);

		}

        // $container_background_color_transparency = $base->getVar($this->params, 'element-container-background-color-opacity', '1');
        // $this->cover_css[$this->id]['background-color'] = Essential_Grid_Base::hex2rgba($container_background_color, $container_background_color_transparency); // we only need rgba in backend
		$this->cover_css[$this->id]['background'] = $container_background_color;

		$cover_background_image_id = $base->getVar($this->params, 'cover-background-image', 0, 'i');
		$cover_background_image_size = $base->getVar($this->params, 'cover-background-size', 'cover');
		$cover_background_image_repeat = $base->getVar($this->params, 'cover-background-repeat', 'no-repeat');

		$cover_background_image_url = false;
		if($cover_background_image_id > 0){
			$cover_background_image_url = wp_get_attachment_image_src($cover_background_image_id, $this->media_sources_type);
			if($cover_background_image_url !== false){
				$this->cover_css[$this->id]['background-image'] = 'url('.$cover_background_image_url[0].')';
				$this->cover_css[$this->id]['background-size'] = $cover_background_image_size;
				$this->cover_css[$this->id]['background-repeat'] = $cover_background_image_repeat;
			}
		}

		$this->wrapper_css[$this->id]['background'] = $fullBgColor;
		$this->wrapper_css[$this->id]['padding'] = implode('px ', $base->getVar($this->params, 'full-padding', array('0'))).'px';
		$this->wrapper_css[$this->id]['border-width'] = implode('px ', $base->getVar($this->params, 'full-border', array('0'))).'px';

		$border_type = $base->getVar($this->params, 'full-border-radius-type', 'px');
		$this->wrapper_css[$this->id]['border-radius'] = implode($border_type . ' ', $base->getVar($this->params, 'full-border-radius', array('0'))) . $border_type;

		$this->wrapper_css[$this->id]['border-color'] = $base->getVar($this->params, 'full-border-color', '#FFF');
		$this->wrapper_css[$this->id]['border-style'] = $base->getVar($this->params, 'full-border-style', 'none');
		$overflow = $base->getVar($this->params, 'full-overflow-hidden', 'false');
		if($overflow == 'true') $this->wrapper_css[$this->id]['overflow'] = 'hidden';

		$this->media_poster_css[$this->id]['background-size'] = $base->getVar($this->params, 'image-fit', 'cover');
		$this->media_poster_css[$this->id]['background-position'] = $base->getVar($this->params, 'image-align-vertical', 'center') . ' ' . $base->getVar($this->params, 'image-align-horizontal', 'center');
		$this->media_poster_css[$this->id]['background-repeat'] = $base->getVar($this->params, 'image-repeat', 'no-repeat');

		$this->content_css[$this->id]['background'] = $contentBgColor;
		$this->content_css[$this->id]['padding'] = implode('px ', $base->getVar($this->params, 'content-padding', array('0'))).'px';
		$this->content_css[$this->id]['border-width'] = implode('px ', $base->getVar($this->params, 'content-border', array('0'))).'px';

		$border_type = $base->getVar($this->params, 'content-border-radius-type', 'px');
		$this->content_css[$this->id]['border-radius'] = implode($border_type . ' ', $base->getVar($this->params, 'content-border-radius', array('0'))) . $border_type;

		$this->content_css[$this->id]['border-color'] = $base->getVar($this->params, 'content-border-color', '#FFF');
		$this->content_css[$this->id]['border-style'] = $base->getVar($this->params, 'content-border-style', 'none');
		$this->content_css[$this->id]['text-align'] = $base->getVar($this->params, 'content-align', 'left');

		$shadow_place = $base->getVar($this->params, 'all-shadow-used', 'none');
		$shadow_values = implode('px ', $base->getVar($this->params, 'content-box-shadow', array('0','0','0','0'))).'px';

		/* 2.1.6 */
		$shadow_rgba = $base->getVar($this->params, 'content-shadow-color', '#000000');
		// $shadow_alpha = $base->getVar($this->params, 'content-shadow-alpha', '100');
		// $shadow_rgba = Essential_Grid_Base::hex2rgba($shadow_color, $shadow_alpha);

		/* 2.2.6 */
		$shadow_anim = $base->getVar($this->params, 'content-box-shadow-hover', 'false') == 'true';
		$inset = $base->getVar($this->params, 'content-box-shadow-inset', 'false') == 'true' ? 'inset ' : '';

		if($shadow_place == 'media'){

			if(!$shadow_anim) {
				$this->media_css[$this->id]['box-shadow'] = $inset . $shadow_values.' '.$shadow_rgba;
			}
			else {
				$this->media_css[$this->id]['box-shadow'] = 'none';
				$this->media_shadow[$this->id] = $inset . $shadow_values.' '.$shadow_rgba;
			}

		}
		else if($shadow_place == 'content'){

			if(!$shadow_anim) {
				$this->content_css[$this->id]['box-shadow'] = $inset . $shadow_values.' '.$shadow_rgba;
			}
			else {
				$this->content_css[$this->id]['box-shadow'] = 'none';
				$this->content_shadow[$this->id] = $inset . $shadow_values.' '.$shadow_rgba;
			}

		}
		else if($shadow_place == 'both'){

			if(!$shadow_anim) {
				$this->wrapper_css[$this->id]['box-shadow'] = $inset . $shadow_values.' '.$shadow_rgba;
			}
			else {
				$this->wrapper_css[$this->id]['box-shadow'] = 'none';
				$this->wrapper_shadow[$this->id] = $inset . $shadow_values.' '.$shadow_rgba;
			}

		}
		else if($shadow_place == 'cover'){

			/* 2.2.6 */
			$cover_direction = $base->getVar($this->params, 'cover-animation-center-type', '');
			$cover_type = $base->getVar($this->params, 'cover-type', 'full');

			if($cover_type === 'content') $shadow_anim = false;
			if(!$shadow_anim || $cover_direction === 'out') {
				$this->cover_css[$this->id]['box-shadow'] = 'inset '.$shadow_values.' '.$shadow_rgba;
			}
			if($shadow_anim) {
				if($cover_direction !== 'out') {
					$this->cover_css[$this->id]['box-shadow'] = 'none';
					$this->cover_shadow[$this->id] = 'inset '.$shadow_values.' '.$shadow_rgba;
				}
				else {
					$this->cover_shadow[$this->id] = 'none';
				}
			}

		}

	}


	/**
     * register layer css styles, added for multiskin in one grid + load more
	 * @since: 2.0
     */
	public function register_layer_css($layer = false, $demo = false){

		$base = new Essential_Grid_Base();
		if($layer === false){
			if(!empty($this->layers)){
				foreach($this->layers as $layer){
					$this->register_layer_css($layer, $demo);
				}
			}
		}else{
			$is_post = (!empty($this->layer_values)) ? false : true;

			if(isset($layer['id'])) $unique_class = 'eg-'.esc_attr($this->handle).'-element-'.$layer['id'];
			else $unique_class = "";

			$special_item = $base->getVar($layer, array('settings', 'special'), 'false');
			if($special_item != 'true'){
				$this->add_element_css(@$layer['settings'], $unique_class); //add css to queue
			}

			/**
			 * not that elegant since code already existed and is now split but currently there is no better implementation than this
			 * $text is now parsed two times for each layer because of this to get if there is an a tag in the text -> settings display styles correctly...
			 * NOTE: most of the if(isset($layer['settings']['source'])){} could be removed if it is sure, that there can not be ANY <a> tag in it. Then it can just be replaced with a placeholdertext
			 */
			$m = new Essential_Grid_Meta();
			$text = '';

			$do_limit = true;
			$do_display = true;
			$do_full = false;
			$do_ignore_styles = false;

			if(isset($layer['settings']['source'])){
				$separator = $base->getVar($layer, array('settings', 'source-separate'), ',');
				$catmax = $base->getVar($layer, array('settings', 'source-catmax'), '-1');
				$meta = $base->getVar($layer, array('settings', 'source-meta'), '');
				$func = $base->getVar($layer, array('settings', 'source-function'), 'link');
				$taxonomy = $base->getVar($layer, array('settings', 'source-taxonomy'), '');

				switch($layer['settings']['source']){
					case 'post':

						if($demo === false){
							if($is_post)
								$text = $this->get_post_value($layer['settings']['source-post'], $separator, $func, $meta, $catmax,$taxonomy);
							else
								$text = $this->get_custom_element_value($layer['settings']['source-post'], $separator, $meta);
						}elseif($demo === 'custom'){
							$text = $this->get_custom_element_value($layer['settings']['source-post'], $separator, $meta);
						}else{
							$post_text = Essential_Grid_Item_Element::getPostElementsArray();
							if(array_key_exists(@$layer['settings']['source-post'], $post_text)) $text = $post_text[@$layer['settings']['source-post']]['name'];

							if($layer['settings']['source-post'] == 'date'){
								$da = get_option('date_format');
								if($da !== false)
									$text = date(get_option('date_format'));
								else
									$text = date('Y.m.d');
							}
						}

						if($layer['settings']['source-post'] == 'cat_list' || $layer['settings']['source-post'] == 'tag_list'){ //no limiting if category or tag list
							$do_limit = true;
							$do_display = false;
							$do_full = true;
						}

						$post_id = (isset($this->post) && isset($this->post['ID'])) ? $this->post['ID'] : '';

						$text = apply_filters('essgrid_post_meta_content', $text, $layer['settings']['source-post'], $post_id, $this->post);
					break;
					case 'woocommerce':
						if(Essential_Grid_Woocommerce::is_woo_exists()){
							if($demo === false){
								if($is_post)
									$text = $this->get_woocommerce_value($layer['settings']['source-woocommerce'], $separator, $catmax);
								else
									$text = $this->get_custom_element_value($layer['settings']['source-woocommerce'], $separator, '');

								if($layer['settings']['source-woocommerce'] == 'wc_categories'){
									$do_limit = false;
									$do_display = false;
									$do_full = true;
								}elseif($layer['settings']['source-woocommerce'] == 'wc_add_to_cart_button'){
									$do_limit = false;
								}
							}elseif($demo === 'custom'){
								$text = $this->get_custom_element_value($layer['settings']['source-woocommerce'], $separator, '');

								if($layer['settings']['source-woocommerce'] == 'wc_categories'){
									$do_limit = false;
									$do_display = false;
									$do_full = true;
								}elseif($layer['settings']['source-woocommerce'] == 'wc_add_to_cart_button'){
									$do_limit = false;
								}
							}else{
								$tmp_wc = Essential_Grid_Woocommerce::get_meta_array();

								foreach($tmp_wc as $handle => $name){
									$woocommerce[$handle]['name'] = $name;
								}

								if(array_key_exists(@$layer['settings']['source-woocommerce'], $woocommerce)) $text = $woocommerce[@$layer['settings']['source-woocommerce']]['name'];
							}
						}
					break;
					case 'icon':
						$text = '<i class="'.@$layer['settings']['source-icon'].'"></i>';
					break;
					case 'text':
						$text = @$layer['settings']['source-text'];

						if($demo === false){
							//check for metas by %meta%
							if($is_post){
								if(isset($this->post['ID']))
									$text = $m->replace_all_meta_in_text(@$this->post['ID'], $text);
							}else{
								$_a = (!empty($this->layer_values)) ? $this->layer_values : array();
								$_b = (!empty($this->media_sources)) ? $this->media_sources : array();
								$_values = array_merge($_a, $_b);
								$text = $m->replace_all_custom_element_meta_in_text($_values, $text);
							}
						}

						$do_display = false;

						if(isset($layer['settings']['source-text-style-disable']) && @$layer['settings']['source-text-style-disable'])
							$do_ignore_styles = true;

					break;
				}

				if($do_limit){
					$limit_by = $base->getVar($layer, array('settings', 'limit-type'), 'none');
					if($limit_by !== 'none'){
						switch($layer['settings']['source']){
							case 'post':
							case 'event':
							case 'woocommerce':
								$text = $base->get_text_intro($text, $base->getVar($layer, array('settings', 'limit-num'), 10, 'i'), $limit_by);
							break;
						}
					}
				}

				// 2.2.6
				$min_height = $base->getVar($layer, array('settings', 'min-height'), '0');
				$max_height = $base->getVar($layer, array('settings', 'max-height'), 'none');

				if($min_height != '0' || $max_height !== 'none') {

					$span = '<span style="display: block;';

					if($min_height != '0') $span .= 'min-height: ' . $min_height . 'px;';
					if($max_height != 'none') $span .= 'max-height: ' . $max_height . 'px';

					$text = $span . '">' . $text . '</span>';

				}

			}

			$link_to = $base->getVar($layer, array('settings', 'link-type'), 'none');
			if($link_to !== 'none') $do_display = true;

			//very basic in relation to original, just add a tag around text so that it works (note: href is mandatory here! Not sure why though)
			switch($link_to){
				case 'post':
				case 'url':
				case 'meta':
				case 'javascript':
				case 'lightbox':
					$text = '<a href="#">'.$text.'</a>';
				break;
				case 'embedded_video':
				case 'ajax':
				break;
			}

			if($base->text_has_certain_tag($text, 'a') && !$do_ignore_styles){
				$this->add_css_wrap[$unique_class]['a']['display'] = $do_display; //do_display defines if we should write display: block;
				$this->add_css_wrap[$unique_class]['a']['full'] = $do_full; //do full styles (for categories and tags separator)
			}

		}

	}


    /**
     * add all styles from an element to queue
     */
    public function add_element_css($settings, $element_class){

		//check if element_class already set, only proceed if it is not set
		if(isset($this->layers_css[$this->id]['idle'][$element_class])) return true;

        $idle = array();
        $hover = array();

        $do_hover = false;
        $do_important = '';

        if(isset($settings['enable-hover']) && $settings['enable-hover'] == 'on') $do_hover = true;
        if(isset($settings['force-important']) && $settings['force-important'] == 'true') $do_important = ' !important';

        if(!empty($settings)){
            $attributes = Essential_Grid_Item_Element::get_existing_elements(true);

            foreach($attributes as $style => $attr){

                if($attr['style'] == 'hover' && !$do_hover) continue;
                if(!isset($settings[$style]) || empty($settings[$style]) || $settings[$style] == '') continue;
                if($attr['style'] != 'idle' && $attr['style'] != 'hover') continue;
                $set_style = ($attr['style'] == 'idle') ? $style : str_replace('-hover', '', $style);

                if($attr['type'] == 'multi-text'){

                    if(!isset($settings[$style.'-unit'])) $settings[$style.'-unit'] = 'px';

                    $set_unit = $settings[$style.'-unit'];

                    if($set_style == 'box-shadow' || $set_style == 'background-color'){
                        $multi_string = '';
                        foreach($settings[$style] as $val){
                            $multi_string .= $val.$set_unit.' ';
                        }

                        //get box shadow color
                        $shadow_color = ($attr['style'] == 'idle') ? $settings['shadow-color'] : $settings['shadow-color-hover'];

						/* 2.1.6 */
						/*
                        //get box shadow transaprency
						$shadow_transparency = ($attr['style'] == 'idle') ? $settings['shadow-alpha'] : $settings['shadow-alpha-hover'];
                        $shadow_color = Essential_Grid_Base::hex2rgba($shadow_color, $shadow_transparency);
                        */

                        $multi_string .= ' '.$shadow_color;

                        if($attr['style'] == 'idle'){
                            $idle['-moz-'.$set_style] = $multi_string;
                            $idle['-webkit-'.$set_style] = $multi_string;
                            $idle[$set_style] = $multi_string;
                        }else{
                            $hover['-moz-'.$set_style] = $multi_string;
                            $hover['-webkit-'.$set_style] = $multi_string;
                            $hover[$set_style] = $multi_string;
                        }
                    }elseif($set_style == 'border'){

                        if($attr['style'] == 'idle'){
                            $idle['border-top-width'] = (isset($settings[$style][0])) ? $settings[$style][0].$set_unit : '0'.$set_unit;
                            $idle['border-right-width'] = (isset($settings[$style][1])) ? $settings[$style][1].$set_unit : '0'.$set_unit;
                            $idle['border-bottom-width'] = (isset($settings[$style][2])) ? $settings[$style][2].$set_unit : '0'.$set_unit;
                            $idle['border-left-width'] = (isset($settings[$style][3])) ? $settings[$style][3].$set_unit : '0'.$set_unit;
                        }else{
                            $hover['border-top-width'] = (isset($settings[$style][0])) ? $settings[$style][0].$set_unit : '0'.$set_unit;
                            $hover['border-right-width'] = (isset($settings[$style][1])) ? $settings[$style][1].$set_unit : '0'.$set_unit;
                            $hover['border-bottom-width'] = (isset($settings[$style][2])) ? $settings[$style][2].$set_unit : '0'.$set_unit;
                            $hover['border-left-width'] = (isset($settings[$style][3])) ? $settings[$style][3].$set_unit : '0'.$set_unit;
                        }

                    }else{
                        $multi_string = '';
                        foreach($settings[$style] as $val){
                            $multi_string .= $val.$set_unit.' ';
                        }

                        if($attr['style'] == 'idle'){
                            $idle[$set_style] = $multi_string;
                        }else{
                            $hover[$set_style] = $multi_string;
                        }
                    }
                }else{
                    if($set_style == 'background-color' || $set_style == 'background'){

						/* 2.1.6 */
						/*
						//get bg color transaprency
                        $bg_color_transparency = ($attr['style'] == 'idle') ? $settings['bg-alpha'] : $settings['bg-alpha-hover'];
                        $bg_color_rgba = Essential_Grid_Base::hex2rgba($settings[$style], $bg_color_transparency); // we only need rgba in backend
						*/
						$bg_color_rgba = $settings[$style];
						if(class_exists('ESGColorpicker')) $bg_color_rgba = ESGColorpicker::get($bg_color_rgba);

                        if($attr['style'] == 'idle'){
                            $idle['background'] = $bg_color_rgba;
                        }else{
                            $hover['background'] = $bg_color_rgba;
                        }

                    }else{
                        if($set_style == 'border'){
                            if($attr['style'] == 'idle'){
                                $idle['border-style'] = 'solid';
                            }else{
                                $hover['border-style'] = 'solid';
                            }
                        }
                        if($set_style == 'font-style' && $settings[$style] == 'true') $settings[$style] = 'italic';

                        $set_unit = @$attributes[$style]['unit'];

                        if($attr['style'] == 'idle'){
                            $idle[$set_style] = $settings[$style].$set_unit;

							if($set_style == 'position' && $settings[$style] == 'absolute'){
								$idle['height'] = 'auto';
								$idle['width'] = 'auto';

								switch($settings['align']){
									case 't_l':
										$idle['top'] = $settings['top-bottom'].$settings['absolute-unit'];
										$idle['left'] = $settings['left-right'].$settings['absolute-unit'];
										break;
									case 't_r':
										$idle['top'] = $settings['top-bottom'].$settings['absolute-unit'];
										$idle['right'] = $settings['left-right'].$settings['absolute-unit'];
										break;
									case 'b_l':
										$idle['bottom'] = $settings['top-bottom'].$settings['absolute-unit'];
										$idle['left'] = $settings['left-right'].$settings['absolute-unit'];
										break;
									case 'b_r':
										$idle['bottom'] = $settings['top-bottom'].$settings['absolute-unit'];
										$idle['right'] = $settings['left-right'].$settings['absolute-unit'];
										break;
								}
							}

                        }else{
                            $hover[$set_style] = $settings[$style].$set_unit;
                        }
                    }
                }
            }
        }

        $this->layers_css[$this->id]['idle'][$element_class] = $idle;
        $this->layers_css[$this->id]['hover'][$element_class] = $hover;
        $this->layers_css[$this->id]['settings'][$element_class]['important'] = $do_important;

    }

    /**
     * set all demo filter categories like Post Title, WooCommerce, Event Calendar and even/masonry
     */
    public function set_filter($filter){

		$this->filter = $filter;

	}


    /**
     * set all demo filter categories like Post Title, WooCommerce, Event Calendar and even/masonry
     */
    public function set_demo_filter(){
        $filter = array();

        if(isset($this->params['choose-layout'])){
            $filter[] = array('slug' => $this->params['choose-layout']); //even || masonry
        }

        if(!empty($this->layers)){

            foreach($this->layers as $layer){
                if(!isset($layer['settings']) || !isset($layer['settings']['source'])) continue;
                switch($layer['settings']['source']){
                    case 'post':
                    case 'woocommerce':
                    case 'event':
                        if(!in_array($layer['settings']['source'], $filter)) $filter[] = array('slug' => $layer['settings']['source']);
                    break;
                }

                //if(isset($this->settings['favorite']) && $this->settings['favorite'] == true)
                //    if(!in_array('favorites', $filter)) $filter[] = 'favorites';
            }

        }

        $this->filter = $filter;
    }


    /**
     * set all demo filter categories like Post Title, WooCommerce, Event Calendar and even/masonry
     */
    public function set_skin_choose_filter(){
        $filter = array();

        if(isset($this->params['choose-layout'])){
            $filter[] = array('slug' => $this->params['choose-layout']); //even || masonry
        }

        $this->filter = $filter;
    }


    /**
     * set demo image
     */
    public function set_image($img){

        $this->cover_image = $img;

    }


    /**
     * set default image by id
	 * @since: 1.2.0
     */
    public function set_default_image_by_id($img_id){

		$img = wp_get_attachment_image_src($img_id, 'full');

		/* 2.1.5 */
		if($img === false) {
			$img = get_option('tp_eg_global_default_img', '');
			$img = !empty($img) ? wp_get_attachment_image_src($img, 'full') : false;
		}

		if($img !== false){
			$this->default_image = $img[0];
			$this->default_image_attr = array($img[1], $img[2]);

		}

    }

	/**
     * set grid item animation
	 * @since: 2.1.6.2
     */
    public function set_grid_item_animation($base, $params){

		$this->grid_item_animation = $base->getVar($params, 'grid-item-animation', 'none');
		$this->grid_item_animation_other = $base->getVar($params, 'grid-item-animation-other', 'none');

		$this->grid_item_animation_zoomin = $base->getVar($params, 'grid-item-animation-zoomin', '125');
		$this->grid_item_other_zoomin = $base->getVar($params, 'grid-item-other-zoomin', '125');

		$this->grid_item_animation_zoomout = $base->getVar($params, 'grid-item-animation-zoomout', '75');
		$this->grid_item_other_zoomout = $base->getVar($params, 'grid-item-other-zoomout', '75');

		$this->grid_item_animation_fade = $base->getVar($params, 'grid-item-animation-fade', '75');
		$this->grid_item_other_fade = $base->getVar($params, 'grid-item-other-fade', '75');

		$this->grid_item_animation_blur = $base->getVar($params, 'grid-item-animation-blur', '5');
		$this->grid_item_other_blur = $base->getVar($params, 'grid-item-other-blur', '5');

		$this->grid_item_animation_shift = $base->getVar($params, 'grid-item-animation-shift', 'top');
		$this->grid_item_other_shift = $base->getVar($params, 'grid-item-other-shift', 'top');

		$this->grid_item_animation_shift_amount = $base->getVar($params, 'grid-item-animation-shift-amount', '10');
		$this->grid_item_other_shift_amount = $base->getVar($params, 'grid-item-other-shift-amount', '10');

		$this->grid_item_animation_rotate = $base->getVar($params, 'grid-item-animation-rotate', '30');
		$this->grid_item_other_rotate = $base->getVar($params, 'grid-item-other-rotate', '30');

    }

    /**
     * set default image
	 * @since: 1.2.0
     */
    public function set_default_image($img){

		$this->default_image = $img;

    }

    /**
     * set youtube default image by id
	 * @since: 2.1.0
     */
    public function set_default_youtube_image_by_id($img_id){

		$img = wp_get_attachment_image_src($img_id, 'full');
		if($img !== false){
			$this->default_youtube_image = $img[0];
		}

    }

    /**
     * set youtube default image by id
	 * @since: 2.1.0
     */
    public function set_default_vimeo_image_by_id($img_id){

		$img = wp_get_attachment_image_src($img_id, 'full');
		if($img !== false){
			$this->default_vimeo_image = $img[0];
		}

    }

    /**
     * set youtube default image by id
	 * @since: 2.1.0
     */
    public function set_default_html_image_by_id($img_id){

		$img = wp_get_attachment_image_src($img_id, 'full');
		if($img !== false){
			$this->default_html_image = $img[0];
		}

    }


    /**
     * set demo image
     */
    public function set_media_sources($sources){

		$this->media_sources = $sources;

    }


    /**
     * set demo image
     */
    public function set_media_sources_type($sources_type){

        $this->media_sources_type = $sources_type;

    }


    /**
     * set google fonts
     */
    private function import_google_fonts(){
        $base = new Essential_Grid_Base();

        $this->google_fonts = $base->getVar($this->params, 'google-fonts', '');

    }


    /**
     * return if lightbox needs to be loaded
     */
    public function do_lightbox_loading(){

		return $this->load_lightbox;

    }


    /**
     * register google fonts to header
     */
    public function register_google_fonts(){
		$http = (is_ssl()) ? 'https' : 'http';

		if(!empty($this->google_fonts)){
			foreach($this->google_fonts as $font){
				if($font !== ''){
					wp_register_style('eg-google-font-'.sanitize_title($font), $http.'://fonts.googleapis.com/css?family='.strip_tags($font));
					wp_enqueue_style('eg-google-font-'.sanitize_title($font));
				}
			}
		}

    }


	/**
	 * Check Advanced Rules of layer to see if should be shown or not
	 * @since: 1.5.0
	 */
    public function check_advanced_rules($layer, $post){
		$base = new Essential_Grid_Base();
		$link_meta = new Essential_Grid_Meta_Linking();
		$meta = new Essential_Grid_Meta();
		$m = $meta->get_all_meta(false);
		$lm = $link_meta->get_all_link_meta(false);

		$is_post = (!empty($this->layer_values)) ? false : true;

		$rules = $base->getVar($layer, array('settings', 'adv-rules'), array());
		$show = $base->getVar($rules, 'ar-show', 'show');
		$logic = $base->getVar($rules, 'ar-logic', array('and', 'and', 'and', 'and', 'and', 'and'));
		$logic_glob = $base->getVar($rules, 'ar-logic-glob', array('and', 'and'));

		//define return values. They change depending on if we want to show or hide if values meet requirements
		$suc = ($show == 'show') ? true : false;
		$fail = ($show == 'show') ? false : true;

		if(!empty($rules)){

			foreach($rules['ar-type'] as $key => $value){
				$delete = false;
				switch($value){
					case 'meta':
						if(trim($rules['ar-meta'][$key]) == '')
							$delete = true;
					break;
					case 'off':
						$delete = true;
					break;
				}

				if($delete === false){ //check if operator between. If yes and value or value-2 empty, delete
					if($rules['ar-operator'][$key] == 'between'){
						if(trim($rules['ar-value'][$key]) == '' || trim($rules['ar-value-2'][$key]) == '') $delete = true;
					}
				}

				if($delete){
					unset($rules['ar-value'][$key]);
					unset($rules['ar-operator'][$key]);
					unset($rules['ar-type'][$key]);
					unset($rules['ar-meta'][$key]);
					unset($rules['ar-value-2'][$key]);
				}
			}

			$results = array();
			if(!empty($rules['ar-type'])){
				foreach($rules['ar-type'] as $key => $value){
					$my_val = '';
					switch($value){
						case 'meta':
							if($is_post){
								if(strpos($rules['ar-meta'][$key], 'eg-') === 0){
									if(!empty($m)){
										foreach($m as $me){
											if('eg-'.$me['handle'] == $rules['ar-meta'][$key]){
												$my_val = $meta->get_meta_value_by_handle($post['ID'],$rules['ar-meta'][$key]);
												break;
											}
										}
									}
								}elseif(strpos($rules['ar-meta'][$key], 'egl-') === 0){
									if(!empty($lm)){
										foreach($lm as $me){
											if('egl-'.$me['handle'] == $rules['ar-meta'][$key]){
												$my_val = $link_meta->get_link_meta_value_by_handle($post['ID'],$rules['ar-meta'][$key]);
												break;
											}
										}
									}
								}else{
									$my_val = get_post_meta($post['ID'], $rules['ar-meta'][$key], true);
								}
							}else{
								$my_val = @$this->layer_values[$rules['ar-meta'][$key]];
							}
						break;

						case 'featured-image':
						case 'alternate-image':
						case 'content-image':
						case 'youtube':
						case 'vimeo':
						case 'wistia':
						case 'soundcloud':
						case 'content-youtube':
						case 'content-vimeo':
						case 'content-wistia':
						case 'content-soundcloud':
						case 'iframe':
						case 'content-iframe':
							if($this->item_media_type == $value){
								$my_val = @$this->media_sources[$value];
							}
						break;
						case 'html5':
						case 'content-html5':
							if($this->item_media_type == $value){
								$my_val = @$this->media_sources[$value]['mp4'].@$this->media_sources[$value]['webm'].@$this->media_sources[$value]['ogv'];
							}
						break;

						default:
							if($this->item_media_type == $value){
								$my_val = apply_filters('essgrid_set_media_source', $my_val, $value, @$this->media_sources);
							}
						break;
					}

					switch($rules['ar-operator'][$key]){
						case 'lt':
							$results[$key] = ($my_val < $rules['ar-value'][$key]) ? true : false;
						break;
						case 'lte':
							$results[$key] = ($my_val <= $rules['ar-value'][$key]) ? true : false;
						break;
						case 'gt':
							$results[$key] = ($my_val > $rules['ar-value'][$key]) ? true : false;
						break;
						case 'gte':
							$results[$key] = ($my_val >= $rules['ar-value'][$key]) ? true : false;
						break;
						case 'equal':
							$results[$key] = ($my_val === $rules['ar-value'][$key]) ? true : false;
						break;
						case 'notequal':
							$results[$key] = ($my_val !== $rules['ar-value'][$key]) ? true : false;
						break;
						case 'between':
							$results[$key] = ($my_val > $rules['ar-value'][$key] && $my_val < $rules['ar-value-2'][$key]) ? true : false;
						break;
						case 'isset':
							$results[$key] = (trim($my_val) !== '' || !empty($my_val)) ? true : false;
						break;
						case 'empty':
							$results[$key] = (trim($my_val) === '') ? true : false;
						break;
					}

				}
			}

			if(!empty($results)){
				$part = array();
				$pnr = 0;
				$log = 0;

				for($i=0;$i<9;$i = $i+3){
					$first = (isset($results[$i])) ? true : false;
					$second = (isset($results[$i+1])) ? true : false;
					$third = (isset($results[$i+2])) ? true : false;

					if($first && $second){
						if($third){ //all three exist
							if($logic[$log] == 'and' && $logic[$log+1] == 'and'){
								$part[$pnr] = ($results[$i] === true && $results[$i+1] === true && $results[$i+2] === true) ? true : false;
							}elseif($logic[$log] == 'and' && $logic[$log+1] == 'or'){
								$part[$pnr] = ($results[$i] === true && $results[$i+1] === true || $results[$i+2] === true) ? true : false;
							}elseif($logic[$log] == 'or' && $logic[$log+1] == 'and'){
								$part[$pnr] = ($results[$i] === true || $results[$i+1] === true && $results[$i+2] === true) ? true : false;
							}elseif($logic[$log] == 'or' && $logic[$log+1] == 'or'){
								$part[$pnr] = ($results[$i] === true || $results[$i+1] === true || $results[$i+2] === true) ? true : false;
							}
						}else{ //only first and second exist
							if($logic[$log] == 'and'){
								$part[$pnr] = ($results[$i] === true && $results[$i+1] === true) ? true : false;
							}else{
								$part[$pnr] = ($results[$i] === true || $results[$i+1] === true) ? true : false;
							}
						}
					}else{
						if($first){
							if($first && $third){
								if($logic[$log+1] == 'and'){
									$part[$pnr] = ($results[$i] === true && $results[$i+2] === true) ? true : false;
								}else{
									$part[$pnr] = ($results[$i] === true || $results[$i+2] === true) ? true : false;
								}
							}else{ //only first exist
								$part[$pnr] = ($results[$i] === true) ? true : false;
							}
						}elseif($second){
							if($second && $third){
								if($logic[$log+1] == 'and'){
									$part[$pnr] = ($results[$i+1] === true && $results[$i+2] === true) ? true : false;
								}else{
									$part[$pnr] = ($results[$i+1] === true || $results[$i+2] === true) ? true : false;
								}
							}else{ //only second exist
								$part[$pnr] = ($results[$i+1] === true) ? true : false;
							}
						}elseif($third){ //only third exists
							$part[$pnr] = ($results[$i+2] === true) ? true : false;
						}else{ //nothing exists, ignore this part
							//do nothing
						}
					}

					$pnr++;
					$log +=2;

				}

				if(!empty($part)){
					//start the && and || operations here
					if(isset($part[0]) && isset($part[1]) && isset($part[2])){ //all three exist
						if($logic_glob[0] == 'and' && $logic[1] == 'and'){
							return ($part[0] === true && $part[1] === true && $part[2] === true) ? $suc : $fail;
						}elseif($logic[0] == 'and' && $logic[1] == 'or'){
							return ($part[0] === true && $part[1] === true || $part[2] === true) ? $suc : $fail;
						}elseif($logic[0] == 'or' && $logic[1] == 'and'){
							return ($part[0] === true || $part[1] === true && $part[2] === true) ? $suc : $fail;
						}elseif($logic[0] == 'or' && $logic[1] == 'or'){
							return ($part[0] === true || $part[1] === true || $part[2] === true) ? $suc : $fail;
						}
					}elseif(isset($part[0]) && isset($part[1])){ //first two
						if($logic_glob[0] == 'and'){
							return ($part[0] === true && $part[1] === true) ? $suc : $fail;
						}else{
							return ($part[0] === true || $part[1] === true) ? $suc : $fail;
						}
					}elseif(isset($part[0]) && isset($part[2])){ //first and last
						if($logic_glob[1] == 'and'){
							return ($part[0] === true && $part[2] === true) ? $suc : $fail;
						}else{
							return ($part[0] === true || $part[2] === true) ? $suc : $fail;
						}
					}elseif(isset($part[1]) && isset($part[2])){ //second and last
						if($logic_glob[1] == 'and'){
							return ($part[1] === true && $part[2] === true) ? $suc : $fail;
						}else{
							return ($part[1] === true || $part[2] === true) ? $suc : $fail;
						}
					}elseif(isset($part[0])){ //only first
						return ($part[0] === true) ? $suc : $fail;
					}elseif(isset($part[1])){ //only second
						return ($part[1] === true) ? $suc : $fail;
					}elseif(isset($part[2])){ //only third
						return ($part[2] === true) ? $suc : $fail;
					}
				}

				return $fail;
			}

		}

		return $suc;

	}


	/**
	 * insert layer
	 */
	public function insert_layer($layer, $demo = false, $masonry = false, $grid_ids = '', $post_ids = ''){

		$base = new Essential_Grid_Base();
		$m = new Essential_Grid_Meta();
		$enable_youtube_nocookie = get_option('tp_eg_enable_youtube_nocookie', 'false');

		$is_post = (!empty($this->layer_values)) ? false : true;

		if($demo === false){
			$post = $this->post;
			$layer_values = $this->layer_values;
		}else{
			$post['ID'] = '0'; //set default if we are in demo mode
		}

		//check advanced rules
		$show = $this->check_advanced_rules($layer, $post);

		if($show === false) return false;

		$position = $base->getVar($layer, 'container', 'tl');

		$class = 'top';
		switch($position){
			case 'tl':
				$class = 'top';
				break;
			case 'br':
				$class = 'bottom';
				break;
			case 'c':
				$class = 'center';
				break;
			case 'm':
				$class = 'content';
				break;
		}

		if(!isset($layer['settings'])) return false;

		$this->register_layer_css($layer, $demo);

		if (isset($layer['id'])) $unique_class = 'eg-'.esc_attr($this->handle).'-element-'.$layer['id'];
		else $unique_class = '';

		$special_item = $base->getVar($layer, array('settings', 'special'), 'false');
		$special_item_type = $base->getVar($layer, array('settings', 'special-type'), 'line-break');
		/*if($special_item != 'true'){
			$this->add_element_css($layer['settings'], $unique_class); //add css to queue
		}*/

		//check if absolute positioned, remove class depending on it
		$absolute = $this->is_absolute_position($unique_class);
		if($absolute){
			$class = 'absolute';
		}

		$hideunderHTML = '';
		$hideunderClass = '';
		$hideunder = $base->getVar($layer, array('settings', 'hideunder'), 0, 'i');
		$hideunderheight = $base->getVar($layer, array('settings', 'hideunderheight'), 0, 'i');
		$hideundertype = $base->getVar($layer, array('settings', 'hidetype'), 'visibility');

		if($hideunder > 0){
			$hideunderHTML .= ' data-hideunder="'.$hideunder.'"';
			$hideunderClass = 'eg-handlehideunder ';
		}

		if($hideunderheight > 0){
			$hideunderHTML .= ' data-hideunderheight="'.$hideunderheight.'"';
			$hideunderClass = 'eg-handlehideunder ';
		}

		if($hideunderHTML !== ''){
			$hideunderHTML .= ' data-hidetype="'.esc_attr($hideundertype).'"';
		}

		$delay = '';
		$duration = '';
		$transition_split = '';
		
		
		if($masonry){
			$transition = '';
			//$transition_split = '';
			$data_transition_transition = '';
		}else{
			$transition = 'esg-'.esc_attr($base->getVar($layer, array('settings', 'transition'), 'fade')).esc_attr($base->getVar($layer, array('settings', 'transition-type'), ''));
			//$transition_split = ' data-split="'.$base->getVar($layer['settings'], 'split', 'line').'"';

			if(isset($layer['id'])) $meta_tran = esc_attr($this->get_meta_element_change($layer['id'], 'transition')); //check if we have meta transition set
			else $meta_tran = false;
			if($meta_tran !== false && trim($meta_tran) !== '') $transition = ' esg-'.$meta_tran;

			if($transition == 'esg-none' || $transition == 'esg-noneout' || $base->getVar($layer, array('settings', 'transition-type'), '') == 'always'){ //no transition
				$transition = '';
				//$transition_split = '';
			}else{
				$delay = ' data-delay="'.round($base->getVar($layer, array('settings', 'delay'), 0) / 100, 2).'"';
				$duration = ' data-duration="'.$base->getVar($layer, array('settings', 'duration'), 'default').'"';

				if(isset($layer['id'])) $meta_tran_delay = $this->get_meta_element_change($layer['id'], 'transition-delay'); //check if we have meta transition-delay set
				else $meta_tran_delay = false;
				if($meta_tran_delay !== false)
					$delay = ' data-delay="'.round($meta_tran_delay / 100, 2).'"';

			}

			// 2.2.5
			if($transition) {

				$data_transition_transition = ' data-transition="' . trim($transition) . '"';
				$transition = ' esg-transition';

			}
			else {
				$data_transition_transition = '';
			}			

		}

		$text = '';

		$do_limit = true;
		$do_display = true;
		$do_full = false;
		$do_ignore_styles = false;
		$is_woo_cats = false;
		$is_woo_button = false;
		$is_html_source = false;
		$is_filter_cat = false;
		$demo_element_type = ' data-custom-type="%s"';

		if(isset($layer['settings']['source'])){
			$separator = $base->getVar($layer, array('settings', 'source-separate'), ',');
			$catmax = $base->getVar($layer, array('settings', 'source-catmax'), '-1');
			$meta = $base->getVar($layer, array('settings', 'source-meta'), '');
			$func = $base->getVar($layer, array('settings', 'source-function'), 'link');
			$taxonomy = $base->getVar($layer, array('settings', 'source-taxonomy'), '');

			switch($layer['settings']['source']){
				case 'post':
					if($demo === false){
						if($is_post)
							$text = $this->get_post_value($layer['settings']['source-post'], $separator, $func, $meta, $catmax,$taxonomy);
						else
							$text = $this->get_custom_element_value($layer['settings']['source-post'], $separator, $meta);



						if($func == 'filter') $is_filter_cat = true;

					}elseif($demo === 'custom'){
						$text = $this->get_custom_element_value($layer['settings']['source-post'], $separator, $meta);
					}else{
						$post_text = Essential_Grid_Item_Element::getPostElementsArray();
						if(array_key_exists(@$layer['settings']['source-post'], $post_text)) $text = $post_text[@$layer['settings']['source-post']]['name'];

						if($layer['settings']['source-post'] == 'date'){
							$da = get_option('date_format');
							if($da !== false)
								$text = date(get_option('date_format'));
							else
								$text = date('Y.m.d');
						}
					}

					$demo_element_type = str_replace('%s', $layer['settings']['source-post'], $demo_element_type);

					if($layer['settings']['source-post'] == 'cat_list' || $layer['settings']['source-post'] == 'tag_list'){ //no limiting if category or tag list
						$do_limit = false;
						$do_display = false;
						$do_full = true;
					}



					$text = apply_filters('essgrid_post_meta_content', $text, $layer['settings']['source-post'], @$this->post['ID'], $this->post);

				break;
				case 'event':
					if($demo === false){

					}else{
						$event = Essential_Grid_Item_Element::getEventElementsArray();
						if(array_key_exists(@$layer['settings']['source-event'], $event)) $text = $event[@$layer['settings']['source-event']]['name'];
					}

					$demo_element_type = str_replace('%s', $layer['settings']['source-event'], $demo_element_type);

				break;
				case 'woocommerce':
					//check if woocommerce is installed
					if($demo === false){
						if(Essential_Grid_Woocommerce::is_woo_exists()){
							if($is_post)
								$text = $this->get_woocommerce_value($layer['settings']['source-woocommerce'], $separator, $catmax);
							else
								$text = $this->get_custom_element_value($layer['settings']['source-woocommerce'], $separator, '');

							if($layer['settings']['source-woocommerce'] == 'wc_categories'){
								$do_limit = false;
								$do_display = false;
								$do_full = true;
								$is_woo_cats = true;
							}elseif($layer['settings']['source-woocommerce'] == 'wc_add_to_cart_button'){
								$do_limit = false;
								$is_woo_button = true;
							}
						}
					}elseif($demo === 'custom'){
						if(Essential_Grid_Woocommerce::is_woo_exists()){
							$text = $this->get_custom_element_value($layer['settings']['source-woocommerce'], $separator, '');

							if($layer['settings']['source-woocommerce'] == 'wc_categories'){
								$do_limit = false;
								$do_display = false;
								$do_full = true;
								$is_woo_cats = true;
							}elseif($layer['settings']['source-woocommerce'] == 'wc_add_to_cart_button'){
								$do_limit = false;
								$is_woo_button = true;
							}

						}
					}else{
						if(Essential_Grid_Woocommerce::is_woo_exists()){
							$tmp_wc = Essential_Grid_Woocommerce::get_meta_array();

							foreach($tmp_wc as $handle => $name){
								$woocommerce[$handle]['name'] = $name;
							}

							if(array_key_exists(@$layer['settings']['source-woocommerce'], $woocommerce)) $text = $woocommerce[@$layer['settings']['source-woocommerce']]['name'];
						}
					}

					$demo_element_type = str_replace('%s', $layer['settings']['source-woocommerce'], $demo_element_type);

				break;
				case 'icon':
					$text = '<i class="'.@$layer['settings']['source-icon'].'"></i>';
					$demo_element_type = '';
				break;
				case 'text':
					$text = @$layer['settings']['source-text'];

					if($demo === false){
						//check for metas by %meta%
						if($is_post){
							$text = $m->replace_all_meta_in_text($this->post['ID'], $text);
						}else{
							$_a = (!empty($this->layer_values)) ? $this->layer_values : array();
							$_b = (!empty($this->media_sources)) ? $this->media_sources : array();
							$_values = array_merge($_a, $_b);
							$text = $m->replace_all_custom_element_meta_in_text($_values, $text);
						}
					}

					// Fix html tags
					libxml_use_internal_errors(true);
					$text_xml = "";
					if( class_exists('DOMDocument') && defined('LIBXML_HTML_NOIMPLIED') && defined('LIBXML_HTML_NODEFDTD') ){
						$dom = new DOMDocument();
						$dom->loadHTML('<root>' . mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8') . '</root>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
						$text_xml = substr($dom->saveHTML(), 6, -8);
					}
					if(!empty($text_xml)) $text = $text_xml;

					if($demo == 'overview' || $demo == 'skinchoose' || $demo == 'skin-editor') $text = esc_attr($text); // added so that Item Skin Editor can be still used even if wrong formated HTML was added as a layer

					if(isset($layer['settings']['source-text-style-disable']) && @$layer['settings']['source-text-style-disable'])
						$do_ignore_styles = true;

					$do_display = false;
					$demo_element_type = '';
					$is_html_source = true;
				break;
				default:
					$demo_element_type = '';
			}

			if($do_limit){
				$limit_by = $base->getVar($layer, array('settings', 'limit-type'), 'none');
				if($limit_by !== 'none'){
					switch($layer['settings']['source']){
						case 'post':
						case 'event':
						case 'woocommerce':
							if( !in_array( $base->getVar($layer, array('settings', 'source-post'), '') , array( 'taxonomy' , 'cat_list' , 'tag_list' ) )  )
								$text = $base->get_text_intro($text, $base->getVar($layer, array('settings', 'limit-num'), 10, 'i'), $limit_by);
						break;
					}
				}
			}

			// 2.2.6
			$min_height = $base->getVar($layer, array('settings', 'min-height'), '0');
			$max_height = $base->getVar($layer, array('settings', 'max-height'), 'none');

			if($min_height != '0' || $max_height !== 'none') {

				$span = '<span style="display: block;';

				if($min_height != '0') {
					$min_height = intval($min_height);
					$span .= 'min-height: ' . $min_height . 'px;';
				}
				if($max_height != 'none') {
					$max_height = intval($max_height);
					$span .= 'overflow: hidden; height: ' . $max_height . 'px; max-height: ' . $max_height . 'px';
				}

				$text = $span . '">' . $text . '</span>';

			}

		}
		
		$link_to = $base->getVar($layer, array('settings', 'link-type'), 'none');
		$link_target = $base->getVar($layer, array('settings', 'link-target'), '_self');
		if($link_target !== 'disabled')
			$link_target = ' target="'.esc_attr($link_target).'"';
		else
			$link_target = '';

		$video_play = '';
		$ajax_class = '';
		$ajax_attr = '';
		$lb_class = '';

		switch($link_to){
			case 'post':
				if($demo === false){
					if($is_post){
						$text = '<a href="'.get_permalink( $post['ID'] ).'"'.$link_target.'>'.$text.'</a>';
					}else{

						/*
						if(isset($this->layer_values['custom-image'])){
							$text = '<a href="'.get_permalink( $this->layer_values['custom-image'] ).'"'.$link_target.'>'.$text.'</a>';
						}
						else{
						*/
							$get_link = $this->get_custom_element_value('post-link', $separator, ''); //get the post link

							/* 2.1.5 */
							// fix for grids populated with WP Media Galleries
							if($get_link == '') {

								if(isset($this->layer_values['custom-image']) && !empty($this->layer_values['custom-image'])) {
									$text = '<a href="'.get_permalink( $this->layer_values['custom-image'] ).'"'.$link_target.'>'.$text.'</a>';
								}
								else {
									$text = '<a href="javascript:void(0);"'.$link_target.'>'.$text.'</a>';
								}

							}
							else {

								/* 2.1.6 append "http" to manually written links starting with "www" */
								$get_link = esc_attr($get_link);
								if(strpos($get_link, '://') === false) {
									$get_link = !is_ssl() ? 'http://' . $get_link : 'https://' . $get_link;
								}

								$text = '<a href="'.$get_link.'"'.$link_target.'>'. preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $text).'</a>';
							}
						/*}*/
					}

				}else{
					$text = '<a href="javascript:void(0);"'.$link_target.'>'.$text.'</a>';
				}
			break;
			case 'url':
				$lurl = $base->getVar($layer, array('settings', 'link-type-url'), 'javascript:void(0);');
				if(strpos($lurl, '://') === false && trim($lurl) !== '' && $lurl !== 'javascript:void(0);'){
					$lurl = (is_ssl()) ? 'https://'.$lurl : 'http://'.$lurl;
				}
				$text = '<a href="'.esc_attr($lurl).'"'.$link_target.'>'.$text.'</a>';
			break;
			case 'meta':
				if($demo === false){
					if($is_post){
						$meta_key = $base->getVar($layer, array('settings', 'link-type-meta'), 'javascript:void(0);');

						$meta_link = $m->get_meta_value_by_handle($post['ID'], $meta_key);
						if($meta_link == ''){// if empty, link to nothing
							$text = '<a href="javascript:void(0);"'.$link_target.'>'.$text.'</a>';
						}else{

							/* 2.1.6 append "http" to manually written links starting with "www" */
							$meta_link = esc_attr($meta_link);
							if((strpos($meta_link, '://') === false) && (strpos($meta_link, 'mailto:') === false)){
								$meta_link = !is_ssl() ? 'http://' . $meta_link : 'https://' . $meta_link;
							}

							$text = '<a href="'.$meta_link.'"'.$link_target.'>'.$text.'</a>';
						}
					}else{
						$meta_key = $base->getVar($layer, array('settings', 'link-type-meta'), '');

						$get_link = $this->get_custom_element_value('post-link', $separator, $meta_key); //get the post link
						if($get_link == '') {
							$text = '<a href="javascript:void(0);"'.$link_target.'>'.$text.'</a>';
						}
						else {

							/* 2.1.6 append "http" to manually written links starting with "www" */
							$get_link = esc_attr($get_link);
							if(strpos($get_link, '://') === false) {
								$get_link = !is_ssl() ? 'http://' . $get_link : 'https://' . $get_link;
							}

							$text = '<a href="'.$get_link.'"'.$link_target.'>'.$text.'</a>';
						}
					}
				}else{
					$text = '<a href="javascript:void(0);"'.$link_target.'>'.$text.'</a>';
				}
			break;
			case 'javascript':
				$text = '<a href="javascript:'.esc_attr($base->getVar($layer, array('settings', 'link-type-javascript'), 'void(0);')).'"'.$link_target.'>'.$text.'</a>'; //javascript-link
			break;
			case 'lightbox':
				$opt = get_option('tp_eg_use_lightbox', 'false');
				if($opt !== 'disabled'){ //enqueue only if default LightBox is selected
					wp_enqueue_script('themepunchboxext');
					wp_enqueue_style('themepunchboxextcss');
				}
				$lb_source = 'javascript:void(0);';
				$lb_addition = '';
				$lb_rel = ($this->lb_rel !== false) ? ' data-esgbox="'.esc_attr($this->lb_rel).'"' : '';
				$lb_data = '';
				$lb_featured = '';
				$lb_post_title = '';
				$lb_owidth='';
				$lb_oheight='';

				if(!empty($this->default_lightbox_source_order)){ //only show if something is checked

					foreach($this->default_lightbox_source_order as $order){ //go through the order and set media as wished

						$val = isset($this->media_sources[$order]) && $this->media_sources[$order] !== '' && $this->media_sources[$order] !== false;
						if($order === 'post-content' || !empty($val)){ //found entry

							$do_continue = false;
							$is_video = false;

							if(!empty($this->lightbox_additions['items']) && $this->lightbox_additions['base'] == 'on') {
								$lb_source = $this->lightbox_additions['items'][0];
								$lb_class = ' esgbox';
							}else{

								switch($order){
									case 'featured-image':
									case 'alternate-image':
									case 'content-image':

										// 2.2.5
										$imgsource = explode('-', $order);
										$imgsource = $imgsource[0];

										if($order == 'content-image') $lb_source = $this->media_sources[$order];
										else $lb_source = $this->media_sources[$order.'-full'];
										$lb_class = ' esgbox';

										if(isset($this->media_sources[$imgsource . '-image-full-width'])) $lb_owidth = ' data-width="' . $this->media_sources[$imgsource . '-image-full-width'] . '" ';
										if(isset($this->media_sources[$imgsource . '-image-full-height'])) $lb_oheight = ' data-height="' . $this->media_sources[$imgsource . '-image-full-height'] . '" ';

									break;
									case 'youtube':
										$http = (is_ssl()) ? 'https' : 'http';
										$enable_youtube_nocookie = get_option('tp_eg_enable_youtube_nocookie', 'false');
										$lb_source = $enable_youtube_nocookie!='false' ? $http.'://www.youtube-nocookie.com/embed/'.$this->media_sources[$order] : $lb_source = $http.'://www.youtube.com/watch?v='.$this->media_sources[$order];

										$lb_class = ' esgbox';
										$is_video = true;
										$lb_addition = ($this->video_ratios['youtube'] == '1') ? '' : ' data-ratio="4:3"';
									break;
									case 'vimeo':
										$http = (is_ssl()) ? 'https' : 'http';
										$lb_source = $http.'://vimeo.com/'.$this->media_sources[$order];
										$lb_class = ' esgbox';
										$is_video = true;
										$lb_addition = ($this->video_ratios['vimeo'] == '1') ? '' : ' data-ratio="4:3"';
									break;
									case 'wistia':
										// $http = (is_ssl()) ? 'https' : 'http';
										$lb_source = '//fast.wistia.net/embed/iframe/'.$this->media_sources[$order];
										$lb_class = ' esgbox';
										$lb_data .= ' data-type="iframe"';
										$lb_addition = ($this->video_ratios['wistia'] == '1') ? '' : ' data-ratio="4:3"';
									break;
									case 'soundcloud':
										$lb_source = '//w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' . $this->media_sources[$order] . '&amp;color=%23ff5500&amp;auto_play=true&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;show_teaser=true&amp;visual=true';
										$lb_class = ' esgbox';
										$lb_data .= ' data-type="iframe"';
									break;
									case 'iframe':
										$lb_source = addslashes($this->media_sources[$order]);
										$lb_class = ' esgbox';
										$lb_data .= ' data-type="iframe"';

									break;
									case 'html5':
										if(trim($this->media_sources[$order]['mp4']) === '' && trim($this->media_sources[$order]['ogv']) === '' && trim($this->media_sources[$order]['webm'] === '')){
											$do_continue = true;
										}else{
											//check for video poster image
											$video_poster_src = '';
											if(!empty($this->default_video_poster_order)){
												foreach($this->default_video_poster_order as $n_order){
													if($n_order == 'no-image'){ //do not show image so set image empty
														$video_poster_src = '';
														break;
													}
													if(isset($this->media_sources[$n_order]) && $this->media_sources[$n_order] !== '' && $this->media_sources[$n_order] !== false){ //found entry
														$video_poster_src = $this->media_sources[$n_order];
														break;
													}
												}
											}

											$lb_mp4 = $this->media_sources[$order]['mp4'];
											$lb_ogv = $this->media_sources[$order]['ogv'];
											$lb_webm = $this->media_sources[$order]['webm'];
											$vid_ratio = ($this->video_ratios['html5'] == '1') ? '' : ' data-ratio="4:3"';

											$lb_source = ""; //Leave it Empty, other way HTML5 Video will not work !!

											if(!empty($lb_mp4)){
												$lb_source = $lb_mp4;
											}
											elseif (!empty($lb_ogv)) {
												$lb_source = $lb_ogv;
											}
											elseif (!empty($lb_webm)) {
												$lb_source = $lb_webm;
											}

											$text = '<img style="display: none;" src="'.esc_attr($video_poster_src).'" />'.$text;
											$lb_class = ' esgbox esgboxhtml5';
											$lb_addition = ' data-mp4="'.esc_attr($lb_mp4).'" data-ogv="'.esc_attr($lb_ogv).'" data-webm="'.esc_attr($lb_webm).'"'.$vid_ratio;
											$is_video = true;
										}
									break;

									case 'revslider':

										$lb_source = 'javascript:void(0);';
										$lb_class = ' esgbox esgbox-post';
										$lb_data = ' data-post="' . $post_ids . '"';
										$lb_data .= ' data-revslider="' . $this->media_sources[$order] . '"';
										$lb_data .= ' data-gridid="' . $grid_ids . '" data-ispost="' . $is_post . '"';

									break;

									case 'essgrid':

										$lb_source = 'javascript:void(0);';
										$lb_class = ' esgbox esgbox-post';
										$lb_data = ' data-post="' . $post_ids . '"';
										$lb_data .= ' data-lbesg="' . $this->media_sources[$order] . '"';
										$lb_data .= ' data-gridid="' . $grid_ids . '" data-ispost="' . $is_post . '"';

									break;

									case 'post-content':

										$lb_source = 'javascript:void(0);';
										$lb_class = ' esgbox esgbox-post';
										$lb_data = ' data-post="' . $post_ids . '"';
										$lb_data .= ' data-gridid="' . $grid_ids . '" data-ispost="' . $is_post . '"';
										$lb_post_title = $is_post ? $base->getVar($this->post, 'post_title', '') : $this->get_custom_element_value('title', $separator, '');
										$lb_post_title = ' data-posttitle="' . $lb_post_title . '"';

										// if featured full is available
										if(isset($this->media_sources['featured-image-full']) && !empty($this->media_sources['featured-image-full'])) {
											$lb_featured = ' data-featured="' . esc_attr($this->media_sources['featured-image-full']) . '"';
										}
										// if featured regular size is available
										else if(isset($this->media_sources['featured-image']) && !empty($this->media_sources['featured-image'])) {
											$lb_featured = ' data-featured="' . esc_attr($this->media_sources['featured-image']) . '"';
										}
										// if global image is available
										else if(!empty($this->default_image)) {
											$lb_featured = ' data-featured="' . esc_attr($this->default_image) . '"';
										}

									break;

									default:
										$do_continue = true;
									break;

								}

							}

							if($do_continue){
								continue;
							}

							if($base->getVar($layer, array('settings', 'show-on-lightbox-video'), 'false') == 'true' && $is_video === false){
								return false; //this element is hidden if media is video
							}
							if($base->getVar($layer, array('settings', 'show-on-lightbox-video'), 'false') == 'hide' && $is_video === true){
								return false; //this element is hidden if media is video
							}

							break;
						}

						/* 2.1.5 */
						if($order === 'featured-image') {
							$default_img = $this->default_image;
							if(!empty($default_img)) {
								$lb_source = $default_img;
								$lb_class = ' esgbox';
								$lb_owidth = ' data-width="' . $this->default_image_attr[0] . '" ';
								$lb_oheight = ' data-height="' . $this->default_image_attr[1] . '" ';
								break;
							}
						}

					}
				}

				if($demo !== false){
					$lb_title = __('demo mode', EG_TEXTDOMAIN);
				}else{
					if($is_post)
						$lb_title = $base->getVar($this->post, 'post_title', '');
					else
						$lb_title = $this->get_custom_element_value('title', $separator, ''); //the title from Post Title will be used
				}

				//$text = '<a href="'.esc_attr($ ).'"'.$lb_addition.' data-caption="'.esc_attr($lb_title).'"'.$lb_rel.$lb_data.$lb_featured.$lb_post_title.'>'.$text.'</a>';

				/* 2.2 */
				$lb_caption = isset($this->fancybox_three_options['title']) ? $this->fancybox_three_options['title'] : 'off';
				$lb_caption = $lb_caption === 'on' ? ' data-caption="' . esc_attr($lb_title) . '" ' : '';

				$text = '<a data-thumb="'. esc_attr( ess_aq_resize($this->lightbox_thumbnail, 200) ) .'" href="'.esc_attr($lb_source).'"'.$lb_addition.$lb_caption.$lb_owidth.$lb_oheight.$lb_rel.$lb_data.$lb_featured.$lb_post_title.'>'.$text.'</a>';

				$this->load_lightbox = true; //set that jQuery is written
			break;
			case 'embedded_video':
				$video_play = ' esg-click-to-play-video';
			break;
			case 'ajax':
				$ajax_class = '';
				if(!empty($this->default_ajax_source_order)){ //only show if something is checked
					$ajax_class = ' eg-ajaxclicklistener';
					foreach($this->default_ajax_source_order as $order){ //go through the order and set media as wished
						$do_continue = false;
						if(isset($this->media_sources[$order]) && $this->media_sources[$order] !== '' && $this->media_sources[$order] !== false || $order == 'post-content'){ //found entry
							switch($order){
								case 'youtube':
									$vid_ratio = ($this->video_ratios['youtube'] == '0') ? '4:3' : '16:9';
									$ajax_attr = ' data-ajaxtype="youtubeid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
									$ajax_attr .= ' data-ajaxsource="'.esc_attr($this->media_sources[$order]).'"'; //depending on type
									$ajax_attr .= ' data-ajaxvideoaspect="'.$vid_ratio.'"'; //depending on type
								break;
								case 'vimeo':
									$vid_ratio = ($this->video_ratios['vimeo'] == '0') ? '4:3' : '16:9';
									$ajax_attr = ' data-ajaxtype="vimeoid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
									$ajax_attr .= ' data-ajaxsource="'.esc_attr($this->media_sources[$order]).'"'; //depending on type
									$ajax_attr .= ' data-ajaxvideoaspect="'.$vid_ratio.'"'; //depending on type
								break;
								case 'wistia':
									$vid_ratio = ($this->video_ratios['wistia'] == '0') ? '4:3' : '16:9';
									$ajax_attr = ' data-ajaxtype="wistiaid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
									$ajax_attr .= ' data-ajaxsource="'.esc_attr($this->media_sources[$order]).'"'; //depending on type
									$ajax_attr .= ' data-ajaxvideoaspect="'.$vid_ratio.'"'; //depending on type
								break;
								case 'html5':
									if($this->media_sources[$order]['mp4'] == ''
									&& $this->media_sources[$order]['webm'] == ''
									&& $this->media_sources[$order]['ogv'] == ''){
										$do_continue = true;
									}else{
										//mp4/webm/ogv
										$vid_ratio = ($this->video_ratios['html5'] == '0') ? '4:3' : '16:9';
										$ajax_attr = ' data-ajaxtype="html5vid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
										$ajax_attr .= ' data-ajaxsource="';
										$ajax_attr .= esc_attr(@$this->media_sources[$order]['mp4']).'|';
										$ajax_attr .= esc_attr(@$this->media_sources[$order]['webm']).'|';
										$ajax_attr .= esc_attr(@$this->media_sources[$order]['ogv']);
										$ajax_attr .= '"';
										$ajax_attr .= ' data-ajaxvideoaspect="'.$vid_ratio.'"'; //depending on type
									}
								break;
								case 'soundcloud':
									$ajax_attr = ' data-ajaxtype="soundcloudid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
									$ajax_attr .= ' data-ajaxsource="'.esc_attr($this->media_sources[$order]).'"'; //depending on type
								break;
								case 'post-content':
									if($is_post){
										$ajax_attr = ' data-ajaxtype="postid"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
										$ajax_attr .= ' data-ajaxsource="'.@$this->post['ID'].'"'; //depending on type
									}else{
										$do_continue = true;
										//$ajax_class = '';
									}
								break;
								case 'featured-image':
								case 'alternate-image':
								case 'content-image':
									$img_url = '';
									if($order == 'content-image')
										$img_url = $this->media_sources[$order];
									else
										$img_url = $this->media_sources[$order.'-full'];

									$ajax_attr = ' data-ajaxtype="imageurl"'; // postid, html5vid youtubeid vimeoid soundcloud revslider
									$ajax_attr .= ' data-ajaxsource="'.esc_attr($img_url).'"'; //depending on type
								break;
								default:
									$ajax_class = '';
									$do_continue = true;
								break;
							}
							if($do_continue){
								continue;
							}
							break;
						}else{ //some custom entry maybe
							$postobj = ($is_post) ? $this->post : false;

							$ajax_attr = apply_filters('essgrid_handle_ajax_content', $order, $this->media_sources, $postobj, $this->grid_id);
							if(empty($ajax_attr)){
								//$ajax_class = '';
								$do_continue = true;
							}

							if($do_continue){
								continue;
							}
							break;
						}
					}
				}

				//$ajax_attr .= ' data-ajaxcallback=""'; //functionname
				//$ajax_attr .= ' data-ajaxcsstoload=""'; //css source
				//$ajax_attr .= ' data-ajaxjstoload=""'; //js source

				if($ajax_class !== ''){ //set ajax loading to true so that the grid can decide to put ajax container in top/bottom
					$this->ajax_loading = true;
				}

			break;
			case 'sharefacebook':
				if(isset($layer['settings']['link-type-sharefacebook'])){
					switch ($layer['settings']['link-type-sharefacebook']) {
						case 'custom':
							$facebook_share_url = $layer['settings']['link-type-sharefacebook-custom-url'];
							break;
						case 'site':
							$facebook_share_url = get_permalink();
							break;
						default:
							if($is_post){
								$facebook_share_url =  get_permalink( $post['ID'] );
							}
							else{
								$get_link = $this->get_custom_element_value('post-link', $separator, '');
								$facebook_share_url = $get_link;
							}
							break;
					}
				}
				else {
					if($is_post){
						$facebook_share_url =  get_permalink( $post['ID'] );
					}
					else{
						$get_link = $this->get_custom_element_value('post-link', $separator, '');
						$facebook_share_url = $get_link;
					}
				}
				$text = '<a href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($facebook_share_url).'" target="_blank" rel=nofollow>'.$text.'</a>';
			break;
			case 'sharegplus':
				if(isset($layer['settings']['link-type-sharegplus'])){
					switch ($layer['settings']['link-type-sharegplus']) {
						case 'custom':
							$gplus_share_url = $layer['settings']['link-type-sharegplus-custom-url'];
							break;
						case 'site':
							$gplus_share_url = get_permalink();
							break;
						default:
							if($is_post){
								$gplus_share_url =  get_permalink( $post['ID'] );
							}
							else{
								$get_link = $this->get_custom_element_value('post-link', $separator, '');
								$gplus_share_url = $get_link;
							}
							break;
					}
				}
				else {
					if($is_post){
						$gplus_share_url =  get_permalink( $post['ID'] );
					}
					else{
						$get_link = $this->get_custom_element_value('post-link', $separator, '');
						$gplus_share_url = $get_link;
					}
				}
				$text = '<a href="https://plus.google.com/share?url='.urlencode($gplus_share_url).'" target="_blank" rel=nofollow>'.$text.'</a>';
			break;
			case 'sharepinterest':
				$title = $excerpt = $img_url = "";
				if(isset($layer['settings']['link-type-sharepinterest'])){
					switch ($layer['settings']['link-type-sharepinterest']) {
						case 'custom':
							$pinterest_share_url = $layer['settings']['link-type-sharepinterest-custom-url'];
							break;
						case 'site':
							$pinterest_share_url = get_permalink();
							$title = get_the_title();
							$excerpt = get_the_excerpt();
							break;
						default:
							if($is_post){
								$pinterest_share_url =  get_permalink( $post['ID'] );
								$title = get_the_title($post['ID']);
								$excerpt = get_the_excerpt($post['ID']);
							}
							else{
								$get_link = $this->get_custom_element_value('post-link', $separator, '');
								$title = $this->get_custom_element_value('title', $separator, '');
								$excerpt = $this->get_custom_element_value('content', $separator, '');
								$pinterest_share_url = $get_link;
							}
							break;
					}
				}
				else {
					if($is_post){
						$pinterest_share_url =  get_permalink( $post['ID'] );
						$title = get_the_title($post['ID']);
						$excerpt = get_the_excerpt($post['ID']);
					}
					else{
						$get_link = $this->get_custom_element_value('post-link', $separator, '');
						$title = $this->get_custom_element_value('title', $separator, '');
						$excerpt = $this->get_custom_element_value('content', $separator, '');
						$pinterest_share_url = $get_link;
					}
				}
				// if featured full is available
				if(isset($this->media_sources['featured-image-full']) && !empty($this->media_sources['featured-image-full'])) {
					$img_url = $this->media_sources['featured-image-full'];
				}
				// if featured regular size is available
				else if(isset($this->media_sources['featured-image']) && !empty($this->media_sources['featured-image'])) {
					$img_url = $this->media_sources['featured-image'];
				}
				// if global image is available
				else if(!empty($this->default_image)) {
					$img_url = esc_attr($this->default_image);
				}

				$description = str_replace(array("%title%","%excerpt%"), array($title,$excerpt), $layer['settings']['link-type-sharepinterest-description']);

				$text = '<a href="https://pinterest.com/pin/create/button/?url='.urlencode($pinterest_share_url).'&media='.urlencode($img_url).'&description='.urlencode($description).'" target="_blank" rel=nofollow>'.$text.'</a>';
			break;
			case 'sharetwitter':
				$title = $excerpt = $img_url = "";
				if(isset($layer['settings']['link-type-sharetwitter'])){
					switch ($layer['settings']['link-type-sharetwitter']) {
						case 'custom':
							$twitter_share_url = $layer['settings']['link-type-sharetwitter-custom-url'];
							break;
						case 'site':
							$twitter_share_url = get_permalink();
							$title = get_the_title();
							$excerpt = get_the_excerpt();
							break;
						default:
							if($is_post){
								$twitter_share_url =  get_permalink( $post['ID'] );
								$title = get_the_title($post['ID']);
								$excerpt = get_the_excerpt($post['ID']);
							}
							else{
								$get_link = $this->get_custom_element_value('post-link', $separator, '');
								$title = $this->get_custom_element_value('title', $separator, '');
								$excerpt = $this->get_custom_element_value('content', $separator, '');
								$twitter_share_url = $get_link;
							}
							break;
					}
				}
				else{
					if($is_post){
						$twitter_share_url =  get_permalink( $post['ID'] );
						$title = get_the_title($post['ID']);
						$excerpt = get_the_excerpt($post['ID']);
					}
					else{
						$get_link = $this->get_custom_element_value('post-link', $separator, '');
						$title = $this->get_custom_element_value('title', $separator, '');
						$excerpt = $this->get_custom_element_value('content', $separator, '');
						$twitter_share_url = $get_link;
					}
				}

				if(!empty($layer['settings']['link-type-sharetwitter-text-before'])){
					$twitter_share_text_before = str_replace(array("%title%","%excerpt%"), array($title,$excerpt), $layer['settings']['link-type-sharetwitter-text-before']);
				}
				else {
					$twitter_share_text_before = "";
				}
				if(!empty($layer['settings']['link-type-sharetwitter-text-after'])){
					$twitter_share_text_after = str_replace(array("%title%","%excerpt%"), array($title,$excerpt), $layer['settings']['link-type-sharetwitter-text-after']);
				}
				else {
					$twitter_share_text_after = "";
				}
				$twitter_share_text = $twitter_share_text_before;
				$text = '<a href="https://twitter.com/intent/tweet?text='.urlencode($twitter_share_text).'&url='.$twitter_share_url.'&related=" target="_blank" rel=nofollow>'.$text.'</a>';

			break;
			case 'likepost':
				if(!empty($this->post['ID']))
					$text = '<a data-post_id="'.@$this->post['ID'].'" href="#"><span class="eg-post-like">'.$text.'</span></a>'; //javascript-link
				else $text = '';
			break;
		}

		if($link_to !== 'none') $do_display = true; //set back to true if a link is set on layer

		$text = trim($text);

		//check for special styling coming from post option and set css to the queue
		if(isset($layer['id'])) $this->set_meta_element_changes($layer['id'], $unique_class);

		if($is_post) {
			$post_class = (!isset($post['ID'])) ? '' : ' eg-post-'.$post['ID'];
		}
		else {
			$post_class = isset($this->post['post_id']) && !empty($this->post['post_id']) ? ' eg-post-'.$this->post['post_id'] : '';
		}

		if($base->text_has_certain_tag($text, 'a') && !$do_ignore_styles){ //check if a tag exists, if yes, class will be set to a tags and not the wrapping div, also the div will receive the position and other stylings // && @$layer['settings']['source'] !== 'text'
			if($is_woo_cats && strpos($text, 'class="') !== false || $is_woo_button || $is_filter_cat && strpos($text, 'class="') !== false){ //add to the classes instead of creating own class attribute if it is woocommerce cats AND a class can be found
				$text = str_replace('class="', 'class="'.$unique_class.$post_class.$lb_class.' ', $text);
			}elseif($is_html_source && strpos($text, 'class="') !== false){
				$text = str_replace('<a', '<a class="'.$unique_class.$post_class.$lb_class.'"', $text);
			}else{
				$text = str_replace('<a', '<a class="'.$unique_class.$post_class.$lb_class.'"', $text);
			}

			/* 2.2 */
			// if(!empty($lb_class)) $text = str_replace('</a>', '<img class="esg-lb-dummy" src="'. EG_PLUGIN_URL .'public/assets/images/300x200transparent.png"></a>', $text);

			//moved to more global css generation process @version: 2.0
			//$this->add_css_wrap[$unique_class]['a']['display'] = $do_display; //do_display defines if we should write display: block;
			//$this->add_css_wrap[$unique_class]['a']['full'] = $do_full; //do full styles (for categories and tags separator)
			$unique_class .= '-a';
		}

		if($do_ignore_styles) $unique_class = 'eg-'.esc_attr($this->handle).'-nostyle-element-'.$layer['id'];

		//replace all the normal shortcodes
		if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate
			$text = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
		}elseif(function_exists('ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate plus
			$text = ppqtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
		}elseif(function_exists('qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage')){ //use qTranslate X
			$text = qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
		}
		$text = do_shortcode($text);

		if($special_item == 'true' && $special_item_type == 'line-break'){ //line break element
			echo '              <div class="esg-'.$class.' '.$unique_class.' esg-none esg-clear" style="height: 5px; visibility: hidden;"></div>'."\n";
		}elseif(trim($text) !== ''){ //}elseif(!empty($text)){

			$use_tag = $base->getVar($layer, array('settings', 'tag-type'), 'div');
			echo '				<'.$use_tag.' class="esg-'.$class.$post_class.$video_play.$ajax_class.' '.$hideunderClass.$unique_class.$transition.'"'.$ajax_attr.$transition_split.$delay.$duration.$hideunderHTML;
			echo ($demo == 'custom') ? $demo_element_type : '';
			echo $data_transition_transition . '>';

			echo $text;

			echo '</'.$use_tag.'>'."\n";
		}

	}


	/**
	 * Retrieve the value of post elements
	 */
	public function get_post_value($handle, $separator, $function, $meta, $catmax = '-1', $taxonomy = ""){

		$base = new Essential_Grid_Base();

		$text = '';

		/* 2.1.5 category max option */
		$adjustMax = false;

		if( in_array( $handle, array( 'cat_list','tag_list','taxonomy') ) )  {
			if(!empty($catmax) && $catmax !== '-1' && is_numeric($catmax) && intval($catmax) > 0) {
				$catmax = intval($catmax);
				$adjustMax = true;
			}
		}

		switch($handle){
			//Post elements
			case 'post_id':
				$text = $base->getVar($this->post, 'ID', '');
				break;
			case 'post_url':
				$post_id = $base->getVar($this->post, 'ID', '');
				$text = get_permalink($post_id);
				break;
			case 'title':
				$text = $base->getVar($this->post, 'post_title', '');
				break;
			case 'caption':
			case 'excerpt':
				$text = trim($base->getVar($this->post, 'post_excerpt'));
				if(empty($text)){
					//strip essential grid shortcode here
					$text = do_shortcode($base->strip_essential_shortcode($base->getVar($this->post, 'post_content')));
					$text = preg_replace("/<style\\b[^>]*>(.*?)<\\/style>/s", "", $text);
					$text = preg_replace("/<script\\b[^>]*>(.*?)<\\/script>/s", "", $text);
				}

				$text = strip_tags($text); //,"<b><br><br/><i><strong><small>"
				break;
			case 'meta':
				$m = new Essential_Grid_Meta();
				$text = $m->get_meta_value_by_handle($base->getVar($this->post, 'ID', ''),$meta);
				break;
			case 'likespost':
				$post_id = $base->getVar($this->post, 'ID', '');
				if(!empty($post_id)){
					$count = get_post_meta($post_id, "eg_votes_count", 0);
					if(!$count) $count[0] = 0;
					if(is_array($count)){
						$text = '<span class="eg-post-count">'.$count[0].'</span>';
					}
				}
				else{
					$text = '';
				}
				break;
			case 'alias':
				$text = $base->getVar($this->post, 'post_name');
				break;
			case 'description':
			case 'content':
				$text = apply_filters('the_content', $base->getVar($this->post, 'post_content'));
				break;
			case 'link':
				$text = get_permalink($base->getVar($this->post, 'ID', ''));
				break;
			case 'date':
				$postDate = $base->getVar($this->post, "post_date_gmt");
				$text = $base->convert_post_date($postDate);
				break;
			case 'date_day':
				$postDate = $base->getVar($this->post, "post_date_gmt");
				$text = date('d',strtotime($postDate));
				break;
			case 'date_month':
				$postDate = $base->getVar($this->post, "post_date_gmt");
				$text = date('m',strtotime($postDate));
				break;
			case 'date_month_abbr':
				$postDate = $base->getVar($this->post, "post_date_gmt");
				$text = date('M',strtotime($postDate));
				break;
				case 'date_month_name':
					$postDate = $base->getVar($this->post, "post_date_gmt");
					$text = date('F',strtotime($postDate));
					break;
			case 'date_year':
				$postDate = $base->getVar($this->post, "post_date_gmt");
				$text = date('Y',strtotime($postDate));
				break;
			case 'date_year_abbr':
				$postDate = $base->getVar($this->post, "post_date_gmt");
				$text = date('y',strtotime($postDate));
				break;
			case 'date_modified':
				$dateModified = $base->getVar($this->post, "post_modified");
				$text = $base->convert_post_date($dateModified);
				break;
			case 'author_name':
				$authorID = $base->getVar($this->post, 'post_author');
				$text = get_the_author_meta('display_name', $authorID);
				break;
			case 'author_posts':
				$authorID = $base->getVar($this->post, 'post_author');
				$text = get_author_posts_url($authorID );
				break;
			case 'author_profile':
				$authorID = $base->getVar($this->post, 'post_author');
				$meta_value =  get_the_author_meta('url', $authorID);
				break;
			case 'author_avatar_32':
				$authorID = $base->getVar($this->post, 'post_author');
				$meta_value =  get_avatar( $authorID, 32);
				break;
			case 'author_avatar_64':
				$authorID = $base->getVar($this->post, 'post_author');
				$meta_value =  get_avatar( $authorID, 64);
				break;
			case 'author_avatar_96':
				$authorID = $base->getVar($this->post, 'post_author');
				$meta_value =  get_avatar( $authorID, 96);
				break;
			case 'author_avatar_512':
				$authorID = $base->getVar($this->post, 'post_author');
				$meta_value =  get_avatar( $authorID, 512);
				break;
			case 'num_comments':
				$text = $base->getVar($this->post, 'comment_count');
				break;
			case 'cat_list':
				$use_taxonomies = false;
				$postCatsIDs = $base->getVar($this->post, 'post_category');
				if(empty($postCatsIDs) && isset($this->post['post_type'])){
					$postCatsIDs = array();
					$obj = get_object_taxonomies($this->post['post_type']);
					if(!empty($obj) && is_array($obj)){
						foreach($obj as $tax){
							if($tax == 'post_tag') continue;

							$use_taxonomies[] = $tax;
							$new_terms = get_the_terms($base->getVar($this->post, 'ID', ''), $tax);
							if(is_array($new_terms) && !empty($new_terms)){
								foreach($new_terms as $term){
									$postCatsIDs[$term->term_id] = $term->term_id;
								}
							}
						}
					}
				}

				/* 2.1.5 category max option */
				if($adjustMax && is_array($postCatsIDs)) $postCatsIDs = array_slice($postCatsIDs, 0, $catmax, true);

				$text = $base->get_categories_html_list($postCatsIDs, $function, $separator, $use_taxonomies);
				break;
			case 'tag_list':
				if(!$adjustMax) {
					$text = $base->get_tags_html_list($base->getVar($this->post, 'ID', ''), $separator, $function);
				}
				else {
					$text = $base->get_tags_html_list($base->getVar($this->post, 'ID', ''), $separator, $function, $catmax);
				}
				break;
			case 'taxonomy':
				if(!$adjustMax) {
					$text = $base->get_tax_html_list($base->getVar($this->post, 'ID', ''), $taxonomy, $separator,  $function);
				}
				else {
					$text = $base->get_tax_html_list($base->getVar($this->post, 'ID', ''), $taxonomy, $separator, $function, $catmax);
				}

				if(is_array($text)) $text = implode($separator,$text);

				break;
			case 'alternate-image':
				$source = get_post_meta($base->getVar($this->post, 'ID', ''), 'eg_sources_image', true);
				$source = wp_get_attachment_image_src(esc_attr($source), 'full');
				$source = ($source !== false && isset($source['0'])) ? $source['0'] : '';
				$text = (!empty($source)) ? '<img src="'.$source.'" />' : '';
				break;

			/*
			case 'iframe':
				print '<h1>HELLO!</h1>';
				die();
				break;
			*/

			default:
				$text = apply_filters('essgrid_post_meta_content', $text, $handle, $base->getVar($this->post, 'ID', ''), $this->post);
			break;
		}

		return $text;
	}


	/**
	 * Retrieve the value of post elements
	 */
	public function get_custom_element_value($handle, $separator, $meta = ''){
		$base = new Essential_Grid_Base();
		$m = new Essential_Grid_Meta();

		$text = '';
		$text = $base->getVar($this->layer_values, $handle, '');

		if($text == '' && $meta != '')
			$text = $base->getVar($this->layer_values, $meta, '');

		if(intval($text) > 0){ //we may be an image from the metas
			$custom_meta = $m->get_all_meta(false);
			if(!empty($custom_meta)){
				foreach($custom_meta as $cmeta){
					if($cmeta['handle'] == $handle){
						if($cmeta['type'] == 'image'){
							$img = wp_get_attachment_image_src($text, $this->media_sources_type);
							if($img !== false){
								$text = $img[0]; //replace with URL
							}
						}
						break;
					}
				}
			}
		}

		return $text;
	}


	/**
	 * Retrieve the value of event elements
	 */
	public function get_event_manager_value($handle){
		$base = new Essential_Grid_Base();

		$text = '';

		switch($handle){
			//check for event manager
			case 'event_start_date':
				break;
			case 'event_end_date':
				break;
			case 'event_start_time':
				break;
			case 'event_end_time':
				break;
			case 'event_event_id':
				break;
			case 'event_location_name':
				break;
			case 'event_location_slug':
				break;
			case 'event_location_address':
				break;
			case 'event_location_town':
				break;
			case 'event_location_state':
				break;
			case 'event_location_postcode':
				break;
			case 'event_location_region':
				break;
			case 'event_location_country':
				break;
		}

		return $text;
	}


	/**
	 * Retrieve the value of woocommerce elements
	 */
	public function get_woocommerce_value($meta, $separator, $catmax = false){
		$text = '';

		if(isset($this->post['ID'])){
			if(Essential_Grid_Woocommerce::is_woo_exists()){
				$base = new Essential_Grid_Base();
				$m = new Essential_Grid_Meta();

				/* 2.1.5 category max option */
				$adjustMax = false;
				if($meta === 'wc_categories') {
					if(!empty($catmax) && $catmax !== '-1' && is_numeric($catmax) && intval($catmax) > 0) {
						$catmax = intval($catmax);
						$adjustMax = true;
					}
				}

				if($adjustMax) {
					$text = Essential_Grid_Woocommerce::get_value_by_meta($this->post['ID'], $meta, $separator, $catmax);
				}
				else {
					$text = Essential_Grid_Woocommerce::get_value_by_meta($this->post['ID'], $meta, $separator);
				}
			}
		}
		return $text;
	}

}
