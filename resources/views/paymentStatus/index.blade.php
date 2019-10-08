@extends('layouts.master')
@section('header.title','Trạng thái thanh toán')
@section('body.title','Danh sách trạng thái thanh toán')
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
                        <th>Trạng thái thanh toán</th>
                        <th>Mô tả</th>
                        <th>Ngày cập nhật</th>
                        <th colspan="2" class="text-center">
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-plus"></i></button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payment_status as $pay_sta)
                        <tr>
                            <td>{{ $pay_sta->name }}</td>
                            <td>{{ $pay_sta->description }}</td>
                            <td>{{ $pay_sta->updated_at }}</td>
                            <td class="text-center">
                                <button class="btn btn-secondary js-btn-edit" data-id="{{$pay_sta->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-edit"></i></button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger js-btn-del" data-id="{{$pay_sta->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{ $payment_status->links() }}
            <!-- End of Content page -->

            </div>
        </div>
    </div>
    <!-- The Modal -->
    <!-- Modal Add-->
    <div class="modal fade" id="modalAdd">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm mới trạng thái thanh toán</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{route('payment-status.store')}}" name="frmAdd" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Trạng thái thanh toán:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả:</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="" autofocus>
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
    <!-- Modal Edit-->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Chỉnh sửa trạng thái thanh toán</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" name="frmEdit" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Trạng thái thanh toán:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả:</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="" autofocus>
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
                    $.ajax({
                        url: '{{route('payment-status.index')}}'+'/'+id,
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
            $('.js-btn-edit').click(function () {
                let id = $(this).data('id');
                let url = '{{route('payment-status.index')}}' + '/' + id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        console.log(data);
                        $('#modalEdit form').attr('action',url);
                        $('#modalEdit .modal-body #name').val(data['name']);
                        $('#modalEdit .modal-body #description').val(data['description']);
                        $('#modalEdit').modal('show');
                    }
                });
            });
        });
    </script>
@endsection()
