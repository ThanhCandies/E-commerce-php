
<?php $__env->startSection('content'); ?>











<section id="ecommerce-products" class="">
    <div class="container row" style="display: flex">
        <div class="col-sm-12">
            <div class="ecommerce-header-items">
                <div class="result-toggler">
                    <div class="search-results">
                        <?php echo e($total??0); ?> results found
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














                </div>
            </div>
        </div>
    </div>
	<div class="grid-view container">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card ecommerce-card">
			<div class="card-content">
				<div class="item-img text-center">
					<a href="/products/<?php echo e($product->id); ?>">
						<img class="img-fluid" src="<?php echo e(isset($product->images)?'http://'.$product->images->url:'../../../app-assets/images/pages/eCommerce/1.png'); ?>" alt="img-placeholder"></a>
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
								$<?php echo e($product->price); ?>

							</h6>
						</div>
					</div>
					<div class="item-name">
						<a href="/products/<?php echo e($product->id); ?>"><?php echo e($product->name); ?></a>

					</div>
					<div>
						<p class="item-description">
							<?php echo e($product->description??'Enjoy smart access to videos, games and apps with this Amazon Fire TV stick. Its Alexa voice remote lets you
							deliver hands-free commands when you want to watch television or engage with other applications. With a
							quad-core processor, 1GB internal memory and 8GB of storage, this portable Amazon Fire TV stick works fast
							for buffer-free streaming.'); ?>

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



					<div class="cart" data-id="<?php echo e($product->id); ?>">
						<i class="feather icon-shopping-cart"></i>
                        <span class="add-to-cart">Add to cart</span>

					</div>
				</div>
			</div>
		</div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\04. Project\01 - Ecommcere\app\views/product.blade.php ENDPATH**/ ?>