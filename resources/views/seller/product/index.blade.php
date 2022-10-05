@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<style>
    .ord{
        margin-top: 20px;
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 5px;

    }

    @media only screen and (max-width: 991px) {
        .ord{
            margin-top: 25px;
        }
    }
</style>
@section('content')
    <div class="content">
        <div class="container ord">


                <div class="main-panel">
                    <div class="content-wrapper">

                        <div class="row mb-2" >
                            <div class="col-12 text-center">
                                <h2 style="color: white;text-transform: uppercase;">Y O U R &nbsp;&nbsp;  O F F E R S</h2>
                                <hr style="border: 2px solid white"/>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-12">

                                @include('frontend.layouts.notification')   @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card " style="margin-bottom: 67px; border-radius: 5px">
                                    <div class="card-body">
                                        <div > <a href="{{route('seller-product.create')}}" class="btn btn-success" style="float: right; padding: 5px"><i class="fa fa-plus-circle"></i> Create New Offer </a></div>
                                        <p class="card-description">
                                            Total Offers : {{$products->count()}}
                                        </p>
                                        <div class="table-responsive pt-3 mt-5">
                                            <table  id="sortTable" class="table table-sm" style="border-radius: 5px; border-color: red" >
                                                <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <th>
                                                        Game
                                                    </th>
                                                    <th>
                                                        Category
                                                    </th>
                                                    <th>
                                                        Photo
                                                    </th>
                                                    <th>
                                                        Price
                                                    </th>

                                                    <th>
                                                        Delivery Type
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
                                                            <a href="{{route('product.detail', $item->slug)}}"> {{ucfirst($item->title)}}</a>
                                                        </td>
                                                        <td>
                                                            {{ucfirst( \App\Models\Category::where('id', $item->cat_id)->value('title'))}}
                                                        </td>
                                                        <td>
                                                            @if($item->photo)
                                                                <img src="{{asset('/images/products/'. $item->photo)}}" alt="product image" style="max-height: 70px;border-radius: 0px ;max-width: 120px">
                                                            @else
                                                                <img src="{{Helper::productDefaultImage()}}" alt="product image" style="max-height: 70px;border-radius: 0px ;max-width: 120px">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{Helper::currency_converter($item->price)}}
                                                        <td>
                                                            {{ucfirst($item->delivery)}}
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="toggle" value="{{$item->id}}" data-toggle="switchbutton" {{$item->status=='active' ? 'checked' : ''}} data-onlabel="active" data-offlabel="inactive" data-size="sm" data-onstyle="success" data-offstyle="danger">
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" data-target="#productID{{$item->id}}" class="mr-1 mb-1 float-left btn btn-sm btn-outline-secondary" data-toggle="modal" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                                            <a href="{{route('seller-product.edit',$item->id)}}" class="mr-1 mb-1 float-left btn btn-sm btn-outline-warning" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                            <form class="float-left mr-1" action="{{route('seller-product.destroy', $item->id)}}" method="post">
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
                                                                        <h3 class="modal-title" id="exampleModalLongTitle">{{ucfirst($product->title)}}</h3>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong>Offer Title: </strong>
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
                                                                            <div class="col-md-12">
                                                                                <strong>Category: </strong>
                                                                                <p>{{ucfirst( \App\Models\Category::where('id', $product->cat_id)->value('title'))}}</p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <strong>Status: </strong>
                                                                                <p>{{ucfirst($product->status)}}</p>
                                                                            </div>

                                                                            <div class="col-6">
                                                                                <strong>Server:</strong>
                                                                                <p> {{ucfirst($product->server)}}</p>
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
                text: "Once deleted, you will not be able to recover this Product!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Poof! Your Offer has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your offer is not deleted!");
                    }
                });

        })
    </script>
    <script>
        $('input[name=toggle]').change(function(){
            var mode=$(this).prop('checked')
            var id  =$(this).val();

            $.ajax({
                url:"{{route('seller.product.status')}}",
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
    <script src="https://code.jquery.com/jquery-3.6.0.js"> </script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" defer></script>


    <script>
        $(document).ready(function() {
            $("#sortTable").DataTable();
        });
    </script>
@endsection
