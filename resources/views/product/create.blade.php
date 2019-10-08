@extends('layouts.master')
@section('header.title','Thêm sản phẩm')
@section('header.css')
    <link rel="stylesheet" href="{{asset("css/quill.css")}}">
    <link rel="stylesheet" href="{{asset("css/quill.snow.css")}}">
    <link rel="stylesheet" href="{{asset("css/quill.bubble.css")}}">
@endsection
@section('body.title','Thêm sản phẩm')
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
            <form action="{{route('product.store')}}" name="frmEdit" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Tên sản phẩm:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus required>
                </div>
                <div class="form-group">
                    <label for="code">Mã sản phẩm:</label>
                    <input type="text" class="form-control" id="code" name="code" placeholder="">
                </div>
                <div class="form-group">
                    <label for="alias">Tên không dấu của sản phẩm:</label>
                    <input type="text" class="form-control" id="alias" name="alias" placeholder="">
                </div>
                <p class="mb-1">Chọn hình đại diện</p>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="img" name="img">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <div class="form-group">
                    <label for="price">Giá sản phẩm:</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="price_sale">Giá sale của sản phẩm:</label>
                    <input type="text" class="form-control" id="price_sale" name="price_sale" placeholder="">
                </div>
                <div class="form-group">
                    <label for="parent">Mã sản phẩm cha:</label>
                    <input type="text" class="form-control" id="parent" name="parent" placeholder="">
                </div>
                <div class="form-group">
                    <label for="quatity">Số lượng sản phẩm:</label>
                    <input type="text" class="form-control" id="quatity" name="quatity" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="quatity">Số tháng bảo hành (mặc định là 12):</label>
                    <input type="number" class="form-control" id="warranty" name="warranty" placeholder="" value="">
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="switch" name="active">
                    <label class="custom-control-label" for="switch">Trạng thái sản phẩm (Đang bán /Ngưng bán):</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="switch2" name="best_sale">
                    <label class="custom-control-label" for="switch2">Sản phẩm bán chạy</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="switch3" name="best_feature">
                    <label class="custom-control-label" for="switch3">Sản phẩm nổi bật</label>
                </div>
                <br>
                <div class="form-group">
                    <label for="sel1">Nhóm thuộc tính:</label>
                    <select name="att_gr_id" id="att-gr-id" class="custom-select mb-3 js-att-gr-id"></select>
                </div>
                <div class="form-group">
                    <label for="sel1">Thương hiệu:</label>
                    <select name="bra_id" id="bra-id" class="custom-select mb-3 js-bra-id"></select>
                </div>
                <div class="form-group">
                    <label for="sel1">Nhà cung cấp:</label>
                    <select name="sup_id" id="sup-id" class="custom-select mb-3 js-sup-id"></select>
                </div>
                <p>Mô tả của sản phẩm</p>
                <textarea class="form-control" id="summary-ckeditor" name="description"></textarea>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
    <!-- The Modal -->


@endsection
@section('body.js')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'summary-ckeditor', {
            height: 1000,
            extraPlugins: 'colorbutton,colordialog',
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>

    <script>
        $(document).ready(function () {
            $(".custom-file-input").on("change", function () {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
            // get brand
            $.ajax({
                url: '{{route('brand/api/getAll')}}',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    let html = '';
                    data.brands.forEach(function (brand) {
                        html += '<option value="' + brand.id + '">' + brand.name + '</option>';
                    });
                    $('.js-bra-id').html(html);
                }
            });
            // get attribute group
            $.ajax({
                url: '{{route('attribute-group/api/getAll')}}',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    let html = '';
                    data.attribute_group.forEach(function (att_gr) {
                        html += '<option value="' + att_gr.id + '">' + att_gr.name + '</option>';
                    });
                    $('.js-att-gr-id').html(html);
                }
            });
            // get attribute group
            $.ajax({
                url: '{{route('supplier/api/getAll')}}',
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    let html = '';
                    data.suppliers.forEach(function (supplier) {
                        html += '<option value="' + supplier.id + '">' + supplier.name + '</option>';
                    });
                    $('.js-sup-id').html(html);
                }
            });

        });

    </script>
@endsection()
