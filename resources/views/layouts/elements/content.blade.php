<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">@yield('title')</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb')</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
            @yield('action')
        </div>
    </div>
</div>
@if(session('success'))
    <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="ms-3">
                <div class="text-success">{{ session('success') }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i>
            </div>
            <div class="ms-3">
                <div class="text-danger">{{ session('error') }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i>
            </div>
            <div class="ms-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            <div class="text-danger">{{ $error }}</div>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@yield('content')
