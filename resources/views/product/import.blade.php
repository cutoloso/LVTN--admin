@extends('layouts.master')
@section('header.title','Import sản phẩm')
@section('header.css')
    <link rel="stylesheet" href="{{asset("css/quill.css")}}">
    <link rel="stylesheet" href="{{asset("css/quill.snow.css")}}">
    <link rel="stylesheet" href="{{asset("css/quill.bubble.css")}}">
@endsection
@section('body.title','Import thêm sản phẩm')
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
            <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="custom-file">
                    <input class="custom-file-input" type="file" name="file" class="form-control" accept=".csv">
                    <label class="custom-file-label" for="customFile">Choose file .csv</label>
                </div>
                <br>
                <div class="mt-2">
                    <button class="btn btn-success">Nhập sản phẩm</button>
                    <div class="dropdown d-inline-block ml-2">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                            Chọn định dạng xuất
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('export',['type'=>'csv']) }}">.CSV</a>
                            <a class="dropdown-item" href="{{ route('export',['type'=>'xlsx']) }}">.XLSX</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- The Modal -->


@endsection
@section('body.js')
@endsection
