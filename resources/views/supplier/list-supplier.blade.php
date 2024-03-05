@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.supplier_list')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.supplier_list')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-sm-4 mb-2">
                    <form action="{{route('list-supplier')}}" class="position-relative">
                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                class="bi bi-search"></i></div>
                        <input class="form-control ps-5 rounded" name="search_supplier" type="text"
                               placeholder="検索" value="{{ request()->input('search_supplier') }}">
                    </form>
                </div>
                @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                    <div class="col-sm-7 col-md-5 col-lg-5 mb-2">
                        <a href="{{route('create-supplier')}}" type="button" class="btn btn-primary px-5 float-end">{{__('admin.supplier_add')}}</a>
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table align-middle last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th>{{__('admin.code')}}</th>
                                <th>{{__('admin.supplier_name')}}</th>
                                <th>{{__('admin.supplier_email')}}</th>
                                <th>{{__('admin.supplier_phone')}}</th>
                                <th>{{__('admin.supplier_adress')}}</th>
                                @if (Auth::user()->is_admin == 1)
                                    <th>{{__('admin.business_location_name')}}</th>
                                @endif
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($supplier_list as $supplier)
                                <tr data-id="{{$supplier->id}}">
                                    <td>{{$supplier->supplier_code}}</td>
                                    <td>{{$supplier->name}}</td>
                                    <td>{{$supplier->email}}</td>
                                    <td>{{$supplier->phone_number}}</td>
                                    <td>{{$supplier->address}}</td>
                                    @if (Auth::user()->is_admin == 1)
                                        <td>{{$supplier->businessLocation->name}}</td>
                                    @endif
                                    <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="{{route('detail-supplier', $supplier->id)}}" class="text-primary"
                                               data-bs-toggle="tooltip" data-bs-placement="bottom" title="詳細"><i
                                                    class="bi bi-eye-fill"></i></a>
                                            @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                                                <a href="{{route('edit-supplier', $supplier->id)}}" class="text-primary"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="編集"><i
                                                    class="bi bi-pencil-fill"></i></a>
                                                @if (Auth::user()->role == 2)
                                                    <a data-id="{{ $supplier->id }}" class="text-danger delete-supplier"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="削除"
                                                        data-id="{{ $supplier->id }}"><i class="bi bi-trash-fill"></i></a>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class=" justify-content-center">
                            {!! $supplier_list->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {

            $('.delete-supplier').click(function() {
                id = $(this).data('id')
                Swal.fire({
                    title: '{{ __('message.supplier_product_want_to_delete') }}',
                    showDenyButton: true,
                    confirmButtonText: '{{ __('admin.btn_delete') }}',
                    denyButtonText: '{{ __('admin.btn_back') }}',
                }).then((result) => {
                    if (result.isConfirmed) {
                        postDeletesupplier(id)
                    }
                })
            })

            function postDeletesupplier(id) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete-supplier') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data['status'] == true) {
                            $('tr[data-id=' + id + ']').remove()
                            Lobibox.notify('success', {
                            title: '成功',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-check-circle',
                                msg: data['message']
                            });
                        } else {
                            Lobibox.notify('error', {
                            title: 'エラー',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-x-circle',
                                msg: data['message']
                            });
                        }
                    },
                });
            }
        });
    </script>
@endsection



