var option;

option = {
    tooltip: {
        trigger: 'item'
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
        case "Users": return "Users - Anyone with the ability to prove their uniqueness (via biometric devices or other processes).";
        case "Miners": return "Miners - Owners of the mining nodes which constitute the network itself";
        case "Applications & Services": return "Applications & Services - Application providers with a weightage based on the generated usage.";
        case "Foundation": return "Foundation - Their role is to lead the community and to organize governance.";
        case "Technical Council": return "Technical Council - Composed of the 'core developers' with a weightage based on the importance of their code contribution.";
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
        data: [{
                value: 880,
                name: 'Users',
                itemStyle: {
                    color: '#193498'
                }
            },
            {
                value: 860,
                name: 'Miners',
                itemStyle: {
                    color: '#113CFC'
                }
            },
            {
                value: 810,
                name: 'Applications & Services',
                itemStyle: {
                    color: '#1597E5'
                }
            },
            {
                value: 800,
                name: 'Foundation',
                itemStyle: {
                    color: '#69DADB'
                }
            },
            {
                value: 850,
                name: 'Technical Council',
                itemStyle: {
                    color: '#004adf'
                }
            }
        ].sort(function (a, b) {
            return a.value - b.value;
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