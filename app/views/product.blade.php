@extends('layouts.home')
@section('content')
{{--<ul>--}}
{{--	@foreach($products as $product)--}}
{{--        <li>{{$product->name}}</li>--}}

{{--	@endforeach--}}
{{--</ul>--}}
{{--<section class="section__container">--}}
{{--	<div class="container">--}}
{{--		asd--}}
{{--	</div>--}}
{{--</section>--}}
<section id="ecommerce-products" class="">
    <div class="container row" style="display: flex">
        <div class="col-sm-12">
            <div class="ecommerce-header-items">
                <div class="result-toggler">
                    <div class="search-results">
                        {{$total??0}} results found
                    </div>
                </div>
                <div class="view-options">
                    <div class="select">
                        <button
                                class="btn dropdown-toggle dropdown-select"
                                type="button"
                                id="dropdownMenu2"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                            Filter
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <a class="dropdown-item" href="?sort_by[price]=asc" type="button">Lowest</a>
                            <a class="dropdown-item" href="?sort_by[price]=desc" type="button">Highest</a>
                        </div>
                    </div>
{{--                    <select class="price-options form-control select2-hidden-accessible" id="ecommerce-price-options" data-select2-id="ecommerce-price-options" tabindex="-1" aria-hidden="true">--}}
{{--                        <option selected="" data-select2-id="2">Featured</option>--}}
{{--                        <option value="1">Lowest</option>--}}
{{--                        <option value="2">Highest</option>--}}
{{--                    </select>--}}
{{--                    <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-ecommerce-price-options-container"><span class="select2-selection__rendered" id="select2-ecommerce-price-options-container" role="textbox" aria-readonly="true" title="Featured">Featured</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>--}}
{{--                    <div class="view-btn-option">--}}
{{--                        <button class="btn btn-white view-btn grid-view-btn active waves-effect waves-light">--}}
{{--                            <i class="feather icon-grid"></i>--}}
{{--                        </button>--}}
{{--                        <button class="btn btn-white list-view-btn view-btn waves-effect waves-light">--}}
{{--                            <i class="feather icon-list"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
	<div class="grid-view container">
        @foreach($products as $product)
        <div class="card ecommerce-card">
			<div class="card-content">
				<div class="item-img text-center">
					<a href="/products/{{$product->id}}">
						<img class="img-fluid" src="{{isset($product->images)?'http://'.$product->images->url:'../../../app-assets/images/pages/eCommerce/1.png'}}" alt="img-placeholder"></a>
				</div>
				<div class="card-body">
					<div class="item-wrapper">
						<div class="item-rating">
							<!-- <div class="badge badge-primary badge-md">
								<span>4</span> <i class="feather icon-star"></i>
							</div> -->
						</div>
						<div>
							<h6 class="item-price mb-0">
								${{$product->price}}
							</h6>
						</div>
					</div>
					<div class="item-name">
						<a href="/products/{{$product->id}}">{{$product->name}}</a>
{{--						<p class="item-company">By <span class="company-name">Google</span></p>--}}
					</div>
					<div>
						<p class="item-description">
							{{$product->description??'Enjoy smart access to videos, games and apps with this Amazon Fire TV stick. Its Alexa voice remote lets you
							deliver hands-free commands when you want to watch television or engage with other applications. With a
							quad-core processor, 1GB internal memory and 8GB of storage, this portable Amazon Fire TV stick works fast
							for buffer-free streaming.'}}
						</p>
					</div>
				</div>
				<div class="item-options text-center">
					<div class="item-wrapper">
						<div class="item-rating">
							<div class="badge badge-primary badge-md">
								<span>4</span> <i class="feather icon-star"></i>
							</div>
						</div>
						<div class="item-cost">
							<h6 class="item-price">
								$39.99
							</h6>
						</div>
					</div>
{{--					<div class="wishlist">--}}
{{--						<i class="fa fa-heart-o"></i> <span>Wishlist</span>--}}
{{--					</div>--}}
					<div class="cart" data-id="{{$product->id}}">
						<i class="feather icon-shopping-cart"></i>
                        <span class="add-to-cart">Add to cart</span>
{{--                        <a href="app-ecommerce-checkout.html" class="view-in-cart d-none">View In Cart</a>--}}
					</div>
				</div>
			</div>
		</div>
        @endforeach
	</div>
</section>
@endsection