<footer class="footer">
	<div class="footer-area" style="background-color: #795548;">
		<div class="container">
			<div class="row section_gap">
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="single-footer-widget tp_widgets">
						<h4 class="footer_title large_title">Our Mission</h4>
						<p style="color: #e6e6e6;">
							Kami berkomitmen untuk menyajikan kopi berkualitas tinggi dan memberikan pengalaman terbaik bagi pelanggan kami.
					  </p>
					  <p style="color: #e6e6e6;">
							Dengan platform ini, kami ingin memudahkan Anda dalam menikmati kopi pilihan langsung di rumah Anda, 
							sambil memberikan pengalaman belanja yang nyaman dan menyenangkan.
					  </p>					  
					</div>
				</div>
				<div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
					<div class="single-footer-widget tp_widgets">
						<h4 class="footer_title">Quick Links</h4>
						<ul class="list">
							<li><a href="/" style="color: #e6e6e6;">Home</a></li>
							<li><a href="/shop" style="color: #e6e6e6;">Shop</a></li>
							<li><a href="/cart" style="color: #e6e6e6;">Shopping Cart</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-sm-6">
					<div class="single-footer-widget instafeed">
						<h4 class="footer_title">Gallery</h4>
						<ul class="list instafeed d-flex flex-wrap">
							@foreach ($products->take(6) as $product)
							<li><img src="{{ asset('storage/'. $product->photo_1) }}" style="height:75px; object-fit:cover;"
									width="75" alt=""></li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
					<div class="single-footer-widget tp_widgets">
						<h4 class="footer_title">Contact Us</h4>
						<div class="ml-40">
							<p class="sm-head">
								<span class="fa fa-location-arrow"></span>
								Head Office
							</p>
							<p style="color: #e6e6e6;">{{$outlet->address}}</p>

							<p class="sm-head">
								<span class="fa fa-phone"></span>
								Phone Number
							</p>
							<p style="color: #e6e6e6;">
								{{$outlet->phone}}
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer-bottom" style="background-color: #795548;">
		<div class="container">
			<div class="row d-flex">
				<p class="col-lg-12 footer-text text-center">
					Created with &hearts; by Achmad Syahrian &copy; 2025.</p>
			</div>
		</div>
	</div>
</footer>