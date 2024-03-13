<header class="top-header">
    <nav class="navbar navbar-expand gap-3">
        <div class="top-navbar-right ms-auto">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown dropdown-user-setting">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center">
                            <img src="assets/images/avatars/person.png" class="user-img" alt="">
                        </div>
                    </a>
                    @if (auth()->check())
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.detail',Auth::user()->id) }}">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatars/person.png" alt="" class="rounded-circle"
                                             width="54" height="54">
                                        <div class="ms-3">
                                            <h6 class="mb-0 dropdown-user-name">{{Auth::user()->name}}</h6>
                                            <small class="mb-0 dropdown-user-designation text-secondary">
                                                {{ROLE_TYPE_NAME[Auth::user()->role]}}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('user.detail',Auth::user()->id) }}">
                                    <div class="d-flex align-items-center">
                                        <div class=""><i class="bi bi-person-fill"></i></div>
                                        <div class="ms-3"><span>Thông tin</span></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    <div class="d-flex align-items-center">
                                        <div class=""><i class="bi bi-lock-fill"></i></div>
                                        <div class="ms-3"><span>Đăng xuất</span></div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div>
    </nav>
</header>