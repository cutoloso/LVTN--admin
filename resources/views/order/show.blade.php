@extends('layouts.master')
@section('header.title','Đơn hàng')
@section('header.css')
    <style>
        #order-received {
            margin-bottom: 3rem
        }

        #order-received .order-info {
            margin-bottom: 2rem
        }

        #order-received .order-info .table {
            margin-bottom: 0
        }

        #order-received .order-info .table tbody tr:first-child td{
            border-top: none
        }

        #order-received .order-info .table span {
            font-family: OpenSans-Bold
        }

        #order-received .order-checkout .table, #order-received .order-info-cus .table {
            margin-bottom: 0
        }

        #order-received .order-checkout .table tr:first-child td, #order-received .order-checkout .table tr:first-child th, #order-received .order-info-cus .table tr:first-child td, #order-received .order-info-cus .table tr:first-child th {
            border-top: none
        }

        #order-received .order-info-cus .title {
            background-color: #f29f29;
            color: #fff;
            font-family: OpenSans-Bold
        }

        #order-received .thanks {
            font-family: OpenSans-Bold
        }
        .card-header{
            color: #fff;
            background-color: #4c75ed;
        }
    </style>
@endsection
@section('body.title','Chi tiết đơn hàng')
@section('body.content')

    <section id="order-received">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="order-info card">
                        <div class="card-header title">Chi tiết đơn hàng</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                    @foreach($orderProduct as $product)
                                        @php
                                            $price = $product->price*$product->quantity;
                                        @endphp
                                        <tr>
                                            <td>{{$product->name}} <span>x {{$product->quantity}}</span></td>
                                            <td><?php echo priceToString($price)?> ₫</td>
                                        </tr>
                                        <tr>
                                            <td>Mã máy:</td>
                                            <td>{{$product->code}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Phương thức thanh toán:</th>
                                        <td>{{$order->pay_name}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Tổng:</th>
                                        <td><?php echo priceToString($order->total_price)?> ₫</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 offset-md-2">
                    <div class="card order-checkout">
                        <div class="card-header title">Địa chỉ thanh toán</div>
                        <div class="card-body content">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr>
                                        <td>Họ và tên: {{$order->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ: {{$order->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại: {{$order->phone}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- The Modal -->

    <!-- Modal Edit-->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật đơn hàng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" name="frmEdit" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="id">Mã đơn hàng:</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="status_name">Trạng thái đơn hàng:</label>
                            <select name="sta_id" id="status_name" class="custom-select mb-3 js-status-name"></select>
                        </div>
                        <div class="form-group">
                            <label for="payment-status">Tình trạng thanh toán:</label>
                            <select name="pay_sta_id" id="payment_status"
                                    class="custom-select mb-3 js-payment-status"></select>
                        </div>
                        <div class="form-group">
                            <label for="payment-method">Phương thức thanh toán:</label>
                            <input type="text" class="form-control" id="payment-method" name="payment-method"
                                   placeholder="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="total-price">Tổng:</label>
                            <input type="text" class="form-control" id="total-price" name="total_price" placeholder=""
                                   readonly>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('body.js')
    <script>
        $(document).ready(function () {
            $("#iputSearch").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#dataTable tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('.js-btn-del').click(function () {
                if (confirm('Vui lòng xác nhận trước khi xóa!')) {
                    let id = $(this).data('id');
                    let staId = $(this).data('sta-id');
                    let payStaId = $(this).data('pay-sta-id');
                    $.ajax({
                        url: '{{route('status.index')}}' + '/' + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (request) {
                            location.reload();
                        },
                        error: function (request) {
                            // handle failure
                        }
                    });
                }
            });

            // select option
            function select_option(selected, value) {
                $(selected + ' option').prop('selected', false);
                return $(selected + ' option[value="' + value + '"]').prop('selected', true);
            }

            // get status
            $.ajax({
                url: '{{route('status/api/getAll')}}',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    let html = '';
                    data.status.forEach(function (sta) {
                        html += '<option value="' + sta.id + '">' + sta.name + '</option>';
                    });
                    $('.js-status-name').html(html);
                }
            });

            // get payment-status
            $.ajax({
                url: '{{route('payment-status/api/getAll')}}',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    let html = '';
                    data.payment_status.forEach(function (pay_sta) {
                        html += '<option value="' + pay_sta.id + '">' + pay_sta.name + '</option>';
                    });
                    $('.js-payment-status').html(html);
                }
            });


            $('.js-btn-edit').click(function () {
                let id = $(this).data('id');
                let url = '{{route('order.index')}}' + '/' + id;
                let staId = $(this).data('sta-id');
                let payStaId = $(this).data('pay-sta-id');

                $.ajax({
                    url: '{{route('order.index')}}' + '/' + id,
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        $('#modalEdit form').attr('action', url);
                        $('#id').val(data.order.id);
                        $('#total-price').val(data.order.total_price);
                        select_option('.js-status-name', data.order.sta_id);
                        select_option('.js-payment-status', data.order.pay_sta_id);

                        // get payment-method
                        $.ajax({
                            url: '{{route('payment-method/api/getAll')}}',
                            type: 'GET',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                $('#payment-method').val(data.payment_method.name);
                            }
                        });
                        $('#modalEdit').modal('show');
                    }
                });
            });
        });

    </script>
@endsection()
