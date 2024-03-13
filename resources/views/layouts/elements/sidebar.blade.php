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
        <li class="<?= (request()->is('dashboard*')) ? 'mm-active' : '' ?>">
            <a href="{{route('dashboard')}}">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        @if (Auth::user()->role === ADMIN || Auth::user()->role === SUPER_ADMIN)
        <li class="<?= (request()->is('user*')) ? 'mm-active' : '' ?>">
            <a href="{{route('user.index')}}">
                <div class="parent-icon"><i class="bi bi-grid-fill"></i>
                </div>
                <div class="menu-title">Quản lý nhân viên</div>
            </a>
        </li>
        @endif
        <li class="<?= (request()->is('area*')) ? 'mm-active' : '' ?>">
            <a href="{{route('area.list')}}">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">Khu vực</div>
            </a>
        </li>
    </ul>
</aside>
