@extends('backend.layouts.master')


@section('content')


    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-lg-12">
                        @include('backend.layouts.notification')
                    </div>
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
                        <form action = "{{route('paypal.settings.update')}}" method="post">
                            <input type="hidden" name="payment_method" value="paypal">
                            @method('patch')
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title">Payment Methods</h4>

                                <div class="row clearfix">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Paypal Client ID</label>
                                            <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                                            <input type="text" name="PAYPAL_CLIENT_ID" value="{{env('PAYPAL_CLIENT_ID')}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Paypal Secret</label>
                                            <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                                            <input type="text" name="PAYPAL_CLIENT_SECRET" value="{{env('PAYPAL_CLIENT_SECRET')}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Paypal Sandbox Mode</label><br>
                                            <input type="checkbox" value="1" name="paypal_sandbox" @if(get_setting('paypal_sandbox')==1) checked @endif>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                        <button type="submit" class="btn btn-success">Save Changes</button>
                                    </div>
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
