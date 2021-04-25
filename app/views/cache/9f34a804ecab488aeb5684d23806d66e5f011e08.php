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
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="css/lightslider.css">
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
										<img class="round" src="/assets/images/pages/eCommerce/4.png" alt="avatar"
                                             height="40" width="40">
									</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/profile"><i class="feather icon-user"></i> Edit Profile</a>
                            <!--	<a class="dropdown-item" href="app-email.html"><i class="feather icon-mail"></i> My Inbox</a>-->
                            <!--	<a class="dropdown-item" href="app-todo.html"><i class="feather icon-check-square"></i> Task</a>-->
                            <!--	<a class="dropdown-item" href="app-chat.html"><i class="feather icon-message-square"></i> Chats</a>-->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout"><i class="feather icon-power"></i> Logout</a>
                        </div>
                    </li>
                    <li class="nav__dropdown dropdown-notification">
                        <a class="nav__dropdown-link nav__dropdown-cover" href="/checkout"


                        >
                            <i class="material-icons">shopping_cart</i>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-cart dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header m-0 p-2">
                                    <h3 class="white"><span class="cart-item-count">6</span><span
                                                class="mx-50">Items</span></h3><span class="notification-title">In Your Cart</span>
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
                                            class="feather icon-shopping-cart align-middle"></i><span
                                            class="align-middle text-bold-600">Checkout</span></a>
                            </li>
                            <li class="empty-cart d-none p-2">Your Cart Is Empty.</li>
                        </ul>
                    </li>
                </ul>
                <?php endif ?>
            </div>
        </div>
    </header>
    <div style="padding-top: 2.2rem;
    width: 100%;
    height: 102px;
    position: fixed;
    top: 0;
    z-index: 2;
display: block;
    background: -webkit-linear-gradient(top, rgba(248, 248, 248, 0.95) 44%, rgba(248, 248, 248, 0.46) 73%, rgba(255, 255, 255, 0));">

    </div>
    <div class="container p-0" style="">
        <nav class="nav">
            <div class="menu">
                <i class="fa fa-bars"></i>
            </div>
            <div class="nav__catalog">
                <div style="position: relative;">
                    <span>CATALOG</span>
                    <div style="height: 1.15rem;width:100%;position:absolute"></div>
                </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
            </div>
            <div class="nav__inner">
                <ul class="nav__links">
                    <li><a href="/">home</a></li>
                    <li><a href="/products">products</a></li>




                </ul>
            </div>
        </nav>
    </div>
    <div class="content-padding"></div>
    <!-- BEGIN: Content-->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- END: Content-->


</div>
<footer class="footer">
    <div class="footer__container">

        <div class="footer__top d-flex">
            <div class="footer__first col-4">
                <h3>E Commerce</h3>
                <div>
                    <a href="">
                        <i class="fa fa-phone"></i>(+00) 000 000 000
                    </a>
                </div>
                <div>
                    <a href="">
                        <i class="fa fa-envelope-o"></i>email@example.com
                    </a>
                </div>
            </div>
            <div class="footer__list col-8">
                <div class="footer__section">
                    <h4>Company</h4>
                    <div>
                        <a href="">About us</a>
                    </div>
                    <div>
                        <a href="">Block</a>
                    </div>
                    <div>
                        <a href="">Contact</a>
                    </div>
                </div>
                <div class="footer__section">
                    <h4>Link</h4>
                    <div>
                        <a href="">About us</a>
                    </div>
                    <div>
                        <a href="">Block</a>
                    </div>
                    <div>
                        <a href="">Contact</a>
                    </div>
                </div>
                <div class="footer__section">
                    <h4>Support</h4>
                    <div>
                        <a href="">About us</a>
                    </div>
                    <div>
                        <a href="">Block</a>
                    </div>
                    <div>
                        <a href="">Contact</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer__bottom d-flex justify-content-between">
            <div class="">Powered by myself</div>
            <ul class="mb-0">
                <li><a href="">Privacy</a></li>
                <li><a href="">Terms</a></li>
                <li><a href="">Purchase</a></li>
            </ul>
        </div>

    </div>
</footer>
</body>
<!-- JavaScript Bundle with Popper -->
<script src="/js/vendors/vendors.min.js"></script>
<script src="/js/vendors/bootstrap.bundle.js"></script>
<script src="/js/vendors/bootstrap.bundle.min.js"></script>
<script src="/js/vendors/bootstrap.js"></script>
<script src="/js/vendors/bootstrap.min.js"></script>
<script src="/js/vendors/lightslider.js"></script>
<?php echo $__env->yieldContent('javascript'); ?>
<script src="/js/main.js"></script>
<script>

</script>

</html><?php /**PATH D:\04. Project\01 - Ecommcere\app\views/layouts/home.blade.php ENDPATH**/ ?>