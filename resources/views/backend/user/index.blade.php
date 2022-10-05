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
                            <h4 class="card-title">Users List</h4>
                            <p class="card-description">
                                Total Users : {{\App\Models\User::count()}}
                            </p>
                            <div class="table-responsive pt-3">
                                <table id="dtBasicExample" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Photo
                                        </th>
                                        <th>
                                            Username
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Seller
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $item)

                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                @if($item->photo)
                                                    <img src="{{$item->photo}}" alt="user image" style="max-height:68px;border-radius: 50% ;max-width: 68px">
                                                @else
                                                    <img src="{{Helper::userDefaultImage()}}" alt="user image" style="max-height:68px;border-radius: 50% ;max-width: 68px">
                                                @endif

                                            </td>
                                            <td>
                                                {{ucfirst($item->username)}}
                                            </td>
                                            <td>
                                                {{$item->email}}
                                            </td>
                                            <td>
                                                @if($item->seller == 0)
                                                    No
                                                @else
                                                    Yes
                                                @endif
                                            </td>
                                            <td>
                                                <input type="checkbox" name="toggle" style="padding: 40px" value="{{$item->id}}" data-toggle="switchbutton" {{$item->status=='active' ? 'checked' : ''}} data-onlabel="active" data-offlabel="inactive" data-size="sm" data-onstyle="success" data-offstyle="danger">
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" data-target="#userID{{$item->id}}" class="float-left btn btn-sm btn-outline-secondary" data-toggle="modal" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                                <a href="{{route('user.edit',$item->id)}}" class="float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>

                                            </td>
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
                                                                    <p class="badge

                                                                    @if($user->status == 'active')
                                                                        badge-success

                                                                    @else
                                                                        badge-danger
                                                                    @endif



                                                                ">{{$user->status}}</p>
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
        $('.dltBtn').click(function (e) {
            var form = $(this).closest('form');
            var dataID =$(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover the user!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Poof! User has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("User is safe!");
                    }
                });

        })
    </script>
    <script>
        $('input[name=toggle]').change(function(){
            var mode=$(this).prop('checked')
            var id  =$(this).val();

            $.ajax({
                url:"{{route('user.status')}}",
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
    <script>
        $(document).ready(function () {
            $('#dtBasicExample').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </script>

@endsection
