@extends('layouts.app')
@section('title')
    Nhân viên
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('user.add')}}" class="btn btn-sm btn-primary">Thêm nhân viên</a>
    </div>
@endsection
@section('breadcrumb')
    Danh sách nhân viên
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <form class="ms-auto position-relative">
                    @csrf
                    <div class="row">
                        <div class="col-5">
                            <select name="role" class="form-select">
                                <option selected="" value="">Chọn chức vụ...</option>
                                @foreach(ROLE_TYPE_LIST as $role => $roleName)
                                    @if(Auth::user()->role != $role)
                                    <option value="{{ $role }}" @if(intval(request('role')) === $role) selected @endif>{{ $roleName }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-7">
                            <div class="ms-auto position-relative">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                                <input name="query" value="{{ request('query') }}" class="form-control ps-5" type="text" placeholder="Tìm kiếm...">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Tên</th>
                        <th class="col-1">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($users->isEmpty())
                        <tr><td colspan="7" class="text-center">Không tìm thấy dữ liệu</td></tr>
                    @else
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                    <a href="{{route('user.detail', $user->id)}}" class="text-primary"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="bottom" title="Xem"><i class="bi bi-eye-fill"></i></a>
                                    <a href="{{route('user.edit', $user->id)}}" class="text-warning"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="bottom"
                                       title="Chỉnh sửa">
                                        <i class="bi bi-pencil-fill"></i></a>
                                    @if(Auth::User()->id !== $user->id)
                                        <form class="d-none" id="formDeleteUser{{$user->id}}" action="{{ route('user.delete', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="javascript:;" id="deleteUserModalBtn" class="text-danger pointer-event"
                                                data-bs-tooltip="tooltip"
                                                data-bs-toggle="modal"
                                                data-bs-placement="bottom" title="Xóa"
                                                data-bs-target="#deleteUserModal" data-user-id="{{$user->id}}">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-12">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Xóa nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Bạn có chắc muốn xóa nhân viên này?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button id="deleteUser" type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/user/index.js"></script>
@endsection
