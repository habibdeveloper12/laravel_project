@extends('backend.layouts.master')


@section('content')


    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <form action = "{{route('currency.update',$currency->id)}}" method="post">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <h4 class="card-title">Edit Currency</h4>
                                <p class="card-description">
                                    edit previous currency
                                </p>
                                <form class="forms-sample">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Currency Name</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Currency name" value="{{$currency->name}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Symbol</label>
                                        <input type="text" name="symbol" class="form-control" id="exampleInputName1" placeholder="Symbol" value="{{$currency->symbol}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Exchange rate</label>
                                        <input type="text" name="exchange_rate" class="form-control" id="exampleInputName1" placeholder="Exchange rate" value="{{$currency->exchange_rate}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Code</label>
                                        <input type="text" name="code" class="form-control" id="exampleInputName1" placeholder="Currency code" value="{{$currency->code}}">
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                    </div>
                </div>
                </form>

            </div>
        </div>

        @endsection
    </div>

@section('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script>
        $('#lfm').filemanager('image');
    </script>

    <script>
        $(document).ready(function() {
            $('#description').summernote();
        });
    </script>

@endsection
