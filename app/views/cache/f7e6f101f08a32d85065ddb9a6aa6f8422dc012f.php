
<?php $__env->startSection('title','Register'); ?>
<?php $__env->startSection('content'); ?>
    <div class="wrapper">
        <section class="flexbox-container">
            <div class="col-xl-8 col-11 d-flex justify-content-center ">
                <div class="card bg-authentication overflow-hidden">
                    <div class="row m-0">
                        <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                            <img src="/assets/images/pages/login.png" alt="branding logo">
                        </div>
                        <div class="col-lg-6 col-12 p-0">
                            <div class="card rounded-0 mb-0 px-2 pb-2">
                                <div class="card-header pb-1">
                                    <div class="card-title">
                                        <h4 class="mb-0">Create Account</h4>
                                    </div>
                                </div>
                                <p class="px-2">Fill the below form to create a new account.</p>
                                <div class="card-content">
                                    <div class="card-body pt-1">
                                        <form action="/register" method="POST" novalidate>
                                            <div class="row mx-0">
                                                <div class="col-lg-5 col-12 p-0">
                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="first-name" placeholder="First Name" required="required" name="firstname">
                                                        <div class="help-block"></div>
                                                        <div class="form-control-position">
                                                            <i data-feather="user" class="feather icon-user"></i>
                                                        </div>
                                                        <label for="first-name">First Name</label>
                                                    </fieldset>
                                                    <div class="help-block"></div>
                                                </div>
                                                <div class="col-lg-5 offset-lg-2 col-12 p-0">
                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="last-name" placeholder="First Name" required="required" name="lastname">
                                                        <!-- <input type="text" class="form-control" id="last-name" placeholder="Last Name" required="required" name="lastname"> -->
                                                        <div class="help-block"></div>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                        <label for="last-name">Last Name</label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <fieldset class="form-label-group form-group control-group position-relative has-icon-left">
                                                <input type="email" class="form-control" id="email" placeholder="Email" required="" name="email">
                                                <div class="help-block"></div>
                                                <div class="form-control-position">
                                                    <i class="feather icon-email"></i>
                                                </div>
                                                <label for="email">Email</label>
                                            </fieldset>
                                            <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                <input type="text" class="form-control" id="username" placeholder="Username" required="" name="username">
                                                <div class="help-block"></div>
                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                                <label for="username">Username</label>
                                            </fieldset>
                                            <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                <!-- <input type="password" class="form-control" id="password" placeholder="Password" required="" name="password"> -->
                                                <input type="password" class="form-control" id="password" placeholder="Your Password" required="" data-validation-required-message="The password field is required" minlength="6" aria-invalid="true" name="password">
                                                <div class="help-block"></div>
                                                <div class="form-control-position">
                                                    <i class="feather icon-lock"></i>
                                                </div>
                                                <label for="password">Password</label>
                                            </fieldset>
                                            <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password" name="confirmPassword" data-validation-match-match="password" aria-invalid="false">
                                                <div class="help-block"></div>
                                                <div class="form-control-position">
                                                    <i class="feather icon-lock"></i>
                                                </div>
                                                <label for="confirm-password">Confirm Password</label>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <fieldset class="checkbox ">
                                                        <div class="vs-checkbox-con vs-checkbox-primary  form-group">
                                                            <input type="checkbox" name="terms" require="" id="terms-and-conditions" data-validation-required-message="The password field is required" aria-invalid="false">
                                                            <span class="vs-checkbox">
															<span class="vs-checkbox--check">
																<i class="vs-icon feather icon-check"></i>
															</span>
														</span>
                                                            <span class=""> I accept the terms &amp; conditions.</span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <a href="/login" class="btn btn-outline-primary float-left btn-inline waves-effect waves-light">Login</a>
                                            <button type="submit" class="btn btn-primary float-right btn-inline waves-effect waves-light">Register</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\04. Project\01 - Ecommcere\app\views/pages/auth/register.blade.php ENDPATH**/ ?>