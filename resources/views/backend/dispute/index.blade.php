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
                  <h4 class="card-title">Disputes</h4>
                  <p class="card-description">
                      Total Disputes :{{\App\Models\AdminNotification::where('status', 'active')->count()}}
                  </p>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                            <th>
                                Order ID
                            </th>
                          <th>
                           Buyer
                          </th>
                          <th>
                            Seller
                          </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($disputes as $item)
                            @php
                            $seller = \App\Models\User::where('user_id',$item->seller_id)->first();
                            $buyer = \App\Models\User::where('user_id',$item->user_id)->first();
                             $order = \App\Models\Order::where('order_number', $item->order_id)->first();
                             $product = \App\Models\Product::where('id', $order->product_id)->first();

                                if(!$seller || !$buyer || !$order || !$product){
                                     header("Location: " . URL::to('/admin'), true, 302);
                                     exit();
                                }
                            @endphp


                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$item->order_id}}
                                </td>
                                <td>
                                    {{ucfirst($buyer->username)}}
                                </td>
                                <td>
                                    {{ucfirst($seller->username)}}
                                </td>

                                <td>
                                    <input type="checkbox" name="toggle" value="{{$item->id}}" data-toggle="switchbutton" {{$item->status=='active' ? 'checked' : ''}} data-onlabel="active" data-offlabel="inactive" data-size="sm" data-onstyle="success" data-offstyle="danger">
                                </td>
                                <td>
                                    <a href="javascript:void(0)" data-target="#disputeID{{$item->id}}" class="mr-1 mb-1 float-left btn btn-sm btn-outline-secondary" data-toggle="modal" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                    <a href="{{route('order.show',$order->id)}}" class="float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="Chat with them" data-placement="bottom"><i class="fas fa-envelope"></i></a>
                                </td>

                                <div class="modal fade" id="disputeID{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">ORDER #{{$item->order_id}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Seller: </strong>
                                                        <p> {{ucfirst($seller->username)}} </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Buyer: </strong>
                                                        <p> {{ucfirst($buyer->username)}} </p>
                                                    </div>
                                                </div>


                                                <strong>Description: </strong>
                                                <p>{!! html_entity_decode($item->description) !!}</p>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Product name: </strong>
                                                        <p>{{Helper::currency_converter($product->offer_price)}}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Quantity: </strong>
                                                        <p>{{$order->quantity}}</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Total: </strong>
                                                        <p>{{Helper::currency_converter($order->total)}}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Order Status: </strong>
                                                        <p>{{$order->condition}}</p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </tr>

                        @endforeach

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
        <script>
            $('input[name=toggle]').change(function(){
                var mode=$(this).prop('checked')
                var id  =$(this).val();

                $.ajax({
                    url:"{{route('dispute.status')}}",
                    type:"POST",
                    data:{
                        _token:'{{csrf_token()}}',
                        mode:mode,
                        id:id,
                    },
                    success:function (response){
                        if(response.status){
                            alert(response.msg)
                        }else {
                            alert('please try again')
                        }
                    }
                })
            })
        </script>
    @endsection
