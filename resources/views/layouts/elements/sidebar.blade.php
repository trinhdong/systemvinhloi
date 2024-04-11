<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            {{--<img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">--}}
        </div>
        <div>
            <h4 class="logo-text">Quản lý bán hàng</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class="bi bi-list"></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        @if (Auth::user()->role === STOCKER || Auth::user()->role === WAREHOUSE_STAFF)
            <li class="<?= (request()->is('dashboard*')) ? 'mm-active' : '' ?>">
                <a href="{{route('dashboard')}}">
                    <div class="parent-icon"><i class="lni lni-dashboard"></i>
                    </div>
                    <div class="menu-title">Quản lý thống kê</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN)
            <li class="<?= (request()->is('dashboard*')) ? 'mm-active' : '' ?>">
                <a href="{{route('dashboard')}}">
                    <div class="parent-icon"><i class="lni lni-dashboard"></i>
                    </div>
                    <div class="menu-title">Quản lý thống kê</div>
                </a>
            </li>
            <li class="<?= (request()->is('user*')) ? 'mm-active' : '' ?>">
                <a href="{{route('user.index')}}">
                    <div class="parent-icon"><i class="lni lni-user"></i>
                    </div>
                    <div class="menu-title">Quản lý nhân viên</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN || Auth::user()->role === STOCKER)
            <li class="<?= (request()->is('category*')) ? 'mm-active' : '' ?>">
                <a href="{{route('category.list')}}">
                    <div class="parent-icon"><i class="lni lni-list"></i>
                    </div>
                    <div class="menu-title">Quản lý danh mục</div>
                </a>
            </li>
            <li class="<?= (request()->is('product*')) ? 'mm-active' : '' ?>">
                <a href="{{route('product.list')}}">
                    <div class="parent-icon"><i class="lni lni-producthunt"></i>
                    </div>
                    <div class="menu-title">Quản lý sản phẩm</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN || Auth::user()->role === SALE)
            <li class="<?= (request()->is('customer*')) ? 'mm-active' : '' ?>">
                <a href="{{route('customer.index')}}">
                    <div class="parent-icon"><i class="lni lni-customer"></i>
                    </div>
                    <div class="menu-title">Quản lý khách hàng</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN || Auth::user()->role === SALE || Auth::user()->role === STOCKER)
            <li class="<?= (request()->is(Auth::user()->role === STOCKER ? 'stocker/order*' : 'order*')) ? 'mm-active' : '' ?>">
                <a href="{{route(Auth::user()->role === STOCKER ? 'stocker.order.index' : 'order.index')}}">
                    <div class="parent-icon"><i class="bi bi-basket2-fill"></i>
                    </div>
                    <div class="menu-title">Quản lý đơn hàng</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role === WAREHOUSE_STAFF)
            <li class="<?= (request()->is('warehouse-staff/order*')) ? 'mm-active' : '' ?>">
                <a href="{{route('warehouse-staff.order.index')}}">
                    <div class="parent-icon"><i class="bi bi-basket2-fill"></i>
                    </div>
                    <div class="menu-title">Quản lý đơn hàng</div>
                </a>
            </li>
        @endif
        @if ( Auth::user()->role === ACCOUNTANT)
            <li class="<?= (request()->is('order*')) ? 'mm-active' : '' ?>">
                <a href="{{route('order.index')}}">
                    <div class="parent-icon"><i class="bi bi-basket2-fill"></i>
                    </div>
                    <div class="menu-title">Quản lý đơn hàng</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN || Auth::user()->role === ACCOUNTANT)
            <li class="<?= (request()->is('payment*')) ? 'mm-active' : '' ?>">
                <a href="{{route('payment.indexPayment')}}">
                    <div class="parent-icon"><i class="bi bi-credit-card"></i></i>
                    </div>
                    <div class="menu-title">Quản lý thanh toán</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN || Auth::user()->role === SALE)
            <li class="<?= (request()->is('area*')) ? 'mm-active' : '' ?>">
                <a href="{{route('area.list')}}">
                    <div class="parent-icon"><i class="bi bi-pin-map-fill"></i>
                    </div>
                    <div class="menu-title">Quản lý khu vực</div>
                </a>
            </li>
        @endif
        @if (Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN)
            <li class="<?= (request()->is('bank_account*')) ? 'mm-active' : '' ?>">
                <a href="{{route('bank_account.index')}}">
                    <div class="parent-icon"><i class="bx bxs-bank"></i>
                    </div>
                    <div class="menu-title">Quản lý tài khoản ngân hàng</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
