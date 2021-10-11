<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/essential/
 * @copyright 2018 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Library {
	private $library_list		 = 'essential-grid/get-list.php';
	private $library_dl			 = 'essential-grid/download.php';
	private $library_server_path = '/essential-grid/images/';
	private $library_path		 = '/essential-grid/templates/';
	private $library_path_plugin = 'admin/assets/imports/';
	private $curl_check			 = null;
	
	const SHOP_VERSION			 = '1.0.0';
	
	/**
	 * Download template by UID (also validates if download is legal)
	 * @since: 2.3
	 */
	public function _download_template($uid){
		global $wp_version, $esglb;
		
		$return	= false;
		$uid	= esc_attr($uid);
		
		
		$code	= (get_option('tp_eg_valid', 'false') == 'false') ? '' : get_option('tp_eg_code', '');
		
		$upload_dir = wp_upload_dir(); // Set upload folder
		// Check folder permission and define file location
		if(wp_mkdir_p( $upload_dir['basedir'].$this->library_path ) ) { //check here to not flood the server
			$done	= false;
			$count	= 0;
			do{	
				$url		= $esglb->get_url('templates');
				$request	= wp_remote_post($url.'/'.$this->library_dl, array(
					'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
					'body' => array(
						'code'			=> urlencode($code),
						'shop_version'	=> urlencode(self::SHOP_VERSION),
						'version'		=> urlencode(Essential_Grid::VERSION),
						'uid'			=> urlencode($uid),
						'product'		=> urlencode('essential-grid')
					),
					'timeout' => 45
				));
				
				$response_code = wp_remote_retrieve_response_code( $request );
				if($response_code == 200){
					$done = true;
				}else{
					$esglb->move_server_list();
				}
				
				$count++;
			}while($done == false && $count < 5);

			if(!is_wp_error($request)) {
				if($response = $request['body']) {
					if($response !== 'invalid'){
						//add stream as a zip file
						$file = $upload_dir['basedir']. $this->library_path . '/' . $uid .'.zip';
						@mkdir(dirname($file));
						$ret = @file_put_contents( $file, $response );
						if($ret !== false){
							//return $file so it can be processed. We have now downloaded it into a zip file
							$return = $file;
						}else{//else, print that file could not be written
							$return = array('error' => __('Can\'t write the file into the uploads folder of WordPress, please change permissions and try again!', EG_TEXTDOMAIN));
						}
					}else{
						$return = array('error' => __('Purchase Code is invalid', EG_TEXTDOMAIN));
					}
				}
			}//else, check for error and print it to customer
		}else{
			$return = array('error' => __('Can\'t write into the uploads folder of WordPress, please change permissions and try again!', EG_TEXTDOMAIN));
		}
		return $return;
	}
	
	
	/**
	 * Delete the Template file
	 * @since: 2.3
	 */
	public function _delete_template($uid){
		$uid = esc_attr($uid);
		
		$upload_dir = wp_upload_dir(); // Set upload folder
		
		// Check folder permission and define file location
		if( wp_mkdir_p( $upload_dir['basedir'].$this->library_path ) ) {
			$file = $upload_dir['basedir']. $this->library_path . '/' . $uid.'.zip';
			
			if(file_exists($file)){
				//delete file
				return unlink($file);
			}
		}
		
		return false;
	}
	
	
	/**
	 * Get the Templatelist from servers
	 * @since: 5.0.5
	 */
	public function _get_template_list($force = false){
		global $wp_version, $esglb;
		
		$last_check	= get_option('tp_eg-templates-check');
		
		if($last_check == false){ //first time called
			$last_check = 172801;
			update_option('tp_eg-templates-check',  time());
		}
		
		// Get latest Templates
		if(time() - $last_check > 345600 || $force == true){ //4 days
			
			update_option('tp_eg-templates-check',  time());
			
			$code	= (get_option('tp_eg_valid', 'false') == 'false') ? '' : get_option('tp_eg_code', '');
			$done	= false;
			$count	= 0;
			do{	
				$url		= $esglb->get_url('templates');
				
				$request	= wp_remote_post($url.'/'.$this->library_list, array(
					'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
					'body' => array(
						'code'			=> urlencode($code),
						'shop_version'	=> urlencode(self::SHOP_VERSION),
						'version'		=> urlencode(Essential_Grid::VERSION),
						'product'		=> urlencode('essential-grid')
					)
				));
				
				$response_code = wp_remote_retrieve_response_code( $request );

				if($response_code == 200){
					$done = true;
				}else{
					$esglb->move_server_list();
				}
				
				$count++;
			}while($done == false && $count < 5);
			
			if(!is_wp_error($request)) {
				if($response = maybe_unserialize($request['body'])) {
					$templates = json_decode($response, true);
					
					if(is_array($templates)) {
						update_option('tp_eg-templates-new', $templates, false);
					}
				}
			}
			$this->update_template_list();
		}
	}
	
	
	/**
	 * Update the Templatelist, move tp_eg-templates-new into tp_eg-templates
	 * @since: 2.3
	 */
	private function update_template_list(){
		$new = get_option('tp_eg-templates-new', false);
		$cur = get_option('tp_eg-templates', array());
		$cur = array();

		
		if($new !== false && !empty($new) && is_array($new)){
			if(empty($cur)){
				$cur = $new;
			}else{
				if(isset($new['grids']) && is_array($new['grids'])){
					foreach($new['grids'] as $n){
						$found = false;
						if(isset($cur['grids']) && is_array($cur['grids'])){
							foreach($cur['grids'] as $ck => $c){
								if($c['uid'] == $n['uid']){
									if(version_compare($c['version'], $n['version'], '<')){
										$n['is_new'] = true;
										$n['push_image'] = true; //push to get new image and replace
									}
									if(isset($c['is_new'])) $n['is_new'] = true; //is_new will stay until update is done
									
									$n['exists'] = true; //if this flag is not set here, the template will be removed from the list
									
									if(isset($n['new_grid'])){
										unset($n['new_grid']); //remove this again, as the new flag should be removed now
									}
									
									$cur['grids'][$ck] = $n;
									$found = true;
									
									break;
								}
							}
						}
						
						if(!$found){
							$n['exists'] = true;
							$n['new_grid'] = true;
							$cur['grids'][] = $n;
						}
						
					}
					
					foreach($cur['grids'] as $ck => $c){ //remove no longer available grids
						if(!isset($c['exists'])){
							unset($cur['grids'][$ck]);
						}else{
							unset($cur['grids'][$ck]['exists']);
						}
					}
					
				}
			}
			
			update_option('tp_eg-templates', $cur, false);
			update_option('tp_eg-templates-new', false, false);
			
			$this->_update_images();
		}
	}
	
	/**
	 * Remove the is_new attribute which shows the "update available" button
	 * @since: 2.3
	 */
	public function remove_is_new($uid){
		$cur = get_option('tp_eg-templates', array());
		
		if(isset($cur['grids']) && is_array($cur['grids'])){
			foreach($cur['grids'] as $ck => $c){
				if($c['uid'] == $uid){
					unset($cur['grids'][$ck]['is_new']);
					break;
				}
			}
		}
		
		update_option('tp_eg-templates', $cur, false);
	}
	
	
	/**
	 * Update the Images get them from Server and check for existance on each image
	 * @since: 2.3
	 */
	private function _update_images(){
		global $wp_version, $esglb;
		
		$templates	= get_option('tp_eg-templates', array());
		$chk		= $this->check_curl_connection();
		$curl		= ($chk) ? new WP_Http_Curl() : false;
		$url		= $esglb->get_url('templates');
		
		$connection = 0;
		
		$reload = array();
		if(!empty($templates) && is_array($templates)){
			$upload_dir = wp_upload_dir(); // Set upload folder
			if(!empty($templates['grids']) && is_array($templates['grids'])){
				foreach($templates['grids'] as $key => $temp){
					
					if($connection > 3) continue; //cant connect to server
						
					// Check folder permission and define file location
					if( wp_mkdir_p( $upload_dir['basedir'].$this->library_path ) ) {
						$file = $upload_dir['basedir'] . $this->library_path . '/' . $temp['img'];
						$file_plugin = EG_PLUGIN_PATH . $this->library_path_plugin . '/' . $temp['img'];
						
						if((!file_exists($file) && !file_exists($file_plugin)) || isset($temp['push_image'])){
							if($curl !== false){
								$done	= false;
								$count	= 0;
								$args	= array('user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url').' - '.$count);
								
								do{
									$image_data = @$curl->request($url.'/'.$this->library_server_path.$temp['img'], $args); // Get image data
									if(!is_wp_error($image_data) && isset($image_data['body']) && isset($image_data['response']) && isset($image_data['response']['code']) && $image_data['response']['code'] == '200'){
										$image_data = $image_data['body'];
										$done = true;
									}else{
										$image_data = false;
										$esglb->move_server_list();
										$url = $esglb->get_url('templates');
									}
									$count++;
								}while($done == false && $count < 5);
							}else{
								$count = 0;
								$options = array(
									'http'=>array(
										'method' => 'GET',
										'header' => "Accept-language: en\r\n" .
										"Cookie: foo=bar\r\n" .
										'User-Agent: WordPress/'.$wp_version.'; '.get_bloginfo('url').' - fgc - '.$count."\r\n"
									)
								);
								$context = stream_context_create($options);
								do{
									//$image_data = @file_get_contents($url.'/'.$this->library_server_path.$temp['img']); // Get image data
									$image_data = @file_get_contents($url.'/'.$this->library_server_path.$temp['img'], false, $context); // Get image data
									if($image_data == false){
										$esglb->move_server_list();
										$url = $esglb->get_url('templates');
									}
									$count++;
								}while($image_data == false && $count < 5);
							}
							if($image_data !== false){
								$reload[$temp['alias']] = true;
								unset($templates['grids'][$key]['push_image']);
								@mkdir(dirname($file));
								@file_put_contents( $file, $image_data );
							}else{//could not connect to server
								$connection++;
							}
						}else{//use default image
						}
					}else{//use default images
					}
				}
			}
		}
		
		if($connection > 3){
			//set value that the server cant be contacted
		}
		
		update_option('tp_eg-templates', $templates, false); //remove the push_image
	}
	
	
	/**
	 * get default ThemePunch default Grids
	 * @since: 2.3
	 */
	public function get_tp_template_grids(){
		global $wpdb;
		
		$grids		= array();
		$defaults	= get_option('tp_eg-templates', array());
		$defaults	= (isset($defaults['grids'])) ? $defaults['grids'] : array();
		
		krsort($defaults);
		
		return $defaults;
	}
	
	
	/**
	 * Get the HTML for all Library Grids
	 */
	public function get_library_grids_html($tp_grids){
		//$base = new Essential_Grid_Base();
		//$base->getVar($skin, array('params', 'full-border-radius')); //i.e.
		?>
		<div id="library_bigoverlay"></div>
		<?php
		if(!empty($tp_grids)){
			foreach($tp_grids as $isd => $grid){
				$isnew = false;
				if(!empty($grid['filter']) && is_array($grid['filter'])){
					foreach($grid['filter'] as $f => $v){
						if($v==='newupdate') $isnew = true;
						$grid['filter'][$f] = ' temp_'.$v;						
					}
				}
			
				
				$esg_cats		= array('template_premium');
				$etikett_a		= __('Premium', EG_TEXTDOMAIN);
			//	$isnew			= is_array($grid['filter']) && in_array("temp_newupdate",$grid['filter']) ? true : false;
				if($isnew){
					$esg_cats[] = 'temp_newupdate';
				}
				?>
				<div class="esg_group_wrappers <?php echo implode(' ', $esg_cats); ?> not-imported-wrapper <?php if(isset($grid['filter'])){ echo implode(' ', $grid['filter']); } ?>">
					<?php
					$this->write_import_template_markup($grid); //add the Slider ID as we want to add a Slider and no Slide
					?>
					<!--div class="library_meta_line">
						<?php if ($isnew) { ?>
							<span class="library_new"><?php _e("New", EG_TEXTDOMAIN); ?></span>
							<?php } ?>
						<span class="<?php echo implode(' ', $esg_cats); ?>"><?php echo $etikett_a; ?></span>
					</div-->
					<div class="library_thumb_title"><?php echo $grid['title']; ?>
						<?php if ($isnew) { ?>
							<span class="library_new esg_library_filter_button esg_libr_new_udpated"><?php _e("New", EG_TEXTDOMAIN); ?></span>
						<?php } ?>	
					</div>
				</div>
				<?php
			}
		}else{
			echo '<span style="color: #F00; font-size: 20px">';
			_e('No data could be retrieved from the servers. Please make sure that your website can connect to the themepunch servers.', EG_TEXTDOMAIN);
			echo '</span>';
		}
		?>
		<div style="clear:both;width:100%"></div>
		<?php
	}
	
	
	/**
	 * output markup for the import grid, the zip was not yet improted
	 * @since: 2.3
	 */
	public function write_import_template_markup($grid){
		$allow_install = true;
		
		$grid['img'] = $this->_check_file_path($grid['img'], true);
		if($grid['img'] == ''){
			//set default image
		}
		
		//check for version and compare, only allow download if version is high enough
		$deny = '';
		if(isset($grid['required'])){
			if(version_compare(Essential_Grid::VERSION, $grid['required'], '<')){
				$deny = ' deny_download';
			}
		}
		?>		
		<div data-src="<?php echo $grid['img'] . "?time=".time(); ?>" class="library_item_import library_item"
			data-zipname="<?php echo $grid['zip']; ?>"
			data-uid="<?php echo $grid['uid']; ?>"
			data-title="<?php echo esc_html($grid['title']); ?>"
			<?php
			if($deny !== ''){ //add needed version number here 
				?>
				data-versionneed="<?php echo $grid['required']; ?>"
				<?php
			}
			?>
			>
			<div class="library_thumb_overview"></div>
			<div class="library_preview_add_wrapper">
				<?php if(isset($grid['preview']) && $grid['preview'] !== ''){ ?>
				<a class="preview_library_grid" href="<?php echo esc_attr($grid['preview']); ?>" target="_blank"><i class="eg-icon-search"></i></a>
				<?php } ?>
				<span class="show_more_library_grid"><i class="eg-icon-plus"></i></span>
				<span class="library_group_opener"><i class="fa-icon-folder"></i></span>
			</div>
		</div>

		<div class="library_thumb_more">
			<span class="ttm_label"><?php echo $grid['title'];?></span>
			<?php
			if(isset($grid['description'])){
				echo $grid['description'];
			}
			if(isset($grid['setup_notes']) && !empty($grid['setup_notes'])){
				?>
				<span class="ttm_space"></span>
				<span class="ttm_label"><?php _e('Setup Notes', EG_TEXTDOMAIN); ?></span>
				<?php
				echo $grid['setup_notes'];
				?>
				<?php
			}
			?>
			<span class="ttm_space"></span>
			<span class="ttm_label"><?php _e('Requirements', EG_TEXTDOMAIN); ?></span>
			<ul class="ttm_requirements">
				<li><?php
				if(version_compare(Essential_Grid::VERSION, $grid['required'], '>=')){
					?><i class="eg-icon-check"></i><?php
				}else{
					?><i class="eg-icon-cancel"></i><?php
					$allow_install = false;
				}				
				_e('Essential Grid Version', EG_TEXTDOMAIN);
				echo ' '.$grid['required'];
				?></li>
			</ul>		
			<span class="ttm_space"></span>
			<span class="ttm_label_direct"><?php _e('Available Version', EG_TEXTDOMAIN); ?></span>
			<span class="ttm_label_half ttm_available"><?php echo $grid['version'];?></span>
			<span class="ttm_space"></span>
			<?php
			if($deny == '' && $allow_install == true){
				?>
				<div class="install_library_grid<?php echo $deny; ?>" data-zipname="<?php echo $grid['zip']; ?>" data-uid="<?php echo $grid['uid']; ?>" data-title="<?php echo esc_html($grid['title']); ?>"><i class="eg-icon-download"></i><?php _e('Install Grid', EG_TEXTDOMAIN); ?></div>
				<?php
			}else{
				?>
				<div class="dontadd_library_grid_item"><i class="icon-not-registered"></i><?php _e('Requirements not met', EG_TEXTDOMAIN); ?></div>
				<?php
			}
			?>
			<span class="tp-clearfix" style="margin-bottom:5px"></span>
		</div>
		<?php
	}
	
	
	/**
	 * check if image was uploaded, if yes, return path or url
	 * @since: 2.3
	 */
	public function _check_file_path($image, $url = false){
		$upload_dir		= wp_upload_dir(); // Set upload folder
		$file			= $upload_dir['basedir'] . $this->library_path . $image;
		$file_plugin	= EG_PLUGIN_PATH . $this->library_path_plugin . $image;
		
		if(file_exists($file)){ //downloaded image first, for update reasons
			if($url){
				$image = $upload_dir['baseurl'] . $this->library_path . $image;
			}else{
				$image = $upload_dir['basedir'] . $this->library_path . $image; //server path
			}
		}elseif(file_exists($file_plugin)){
			if($url){
				$image = EG_PLUGIN_PATH . $this->library_path_plugin . $image;
			}else{
				$image = EG_PLUGIN_PATH . $this->library_path_plugin . $image;
			}
		}else{
			//redownload image from server and store it
			$this->_update_images();
			if(file_exists($file)){ //downloaded image first, for update reasons
				if($url){
					$image = $upload_dir['baseurl'] . $this->library_path . $image;
				}else{
					$image = $upload_dir['basedir'] . $this->library_path . $image; //server path
				}
			}else{
				$image = false;
			}
		}
		
		return $image;
	}
	
	
	/**
	 * import Grid from TP servers
	 * @since: 2.3
	 */
	public function import_grid($uid, $zip, $ignore_exists = false){
		$added	= array();
		$return = array();
		
		if($uid == ''){
			return __("ID missing, something went wrong. Please try again!", EG_TEXTDOMAIN);
		}else{
			$uids	= (array)$uid;

			if(!empty($uids)){
				foreach($uids as $uid){
					set_time_limit(60); //reset the time limit
					
			
					$filepath = $this->_download_template($uid); //can be single or multiple
					//send request to TP server and download file
					if(is_array($filepath) && isset($filepath['error'])){
						return $filepath['error'];
						break;
					}

					
					
					if($filepath !== false){
						//pull the content from the filepath
						$upload_dir	= wp_upload_dir();
						$rem_path	= $upload_dir['basedir'].'/esgtemp/';
						$d_path		= $rem_path;
						$content	= '';
						
						WP_Filesystem();
			
						global $wp_filesystem;

						$unzipfile = unzip_file($filepath, $d_path);

						if(is_wp_error($unzipfile)){
							define('FS_METHOD', 'direct'); //lets try direct. 
							
							WP_Filesystem();  //WP_Filesystem() needs to be called again since now we use direct !
							
							$unzipfile = unzip_file($filepath, $d_path);
							if(is_wp_error($unzipfile)){
								$d_path		= EG_PLUGIN_PATH.'esgtemp/';
								$rem_path	= $d_path;
								$unzipfile	= unzip_file($filepath, $d_path);
								
								if(is_wp_error($unzipfile)){
									$f = basename($filepath);
									$d_path = str_replace($f, '', $filepath);
									
									$unzipfile = unzip_file($filepath, $d_path);
								}
							}
						}
						
						
						$this->_delete_template($uid);
						
						if(!is_wp_error($unzipfile)){
							$content = ($wp_filesystem->exists($d_path.'ess_grid.json')) ? $wp_filesystem->get_contents($d_path.'ess_grid.json') : '';
						}

						
						$content = json_decode($content, true);

						// import custom images
						$content = $this->import_custom_images($content,$d_path);

						$wp_filesystem->delete($rem_path, true);
						if(is_array($content)){
							$im			= new Essential_Grid_Import();
							$skins		= (isset($content['skins'])) ? $content['skins'] : array();
							$skins_ids	= array();
							if(!empty($skins)){
								foreach($skins as $skin){
									$skins_ids[] = $skin['id'];
								}
								$return['skins_imported'] = $im->import_skins($skins, $skins_ids, true, $ignore_exists);
							}
							
							$navigation_skins		= (isset($content['navigation-skins'])) ? $content['navigation-skins'] : array();
							$navigation_skins_ids	= array();
							if(!empty($navigation_skins)){
								foreach($navigation_skins as $skin){
									$navigation_skins_ids[] = $skin['id'];
								}
								$return['navigation_skins_imported'] = $im->import_navigation_skins(@$navigation_skins, $navigation_skins_ids, true, $ignore_exists);
							}

							if(!empty($content['punch-fonts'])){
								$return['custom_fonts_imported'] = $im->import_punch_fonts($content['punch-fonts']);
							}
							
							$grids		= (isset($content['grids'])) ? $content['grids'] : array();
							$grids_ids	= array();
							if(!empty($grids)){
								foreach($grids as $grid){
									$grids_ids[] = $grid['id'];
								}
								$return['grids_imported'] = $im->import_grids($grids, $grids_ids);
							}
							
							$elements		= (isset($content['elements'])) ? $content['elements'] : array();
							$elements_ids	= array();
							if(!empty($elements)){
								foreach($elements as $element){
									$elements_ids[] = $element['id'];
								}
								$return['elements_imported'] = $im->import_elements(@$elements, $elements_ids);
							}
							
							$custom_metas	 = (isset($content['custom-meta'])) ? $content['custom-meta'] : array();
							if(!empty($custom_metas) && is_array($custom_metas)){
								foreach($custom_metas as $key => $custom_meta){
									$custom_metas[$key] = $custom_meta;
								}
								if(!empty($custom_metas)){
									$custom_metas_imported = $im->import_custom_meta($custom_metas);
								}
							}
							
							$global_css							= (isset($content['global-css'])) ? $content['global-css'] : '';
							$return['global_styles_imported']	= $im->import_global_styles($global_css);
						}else{
							return __("Could not download Grid. Please try again later!", EG_TEXTDOMAIN);
						}
					}else{
						return (is_array($filepath)) ? $filepath['error'] : __("Could not download from server. Please try again later!", EG_TEXTDOMAIN);
					}
				}
			}else{
				return __("Could not download Grid. Please try again later!", EG_TEXTDOMAIN);
			}
		}
		
		return $return;
	}
	
	
	/**
	 * Check if Curl can be used
	 */
	public function check_curl_connection(){
		
		if($this->curl_check !== null) return $this->curl_check;
		
		$curl = new WP_Http_Curl();
		
		$this->curl_check = $curl->test();
		
		return $this->curl_check;
	}

	// read the json import file
    public function import_custom_images($json,$path){
		//search for the layers part
		$grids = $json["grids"];
		$new_grids = array();
		if(is_array($grids)){
			foreach($grids as $grid){
				$layers = json_decode($grid["layers"]);
				//find the image ids
				$new_layers = array();
				if(is_array($layers)){
					foreach ($layers as $layer){
						$layer = json_decode($layer);
						if( isset($layer->{'custom-type'}) &&  $layer->{'custom-type'}=="image"){
							$custom_image = $path.$layer->{'custom-image'}.".jpg";
							//import the image and replace the id
							$layer->{'custom-image'} = "".$this->create_image($custom_image);
							if(!empty($layer->{'eg-alternate-image'})){
								$alternate_image = $path.$layer->{'eg-alternate-image'}.".jpg";
								//import the image and replace the id
								$layer->{'eg-alternate-image'} = "".$this->create_image($alternate_image);
							}
						}
						$new_layers[] = json_encode($layer);
					}
				}	
				$grid["layers"] = json_encode($new_layers) ;
				$new_grids[] = $grid; 
			}
		}
		$json["grids"] = $new_grids;
		
        return $json;
    }

    public function create_image($file){
        if(empty($file)) return false;
		set_time_limit(60); //reset the time limit
		
        $upload_dir = wp_upload_dir();
        $image_url = $file;
        $image_data = file_get_contents($image_url);
        $filename = basename($image_url);
        if(wp_mkdir_p($upload_dir['path']))
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);
        
        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
		);
		
        $attach_id = wp_insert_attachment( $attachment, $file );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
	   
		return $attach_id;
    }
}
?>