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
@section('body.title','Quản lý đánh giá')
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
{{--                        <th class="js-sort" data-sort="created_at"><span class="mr-2">Ngày tạo</span><span class="icon-sort text-center"><i class="fas fa-sort"></i></span></th>--}}
{{--                        <th class="js-sort" data-sort="updated_at"><span class="mr-2">Ngày cập nhật</span><span class="icon-sort text-center"><i class="fas fa-sort"></i></span></th>--}}
                        <th class="js-sort" data-sort="review_count">Đánh giá</th>
                        <th class="text-center">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
{{--                            <td>{{ $product->created_at }}</td>--}}
{{--                            <td>{{ $product->updated_at }}</td>--}}
                            <td>{{ $product->review_count }}</td>
                            <td class="text-center">
                                <a class="btn btn-secondary btn-sm js-btn-view" href="/reviews?product={{$product->id}}"><i class="fas fa-eye"></i></a>
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
