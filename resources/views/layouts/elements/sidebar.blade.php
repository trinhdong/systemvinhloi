<!--start sidebar -->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header bg-light border-end-0" style="justify-content: center;" >
      <div style="display:flex;justify-content: center;">
         <img src="assets/images/logo.png" class="logo-icon" alt="logo icon" style="width: 60%;">
      </div>
      <div class="toggle-icon ms-auto"> <i class="bi bi-list" style="color:rgb(78, 78, 78)"></i>
      </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
      <li>
        <a href="{{route('user.list')}}" class="">
          <div class="parent-icon"><i class="bi bi-person-circle"></i>
          </div>
          <div class="menu-title">Quan ly nhan vien</div>
        </a>
      </li>
        <li>
            <a href="{{route('area.list')}}" class="">
                <div class="parent-icon"><i class="bi bi-person-circle"></i>
                </div>
                <div class="menu-title">Quản lý khu vực</div>
            </a>
        </li>
      <li>
        <a class="btn-logout" >
          <div class="parent-icon"><i class="bi bi-person-circle"></i>
          </div>
          <div class="menu-title cursor-pointer">{{ __('Dang xuat') }}</div>
        </a>
        <form id="logout-form-menu" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
    <!--end navigation-->
 </aside>
 <!--end sidebar -->
