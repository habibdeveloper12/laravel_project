@php
    $setting = \App\Models\Settings::first();
@endphp
            <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <a class="navbar-brand brand-logo" href="{{route('admin')}}"><img src="{{asset($setting->logo)}}" alt="gg-trade logo"/></a>
          <a class="navbar-brand brand-logo-mini" href="{{route('admin')}}"><img src="{{asset($setting->favicon)}}"  width="30px" height="30px" alt="gg-trade logo"/></a>
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-sort-variant"></span>
          </button>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item dropdown mr-1">
                @php
                    Helper::currency_load();
                    $currency_code = session('currency_code');
                    $currency_symbol = session('currency_symbol');

                    if($currency_symbol == ""){
                            $system_default_currency_info = session('system_default_currency_info');
                            $currency_symbol = $system_default_currency_info->symbol;
                            $currency_code = $system_default_currency_info->code;
                    }
                @endphp
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="currency" href="#" data-toggle="dropdown">
                    {{$currency_symbol}} {{\Illuminate\Support\Str::upper($currency_code)}} &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="currency">
                    @foreach(\App\Models\Currency::where('status', 'active')->get() as $currency)
                        <a class="dropdown-item" href="javascript:;" onclick="currency_change('{{$currency['code']}}')"> {{$currency->symbol}} {{\Illuminate\Support\Str::upper($currency->code)}}</a>
                    @endforeach
                </div>
            </li>
            @php
                $notify= 0;
                    $all = [];
                    $all[] = $unchecked_dispute_notify = \App\Models\AdminNotification::where(['status' => 'active', 'is_read' => '0'])->orderBy('created_at')->get();
                    $all[] =$unchecked_blacklist_violation = \App\Models\reportBlacklist::where(['status' => 'active', 'is_read' => '0'])->orderBy('created_at')->get();
                    $all[] = $unchecked_withdrawal_request = \App\Models\WithdrawalRequest::where(['status' => 'active', 'is_read' => '0'])->orderBy('created_at')->get();
                    $all[] = $unchecked_new_order = \App\Models\Order::where(['is_seen_admin' => 0])->orderBy('created_at')->get();

                    if(count($all[0]) > 0 || count($all[1]) > 0 || count($all[2]) > 0  || count($all[3]) > 0){
                            $notify = 1;
                    }
            @endphp

            <li class="nav-item dropdown mr-4">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell mx-0"></i>
                @if($notify == 1)
              <span class="count"></span>
                @endif
            </a>



                <style>
                    .dropdown-menu-right{
                        max-height: 500px;
                        min-width: 250px;
                        overflow-y: scroll;
                    }
                </style>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
                @if($notify == 1)
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>

                @foreach($all as $key => $value)

                @if(count($value) > 0)
                        @foreach($value as $details)
                            @if($key == 0)
                                <a class="dropdown-item" href="{{route('dispute')}}">
                                    <div class="item-thumbnail">
                                        <div class="item-icon bg-info">
                                            <i class="mdi mdi-information mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <h6 class="font-weight-normal">Dispute Created</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($details->created_at)->diffForHumans()}}
                                        </p>
                                    </div>
                                </a>

                            @elseif($key == 1)
                            <a class="dropdown-item" href="{{route('rule')}}">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-danger">
                                        <i class="mdi mdi-information mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">Blacklisted word detected</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        {{ \Carbon\Carbon::parse($details->created_at)->diffForHumans()}}
                                    </p>
                                </div>
                            </a>

                            @elseif($key == 2)
                                <a class="dropdown-item" href="{{route('withdraw')}}">
                                    <div class="item-thumbnail">
                                        <div class="item-icon bg-primary">
                                            <i class="mdi mdi-cash mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <h6 class="font-weight-normal">Withdrawal Request</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($details->created_at)->diffForHumans()}}
                                        </p>
                                    </div>
                                </a>
                            @elseif($key == 3)
                                <a class="dropdown-item" href="{{route('order.index')}}">
                                    <div class="item-thumbnail">
                                        <div class="item-icon bg-warning">
                                            <i class="mdi mdi-checkbox-marked-circle-outline mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <h6 class="font-weight-normal">New Order</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($details->created_at)->diffForHumans()}}
                                        </p>
                                    </div>
                                </a>
                            @endif
                        @endforeach

                    @else

                    @endif
                @endforeach
                @else

                    <p class="mb-0 font-weight-normal float-left dropdown-header">No notifications</p>
                @endif
            </div>
          </li>

          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="{{Helper::userDefaultImage()}}" alt="profile"/>
                <span class="nav-profile-name">{{ucfirst(auth('admin')->user()->full_name)}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="mdi mdi-settings text-primary"></i>
                Settings
              </a>
              <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="mdi mdi-logout text-primary"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
