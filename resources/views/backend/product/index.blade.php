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
                            <h4 class="card-title">Product List <a href="{{route('product.create')}}" class="btn btn-success" style="float: right"><i class="fa fa-plus-circle"></i> Create Product </a></h4>
                            <p class="card-description">
                                Total Products : {{\App\Models\Product::count()}}
                            </p>
                            <div class="table-responsive pt-3">
                                <table id="dtBasicExample" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Title
                                        </th>
                                        <th>
                                            Photo
                                        </th>
                                        <th>
                                            Price
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
                                    @foreach($products as $item)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{ucfirst($item->title)}}
                                            </td>
                                            <td>
                                                @if($item->photo)
                                                    <img src="{{$item->photo}}" alt="product image" style="max-height: 98px;border-radius: 0px ;max-width: 120px">
                                                @else
                                                    <img src="{{Helper::productDefaultImage()}}" alt="product image" style="max-height: 98px;border-radius: 0px ;max-width: 120px">
                                                @endif
                                            </td>
                                            <td>
                                                {{Helper::currency_converter($item->offer_price)}}
                                            </td>
                                            <td>
                                                <input type="checkbox" name="toggle" value="{{$item->id}}" data-toggle="switchbutton" {{$item->status=='active' ? 'checked' : ''}} data-onlabel="active" data-offlabel="inactive" data-size="sm" data-onstyle="success" data-offstyle="danger">
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" data-target="#productID{{$item->id}}" class="mr-1 mb-1 float-left btn btn-sm btn-outline-secondary" data-toggle="modal" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                                <a href="{{route('product.edit',$item->id)}}" class="mr-1 mb-1 float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                <form class="float-left mr-1" action="{{route('product.destroy', $item->id)}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <a href=""  data-id="{{$item->id}}" class=" dltBtn btn btn-sm btn-outline-danger" data-toggle="tooltip" title="delete" data-placement="bottom"><i class="fas fa-trash-alt"></i></a>
                                                </form>

                                            </td>

                                            <!-- Modal -->
                                            <div class="modal fade" id="productID{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    @php
                                                    $product = \App\Models\Product::where('id', $item->id)->first();
                                                    @endphp
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ucfirst($product->title)}}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <strong>Summary: </strong>
                                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                                            <strong>Description: </strong>
                                                            <p>{!! html_entity_decode($product->description) !!}</p>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <strong>Price: </strong>
                                                                    <p>{{Helper::currency_converter($product->offer_price)}}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <strong>Stock: </strong>
                                                                    <p>{{$product->stock}}</p>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <strong>Category: </strong>
                                                                    <p>{{ucfirst(\App\Models\Category::where('id', $product->cat_id)->value('title'))}}</p>
                                                                </div>


                                                                <div class="col-md-6">
                                                                    <strong>Seller: </strong>
                                                                    <p>{{ucfirst($product->added_by)}}</p>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <strong>Server: </strong>
                                                                    <p>{{ucfirst($product->server)}}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <strong>Delivery: </strong>
                                                                    <p>{{ucfirst($product->delivery)}}</p>
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
