@extends('layouts.app')
@section('title')
    {{-- write title this page--}}
    {{__('admin.billing_management')}}
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
    {{__('admin.billing_management')}}
@endsection
@section('content')
    @php
        $status_bill = App\Enums\EBillStatus::getArray();
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
                            <input type="checkbox" class="check-all-bill">
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
                                                <option value="{{$key}}" {{request()->input('bill_status')==$key ? 'selected' : ''}}>{{$st}}</option>
                                            @endforeach
                                        </select>
                                        <input hidden type="text" class="form-control sort_collect_date"  name="sort_collect_date" value="{{ request()->input('sort_collect_date') }}">
                                    </div>
                                    <div class="col-sm-12 mt-2">
                                        <label class="form-label">{{__('admin.contract_customer_id')}}</label>
                                        <select id="" class="form-select search-customer" name="customer_id">
                                            <option value="" selected></option>
                                            @foreach($listCustomer as $key => $cus)
                                                <option value="{{$cus->id}}" {{request()->input('customer_id')==$cus->id ? 'selected' : ''}}>{{$cus->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mt-2">
                                        <label class="form-label">{{__('admin.closing_group')}}</label>
                                        <select class="form-select closing_group" name="closing_group" id="closing_group">
                                            <option value="" selected></option>
                                            <option value="5" {{request()->input('closing_group')==5 ? 'selected' : ''}}>5</option>
                                            <option value="10" {{request()->input('closing_group')==10 ? 'selected' : ''}}>10</option>
                                            <option value="15" {{request()->input('closing_group')==15 ? 'selected' : ''}}>15</option>
                                            <option value="20" {{request()->input('closing_group')==20 ? 'selected' : ''}}>20</option>
                                            <option value="25" {{request()->input('closing_group')==25 ? 'selected' : ''}}>25</option>
                                            <option value="{{date('t')}}" {{request()->input('closing_group')==date('t') ? 'selected' : ''}}>{{date('t')}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mt-2">
                                        <label class="form-label">{{__('admin.customer_closing_date')}}</label>
                                        <div class="row position-relative">
                                            <div class="col-sm-6 ">
                                                <input type="text" class="form-control closing_date_from" id="closing_date_from" name="closing_date_from" value="{{ request()->input('closing_date_from') }}">
                                                <span class="position-absolute top-50 start-50 translate-middle">~</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control closing_date_to" id="closing_date_to" name="closing_date_to" value="{{ request()->input('closing_date_to') }}">
                                            </div>
                                        </div>
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
                                <th>#</th>
                                <th>注文番号</th>
                                <th>得意先名</th>
                                <th>締めグループ</th>
                                <th>締め日</th>
                                <th>
                                    <span>回収日</span>
                                    @php 
                                        $color_black = false ; 
                                        if(request()->input('sort_collect_date') == 'asc'){
                                            $color_black = 'asc';
                                        } else if(request()->input('sort_collect_date') == 'desc'){
                                            $color_black = 'desc';
                                        }
                                    @endphp
                                    <span class="ms-2">
                                        <i class="collect_date_desc bi bi-caret-up-fill {{$color_black == 'desc' ? 'color-icon' : ''}}"></i>
                                        <i class="collect_date_asc bi bi-caret-down-fill {{$color_black == 'asc' ? 'color-icon' : ''}}"></i>
                                    </span>
                                </th>
                                <th>請求金額</th>
                                <th style="min-width: 120px;">{{__('admin.contract_status')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paginator as $item)
                                <tr data-id="{{$item->id}}" data-table="{{$item->table_name}}">
                                    <td><input type="checkbox" class="check-bill"></td>
                                    <td>{{$item->order_number}}</td>
                                    <td>
                                        @if($item->Customer)
                                            {{$item->Customer->name}}
                                        @else
                                            {{__('message.404_not_found')}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->Customer)
                                            {{($item->Customer->closing_group) ? $item->Customer->closing_group.'日' : ''}}
                                        @else
                                            {{__('message.404_not_found')}}
                                        @endif
                                    </td>
                                    <td class="td-closing-date">
                                        @if($item->closing_date)
                                            {{($item->closing_date) ? date('Y/m/d', strtotime($item->closing_date)) : ''}}
                                        @endif
                                    </td>
                                    <td class="td-collect-date" style="width:150px;">
                                        <input {{($item->closing_date) ? "" : "disabled"}} type="text" class="form-control collect_date" name="" value="{{($item->collect_date) ? date('Y/m/d', strtotime($item->collect_date)) : ''}}">
                                    </td>
                                    <td>{{number_format($item->total_price)}}円</td>
                                    
                                    <td>
                                        <select id="bill_status" class="form-select w-50 bill_status" style="min-width:100px;">
                                            @foreach($status_bill as $key => $st)
                                                <option value="{{$key}}" {{$key==$item->bill_status ? 'selected' : ''}}>{{$st}}</option>
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
                <button class="btn btn-primary me-2 p-2 change-many-status" >選択された請求を全て締める</button>
                <button class="btn btn-primary p-2 download-many-pdf" >選択された締め請求書をダウンロード</button>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.search-customer').select2({
                theme: 'bootstrap4'
            })
            $('.collect_date').bootstrapMaterialDatePicker({
                cancelText: "Abbrechen",
                time: false,
                format: 'YYYY/MM/DD',
                cancelText:"戻る",
                okText:"選択",
                lang: "ja",
            });
            $('.collect_date').on('dateSelected', function(e, date) { 
                id = $(this).attr('data-dtp')
                $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
            });
            $('.closing_date_from').bootstrapMaterialDatePicker({
                cancelText: "Abbrechen",
                time: false,
                format: 'YYYY/MM/DD',
                cancelText:"戻る",
                okText:"選択",
                lang: "ja",
            });
            $('.closing_date_from').on('dateSelected', function(e, date) {
                id = $(this).attr('data-dtp')
                $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
            });

            $('.closing_date_to').bootstrapMaterialDatePicker({
                cancelText: "Abbrechen",
                time: false,
                format: 'YYYY/MM/DD',
                cancelText:"戻る",
                okText:"選択",
                lang: "ja",
            });
            $('.closing_date_to').on('dateSelected', function(e, date) {
                id = $(this).attr('data-dtp')
                $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
            });

            $('.collect_date_desc').click(function(){
                sort = $('.form-search').find('input[name=sort_collect_date]') ;
                if(sort.val() == ""){
                    sort.val('desc')
                } 
                else if(sort.val() == "desc"){
                    sort.val('')
                } else {
                    sort.val('desc')
                }
                $('.form-search').submit();
            })
            $('.collect_date_asc').click(function(){
                sort = $('.form-search').find('input[name=sort_collect_date]') ;
                if(sort.val() == ""){
                    sort.val('asc')
                } 
                else if(sort.val() == "asc"){
                    sort.val('')
                } else {
                    sort.val('asc')
                }
                $('.form-search').submit();
            })

            $('#btn-search, .close-search').click(function(){
                if($('.dropdown-search').hasClass('d-none')){
                    $('.dropdown-search').removeClass('d-none')
                }else{
                    $('.dropdown-search').addClass('d-none')
                }
            })

            $('.check-all-bill').change(function(){
                if($('.check-all-bill').is(':checked')){
                    $('.check-bill').prop("checked", true);
                } else {
                    $('.check-bill').prop("checked", false);
                }
            })

            $(document).on('change','.bill_status',function(){
                status = $(this).val();
                id = $(this).closest('tr').attr('data-id');
                table = $(this).closest('tr').attr('data-table');
                $.ajax({
                    type: "POST",
                    url: "{{ route('billing-manager.change-status') }}",
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
                                $('tr[data-id='+id+'] .td-closing-date').text(data['data']['closing_date']);
                                
                                if(data['data']['collect_date'] != null){
                                    $('tr[data-id='+id+'] .td-collect-date .collect_date').val(data['data']['collect_date']);
                                    $('tr[data-id='+id+'] .td-collect-date .collect_date').attr('disabled',false)
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

            $('.change-many-status').click(function(){
                arr = [] ; 
                $('.check-bill').each(function( index ) {
                    data = {};
                    if($(this).is(':checked')){
                        if($(this).closest('tr').find('.bill_status').val() == 1){
                            data.id = $(this).closest('tr').attr('data-id')
                            data.table = $(this).closest('tr').attr('data-table');
                            arr.push(data);
                        }
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('billing-manager.change-many-status') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        arr_data : arr,
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data['status'] == true) {
                            $('.check-bill').each(function( index ) {
                                if($(this).is(':checked')){
                                    $(this).closest('tr').find('.bill_status option[value=2]').attr('selected',true)
                                    $(this).closest('tr').find('.td-closing-date').text(data['data']['closing_date']);
                                }
                            });

                            Lobibox.notify('success', {
                                title: '成功',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-check-circle',
                                msg: data['message']
                            });
                            location.reload();
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

            $(document).on('change','.collect_date',function(){
                date = $(this).val() ;
                id = $(this).closest('tr').attr('data-id');
                table = $(this).closest('tr').attr('data-table');
                $.ajax({
                    type: "POST",
                    url: "{{ route('billing-manager.change-collect_date') }}",
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

            $('.download-many-pdf').click(function(){
                $('.check-bill').each(function( index ) {
                    if($(this).is(':checked')){
                        if($(this).closest('tr').find('.bill_status').val() == 2){
                            id = $(this).closest('tr').attr('data-id')
                            table = $(this).closest('tr').attr('data-table');
                            if(table == 'original')
                                window.open('/original_contract/download-copy/'+id, '_blank');
                            else
                                window.open('/maker_execution/download-copy/'+id, '_blank');
                        }
                    }
                });
            })
        });
    </script>
@endsection



