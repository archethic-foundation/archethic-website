 
$(document).ready(function(){
 
                    
  
    var array_uniris_all = [];      
    var array_uniris_1m = [];       
    var array_uniris_1d = [];       
    var array_uniris_combined = []; 

    var array_btc_all = [];      
    var array_btc_1m = [];       
    var array_btc_1d = [];       
    var array_btc_combined = [];
    
    var array_eth_all = [];      
    var array_eth_1m = [];       
    var array_eth_1d = [];       
    var array_eth_combined = [];
  
    function sortNumerically(a, b) {
        if ( a[0] < b[0] ){
          return -1;
        }
        if ( a[0] > b[0] ){
          return 1;
        }
        return 0;
      }
  
  
      var usdmaxpromise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=usd&days=max');
      var usd31promise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=usd&days=31');
      var usd1maxpromise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=usd&days=1');
      var btcmaxpromsie = $.getJSON('https://api.coingecko.com/api/v3/coins/bitcoin/market_chart?vs_currency=usd&days=max');
      var btc31promise =  $.getJSON('https://api.coingecko.com/api/v3/coins/bitcoin/market_chart?vs_currency=usd&days=31');
      var btc1promise = $.getJSON('https://api.coingecko.com/api/v3/coins/bitcoin/market_chart?vs_currency=usd&days=1');
      var ethmaxpromise = $.getJSON('https://api.coingecko.com/api/v3/coins/ethereum/market_chart?vs_currency=usd&days=max');
      var eth31promise =  $.getJSON('https://api.coingecko.com/api/v3/coins/ethereum/market_chart?vs_currency=usd&days=31');
      var eth1promise = $.getJSON('https://api.coingecko.com/api/v3/coins/ethereum/market_chart?vs_currency=usd&days=1');
    
      $.when(usdmaxpromise, usd31promise, usd1maxpromise, btcmaxpromsie, btc31promise, btc1promise, ethmaxpromise, eth31promise, eth1promise)
      .then(function(api_data_all, api_data_1m, api_data_1d, api1_data_all, api1_data_1m, api1_data_1d, api2_data_all, api2_data_1m, api2_data_1d){
                                
                                        array_uniris_all = api_data_all[0].prices;
                                        array_uniris_1m = api_data_1m[0].prices;
                                        array_uniris_1d = api_data_1d[0].prices;
                                        array_uniris_combined = array_uniris_all.concat(array_uniris_1m).concat(array_uniris_1d);
                                        array_uniris_combined.sort(sortNumerically);

                                        array_btc_all = api1_data_all[0].prices;
                                        array_btc_1m = api1_data_1m[0].prices;
                                        array_btc_1d = api1_data_1d[0].prices;
                                        array_btc_combined = array_btc_all.concat(array_btc_1m).concat(array_btc_1d);
                                        array_btc_combined.sort(sortNumerically);

                                        array_eth_all = api2_data_all[0].prices;
                                        array_eth_1m = api2_data_1m[0].prices;
                                        array_eth_1d = api2_data_1d[0].prices;
                                        array_eth_combined = array_eth_all.concat(array_eth_1m).concat(array_eth_1d);
                                        array_eth_combined.sort(sortNumerically);
                                    
                                    
                                        Highcharts.setOptions({
                                            lang: {
                                                thousandsSep: ','
                                            }
                                        });

                                        Highcharts.setOptions({
                                            lang:{
                                                rangeSelectorZoom: ''
                                            }
                                        });
                            
                                        uco_chart = Highcharts.stockChart('chart_container2', {

                                        
                                            xAxis: {
                                                ordinal: false,
                                                type: 'datetime',
                                                dateTimeLabelFormats: {
                                                    hour: '%l%P',
                                                    day: '%e %b',
                                                    week: '%e %b',
                                                    month: '%b \'%y',
                                                    year: '%Y'
                                                }
                                            },

                                            title: {
                                                text: '<b>Percentage Change in Price of UCO - BTC - ETH</b>'
                                            },

                                            legend: {
                                                enabled: true,
                                               
                                               
                                            },

                                            

                                            yAxis: [{
                                                labels: {
                                                    formatter: function () {
                                                        return (this.value > 0 ? ' + ' : '') + this.value + '%';
                                                    }
                                                },
                                                plotLines: [{
                                                    value: 0,
                                                    width: 2,
                                                    color: 'silver'
                                                }]
                                            },{
                                                opposite: false,
                                                
                                            }],

                                            plotOptions: {
                                                series: {
                                                    compare: 'percent',
                                                    showInNavigator: true
                                                }
                                            },

                                           tooltip: {
                                                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>$ {point.y}</b> ({point.change}%)<br/>',
                                                valueDecimals: 2,
                                                split: true
                                            },

                                           

                                            series: [{

                                                //name: UCO,
                                                data: array_uniris_combined,
                                                name: 'UCO',
                                                color: '#7cb5ec'
                                                //showInLegend: false
                                            },{
                                                //name: BTC,
                                                data: array_btc_combined,
                                                name: 'BTC',
                                                color: '#ffc56e'
                                                //yAxis: 1,
                                                //visible: false
                                            },{
                                                //name: eth,
                                                data: array_eth_combined,
                                                name: 'ETH',
                                                color: '#d46a67'
                                                //yAxis: 2,
                                                //visible: false
                                            }],

                            
                                           
                            
                            
                                            time: {
                                                useUTC: false
                                            },
                                        
                                
                                            navigator: {
                                                enabled: false
                                            },
                                
                                            scrollbar: {
                                                enabled: false
                                            },
                                
                                            rangeSelector: {
                                                selected: 0,
                                                inputEnabled: true,
                                                buttons: [{
                                                    type: 'day',
                                                    count: 1,
                                                    text: '1D',
                                                },
                                                {
                                                    type: 'week',
                                                    count: 1,
                                                    text: '1W',
                                                },
                                                {
                                                    type: 'month',
                                                    count: 1,
                                                    text: '1M',
                                                },
                                                {
                                                    type: 'year',
                                                    count: 1,
                                                    text: '1Y',
                                                }, {
                                                    type: 'all',
                                                    count: 1,
                                                    text: 'All',
                                                }]
                            
                                            }
                            
                                        });
                                    });
                                });
  