

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
                    <h2 class="tm-block-title">Felhasználók</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Osztályfőnök</th>
                                <th class="th-sm">Osztály módosítása</th>
                                <th class="th-sm">Diákok listázása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->ID); ?></td>
                                    <td><?php echo e($item->Name); ?></td>
                                    <td><?php echo e($item->GetTeacher->FName." ".$item->GetTeacher->LName); ?></td>
                                    <td><button onclick="location.href = '/osztalymodositas/<?php echo e($item->ID); ?>';" >Szerkesztés</button></td>
                                    <td><button onclick="location.href = '/osztaly/diakok/<?php echo e($item->ID); ?>';" >Diákok listázása</button></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if($status == 2): ?>
                    <h2 class="tm-block-title">Új osztály</h2>
                    
                        <form id="ujFelh" class="formCenterContent" action="/ujosztalymentes" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="name">Név: </label>
                                    <input type="text" class="textfield" id="name" name="name" value="" required>
                                </div>
                                <div class="inputcolumn">
                                    <label for="teacher">Osztályfőnök: </label>
                                    <select id="teacher" class="textfield" name="teacher">
                                        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($teacher->UserID); ?>"><?php echo e($teacher->FName." ".$teacher->LName.", ID: ".$teacher->UserID); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="inputcolumn">
                                    <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                </div>
                            <div class="NewUser">
                        </form>
                    </div>
                <?php endif; ?>
                <?php if($status ==3): ?>
                    <h2 class="tm-block-title">Új osztály</h2>
                    
                        <form id="ujFelh" class="formCenterContent" action="/osztalymodositas" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="classID" id="classID" value="<?php echo e($class->ID); ?>">
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="name">Név: </label>
                                    <input type="text" class="textfield" id="name" name="name" value="<?php echo e($class->Name); ?>" required>
                                </div>
                                <div class="inputcolumn">
                                    <label for="teacher">Osztályfőnök: </label>
                                    <select id="teacher" class="textfield" name="teacher">
                                        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($teacher->UserID); ?>" <?php echo e($class->ClassMasterID == $teacher->ID ? 'selected' : ''); ?>><?php echo e($teacher->FName." ".$teacher->LName.", ID: ".$teacher->UserID); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
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
    <script src="<?php echo e(asset('/js/gorgeto.js')); ?>" type="text/javascript" defer></script>
    <script src="<?php echo e(asset('/js/adminJS.js')); ?>" type="text/javascript" defer></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/admin/school_Classes.blade.php ENDPATH**/ ?>