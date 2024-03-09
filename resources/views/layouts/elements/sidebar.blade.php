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
            <li>
                <a href="" class="">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">das</div>
                </a>
            </li>
      <li>
        <a href="#" class="">
          <div class="parent-icon"><i class="bi bi-person-circle"></i>
          </div>
          <div class="menu-title">{{__('admin.user_list')}}</div>
        </a>
      </li>
      <li>
        <a href="" class="">
          <div class="parent-icon"><i class="bi bi-ui-checks"></i>
          </div>
          <div class="menu-title">{{__('admin.manufacture_product_list')}}</div>
        </a>
      </li>
      <li>
        <a href="" class="">
          <div class="parent-icon"><i class="bi bi-cash-stack"></i>
          </div>
          <div class="menu-title">{{__('admin.original_product_list')}}</div>
        </a>
      </li>
      <li>
        <a href="" class="">
          <div class="parent-icon"><i class="bi bi-person-circle"></i>
          </div>
          <div class="menu-title">{{__('admin.customer_list')}}</div>
        </a>
      </li>
      <li>
        <a href="" class="">
          <div class="parent-icon"><i class="bi bi-cash-stack"></i>
          </div>
          <div class="menu-title">{{__('admin.supplier_list')}}</div>
        </a>
      </li>
      <li>
        <a href="" class="">
          <div class="parent-icon"><i class="bi bi-ui-checks"></i>
          </div>
          <div class="menu-title">{{__('admin.supplier_contract_list')}}</div>
        </a>
      </li>
      <li>
        <a href="" class="">
          <div class="parent-icon"><i class="bi bi-cash-stack"></i>
          </div>
          <div class="menu-title">{{__('admin.original_contract_list')}}</div>
        </a>
      </li>
      <li>
        <a href="" class="">
          <div class="parent-icon"><i class="bi bi-cash"></i>
          </div>
          <div class="menu-title">{{__('admin.billing_management')}}</div>
        </a>
      </li>
      <li>
        <a href="" class="">
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
        <form id="logout-form-menu" action="" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
    <!--end navigation-->
 </aside>
 <!--end sidebar -->
