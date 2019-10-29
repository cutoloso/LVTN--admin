@extends('layouts.master')
@section('header.title','Danh mục')
@section('body.title','Danh sách danh mục')
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
                        <th class="js-sort" data-sort="name"><span class="mr-2">name</span><i class="fas fa-sort"></i></th>
                        <th>Mô tả</th>
                        <th class="js-sort" data-sort="created_at"><span class="mr-2">Ngày tạo</span><i class="fas fa-sort"></i></th>
                        <th class="js-sort" data-sort="updated_at"><span class="mr-2">Ngày cập nhật</span><i class="fas fa-sort"></i></th>
                        <th class="text-center">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->description }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td class="text-center">
                                <button class="btn btn-secondary js-btn-edit" data-id="{{$user->id}}" data-token="{{ csrf_token() }}"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{ $users->links() }}
            <!-- End of Content page -->

            </div>
        </div>
    </div>
    <!-- The Modal -->
    <!-- Modal Edit-->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Chỉnh sửa người dùng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" name="frmEdit" method="post" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Tên người dùng:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" >
                        </div>
                        <div class="form-group">
                            <label for="gr_id">Khóa / Mở khóa tài khoản:</label>
                            <select name="gr_id" id="gr_id" class="custom-select mb-3 js-gr_id-id"></select>
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
                    console.log(data);
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
                        select_option('.js-gr_id-id',data.gr_id);
                        console.log(data.gr_id);
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
