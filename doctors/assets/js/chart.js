var totalFrequency = 0;

function getChart() {

    // Bar Chart
    $.get("./../data.php", function(data, status) {
        console.log(data);
        var name = [];
        var marks = [];

        for (var i in data) {
            name.push(data[i].s_name);
            marks.push(data[i].frequency);
        }


        var barChartData = {
            labels: name,
            datasets: [{
                label: 'Diagnosed',
                backgroundColor: 'rgba(0, 158, 251, 0.5)',
                borderColor: 'rgba(0, 158, 251, 1)',
                borderWidth: 1,
                data: marks
            }, {
                label: 'Diagnosed',
                backgroundColor: 'rgba(255, 188, 53, 0.5)',
                borderColor: 'rgba(255, 188, 53, 1)',
                borderWidth: 1,
                data: marks
            }]
        };

        var ctx = document.getElementById('bargraph').getContext('2d');
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                legend: {
                    display: false,
                }
            }
        });

        // Line Chart

        var lineChartData = {
            labels: name,
            datasets: [{
                label: "Diagnosed",
                backgroundColor: "rgba(0, 158, 251, 0.5)",
                data: marks
            }, {
                label: "Diagnosed",
                backgroundColor: "rgba(255, 188, 53, 0.5)",
                fill: true,
                data: marks
            }]
        };

        var linectx = document.getElementById('linegraph').getContext('2d');
        window.myLine = new Chart(linectx, {
            type: 'line',
            data: lineChartData,
            options: {
                responsive: true,
                legend: {
                    display: false,
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                }
            }
        });

        // Bar Chart 2

        barChart();

        $(window).resize(function() {
            barChart();
        });

        function barChart() {
            $('.bar-chart').find('.item-progress').each(function() {
                var itemProgress = $(this),
                    itemProgressWidth = $(this).parent().width() * ($(this).data('percent') / 100);
                itemProgress.css('width', itemProgressWidth);
            });
        };
    });
}

function checkSicknesses() {
    $.ajax({
        url: './checkSicknesses.php',
        data: $(this).serialize(),
        type: "POST",
        dataType: "json",
        success: function(data) {
            if (totalFrequency !== data) {
                getChart();
                totalFrequency = data;
            }

        }
    });
}
$(document).ready(function() {
    setInterval(() => {
        checkSicknesses()
    }, 1000);
});