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
                    <form action = "{{route('currency.store')}}" method="post">
                        @csrf
            <div class="card-body">
                  <h4 class="card-title">Add Currency</h4>
                  <p class="card-description">
                    Add a new currency
                  </p>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputName1">Currency Name</label>
                      <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Currency Name" value="{{old('name')}}">
                    </div>

                      <div class="form-group">
                          <label for="exampleInputName1">Symbol</label>
                          <input type="text" name="symbol" class="form-control" id="exampleInputName1" placeholder="Symbol" value="{{old('symbol')}}">
                      </div>

                      <div class="form-group">
                          <label for="exampleInputName1">Exchange rate</label>
                          <input type="text" name="exchange_rate" class="form-control" id="exampleInputName1" placeholder="Exchange rate" value="{{old('exchange_rate')}}">
                      </div>
                      <div class="form-group">
                          <label for="exampleInputName1">Code</label>
                          <input type="text" name="code" class="form-control" id="exampleInputName1" placeholder="Currency code" value="{{old('code')}}">
                      </div>

                    <div class="form-group">
                      <label for="exampleSelectGender">Status</label>
                        <select name="status" class="form-control" id="exampleSelectGender">
                          <option value="active" {{old('status') =='active' ? 'selected' : ''}} >Active</option>
                          <option value="inactive" {{old('status') =='inactive' ? 'selected' : ''}} >Inactive</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
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
</script>

<script>
    $(document).ready(function() {
        $('#description').summernote();
    });
</script>

@endsection
