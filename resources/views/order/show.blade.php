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

        #order-received .order-info .table tbody tr:first-child td {
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

        .card-header {
            color: #fff;
            background-color: #4c75ed;
        }


    </style>

    {{--    <link href="{{asset('css/jquery.fancybox.min.css')}}" rel="stylesheet">--}}
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
                                            <td><?php echo priceToString($price)?></td>
                                        </tr>
                                        <tr>
                                            <td>Mã máy:</td>
                                            <td>{{$product->code}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ngày đặt hàng:</td>
                                            <td>{{$order->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Phương thức thanh toán:</th>
                                        <td>{{$order->pay_mth_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái thanh toán:</th>
                                        <td>{{$order->pay_sta_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái đơn hàng:</th>
                                        <td>{{$order->sta_name}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Tổng:</th>
                                        <td><?php echo priceToString($order->total_price)?></td>
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
                <div class="col-12 text-center mt-3 print-order">
                    In hóa đơn
                    <a class="btn btn-success" data-toggle="modal" data-target="#printer-modal" style="cursor: pointer;">
                        <i class="fas fa-print" style="color: #fff"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- The Modal -->
<?php //dd($order); ?>
    <!-- Modal Print-->
    <div class="modal fade" id="printer-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">In hóa đơn</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="printer" class="col-12">
                        <div>
                            <table style="width: 100%;  border: 1px solid #000; border-bottom: 1px dashed #000;">
                                <tr>
                                    <td style="width: 25%; padding: 5px;">
                                        <div class="logo-holder">
                                            <img style="max-width: 100%;" src="{{asset('images/logo.png')}}"/>
                                        </div>
                                    </td>
                                    <td style="width: 25%; padding: 5px;">
                                        <div class="logo-holder">
                                            <img style="max-width: 100%"
                                                 src="">
                                        </div>
                                    </td>
                                    <td style="padding: 5px;">
                                        Mã đơn hàng: <strong>{{$order->id}}</strong>
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%; border-left: 1px solid #000;border-right: 1px solid #000;">
                                <tr>
                                    <td style="width: 50%;padding: 5px; vertical-align: baseline;">
                                        <strong>Từ </strong>AZ Mobile<br>
                                         <br>

                                    </td>
                                    <td style="width: 50%;padding: 5px; vertical-align: baseline;">
                                        <strong>Đến </strong>{{$order->name}}<br>
                                        {{$order->address}}<br>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;padding: 5px; vertical-align: baseline;">
                                        <strong>SĐT</strong>: 0909090909
                                    </td>
                                    <td style="width: 50%;padding: 5px;">
                                        <strong>SĐT</strong>: {{$order->phone}}
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%; border-collapse: collapse; font-size: small; " border="1">
                                <tr>
                                    <td style="width: 50%;padding: 5px;" colspan="4">
                                        <strong>Nội dung vận chuyển</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px; text-align:center;">
                                        STT
                                    </td>
                                    <td style="padding: 5px;">
                                        Tên
                                    </td>
                                    <td style="padding: 5px; text-align:center;">
                                        Số lượng
                                    </td>
                                    <td style="padding: 5px; text-align:center;">
                                        Giá
                                    </td>
                                </tr>
                                @php $stt = 0; @endphp
                                @foreach($orderProduct as $product)
                                    @php $stt++; @endphp
                                    <tr>
                                        <td style="padding: 5px; text-align:center;">
                                            {{$stt}}
                                        </td>
                                        <td style="padding: 5px;">
                                            {{$product->name}}
                                        </td>
                                        <td style="padding: 5px; text-align:center;">
                                            {{$product->quantity}}
                                        </td>
                                        <td style="padding: 5px; text-align:center;">
                                            {{$product->price_sale}}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="width: 50%;padding: 5px;" colspan="2">
                                        <strong>Tổng sản phẩm</strong>
                                    </td>
                                    <td style="padding: 5px; text-align:center;">
                                        <strong>{{$stt}}</strong>
                                    </td>
                                    <td style="padding: 5px; text-align: center;">
                                        <strong>{{$order->total_price}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;padding: 5px; vertical-align: baseline;" colspan="2">
                                        <strong>Tiền thu người nhận</strong> <br>
                                        <div style="font-size: x-large;font-weight: bold;">{{$order->total_price}}</div>
                                    </td>
                                    <td style="width: 50%;padding: 5px; text-align:center;" colspan="2">
                                        <strong>Chữ ký người nhận </strong><br>
                                        <small>(Xác nhận hàng nguyên vẹn)</small>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary is-small" onclick="onPrint()">
                        IN PHIẾU
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('body.js')

    {{--    <script src="{{asset('js/jquery.fancybox.min.js')}}"></script>--}}

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

        }); //end document ready

        function onPrint() {
            const feature = 'width=800,height=700,top=100,left=200,toolbars=no,scrollbars=yes,status=no,resizable=no';
            const WindowObject = window.open('', 'PrintWindow', feature);
            const template = document.getElementById('printer').innerHTML;
            WindowObject.document.writeln(template);
            setTimeout(function () { // wait until all resources loaded
                WindowObject.document.close(); // necessary for IE >= 10
                WindowObject.scrollTo(0, 0);
                WindowObject.focus(); // necessary for IE >= 10
                WindowObject.print(); // change window to winPrint
                WindowObject.close(); // change window to winPrint
            }, 250);
        };

        // function PrintElem(elem)
        // {
        //     var mywindow = window.open('', 'PRINT', 'height=400,width=600');
        //
        //     mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        //     mywindow.document.write('</head><body >');
        //     mywindow.document.write('<h1>' + document.title  + '</h1>');
        //     mywindow.document.write(document.getElementById(elem).innerHTML);
        //     mywindow.document.write('</body></html>');
        //
        //     mywindow.document.close(); // necessary for IE >= 10
        //     mywindow.focus(); // necessary for IE >= 10*/
        //
        //     mywindow.print();
        //     mywindow.close();
        //
        //     return true;
        // }
    </script>

@endsection
