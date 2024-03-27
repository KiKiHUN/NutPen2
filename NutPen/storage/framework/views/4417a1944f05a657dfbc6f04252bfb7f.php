



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
                            <h2 class="tm-block-title mb-4">Első indításnál egy admin fiókot kell regisztrálni</h2>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-12">
                            <form action="/registeradmin" method="post" class="tm-login-form">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for="ID">Azonosító</label>
                                    <input name="ID" type="text" class="form-control validate" id="ID"
                                        value="a00000" required />
                                </div>
                                <div class="form-group mt-3">
                                    <label for="password">Jelszó</label>
                                    <input name="password" type="password" class="form-control validate" id="password"
                                        value="" required />
                                </div>
                                <div class="form-group">
                                    <label for="fname">Vezetéknév</label>
                                    <input name="fname" type="text" class="form-control validate" id="fname"
                                        value="" required />
                                </div>
                                <div class="form-group">
                                    <label for="lname">Keresztnév</label>
                                    <input name="lname" type="text" class="form-control validate" id="lname"
                                        value="" required />
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" type="text" class="form-control validate" id="email"
                                        value="" required />
                                </div>
                                <div class="form-group">
                                    <label for="phone">Telefonszám</label>
                                    <input name="phone" type="text" class="form-control validate" id="phone"
                                        value="" required />
                                </div>

                                <div class="form-group">
                                    <label for="postacode">Irányítószám</label>
                                    <input name="postacode" type="number" class="form-control validate" id="postacode"
                                        value="" required />
                                </div>

                                <div class="form-group">
                                    <label for="fulladdress">Cím</label>
                                    <input name="fulladdress" type="text" class="form-control validate" id="fulladdress"
                                        value="" required />
                                </div>

                              
                               
                                <div class="form-group">
                                    <label for="bday">Születési dátum</label>
                                    <input type="date" id="bday" value="2017-06-01" name="bday"/>
                                </div>
                                     
                                      

                                <div class="form-group">
                                    <label for="sextype">Nem:</label>

                                    <select class="form-control validate" name="sextype" id="sextype">
                                        <?php $__currentLoopData = $sexes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sex->ID); ?>"><?php echo e($sex->Name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                               
                                
                                <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary btn-block text-uppercase">
                                            Regisztrál
                                        </button>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/admin/admin_register.blade.php ENDPATH**/ ?>