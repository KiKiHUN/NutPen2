

<?php $__env->startSection('header'); ?>
<link rel="stylesheet" href="/bootstrap-datetimepicker-4.17.47/css/bootstrap-datetimepicker.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
       <div class='col-sm-6'>
          <div class="form-group">
             <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
                </span>
             </div>
          </div>
       </div>
       <script type="text/javascript">
          $(function () {
              $('#datetimepicker2').datetimepicker({
                  locale: 'ru'
              });
          });
       </script>
    </div>
 </div>
                                      

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script type="text/javascript" src="/bootstrap-datetimepicker-4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/test.blade.php ENDPATH**/ ?>