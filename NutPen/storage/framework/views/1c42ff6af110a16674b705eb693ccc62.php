<?php $__env->startSection('title', __('Forbidden')); ?>
<?php $__env->startSection('code', '403'); ?>
<?php $__env->startSection('message'); ?>
<i class="fa-solid fa-gavel"></i>
<?php echo e(__($exception->getMessage() ?: 'Forbidden')); ?>

<i class="fa-solid fa-face-kiss-beam"></i>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors::minimal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/errors/403.blade.php ENDPATH**/ ?>