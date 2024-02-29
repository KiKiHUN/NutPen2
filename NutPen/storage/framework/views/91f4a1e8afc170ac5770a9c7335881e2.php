<?php $__env->startSection('navbar'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
    <div class="alert alert-warning" style="text-align:center">
        <?php echo e(session()->get('message')); ?>

    </div>
<?php endif; ?>
    <div class="Internal">
       
        <div class="Banner">

        </div>
        <div class="row">
            <div class="col-12 mx-auto tm-login-col">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 class="tm-block-title mb-4">Üdvözöljük a NutPen naplóban</h2>
                            <h2 class="tm-block-title mb-4">Kérem jelentkezzen be</h2>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <form action="/loginCheck" method="post" class="tm-login-form">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for="username">Azonosító</label>
                                    <input name="ID" type="text" class="form-control validate" id="ID"
                                        value="" required />
                                </div>
                                <div class="form-group mt-3">
                                    <label for="password">Jelszó</label>
                                    <input name="password" type="password" class="form-control validate" id="password"
                                        value="" required />
                                </div>
                                <div class="form-group mt-4">

                                    <?php if($enabledToLogin == false): ?>
                                        <br>
                                        <h2 style="color: red">Bejelentkezés letiltva</h2>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-primary btn-block text-uppercase">
                                            Bejelentkez
                                        </button>
                                    <?php endif; ?>
                                    <?php if($voltProba == true): ?>
                                        <br>
                                        <h2 style="color: red">Sikertelen bejelentekzés</h2>
                                    <?php endif; ?>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="/js/bannerLoad.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/login.blade.php ENDPATH**/ ?>