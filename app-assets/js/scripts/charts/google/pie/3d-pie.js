/*=========================================================================================
    File Name: 3d-pie.js
    Description: google 3D pie chart
    ----------------------------------------------------------------------------------------
    Item Name: Modern Admin - Clean Bootstrap 4 Dashboard HTML Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// 3D Pie chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawPie3d);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawPie3d() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);


    // Set chart options
    var options_pie3d = {
        title: 'Deneme',
        is3D: true,
        height: 400,
        fontSize: 12,
        colors:['blue','green', 'yellow', 'pink', 'black'],
        chartArea: {
            left: '5%',
            width: '90%',
            height: 350
        },
        animation:{
            duration: 1000,
            easing: 'in',
            startup: true
        },
    };

    // Instantiate and draw our chart, passing in some options.
    var pie3d = new google.visualization.PieChart(document.getElementById('pie-3d'));
    pie3d.draw(data, options_pie3d);

    var percent = 0;
    // start the animation loop
    var handler = setInterval(function(){
        // values increment
        percent += 1;
        // apply new values
        data.setValue(2, 1, percent);
        data.setValue(1, 1, 100 - percent);
        // update the pie
        pie3d.draw(data, options_pie3d);
        // check if we have reached the desired value
        if (percent > 74)
        // stop the loop
        clearInterval(handler);
    }, 30);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawPie3d();
    }
});