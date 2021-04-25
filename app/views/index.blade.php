@extends('layouts.home')
@section('content')
    <section class="section__container">
        <div class="container category__container">
            <form action="/products" class="filter mb-0">
                <div class="title">
                    <h3>SEARCH PRODUCT</h3>
                </div>
                <div class="filter__inner">
                    {{--                    <div class="dropdown">--}}
                    {{--                        <h6>Select manufacturer</h6>--}}
                    {{--                        <div class="dropdown__container">--}}
                    {{--                            <select name="test2">--}}
                    {{--                                <option value="0">Asus</option>--}}
                    {{--                                <option value="1">Intel</option>--}}
                    {{--                                <option value="2">BMW</option>--}}
                    {{--                                <option value="3">Citroen</option>--}}
                    {{--                                <option value="4">Ford</option>--}}
                    {{--                                <option value="5">Honda</option>--}}
                    {{--                                <option value="6">Jaguar</option>--}}
                    {{--                                <option value="7">Land Rover</option>--}}
                    {{--                                <option value="8">Mercedes</option>--}}
                    {{--                                <option value="9">Mini</option>--}}
                    {{--                                <option value="10">Nissan</option>--}}
                    {{--                                <option value="11">Toyota</option>--}}
                    {{--                                <option value="12">Volvo</option>--}}
                    {{--                            </select>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="dropdown">
                        <h6>Select category</h6>
                        <div class="dropdown__container">
                            <select name="category">
                                <option value="">Select</option>

                                @foreach ($categories as $k=>$category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>

                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="dropdown">
                        <h6>Select price</h6>
                        <div class="dropdown__container">
                            <select name="price">
                                <option value="0">All</option>
                                <option value="1">asd</option>
                                <option value="2">fda</option>
                                <option value="3">asdf</option>
                                <option value="4">dfas</option>
                                <option value="5">Honda</option>
                                <option value="6">Jaguar</option>
                                <option value="7">Land Rover</option>
                                <option value="8">Mercedes</option>
                                <option value="9">Mini</option>
                                <option value="10">Nissan</option>
                                <option value="11">Toyota</option>
                                <option value="12">Volvo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn p-0" type="submit">select</button>
            </form>
            <div class="carousel">
                <a href="#" class="btn btn-primary rounded-pill carousel__more p-0">More</a>
            </div>
        </div>
    </section>
    <scetion class="section__container">
        <div class="container category__list">
            <h4>Categories</h4>
            <div class="list__container">
                @foreach ($categories as $k=>$category)
                    @if($k>=8)
                        @break
                    @endif
                    <a href="/category?_id={{$category->id}}">
                        <div class="list__item">
                            <h6>{{$category->name}}</h6>
                            <img src="http://{{isset($category->images)?$category->images->url:'null' }}">
                        </div>
                    </a>
                @endforeach

            </div>
        </div>
    </scetion>
    <section class="product__container">
        <div>
            <h4>Newest</h4>
            <div class="product__slider-shadow left"></div>
            <div class="product__slider-shadow right"></div>
            <ul class="product__slider" id="slider">
                {{-- <li>--}}
                {{-- <div class="product__item">--}}
                {{-- <a href="#">--}}
                {{-- <div class="product__image">--}}
                {{-- <img src="/app-assets/images/pages/eCommerce/4.png">--}}
                {{-- </div>--}}
                {{-- <p>Apple watch</p>--}}
                {{-- <div class="price__container">--}}
                {{-- <span class="dollar">$</span>--}}
                {{-- <span class="price-details">1175</span>--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- <a class="cart__add" href="">--}}
                {{-- <i class="material-icons">shopping_cart</i>--}}
                {{-- </a>--}}
                {{-- </div>--}}
                {{-- </li>--}}
                @foreach($products as $product)
                    <li>
                        <div class="product__item">
                            <a href="#" class=" product__item-container" style="display: block">
                                <div class="product__image">
                                    <img src="{{isset($product->images)?"http://".$product->images->url:"/app-assets/images/pages/eCommerce/4.png"}}">
                                </div>
                                <p>{{$product->name}}</p>
                                <div class="price__container">
                                    <span class="dollar">$</span>
                                    <span class="price-details">{{$product->price}}</span>
                                </div>
                            </a>
                            <a class="cart__add" href="#" data-id="{{$product->id}}">
                                <i class="material-icons">shopping_cart</i>
                            </a>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </section>
    <section class="section__banner">
        <div class="banner__container row">
            <div class="banner__item col col-md-3 col-6">
                <img src="/app-assets/images/logo/Intel_logo.svg">
            </div>
            <div class="banner__item col col-md-3 col-6">
                <img src="/app-assets/images/logo/Asus_logo.png">
            </div>
            <div class="banner__item col col-md-3 col-6">
                <img src="/app-assets/images/logo/Corsair_logo.png">
            </div>
            <div class="banner__item col col-md-3 col-6">
                <img src="/app-assets/images/logo/Cooler_Master_Logo.png">
            </div>
        </div>
    </section>
@endsection