@extends('layouts.master')
@section('header.title','Khuyến mãi')
@section('body.title','Danh sách khuyến mãi')
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
                        <th>Khuyến mãi</th>
                        <th>Mô tả</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Ngày cập nhật</th>
                        <th colspan="2" class="text-center">
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-plus"></i></button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->name }}</td>
                            <td>{{ $sale->description }}</td>
                            <td>{{ $sale->date_start }}</td>
                            <td>{{ $sale->date_end }}</td>
                            <td>{{ $sale->updated_at }}</td>
                            <td class="text-center">
                                <button class="btn btn-secondary js-btn-edit" data-id="{{$sale->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-edit"></i></button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger js-btn-del" data-id="{{$sale->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{ $sales->links() }}
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
                    <h4 class="modal-title">Thêm mới khuyến mãi</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{route('sale.store')}}" name="frmAdd" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">khuyến mãi:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả:</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="date_start">Ngày bắt đầu:</label>
                            <input type="date" class="form-control" id="date_start" name="date_start" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="date_end">Ngày kết thúc:</label>
                            <input type="date" class="form-control" id="date_end" name="date_end" placeholder="" autofocus>
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
                    <h4 class="modal-title">Chỉnh sửa khuyến mãi</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" name="frmEdit" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">khuyến mãi:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả:</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="date_start">Ngày bắt đầu:</label>
                            <input type="date" class="form-control" id="date_start" name="date_start" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="date_end">Ngày kết thúc:</label>
                            <input type="date" class="form-control" id="date_end" name="date_end" placeholder="" autofocus>
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
                        url: '{{route('sale.index')}}'+'/'+id,
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
                let url = '{{route('sale.index')}}' + '/' + id;
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
                        $('#modalEdit .modal-body #date_start').val(data['date_start']);
                        $('#modalEdit .modal-body #date_end').val(data['date_end']);
                        $('#modalEdit').modal('show');
                    }
                });
            });
        });
    </script>
@endsection()
