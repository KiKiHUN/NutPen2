

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
                    <h2 class="tm-block-title">Összes bannolt ID és IP</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Kliens ID</th>
                                <th class="th-sm">Kliens IP</th>
                                <th class="th-sm">ID bannolva</th>
                                <th class="th-sm">IP bannolva</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item['clientID']); ?></td>
                                    <td><?php echo e($item['clientIP']); ?></td>
                                    <td><input type="checkbox" banningid="<?php echo e($item['ID']); ?>" class="CHK_IDbanning"
                                        <?php if( $item['UUIDBanned']==1): ?>
                                            checked
                                            value=1
                                        <?php else: ?>
                                            value=0
                                        <?php endif; ?>
                                    ></td>
                                    <td><input type="checkbox" banningid="<?php echo e($item['ID']); ?>" class="CHK_IPbanning"
                                        <?php if( $item['IPBanned']==1): ?>
                                            checked
                                            value=1
                                        <?php else: ?>
                                            value=0
                                        <?php endif; ?>
                                    ></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <button id="SaveBannBTN" class=" btn-success margined-send-btn">Mentés</button>
                <?php endif; ?>

                <?php if($status == 1): ?>
                    <h2 class="tm-block-title">Új kitiltás</h2>
                    
                        <form id="ujFelh" class="formCenterContent" action="/ujkitiltasmentes" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="UUIDtext">UUID: </label>
                                    <input type="text" class="textfield" id="UUIDtext" name="UUIDtext" placeholder="6c742b69-b4a3-42ab-8793-737f0b3e62ba" value="">
                                </div>

                                <div class="inputcolumn">
                                    <label for="UUIDchk">UUID bannnolva: </label>
                                    <td><input type="checkbox" name="UUIDchk" id="UUIDchk" class="textfield"></td>
                                </div>
                                <br>
                              
                                <div class="inputcolumn">
                                    <label for="IPtext">IP: </label>
                                    <input type="text" class="textfield" id="IPtext" name="IPtext" value="" placeholder="192.168.1.1">
                                </div>

                                <div class="inputcolumn">
                                    <label for="IPchk">UUID bannnolva: </label>
                                    <td><input type="checkbox" name="IPchk" id="IPchk" class="textfield"></td>
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

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/admin/bannedUsers.blade.php ENDPATH**/ ?>