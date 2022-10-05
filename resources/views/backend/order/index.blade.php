@extends('backend.layouts.master')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    @include('backend.layouts.notification')
                </div>

                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Orders List</h4>
                            <p class="card-description">
                                Total Orders :{{\App\Models\Order::count()}}
                            </p>
                            <div class="table-responsive pt-3">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Buyer Name</th>
                                        <th>Seller Name</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($orders as $item)
                                            @php
                                                $seller = \App\Models\User::where('user_id', $item->seller)->first();
                                            @endphp
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->order_number}}</td>
                                            <td>{{$item->username}}</td>
                                            <td>{{$seller->username}}</td>
                                            <td>{{Helper::currency_converter($item->total)}}</td>

                                            <td><span class="badge
                                                  @if($item->condition == 'pending')
                                                    badge-info
@elseif($item->condition == 'delivered')
                                                    badge-primary
@elseif($item->condition == 'completed')
                                                    badge-success
@else
                                                    badge-danger
@endif
                                                    ">{{$item->condition}}</span>
                                            </td>
                                            <td>
                                                <a href="{{route('order.show',$item->id)}}" class="float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>

                                            </td>

                                        </tr>

                                    @empty
                                        <tr>
                                            No Orders
                                        </tr>

                                    @endforelse


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
    </div>
@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $.ajaxSetup({
            header: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>
@endsection

