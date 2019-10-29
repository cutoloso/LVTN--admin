@extends('layouts.master')
@section('header.title','Đơn hàng')
@section('header.css')
    <style>
        .table{
            font-size: 13px;
        }
        .color{
            width: max-content;
            padding: 0 10px;
            height: 32px;
            border-radius: 4px;
            text-align: center;
            line-height: 32px;
            font-weight: bold;
        }
    </style>
@endsection
@section('body.title','Danh sách đơn hàng')
@section('body.content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <!-- table name -->
            @yield('body.table-name')
            <!-- End of table name -->
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <!-- Content page -->
                <input class="form-control" id="iputSearch" type="text" placeholder="Search..">
                <br>
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="js-sort" data-sort="id"><span class="mr-2">Mã đơn hàng</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="created_at"><span class="mr-2">Ngày tạo</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="updated_at"><span class="mr-2">Ngày cập nhật</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="status_name"><span class="mr-2">Tình trạng đơn hàng</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="payment_status_id"><span class="mr-2">Tình trạng thanh toán</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="payment_method_name"><span class="mr-2">Phương thức thanh toán</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="total_price"><span class="mr-2">Tổng</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th colspan="2" class="text-center">
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $ord)
                        <tr>
                            <td>{{ $ord->id }}</td>
                            <td>{{ $ord->created_at }}</td>
                            <td>{{ $ord->updated_at }}</td>
                            <td><div class="color" style="background-color: <?php echo $ord->bg_color_code ?>; color: <?php echo $ord->color_code  ?>;">{{$ord->status_name}}</div></td>
                            <td>{{ $ord->payment_status_name }}@if($ord->payment_status_id == 2) <i class="fas fa-check text-success"></i>
                                @endif</td>
                            <td>{{ $ord->payment_method_name }}</td>
                            <td>{{ priceToString($ord->total_price) }}</td>

                            <td class="text-center">
                                <a class="btn btn-sm btn-success js-btn-show" href="{{route('order.showOrderDetail',$ord->id)}}"><i class="fas fa-eye"></i></a>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-secondary js-btn-edit" data-id="{{$ord->id}}" data-sta-id="{{$ord->sta_id}}"  data-pay-sta-id="{{$ord->pay_sta_id}}" data-token="{{ csrf_token() }}"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{ $orders->links() }}
            <!-- End of Content page -->

            </div>
        </div>
    </div>
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
                            <select name="pay_sta_id" id="payment_status" class="custom-select mb-3 js-payment-status"></select>
                        </div>
                        <div class="form-group">
                            <label for="payment-method">Phương thức thanh toán:</label>
                            <input type="text" class="form-control" id="payment-method" name="payment-method" placeholder="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="total-price">Tổng:</label>
                            <input type="text" class="form-control" id="total-price" name="total_price" placeholder="" readonly>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" >
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('body.js')
    <script>
        $(document).ready(function(){
            $("#iputSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#dataTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('.js-btn-del').click(function () {
                if(confirm('Vui lòng xác nhận trước khi xóa!')){
                    let id = $(this).data('id');
                    let staId = $(this).data('sta-id');
                    let payStaId = $(this).data('pay-sta-id');
                    $.ajax({
                        url: '{{route('status.index')}}'+'/'+id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(request) {
                            location.reload();
                        },
                        error: function(request) {
                            // handle failure
                        }
                    });
                }
            });
            // select option
            function select_option(selected, value) {
                $(selected+' option').prop('selected',false);
                return $(selected+' option[value="' + value + '"]').prop('selected',true);
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
                    success: function(data) {
                        $('#modalEdit form').attr('action',url);
                        $('#id').val(data.order.id);
                        $('#total-price').val(data.order.total_price);
                        select_option('.js-status-name',data.order.sta_id);
                        select_option('.js-payment-status',data.order.pay_sta_id);

                        if(data.order.pay_sta_id === 2){
                            $('#payment_status').attr('disabled',true);
                        }
                        else {
                            $('#payment_status').attr('disabled',false);
                        }
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

            let urlParams = new URLSearchParams(location.search);
            $('.js-sort').click(function () {
                let a=window.location.href;
                let s = a;
                let b='';

                if (urlParams.has('page')){
                    let p = urlParams.get('page');
                    let t="?page="+p;
                    b="?sort="+$(this).data('sort')+"&order=asc";
                    if (urlParams.has('sort')){
                        let o = urlParams.get('sort');
                        let s_temp = urlParams.get('order');
                        t +="&sort="+o+"&order="+s_temp;
                        s = a.replace(t, '');
                        if (s_temp ==='asc'){
                            b="?sort="+$(this).data('sort')+"&order=desc";
                        }
                    }
                    s = a.replace(t, '');
                }
                else {
                    b="?sort="+$(this).data('sort')+"&order=asc";
                    if (urlParams.has('sort')){
                        let s_temp = urlParams.get('order');
                        let o = urlParams.get('sort');
                        let t="?sort="+o+"&order="+s_temp;
                        s = a.replace(t, '');
                        if (s_temp ==='asc'){
                            b="?sort="+$(this).data('sort')+"&order=desc";
                        }
                    }
                }
                console.log(s+b)
                location.replace(s+b);
            });
        });

    </script>
@endsection()
