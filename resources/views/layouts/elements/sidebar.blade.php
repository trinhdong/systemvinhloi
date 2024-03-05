<!--start sidebar -->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header bg-light border-end-0" style="justify-content: center;" >
      <div style="display:flex;justify-content: center;">
         <img src="assets/images/logo-yamaplus.png" class="logo-icon" alt="logo icon" style="width: 60%;">
      </div>
      <div class="toggle-icon ms-auto"> <i class="bi bi-list" style="color:rgb(78, 78, 78)"></i>
      </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        @if (Auth::user()->is_admin == 1)
            <li>
                <a href="{{ Route('list-business') }}" class="">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">{{__('admin.business_location_list')}}</div>
                </a>
            </li>
        @endif
      <li>
        <a href="{{route('list-user')}}" class="">
          <div class="parent-icon"><i class="bi bi-person-circle"></i>
          </div>
          <div class="menu-title">{{__('admin.user_list')}}</div>
        </a>
      </li>
      <li>
        <a href="{{route('list-moproduct')}}" class="">
          <div class="parent-icon"><i class="bi bi-ui-checks"></i>
          </div>
          <div class="menu-title">{{__('admin.manufacture_product_list')}}</div>
        </a>
      </li>
      <li>
        <a href="{{route('list-oproduct')}}" class="">
          <div class="parent-icon"><i class="bi bi-cash-stack"></i>
          </div>
          <div class="menu-title">{{__('admin.original_product_list')}}</div>
        </a>
      </li>
      <li>
        <a href="{{route('list-customer')}}" class="">
          <div class="parent-icon"><i class="bi bi-person-circle"></i>
          </div>
          <div class="menu-title">{{__('admin.customer_list')}}</div>
        </a>
      </li>
      <li>
        <a href="{{route('list-supplier')}}" class="">
          <div class="parent-icon"><i class="bi bi-cash-stack"></i>
          </div>
          <div class="menu-title">{{__('admin.supplier_list')}}</div>
        </a>
      </li>
      <li>
        <a href="{{route('supplier-contract.list')}}" class="">
          <div class="parent-icon"><i class="bi bi-ui-checks"></i>
          </div>
          <div class="menu-title">{{__('admin.supplier_contract_list')}}</div>
        </a>
      </li>
      <li>
        <a href="{{route('original-contract-list')}}" class="">
          <div class="parent-icon"><i class="bi bi-cash-stack"></i>
          </div>
          <div class="menu-title">{{__('admin.original_contract_list')}}</div>
        </a>
      </li>
      <li>
        <a href="{{route('billing-manager')}}" class="">
          <div class="parent-icon"><i class="bi bi-cash"></i>
          </div>
          <div class="menu-title">{{__('admin.billing_management')}}</div>
        </a>
      </li>
      <li>
        <a href="{{route('list-pay')}}" class="">
          <div class="parent-icon"><i class="bi bi-cash"></i>
          </div>
          <div class="menu-title">支払い管理</div>
        </a>
      </li>
      <li>
        <a class="btn-logout" >
          <div class="parent-icon"><i class="bi bi-person-circle"></i>
          </div>
          <div class="menu-title cursor-pointer">{{ __('ログアウト') }}</div>
        </a>
        <form id="logout-form-menu" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form> 
      </li>
    </ul>
    <!--end navigation-->
 </aside>
 <!--end sidebar -->
