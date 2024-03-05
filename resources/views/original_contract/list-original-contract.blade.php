@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.original_contract_list')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.original_contract_list')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-sm-4 mb-2">
                    <form action="{{route('original-contract-list')}}" class="position-relative">
                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                        <input class="form-control ps-5 rounded" type="text" placeholder="検索" name="search_original_contract" value="{{ request()->input('search_original_contract') }}">
                    </form>
                </div>
                @if (Auth::user()->is_admin != 1)
                    <div class="col-sm-5 col-md-4 col-lg-4 mb-2">
                        <a href="{{route('create-original-contract') }}" type="button" class="btn btn-primary px-5 float-end">{{__('admin.original_contract_add')}}</a>
                    </div>
                @endif
            </div>
            @if (Auth::user()->is_admin == 1 || Auth::user()->role == 2)
            <div class="col-sm-12" style="font-size:16px;color:black">
                <div class="row d-flex justify-content-between">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    <div>{{date('m/d',strtotime("-1 Days"))}}（先日）</div>
                                    <div>売上: {{number_format($data_statistical['yesterday']['revenue'])}}円</div>
                                    <div>仕入: {{number_format($data_statistical['yesterday']['purchase_amount'])}}円</div>
                                    <div>粗利: {{(number_format($data_statistical['yesterday']['revenue'] - $data_statistical['yesterday']['purchase_amount']))}}円</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <div>{{date('m/d')}}（今日）</div>
                                    <div>売上: {{number_format($data_statistical['today']['revenue'])}}円</div>
                                    <div>仕入: {{number_format($data_statistical['today']['purchase_amount'])}}円</div>
                                    <div>粗利: {{number_format(($data_statistical['today']['revenue'] - $data_statistical['today']['purchase_amount']))}}円</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <div>{{date('m')}}（今月）</div>
                                    <div>売上: {{number_format($data_statistical['month']['revenue'])}}円</div>
                                    <div>仕入: {{number_format($data_statistical['month']['purchase_amount'])}}円</div>
                                    <div>粗利: {{number_format(($data_statistical['month']['revenue'] - $data_statistical['month']['purchase_amount']))}}円</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table align-middle last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th>ID</th>
                                <th>{{__('admin.contract_create_date')}}</th>
                                <th>{{__('admin.original_contract_order_number')}}</th>
                                @if(Auth::user()->is_admin == 1)
                                <th>{{__('admin.business_location_name')}}</th>
                                @endif
                                <th>{{__('admin.contract_customer_id')}}</th>
                                <th>{{__('admin.contract_earnings')}}</th>
                                <th>{{__('admin.contract_purchase_amount')}}</th>
                                <th>{{__('admin.contract_profit')}}</th>
                                <th>{{__('admin.contract_status')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($original_contract_list as $original_contract)
                            <tr data-id="{{$original_contract->id}}">
                                <td>{{$original_contract->id}}</td>
                                <td>{{date('Y/m/d', strtotime($original_contract->created_date))}}</td>
                                <td>{{$original_contract->order_number}}</td>
                                @if(Auth::user()->is_admin == 1)
                                <td>{{$original_contract->bussinessLocation->name}}</td>
                                @endif
                                <td>
                                    @if($original_contract->Customer)
                                      {{$original_contract->Customer->name}}
                                    @else
                                      {{__('message.404_not_found')}}
                                    @endif
                                  </td>
                                <td>¥ {{number_format($original_contract->getRevenue())}}</td>
                                <td>¥ {{number_format($original_contract->getPurchaseAmount())}}</td>
                                <td>¥ {{number_format($original_contract->getRevenue() - $original_contract->getPurchaseAmount())}}</td>
                                <td>
                                    <select class="form-select status-original-contract" data-id="{{$original_contract->id}}" style="width: 120px; text-align: center;" @if (Auth::user()->is_admin == 1) disabled @endif>
                                        @foreach ($status['statusOriginalContract'] as $key => $status_original_contract)
                                            <option value="{{$key}}" {{ $key==$original_contract->status ? 'selected' : ''}}>{{$status_original_contract}}</option>
                                        @endforeach
                                    </select>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <a href="{{route('detail-original-contract', $original_contract->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="詳細"><i class="bi bi-eye-fill"></i></a>
                                        @if (Auth::user()->is_admin != 1)
                                        <a href="{{route('edit-original-contract', $original_contract->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="編集"><i class="bi bi-pencil-fill"></i></a>
                                        <a class="text-danger delete-original-contract" data-id="{{$original_contract->id}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="削除" ><i class="bi bi-trash-fill"></i></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class=" justify-content-center">
                            {!! $original_contract_list->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.status-original-contract').change(function() {
            status = $(this).val()
            id = $(this).data('id')
            postChangeStatusOriginalContract(id,status);
        })

        function postChangeStatusOriginalContract(id,status) {
            $.ajax({
                type: "POST",
                url: "{{ route('change-status-original-contract') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id : id ,
                    status: status
                },
                dataType: 'json',
                success: function(data) {
                    if (data['status'] == true) {
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
                }
            })
        }

        $('.delete-original-contract').click(function() {
            id = $(this).data('id')
            Swal.fire({
                title: '{{ __('message.original_contract_want_to_delete') }}',
                showDenyButton: true,
                confirmButtonText: '{{__('admin.btn_delete') }}',
                denyButtonText: '{{__('admin.btn_back') }}',
            }).then((result) => {
                if (result.isConfirmed) {
                    postDeleteOriginalContract(id)
                }else if (result.isDenied) {
                }
            })
        })

        function postDeleteOriginalContract(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('delete-original-contract') }}",
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
    </script>
@endsection



