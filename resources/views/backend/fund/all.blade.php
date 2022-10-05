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
                            <h4 class="card-title"> All Transactions </h4>
                            <p class="card-description">
                                Total Transactions : {{\App\Models\TransactionsLog::count()}}
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
                                            Email
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
{{--                                        <th>--}}
{{--                                            Action--}}
{{--                                        </th>--}}
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
                                                {{$transact->email}}
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
                                            ">{{$item->status}}
                                            </td>
{{--                                            <td>--}}
{{--                                                <a href="javascript:void(0)" data-target="#userID{{$item->id}}" class="float-left btn btn-sm btn-outline-secondary" data-toggle="modal" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>--}}
{{--                                                <a href="{{route('user.edit',$item->id)}}" class="float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>--}}


{{--                                            </td>--}}
                                            <!-- Modal -->
                                            <div class="modal fade" id="userID{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    @php
                                                        $user = \App\Models\User::where('id', $item->id)->first();
                                                    @endphp
                                                    <div class="modal-content">
                                                        <div class="text-center">
                                                            <img src="{{$user->photo}}" style="border-radius: 50%; margin: 2% 0; max-height: 100px; max-width: 100px" >
                                                        </div>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">{{$user->username}} </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <strong>Username: </strong>
                                                            <p>{{$user->username}}</p>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <strong>Email: </strong>
                                                                    <p>{{$user->email}}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <strong>Phone: </strong>
                                                                    <p>{{$user->phone}}</p>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <strong>Balance: </strong>
                                                                    <p>{{Helper::currency_converter($user->balance)}}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <strong>Last seen: </strong>
                                                                    <p>{{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <strong>Status: </strong>
                                                                    <p class="badge badge-warning">{{$user->status}}</p>
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
        $(document).ready(function () {
            $('#dtBasicExample').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </script>

@endsection
