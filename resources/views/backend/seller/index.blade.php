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
                  <h4 class="card-title">Seller List </h4>
                  <p class="card-description">
                      Total Sellers :{{$sellers->count()}}
                  </p>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
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
                                Status
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($sellers as $item)

                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    <img src="{{$item->photo == null ? Helper::userDefaultImage() : $item->photo}}" alt="profile image" style="max-height: 98px;border-radius: 0px ;max-width: 120px">
                                </td>
                                <td>
                                    {{$item->username}}
                                </td>
                                <td>
                                    {{$item->email}}
                                </td>

                                <td>
                                    <input type="checkbox" name="toggle" value="{{$item->id}}" data-toggle="switchbutton" {{$item->status=='active' ? 'checked' : ''}} data-onlabel="active" data-offlabel="inactive" data-size="sm" data-onstyle="success" data-offstyle="danger">
                                </td>
                                <td>
                                    <a href="{{route('seller.edit',$item->id)}}" class="float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form class="float-left ml-1" action="{{route('seller.destroy', $item->id)}}" method="post">
                                       @csrf
                                        @method('delete')
                                        <a href=""  data-id="{{$item->id}}" class="dltBtn btn btn-sm btn-outline-danger" data-toggle="tooltip" title="delete" data-placement="bottom"><i class="fas fa-trash-alt"></i></a>

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
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                            swal("Poof! Your imaginary file has been deleted!", {
                                icon: "success",
                            });
                        } else {
                            swal("Your imaginary file is safe!");
                        }
                    });

            })
        </script>
    @endsection
