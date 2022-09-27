let map
let minNbOfAuthorizedNodes
let maxNbOfAuthorizedNodes
let minNbOfPendingNodes
let maxNbOfPendingNodes
var worldmapDatas = []


const prec_tab = [
    ['0', '1', '2', '3'],
    ['4', '5', '6', '7'],
    ['8', '9', 'A', 'B'],
    ['C', 'D', 'E', 'F']
]

const main_tab = [
    '8', '9', 'A', 'B',
    'C', 'D', 'E', 'F',
    '0', '1', '2', '3',
    '4', '5', '6', '7'
]

function reverse_patch(patch) {

    const [first_digit, second_digit, third_digit] = patch

    const lat_init = (main_tab.indexOf(second_digit) - 4) * 22.5
    const lon_init = main_tab.indexOf(first_digit) * 22.5

    const lat_prec = Math.trunc(parseInt(third_digit, 16) / 4)
    const lon_prec = parseInt(third_digit, 16) % 4

    const lat_range_0 = lat_init + lat_prec * 5.625 - 90
    const lat_range_1 = lat_init + (lat_prec + 1) * 5.625 - 90
    const lon_range_0 = lon_init + lon_prec * 5.625 - 180
    const lon_range_1 = lon_init + (lon_prec + 1) * 5.625 - 180

    var coordinates = {
        lat: [lat_range_0, lat_range_1],
        lon: [lon_range_0, lon_range_1]
    }

    return coordinates
}

const query = `
         {
              nodes{
                geoPatch,
                authorized,
                available
              }
          }
        `;

fetch("https://mainnet.archethic.net/api/graphiql", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
    },
    body: JSON.stringify({
        query
    })
}).then((response) => {
    return response.json();
}).then((data) => {

    for (let i = 0; i < data.data.nodes.length; i++) {

        worldmapDatas.push({
            coords: reverse_patch(data.data.nodes[i].geoPatch),
            geo_patch: data.data.nodes[i].geoPatch,
            nb_of_nodes: 1,
            authorized: true,
        })
    }
    console.log(worldmapDatas)

    calculateNbOfNodes(worldmapDatas)

    var chart = echarts.init(document.getElementById('globe3d'));

    var canvas = document.createElement('canvas');
    var mapChart = echarts.init(canvas, null, {
        width: 2048,
        height: 1024
    });

    mapChart.setOption({

        legend: {
            selectedMode: 'single',
            textStyle: {
                fontSize: 16
            }
        },
        geo: {
            type: 'map',
            map: 'world',
            top: 0,
            left: 0,
            right: 0,
            bottom: 0,
            boundingCoords: [
                [-180, 90],
                [180, -90]
            ],
            silent: true,
            projection: {
                project: (point) => [point[0], point[1] * -1],
                unproject: (point) => [point[0], point[1] * -1]
            },

            itemStyle: {
                normal: {
                    borderColor: 'transparent',
                    areaColor: 'transparent'
                }
            },
            label: {
                normal: {
                    textStyle: {
                        color: '#fff',
                        fontSize: 40
                    }
                }
            }
        },
        series: [{
            type: 'custom',
            coordinateSystem: 'geo',
            geoIndex: 0,
            renderItem: renderItem,
            data: formatData(worldmapDatas, true),
            tooltip: {
                show: true,
                formatter: tooltipFormatter,
            }
        }]

    });


    chart.setOption({
        globe: {

            baseTexture: 'assets/img/world.topo.bathy.200401.jpg',
            heightTexture: 'assets/img/elev_bump_4k.jpg',

            shading: 'color',
            realisticMaterial: {
                roughness: 0.8,
                metalness: 0
            },
            // environment: 'transparent',

            globeRadius: 60,

            globeOuterRadius: 0,

            postEffect: {
                enable: true
            },
            temporalSuperSampling: {
                enable: true
            },
            light: {
                ambient: {
                    intensity: 0
                },
                main: {
                    intensity: 6,
                    shadow: true
                },
                // ambientCubemap: {
                //     texture: 'assets/js/pisa.hdr',
                //     exposure: 2,
                //     diffuseIntensity: 0.1,
                //     specularIntensity: 1
                // }
            },
            viewControl: {
                animationDurationUpdate: 1000,
                animationEasingUpdate: 'cubicInOut',
                targetCoord: [116.46, 39.92],
                autoRotate: false
            },

            layers: [{
                type: 'blend',
                blendTo: 'albedo',
                texture: mapChart
            }]
        },
        series: []
    })
});

function calculateNbOfNodes(datas) {
    const authorizedNodes = datas.filter(data => data.authorized)
        .map(data => data.nb_of_nodes)

    minNbOfAuthorizedNodes = Math.min(...authorizedNodes)
    maxNbOfAuthorizedNodes = Math.max(...authorizedNodes)

    const pendingNodes = datas.filter(data => !data.authorized)
        .map(data => data.nb_of_nodes)

    minNbOfPendingNodes = Math.min(...pendingNodes)
    maxNbOfPendingNodes = Math.max(...pendingNodes)
}

// Format datas for echarts series
function formatData(datas, authorized) {
    return datas.filter(data => data.authorized === authorized)
        .map(data => {
            return data.authorized === authorized ? [
                data.coords.lon[0],
                data.coords.lon[1],
                data.coords.lat[0],
                data.coords.lat[1],
                data.nb_of_nodes,
                data.geo_patch,
                authorized ? minNbOfAuthorizedNodes : minNbOfPendingNodes,
                authorized ? maxNbOfAuthorizedNodes : maxNbOfPendingNodes
            ] : null
        })
}

function tooltipFormatter(params, ticket, callback) {
    const nbNodes = params.value[4]
    const geoPatch = params.value[5]
    let res = nbNodes.toString()
    res += nbNodes > 1 ? ' nodes' : ' node'
    res += '<br/>geo patch : ' + geoPatch
    return res
}

// Render a circle and a emphasis rectangle at coord of a geo patch
function renderItem(params, api) {
    // Color set by visualMap
    const color = api.visual('color')
    // return value only if color is set by visualMap
    if (color != 'rgba(0,0,0,0)') {
        const firstPoint = api.coord([api.value(0), api.value(2)])
        const secondPoint = api.coord([api.value(1), api.value(3)])

        // Circle
        const centerPoint = [
            (firstPoint[0] + secondPoint[0]) / 2,
            (firstPoint[1] + secondPoint[1]) / 2
        ]

        const maxRadius = Math.abs((secondPoint[0] - firstPoint[0]) / 2)

        // Calculate radius to have a range from 20% to 100% of maxRadius
        const min = api.value(6)
        const max = api.value(7)
        const nbNodes = api.value(4)

        // Avoid dividing by 0
        const percent = max !== min ?
            (0.60 * (nbNodes - min) / (max - min)) + 0.40 : 1

        const radius = maxRadius * percent

        // Rectangle
        const rectWidth = secondPoint[0] - firstPoint[0]
        const rectHeight = secondPoint[1] - firstPoint[1]

        return {
            type: 'group',
            children: [{
                    type: 'circle',
                    shape: {
                        cx: centerPoint[0],
                        cy: centerPoint[1],
                        r: radius
                    },
                    style: {
                        fill: 'red',
                        opacity: 0.65,
                        stroke: 'rgb(0,0,0,0.5)',
                        lineWidth: 1
                    }
                },
                // rectangle to show geo patch square on emphasis
                {
                    type: 'rect',
                    shape: {
                        x: firstPoint[0],
                        y: firstPoint[1],
                        width: rectWidth,
                        height: rectHeight
                    },
                    style: {
                        fill: 'rgba(0,0,0,0)',
                        opacity: 0
                    },
                    emphasis: {
                        style: {
                            opacity: 1,
                            stroke: '#000',
                            lineWidth: 1
                        }
                    }
                }
            ]
        };
    } else {
        return null
    }
}

window.addEventListener('resize', function () {
    chart.resize();
});