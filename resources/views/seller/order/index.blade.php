@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@section('content')
    <style>
    .ord{
    margin-top: 20px !important;
    margin-bottom: 30px;
    background-color: rgba(239,239,239,0.72);
    border-radius: 5px;
        min-height: 800px;
    }

    @media only screen and (max-width: 991px) {
    .ord{
    margin-top: 20px !important;
    }
    }
    </style>

    <div class="container ord">

        <h2 style=" padding: 20px"> My Sales</h2>
        <hr/>



        <div class="row" style="margin-bottom: 80px; padding: 0 30px">
            @if(count($orders)> 0)

                <div class="table-responsive pt-3">
                    <table class="table " id="sortTable" style="border-radius: 5px">
                        <p style="font-size: 16px">This is the list of items you have sold.</p>
                        <br/>
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Game</th>
                            <th>Payment Status</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $item)
                            @if($item->seller == $user->user_id)
                                <tr>
                                    <td>
                                        {{date('d M Y - g:i A ', strtotime($item->created_at))}}
                                    </td>
                                    <td>{{$item->order_number}}</td>
                                    <td>
                                        {{ucfirst($item->product)}} {{ucfirst(\App\Models\Category::where('id', \App\Models\Product::where('id',$item->product_id)->first()->cat_id)->first()->title)}}
                                    </td>
                                    <td>{{ucfirst($item->payment_status)}}</td>
                                    <td>
                                        <span class="badge
                                                 @if($item->condition == 'pending')
                                                    bg-warning
                                                @elseif($item->condition == 'delivered')
                                                    bg-info
                                                @elseif($item->condition == 'completed')
                                                    bg-success fa fa-check
                                                @else
                                                    bg-danger
                                                @endif
                                                    "> {{ucfirst($item->condition)}}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{route('orders.show',$item->id)}}" class="float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>

                                    </td>

                                </tr>
                            @endif
                        @endforeach


                        </tbody>
                    </table>
                </div>


            @else
                <h3> Empty </h3>

            @endif

        </div>


    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.js"> </script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" defer></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        $("#sortTable").DataTable();
    });
</script>
