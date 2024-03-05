@extends('layouts.app')
@section('title')
    {{-- write title this page--}}
    支払い管理
@endsection
@section('css')
    {{-- write css this page--}}
    <style>
        .color-icon{
            color: rgb(0, 192, 0);
        }
    </style>
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    支払い管理
@endsection
@section('content')
@php
    $status_bill = App\Enums\EPayStatus::getArray();
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="d-flex justify-content-between m-2 row">
            <div class="col-sm-4 mb-2">
                <form action="#" class="position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                            class="bi bi-search"></i></div>
                    <input class="form-control ps-5 rounded" name="" type="text"
                        placeholder="検索" value="">
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-1">
                <div class="d-flex align-items-center justify-content-between m-2">
                    <div>
                        
                    </div>
                    <div class="dropdown position-relative">
                        <button id="btn-search" class="btn btn-primary dropdown-toggle" type="button" ><i class="bi bi-funnel"></i></button>
                        <div class="rounded border bg-light dropdown-search d-none position-absolute top-12 end-0" style="width:300px;" >
                            <form class="row p-3 form-search">
                                <div class="col-sm-12 mt-2">
                                    <label class="form-label">{{__('admin.contract_status')}}</label>
                                    <select id="" class="form-select" name="bill_status">
                                        <option value="" selected></option>
                                        @foreach($status_bill as $key => $st)
                                            <option value="{{$key}}" {{request()->input('pay_status')==$key ? 'selected' : ''}}>{{$st}}</option>
                                        @endforeach
                                    </select>
                                    <input hidden type="text" class="form-control sort_collect_date"  name="sort_collect_date" value="{{ request()->input('sort_collect_date') }}">
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <label class="form-label">{{__('admin.supplier_name')}}</label>
                                    <select id="" class="form-select search-supplier" name="supplier_id">
                                        <option value="" selected></option>
                                        @foreach($listSupplier as $key => $cus)
                                            <option value="{{$cus->id}}" {{request()->input('supplier_id')==$cus->id ? 'selected' : ''}}>{{$cus->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-sm-12 mt-2 text-end">
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table align-middle last-child-right">
                        <thead class="table-secondary">
                        <tr>
                            <th>注文番号</th>
                            <th>仕入先名</th>
                            <th>締め日</th>
                            <th>支払日</th>
                            <th>支払金額</th>
                            <th style="min-width: 120px;">{{__('admin.contract_status')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paginator as $item)
                            <tr data-id="{{$item->id}}" class="table-pay" data-table="{{$item->table_name}}">
                                <td>{{$item->order_number}}</td>
                                <td>
                                    @if($item->Supplier)
                                        {{$item->Supplier->name}}
                                    @else
                                        {{__('message.404_not_found')}}
                                    @endif
                                </td>
                                <td class="td-closing-date">
                                    @if($item->closing_date_pay)
                                        {{($item->closing_date_pay) ? date('Y/m/d', strtotime($item->closing_date_pay)) : ''}}
                                    @endif
                                </td>
                                <td class="td-collect-date" style="width:150px;">
                                    <input {{($item->closing_date_pay) ? "" : "disabled"}} type="text" class="form-control date_of_payment" name="" value="{{($item->date_of_payment) ? date('Y/m/d', strtotime($item->date_of_payment)) : ''}}">
                                </td>
                                    <td>{{number_format($item->total_buy)}}円</td>
                                <td>
                                    <select id="pay_status" class="form-select w-50 pay_status" style="min-width:100px;">
                                        @foreach($status_bill as $key => $st)
                                            <option value="{{$key}}" {{$key==$item->pay_status ? 'selected' : ''}}>{{$st}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <a href="{{$item->table_name == 'original' ? route('detail-original-contract', $item->id) : route('supplier-contract.detail',$item->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="詳細"><i class="bi bi-eye-fill"></i></a>
                                    <a href="{{$item->table_name == 'original' ? route('edit-original-contract', $item->id) : route('supplier-contract.edit',$item->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="編集"><i class="bi bi-pencil-fill"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="justify-content-center">
                        {!! $paginator->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary me-2 p-2 download-all-pdf" >選択された請求を全て締める</button>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.date_of_payment').bootstrapMaterialDatePicker({
                time: false,
                format: 'YYYY/MM/DD',
                cancelText: "戻る",
                okText: "選択",
                lang: "ja",
            });
            $('.date_of_payment').on('dateSelected', function(e, date) { 
                id = $(this).attr('data-dtp')
                $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
            });
            $('#btn-search, .close-search').click(function(){
                if($('.dropdown-search').hasClass('d-none')){
                    $('.dropdown-search').removeClass('d-none')
                }else{
                    $('.dropdown-search').addClass('d-none')
                }
            })

            $(document).on('change','.pay_status',function(){
                status = $(this).val();
                id = $(this).closest('tr').attr('data-id');
                table = $(this).closest('tr').attr('data-table');
                $.ajax({
                    type: "POST",
                    url: "{{ route('pay.change-status') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id : id,
                        status: status,
                        table: table
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
                            if(data['data']['check_status'] == true){
                                $('tr[data-id='+id+'] .td-closing-date').text(data['data']['closing_date_pay']);
                                if(data['data']['date_of_payment'] != null){
                                    $('tr[data-id='+id+'] .td-collect-date .date_of_payment').val(data['data']['date_of_payment']);
                                    $('tr[data-id='+id+'] .td-collect-date .date_of_payment').attr('disabled',false)
                                }
                            }
                                
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
            })

            $(document).on('change','.date_of_payment',function(){
                date = $(this).val() ;
                id = $(this).closest('tr').attr('data-id');
                table = $(this).closest('tr').attr('data-table');
                $.ajax({
                    type: "POST",
                    url: "{{ route('pay.change-date-of-payment') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id : id,
                        date: date,
                        table: table
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
                                title: '成功',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-check-circle',
                                msg: data['message']
                            });
                        }
                    }
                })
            })

            $('.download-all-pdf').click(function(){
                $('.table-pay').each(function( index ) {
                    id = $(this).closest('tr').attr('data-id')
                    table = $(this).closest('tr').attr('data-table');
                    if(table == 'original')
                        window.open('/original_contract/download-copy/'+id, '_blank');
                    else
                        window.open('/maker_execution/download-copy/'+id, '_blank');
                });
            })
        })
    </script>
@endsection



