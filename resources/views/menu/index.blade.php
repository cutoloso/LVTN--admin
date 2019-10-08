@extends('layouts.master')
@section('header.title','sản phẩm')
@section('header.css')
    <style>

    </style>
@endsection()
@section('body.title','Menu trang chủ')
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
                        <th>STT</th>
                        <th>Danh mục</th>
                        <th>Đường dẫn</th>
                        <th colspan="2" class="text-center">
                            <button class="btn btn-success" id="js-btn-add" data-toggle="modal" data-target="#modalAdd">
                                <i class="fas fa-plus"></i></button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    <form id="frmUpdate" action="{{route('menu.index')}}" method="post">--}}
                        @csrf
                        @method('PUT')
                        @foreach($menus as $menu)
                            <tr>
                                <td>{{$menu->sort}}</td>
                                <input type="hidden" name="sort[]" value="{{$menu->sort}}">
                                <td>{{$menu->name}}</td>
                                <input type="hidden" name="cat_id[]" value="{{$menu->cat_id}}">
                                <td>{{$menu->link}}</td>
                                <td class="text-center">
                                    <button class="btn btn-secondary js-btn-edit" data-id="{{$menu->cat_id}}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger js-btn-del" data-id="{{$menu->cat_id}}"
                                            data-token="{{ csrf_token() }}"><i class="fas fa-minus"></i></button>
                                </td>
                            </tr>
                        @endforeach
{{--                    </form>--}}
                    </tbody>
{{--                    <tfoot>--}}
{{--                    <tr class="text-center">--}}
{{--                        <td>--}}
{{--                            <button class="btn btn-success mr-3" onclick="moveRow('up')"><i class="fas fa-caret-up"></i>--}}
{{--                            </button>--}}
{{--                            <button class="btn btn-success" onclick="moveRow('down')"><i class="fas fa-caret-down"></i>--}}
{{--                            </button>--}}
{{--                        </td>--}}
{{--                        <td></td>--}}
{{--                        <td>--}}
{{--                            <button id="js-btn-update" class="btn btn-primary">Cập nhật</button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}

{{--                    </tfoot>--}}
                </table>

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
                    <h4 class="modal-title">Thêm mới danh mục vào menu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{route('menu.index')}}" name="frmAdd" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <label for="sel1">Danh mục:</label>
                            <select name="cat_id" id="cat-id" class="custom-select mb-3 js-cat-id"></select>
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
    <!-- Modal Edit-->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Chỉnh sửa danh mục vào menu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" name="frmEdit" method="post">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="sel1">Danh mục:</label>
                            <select name="cat_id" id="cat-id" class="custom-select mb-3 js-cat-id"></select>
                        </div>
                        <div class="form-group">
                            <label for="link">Đường dẫn:</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="">
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

            $.ajax({
                url: '{{route('category/api/getAll')}}',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    console.log(data);
                    let html = '';
                    data.category.forEach(function (cat) {
                        html += '<option value="' + cat.id + '">' + cat.name + '</option>';
                    });
                    $('.js-cat-id').html(html);
                }
            });

            $('#js-btn-update').click(function () {
                $('#frmUpdate').submit();
            });
            $('.js-btn-del').click(function () {
                if (confirm('Vui lòng xác nhận trước khi xóa!')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: '/menu/' + id,
                        type: 'DELETE',
                        data: {
                            "_token": $(this).data('token'),
                        },
                        success: function (request) {
                            location.reload();
                        },
                        error: function (request) {
                            console.log(request)
                        }
                    });
                }
            });

            // select option
            function select_option(selected, value) {
                $(selected+' option').prop('selected',false);
                return $(selected+' option[value="' + value + '"]').prop('selected',true);
            }

            $('.js-btn-edit').click(function () {
                let id = $(this).data('id');
                let url = '{{route('menu.index')}}' + '/' + id;
                // get menu
                $.ajax({
                    url: '{{route('category/api/getAll')}}',
                    type: 'GET',
                    success: function (response) {
                        data = response.category;
                        let html = '';
                        data.forEach(function (cat) {
                            html += '<option value="' + cat.id + '">' + cat.name + '</option>';
                        });
                        $('.js-cat-id').html(html);
                        select_option('.js-cat-id',id);
                        $('#modalEdit form').attr('action',url);
                        $('#modalEdit .modal-body #link').val(data['name']);
                    }
                });
                $('#modalEdit').modal('show');
            });
        });
        // var rowCurrent;
        // var index = -1;
        // var rows = $('#dataTable tbody tr');
        // rows.click(function () {
        //     if (index !== -1) {
        //         $('#dataTable tbody tr').eq(index).removeClass('bg-primary text-white');
        //     }
        //     rowCurrent = $(this);
        //     $(this).addClass('bg-primary text-white');
        //     index = $(this).index();
        //     console.log(index);
        // });
        //
        // function moveRow(option) {
        //     $parent = $('#dataTable tbody tr');
        //     if (option === 'up') {
        //         if (index > 0) {
        //             $('#dataTable tbody tr').eq(index).removeClass('bg-primary text-white');
        //             rowCurrent.insertBefore(rowCurrent.prev('tr'));
        //             index--;
        //             $('#dataTable tbody tr').eq(index).addClass('bg-primary text-white');
        //         }
        //     } else {
        //         if (index < rows.length - 1) {
        //             $('#dataTable tbody tr').eq(index).removeClass('bg-primary text-white');
        //             rowCurrent.insertAfter(rowCurrent.next('tr'));
        //             index++;
        //             $('#dataTable tbody tr').eq(index).addClass('bg-primary text-white');
        //         }
        //     }
        //     console.log(index);
        // }
    </script>
@endsection()
