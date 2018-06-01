;(function($){
    $(document).ready(function(){
        window.mapChart = Highcharts.mapChart('map', {

            chart: {
                map: 'countries/us/us-all',
                borderWidth: 0,
            },

            title: {
                text: ''
            },

            legend: {
                enabled: false
            },

            mapNavigation: {
                enabled: false
            },

            exporting: {
                enabled: false
            },

            colorAxis: {
                min: 1,
                type: 'logarithmic',
                minColor: '#EEEEFF',
                maxColor: '#000022',
                stops: [
                    [0, '#EFEFFF'],
                    [0.67, '#4444FF'],
                    [1, '#000022']
                ]
            },

            plotOptions: {
                series: {
                    animation: false
                }
            },

            series: [{
                animation: {
                    duration: 1000
                },
                data: mapData,
                joinBy: ['postal-code', 'code'],
                dataLabels: {
                    enabled: false,
                    color: '#FFFFFF',
                    format: '{point.code}'
                },
                name: 'Meetings',
                tooltip: {
                    pointFormat: '{point.code}: {point.value}%'
                }
            }]
        });

        setTimeout(
            function(){
                var map       = $('#map'),
                    mapWidth  = map.width(),
                    mapHeight = parseInt(mapWidth/1.2);

                window.mapChart.setSize(mapWidth, mapHeight);
                map.css('opacity', 1);
            }, 1000
        );

        $('.print-page').click(function(){
            window.print();
        });
    });
})(jQuery);