
<?php $__env->startSection('content'); ?>
    <section class="section__container">
        <div class="container">
            <h1>
                CHECK OUT
            </h1>
            <?php if(empty($carts)): ?>
                <h6>No Product</h6>
            <?php else: ?>
                <form method="post" action="/checkout" id="checkout">
                    <h6><i class="step-icon step feather icon-shopping-cart"></i>Cart</h6>
                    <fieldset>
                        <section id="place-order" class="list-view product-checkout">
                            <div class="checkout-items">
                                <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card ecommerce-card">
                                        <div class="card-content">
                                            <div class="item-img text-center">
                                                <a href="app-ecommerce-details.html">
                                                    <img src="<?php echo e(isset($product['image'])?"http://".$product['image']:"/app-assets/images/pages/eCommerce/9.png"); ?>"
                                                         alt="img-placeholder">
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <div class="item-name">
                                                    <a href="app-ecommerce-details.html"><?php echo e($product['name']); ?></a>
                                                    
                                                    
                                                    <p class="stock-status-in">In Stock</p>
                                                </div>
                                                <div class="item-quantity">
                                                    <p class="quantity-title">Quantity</p>
                                                    <div class="input-group quantity-counter-wrapper">
                                                        <input type="text" class="quantity-counter" value="<?php echo e($product['count']); ?>" max="10"
                                                               min="1"
                                                               data-price="<?php echo e($product['price']); ?>">
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="item-options text-center">
                                                <div class="item-wrapper">
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    <div class="item-cost">
                                                        <h6 class="item-price">
                                                            $<?php echo e($product['price']); ?>

                                                        </h6>
                                                        
                                                        
                                                        
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                <div class="remove-wishlist" data-id="<?php echo e($product['id']); ?>">
                                                    <i class="feather icon-x align-middle"></i> Remove
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <script src="/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js"></script>
    <script src="/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
    <script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="/js/checkout.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\04. Project\01 - Ecommcere\app\views/checkout.blade.php ENDPATH**/ ?>