@extends('layouts.master')
@section('header.title','Thống kê')
@section('header.css')
    <style>
        .select-year, .select-month{
            width: max-content;
        }
        .card-year{
            display: flex;
            align-items: center;
        }
        .frm-year, .year-title, .frm-month{
            display: inline-block;
            margin-bottom: 0;
        }
        .year-title{
            padding-right: 1rem;
        }
        .select-brand option{
            text-transform: capitalize;
        }
    </style>
@endsection
@section('body.title','Thống kê doanh thu')
@section('body.content')
    <!-- Area Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 card-year">
            <h6 class="year-title m-0 font-weight-bold text-primary">Thống kê doanh thu cửa hàng</h6>
            <span class="mr-1">Tháng</span>
            <div class="form-group frm-month mr-4">
                <select name="month" class="custom-select select-month">
                    <option value='-1' selected >Tất cả</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
            <div class="form-group frm-year mr-4">
                <span class="mr-1">Năm</span>
                <select name="year" class="custom-select select-year"></select>
            </div>
            <button class="btn btn-primary js-btn-statistics-1">Xem</button>

        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
            <hr>
            <div class="text-center">Biểu đồ doanh thu cửa hàng theo từng năm.</div>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 card-year">
            <h6 class="year-title m-0 font-weight-bold text-primary">Thống kê doanh thu cửa hàng</h6>
            <span class="mr-1">Tháng</span>
            <div class="form-group frm-month mr-4">
                <select name="month" class="custom-select select-month">
                    <option value='-1' selected >Tất cả</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>

            </div>
            <div class="form-group frm-year mr-4">
                <span class="mr-1">Năm</span>
                <select name="year" class="custom-select select-year"></select>
            </div>
            <button class="btn btn-primary js-btn-statistics-2">Xem</button>

        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-pie pt-4">
                <canvas id="myPieChart"></canvas>
            </div>
            <hr>
            <div class="text-center">Biểu đồ doanh thu cửa hàng theo thương hiệu</div>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 card-brand">
            <h6 class="year-title m-0 font-weight-bold text-primary">Thống kê số lượng sản phẩm bán theo thương hiệu</h6>
                <span class="mr-1">Thương hiệu</span>
                <div class="form-group frm-year mr-4">
                    <select name="brand" class="custom-select select-brand">
                        <option value='-1' selected >Tất cả</option>
                    </select>
                </div>
                <span class="mr-1">Tháng</span>
                <div class="form-group frm-month mr-4">
                    <select name="month" class="custom-select select-month">
                        <option value='-1' selected >Tất cả</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>

                </div>
                <div class="form-group frm-year mr-4">
                    <span class="mr-1">Năm</span>
                    <select name="year" class="custom-select select-year"></select>
                </div>
                <button class="btn btn-primary js-btn-statistics-3">Xem</button>

        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="table-responsive">

                <!-- Content page -->
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng bán</th>
                    </tr>
                    </thead>
                    <tbody class="js-tbody-statistics-3">

                    </tbody>
                </table>
{{--                {{ $products->links() }}--}}
        </div>
    </div>
@endsection
@section('body.js')

    <!-- Page level plugins -->
    <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('js/config-chart.js')}}"></script>

    <!-- Page level custom scripts -->
{{--    <script src="{{asset('js/chart-area-demo.js')}}"></script>--}}
{{--    <script src="{{asset('js/chart-pie-demo.js')}}"></script>--}}
{{--    <script src="{{asset('js/chart-bar-demo.js')}}"></script>--}}
    <script>
        $(document).ready(function () {
            const areaChart = $("#myAreaChart");
            const pieChart = $("#myPieChart");
            const year = $('.select-year');
            const month = $('.select-month');
            const brand = $('.select-brand');
            var labels = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];

            // Generic function to make an AJAX call
            let fetchData = function(query, dataURL) {
                // Return the $.ajax promise
                return $.ajax({
                    data: query,
                    dataType: 'json',
                    url: dataURL
                });
            };
            function updateData(chart, label, data1) {
                chart.data.labels = label;
                chart.data.datasets[0].data = data1;
                chart.update();
            }
            var myBarChart = new Chart(areaChart, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Revenue",
                        backgroundColor: "#4e73df",
                        hoverBackgroundColor: "#2e59d9",
                        borderColor: "#4e73df",
                        data: [0,0,0,0,0,0,0,0,0,0,0,0],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'month'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 31
                            },
                            maxBarThickness: 25,
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                maxTicksLimit: 5,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return number_format(value) +' đ';
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + 'đ';
                            }
                        }
                    },
                }
            });
            var myPieChart = new Chart(pieChart, {
                type: 'doughnut',
                data: {
                    labels: [1,2,3,4,5],
                    datasets: [{
                        data: [0,0,0,0,0],
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
            let getYear = fetchData('','{!! route('get-year-order') !!}');
            $.when(getYear).then(function (response) {
                let data = response.data;
                // console.log(data);
                let html = '';
                data.forEach(function (item) {
                    html += '<option value="' + item.year + '">' + item.year + '</option>';
                });
                year.html(html);
            }).then(function () {
                let y = year.val();
                let m = month.val();
                $.ajax({
                    url : 'http://127.0.0.1:8000/sales-by-year',
                    data: {
                        year: y,
                        month: m
                    },
                    method: 'GET',
                    success: function (response) {
                        // console.log(response.data);
                        // paintBarChart(areaChart, response.data, labels);
                        updateData(myBarChart, labels, response.data);
                    },
                });
            }).then(function () {
                let y = year.val();
                let m = month.val();
                $.ajax({
                    url : 'http://127.0.0.1:8000/get-order-by-brand',
                    async: false,
                    data: {
                        year: y,
                        month: m
                    },
                    method: 'GET',
                    success: function (response) {
                        let arr_label = [];
                        let arr_data = [];
                        response.data.forEach(function ($item) {
                            arr_label.push($item.name);
                            arr_data.push($item.totalPrice);
                        });
                        // console.log(arr_label);
                        // console.log(arr_data);
                        // paintPieChart(pieChart, arr_label, arr_data)
                        updateData(myPieChart, arr_label, arr_data);
                    }
                });
            });
            $('.js-btn-statistics-1').on('click',function () {
                let y = $(this).parents('.card-header').find('.select-year').val();
                let m = $(this).parents('.card-header').find('.select-month').val();
                let arrLabel = [];
                // Area Chart Example
                if(m !== '-1'){
                    let countDate = new Date(y, m, 0).getDate(); //Đém số ngày của tháng
                    for(let i=1; i<=countDate; i++){
                        arrLabel.push(i);
                    }
                }
                else{
                    arrLabel = labels;
                }
                $.ajax({
                    url : 'http://127.0.0.1:8000/sales-by-year',
                    data: {
                        year: y,
                        month: m
                    },
                    method: 'GET',
                    success: function (response) {
                        console.log(response.data);
                        // paintBarChart(areaChart, response.data,arrLabel);
                        updateData(myBarChart, labels, response.data);
                    },
                });


            });
            $('.js-btn-statistics-2').on('click',function () {
                let y = $(this).parents('.card-header').find('.select-year').val();
                let m = $(this).parents('.card-header').find('.select-month').val();
                $.ajax({
                    url : 'http://127.0.0.1:8000/get-order-by-brand',
                    async: false,
                    data: {
                        year: y,
                        month: m
                    },
                    method: 'GET',
                    success: function (response) {
                        let arr_label = [];
                        let arr_data = [];
                        response.data.forEach(function ($item) {
                            arr_label.push($item.name);
                            arr_data.push($item.totalPrice);
                        });
                        // polarArea
                        // console.log(arr_label);
                        // console.log(arr_data);
                        // paintPieChart(pieChart, arr_label, arr_data);
                        // updateData(myPieChart,arr_data);
                        updateData(myPieChart, arr_label, arr_data);
                    }
                });
            });

            $.ajax({
                url : '{{ route('brand/api/getAll') }}',
                data: {

                },
                method: 'GET',
                success: function (response) {
                    // console.log(response.brands);
                    let data = response.brands;
                    let html = brand.html();
                    data.forEach(function (item) {
                        html += '<option value="' + item.id + '">' + item.name + '</option>';
                    });
                    brand.html(html);
                },
            });

            $('.js-btn-statistics-3').on('click',function () {
                let b = $(this).parents('.card-header').find('.select-brand').val();
                let y = $(this).parents('.card-header').find('.select-year').val();
                let m = $(this).parents('.card-header').find('.select-month').val();
                $.ajax({
                    url : '{{route('getProductByBrand')}}',
                    async: false,
                    data: {
                        bra_id: b,
                        year: y,
                        month: m
                    },
                    method: 'GET',
                    success: function (response) {
                        console.log(response);
                        let data = response.data;
                        // console.log(data);
                        let html = '';
                        data.forEach(function (item) {
                            html += '<tr><td>'+item.name+'</td><td>'+item.count+'</td></tr>';
                        });
                        $('.js-tbody-statistics-3').html(html);

                    }
                });

            });
        });
    </script>
@endsection
