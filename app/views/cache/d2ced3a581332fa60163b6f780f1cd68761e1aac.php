
<?php $__env->startSection('title',$exception->getMessage()); ?>
<?php $__env->startSection('content'); ?>
<section class="row flexbox-container mx-0">
    <div class="col-xl-7 cl-md-8 col-12 d-flex justify-content-center ">
        <div class="card-content">
            <div class="card-body text-center">
                <img src="/assets/images/pages/404.png" class="img-fluid align-self-center" alt="branding logo">
                <h1 class="font-large-2 my-1"><?php echo e($exception->getCode()); ?> - <?php echo e($exception->getMessage()); ?></h1>
                <p class="p-2">
                    We're sorry, the page you requeste could not be found. PLease go back to homepage or contact us at
                    <a href="mailto:<?= $_ENV["EMAIL"] ?? "example@example.com" ?>"><?= $_ENV["EMAIL"] ?? "example@example.com" ?></a>
                </p>
                <a class="btn btn-primary btn-lg mt-2 waves-effect waves-light" href="/">Back to Home</a>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts._error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\04. Project\01 - Ecommcere\app\views/pages/_error.blade.php ENDPATH**/ ?>