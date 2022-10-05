@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


@section('content')

    <div class="container ord" style="  background-color: rgba(239,239,239,0.72);
        border-radius: 5px;">
        <style>
            .ord{
                margin: 20px auto 50px auto;
                min-height: 800px;
            }
            @media only screen and (max-width: 991px) {
                .ord{
                    margin-top: 20px !important;
                }
                h3{
                    font-size: 14px;
                }
            }
            .dot{
                font-size: 30px;
                color: #8a8888;
            }
        </style>
        @php
            $settings = \App\Models\Settings::first();
        @endphp

        <h3 style=" padding: 10px"> Balance &nbsp;  {{number_format($balance,2)}} <i class="fa fa-dollar"></i>   &nbsp; <i class="dot">-</i> &nbsp; {{number_format(round($balance * $exchange_rate_pol, 2),2)}} zł &nbsp; <i class="dot">-</i> &nbsp; {{number_format(round($balance * $exchange_rate_eur, 2),2)}} <i class="fa fa-euro"></i> </h3>
        <hr/>
        <div class="row" style="background-color: transparent; padding: 20px 50px; margin-bottom: 20px; border-radius: 5px">

            <p style="font-size: 16px">    <i class="fa fa-warning"></i> Withdrawal of funds costs {{$settings->withdraw_fee}}% of any withdrawal amount</p>
            <div class=" col-12"></div>

            @if($balance< $settings->withdraw_min)
                <p style="color: #d53f3f"> You cannot withdraw now, Minimum withdrawal amount is {{Helper::currency_converter($settings->withdraw_min)}}</p>
            @else
            <button class="btn btn-primary " type="button" data-toggle="modal" data-target="#exampleModal"> Withdraw Funds</button>
            @endif
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">WITHDRAW</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('withdraw.request')}}" method="post">
@csrf
                                <label class="form-label">WITHDRAWAL METHOD </label>

                                <select class="form-control form-control-lg mb-4" id="option" name="method">
                                    <option >Select an option</option>
                                    <option value="paypal"> Paypal</option>
                                    <option value="bank_card"> Bank Card</option>
                                </select>

                                <div class="bank">
                                    <label class="form-label">CARD NUMBER </label>
                                    <input type="text" class="form-control mb-4" name="card" placeholder="Enter your card number" >
                                </div>


                                <div class="paypal">
                                    <label class="form-label">PayPal Email</label>
                                    <input type="text" class="form-control mb-4" name="paypal_email" placeholder="Enter your PayPal email" >
                                </div>


                                <script>
                                    $('.bank').hide();
                                    $('.paypal').hide();
                                    $('select').on('change', function() {
                                        let option = this.value;

                                        if(option == 'paypal'){
                                            $('.bank').hide();
                                            $('.bank').val(0) ;
                                            $('.paypal').show();

                                        }else {
                                            $('.bank').show();
                                            $('.paypal').hide();
                                            $('.paypal').val(0);

                                        }


                                    });
                                </script>
                                <label class="form-label">AMOUNT ($) </label>
                                <input id="amount" type="number" class="form-control " step="0.01" name="amount" min="{{$settings->withdraw_min}}" max="{{$balance}}" value="{{$settings->withdraw_min}}" required>
                                <p style="color: #9f9c9c" class="mb-4">Withdrawal cost: {{$settings->withdraw_fee}}% commission, min. {{Helper::currency_converter($settings->withdraw_min)}}</p>

                                <label class="form-label">TO BE RECEIVED ($) </label>
                                <input id="receive" type="text" class="form-control mb-4" name="to_receive" value="" disabled>

                                @if($balance < 1)
                                    <p class="btn mb-5" style="width: 100%; color: red">You do not have any fund to withdraw!</p>
                                @else
                                    <button type="submit" class="btn btn-primary mb-5" style="width: 100%">Submit Request</button>
                                @endif
                            </form>


                            <script>
                                let input = document.getElementById("amount");
                                let receive = document.getElementById("receive");

                                receive.value = {{$settings->withdraw_min}} - {{$settings->withdraw_min}} * ({{$settings->withdraw_fee}}/100);

                                input.addEventListener("click", ()=> {
                                    error.innerText = '';
                                })


                                input.addEventListener("change", ()=>{

                                    let inputImage = input.value;
                                    let re =input.value - (input.value * ({{$settings->withdraw_fee}}/100));
                                    receive.value = re.toFixed(2);
                                })
                            </script>

                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div class="row" style="padding: 0 30px">

            <p style="font-size: 16px;margin-bottom: 20px;"> This is a summary of all your financial transaction, including fund withdrawal.</p>

        </div>



        <div class="row" style="margin-bottom: 80px; padding: 0 30px">

            <div class="table-responsive">
                <table class="table " id="sortTable" style="border-radius: 5px">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if(!count($logs)>0)
                        <style>
                            #footer{
                                position: fixed;
                            }
                        </style>
                    @else
                        @foreach($logs as $log)
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($log->created_at)->format('M, d Y- g:i A ')}}</td>

                                    <td>
                                                <span class="badge
                                                 @if($log->status == 'pending')
                                                    bg-info
                                                @elseif($log->status == 'processing')
                                                    bg-primary
                                                @elseif($log->status == 'declined')
                                                    bg-danger
                                                @elseif($log->status == 'approved' || $log->status == 'disbursed')
                                                    bg-success
                                                @else
                                                    bg-secondary
                                                @endif
                                                    "> {{ucfirst($log->status)}}
                                                </span>
                                    </td>
                                    <td>{{$log->description}}</td>
                                    @if($log->type === 'credit')<td class="text-success">
                                            +
                                        @else<td class="text-danger">
                                          -
                                        @endif
                                        {{Helper::currency_converter($log->amount)}} </td>

                                    <td>
                                        <a href="javascript:void(0)" data-target="#productID{{$log->id}}" class="mr-1 mb-1 float-left btn btn-sm btn-outline-secondary" data-toggle="modal" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                    </td>

                                </tr>
                                <div class="modal fade" id="productID{{$log->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLongTitle">Transaction Details</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>Description: </strong>
                                                <p>{!! html_entity_decode($log->description) !!}</p>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Amount: </strong>
                                                        <p>{{Helper::currency_converter($log->amount)}}</p>
                                                    </div>

                                                    @if($log->type == 'withdraw')
                                                    <div class="col-md-6">
                                                        <strong>Amount to receive: </strong>
                                                        <p>{{Helper::currency_converter($log->amount_to_receive)}} @ {{\App\Models\Settings::first()->withdraw_fee}}%</p>
                                                    </div>
                                                    @endif

                                                </div>
                                                @if($log->type == 'withdraw')

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <strong>Withdrawal Method: </strong>
                                                        @if($log->method == 'bank_card')
                                                            <p>Bank Card</p>

                                                        @else
                                                            <p>{{ucfirst($log->method)}}</p>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <strong>Withdrawal Info: </strong>
                                                        <p>{{ucfirst($log->method_info)}}</p>
                                                    </div>

                                                </div>

                                                @endif

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Status: </strong>
                                                        <p>{{ucfirst($log->status)}}</p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <strong>Date: </strong>
                                                        <p>{{\Carbon\Carbon::parse($log->created_at)->format('M, d Y- g:i A ')}}</p>
                                                    </div>

                                                </div>





                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        @endforeach




                    @endif
                    </tbody>
                </table>
            </div>

        </div>


    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.js"> </script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" defer></script>


<script>
    $(document).ready(function() {
        $("#sortTable").DataTable()({
            order: [[0, 'desc']],
        });
    });
</script>
