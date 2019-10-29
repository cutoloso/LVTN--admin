@extends('layouts.master')
@section('header.title','sản phẩm')
@section('header.css')
    <style>
        .brand_img img{
            max-height: 25px;
            display: block;
            margin: 0 auto;
        }
        .table td, .table th {
            font-size: 13px;
        }
    </style>
@endsection
@section('body.title','Danh sách sản phẩm')
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
                        <th class="js-sort" data-sort="name"><span class="mr-2">Tên</span><i class="fas fa-sort"></i></th>
                        <th class="js-sort" data-sort="code"><span class="mr-2">Mã</span><i class="fas fa-sort"></i></th>
{{--                        <th>Tên không dấu</th>--}}
                        <th>Ảnh đại diện</th>
                        <th class="js-sort" data-sort="price"><span class="mr-2">Giá gốc</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="price_sale"><span class="mr-2">Giá khuyến mãi</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
{{--                        <th>Mã sản phẩm cha</th>--}}
                        <th class="js-sort" data-sort="quatity"><span class="mr-2">Số lượng</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort text-center" data-sort="active"><span class="mr-2">Đang bán/Ngưng bán</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort text-center" data-sort="best_sale"><span class="mr-2">Bán chạy</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort text-center" data-sort="best_feature"><span class="mr-2">Nổi bật</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="att_gr_name"><span class="mr-2">Nhóm thuộc tính chính</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="bra_name"><span class="mr-2">Nhãn hiệu</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="sup_name"><span class="mr-2">Nhà cung cấp</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th class="js-sort" data-sort="created_at"><span class="mr-2">Ngày tạo</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
{{--                        <th>Ngày cập nhật</th>--}}
                        <th class="js-sort" data-sort="warranty"><span class="mr-2">Bảo hành</span><div class="icon-sort text-center"><i class="fas fa-sort"></i></div></th>
                        <th colspan="2" class="text-center">
                            <a class="btn btn-success btn-sm" href="{{route('product.create')}}"><i class="fas fa-plus"></i></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->code }}</td>
{{--                            <td>{{ $product->alias }}</td>--}}
                            <td class="text-center">
                                <a class="btn btn-secondary btn-sm" href="/product/{{$product->id}}/gallery"><i class="fas fa-eye"></i></a>
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->price_sale }}</td>
{{--                            <td>{{ $product->parent }}</td>--}}
                            <td>{{ $product->quatity }}</td>
                            <td class="text-center">
                                @if($product->active==1) <i class="fas fa-check text-success"></i>
                                @else <i class="fas fa-times text-danger"></i>
                                @endif
                            </td><td class="text-center">
                                @if($product->best_sale==1) <i class="fas fa-check text-success"></i>
                                @else <i class="fas fa-times text-danger"></i>
                                @endif
                            </td><td class="text-center">
                                @if($product->best_feature==1) <i class="fas fa-check text-success"></i>
                                @else <i class="fas fa-times text-danger"></i>
                                @endif
                            </td>
                            <td>{{ $product->att_gr_name }}<br>
                                <a href="/product/{{$product->id}}/attribute-value" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
                            </td>
{{--                            <td>--}}
{{--                                <button class="btn btn-secondary"><i class="fas fa-eye"></i></button>--}}
{{--                            </td>--}}
                            <td>{{ $product->bra_name }}</td>
                            <td>{{ $product->sup_name }}</td>
                            <td>{{ $product->created_at }}</td>
{{--                            <td>{{ $product->updated_at }}</td>--}}
                            <td>{!! $product->warranty !!} tháng</td>
{{--                            <td class="text-center">--}}
{{--                                <button class="btn btn-secondary btn-sm js-btn-edit" data-id="{{$product->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-edit"></i></button>--}}
{{--                            </td>--}}
                            <td class="text-center">
                                <a class="btn btn-secondary btn-sm js-btn-edit" href="{{route('product.edit',$product->id)}}"><i class="fas fa-edit"></i></a>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm js-btn-del" data-id="{{$product->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{ $products->links() }}
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

            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            $('.js-btn-del').click(function () {
                if(confirm('Vui lòng xác nhận trước khi xóa!')){
                    let id = $(this).data('id');
                    $.ajax({
                        url: '{{route('product.index')}}' + '/' + id,
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
                location.replace(s+b);
            });

        });

    </script>
@endsection()
