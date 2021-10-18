console.log("Chart")

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
                itemStyle: { color: '#4CC9F0' },

            }, { value: 3.2, name: 'Marketing', itemStyle: { color: '#FFFA46' } },
            { value: 5.6, name: 'Team', itemStyle: { color: '#00818A' } },
            { value: 8.2, name: 'Funding Pool', itemStyle: { color: '#3F37C9' } },
            { value: 23.3, name: 'Deliverables', itemStyle: { color: '#4895EF' } },
            { value: 9.0, name: 'Enhancements', itemStyle: { color: '#38a3a5' } },
            { value: 2.2, name: 'Foundation', itemStyle: { color: '#F72585' } },


            {
                value: 3.4,
                name: 'Exhange Platform',
                itemStyle: { color: '#FF865E' }
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