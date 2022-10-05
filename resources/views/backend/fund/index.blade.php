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
                            <h4 class="card-title"> Pending Transactions </h4>
                            <p class="card-description">
                                Total Pending Transactions : {{\App\Models\TransactionsLog::where('status', 'pending')->count()}}
                            </p>
                            <div class="table-responsive pt-3">
                                <table id="dtBasicExample" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>
                                            Date
                                        </th>

                                        <th>
                                            Username
                                        </th>

                                        <th>
                                            Transaction Description
                                        </th>

                                        <th>
                                            Transaction type
                                        </th>


                                        <th>
                                            Amount
                                        </th>
                                        <th>
Status
                                        </th>

                                        <th>
                                            Approve Transaction
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $item)
                                        @php
                                            $transact = \App\Models\User::where('user_id', $item->user_id)->first();
                                        @endphp

                                        <tr>
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans()}}
                                            </td>
                                            <td>
                                                {{ucfirst($transact->username)}}

                                            </td>
                                            <td>
                                                {{$item->description}}
                                            </td>
                                            <td>
                                                {{$item->type}}
                                            </td>
                                            <td>
                                                {{Helper::currency_converter($item->amount)}}
                                            </td>
                                            <td class="badge p-1 m-3
                                              @if($item->status == 'pending')
                                                badge-warning
                                                @elseif($item->status == 'declined')
                                                badge-danger
                                                @elseif($item->status == 'approved')
                                                badge-success
                                                @else
                                                badge-secondary

                                            @endif


                                            b">

                                            {{$item->status}}
                                            </td>
                                            <style>
                                                .yes, .no{
                                                    padding: 10px;
                                                }
                                            </style>
                                            <td>
                                                <button class="yes btn btn-success" value="{{$item->id}}">Yes</button>

                                                <button class="no btn btn-danger" value="{{$item->id}}">No</button>
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
        $(document).ready(function () {
            $('#dtBasicExample').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </script>

    <script>
        $('.yes').click(function(){
            var id  =$(this).val();
            var path = "{{route('approve.transaction')}}";

            $.ajax({
                url:path,
                type:"POST",
                data:{
                    _token:'{{csrf_token()}}',
                    id:id,
                }, success:function (response){
                    window.location.reload();
                },
                error:function (err) {
                }
            })
        })
    </script>
    <script>
        $('.no').click(function(){
            var id  =$(this).val();
            var path = "{{route('disapprove.transaction')}}";

            $.ajax({
                url:path,
                type:"POST",
                data:{
                    _token:'{{csrf_token()}}',
                    id:id,
                }, success:function (response){
                    window.location.reload();
                },
                error:function (err) {
                    console.log(err);
                }
            })
        })
    </script>


@endsection
