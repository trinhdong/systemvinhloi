@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.business_location_list')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.business_location_list')}}
@endsection
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="d-flex justify-content-between m-2 row">
      <div class="col-sm-4 mb-2">
        <form class="position-relative">
          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
          <input class="form-control ps-5 rounded" type="text" placeholder="検索" name="business_name" value="{{ request()->input('business_name') }}">
        </form>
      </div>
      @if (Auth::user()->is_admin == true)
        <div class="col-sm-5 col-md-4 col-lg-4 mb-2">
            <a href="{{ route('add-business') }}" type="button" class="btn btn-primary px-5 float-end">{{__('admin.business_location_add')}}</a>
        </div>
      @endif
    </div>
    <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <table class="table align-middle last-child-right">
              <thead class="table-secondary">
                <tr>
                <th>ID</th>
                <th>{{__('admin.business_location_name')}}</th>
                <th>{{__('admin.business_location_adress')}}</th>
                <th>{{__('admin.business_location_phone')}}</th>
                <th>{{__('admin.business_location_earnings')}}</th>
                <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($businesses as $key => $business)
                <tr>
                  <td>{{ $business->business_code }}</td>
                  <td>
                    <div class="d-flex align-items-center gap-3 cursor-pointer">
                      <div class="">
                        <p class="mb-0">{{$business->name}}</p>
                      </div>
                    </div>
                  </td>
                  <td>{{$business->address}}</td>
                  <td>{{$business->phone_number}}</td>
                  <td>
                    @php
                        $totalSupplierContract = 0;
                        $totalOriginalContract = 0;
                        foreach ($business->SupplierContract as $key => $value) {
                           $totalSupplierContract += $value->getRevenue();
                        }
                        foreach ($business->originalContract as $key => $value) {
                           $totalOriginalContract += $value->getRevenue();
                        }
                        $total = $totalSupplierContract + $totalOriginalContract;
                    @endphp
                    ¥ {{number_format($total,2)}}
                  <td>
                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                        <a href="{{ route('detail-business', $business->id) }}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="詳細"><i class="bi bi-eye-fill"></i></a>
                      @if (Auth::user()->is_admin == 1)
                        <a href="{{ route('edit-business', $business->id) }}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="編集"><i class="bi bi-pencil-fill"></i></a>
                        <a class="text-danger delete-business" data-bs-toggle="tooltip" data-bs-placement="bottom" title="削除" data-id="{{ $business->id }}"><i class="bi bi-trash-fill"></i></a>
                      @endif
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class=" justify-content-center">
              {!! $businesses->links('pagination::bootstrap-5') !!}
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
      $('.delete-business').click(function(){
        id = $(this).data('id')
        Swal.fire({
        title: '{{ __('message.bussiness_want_to_delete') }}',
        showDenyButton: true,
        confirmButtonText: '{{ __('admin.btn_delete') }}',
        denyButtonText: '{{ __('admin.btn_back') }}',
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{ route('delete-business') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id :id
                },
                dataType: 'json',
                success: function(data) {
                    if(data['status'] == true) {
                        $('.delete-business[data-id='+id+']').parent().parent().parent().remove()
                        Lobibox.notify('success', {
                            title: '成功',
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            icon: 'bx bx-check-circle',
                            msg: data['message']
                        });
                    } else {
                    }
                },
            });
        } else if (result.isDenied) {

        }
      })
      })
    });
  </script>
@endsection



