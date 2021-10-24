var option;

option = {
    tooltip: {
        trigger: 'item',
        // formatter: (a) => {
        //     return a.data.value + " %"
        // }
    },
    color: ['#80FFA5', '#00DDFF', '#37A2FF', '#FF0087', '#FFBF00'],
    legend: {
        show: false,
        top: '5%',
        left: 'center'
    },
    series: [{
        name: '',
        type: 'pie',
        radius: ['40%', '70%'],
        avoidLabelOverlap: false,
        itemStyle: {
            borderRadius: 5,
            borderColor: '#000',
            borderWidth: 1
        },
        label: {
            show: false,
            position: 'center'
        },
        emphasis: {
            label: {
                show: false,
                fontSize: '18',
                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                    {
                      offset: 0,
                      color: 'rgba(128, 255, 165)'
                    },
                    {
                      offset: 1,
                      color: 'rgba(1, 191, 236)'
                    }
                  ])
                },

        },
        labelLine: {
            show: false
        },
        data: [{
                value: 44.8,
                name: ' Network Pool',
                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        {
                          offset: 0,
                          color: 'rgba(0, 221, 255)'
                        },
                        {
                          offset: 1,
                          color: 'rgba(77, 119, 255)'
                        }
                      ])
                    },


            }, {
                value: 3.2,
                name: 'Marketing',
                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        {
                          offset: 0,
                          color: 'rgba(55, 162, 255)'
                        },
                        {
                          offset: 1,
                          color: 'rgba(116, 21, 219)'
                        }
                      ])
                    }

            },
            {
                value: 5.6,
                name: 'Team',
                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        {
                          offset: 0,
                          color: 'rgba(255, 0, 135)'
                        },
                        {
                          offset: 1,
                          color: 'rgba(135, 0, 157)'
                        }
                      ])
                    }

            },
            {
                value: 8.2,
                name: 'Funding Pool',
                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        {
                          offset: 0,
                          color: 'rgba(255, 191, 0)'
                        },
                        {
                          offset: 1,
                          color: 'rgba(224, 62, 76)'
                        }
                      ])
                    }

            },
            {
                value: 23.3,
                name: 'Deliverables',
                itemStyle: {
                    color: '#5C33F6'

                }
            },
            {
                value: 9.0,
                name: 'Enhancements',
                itemStyle: {
                    color: '#7ECA9C'
                }
            },
            {
                value: 2.2,
                name: 'Foundation',
                itemStyle: {
                    color: '#14F195'
                }
            },
            {
                value: 3.4,
                name: 'Exhange Platform',
                itemStyle: {
                    color: '#FF884B'
                }
            }


        ]
    }]
};

// var chartDom = document.getElementById('pie_item');
// var myChart = echarts.init(chartDom);

// option && myChart.setOption(option);

// window.addEventListener('resize', onWindowResize2, false);

// function onWindowResize2() {

//     var chartDom = document.getElementById('pie_item');
//     var myChart = echarts.init(chartDom);

//     option && myChart.setOption(option);
// }


function getGovItemData(name) {
    switch(name) {

        case "Blockchain": return "Blockchain - <br>Blockchain has the ability<br> to test a full-scale<br> functionality and its impact <br>before deploying it on <br>the network.";
        case "Users": return "Users - <br>Anyone with the ability<br> to prove their uniqueness<br> (via biometric devices or<br> other processes).";
        case "Foundation": return "Foundation - <br>Their role is to<br> lead the community and<br> to organize governance.";
        case "Miners": return "Miners - <br>Owners of the mining<br> nodes which constitute the<br> network itself";
        case "Technical & Ethical Council": return "Technical & Ethical Council - <br>Composed of the 'core developers'<br> with a weightage based<br> on the importance of <br>their code contribution.";
        case "Applications & Services": return "Applications & Services - <br>Application providers with a <br>weightage based on the<br> generated usage.";



    }
}


let optionG;

optionsG = {
    backgroundColor: 'rgba(0,0,0,0)',

    tooltip: {
        trigger: 'item',
        position: 'inside',
        backgroundColor: "#05050f",
        textStyle: {
            color: "#fff"
        },
        className: 'echarts-tooltip echarts-tooltip-dark',
        formatter: (a) => {
            return getGovItemData(a.data.name)
        }
    },
    visualMap: {
        show: false,
        min: 80,
        max: 600,
        inRange: {
            colorLightness: [0, 1]
        }
    },
    series: [{
        name: 'ARCHEthic Governance',
        type: 'pie',
        radius: '55%',
        center: ['50%', '50%'],
        data: [
            {
                value: 400,
                name: 'Technical & Ethical Council',
                itemStyle: {
                  color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                    {
                      offset: 0,
                      color: 'rgba(128, 255, 165)'
                    },
                    {
                      offset: 1,
                      color: 'rgba(1, 191, 236)'
                    }
                  ])
                }
                },
            {
                value: 400,
                name: 'Foundation',
                itemStyle: {
                  color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                    {
                      offset: 0,
                      color: 'rgba(0, 221, 255)'
                    },
                    {
                      offset: 1,
                      color: 'rgba(77, 119, 255)'
                    }
                  ])
                }
                },
            {
                value: 400,
                name: 'Miners',
                itemStyle: {
                  color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                    {
                      offset: 0,
                      color: 'rgba(55, 162, 255)'
                    },
                    {
                      offset: 1,
                      color: 'rgba(116, 21, 219)'
                    }
                  ])
                }
                },
            {
                value: 400,
                name: 'Applications & Services',
                itemStyle: {
                  color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                    {
                      offset: 0,
                      color: '#134e5e'
                    },
                    {
                      offset: 1,
                      color: '#71b280'
                    }
                  ])
                }
          },
            {
                value: 400,
                name: 'Blockchain',
                itemStyle: {
                  color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                    {
                      offset: 0,
                      color: 'rgba(255, 191, 0)'
                    },
                    {
                      offset: 1,
                      color: 'rgba(224, 62, 76)'
                    }
                  ])
                }
                },
            {
                value: 400,
                name: 'Users',
                itemStyle: {

                  color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                    {
                      offset: 0,
                      color: 'rgba(255, 0, 135)'
                    },
                    {
                      offset: 1,
                      color: 'rgba(135, 0, 157)'
                    }
                  ])
                }
                },


        ].sort(function(a, b){
            return a.value - b.value
        }),
        roseType: 'radius',
        label: {
            color: 'rgba(255, 255, 255, 0.6)'
        },
        emphasis: {
          scale: true,
          scaleSize: 15
        },
        labelLine: {
            lineStyle: {
                color: 'rgba(255, 255, 255, 0.6)'
            },
            smooth: 0.2,
            length: 10,
            length2: 20
        },
        itemStyle: {
            color: '#017baf',
            shadowBlur: 200,
            shadowColor: 'rgba(0, 0, 0, 0.8)'
        },


        animationType: 'scale',
        animationEasing: 'elasticOut',
        animationDelay: function (idx) {
            return Math.random() * 200;
        }
    }]
};



var chartDom2 = document.getElementById('gov_item');
var myChart2 = echarts.init(chartDom2);
optionsG && myChart2.setOption(optionsG);
