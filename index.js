 
$(document).ready(function(){
 
                
    
  
    var array_uniris_all = [];      
    var array_uniris_1m = [];       
    var array_uniris_1d = [];       
    var array_uniris_combined = []; 

    var array_eur_all = [];      
    var array_eur_1m = [];       
    var array_eur_1d = [];       
    var array_eur_combined = []; 

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
  var usd1promise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=usd&days=1');
  var btcmaxpromise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=btc&days=max');
  var btc31promise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=btc&days=31');
  var btc1promise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=btc&days=1');
  var ethmaxpromise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=eth&days=max');
  var eth31promise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=eth&days=31');
  var eth1promise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=eth&days=1');
  var euromaxpromise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=eur&days=max');
  var euro31promise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=eur&days=31');
  var euro1promise = $.getJSON('https://api.coingecko.com/api/v3/coins/uniris/market_chart?vs_currency=eur&days=1');
  $.when(usdmaxpromise, usd31promise, usd1promise, btcmaxpromise,btc31promise, btc1promise, ethmaxpromise, eth31promise, eth1promise,
    euromaxpromise, euro31promise, euro1promise ).then(function(api_data_all, api_data_1m, api_data_1d, api1_data_all, api1_data_1m,
    api1_data_1d, api2_data_all, api2_data_1m, api2_data_1d, api3_data_all, api3_data_1m, api3_data_1d ){
  
               
                                        array_uniris_all = api_data_all[0].prices;
                                        array_uniris_1m = api_data_1m[0].prices;
                                        array_uniris_1d = api_data_1d[0].prices;
                                        array_uniris_combined = array_uniris_all.concat(array_uniris_1m).concat(array_uniris_1d);
                                        array_uniris_combined.sort(sortNumerically);

                                        array_eur_all = api3_data_all[0].prices;
                                        array_eur_1m = api3_data_1m[0].prices;
                                        array_eur_1d = api3_data_1d[0].prices;
                                        array_eur_combined = array_uniris_all.concat(array_eur_1m).concat(array_eur_1d);
                                        array_eur_combined.sort(sortNumerically);



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
                                            global: {
                                                useUTC: false
                                            }
                                        });

                                        Highcharts.setOptions({
                                            lang:{
                                                rangeSelectorZoom: ''
                                            }
                                        });
                            
                                         uco_chart = Highcharts.stockChart('chart_container', {

                                        
                                            xAxis: {
                                                ordinal: false,
                                                type: 'datetime',
                                                dateTimeLabelFormats: {
                                                    hour: '%H:%M',
                                                    day: '%e %b',
                                                    week: '%e %b',
                                                    month: '%b \'%y',
                                                    year: '%Y'
                                                }
                                            },
                                            
                                           

                                            title: {
                                                text: '<b>Price of UCO in USD - EUR - BTC - ETH</b>'
                                            },

                                            tooltip: {
                                                shared: true,
                                                formatter: function() {
                                                    let p = '';
                                                    p += '<b>' + Highcharts.dateFormat('%a %e %b %Y, %H:%M:%S',this.x) +'</b><br/>';
                                                    $.each(this.points, function(i, series){
                                                        if(this.series.name == 'USD'){
                                                        p +='<b>Price: </b>$'/*'<span style="color:' + this.series.color + '">' + this.series.name + '</span>*/  + Highcharts.numberFormat(this.y, 8) + '<br/>'}
                                                        if (this.series.name == 'EUR'){
                                                            p +=/*'<span style="color:' + this.series.color + '">' + this.series.name + '</span>*/ '<b>Price: </b>€' + Highcharts.numberFormat(this.y, 8) + '<br/>'}
                                                        if (this.series.name == 'BTC'){
                                                        p +=/*'<span style="color:' + this.series.color + '">' + this.series.name + '</span>*/ '<b>Price: </b>₿' + Highcharts.numberFormat(this.y, 8) + '<br/>'}
                                                        if (this.series.name == 'ETH'){
                                                        p +=/*'<span style="color:' + this.series.color + '">' + this.series.name + '</span>*/ '<b>Price: </b>Ξ' + Highcharts.numberFormat(this.y, 8) + '<br/>'}
                                                       
                                                    });
                                    
                                                    return p;
                                                }
                                            },
                                            
                                            legend: {
                                                enabled: true,
                                                
                                                /*align: 'top',
                                                verticalAlign: 'top',
                                                //layout: 'vertical',
                                                x: 800,
                                                y: 0,*/
                                               
                                            },

                                            

                                           

                                            yAxis: [{
                                                
                                                
                                                opposite: false,
                                                labels: {
                                                   
                                                    format: '$ {value}',
                                                    style: {
                                                        color: '#7cb5ec',
                                                    }
                                                },
                                                
                                            
                                            },{
                                                    opposite: true,
                                                    labels: {
                                                        format: '€ {value}',
                                                        style: {
                                                            color: '#909090',
                                                        }
                                                    } 
                                                }, {
                                                
                                                opposite: true,
                                                labels: {
                                                    format: '₿ {value}',
                                                    style: {
                                                        color: '#ffc56e'
                                                    }
                                                }
                                                
                                            },{
                                                opposite: true,
                                                labels: {
                                                    format: 'Ξ {value}',
                                                    style: {
                                                        color: '#d46a67'
                                                    }
                                                }
                                            }],

                                            series: [{

                                                
                                                
                                                data: array_uniris_combined,
                                                name: 'USD',
                                                
                                                color: '#7cb5ec'
                                                
                                            },{
                                                data: array_eur_combined,
                                                name: 'EUR',
                                                color: '#909090',
                                                yAxis: 1,
                                                visible: false
                                            },
                                            
                                            
                                            
                                            {
                                                
                                                data: array_btc_combined,
                                                name: 'BTC',
                                                color: '#ffc56e',
                                                yAxis: 2,
                                                visible: false
                                            },{
                                                
                                                data: array_eth_combined,
                                                name: 'ETH',
                                                color: '#d46a67',
                                                yAxis: 3,
                                                visible: false
                                            }],

                            
                                            
                                        
                                
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
                            
                                            },

                                            
                            
                                        });
                                        

                                    });
                                });