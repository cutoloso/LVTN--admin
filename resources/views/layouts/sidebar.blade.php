<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
        <div class="sidebar-brand-icon rotate-n-15">
{{--            <i class="fas fa-laugh-wink"></i>--}}
        </div>
        <div class="sidebar-brand-text mx-3">AZ Mobile</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Product Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#product" aria-expanded="true"
           aria-controls="product">
            <i class="fas fa-mobile-alt"></i>
            <span>SẢN PHẨM</span>
        </a>
        <div id="product" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý sản phẩm:</h6>
                <a class="collapse-item" href="{{route('product.index')}}">Danh sách</a>
                {{--                <a class="collapse-item" href="{{route('brands.index')}}">Thương hiệu</a>--}}
                {{--                <a class="collapse-item" href="{{route('suppliers.index')}}">Nhà cung cấp</a>--}}
                {{--                <a class="collapse-item" href="{{route('category.index')}}">Danh mục</a>--}}
                <a class="collapse-item" href="{{route('attribute-group.index')}}">Nhóm thuộc tính</a>
                <a class="collapse-item" href="{{route('attributes.index')}}">Thông số kỹ thuật</a>
                <a class="collapse-item" href="{{route('product.import')}}">Nhập/ Xuất sản phẩm</a>

            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Shopping Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shopping" aria-expanded="true"
           aria-controls="shopping">
            <i class="fas fa-dollar-sign"></i>
            <span>BÁN HÀNG</span>
        </a>
        <div id="shopping" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý bán hàng:</h6>
                <a class="collapse-item" href="{{route('order.index')}}">Đơn hàng</a>
{{--                <a class="collapse-item" href="{{route('order.index')}}">Bảo hành</a>--}}
{{--                <a class="collapse-item" href="{{route('sale.index')}}">Khuyến mãi</a>--}}
                {{--              <a class="collapse-item" href="">Phí vận chuyển</a>--}}
                <a class="collapse-item" href="{{route('status.index')}}">Tình trạng đơn hàng</a>
                <a class="collapse-item" href="{{route('payment-method.index')}}">Phương thức thanh toán</a>
                <a class="collapse-item" href="{{route('payment-status.index')}}">Tình trạng thanh toán</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('getStatistics')}}">
            <i class="fas fa-signal"></i>
            <span>Thống kê</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('reviews.index')}}">
            <i class="far fa-grin-stars"></i>
            <span>Đánh giá</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('inventory.index')}}">
            <i class="fas fa-warehouse"></i>
            <span>Quản lý tồn kho</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.index')}}">
            <i class="fas fa-users"></i>
            <span>Quản lý tài khoản</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Website Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#website" aria-expanded="true"
           aria-controls="website">
            <i class="fas fa-globe"></i>
            <span>Webside</span>
        </a>
        <div id="website" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý website:</h6>
                <a class="collapse-item" href="{{route('menu.index')}}">Menu</a>
                <a class="collapse-item" href="{{route('category.index')}}">Danh mục</a>
                <a class="collapse-item" href="{{route('banner.index')}}">Slider</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('suppliers.index')}}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Nhà cung cấp</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('brands.index')}}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Thương hiệu</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
