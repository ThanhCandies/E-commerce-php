
<?php $__env->startSection('content'); ?>
    <section class="section__container">
        <div class="container category__container">
            <form action="/products" class="filter mb-0">
                <div class="title">
                    <h3>SEARCH PRODUCT</h3>
                </div>
                <div class="filter__inner">
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class="dropdown">
                        <h6>Select category</h6>
                        <div class="dropdown__container">
                            <select name="category">
                                <option value="">Select</option>

                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($k>=8): ?>
                        <?php break; ?>
                    <?php endif; ?>
                    <a href="/category?_id=<?php echo e($category->id); ?>">
                        <div class="list__item">
                            <h6><?php echo e($category->name); ?></h6>
                            <img src="http://<?php echo e(isset($category->images)?$category->images->url:'null'); ?>">
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </scetion>
    <section class="product__container">
        <div>
            <h4>Newest</h4>
            <div class="product__slider-shadow left"></div>
            <div class="product__slider-shadow right"></div>
            <ul class="product__slider" id="slider">
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <div class="product__item">
                            <a href="#" class=" product__item-container" style="display: block">
                                <div class="product__image">
                                    <img src="<?php echo e(isset($product->images)?"http://".$product->images->url:"/app-assets/images/pages/eCommerce/4.png"); ?>">
                                </div>
                                <p><?php echo e($product->name); ?></p>
                                <div class="price__container">
                                    <span class="dollar">$</span>
                                    <span class="price-details"><?php echo e($product->price); ?></span>
                                </div>
                            </a>
                            <a class="cart__add" href="#" data-id="<?php echo e($product->id); ?>">
                                <i class="material-icons">shopping_cart</i>
                            </a>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\04. Project\01 - Ecommcere\app\views/index.blade.php ENDPATH**/ ?>