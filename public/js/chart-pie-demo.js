// Pie Chart Example
function paintPieChart(selector,arr_label, arr_data){
    var myPieChart = new Chart(selector, {
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
            cutoutPercentage: 0,
        },
    });
}



