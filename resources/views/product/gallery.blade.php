@extends('layouts.master')
@section('header.title','hình ảnh')
@section('header.css')
    <style>
        .brand_img img{
            max-height: 100px;
            display: block;
            margin: 0 auto;
        }
        .custom-td{
            vertical-align: middle !important;
        }
    </style>
@endsection()
@section('body.title','Danh sách hình ảnh')
@section('body.content')

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <!-- Content page -->
                <input class="form-control" id="iputSearch" type="text" placeholder="Search..">
                <br>
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Hình ảnh sản phẩm</th>
                        <th>Ảnh đại diện</th>
                        <th colspan="2" class="text-center">
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-plus"></i></button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; ?>
                    @foreach ($product_img as $pro)
                        <tr>
                            <td class="custom-td">
                                <?php echo $i++; ?>
                            </td>
                            <td class="brand_img">
                                @if ($pro->img != '')
                                    <img src="{{asset('storage/products/'.$pro->img)}}" alt="">
                                @else
                                    <img src="" alt="">
                                @endif
                            </td>
                            <td class="text-center">
                                @if($pro->active == 1) <i class="fas fa-check text-success"></i>
                                @endif
                            </td>
                            <td class="text-center custom-td">
                                <button class="btn btn-secondary js-btn-edit" data-id="{{$pro->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-edit"></i></button>
                            </td>
                            <td class="text-center custom-td">
                                <button class="btn btn-danger js-btn-del" data-id="{{$pro->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
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
                    <h4 class="modal-title">Thêm mới hình ảnh</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="/product/{{$id}}/gallery" name="frmAdd" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <p class="mb-1">Chọn hình ảnh</p>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="img" name="img[]" multiple="multiple" accept=".png, .jpg">
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
                    <h4 class="modal-title">Chỉnh sửa hình ảnh</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" name="frmEdit" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="active" name="active">
                            <label class="custom-control-label" for="active">Ảnh đại diện sản phẩm</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="front" name="front">
                            <label class="custom-control-label" for="front">Ảnh mặt trước sản phẩm</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="back" name="back">
                            <label class="custom-control-label" for="back">Ảnh mặt sau sản phẩm</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="above" name="above">
                            <label class="custom-control-label" for="above">Ảnh phía trên sản phẩm</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="below" name="below">
                            <label class="custom-control-label" for="below">Ảnh phía dưới sản phẩm</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="left" name="left">
                            <label class="custom-control-label" for="left">Ảnh bên trái sản phẩm</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="right" name="right">
                            <label class="custom-control-label" for="right">Ảnh bên phải sản phẩm</label>
                        </div>
                        <br>
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
                    let url = '/product/{{$id}}/gallery/' + id;
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(request) {
                            window.location.replace('/product/{{$id}}/gallery');
                        },
                        error: function(request) {
                            // handle failure
                        }
                    });
                }
            });

            $('.js-btn-edit').click(function () {
                let id = $(this).data('id');
                let url = '/product/{{$id}}/gallery/' + id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let data = response.product_img;
                        console.log(data);
                        $('#modalEdit form').attr('action',url);
                        $('#modalEdit .modal-body input[type]').prop('checked',false);
                        if (data.active === 1) $('#modalEdit .modal-body #active').prop('checked',true);
                        if (data.front === 1) $('#modalEdit .modal-body #front').prop('checked',true);
                        if (data.back === 1) $('#modalEdit .modal-body #back').prop('checked',true);
                        if (data.above === 1) $('#modalEdit .modal-body #above').prop('checked',true);
                        if (data.below === 1) $('#modalEdit .modal-body #below').prop('checked',true);
                        if (data.left === 1) $('#modalEdit .modal-body #left').prop('checked',true);
                        if (data.right === 1) $('#modalEdit .modal-body #right').prop('checked',true);

                        $('#modalEdit').modal('show');
                    }
                });
            });

        });

    </script>
@endsection()
