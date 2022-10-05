@php
    $setting = \App\Models\Settings::first();
@endphp

<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 text-center">
                             <span class="copyright">
                                &copy; <script>document.write(new Date().getFullYear());</script> GG-Trade
                            </span>
                        </div>
                        <div class="col-md-6 col-sm-12 policy">
                            <a class="p-link" href="{{route('privacy.policy')}}"> Privacy Policy </a>
                            <a class="p-link" href="{{route('cookie.policy')}}"> Cookies Policy </a>
                            <a class="p-link" target="_blank" href="{{route('support')}}"> Submit a request </a>
                        </div>
						<div class="col-md-4 col-sm-12 text-center favi">
                           <a href="{{$setting->facebook_url}}" target="_blank"> <i class="fa fa-facebook"></i></a>
                            <a href="{{$setting->twitter_url}}" target="_blank">  <i class="fa fa-twitter"></i></a>
                            <a href="{{$setting->instagram_url}}" target="_blank"> <i class="fa fa-instagram"></i></a>
                            <a href="{{$setting->youtube_url}}" target="_blank"> <i class="fa fa-youtube"></i></a>
                            <a href="{{$setting->tiktok_url}}" target="_blank"> <i class="fa-brands fa-tiktok"></i> </a>
                        </div>

					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->

