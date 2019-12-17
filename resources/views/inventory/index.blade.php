@extends('layouts.master')
@section('header.title','QL tài khoản')
@section('header.css')
    <style>
        .js-sort{
            text-align: left;
        }
    </style>
@endsection()
@section('body.title','Quản lý tồn kho')
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
                        <th class="js-sort" data-sort="name"><span class="mr-2">Tên sản phẩm</span><i class="fas fa-sort"></i></th>
                        <th class="js-sort" data-sort="quatity"><span class="mr-2">Số lượng</span><i class="fas fa-sort"></i></th>
                        <th class="text-center">
                            Cập nhật số lượng
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>
                                {{ $product->quatity }}
                                @if($product->quatity < 5)
                                    <i class="text-danger fas fa-exclamation-triangle"></i>
                                    @endif
                            </td>
                            <td class="text-center">
                                <a class="btn btn-secondary js-btn-edit" href="{{route('inventory.show',$product->id)}}"><i class="fas fa-edit"></i></a>
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
            // get group
            $.ajax({
                url: '{{route('group/api/getAll')}}',
                type: 'GET',
                success: function (data) {
                    let html = '';
                    // console.log(data);
                    data.groups.forEach(function (group) {
                        html += '<option value="' + group.gr_id + '">' + group.description + '</option>';
                    });
                    $('#gr_id').html(html);
                }
            });

            // select option
            function select_option(selected, value) {
                $(selected+' option').prop('selected',false);
                return $(selected+' option[value="' + value + '"]').prop('selected',true);
            }
            $('.js-btn-edit').click(function () {
                let id = $(this).data('id');
                let url = '{{route('user.index')}}' + '/' + id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let data = response.user;
                        console.log(data);

                        $('#modalEdit form').attr('action',url);
                        $('#modalEdit .modal-body #name').val(data.name);
                        $('#modalEdit .modal-body #email').val(data.email);
                        select_option('.js-gr_id-id',data.gr_id);
                        if(data.active === 1)
                            $('#switch').prop('checked',true);
                        else
                            $('#switch').prop('checked',false);

                        $('#modalEdit').modal('show');
                    }
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
