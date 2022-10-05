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
                            <h4 class="card-title">Previous Announcements <a href="javascript:void(0)" data-target="#prod" class="btn btn-success" data-toggle="modal" title="view" data-placement="bottom" style="float: right"><i class="fa fa-plus-circle"></i> Create Announcement </a></h4>

                            <div class="modal fade" id="prod" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Make Announcement</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action = "{{route('post.announcement')}}" method="post" enctype="multipart/form-data">
                                                @csrf

                                                        <div class="form-group">
                                                            <label for="exampleTextarea1">Description</label>
                                                            <textarea id="description" class="form-control description" rows="5"  placeholder="Write some text..." name="description">{{old('description')}}</textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Image upload</label>
                                                            <input type="file" name="photo" class="form-control" >
                                                        </div>

                                                        <button type="submit" class="btn btn-primary mr-2">Send</button>
                                                        <button class="btn btn-light">Cancel</button>
                                            </form>
                                        </div>

                                        </div>

                                    </div>
                                </div>


                            <p class="card-description">
                                Total : {{count($announcements)}}
                            </p>
                            <div class="table-responsive pt-3">
                                <table id="dtBasicExample" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Message
                                        </th>
                                        <th>
                                            File
                                        </th>
                                        <th>
                                            Date Sent
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($announcements as $item)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{ucfirst($item->body)}}
                                            </td>
                                            <td>
                                                @if($item->file_type == 'jpg' || $item->file_type == 'png' || $item->file_type == 'jpeg' || $item->file_type == 'jfif' || $item->file_type == 'svg' || $item->file_type == 'gif')
                                                    <img src="{{$item->file}}" alt="product image" style="max-height: 98px;border-radius: 0px ;max-width: 120px">
                                                @else
                                                   <a href="{{$item->file}}">{{$item->filename}}</a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans()}}
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
        $('input[name=toggle]').change(function(){
            var mode=$(this).prop('checked')
            var id  =$(this).val();

            $.ajax({
                url:"{{route('product.status')}}",
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
