

<?php $__env->startSection('navbar'); ?>

    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-clock"></i>
            <span>
                Óra <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/ora">Listázás</a>
            <a class="dropdown-item" href="/ora/uj">Új</a>
        </div>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-pen-ruler"></i>
            <span>
                Tantárgy <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/targy">Listázás</a>
            <a class="dropdown-item" href="/targy/uj">Új</a>
        </div>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-clock"></i>
            <span>
                Felhasználó <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/felhasznalok">Listázás</a>
            <a class="dropdown-item" href="/ujfelhasznalo">Új</a>
        </div>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-link"></i>
            <span>
                Diák-Szülő Kapcsolat <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/kapcsolat/szulo ">Listázás</a>
            <a class="dropdown-item" href="/kapcsolat/szulo/uj">Új</a>
        </div>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-link"></i>
            <span>
                Diák-Tanóra Kapcsolat <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/kapcsolat/ora ">Listázás</a>
            <a class="dropdown-item" href="/kapcsolat/ora/uj">Új</a>
        </div>
    </li>


   
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
                <?php if($status!=1): ?>
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
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->USerID); ?></td>
                                    <td><?php echo e($item->fname); ?></td>
                                    <td><?php echo e($item->lname); ?></td>
                                    <td><?php echo e($item->role); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if($status == 1): ?>
                    <h2 class="tm-block-title">Új felhasználó</h2>
                    <div>
                        <form id="ujFelh" action="/felhasznalok/ujFelh" method="post">
                            <?php echo csrf_field(); ?>
                            <label for="vnev">Vezetéknév: </label>
                            <input type="text" id="vnev" name="vnev" value="" required>
                            <label for="knev">Keresztnév: </label>
                            <input type="text" id="knev" name="knev" value="" required>
                            <label for="tipus">Típus: </label>
                            <select id="tipus" name="tipus">
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->ID); ?>"><?php echo e($role->Name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="knev">Jelszó: </label>
                            <input type="password" id="pw" name="pw" value="" required>
                            <input type="submit" value="Mentés" class=" btn-success">
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