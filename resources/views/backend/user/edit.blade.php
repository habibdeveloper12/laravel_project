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
                        <form action = "{{route('user.update',$user->id)}}" method="post">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <h4 class="card-title">Edit User</h4>
                                <p class="card-description">
                                    Modify user
                                </p>
                                <form class="forms-sample">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Username</label>
                                        <input type="text" name="username" class="form-control" id="exampleInputName1" placeholder="Username" value="{{$user->username}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Email</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputName1" placeholder="Email" value="{{$user->email}}">
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>

        @endsection
    </div>

