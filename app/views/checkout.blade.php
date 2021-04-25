@extends('layouts.home')
@section('content')
    <section class="section__container">
        <div class="container">
            <h1>
                CHECK OUT
            </h1>
            @if(empty($carts))
                <h6>No Product</h6>
            @else
                <form method="post" action="/checkout" id="checkout">
                    <h6><i class="step-icon step feather icon-shopping-cart"></i>Cart</h6>
                    <fieldset>
                        <section id="place-order" class="list-view product-checkout">
                            <div class="checkout-items">
                                @foreach($carts as $key=>$product)
                                    <div class="card ecommerce-card">
                                        <div class="card-content">
                                            <div class="item-img text-center">
                                                <a href="app-ecommerce-details.html">
                                                    <img src="{{isset($product['image'])?"http://".$product['image']:"/app-assets/images/pages/eCommerce/9.png"}}"
                                                         alt="img-placeholder">
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <div class="item-name">
                                                    <a href="app-ecommerce-details.html">{{$product['name']}}</a>
                                                    {{--                                    <span></span>--}}
                                                    {{--                                    <p class="item-company">By <span class="company-name">Amazon</span></p>--}}
                                                    <p class="stock-status-in">In Stock</p>
                                                </div>
                                                <div class="item-quantity">
                                                    <p class="quantity-title">Quantity</p>
                                                    <div class="input-group quantity-counter-wrapper">
                                                        <input type="text" class="quantity-counter" value="{{$product['count']}}" max="10"
                                                               min="1"
                                                               data-price="{{$product['price']}}">
                                                    </div>
                                                </div>
                                                {{--                                <p class="delivery-date">Delivery by, Wed Apr 25</p>--}}
                                                {{--                                <p class="offers">17% off 4 offers Available</p>--}}
                                            </div>
                                            <div class="item-options text-center">
                                                <div class="item-wrapper">
                                                    {{--                                    <div class="item-rating">--}}
                                                    {{--                                        <div class="badge badge-primary badge-md">--}}
                                                    {{--                                            4 <i class="feather icon-star ml-25"></i>--}}
                                                    {{--                                        </div>--}}
                                                    {{--                                    </div>--}}
                                                    <div class="item-cost">
                                                        <h6 class="item-price">
                                                            ${{$product['price']}}
                                                        </h6>
                                                        {{--                                        <p class="shipping">--}}
                                                        {{--                                            <i class="feather icon-shopping-cart"></i> Free Shipping--}}
                                                        {{--                                        </p>--}}
                                                    </div>
                                                </div>
                                                {{--                                <div class="wishlist remove-wishlist">--}}
                                                {{--                                    <i class="feather icon-x align-middle"></i> Remove--}}
                                                {{--                                </div>--}}
                                                <div class="remove-wishlist" data-id="{{$product['id']}}">
                                                    <i class="feather icon-x align-middle"></i> Remove
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="checkout-options">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="price-details">
                                                <p>Price Details</p>
                                            </div>
                                            <div class="detail">
                                                <div class="detail-title">
                                                    Total MRP
                                                </div>
                                                <div class="detail-amt" id="totalMRP">
                                                    $598
                                                </div>
                                            </div>
                                            {{--                                <div class="detail">--}}
                                            {{--                                    <div class="detail-title">--}}
                                            {{--                                        Bag Discount--}}
                                            {{--                                    </div>--}}
                                            {{--                                    <div class="detail-amt discount-amt">--}}
                                            {{--                                        -25$--}}
                                            {{--                                    </div>--}}
                                            {{--                                </div>--}}
                                            {{--                                <div class="detail">--}}
                                            {{--                                    <div class="detail-title">--}}
                                            {{--                                        Estimated Tax--}}
                                            {{--                                    </div>--}}
                                            {{--                                    <div class="detail-amt">--}}
                                            {{--                                        $1.3--}}
                                            {{--                                    </div>--}}
                                            {{--                                </div>--}}
                                            {{--                                <div class="detail">--}}
                                            {{--                                    <div class="detail-title">--}}

                                            {{--                                        EMI Eligibility--}}
                                            {{--                                    </div>--}}
                                            {{--                                    <div class="detail-amt emi-details">--}}
                                            {{--                                        Details--}}
                                            {{--                                    </div>--}}
                                            {{--                                </div>--}}
                                            <div class="detail">
                                                <div class="detail-title">
                                                    Delivery Charges
                                                </div>
                                                <div class="detail-amt discount-amt">
                                                    Free
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="detail">
                                                <div class="detail-title detail-total">Total</div>
                                                <div class="detail-amt total-amt" id="total">$574</div>
                                            </div>
                                            <div class="btn btn-primary btn-block place-order waves-effect waves-light">
                                                PLACE
                                                ORDER
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </fieldset>
                    <h6>Address</h6>
                    <fieldset>
                        <input placeholder="Address" name="address">
                        <div class="btn delivery-address" type="button">Delivery this address</div>
                    </fieldset>
                    <h6>Payment</h6>
                    <fieldset>
                        <input placeholder="Address" name="address">
                        <div class="btn delivery-address" type="button">Delivery this address</div>
                    </fieldset>
                </form>
            @endif
        </div>
    </section>
@endsection
@section('javascript')
    <script src="/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js"></script>
    <script src="/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
    <script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="/js/checkout.js"></script>
@endsection
