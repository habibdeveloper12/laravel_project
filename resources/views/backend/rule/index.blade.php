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
                            <h4 class="card-title">Blacklist Word<a href="javascript:void(0)" data-target="#new"class="btn btn-success" data-toggle="modal" data-placement="bottom" style="float: right"><i class="fa fa-plus-circle"></i> Add New Word</a></h4>

                            <div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add New Word</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action = "{{route('post.word')}}" method="post">
                                                @csrf
                                                <div class="card-body">
                                                    <h4 class="card-title">New Word</h4>

                                                    <form class="forms-sample">
                                                        <div class="form-group">
                                                            <label for="exampleInputName1">Word</label>
                                                            <input type="text" name="word" class="form-control" style="border-color: #13171c" id="exampleInputName1" >
                                                        </div>

                                                        <button type="submit" class="btn btn-primary mr-2">Add</button>
                                                    </form>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                                <p class="card-description">
                                Total Blacklisted Word : {{\App\Models\blacklist::count()}}
                            </p>
                            <div class="table-responsive pt-3">
                                <table id="dtBasicExample" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Word
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($blacklists as $item)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{ucfirst($item->word)}}
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" data-target="#blackID{{$item->id}}" class="mr-1 mb-1 float-left btn btn-sm btn-outline-secondary" data-toggle="modal" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>

                                                <form class="float-left mr-1" action="{{route('word.destroy', $item->id)}}" method="post">
                                                    @csrf
                                                    <a href=""  data-id="{{$item->id}}" class=" dltBtn btn btn-sm btn-outline-danger" data-toggle="tooltip" title="delete" data-placement="bottom"><i class="fas fa-trash-alt"></i></a>
                                                </form>

                                            </td>


                                            <div class="modal fade" id="blackID{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">

                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">{{$item->word}}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action = "{{route('word.update', $item->id)}}" method="post">
                                                                @csrf
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Edit Word</h4>

                                                                    <form class="forms-sample">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputName1">Word</label>
                                                                            <input type="text" name="word" class="form-control" id="exampleInputName1" value="{{$item->word}}">
                                                                        </div>

                                                                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                                                                    </form>

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
                            text: "Once deleted, you will not be able to recover this product!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                    form.submit();
                                    swal("Poof! Product has been deleted!", {
                                        icon: "success",
                                    });
                                } else {
                                    swal("Product is not deleted!");
                                }
                            });

                    })
                </script>



            @endsection
