@extends('layouts.main')
@section('container')
    <section class="blog-banner-area" id="category">
        <div class="container h-100">
            <div class="blog-banner">
                <div class="text-center">
                    <h1>PRODUCT CHECKOUT</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="checkout_area section-margin--small">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-7">
                        <h3>Billing Details</h3>
                        <form class="row contact_form" action="{{ route('transaction.add') }}" enctype="multipart/form-data"
                            method="POST" novalidate="novalidate">
                            @csrf
                            <label class="form-label">Upload payment proof photo</label>
                            <div class="custom-file mb-3 form-group">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                    name="image" id="validatedCustomFile">
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                <div class="invalid-feedback">
                                    @error('image')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            {{-- <label for="provinsi">Provinsi</label>
                            <select id="provinsi" name="provinsi" class="custom-select">
                                <option selected>Pilih Provinsi</option>
                                @foreach ($provinces as $provinsi)
                                    <option value="{{ $provinsi->name }}">{{ $provinsi->name }}</option>
                                @endforeach
                            </select>
                            <label for="kabupaten" class="mt-3">Kabupaten/Kota</label>
                            <select id="kabupaten" name="kabupaten" class="custom-select">
                                <option selected>Pilih Kabupaten/Kota</option>
                            </select> --}}
                            <label for="kecamatan" class="mt-3">Kecamatan</label>
                            <select name="kecamatan" class="custom-select">
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->name }}">{{ $kecamatan->name }}</option>
                                @endforeach
                            </select>
                            <label for="lokasi" class="mt-3">Titik Lokasi</label>
                            <div id="map" style="height: 300px; width: 100%;"></div>
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">

                            <label class="form-label mt-3" for="validationTextarea">Alamat Lengkap</label>
                            <textarea class="form-control" id="validationTextarea" name="alamat_lengkap" placeholder="Alamat Lengkap">{{ old('description') }}</textarea>
                    </div>
                    <script>
                        var map = L.map('map').setView([3.5952, 98.6722], 12); // Set awal (Indonesia)
                    
                        // Tambahkan peta dari OpenStreetMap
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors'
                        }).addTo(map);
                    
                        var marker; // Simpan marker
                    
                        // Event ketika user mengklik peta
                        map.on('click', function(e) {
                            var lat = e.latlng.lat;
                            var lng = e.latlng.lng;
                    
                            // Hapus marker lama (jika ada)
                            if (marker) {
                                map.removeLayer(marker);
                            }
                    
                            // Tambahkan marker baru
                            marker = L.marker([lat, lng]).addTo(map)
                                .bindPopup("Latitude: " + lat + "<br>Longitude: " + lng)
                                .openPopup();
                    
                            // Isi input hidden dengan koordinat
                            document.getElementById('latitude').value = lat;
                            document.getElementById('longitude').value = lng;
                        });
                    </script>
                    
                    <div class="col-lg-5">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <ul class="list">
                                <li>
                                    <a>
                                        <h4>Product <span>Total</span></h4>
                                    </a>
                                </li>
                                @php
                                    use Illuminate\Support\Str;
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($productsCart as $product)
                                    <li>
                                        <a>{{ Str::limit($product->name, 15) }} <span class="middle">x
                                                {{ $cart[$product->id]['quantity'] }}</span> <span class="last">Rp.
                                                {{ number_format($product->harga * $cart[$product->id]['quantity'], 2, ',', '.') }}</span></a>
                                    </li>
                                    @php
                                        $subtotal = $product->harga * $cart[$product->id]['quantity'];
                                        $totalPrice += $subtotal;
                                    @endphp
                                @endforeach
                            </ul>
                            <ul class="list list_2">
                                <li><a>Total <span>Rp. {{ number_format($totalPrice, 2, ',', '.') }}</span></a></li>
                            </ul>
                            <div class="payment_item mt-4">
                                <img src="img/payment_method.png" width="400px" alt="">
                                @error('payment_method')
                                    <p class="text-danger text-center">{{ $message }}</p>
                                @enderror
                                <div class="radion_btn">
                                    <input type="radio" id="f-option5" name="payment_method" value="bank_transfer">
                                    <label class="@error('payment_method') text-danger @enderror" for="f-option5">
                                        @error('payment_method')
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        @enderror Bank
                                        Transfer
                                    </label>
                                    <div class="check"></div>
                                </div>
                                <p>
                                    BNI : 012xxxxxxx <br>
                                    BRI : 012xxxxxxx <br>
                                    BCA : 012xxxxxxx <br>
                                </p>
                            </div>
                            <div class="payment_item active">
                                <div class="radion_btn">
                                    <input type="radio" id="f-option6" name="payment_method" value="e_wallet">
                                    <label class="@error('payment_method') text-danger @enderror" for="f-option6">
                                        @error('payment_method')
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        @enderror E-Wallet
                                    </label>
                                    <div class="check"></div>
                                </div>
                                <p>
                                    DANA : 012xxxxxxx <br>
                                    OVO : 012xxxxxxx <br>
                                    GOPAY : 012xxxxxxx <br>
                                </p>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="button bg-warning border-0 button-paypal" href="#"><i
                                        class="fa-regular fa-credit-card"></i> Buy Now</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
