@extends('layouts.master')
@section('header.title','Nhà cung cấp')
@section('header.css')
    <style>
        .btn-del{
            cursor: pointer;
        }
        .brand_img img{
            max-height: 25px;
            display: block;
            margin: 0 auto;
        }
    </style>
@endsection()
@section('body.title','Danh sách nhà cung cấp')
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
                        <th>Name</th>
                        <th>Hình đại diện</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th colspan="2" class="text-center">
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-plus"></i></button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->name }}</td>
                            <td class="brand_img">
                                @if ($supplier->img != '')
                                    <img src="{{asset('storage/suppliers/'.$supplier->img)}}" alt="">
                                @else
                                    <img src="" alt="">
                                @endif
                            </td>
                            <td>{{ $supplier->created_at }}</td>
                            <td>{{ $supplier->updated_at }}</td>
                            <td class="text-center">
                                <button class="btn btn-secondary js-btn-edit" data-id="{{$supplier->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-edit"></i></button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger js-btn-del" data-id="{{$supplier->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{ $suppliers->links() }}
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
                    <h4 class="modal-title">Thêm mới nhà cung cấp</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{route('suppliers.store')}}" name="frmAdd" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Tên nhà cung cấp:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus>
                        </div>
                        <p class="mb-1">Chọn hình đại diện</p>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="img" name="img">
                            <label class="custom-file-label" for="customFile">Choose file</label>
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
                    <h4 class="modal-title">Chỉnh sửa nhà cung cấp</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" name="frmEdit" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Tên nhà cung cấp:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus>
                        </div>
                        <p class="mb-1">Chọn hình đại diện</p>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="img" name="img">
                            <label id="name_img" class="custom-file-label" for="customFile">Choose file</label>
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
        });

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $('.js-btn-del').click(function () {
            if(confirm('Vui lòng xác nhận trước khi xóa!')){
                let id = $(this).data('id');
                $.ajax({
                    url: '{{route('suppliers.index')}}'+'/'+id,
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
            let url = '{{route('suppliers.index')}}' + '/' + id;
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#modalEdit form').attr('action',url);
                    $('#modalEdit .modal-body #name').val(data['name']);
                    $('#modalEdit .modal-body #name_img').text(data['img']);
                    $('#modalEdit').modal('show');
                }
            });
        });
    </script>
@endsection()
