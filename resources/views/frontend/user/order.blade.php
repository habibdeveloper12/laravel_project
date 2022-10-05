@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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

@section('content')

    <div class="content">
        <div class="container ord">
            <h2 class="ml-sm-1 p-4" >My Orders</h2>
            <hr/>
            <!-- STORE -->
            <div id="store" class="col-md-12">

                @if(count($orders)>0)
                    <p>This is the list of the items you have purchased</p>
                <br/>
                <div class="table-responsive mb-5" style="white-space: nowrap!important;">
                    <table class="table "  id="sortTable" style="border-radius: 5px">

                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Game</th>
                                <th>Payment Status</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($orders as $item)

                                    <tr>
                                        <td>
                                            {{$item->order_number}}
                                        </td>
                                        <td>
                                            {{ucfirst($item->product)}} {{ucfirst(\App\Models\Category::where('id', \App\Models\Product::where('id',$item->product_id)->first()->cat_id)->first()->title)}}
                                        </td>
                                        <td>
                                            {{ucfirst($item->payment_status)}}
                                        </td>
                                        <td>
                                            {{Helper::currency_converter($item->total)}}
                                        </td>
                                        <td>
                                            <span class="badge
                                                 @if($item->condition == 'pending')
                                                bg-warning
                                                    @elseif($item->condition == 'delivered')
                                                bg-info
                                                     @elseif($item->condition == 'completed')
                                                bg-success
                                                    @else
                                                bg-danger
                                                    @endif
                                                "> {{ucfirst($item->condition)}}
                                        </span>
                                        </td>
                                        <td>
                                            {{date('d M Y - g:i A ', strtotime($item->created_at))}}
                                        </td>
                                        <td>
                                            <a href="{{route('user-order.show',$item->id)}}" class="float-left btn btn-warning" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                        </tbody>


                    </table>
                </div>

                @else
                    <style>

                        @media only screen and (max-width: 991px) {
                            #footer{
                                position: initial;
                            }
                            .ord{
                                margin-top: 50px !important;
                                margin-bottom: 30px;
                            }
                        }
                    </style>
                    <P style="font-size: 16px">You have not purchased any item yet go to <a href="{{route('shop')}}"><b>SHOP</b></a> to order </P>
                @endif
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.js"> </script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" defer></script>


    <script>
        $(document).ready(function() {
            $("#sortTable").DataTable();
        });
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


        @endsection

