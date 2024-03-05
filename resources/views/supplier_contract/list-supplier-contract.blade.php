@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.supplier_contract_list')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.supplier_contract_list')}}
@endsection
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="d-flex justify-content-between m-2 row">
      <div class="col-sm-4 mb-2">
        <form class="position-relative" method="get" >
          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
          <input class="form-control ps-5 rounded" type="text" placeholder="検索" name="order_number" value="{{ request()->input('order_number') }}">
        </form>
      </div>
      @if (Auth::user()->is_admin != 1)
        <div class="col-sm-5 col-md-4 col-lg-4 mb-4">
          <a href="{{route('supplier-contract.create') }}" type="button" class="btn btn-primary px-5 float-end">{{__('admin.supplier_contract_add')}}</a>
        </div>
      @endif
      @if (Auth::user()->is_admin == 1 || Auth::user()->role == 2)
      <div class="col-sm-12" style="font-size:16px;color:black">
        <div class="row d-flex justify-content-between">
          <div class="col-sm-4">
              <div class="card">
            <div class="card-body d-flex justify-content-center align-items-center">
              <div class="text-center">
                  <div>{{date("m/d",strtotime("-1 Days"))}}（先日）</div>
                  <div>売上:{{number_format($data_statistics['yesterday']['revenue'])}}円</div>
                  <div>仕入:{{number_format($data_statistics['yesterday']['purchase_amount'])}}円</div>
                  <div>粗利:{{number_format($data_statistics['yesterday']['revenue']-$data_statistics['yesterday']['purchase_amount'])}}円</div>
              </div>
            </div>
              </div>
          </div>
          <div class="col-sm-4">
              <div class="card">
            <div class="card-body">
              <div class="text-center">
                <div>{{ date("m/d") }}（今日）</div>
                <div>売上:{{number_format($data_statistics['today']['revenue'])}}円</div>
                <div>仕入:{{number_format($data_statistics['today']['purchase_amount'])}}円</div>
                <div>粗利:{{number_format($data_statistics['today']['revenue']-$data_statistics['today']['purchase_amount'])}}円</div>
            </div>
            </div>
            </div>
          </div>
          <div class="col-sm-4">
              <div class="card">
            <div class="card-body">
              <div class="text-center">
                <div>{{ date("m") }}（今月）</div>
                <div>売上:{{number_format($data_statistics['month']['revenue'])}}円</div>
                <div>仕入:{{number_format($data_statistics['month']['purchase_amount'])}}円</div>
                <div>粗利:{{number_format($data_statistics['month']['revenue']-$data_statistics['month']['purchase_amount'])}}円</div>
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
                <th>{{__('admin.supplier_contract_order_number')}}</th>
                @if (Auth::user()->is_admin == 1)
                  <th>{{__('admin.business_location_name')}}</th>
                @endif
                <th>{{__('admin.contract_customer_id')}}</th>
                <th class="text-center">{{__('admin.contract_earnings')}}</th>
                <th class="text-center">{{__('admin.contract_purchase_amount')}}</th>
                <th class="text-center">{{__('admin.contract_profit')}}</th>
                <th class="text-center">{{__('admin.contract_status')}}</th>
                <th></th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($list_memo_supplier_contract as $item)
                    <tr data-id="{{$item->id}}">
                      <td>{{$item->id}}</td>
                      <td>{{date('Y/m/d',strtotime($item->created_date))}}</td>
                      <td>{{$item->order_number}}</td>
                      @if (Auth::user()->is_admin == 1)
                        <td>{{$item->BusinessLocation->name}}</td>
                      @endif
                      <td>
                        @if($item->Customer)
                          {{$item->Customer->name}}
                        @else
                          {{__('message.404_not_found')}}
                        @endif
                      </td>
                      <td class="text-center">¥ {{number_format($item->getRevenue())}}</td>
                      <td class="text-center">¥ {{number_format($item->getPurchaseAmount())}}</td>
                      <td class="text-center">¥ {{number_format($item->getRevenue() - $item->getPurchaseAmount())}}</td>
                      <td class="d-flex justify-content-center">
                        <select class="form-select m-0 status-supplier-contract" data-id="{{$item->id}}" style="width: 160px; text-align: center" @if (Auth::user()->is_admin == 1) disabled @endif>
                          @foreach ($status as $key => $item_status)
                            <option value="{{$key}}" {{$key==$item->status ? "selected" : ""}}>{{$item_status}}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                            <a href="{{route('supplier-contract.detail',$item->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="詳細"><i class="bi bi-eye-fill"></i></a>
                            @if (Auth::user()->is_admin != 1)
                            <a href="{{route('supplier-contract.edit',$item->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="編集"><i class="bi bi-pencil-fill"></i></a>
                            <a class="text-danger delete-supplier-contract" data-id="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="削除" ><i class="bi bi-trash-fill"></i></a>
                            @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
            <div class=" justify-content-center">
               {{-- paginate --}}
               {!! $list_memo_supplier_contract->links('pagination::bootstrap-5') !!}
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
@section('script')
  <script>
    $(document).ready(function() {
      $('.delete-supplier-contract').click(function() {
        id = $(this).data('id')
        Swal.fire({
            title: '{{ __('message.supplier_contract_want_to_delete') }}',
            showDenyButton: true,
            confirmButtonText: '{{__('admin.btn_delete') }}',
            denyButtonText: '{{__('admin.btn_back') }}',
        }).then((result) => {
            if (result.isConfirmed) {
                postDeleteConstruct(id)
            }else if (result.isDenied) {
            }
        })
      })

      function postDeleteConstruct(id) {
        $.ajax({
            type: "POST",
            url: "{{ route('supplier-contract.handle.delete') }}",
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

        $('.status-supplier-contract').change(function() {
            status = $(this).val()
            id = $(this).data('id')
            postChangeStatusSupplierContract(id,status);
        })

        function postChangeStatusSupplierContract(id,status) {
            $.ajax({
                type: "POST",
                url: "{{ route('change-status-supplier-contract') }}",
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
                },
                error:function(data){
                      Lobibox.notify('error', {
                          title: 'エラー',
                          pauseDelayOnHover: true,
                          continueDelayOnInactiveTab: false,
                          position: 'top right',
                          icon: 'bx bx-x-circle',
                          msg: data['message']
                      });
                }
            })
        }
    });
  </script>
@endsection



