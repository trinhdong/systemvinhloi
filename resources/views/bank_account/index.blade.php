@extends('layouts.app')
@section('title')
    Tài khoản ngân hàng
@endsection
@section('breadcrumb')
    Danh sách tài khoản ngân hàng
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-sm-10 mb-2">
                    <form id="form-search" class="position-relative">
                        <div class="row">
                            <div class="col-4">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                            class="bi bi-search"></i></div>
                                <input onchange="$('#form-search').submit()" class="form-control ps-5 rounded" type="text"
                                       placeholder="Nhập nội dung tìm kiếm"
                                       name="query" value="{{ request('query') }}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-2">
                    <a href="{{route('bank_account.add')}}" class="btn btn-primary float-end">Thêm tài khoản</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table align-middle last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Tên ngân hàng</th>
                                <th>Số tài khoản</th>
                                <th>Tên chủ tài khoản</th>
                                <th>Tên chi nhánh</th>
                                <th class="col-1">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($bankAccounts->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">Không tìm thấy dữ liệu</td>
                                </tr>
                            @else
                                @foreach($bankAccounts as $key => $bankAccount)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $bankAccount->bank_name }}</td>
                                        <td>{{ $bankAccount->bank_code }}</td>
                                        <td>{{ $bankAccount->bank_account_name }}</td>
                                        <td>{{ $bankAccount->bank_branch }}</td>
                                        <td>
                                            <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                                <a href="{{route('bank_account.detail', $bankAccount->id)}}" class="text-primary"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="bottom" title="Xem"><i class="bi bi-eye-fill"></i></a>
                                                <a href="{{route('bank_account.edit', $bankAccount->id)}}" class="text-warning"
                                                   data-bs-toggle="tooltip"
                                                   data-bs-placement="bottom"
                                                   title="Chỉnh sửa">
                                                    <i class="bi bi-pencil-fill"></i></a>
                                                    <form class="d-none" id="formDeleteBankAccount{{$bankAccount->id}}"
                                                          action="{{ route('bank_account.delete', $bankAccount->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a href="javascript:;" id="deleteBankAccountModalBtn"
                                                       class="text-danger pointer-event"
                                                       data-bs-tooltip="tooltip"
                                                       data-bs-toggle="modal"
                                                       data-bs-placement="bottom" title="Xóa"
                                                       data-bs-target="#deleteBankAccountModal" data-bank-account-id="{{$bankAccount->id}}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
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
                            {{ $bankAccounts->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteBankAccountModal" tabindex="-1" aria-labelledby="deleteBankAccountModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBankAccountModalLabel">Xóa nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Bạn có chắc muốn xóa tài khoản ngân hàng này?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button id="deleteBankAccount" type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/bank_account/index.js"></script>
@endsection
