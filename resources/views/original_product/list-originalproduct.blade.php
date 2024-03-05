@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.original_product_list')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.original_product_list')}}
@endsection
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="d-flex justify-content-between m-2 row">
      <div class="col-sm-4 mb-2">
        <form class="position-relative">
          <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
          <input class="form-control ps-5 rounded" type="text" placeholder="検索" name="mop_name" value="{{ request()->input('mop_name') }}">
        </form>
      </div>
      @if (Auth::user()->role == 2 || Auth::user()->role == 3)
        <div class="col-sm-5 col-md-4 col-lg-4 mb-2">
            <a href="{{route('add-oproduct')}}" type="button" class="btn btn-primary px-5 float-end">{{__('admin.original_product_add')}}</a>
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
                <th>{{__('admin.original_product_category')}}</th>
                <th>{{__('admin.original_product_name')}}</th>
                <th>{{__('admin.original_product_price')}}</th>
                <th>{{__('admin.original_product_order_period')}}</th>
                @if (Auth::user()->is_admin == 1)
                    <th>{{__('admin.business_location_name')}}</th>
                @endif
                <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($getMOPs as $key => $getMOP)
                <tr>
                  <td>{{$getMOP->id}}</td>
                  <td>
                    <div class="d-flex align-items-center gap-3 cursor-pointer">
                      <div class="">
                        <p class="mb-0">{{$getMOP->category}}</p>
                      </div>
                    </div>
                  </td>
                    <td>{{$getMOP->name}}</td>
                    <td>¥ {{number_format($getMOP->unit_price)}}</td>
                    <td>{{!empty($getMOP->order_period) ? $getMOP->order_period . "日" : ""}}</td>
                    @if (Auth::user()->is_admin == 1)
                        <td>{{$getMOP->businessLocation->name}}</td>
                    @endif
                  <td>
                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                        <a href="{{ route('detail-oproduct', $getMOP->id) }}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="詳細"><i class="bi bi-eye-fill"></i></a>
                        @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                            <a href="{{route('edit-oproduct', $getMOP->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="編集"><i class="bi bi-pencil-fill"></i></a>
                            @if (Auth::user()->role == 2)
                                <a class="text-danger delete-oproduct" data-bs-toggle="tooltip" data-bs-placement="bottom" title="削除" data-id="{{$getMOP->id}}"><i class="bi bi-trash-fill"></i></a>
                            @endif
                        @endif
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class=" justify-content-center">
              {!! $getMOPs->links('pagination::bootstrap-5') !!}
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
      $('.delete-oproduct').click(function(){
        id = $(this).data('id')
        Swal.fire({
        title: '{{ __('message.original_product_want_to_delete') }}',
        showDenyButton: true,
        confirmButtonText: '{{ __('admin.btn_delete') }}',
        denyButtonText: '{{ __('admin.btn_back') }}',
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{ route('delete-oproduct') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id :id
                },
                dataType: 'json',
                success: function(data) {
                    if(data['status'] == true) {
                        $('.delete-oproduct[data-id='+id+']').parent().parent().parent().remove()
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



