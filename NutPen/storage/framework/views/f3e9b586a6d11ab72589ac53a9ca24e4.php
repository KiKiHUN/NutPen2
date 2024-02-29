

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
                <?php if($status<=1): ?>
                    <button type="submit" class="filterbtn" value="a">Admin</button>
                    <button type="submit" class="filterbtn" value="t">Tanár</button>
                    <button type="submit" class="filterbtn" value="s">Diák</button>
                    <button type="submit" class="filterbtn" value="p">Szülő</button>
                    <button type="submit" class="filterbtn" value="h">Fő emberek</button>
                <?php endif; ?>
               
                <?php if($status == 0): ?>
                    <h2 class="tm-block-title">Felhasználók</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Vnév</th>
                                <th class="th-sm">Knév</th>
                                <th class="th-sm">Típus</th>
                                <th class="th-sm">Módosítás</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->USerID); ?></td>
                                    <td><?php echo e($item->fname); ?></td>
                                    <td><?php echo e($item->lname); ?></td>
                                    <td><?php echo e($item->role); ?></td>
                                    <td> <button onclick="location.href = '/felhasznalomodositas/<?php echo e($item->USerID); ?>';" >Szerkesztés</button></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if($status == 2): ?>
                    <h2 class="tm-block-title">Új felhasználó</h2>
                        <form id="ujFelh" class="formCenterContent" action="/ujfelhasznalomentes" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="fname">Vezetéknév: </label>
                                    <input type="text" class="textfield" id="fname" name="fname" value="" required>
                                </div>
                              
                                <div class="inputcolumn">
                                    <label for="lname">Keresztnév: </label>
                                    <input type="text" class="textfield" id="lname" name="lname" value="" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="role">Típus: </label>
                                    <select id="role" class="textfield" name="role">
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->ID); ?>"><?php echo e($role->Name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="inputcolumn">
                                    <label for="sextype">Nem: </label>
                                    <select id="sextype" class="textfield" name="sextype">
                                        <?php $__currentLoopData = $sextypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sextype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sextype->ID); ?>"><?php echo e($sextype->Name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="inputcolumn">
                                    <label for="email">Email: </label>
                                    <input type="email" class="textfield" id="email" name="email" value="" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="phone">Telefonszám: </label>
                                    <input type="text" class="textfield" id="phone" name="phone" value="" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="pw">Jelszó: </label>
                                    <input type="password" class="textfield" id="pw" name="pw" value="" required>
                                </div>

                                <div class="inputcolumn">
                                    <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                </div>
                            <div class="NewUser">
                        </form>
                    </div>
                <?php endif; ?>
                <?php if($status == 3): ?>
                    <h2 class="tm-block-title">Felhasználó módisítás</h2>
                        <form id="ujFelh" class="formCenterContent" action="/felhasznalomodositas/mentes" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="UserID" id="UserID" value="<?php echo e($user->UserID); ?>">
                            <div class="NewUser">
                                <div class="inputcolumn">
                                    <label for="fname">Vezetéknév: </label>
                                    <input type="text" class="textfield" id="fname" name="fname" value="<?php echo e($user->FName); ?>" required>
                                </div>
                              
                                <div class="inputcolumn">
                                    <label for="lname">Keresztnév: </label>
                                    <input type="text" class="textfield" id="lname" name="lname" value="<?php echo e($user->LName); ?>" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="role">Típus: </label>
                                    <select id="role" class="textfield" name="role">
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->ID); ?>" <?php echo e($user->RoleTypeID == $role->ID ? 'selected' : ''); ?>><?php echo e($role->Name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="inputcolumn">
                                    <label for="sextype">Nem: </label>
                                    <select id="sextype" class="textfield" name="sextype">
                                        <?php $__currentLoopData = $sextypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sextype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sextype->ID); ?>" <?php echo e($user->SexTypeID == $sextype->ID ? 'selected' : ''); ?>><?php echo e($sextype->Name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="inputcolumn">
                                    <label for="email">Email: </label>
                                    <input type="email" class="textfield" id="email" name="email" value="<?php echo e($user->Email); ?>" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="phone">Telefonszám: </label>
                                    <input type="text" class="textfield" id="phone" name="phone" value="<?php echo e($user->Phone); ?>" required>
                                </div>

                                <div class="inputcolumn">
                                    <label for="pw">Jelszó: (üresen hagyva nem módosul)</label>
                                    <input type="password" class="textfield" id="pw" name="pw" value="">
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

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/admin/felh.blade.php ENDPATH**/ ?>