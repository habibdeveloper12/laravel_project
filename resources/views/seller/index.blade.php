@extends('seller.layouts.master')


@section('content')
     <!-- partial -->
     <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-lg-12">
                @include('backend.layouts.notification')
            </div>

            <div class="row">
            <div class="col-md-12 grid-margin">

              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 mr-xl-5">
                    <h2>Welcome back, </h2>
                    <p class="mb-md-0">Your seller dashboard.</p>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;</p>

                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                      <li class="nav-item">
                          <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Earnings</a>
                      </li>
                  </ul>
                  <div class="tab-content py-0 px-0">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                          <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-shopping mr-3 icon-lg text-warning"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total Products</small>
                            <h5 class="mr-2 mb-0">{{\App\Models\Product::where(['status'=>'active', 'added_by'=> $user->username])->count()}}</h5>
                          </div>
                        </div>
                          <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                              <i class="mdi mdi-cart-outline mr-3 icon-lg text-danger"></i>
                              <div class="d-flex flex-column justify-content-around">
                                  <small class="mb-1 text-muted">Total Orders</small>
                                  <h5 class="mr-2 mb-0">{{$count}}</h5>
                              </div>
                          </div>
                        <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total Customers</small>
                            <h5 class="mr-2 mb-0">{{\App\Models\User::where(['status'=> 'active', ])->count()}}</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                      <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                          <div class="d-flex flex-wrap justify-content-xl-between">
                              <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                  <i class="mdi mdi-cash-multiple mr-3 icon-lg text-success"></i>
                                  <div class="d-flex flex-column justify-content-around">
                                      <small class="mb-1 text-muted">Balance</small>
                                      <h5 class="mr-2 mb-0">{{Helper::currency_converter($balance)}}</h5>
                                  </div>
                              </div>
                              <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                  <i class="mdi mdi-currency-usd mr-3 icon-lg text-success"></i>
                                  <div class="d-flex flex-column justify-content-around">
                                      <small class="mb-1 text-muted">Available for withdrawal</small>
                                      <h5 class="mr-2 mb-0">{{Helper::currency_converter($balance - $balance * 0.13)}}</h5>
                                  </div>
                              </div>
                              <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                  <div class="d-flex flex-column justify-content-around">
                                      <h5 class="mr-2 mb-0"><a href="{{route('earnings')}}" class="btn btn-warning">Withdraw</a></h5>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Recent Orders <a href="{{route('orders.index')}}" class="btn btn-success" style="float: right">View all</a></p>
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Buyer Name</th>
                            <th>Game</th>
                            <th>Payment Status</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      @forelse($orders as $items)
                          @foreach($items->products as $item)
                              @if($item->pivot->added_by == $user->id)
                                  <tr>
                                      <td>{{$items->order_number}}</td>
                                      @php
                                          $username = \App\Models\User::where('user_id', $items->user_id)->get('username')->first()->username;
                                      @endphp
                                      <td>{{ucfirst($username)}}</td>
                                      <td>{{ucfirst($item->title)}}</td>
                                      <td>{{ucfirst($items->payment_status)}}</td>


                                      <td>
                                                <span class="badge
                                                 @if($item->pivot->condition == 'pending')
                                                    badge-info
                                                @elseif($item->pivot->condition == 'processing')
                                                    badge-primary
                                                @elseif($item->pivot->condition == 'delivered')
                                                    badge-success
                                                @elseif($item->pivot->condition == 'received')
                                                    badge-success mdi mdi-checkbox-marked-circle-outline
                                                @else
                                                    badge-danger
                                                @endif
                                                    "> {{ucfirst($item->pivot->condition)}}
                                                </span>
                                      </td>
                                      <td>
                                          <a href="{{route('orders.show',$item->pivot->prod_ord_id)}}" class="float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                      </td>

                                  </tr>
                              @endif
                          @endforeach

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
        <!-- content-wrapper ends -->

@endsection

