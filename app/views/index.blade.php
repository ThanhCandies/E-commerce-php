<?php

use App\core\Application;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/assets/ico/favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <style>
    </style>
    <title>E commcerce</title>
</head>

<body>
<div class="wrapper">
    <header class="header">
        <div class="header__container">
            <div class="menu header__menu">
                <i class="fa fa-bars"></i>
            </div>
            <a href="/" class="logo">
                <span class="logo__text">parts</span>
                <br />
                <span>autos</span>
            </a>
            <div class="header__searchbar rounded-pill">
                <form action="/products" method="get">
                    <input type="text" autocomplete="off" placeholder="Search..." id="search" name="q" maxlength="256">
                    <button type="submit" class="btn p-0 rounded-circle header__serachbar-submit">
                        <inp class="fa fa-search"></input>
                    </button>
                </form>
            </div>
            <div class="header__auth">
                <?php if (Application::isGuest()) : ?>
                <ul class="header__auth-list">
                    <li class="header__auth-item"><a class="btn btn-primary" href="/login">Sign in</a></li>
                    <li class="header__auth-item"><a class="btn btn-primary" href="/register">Sign up</a></li>
                </ul>
                <?php else : ?>
                <ul class="header__auth-list">
                    <li class="nav__dropdown dropdown-user nav-item" style="position: relative">
                        <a class="nav-link dropdown-user-link" href="#" data-toggle="dropdown" aria-expanded="false"
                           data-display="static">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name text-bold-600"><?= Application::$app->user->getDisplayName(); ?></span>
                                <span class="user-status">Available</span>
                            </div>
                            <span class="nav__dropdown-cover overflow-hidden">
										<img class="round" src="/assets/images/pages/eCommerce/4.png" alt="avatar" height="40" width="40">
									</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/profile"><i class="feather icon-user"></i> Edit Profile</a>
                            <!--									<a class="dropdown-item" href="app-email.html"><i class="feather icon-mail"></i> My Inbox</a>-->
                            <!--									<a class="dropdown-item" href="app-todo.html"><i class="feather icon-check-square"></i> Task</a>-->
                            <!--									<a class="dropdown-item" href="app-chat.html"><i class="feather icon-message-square"></i> Chats</a>-->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout"><i class="feather icon-power"></i> Logout</a>
                        </div>
                    </li>
                    <li class="nav__dropdown dropdown-notification">
                        <a class="nav__dropdown-link nav__dropdown-cover" href="#" data-toggle="dropdown" data-display="static">
                            <i class="material-icons">shopping_cart</i>
                            <span class="badge badge-pill badge-danger badge-up cart-item-count">6</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-cart dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header m-0 p-2">
                                    <h3 class="white"><span class="cart-item-count">6</span><span class="mx-50">Items</span></h3><span
                                            class="notification-title">In Your Cart</span>
                                </div>
                            </li>
                            <li class="scrollable-container media-list scroll-y">
                                <a class="cart-item" href="app-ecommerce-details.html">
                                    <div class="media">
                                        <div class="media-left d-flex justify-content-center align-items-center">
                                            <img src="/assets/images/pages/eCommerce/4.png" width="75" alt="Cart Item">
                                        </div>
                                        <div class="media-body">
                                            <span class="item-title text-truncate text-bold-500 d-block mb-50">Apple - Apple Watch Series 1 42mm Space Gray Aluminum Case Black Sport Band - Space Gray Aluminum</span>
                                            <span class="item-desc font-small-2 text-truncate d-block"> Durable, lightweight aluminum cases in silver, space gray,gold, and rose gold. Sport Band in a variety of colors. All the features of the original Apple Watch, plus a new dual-core processor for faster performance. All models run watchOS 3. Requires an iPhone 5 or later to run this device.</span>
                                            <div class="d-flex justify-content-between align-items-center mt-1">
                                                <span class="align-middle d-block">1 x $299</span><i
                                                        class="remove-cart-item feather icon-x danger font-medium-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center text-primary"
                                                                href="/checkout"><i
                                            class="feather icon-shopping-cart align-middle"></i><span class="align-middle text-bold-600">Checkout</span></a>
                            </li>
                            <li class="empty-cart d-none p-2">Your Cart Is Empty.</li>
                        </ul>
                    </li>
                </ul>
                <?php endif ?>
            </div>
        </div>
    </header>
    <div class="container" style="">
        <nav class="nav">
            <div class="menu">
                <i class="fa fa-bars"></i>
            </div>
            <div class="nav__catalog">
                <div style="position: relative;">
                    <span>CATALOG</span>
                    <div style="height: 1.15rem;width:100%;position:absolute"></div>
                </div>
                <div class="nav__catalog-container">
                    <ul class="nav__catalog-list">
                        <li class="nav__catalog-item">
                            <a href="/products/laptop" class="catatog__item">
                                <h5>Laptop</h5>
                            </a>
                            <a href="/products/laptop?filter=asus" class="catatog__sub-item">asus</a>
                            <a href="/products/laptop?filter=asus" class="catatog__sub-item">asus</a>
                            <a href="/products/laptop?filter=asus" class="catatog__sub-item">asus</a>
                            <a href="/products/laptop?filter=asus" class="catatog__sub-item">asus</a>
                            <a href="/products/laptop?filter=asus" class="catatog__sub-item">asus</a>
                        </li>
                        <li class="nav__catalog-item">
                            <a href="/products/PC" class="catatog__item">
                                <h5>PC</h5>
                            </a>
                            <a href="/products/PC?filter=asus" class="catatog__sub-item">asus</a>
                            <a href="/products/PC?filter=asus" class="catatog__sub-item">asus</a>
                            <a href="/products/PC?filter=asus" class="catatog__sub-item">asus</a>
                            <a href="/products/PC?filter=asus" class="catatog__sub-item">asus</a>
                            <a href="/products/PC?filter=asus" class="catatog__sub-item">asus</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="nav__inner">
                <ul class="nav__links">
                    <li><a href="#">home</a></li>
                    <li><a href="#">blog</a></li>
                    <li><a href="#">faq</a></li>
                    <li><a href="#">services</a></li>
                    <li><a href="#">about us</a></li>
                    <li><a href="#">contacts</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <section class="container category__container">

        <form action="/products" class="filter">
            <div class="title">
                <h3>SEARCH PART</h3>
            </div>
            <div class="filter__inner">
                <div class="dropdown">
                    <h6>Select make</h6>
                    <div class="dropdown__container">
                        <select name="test2">
                            <option value="0">All</option>
                            <option value="1">Audi</option>
                            <option value="2">BMW</option>
                            <option value="3">Citroen</option>
                            <option value="4">Ford</option>
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
                <div class="dropdown">
                    <h6>Select model</h6>
                    <div class="dropdown__container">
                        <select name="test3">
                            <option value="0">Select car:</option>
                            <option value="1">Audi</option>
                            <option value="2">BMW</option>
                            <option value="3">Citroen</option>
                            <option value="4">Ford</option>
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
                <div class="dropdown">
                    <h6>Select year</h6>

                    <div class="dropdown__container">
                        <select name="test4">
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
    </section>
    <scetion class="container category__list">
        <h4>Categories</h4>
        <div class="list__container">
            <div class="list__item">
                <h6>Smart Watch</h6>
                <img src="/app-assets/images/pages/eCommerce/4.png">
            </div>
            <div class="list__item">
                <h6>Audio</h6>
                <img src="/app-assets/images/pages/eCommerce/12.png">
            </div>
            <div class="list__item">
                <h6>Laptop</h6>
                <img src="/app-assets/images/pages/eCommerce/apple-macbook.jpg">
            </div>
            <div class="list__item">
                <h6>Monitor</h6>
                <img src="/app-assets/images/pages/eCommerce/apple-Imac.jpg">
            </div>
            <div class="list__item">
                <h6>Console</h6>
                <img src="/app-assets/images/pages/eCommerce/7.png">
            </div>
            <div class="list__item">
                <h6>Camera</h6>
                <img src="/app-assets/images/pages/eCommerce/canon-camera.jpg">
            </div>
            <div class="list__item">
                <h6>Desktop</h6>
                <img src="/app-assets/images/pages/eCommerce/asus-desktop.jpg">
            </div>
            <div class="list__item">
                <h6>Accessrios</h6>
                <img src="/app-assets/images/pages/eCommerce/11.png">
            </div>
        </div>
    </scetion>
    <section class="product__container">
        <div class="product__item">
            <div class="product__image">
                <img src="/app-assets/images/pages/eCommerce/4.png">
            </div>
            <p>Apple watch</p>
            <div class="price__container">
                <span class="dollar">$</span>
                <span class="price-details">1175</span>
            </div>
            <a class="cart__add" href="">
                <i class="material-icons">shopping_cart</i>
            </a>
        </div>
        <div class="product__item">
            <div class="product__image">
                <img src="/app-assets/images/pages/eCommerce/4.png">
            </div>
            <p>Apple watch</p>
            <div class="price__container">
                <span class="dollar">$</span>
                <span class="price-details">1175</span>
            </div>
            <a class="cart__add" href="">
                <i class="material-icons">shopping_cart</i>
            </a>
        </div><div class="product__item">
            <div class="product__image">
                <img src="/app-assets/images/pages/eCommerce/4.png">
            </div>
            <p>Apple watch</p>
            <div class="price__container">
                <span class="dollar">$</span>
                <span class="price-details">1175</span>
            </div>
            <a class="cart__add" href="">
                <i class="material-icons">shopping_cart</i>
            </a>
        </div><div class="product__item">
            <div class="product__image">
                <img src="/app-assets/images/pages/eCommerce/4.png">
            </div>
            <p>Apple watch</p>
            <div class="price__container">
                <span class="dollar">$</span>
                <span class="price-details">1175</span>
            </div>
            <a class="cart__add" href="">
                <i class="material-icons">shopping_cart</i>
            </a>
        </div><div class="product__item">
            <div class="product__image">
                <img src="/app-assets/images/pages/eCommerce/4.png">
            </div>
            <p>Apple watch</p>
            <div class="price__container">
                <span class="dollar">$</span>
                <span class="price-details">1175</span>
            </div>
            <a class="cart__add" href="">
                <i class="material-icons">shopping_cart</i>
            </a>
        </div><div class="product__item">
            <div class="product__image">
                <img src="/app-assets/images/pages/eCommerce/4.png">
            </div>
            <p>Apple watch</p>
            <div class="price__container">
                <span class="dollar">$</span>
                <span class="price-details">1175</span>
            </div>
            <a class="cart__add" href="">
                <i class="material-icons">shopping_cart</i>
            </a>
        </div>
    </section>
    <footer>

    </footer>
</div>
</body>
<!-- JavaScript Bundle with Popper -->
<script src="/js/vendors/vendors.min.js"></script>
<script src="/js/vendors/bootstrap.bundle.js"></script>
<script src="/js/vendors/bootstrap.bundle.min.js"></script>
<script src="/js/vendors/bootstrap.js"></script>
<script src="/js/vendors/bootstrap.min.js"></script>
<script src="/js/main.js"></script>
<script>

</script>

</html>