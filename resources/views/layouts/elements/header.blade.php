<!--start top header-->
<header class="top-header">
    <nav class="navbar navbar-expand gap-3">
      <div class="mobile-toggle-icon fs-3">
          <i class="bi bi-list"></i>
        </div>

        <div class="top-navbar-right ms-auto">
          <ul class="navbar-nav align-items-center">
            <li class="nav-item search-toggle-icon">
              <a class="nav-link" href="#">
                <div class="">
                  <i class="bi bi-search"></i>
                </div>
              </a>
            </li>
          <li class="nav-item dropdown dropdown-user-setting">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
              <div class="user-setting d-flex align-items-center">
                <img src="assets/images/avatars/person.png" class="user-img" alt="">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              @if (auth()->check())
                  <li>
                    <a class="dropdown-item" href="{{ route('user.detail',Auth::user()->id) }}">
                      <div class="d-flex align-items-center">
                        <img src="assets/images/avatars/person.png" alt=""
                            class="rounded-circle" width="54" height="54">
                        <div class="ms-3">
                          <h6 class="mb-0 dropdown-user-name">{{ Auth::user()->name }}</h6>
                          <small class="mb-0 dropdown-user-designation text-secondary">
                            @foreach (ROLE_TYPE_NAME as $key => $type)
                                @if ($key === Auth::user()->role)
                                  {{ $type }}
                                @endif
                            @endforeach
                          </small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                      <hr class="dropdown-divider">
                  </li>
                  <li>
                      <a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                          {{ __('ログアウト') }}
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </li>
              @endif
            </ul>
          </li>
          </ul>
          </div>
    </nav>
  </header>
   <!--end top header-->
