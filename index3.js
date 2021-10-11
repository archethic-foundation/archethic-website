 
$(document).ready(function(){
 
                   
  
    var array_uniris_all = [];      
    var array_uniris_1m = [];       
    var array_uniris_1d = [];       
    var array_uniris_combined = []; 
  
    var array_volume_all = [];      
    var array_volume_1m = [];       
    var array_volume_1d = [];       
    var array_volume_combined = [];
    
    
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
  
    $.when(usdmaxpromise, usd31promise, usd1promise).then(function(api_data_all, api_data_1m, api_data_1d){
  
               
                                        array_uniris_all = api_data_all[0].prices;
                                        array_uniris_1m = api_data_1m[0].prices;
                                        array_uniris_1d = api_data_1d[0].prices;
                                        array_uniris_combined = array_uniris_all.concat(array_uniris_1m).concat(array_uniris_1d);
                                        array_uniris_combined.sort(sortNumerically);
  
                                        array_volume_all = api_data_all[0].total_volumes;
                                        array_volume_1m = api_data_1m[0].total_volumes;
                                        array_volume_1d = api_data_1d[0].total_volumes;
                                        array_volume_combined = array_volume_all.concat(array_volume_1m).concat(array_volume_1d);
                                        array_volume_combined.sort(sortNumerically);
  
                                       
                                    
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
                            
                                        uco_chart = Highcharts.stockChart('chart_container3', {
  
                                        
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
                                                text: '<b>Volume of UCO</b>'
                                            },
                                            
  
                                           
  
                                            legend: {
                                                enabled: true,
                                                
                                               
                                            },
  
                                            
                                            tooltip: {
                                              shared: true,
                                              formatter: function() {
                                                  let p = '';
                                                  p += '<b>' + Highcharts.dateFormat('%a %e %b %Y, %H:%M:%S',this.x) +'</b><br/>';
                                                  $.each(this.points, function(i, series){
                                                      if(this.series.name == 'UCO'){
                                                      p +='<b> Price: (UCO) $ </b>'/*'<span style="color:' + this.series.color + '">' + this.series.name + '</span>*/  + Highcharts.numberFormat(this.y) + '<br/>'}
                                                      if (this.series.name == 'VOL'){
                                                      p +=/*'<span style="color:' + this.series.color + '">' + this.series.name + '</span>*/ '<b> VOL: $ </b>' + Highcharts.numberFormat(this.y) + '<br/>'}
                                                      
                                                      
                                                  });
                                  
                                                  return p;
                                              }
                                          },
  
                                            yAxis: [{
                                              
                                              
                                              opposite: false,
                                              labels: {
                                                  //format: '$ {value}',
                                                  format: '$ {value}',
                                                  style: {
                                                      color: '#7cb5ec'
                                                  }
                                              },
                                            
                                          }, {
                                             
                                              opposite: true,
                                              labels: {
                                                  format: '$ {value}',
                                                  style: {
                                                      color: '#696969'
                                                  }
                                              }
                                             
                                          }],
  
                                          series: [{
                                              //name: BTC,
                                              data: array_volume_combined,
                                              name: 'VOL',
                                              color: '#696969',
                                              yAxis: 1,
                                              //visible: false
                                          },{
  
                                            //label: UCO,
                                            
                                            data: array_uniris_combined,
                                            name: 'UCO',
                                            
                                            color: '#7cb5ec',
                                            visible: false
                                            //showInLegend: false
                                        },],
  
                            
                                        
                            
                            
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