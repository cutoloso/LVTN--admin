@extends('layouts.master')
@section('header.title','Nhóm thuộc tính chính')
@section('body.title','Danh sách nhóm thuộc tính chính')
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
                        <th>Tên nhóm thuộc tính</th>
                        <th>Tên không dấu</th>
                        <th>Thuộc tính 1</th>
                        <th>Thuộc tính 2</th>
                        <th>Thuộc tính phụ</th>
                        <th>Ngày cập nhật</th>
                        <th colspan="2" class="text-center">
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-plus"></i></button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($attribute_group as $att_group)
                        <tr>
                            <td>{{ $att_group->name }}</td>
                            <td>{{ $att_group->alias }}</td>
                            <td>
                                @if($att_group->att_name_1 != '')
                                    {{ $att_group->att_name_1 }}
                                @endif
                            </td>
                            <td>
                                @if($att_group->att_name_2 != '')
                                    {{ $att_group->att_name_2 }}
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-info js-btn-addAtt"  data-id="{{$att_group->id}}"><i class="fas fa-eye"></i></button>
                            </td>
{{--                            <td>{{ $att_group->created_at }}</td>--}}
                            <td>{{ $att_group->updated_at }}</td>
                            <td class="text-center">
                                <button class="btn btn-secondary js-btn-edit" data-id="{{$att_group->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-edit"></i></button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger js-btn-del" data-id="{{$att_group->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{ $attribute_group->links() }}
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
                    <h4 class="modal-title">Thêm mới nhóm thộc tính chính</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{route('attribute-group.store')}}" name="frmAdd" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Tên nhóm thuộc tính:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="name">Tên không dấu</label>
                            <input type="text" class="form-control" id="alias" name="alias" placeholder="" >
                        </div>
                        <div class="form-group">
                            <label for="icon">Thuộc tính 1:</label>
                            <input type="text" class="form-control" id="att_name_1" name="att_name_1" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="icon">Thuộc tính 2:</label>
                            <input type="text" class="form-control" id="att_name_2" name="att_name_2" placeholder="">
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
                    <h4 class="modal-title">Chỉnh sửa nhóm thuộc tính</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" name="frmEdit" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Tên nhóm thuộc tính:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="name">Tên không dấu</label>
                            <input type="text" class="form-control" id="alias" name="alias" placeholder="" >
                        </div>
                        <div class="form-group">
                            <label for="icon">Thuộc tính 1:</label>
                            <input type="text" class="form-control" id="att_name_1" name="att_name_1" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="icon">Thuộc tính 2:</label>
                            <input type="text" class="form-control" id="att_name_2" name="att_name_2" placeholder="">
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

    <!-- Modal addAtt-->
    <div class="modal fade" id="modalAddAtt">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thuộc thuộc tính phụ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{route('attribute/api/post')}}" name="frmAddAtt" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    @csrf
                    <input type="hidden" value="" id="idGroup" name="idGroup">
                    <div class="modal-body">

                    </div>
                    <input type="hidden" name="arrs_start" id="arrs_start">
                    <!-- Modal footer -->
                    <div class="modal-footer" >
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
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
                        url: '{{route('attribute-group.index')}}'+'/'+id,
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
                let url = '{{route('attribute-group.index')}}' + '/' + id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#modalEdit form').attr('action',url);
                        $('#modalEdit .modal-body #name').val(data['name']);
                        $('#modalEdit .modal-body #alias').val(data['alias']);
                        $('#modalEdit .modal-body #att_name_1').val(data['att_name_1']);
                        $('#modalEdit .modal-body #att_name_2').val(data['att_name_2']);
                        $('#modalEdit').modal('show');
                    }
                });
            });
            $('.js-btn-addAtt').click(function () {

                let id = $(this).data('id');
                let url = 'attribute/api/getAll/' + id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                    //
                    },
                    success: function(data) {
                        console.log(data);
                        let html = '';
                        let listCheck = data.attributesGroupAttribute;
                        function isCheck(value) {
                            var flag = false;
                            listCheck.forEach(function(att) {
                                if (att.att_id === value) flag = true;
                            })
                            return flag;
                        }
                        data.attributes.forEach(function(att) {
                            if (isCheck(att.id)){
                                html += '<div class="custom-control custom-switch">\n' +
                                    ' <input type="checkbox" class="custom-control-input" id="'+att.id+'" name="atts['+att.id+']" checked value="'+ att.id +'">\n' +
                                    '<label class="custom-control-label" for="'+att.id+'">'+att.name+'</label>\n' +
                                    '</div>';
                            }
                            else{
                            html += '<div class="custom-control custom-switch">\n' +
                                ' <input type="checkbox" class="custom-control-input" id="'+att.id+'" name="atts['+att.id+']" value="'+ att.id +'">\n' +
                                '<label class="custom-control-label" for="'+att.id+'">'+att.name+'</label>\n' +
                                '</div>';
                            }
                        });
                        $('#modalAddAtt .modal-body').html(html);
                        // convert object to string
                        $('#modalAddAtt #arrs_start').val(listCheck.map(function (obj) {
                            return obj.att_id;
                        }));
                        $('#modalAddAtt #idGroup').val(id);
                        $('#modalAddAtt').modal('show');
                    }
                });
            });
        });

    </script>
@endsection()
