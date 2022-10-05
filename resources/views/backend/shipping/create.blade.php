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
                    <form action = "{{route('shipping.store')}}" method="post">
                        @csrf
            <div class="card-body">
                  <h4 class="card-title">Add Shipping Method</h4>
                  <p class="card-description">
                    Create a shipping method
                  </p>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputName1">Shipping Address</label>
                      <input type="text" name="shipping_address" class="form-control" id="exampleInputName1" placeholder="Shipping Address" value="{{old('shipping_address')}}">
                    </div>

                    <div class="form-group">
                      <label for="exampleTextarea1">Delivery Time</label>
                        <input type="text" name="delivery_time" class="form-control" id="exampleInputName1" placeholder="Delivery Time" value="{{old('delivery_time')}}">
                    </div>

                      <div class="form-group">
                          <label for="exampleTextarea1">Delivery Charge</label>
                          <input type="number" step="any" name="delivery_charge" class="form-control" id="exampleInputName1" placeholder="Delivery Charge" value="{{old('delivery_charge')}}">
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
