

<?php $__env->startSection('navbar'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <?php echo $__env->make('admin.Navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    

    <!-- row -->
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
        </div>

        <?php if(session()->has('message')): ?>
            <div class="alert alert-success">
                <?php echo e(session()->get('message')); ?>

            </div>
        <?php endif; ?>

        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                <?php if($status == 0): ?>
                    <h2 class="tm-block-title">Tantárgyak</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Leírás</th>
                                <th class="th-sm">Tantárgy módosítása</th>
                                <th class="th-sm">Tanórák listázása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->ID); ?></td>
                                    <td><?php echo e($item->Name); ?></td>
                                    <td><?php echo e($item->Description); ?></td>
                                    <td><button onclick="location.href = '/tantargymodositas/<?php echo e($item->ID); ?>';" >Szerkesztés</button></td>
                                    <td><button onclick="location.href = '/tantargy/orak/<?php echo e($item->ID); ?>';" >Tanórák listázása</button></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if($status == 2): ?>
                    <h2 class="tm-block-title">Új tantárgy</h2>
                    
                        <form id="ujFelh" class="formCenterContent" action="/ujtantargymentes" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="name">Név: </label>
                                    <input type="text" class="textfield" id="name" name="name" value="" required>
                                </div>
                                <div class="inputcolumn">
                                    <label for="description">Leírás: </label>
                                    <input type="text" class="textfield" id="description" name="description" value="">
                                </div>
                                <div class="inputcolumn">
                                    <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                </div>
                            <div class="NewUser">
                        </form>
                <?php endif; ?>
                <?php if($status ==3): ?>
                    <h2 class="tm-block-title">Tantárgy módosítás</h2>
                    
                        <form id="ujFelh" class="formCenterContent" action="/tantargymodositas" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="subjectID" id="classID" value="<?php echo e($subject->ID); ?>">
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="name">Név: </label>
                                    <input type="text" class="textfield" id="name" name="name" value="<?php echo e($subject->Name); ?>" required>
                                </div>
                                <div class="inputcolumn">
                                    <label for="description">Leírás: </label>
                                    <input type="text" class="textfield" id="description" name="description" value="<?php echo e($subject->Description); ?>">
                                </div>
                                <div class="inputcolumn">
                                    <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                </div>
                            <div class="NewUser">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
    <script src="<?php echo e(asset('/js/gorgeto.js')); ?>" type="text/javascript" defer></script>
    <script src="<?php echo e(asset('/js/adminJS.js')); ?>" type="text/javascript" defer></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/admin/subject.blade.php ENDPATH**/ ?>