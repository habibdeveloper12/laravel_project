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
                        <form action = "{{route('settings.withdraw.update')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title">Edit Withdrawal Settings</h4>
                                <div class="forms-sample">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Withdrawal Fee (%)</label><span class="text-danger">*</span>
                                        <input type="text" name="withdraw_fee" class="form-control" id="exampleInputName1" placeholder="e.g 10" value="{{$settings->withdraw_fee}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Minimum Withdraw ($)</label><span class="text-danger">*</span>
                                        <input type="text" name="withdraw_min" class="form-control" id="exampleInputName1" placeholder="" value="{{$settings->withdraw_min}}">
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                                </form>
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
                    $('#lfm1').filemanager('image');
                    $('#lfm2').filemanager('image');
                    $('#lfm3').filemanager('video');
                    $('#lfm4').filemanager('image');
                    $('#lfm5').filemanager('image');

                </script>

                <script>
                    $(document).ready(function() {
                        $('#description').summernote();
                    });
                </script>

@endsection
