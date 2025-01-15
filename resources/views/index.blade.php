@extends('layouts.main')
@section('container')

    @if (session()->has('success'))
        <div class="alert alert-success text-center mt-4" role="alert">
            {{ session('success') }} <i class="fa-solid fa-circle-check"></i>
        </div>
    @endif
    <section class="hero-banner">
        <div class="container">
            <div class="row no-gutters align-items-center pt-60px">
                <div class="col-5 d-none d-sm-block">
                    <div class="hero-banner__img">
                        {{-- <img class="img-fluid" src="img/home/hero-banner.png" alt=""> --}}
                        <img class="img-fluid" src="{{ asset('img/home/hero-coffee.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-sm-7 col-lg-6 offset-lg-1 pl-4 pl-md-5 pl-lg-0">
                    <div class="hero-banner__content">
                        <h4>Welcome to {{ $outlet->name }}</h4>
                        <h1>Explore Our Premium Coffee</h1>
                        <p>Welcome to our official coffee shop! Indulge in the rich aromas and flavors of our premium coffee
                            blends.
                            From freshly roasted beans to handcrafted beverages, we’re here to satisfy your coffee cravings.
                            Discover your perfect cup today and experience the art of coffee like never before.</p>

                        <a class="button button-hero" href="/shop">Browse Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ Hero banner start =================-->

    <!--================ Hero Carousel start =================-->
    @if ($products->count())
        <section class="section-margin mt-0">
            <div class="owl-carousel owl-theme hero-carousel">
                @foreach ($products as $product)
                    <div class="hero-carousel__slide">
                        <img src="{{ asset('storage/' . $product->photo_1) }}" style="height: 380px; object-fit:cover;"
                            alt="" class="img-fluid">
                        <a href="/shop/product-{{ $product->id }}" class="hero-carousel__slideOverlay">
                            <h3>{{ $product->name }}</h3>
                            <p>Rp. {{ number_format($product->harga, 2, ',', '.') }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!--================ Hero Carousel end =================-->

    <!-- ================ popular product section start ================= -->
    <section class="section-margin calc-60px">
        <div class="container">
            <div class="section-intro pb-60px">
                <p>Popular Item in the store</p>
                <h2>Popular <span class="section-intro__style">Product</span></h2>
            </div>
            <div class="row">
                @if ($popularProducts->count())
                    @foreach ($popularProducts->take(4) as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card text-center card-product">
                                <div class="card-product__img">
                                    <img class="card-img" src="{{ asset('storage/' . $product->photo_1) }}"
                                        style="height: 255px; object-fit:cover;" alt="">
                                    <ul class="card-product__imgOverlay">
                                        <li>
                                            <p class="card-product__price text-dark">Rp.
                                                {{ number_format($product->harga, 2, ',', '.') }}</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    @if ($product->category_id == null)
                                        <p>No Category</p>
                                    @else
                                        <p>{{ $product->category->name }}</p>
                                    @endif
                                    <h4 class="card-product__title"><a
                                            href="/shop/product-{{ $product->id }}">{{ $product->name }}</a></h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        @else
            <div class="container">
                <p class="text-center fs-4">No Product Found.</p>
            </div>
            @endif
        </div>
    </section>
    <!-- ================ popular product section end ================= -->

    <!-- ================ product section start ================= -->
    <section class="section-margin calc-60px">
        <div class="container">
            <div class="section-intro pb-60px">
                {{-- <p>Popular Item in the market</p> --}}
                <h2>New <span class="section-intro__style">Product</span></h2>
            </div>
            <div class="row">
                @if ($products->count())
                    @foreach ($products->take(8) as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card text-center card-product">
                                <div class="card-product__img">
                                    <img class="card-img" src="{{ asset('storage/' . $product->photo_1) }}"
                                        style="height: 255px; object-fit:cover;" alt="">
                                    <ul class="card-product__imgOverlay">
                                        <li>
                                            <p class="card-product__price text-dark">Rp.
                                                {{ number_format($product->harga, 2, ',', '.') }}</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    @if ($product->category_id == null)
                                        <p>No Category</p>
                                    @else
                                        <p>{{ $product->category->name }}</p>
                                    @endif
                                    <h4 class="card-product__title"><a
                                            href="/shop/product-{{ $product->id }}">{{ $product->name }}</a></h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="/shop" class="button button-postComment text-center button--active">See More</a>
                </div>
            </div>
        @else
            <div class="container">
                <p class="text-center fs-4">No Product Found.</p>
            </div>
            @endif
        </div>
    </section>
    <!-- ================ product section end ================= -->


    <!-- ================ Subscribe section start ================= -->
    <section class="subscribe-position">
        <div class="container">
            <div class="subscribe text-center">
                <h3 class="subscribe__title">Terima kasih telah berkunjung</h3>
                <p>Kenyamanan dan Kepuasan Belanja dalam Genggaman Anda!</p>
            </div>
        </div>
    </section>

@endsection
