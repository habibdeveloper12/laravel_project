@extends ('support.layouts.master')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
        .ord{
            margin-top: 100px ;
            margin-bottom: 20px ;
            padding: 25px;
        }
        .form-control{
            margin-bottom: 20px;
            margin-top: 0px;
        }
        label{
            margin: 0;
            padding: 5px 0;
        }

        @media only screen and (max-width: 991px) {
            .ord{
                margin-top: 90px !important;
            }
        }
    </style>

    <div class="container ord">

        <div class="row">
            <div class=" main-content-area">
                <div class="wrap-contacts ">
                    <div class="col-lg-8 col-sm-6 col-md-6 col-xs-12">
                        <div class="contact-box contact-form">
                            <h2 class="box-title">Submit a request</h2>
                            <form action="{{route('contact.us')}}" method="post" name="frm-contact">

                                @csrf
                                <label for="name">Name<span>*</span></label>
                                <input type="text" class="form-control" @auth value="{{Auth::user()->username}}" @endauth id="name" name="full_name" >
                                @error('full_name')
                                <p class="text-danger"><strong>{{$message}}</strong></p>
                                @enderror

                                <label for="email">Email<span>*</span></label>
                                <input type="text" class="form-control" @auth value="{{Auth::user()->email}}" @endauth id="email" name="email" >
                                @error('email')
                                <p class="text-danger"><strong>{{$message}}</strong></p>
                                @enderror

                                <label for="phone">Subject</label>
                                <input type="text" class="form-control" value="" id="email" name="subject" >
                                @error('subject')
                                <p class="text-danger"><strong>{{$message}}</strong></p>
                                @enderror

                                <label for="phone">Order Number</label>
                                <input type="text" class="form-control" value="" id="email" name="order_number" style="margin-bottom: 0">
                                <p style="color: #c5c4c4">If your request is not related to an order, please put a dash</p>
                                @error('order_number')
                                <p class="text-danger"><strong>{{$message}}</strong></p>
                                @enderror

                                <label for="comment">Comment</label>
                                <textarea name="comment" class="form-control" rows="7" id="comment" style="margin-bottom: 0"></textarea>
                                <p  style="color: #c5c4c4">Please describe everything in as much detail as possible because this will help us to solve the problem faster</p>
                                @error('comment')
                                <p class="text-danger"><strong>{{$message}}</strong></p>
                                @enderror

                                <button type="submit" class="btn btn-success mt-4" style="width: 100%" >Submit</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div><!--end main products area-->

        </div><!--end row-->

    </div><!--end container-->

@endsection

@section('scripts')


@endsection

