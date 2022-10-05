
        <ul class="nav">


          <li class="nav-item">
            <a class="nav-link" href="{{route('admin')}}">
              <i class="mdi mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#brand" aria-expanded="false" aria-controls="user">
                    <i class="mdi mdi-book menu-icon"></i>
                    <span class="menu-title">Game Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="brand">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('brand.index')}}"> All Game </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('brand.create')}}"> Add Game </a></li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#cat" aria-expanded="false" aria-controls="cat">
                    <i class="mdi mdi-arrange-bring-forward menu-icon"></i>
                    <span class="menu-title">Category Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="cat">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('category.index')}}">All Category</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('category.create')}}">Add Category</a></li>
                    </ul>
                </div>
            </li>



            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#product" aria-expanded="false" aria-controls="user">
                    <i class="mdi mdi-buffer menu-icon"></i>
                    <span class="menu-title">Product Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="product">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('product.index')}}"> All Product </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('product.create')}}"> Add Product </a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#user" aria-expanded="false" aria-controls="user">
                    <i class="mdi mdi-account menu-icon"></i>
                    <span class="menu-title">Customer Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="user">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('user.index')}}"> All Customer </a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('dispute')}}">
                    <i class="mdi mdi-poll menu-icon"></i>
                    <span class="menu-title">Settle Dispute</span>
                </a>
            </li>


            <li class="nav-item">
            <a class="nav-link" href="{{route('order.index')}}">
              <i class="mdi mdi-chart-pie menu-icon"></i>
              <span class="menu-title">Order Management</span>
            </a>
          </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#currency" aria-expanded="false" aria-controls="user">
                    <i class="mdi mdi-currency-eur menu-icon"></i>
                    <span class="menu-title">Currency Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="currency">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('currency.index')}}"> All Currencies </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('currency.create')}}"> Add Currency </a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('settings')}}">
                    <i class="mdi mdi-settings menu-icon"></i>
                    <span class="menu-title">Settings</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#fund" aria-expanded="false" aria-controls="user">
                    <i class="mdi mdi-settings menu-icon"></i>
                    <span class="menu-title">Funds Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="fund">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('all.transaction')}}">All Transactions </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('fund.pending')}}"> Pending Funds </a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#payment" aria-expanded="false" aria-controls="user">
                    <i class="mdi mdi-settings menu-icon"></i>
                    <span class="menu-title">Payment Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="payment">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('settings.payment')}}"> Payment Gateway </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('settings.withdraw')}}"> Withdraw details </a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#seller" aria-expanded="false" aria-controls="user">
                    <i class="mdi mdi-bus menu-icon"></i>
                    <span class="menu-title">Seller Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="seller">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('seller.index')}}"> All Sellers </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('withdraw')}}"> Withdrawal Requests </a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#rule" aria-expanded="false" aria-controls="user">
                    <i class="mdi mdi-eye menu-icon"></i>
                    <span class="menu-title">Rule violators</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="rule">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('add.word')}}"> All Blacklisted word </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('rule')}}"> Detected Words </a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('announcement')}}">
                    <i class="mdi mdi-web menu-icon"></i>
                    <span class="menu-title">Announcement</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-logout menu-icon"></i>
                    <span class="menu-title">Logout</span>
                </a>
            </li>


        </ul>
