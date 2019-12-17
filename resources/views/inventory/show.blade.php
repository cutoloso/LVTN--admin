@extends('layouts.master')
@section('header.title','QL tồn kho')
@section('body.title','Quản lý tồn kho')
@section('body.content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <!-- table name -->
            @yield('body.table-name')
            Sản phẩm {{$product->name}}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <!-- Content page -->
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="js-sort" data-sort="name"><span class="mr-2">Số lượng</span><i class="fas fa-sort"></i></th>
                        <th>Ngày tạo</th>
                        <th class="js-sort" data-sort="updated_at"><span class="mr-2">Ngày cập nhật</span><i class="fas fa-sort"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($inventorys as $inventory)
                        <tr>
                            <td>{{ $inventory->quantity }}</td>

                            <td>{{ $inventory->created_at }}</td>
                            <td>{{ $inventory->updated_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

{{--            {{ $inventorys->links() }}--}}
            <!-- End of Content page -->
                <form action="{{route('inventory.store')}}" name="frmEdit" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Số lượng còn:</label>
                            <input type="text" class="form-control" id="name" name="name" readonly placeholder="" value="{{$product->quatity}}">
                        </div>
                        <div class="form-group">
                            <label for="date">Ngày nhập:</label>
                            <input type="date" class="form-control" id="date" name="date" required placeholder="" >
                        </div>
                        <div class="form-group">
                            <label for="name">Số lượng nhập:</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" required placeholder="" >
                        </div>
                        <input type="hidden" value="{{$product->id}}" name="pro_id">
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
