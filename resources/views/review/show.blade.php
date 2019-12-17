@extends('layouts.master')
@section('header.title','sản phẩm')
@section('header.css')
    <style>
        .review-content span {
            max-width: 500px;
            /*giới hạn độ rộng 251px*/
            overflow: hidden; /*Ẩn đoạn text bị thừa*/
            text-overflow: ellipsis; /*Cắt một đoạn text và thay thế bằng dấu ...*/

            /*giới hạn độ cao 4 dòng*/
            display: -webkit-box;
            -webkit-line-clamp: 3; /*Số dòng text hiển thị*/
            -webkit-box-orient: vertical;

        }

        .star-rating {
            position: relative;
            width: -webkit-fit-content;
            width: -moz-fit-content;
            width: fit-content
        }

        .star-rating .star {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            overflow: hidden
        }

        .star-rating .star::before {
            font-family: 'Font Awesome 5 Free';
            content: "\f005\f005\f005\f005\f005";
            font-size: 12px;
            color: #f29f29;
            font-weight: 600;
            line-height: 100%
        }

        .star-rating::before {
            font-family: 'Font Awesome 5 Free';
            content: "\f005\f005\f005\f005\f005";
            font-size: 12px;
            color: #e2e2e2;
            margin-left: 1px;
            line-height: 100%
        }
    </style>
@endsection
@section('body.title','Đánh giá sản phẩm')
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
                <div class="chart-pie pt-4">
                    <canvas id="myPieChart"></canvas>
                </div>
                <br>
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th class="js-sort" data-sort="star"><span class="mr-2">Đánh giá</span><i class="fas fa-sort"></i></th>
                        <th>Ngày tạo</th>
                        <th class="js-sort" data-sort="active"><span class="mr-2">Trạng thái</span><i class="fas fa-sort"></i></th>
                        <th class="text-center">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1 @endphp
                    @foreach ($reviews as $review)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $review->title }}</td>
                            <td class="review-content"><span>{{ $review->content }}</span></td>
                            <td class="review-content">
                                <div class="star-rating">
                                    <span class="star" style="width: {{ $review->star*20 }}%"></span>
                                </div>
                            </td>
                            <td class="text-center">{{ $review->created_at }}</td>
                            <td class="text-center">
                                @if($review->active !=1)
                                    <i class="fas fa-eye-slash"></i>
                                @else
                                    <i class="fas fa-eye"></i>
                                @endif

                                @if($review->sentiment !=1)
                                        <i class="far fa-frown"></i>
                                @else
                                        <i class="far fa-laugh-beam"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-success js-btn-view" data-id="{{$review->id}}"><i
                                        class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                    </tbody>
                </table>
                {{ $reviews->links() }}

            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="modalView">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" class="frmUpdateReview">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                <span class="title">Tiêu đề</span>
                                <span class="star-rating">
                                    <span class="star" style="width: 100%"></span>
                                </span>
                            </div>
                            <div class="card-body">nội dung
                            </div>
                            <div class="card-footer">
                                @csrf
                                @method('PUT')
                                <input class="pro_id" name="pro_id" type="hidden">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input js-active" id="active" name="active">
                                    <label class="custom-control-label" for="active">Hiện đánh giá</label>
                                </div>
                            </div>
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
    <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('js/config-chart.js')}}"></script>
    <script src="{{asset('js/chart-pie-demo.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#iputSearch").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#dataTable tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            let urlParams = new URLSearchParams(location.search);
            $('.js-sort').click(function () {
                let a = window.location.href;
                let s = a;
                let b = '';

                if (urlParams.has('page')) {
                    let p = urlParams.get('page');
                    let t = "&page=" + p;
                    b = "&sort=" + $(this).data('sort') + "&order=asc";
                    if (urlParams.has('sort')) {
                        let o = urlParams.get('sort');
                        let s_temp = urlParams.get('order');
                        t += "&sort=" + o + "&order=" + s_temp;
                        s = a.replace(t, '');
                        if (s_temp === 'asc') {
                            b = "?sort=" + $(this).data('sort') + "&order=desc";
                        }
                    }
                    s = a.replace(t, '');
                } else {
                    b = "&sort=" + $(this).data('sort') + "&order=asc";
                    if (urlParams.has('sort')) {
                        let s_temp = urlParams.get('order');
                        let o = urlParams.get('sort');
                        let t = "&sort=" + o + "&order=" + s_temp;
                        s = a.replace(t, '');
                        if (s_temp === 'asc') {
                            b = "&sort=" + $(this).data('sort') + "&order=desc";
                        }
                    }
                }
                location.replace(s + b);
            });

            $('.js-btn-view').click(function () {
                let id = $(this).data('id');
                let url = '{{route('reviews.index')}}' + '/' + id;
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        let data = response.review;
                        console.log(data);
                        $('#modalView form').attr('action', url);
                        $('#modalView .modal-header .modal-title').text(data.usr_name);
                        $('#modalView .modal-body .card-header .title').text(data.title);
                        $('#modalView .modal-body .card-header .star-rating .star').css('width',data.star*20+'%');
                        $('#modalView .modal-body .card-body').text(data.content);
                        $('#modalView .modal-body .pro_id').val(urlParams.get('product'));
                        if (data.active === 1) $('#modalView .modal-body .js-active').prop('checked',true);
                        $('#modalView').modal('show');
                    }
                });
            });
            const pieChart = $("#myPieChart");
            const pro_id = '{{$pro_id}}';
            $.ajax({
                url : 'http://127.0.0.1:8000/statics-review',
                async: false,
                data: {
                    product: pro_id,
                },
                method: 'GET',
                success: function (response) {
                    let arr_label = [];
                    let arr_data = [];
                    response.data.forEach(function ($item) {
                        if($item.sentiment === 0){
                            arr_label.push("Tích cực");
                        }
                        else{
                            arr_label.push("Tiêu cực");
                        }
                        arr_data.push($item.review_count);
                    });
                    // polarArea
                    // console.log(arr_label);
                    // console.log(arr_data);
                    paintPieChart(pieChart, arr_label, arr_data)
                }
            });

        });

    </script>
@endsection()
