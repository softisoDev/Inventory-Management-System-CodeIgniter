/*=========================================================================================
    File Name: basic-pie.js
    Description: echarts basic pie chart
    ----------------------------------------------------------------------------------------
    Item Name: Modern Admin - Clean Bootstrap 4 Dashboard HTML Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic pie chart
// ------------------------------

$(window).on("load", function(){

    // Set paths
    // ------------------------------

    require.config({
        paths: {
            echarts: 'app-assets/vendors/js/charts/echarts'
        }
    });


    // Configuration
    // ------------------------------

    require(
        [
            'echarts',
            'echarts/chart/pie',
            'echarts/chart/funnel'
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('basic-pie'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add title
                title: {
                    text: 'Kitabların Satışı',
                    x: 'center'
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} AZN ({d} %)",

                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    x: 'left',
                    data: ['Yanvar', 'Fevral', 'Mart']
                },

                // Add custom colors
                color: ['#00A5A8', '#626E82', '#FF7D4D'],

                // Display toolbox
                toolbox: {
                    show: true,
                    orient: 'vertical',
                    feature: {
                       mark: {
                            show: false,
                            title: {
                                mark: 'Markline switch',
                                markUndo: 'Undo markline',
                                markClear: 'Clear markline'
                            }
                        },
                        dataView: {
                            show: false,
                            readOnly: true,
                            title: 'Məlumatlara Bax',
                            lang: ['View chart data', 'Bağla', 'Update']
                        },

                        magicType: {
                            show: false,
                            title: {
                                pie: 'Switch to pies',
                                funnel: 'Switch to funnel',
                            },
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    y: '20%',
                                    width: '50%',
                                    height: '70%',
                                    funnelAlign: 'left',
                                    max: 1548
                                }
                            }
                        },

                        restore: {
                            show: true,
                            title: 'Yenilə'
                        },
                        saveAsImage: {
                            show: true,
                            title: 'Şəkil Kimi Yaddaşa Ver',
                            lang: ['Saxla']
                        }
                    }
                },

                // Enable drag recalculate
                calculable: false,

                // Add series
                series: [{
                    name: 'Kitabların Satışı',
                    type: 'pie',
                    radius: '70%',
                    center: ['50%', '57.5%'],
                    data: [
                        {value: 335, name: 'Yanvar'},
                        {value: 310, name: 'Fevral'},
                        {value: 234, name: 'Mart'}
                    ],
                    axisLabel:{
                        show: true
                    }
                }]
            };

            // Apply options
            // ------------------------------

            myChart.setOption(chartOptions);


            // Resize chart
            // ------------------------------

            $(function () {

                // Resize chart on menu width change and window resize
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);

                // Resize function
                function resize() {
                    setTimeout(function() {

                        // Resize chart
                        myChart.resize();
                    }, 200);
                }
            });
        }
    );
});