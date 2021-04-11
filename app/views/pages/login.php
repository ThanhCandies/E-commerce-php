<div class="wrapper">
		<section class="flexbox-container">
			<div class="col-xl-8 col-11 d-flex justify-content-center ">
				<div class="card bg-authentication overflow-hidden">
					<div class="row m-0">
						<div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
							<img src="/assets/images/pages/login.png" alt="branding logo">
						</div>
						<div class="col-lg-6 col-12 p-0">
							<div class="card rounded-0 mb-0 px-2">
								<div class="card-header pb-1">
									<div class="card-title">
										<h4 class="mb-0">Login</h4>
									</div>
								</div>
								<p class="px-2">Welcome back, please login to your account.</p>
								<div class="card-content">
									<div class="card-body pt-1">
										<form action="/login" method="POST" novalidate>
											<fieldset class="form-label-group form-group position-relative has-icon-left">
												<input type="text" class="form-control" id="user-name" placeholder="Username" required="" name="username">
												<div class="help-block"></div>
												<div class="form-control-position">
													<i data-feather="user" class="feather icon-user"></i>
												</div>
												<label for="user-name">Username</label>
											</fieldset>

											<fieldset class="form-label-group form-group position-relative has-icon-left">
												<input type="password" class="form-control" id="user-password" placeholder="Password" required="" name="password">
												<div class="help-block"></div>
												<div class="form-control-position">
													<i class="feather icon-lock"></i>
												</div>
												<label for="user-password">Password</label>
											</fieldset>
											<div class="d-flex justify-content-between align-items-center">
												<div class="text-left">
													<fieldset class="checkbox form-group">
														<div class="vs-checkbox-con vs-checkbox-primary">
															<input type="checkbox" name="remember">
															<span class="vs-checkbox">
																<span class="vs-checkbox--check">
																	<i class="vs-icon feather icon-check"></i>
																</span>
															</span>
															<span class="">Remember me</span>
														</div>
													</fieldset>
												</div>
												<div class="text-right"><a href="/forget" class="card-link">Forgot Password?</a></div>
											</div>
											<a href="/register" class="btn btn-outline-primary float-left btn-inline waves-effect waves-light">Register</a>
											<button type="submit" class="btn btn-primary float-right btn-inline waves-effect waves-light">Login</button>
										</form>
									</div>
								</div>
								<div class="login-footer">
									<div class="divider">
										<div class="divider-text">OR</div>
									</div>
									<div class="footer-btn d-inline">
										<a href="#" class="btn btn-facebook waves-effect waves-light"><span class="fab fa-facebook-f"></span></a>
										<a href="#" class="btn btn-twitter white waves-effect waves-light"><span class="fab fa-twitter"></span></a>
										<a href="#" class="btn btn-google waves-effect waves-light"><span class="fab fa-google"></span></a>
										<a href="#" class="btn btn-github waves-effect waves-light"><span class="fab fa-github-alt"></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>