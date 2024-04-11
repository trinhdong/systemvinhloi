@extends('layouts.app')

@section('title')
    Tài khoản ngân hàng
@endsection

@section('action')
    <div class="col-12">
        <a href="{{route('bank_account.index')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection

@section('breadcrumb')
    {{$bankAccount->bank_code}} - {{$bankAccount->bank_account_name}}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row py-4">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">Thông tin tài khoản ngân hàng</h5>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th class="col-6">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên ngân hàng
                                </th>
                                <td class="col-6">{{$bankAccount->bank_name}}</td>
                            </tr>
                            <tr>
                                <th class="col-6">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Số tài khoản ngân hàng
                                </th>
                                <td class="col-6">{{$bankAccount->bank_code}}</td>
                            </tr>
                            <tr>
                                <th class="col-6">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên chủ tài khoản ngân hàng
                                </th>
                                <td class="col-6">{{$bankAccount->bank_account_name}}</td>
                            </tr>
                            <tr>
                                <th class="col-6">
                                    <em class="fa fa-id-card mr-1" aria-hidden="true"></em>Tên chi nhánh
                                </th>
                                <td class="col-6">{{$bankAccount->bank_branch}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{route('bank_account.edit', $bankAccount->id)}}" style="width: 80px;" class="btn btn-primary mt-3">Sửa</a>
            <form class="d-none" id="formDeleteBankAccount{{$bankAccount->id}}"
                  action="{{ route('bank_account.delete', $bankAccount->id) }}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
            <a style="width: 80px;" href="javascript:;" id="deleteBankAccountModalBtn"
               class="btn btn-danger mt-3"
               data-bs-tooltip="tooltip"
               data-bs-toggle="modal"
               data-bs-placement="bottom" title="Xóa"
               data-bs-target="#deleteBankAccountModal"
               data-bank-account-id="{{$bankAccount->id}}">
                Xóa
            </a>
        </div>
    </div>
    <div class="modal fade" id="deleteBankAccountModal" tabindex="-1" aria-labelledby="deleteBankAccountModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBankAccountModalLabel">Xóa tài khoản ngân hàng</h5>
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
