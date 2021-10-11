<?php
class CCPS_Common {
  // static $default_coinmarketcap_api_key = '6871e28a-4ba4-44ee-904d-8e84c4a648e3';
  static $default_coinmarketcap_api_key = '9a1867d4-66d6-45a8-b155-64931b133a58';
  static $default_coingecko_api_key = '9a1867d4-66d6-45a8-b155-64931b133a58';

  public static function cp_enqueue_styles(){
    wp_enqueue_style('cp-base', CCPS_URL.'css/cp_base.css');

    $default_css = get_option('cryptocurrency-prices-default-css'); 
    wp_register_style('cp-'.$default_css, CCPS_URL.'css/cp_'.$default_css.'.css');
    wp_enqueue_style('cp-'.$default_css);
  }

  public static function cp_enqueue_admin_styles(){
    wp_enqueue_style('cp-admin', CCPS_URL.'css/cp_admin.css');
  }
  
  public static function cp_custom_styles(){
    if (get_option('cryptocurrency-prices-css') and get_option('cryptocurrency-prices-css')!=''){
      echo '
        <style type="text/css">
          '.esc_html(get_option('cryptocurrency-prices-css')).'
        </style>
      ';
    }
  }
  
  public static function cp_load_textdomain() {
    load_plugin_textdomain( 'cryprocurrency-prices', false, dirname( plugin_basename(__FILE__) ).'/../languages/' );
  }

  public static function cp_load_scripts($type = '') {
    switch($type){
      case 'datatable':
        wp_enqueue_style('datatables-css', CCPS_URL . 'js/datatables/datatables.min.css');
        wp_enqueue_script( 'datatables-js', CCPS_URL . 'js/datatables/datatables.min.js');
        wp_enqueue_style( 'datatables-responsive-css', CCPS_URL . 'js/datatables/responsive.dataTables.min.css');
        wp_enqueue_script( 'datatables-responsive-js', CCPS_URL . 'js/datatables/dataTables.responsive.min.js');
        break;
      case 'lazy':
        wp_enqueue_script( 'jquery-lazy', CCPS_URL . 'js/jquery.lazy.min.js');
        break;     
      default:
        wp_enqueue_script( 'jquery' );
        if (get_option('cryptocurrency-payment-site-key') && get_option('cryptocurrency-payment-site-key') != '' && get_option('cryptocurrency-payment-secret-key') && get_option('cryptocurrency-payment-secret-key') != '') {
          wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js' );
        }        
        break;
    }
  }
  
  public static function cp_widgets_init(){
    register_widget('CCPS_Shortcode_Widget');
    register_widget('CCPS_Ticker_Widget');
  }
  
  public static function cp_plugin_activate() {
    //handle plugin activation
    
    //set default css option 
    update_option('cryptocurrency-prices-default-css', 'light');
  }

  public static function cp_get_coinmarketcap_api_key() {
    $api_key = get_option( 'cp_coinmarketcap_api_key' );
    if ( empty( $api_key ) ) {
      $api_key = self::$default_coinmarketcap_api_key;
    }
    return $api_key;
  }



  public static function get_market_api_key() {
    $api_key = get_option( 'cp_coinmarketcap_api_key' );
    $market = '';

    if ( empty( $api_key ) ) {
      $api_key = self::$default_coingecko_api_key;
      $market = 'coingecko';
    }

    else {
      $api_key = self::$default_coinmarketcap_api_key;
      $market = 'coinmarketcap';
    }

    return array(
      'api_key'=>$api_key,
      'market'=>$market
    );

    //return $api_key;
  }



  public static function cp_fetch_tickerOLD($args) {
    $defaults = array(
      'limit' => 10,
    );
    $args = wp_parse_args( $args, $defaults );
    $args['limit'] = min($args['limit'], 500);

    $coinmarketcap_api_key = self::cp_get_coinmarketcap_api_key();
    
    $response = wp_remote_get( 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?convert=USD&limit=' . $args['limit'] . '&CMC_PRO_API_KEY=' . $coinmarketcap_api_key );
    if ( is_array( $response ) ) {
      try {
        $data = json_decode($response['body'], true);
      } catch ( Exception $e ) {
        return;
      }
      if($data['data']){

        foreach( $data['data'] as $index => $coin ) {
          if( 'BTC' === $coin['symbol']) {
            $bitcoin_price_usd = $coin['quote']['USD']['price'];
            break;
          }
        }

        $formatted = array();
        foreach( $data['data'] as $index => $coin ) {
          $price_btc = $coin['quote']['USD']['price'] / $bitcoin_price_usd;
          
          $formatted[] = array(
            'id' => $coin['id'],
            'name' => $coin['name'],
            'symbol' => $coin['symbol'],
            'rank' => $coin['cmc_rank'],
            'price_usd' => $coin['quote']['USD']['price'],
            'price_btc' => $price_btc >= 1 ? number_format($price_btc, 2) : number_format($price_btc, 8),
            '24h_volume_usd' => $coin['quote']['USD']['volume_24h'],
            'market_cap_usd' => $coin['quote']['USD']['market_cap'],
            'available_supply' => $coin['circulating_supply'],
            'total_supply' => $coin['total_supply'],
            'max_supply' => $coin['max_supply'],
            'percent_change_1h' => $coin['quote']['USD']['percent_change_1h'],
            'percent_change_24h' => $coin['quote']['USD']['percent_change_24h'],
            'percent_change_7d' => $coin['quote']['USD']['percent_change_7d'],
            'last_updated' => $coin['quote']['USD']['last_updated'],
          );
        }
        return $formatted;
      }
    }
    return;
    
  }



  public static function fetch_coinmarketcap_data($coinmarketcap_api_key) {
    
    $response = wp_remote_get( 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?convert=USD&limit=' . 10 . '&CMC_PRO_API_KEY=' . $coinmarketcap_api_key );
    if ( is_array( $response ) ) {
      try {
        $data = json_decode($response['body'], true);
      } catch ( Exception $e ) {
        return;
      }
      if($data['data']){

        foreach( $data['data'] as $index => $coin ) {
          if( 'BTC' === $coin['symbol']) {
            $bitcoin_price_usd = $coin['quote']['USD']['price'];
            break;
          }
        }

        $formatted = array();
        foreach( $data['data'] as $index => $coin ) {
          $price_btc = $coin['quote']['USD']['price'] / $bitcoin_price_usd;
          
          $formatted[] = array(
            'id' => $coin['id'],
            'name' => $coin['name'],
            'symbol' => $coin['symbol'],
            'rank' => $coin['cmc_rank'],
            'price_usd' => $coin['quote']['USD']['price'],
            'price_btc' => $price_btc >= 1 ? number_format($price_btc, 2) : number_format($price_btc, 8),
            '24h_volume_usd' => $coin['quote']['USD']['volume_24h'],
            'market_cap_usd' => $coin['quote']['USD']['market_cap'],
            'available_supply' => $coin['circulating_supply'],
            'total_supply' => $coin['total_supply'],
            'max_supply' => $coin['max_supply'],
            'percent_change_1h' => $coin['quote']['USD']['percent_change_1h'],
            'percent_change_24h' => $coin['quote']['USD']['percent_change_24h'],
            'percent_change_7d' => $coin['quote']['USD']['percent_change_7d'],
            'last_updated' => $coin['quote']['USD']['last_updated'],
          );
        }
        return $formatted;
      }
    }
    return;
    
  }



  public static function fetch_coingecko_data() {

    $response = wp_remote_get( 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1&sparkline=false' );

    if ( is_array( $response ) ) {
      try {
        $data = json_decode($response['body'], true);
      } catch ( Exception $e ) {
        return;
      }
      // if($data['data']){

        foreach( $data as $index => $coin ) {
          if( 'btc' === $coin['symbol']) {
            // $bitcoin_price_usd = $coin['quote']['USD']['price'];
            $bitcoin_price_usd = 1;
            break;
          }
        }

        $formatted = array();
        foreach( $data as $index => $coin ) {
          // $price_btc = $coin['quote']['USD']['price'] / $bitcoin_price_usd;
          $price_btc = 1;
          
          $formatted[] = array(
            'id' => $coin['market_cap_rank'],
            'name' => $coin['name'],
            'symbol' => $coin['symbol'],
            'rank' => $coin['market_cap_rank'],
            'price_usd' => $coin['current_price'], //$coin['quote']['USD']['price'],
            'price_btc' => 1, //$price_btc >= 1 ? number_format($price_btc, 2) : number_format($price_btc, 8),
            '24h_volume_usd' => $coin['total_volume'],
            'market_cap_usd' => $coin['market_cap'],
            'available_supply' => $coin['circulating_supply'],
            'total_supply' => $coin['total_supply'],
            'max_supply' => $coin['total_supply'],
            'percent_change_1h' => $coin['ath_change_percentage'],
            'percent_change_24h' => $coin['price_change_percentage_24h'],
            'percent_change_7d' => $coin['ath_change_percentage'],
            'last_updated' => $coin['last_updated'],
          );
        }
        return $formatted;
      // }
    }
    return;
    
  }




  public static function cp_fetch_ticker($args) {
    $defaults = array(
      'limit' => 10,
    );
    $args = wp_parse_args( $args, $defaults );
    $args['limit'] = min($args['limit'], 500);

    //$coinmarketcap_api_key = self::cp_get_coinmarketcap_api_key();

    $ticker_data = self::get_market_api_key();
    if ($ticker_data['market'] == 'coinmarketcap') {
      return self::fetch_coinmarketcap_data($ticker_data['api_key']);
    }

    else {
      return self::fetch_coingecko_data();
    }

    
    // $response = wp_remote_get( 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?convert=USD&limit=' . $args['limit'] . '&CMC_PRO_API_KEY=' . $coinmarketcap_api_key );

    // $response = wp_remote_get( 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1&sparkline=false' );

    // if ( is_array( $response ) ) {
    //   try {
    //     $data = json_decode($response['body'], true);
    //   } catch ( Exception $e ) {
    //     return;
    //   }
    //   // if($data['data']){

    //     foreach( $data as $index => $coin ) {
    //       if( 'btc' === $coin['symbol']) {
    //         // $bitcoin_price_usd = $coin['quote']['USD']['price'];
    //         $bitcoin_price_usd = 1;
    //         break;
    //       }
    //     }

    //     $formatted = array();
    //     foreach( $data as $index => $coin ) {
    //       // $price_btc = $coin['quote']['USD']['price'] / $bitcoin_price_usd;
    //       $price_btc = 1;
          
    //       $formatted[] = array(
    //         'id' => $coin['market_cap_rank'],
    //         'name' => $coin['name'],
    //         'symbol' => $coin['symbol'],
    //         'rank' => $coin['market_cap_rank'],
    //         'price_usd' => $coin['current_price'], //$coin['quote']['USD']['price'],
    //         'price_btc' => 1, //$price_btc >= 1 ? number_format($price_btc, 2) : number_format($price_btc, 8),
    //         '24h_volume_usd' => $coin['total_volume'],
    //         'market_cap_usd' => $coin['market_cap'],
    //         'available_supply' => $coin['circulating_supply'],
    //         'total_supply' => $coin['total_supply'],
    //         'max_supply' => $coin['total_supply'],
    //         'percent_change_1h' => $coin['ath_change_percentage'],
    //         'percent_change_24h' => $coin['price_change_percentage_24h'],
    //         'percent_change_7d' => $coin['ath_change_percentage'],
    //         'last_updated' => $coin['last_updated'],
    //       );
    //     }
    //     return $formatted;
    //   // }
    // }
    // return;
    
  }




}