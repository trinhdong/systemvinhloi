@extends('layouts.app')
@section('title')
    Nhân viên
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('user.index')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    {{$user->name}}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row py-4">
                <div class="col-xl-4 offset-xl-4">
                    <input type="text" hidden name="user_id" value="103">
                    <div class="d-flex justify-content-center align-items-center">
                        <img width="100px" src="assets/images/avatars/person.png" class="user-img" alt="">
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="sz-col-170">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên
                                </th>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-170">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Email
                                </th>
                                <td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <th class="sz-col-170">
                                    <em class="fa fa-envelope mr-1" aria-hidden="true"></em>Chức vụ
                                </th>
                                <td>{{ROLE_TYPE_NAME[$user->role]}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <a href="{{route('user.edit', $user->id)}}" style="width: 80px;" class="btn btn-primary mt-3 me-2">Sửa</a>
                @if(Auth::User()->id !== $user->id)
                    <form class="d-none" id="formDeleteUser{{$user->id}}"
                          action="{{ route('user.delete', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    <a style="width: 80px;" href="javascript:;" id="deleteUserModalBtn"
                       class="btn btn-danger mt-3"
                       data-bs-tooltip="tooltip"
                       data-bs-toggle="modal"
                       data-bs-placement="bottom" title="Xóa"
                       data-bs-target="#deleteUserModal" data-user-id="{{$user->id}}">
                        Xóa
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
         aria-hidden="true" style="display: none;">
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
