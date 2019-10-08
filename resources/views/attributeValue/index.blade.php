@extends('layouts.master')
@section('header.title','sản phẩm')
@section('header.css')
    <style>
        .alert{
            display: none;
        }
    </style>
@endsection()
@section('body.title','Danh sách thuộc tính')
@section('body.content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <!-- table name -->
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Cập nhật thành công!</strong>
                </div>
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Có lỗi khi cập nhật!</strong>
                </div>
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
                        <th>Tên thuộc tính</th>
                        <th>Giá trị</th>
                        <th colspan="2" class="text-center">
{{--                            <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-plus"></i></button>--}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($att_vals as $att_val)
                        <tr>
                            <td>{{ $att_val->name }}</td>
                            <td>
                                <input class="form-control" type="text" id="{{ $att_val->att_id }}" value="{{ $att_val->att_value }}">
                            </td>
                            <td class="text-center">
                                <button class="btn btn-secondary js-btn-edit" data-id="{{$att_val->att_id}}" data-token="{{ csrf_token() }}"><i class="fas fa-save"></i></button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger js-btn-del" data-id="{{$att_val->att_id}}" data-token="{{ csrf_token() }}"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{ $att_vals->links() }}
            <!-- End of Content page -->

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

            $('.js-btn-edit').click(function () {
                let att_id = $(this).data('id');
                let url = '/product/{{$pro_id}}/attribute-value/'+ att_id;
                let att_value = $('#'+att_id).val();
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        "att_value":att_value,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        $('.alert').css('display','none');
                    },
                    success: function() {
                        // alert('Cập nhật thành công');
                        $('.alert-success').css('display','block');
                    },
                    error: function() {
                        $('.alert-danger').css('display','block');
                    }
                });
            });
            $('.js-btn-del').click(function () {
                let att_id = $(this).data('id');
                let url = '/product/{{$pro_id}}/attribute-value/'+ att_id;
                let att_value = 'Đang cập nhật';
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        "att_value":att_value,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        $('.alert').css('display','none');
                    },
                    success: function() {
                        // alert('Cập nhật thành công');
                        $('#'+att_id).val(att_value);
                        $('.alert-success').css('display','block');
                    },
                    error: function() {
                        $('.alert-danger').css('display','block');
                    }
                });
            });
        });

    </script>
@endsection()
