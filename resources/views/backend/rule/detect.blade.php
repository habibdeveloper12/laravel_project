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
                  <h4 class="card-title">Rule violators</h4>

                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                           Buyer
                          </th>
                          <th>
                            Seller
                          </th>
                            <th>
                                Message
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($reports as $item)
                            @php
                            $seller = \App\Models\User::where('user_id',$item->seller_id)->first();
                            $buyer = \App\Models\User::where('user_id',$item->user_id)->first();
                             $order = \App\Models\Order::where('order_number', $item->order_id)->first();
                            @endphp

                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{ucfirst($buyer->username)}}
                                </td>
                                <td>
                                    {{ucfirst($seller->username)}}
                                </td>
                                <td>
                                    {{ucfirst($item->message)}}
                                </td>
                                <td>
                                    <input type="checkbox" name="toggle" value="{{$item->id}}" data-toggle="switchbutton" {{$item->status=='active' ? 'checked' : ''}} data-onlabel="active" data-offlabel="inactive" data-size="sm" data-onstyle="success" data-offstyle="danger">
                                </td>
                                <td>
                                    {{date('d M Y - g:i A ', strtotime($item->created_at))}}
                                </td>

                                <td>
                                    <a href="{{route('chat.show',$item->id)}}" class="float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="Chat with them" data-placement="bottom"><i class="fas fa-envelope"></i></a>
                                </td>

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
