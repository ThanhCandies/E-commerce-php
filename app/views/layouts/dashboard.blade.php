<?php
use App\core\Application;
$routes = Application::$app->getRoutes()['GET'];
$path = Application::$app->request->getPath();
//dd($path,$routes);
?>


<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	@yield('header')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

	<!-- BEGIN: Header-->
	<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
		<div class="navbar-wrapper">
			<div class="navbar-container content">
				<div class="navbar-collapse" id="navbar-mobile">
					<div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
						<ul class="nav navbar-nav">
							<li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
						</ul>
						<ul class="nav navbar-nav bookmark-icons">

						</ul>
						<ul class="nav navbar-nav">

						</ul>
					</div>
					<ul class="nav navbar-nav float-right">

						<li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li>

						<li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span class="badge badge-pill badge-primary badge-up">5</span></a>
							<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
								<li class="dropdown-menu-header">
									<div class="dropdown-header m-0 p-2">
										<h3 class="white">5 New</h3><span class="notification-title">App Notifications</span>
									</div>
								</li>
								<li class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0)">
										<div class="media d-flex align-items-start">
											<div class="media-left"><i class="feather icon-plus-square font-medium-5 primary"></i></div>
											<div class="media-body">
												<h6 class="primary media-heading">You have new order!</h6><small class="notification-text"> Are your going to meet me tonight?</small>
											</div><small>
												<time class="media-meta" datetime="2015-06-11T18:29:20+08:00">9 hours ago</time></small>
										</div>
									</a><a class="d-flex justify-content-between" href="javascript:void(0)">
										<div class="media d-flex align-items-start">
											<div class="media-left"><i class="feather icon-download-cloud font-medium-5 success"></i></div>
											<div class="media-body">
												<h6 class="success media-heading red darken-1">99% Server load</h6><small class="notification-text">You got new order of goods.</small>
											</div><small>
												<time class="media-meta" datetime="2015-06-11T18:29:20+08:00">5 hour ago</time></small>
										</div>
									</a><a class="d-flex justify-content-between" href="javascript:void(0)">
										<div class="media d-flex align-items-start">
											<div class="media-left"><i class="feather icon-alert-triangle font-medium-5 danger"></i></div>
											<div class="media-body">
												<h6 class="danger media-heading yellow darken-3">Warning notifixation</h6><small class="notification-text">Server have 99% CPU usage.</small>
											</div><small>
												<time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
										</div>
									</a><a class="d-flex justify-content-between" href="javascript:void(0)">
										<div class="media d-flex align-items-start">
											<div class="media-left"><i class="feather icon-check-circle font-medium-5 info"></i></div>
											<div class="media-body">
												<h6 class="info media-heading">Complete the task</h6><small class="notification-text">Cake sesame snaps cupcake</small>
											</div><small>
												<time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Last week</time></small>
										</div>
									</a><a class="d-flex justify-content-between" href="javascript:void(0)">
										<div class="media d-flex align-items-start">
											<div class="media-left"><i class="feather icon-file font-medium-5 warning"></i></div>
											<div class="media-body">
												<h6 class="warning media-heading">Generate monthly report</h6><small class="notification-text">Chocolate cake oat cake tiramisu marzipan</small>
											</div><small>
												<time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Last month</time></small>
										</div>
									</a></li>
								<li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center" href="javascript:void(0)">View all notifications</a></li>
							</ul>
						</li>
						<li class="dropdown dropdown-user nav-item">
<!--							<a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">-->
<!--								<div class="user-nav d-sm-flex d-none">-->
<!--									<span class="user-name text-bold-600">John Doe</span>-->
<!--									<span class="user-status">Available</span>-->
<!--								</div>-->
<!--								<span>-->
<!--									<img class="round" src="/app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40">-->
<!--								</span>-->
<!--							</a>-->
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="page-user-profile.html">
									<i class="feather icon-user"></i> Edit Profile
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="auth-login.html"><i class="feather icon-power"></i> Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
	<!-- END: Header-->


	<!-- BEGIN: Main Menu-->
	<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
		<div class="navbar-header">
			<ul class="nav navbar-nav flex-row">
				<li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('admin.home')}}">
						<div class="brand-logo"></div>
						<h2 class="brand-text mb-0">Vuexy</h2>
					</a></li>
				<li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
			</ul>
		</div>
		<div class="shadow-bottom"></div>
		<div class="main-menu-content">
			<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
				<li class="<?= $path===route('admin.home')?'active':'' ?>"><a href="{{route('admin.home')}}"><i class="feather icon-home"></i><span class="menu-item" data-i18n="Analytics">Analytics</span></a>
				</li>
				<li class=" navigation-header"><span>Apps</span>
				</li>
				<li class="<?= $path===route('admin.users')?'active':'' ?> nav-item"><a href="{{route('admin.users')}}"><i class="fa fa-users"></i><span class="menu-item" data-i18n="List Users">List Users</span></a>
				</li>
				<li class="<?= $path===route('admin.products')?'active':'' ?> nav-item"><a href="{{route('admin.products')}}"><i class="fa fa-shopping-bag"></i><span class="menu-item" data-i18n="Products">Products</span></a>
				</li>
				<li class="<?= $path===route('admin.categories')?'active':'' ?> nav-item"><a href="{{route('admin.categories')}}"><i class="fa fa-th"></i><span class="menu-item" data-i18n="Categories">Categories</span></a>
				</li>
				<li class=" navigation-header"><span>pages</span>
				</li>
				<li class="<?= $path===route('admin.profiles')?'active':'' ?> nav-item"><a href="{{route('admin.profiles')}}"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Profile">Profile</span></a>
				</li>
				<li class="<?= $path===route('admin.settings')?'active':'' ?> nav-item"><a href="{{route('admin.settings')}}"><i class="feather icon-settings"></i><span class="menu-title" data-i18n="Account Settings">Account Settings</span></a>
				</li>
				<li class="<?= $path===route('admin.faq')?'active':'' ?> nav-item"><a href="{{route('admin.faq')}}"><i class="feather icon-help-circle"></i><span class="menu-title" data-i18n="FAQ">FAQ</span></a>
				</li>
				<li class="<?= $path===route('admin.knowledgebase')?'active':'' ?> nav-item"><a href="{{route('admin.knowledgebase')}}"><i class="feather icon-info"></i><span class="menu-title" data-i18n="Knowledge Base">Knowledge Base</span></a>
				</li>
				<li class="<?= $path===route('admin.invoice')?'active':'' ?> nav-item"><a href="{{route('admin.invoice')}}"><i class="feather icon-file"></i><span class="menu-title" data-i18n="Invoice">Invoice</span></a>
				</li>
			</ul>
		</div>
	</div>
	<!-- END: Main Menu-->

	<!-- BEGIN: Content-->
	@yield('content')
	<!-- END: Content-->


	<div class="sidenav-overlay"></div>
	<div class="drag-target"></div>

	<!-- BEGIN: Footer-->
	<footer class="footer footer-static footer-light">
		<p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2020<a class="text-bold-800 grey darken-2" href="https://1.envato.market/pixinvent_portfolio" target="_blank">Pixinvent,</a>All rights Reserved</span><span class="float-md-right d-none d-md-block">Hand-crafted & Made with<i class="feather icon-heart pink"></i></span>
			<button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
		</p>
	</footer>
	<!-- END: Footer-->
	@yield('footer')
</body>
<!-- END: Body-->

</html>