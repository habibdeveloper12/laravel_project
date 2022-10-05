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
                            <h4 class="card-title">Withdrawal requests </h4>
                            <p class="card-description">
                                Total Withdrawal Requests :{{$withdraw->count()}}
                            </p>
                            <div class="table-responsive pt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Username
                                            </th>
                                            <th>
                                                Email
                                            </th>
                                            <th>
                                                Withdrawal Method
                                            </th>
                                            <th>
                                                Amount
                                            </th>
                                            <th>
                                                Amount to be received ({{\App\Models\Settings::first()->withdraw_fee}}%)
                                            </th>
                                            <th>
                                                Approve
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($withdraw as $item)

                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>

                                            <td>
                                                {{$item->username}}
                                            </td>
                                            <td>
                                                {{$item->email}}
                                            </td>
                                            <td>
                                                @if($item->method == 'bank_card')
                                                    Bank Card
                                                @else
                                                    Others
                                                @endif
                                            </td>
                                            <td>
                                                {{Helper::currency_converter($item->amount)}}
                                            </td>
                                            <td>
                                                {{Helper::currency_converter($item->amount_to_receive)}}
                                            </td>

                                            <td>
                                                <form method="post" action="{{route('seller.withdraw')}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <input type="hidden" name="user_id" value="{{$item->user_id}}">
                                                    <input type="hidden" name="status" value="yes">
                                                    @csrf
                                                    <button type="submit" data-id="{{$item->id}}" class="yes btn btn-success" >Yes</button>
                                                </form>

                                                <form method="post" action="{{route('seller.withdraw')}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <input type="hidden" name="user_id" value="{{$item->user_id}}">
                                                    <input type="hidden" name="status" value="no">
                                                    @csrf
                                                    <button type="submit" data-id="{{$item->id}}" class="no btn btn-danger" >No</button>
                                                </form>
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
        $('.yes').click(function (e) {
            var form = $(this).closest('form');
            var dataID =$(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure you want to release funds?",
                text: "Once confirmed, you will not be able to revert it!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Thanks! Payment is processing", {
                            icon: "success",
                        });
                    } else {
                        swal("Payment not processed!");
                    }
                });

        })
    </script>

    <script>
        $('.no').click(function (e) {
            var form = $(this).closest('form');
            var dataID =$(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure you want to cancel this request?",
                text: "Once confirmed, you will not be able to revert it!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Thanks! Request cancelled.", {
                            icon: "success",
                        });
                    } else {
                        swal("Payment not processed!");
                    }
                });

        })
    </script>

@endsection
