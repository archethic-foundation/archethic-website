<?php
class CCPS_Ethereum {
  
  public static function cp_ethereum_shortcode( $atts ) {
    //load javascript library
    
    if (isset($atts['feature'])){
      if ($atts['feature'] == 'balance'){
        $html = CCPS_Ethereum::cp_ethereum_balance( $atts );
      } elseif ($atts['feature'] == 'block') {
        $html = CCPS_Ethereum::cp_ethereum_block( $atts );
      } else {
        $html = 'Unsupported feature.';
      }
    } else {
      $html = 'Please specify a feature.';
    }
    
    return $html;
  }
  
  public static function cp_ethereum_balance( $atts ) {         
    CCPS_Ethereum::cp_include_web3js();
    
    $ethereum_api = get_option('ethereum-api');
    
    if (isset($ethereum_api) and $ethereum_api!=''){    
  
      $html = '
      <h2>'.__('Check Ethereum address balance', 'cryprocurrency-prices').'</h2>
      <form id="get_balance" class="cp-form">
        <input type="text" name="address" size="42" placeholder="'.__('Ethereum address', 'cryprocurrency-prices').'" />
        <input type="submit" value="'.__('Get balance', 'cryprocurrency-prices').'" />
      </form>
      <div id="balance_result"></div>
      
      <script type="text/javascript">  
        function getBalance(address) {
          var Web3 = require("web3");
          var web3 = new Web3();
          web3.setProvider(new web3.providers.HttpProvider("'.$ethereum_api.'"));
          
          if (web3.isAddress(address)){
            var balance = web3.eth.getBalance(address);
            var balanceEth = balance.div(1000000000000000000); 
            document.getElementById("balance_result").innerHTML = 
              "Balance of address: " + address + 
              " is: <strong>" + balanceEth.toFormat(6) + " ETH</strong>";
          } else {
            document.getElementById("balance_result").innerHTML = "Invalid address: "+address;
          }   
        }
  
        jQuery("#get_balance").submit(function(e){
          e.preventDefault(); //prevent default form submit
          
          var address = jQuery("#get_balance input[name=\'address\']").val();
          getBalance(address);
        });
      </script>
      ';
    } else {
      $html = 'You need to setup the ethereum API URL in the plugin settings.';
    }
    
    return $html;
  }
  
  public static function cp_ethereum_block( $atts ) {         
    CCPS_Ethereum::cp_include_web3js();
    
    $ethereum_api = get_option('ethereum-api');
    
    if (isset($ethereum_api) and $ethereum_api!=''){    
  
      $html = '
      <h2>'.__('View Ethereum block', 'cryprocurrency-prices').'</h2>
      <form id="get_block" class="cp-form">
        <input type="text" name="block" size="42" placeholder="'.__('Block number or hash', 'cryprocurrency-prices').'" />
        <input type="submit" value="'.__('Get block', 'cryprocurrency-prices').'" />
      </form>
      <div id="block_result"></div>
      
      <script type="text/javascript">  
        function getBlock(blockNumberHash) {
          var Web3 = require("web3");
          var web3 = new Web3();
          web3.setProvider(new web3.providers.HttpProvider("'.$ethereum_api.'"));
          
          var blockData = web3.eth.getBlock(blockNumberHash);
          
          //calculate block difficulty
          var difficulty = "";
          blockData.difficulty.c.forEach(function(element){
            difficulty += element;
          });
          
          //calculate datetime
          var dateTime = new Date(blockData.timestamp*1000);
          
          document.getElementById("block_result").innerHTML =
            "<table class=\"cp-table cp-block-info\">"+
            "<tr><td>Height: "+"</td><td>"+blockData.number+"</td></tr>"+
            "<tr><td>Timestamp: "+"</td><td>"+dateTime.toISOString()+"</td></tr>"+
            "<tr><td>Transactions: "+"</td><td>"+blockData.transactions.length+"</td></tr>"+
            "<tr><td>Block hash: "+"</td><td>"+blockData.hash+"</td></tr>"+
            "<tr><td>Parent hash: "+"</td><td>"+blockData.parentHash+"</td></tr>"+
            "<tr><td>Mined by: "+"</td><td>"+blockData.miner+"</td></tr>"+
            "<tr><td>Difficulty: "+"</td><td>"+difficulty+"</td></tr>"+
            "<tr><td>Size: "+"</td><td>"+blockData.size+" bytes"+"</td></tr>"+
            "<tr><td>Gas used: "+"</td><td>"+blockData.gasUsed+"</td></tr>"+
            "<tr><td>Gas limit: "+"</td><td>"+blockData.gasLimit+"</td></tr>"+
            "<tr><td>Nonce: "+"</td><td>"+blockData.nonce+"</td></tr>"+
            "</table>";
          console.log(blockData);
        }
  
        jQuery("#get_block").submit(function(e){
          e.preventDefault(); //prevent default form submit
          
          var blockNumberHash = jQuery("#get_block input[name=\'block\']").val();
          getBlock(blockNumberHash);
        });
      </script>
      ';
    } else {
      $html = 'You need to setup the ethereum API URL in the plugin settings.';
    }
    
    return $html;
  }
  
  private static function cp_include_web3js( ) {
    wp_enqueue_script( "web3", CCPS_URL . 'js/web3.min.js' );
    wp_enqueue_script( "bignumber", CCPS_URL . 'js/bignumber.min.js' );
  }

}