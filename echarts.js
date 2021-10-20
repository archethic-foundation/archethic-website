var option;

option = {
    tooltip: {
        trigger: 'item',
        // formatter: (a) => {
        //     return a.data.value + " %" 
        // }
    },
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
                color: "#FFFFFF"
            }
        },
        labelLine: {
            show: false
        },
        data: [{
                value: 44.8,
                name: ' Network Pool',
                itemStyle: {
                    color: '#193498'
                },

            }, {
                value: 3.2,
                name: 'Marketing',
                itemStyle: {
                    color: '#3F37C9'
                }
            },
            {
                value: 5.6,
                name: 'Team',
                itemStyle: {
                    color: '#4895EF'
                }
            },
            {
                value: 8.2,
                name: 'Funding Pool',
                itemStyle: {
                    color: '#1F5EA8'
                }
            },
            {
                value: 23.3,
                name: 'Deliverables',
                itemStyle: {
                    color: '#1597E5'
                }
            },
            {
                value: 9.0,
                name: 'Enhancements',
                itemStyle: {
                    color: '#38a3a5'
                }
            },
            {
                value: 2.2,
                name: 'Foundation',
                itemStyle: {
                    color: '#2A9D8F'
                }
            },
            {
                value: 3.4,
                name: 'Exhange Platform',
                itemStyle: {
                    color: '#69DADB'
                }
            }


        ]
    }]
};

var chartDom = document.getElementById('pie_item');
var myChart = echarts.init(chartDom);

option && myChart.setOption(option);

window.addEventListener('resize', onWindowResize2, false);

function onWindowResize2() {

    var chartDom = document.getElementById('pie_item');
    var myChart = echarts.init(chartDom);

    option && myChart.setOption(option);
}


function getGovItemData(name) {
    switch(name) {
        
        case "Blockchain": return "Blockchain - <br>The Blockchain itself, specifically<br> through its ability to <br>test a full-scale functionality<br> before deploying it on<br> the network. For example, the<br> maximum size of transactions <br>is not linked to <br>a point of view, rather <br>it can be directly tested <br>to determine the actual <br>impact on the network <br>with respect to the<br> need considered. ";
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
        backgroundColor: "#05050f",
        textStyle: {
            color: "#fff"
        },
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
                value: 300,
                name: 'Technical & Ethical Council',
                itemStyle: {
                    color: '#113CFC'
                }
            },
            {
                value: 550,
                name: 'Foundation',
                itemStyle: {
                    color: '#69DADB'
                }
            },
            {
                value: 400,
                name: 'Miners',
                itemStyle: {
                    color: '#004adf'
                }
            },
            {
                value: 450,
                name: 'Applications & Services',
                itemStyle: {
                    color: '#193498'
                }
            },
            {
                value: 500,
                name: 'Blockchain',
                itemStyle: {
                    color: '#004adf'
                }
            },
            {
                value: 350,
                name: 'Users',
                itemStyle: {
                    color: '#1597E5'
                }
            },
            
        ].sort(function(a, b){
            return a.value - b.value
        }),
        roseType: 'radius',
        label: {
            color: 'rgba(255, 255, 255, 0.6)'
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