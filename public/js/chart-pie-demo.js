// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
// var pieChart = document.getElementById("myPieChart");
function paintPieChart(selector,arr_label, arr_data){
    let myPieChart = new Chart(selector, {
        type: 'doughnut',
        data: {
            labels: arr_label,
            datasets: [{
                data: arr_data,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', 'rgb(255, 99, 132)','rgb(75, 192, 192)', 'rgb(255, 205, 86)', 'rgb(201, 203, 207)'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: true,
                caretPadding: 10,
            },
            legend: {
                display: true
            },
            cutoutPercentage: 80,
        },
    });
}



