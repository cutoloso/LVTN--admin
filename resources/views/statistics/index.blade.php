@extends('layouts.master')
@section('header.title','Đơn hàng')
@section('header.css')
    <style>
        #payment-status-year{
            width: max-content;
        }
        .card-year{
            display: flex;
            align-items: center;
        }
        .frm-year, .year-title{
            display: inline-block;
            margin-bottom: 0;
        }
        .year-title{
            padding-right: 1rem;
        }
        #payment-status-year{
            margin-bottom: 0 !important;
        }
    </style>
@endsection
@section('body.title','Danh sách trạng thái đơn hàng')
@section('body.content')
    <!-- Area Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 card-year">
            <h6 class="year-title m-0 font-weight-bold text-primary">Thống kê doanh thu cửa hàng theo tháng</h6>
            <div class="form-group frm-year">
                <select name="year" id="payment-status-year" class="custom-select mb-3"></select>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
            <hr>
            <div class="text-center">Biểu đồ doanh thu cửa hàng theo từng tháng.</div>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thống kê số doanh thu cửa hàng theo thương hiệu</h6>
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
@endsection
@section('body.js')

    <!-- Page level plugins -->
    <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/chart-area-demo.js')}}"></script>
    <script src="{{asset('js/chart-pie-demo.js')}}"></script>
    <script>
        $(document).ready(function () {
            const areaChart = $("#myAreaChart");
            const pieChart = $("#myPieChart");
            const year = $('#payment-status-year');

            // Generic function to make an AJAX call
            let fetchData = function(query, dataURL) {
                // Return the $.ajax promise
                return $.ajax({
                    data: query,
                    dataType: 'json',
                    url: dataURL
                });
            };

            let getYear = fetchData('','{!! route('get-year-order') !!}');

            $.when(getYear).then(function (response) {
                let data = response.data;
                console.log(data);
                let html = '';
                data.forEach(function (item) {
                    html += '<option value="' + item.year + '">' + item.year + '</option>';
                });
                year.html(html);
            }).then(function () {
                let y = year.val();
                $.ajax({
                    url : 'http://127.0.0.1:8000/sales-by-mounth',
                    data: {
                        year: y
                    },
                    method: 'GET',
                    success: function (response) {
                        console.log(response.data);
                        paintAreaChart(areaChart, response.data);
                    },
                });
            }).then(function () {
                let y = year.val();
                $.ajax({
                    url : 'http://127.0.0.1:8000/get-order-by-brand',
                    async: false,
                    data: {
                        year: y
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
                        console.log(arr_label);
                        console.log(arr_data);
                        paintPieChart(pieChart, arr_label, arr_data)
                    }
                });
            });

            year.change(function () {
                let y = year.val();
                // Area Chart Example

                $.ajax({
                    url : 'http://127.0.0.1:8000/sales-by-mounth',
                    data: {
                        year: y
                    },
                    method: 'GET',
                    success: function (response) {
                        console.log(response.data);
                        paintAreaChart(areaChart, response.data);
                    },
                });

                $.ajax({
                    url : 'http://127.0.0.1:8000/get-order-by-brand',
                    async: false,
                    data: {
                        year: y
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
                        console.log(arr_label);
                        console.log(arr_data);
                        paintPieChart(pieChart, arr_label, arr_data)
                    }
                });

            });
        });
    </script>
@endsection
