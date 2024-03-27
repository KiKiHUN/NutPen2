

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
                <?php if($status == 0): ?>     <!--//értékeléstípusok-->
                    <h2 class="tm-block-title">Értékelés típusok</h2>
                    <button onclick="location.href = '/ujertekelestipus';" >Új értékelés típus</button>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Név</th>
                                <th class="th-sm">Érték</th>
                                <th class="th-sm">Értékelés módosítása</th>
                                <th class="th-sm">Értékelés törlése</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            
                            <?php $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->ID); ?></td>
                                    <td><?php echo e($item->Name); ?></td>
                                    <td><?php echo e($item->Value); ?></td>
                                    <td><button onclick="location.href = '/ertekelestipusmodositas/<?php echo e($item->ID); ?>';" >Módosítás</button></td>
                                    <td><button onclick="location.href = '/ertekelestipustorles/<?php echo e($item->ID); ?>';" >Törlés</button></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <?php if($status == 2): ?>      <!--//új értékeléstípus-->
                        <h2 class="tm-block-title">Új Értékelés típus</h2>
                        
                            <form id="ujFelh" class="formCenterContent" action="/ujertekelestipusmentes" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="NewUser">
                                    <div class="inputcolumn">
                                        <label for="name">Név: </label>
                                        <input type="text" class="textfield" id="name" name="name" value="" required>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="value">Érték: </label>
                                        <input type="text" class="textfield" id="value" name="value" value="" required >
                                    </div>
                                    <div class="inputcolumn">
                                        <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                    </div>
                                <div class="NewUser">
                            </form>
                        </div>
                    <?php else: ?>
                        <?php if($status ==3): ?>       <!--//értékeléstípus módosítás-->

                            <h2 class="tm-block-title">Értékelés típus módosítás</h2>
                            <form id="ujFelh" class="formCenterContent" action="/ertekelestipusmodositas" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="ratingID" id="ratingID" value="<?php echo e($rating->ID); ?>">
                                <div class="NewUser">
                                    <div class="NewUser">
                                        <div class="inputcolumn">
                                            <label for="name">Név: </label>
                                            <input type="text" class="textfield" id="name" name="name" value="<?php echo e($rating->Name); ?>" required>
                                        </div>
                                        <div class="inputcolumn">
                                            <label for="value">Érték: </label>
                                            <input type="text" class="textfield" id="value" name="value" value="<?php echo e($rating->Value); ?>" required >
                                        </div>
                                        <div class="inputcolumn">
                                            <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                        </div>
                                    <div class="NewUser">
                                </div>
                            </form>
                                
                            </div>
                        <?php else: ?>
                            <?php if($status ==4): ?>       <!--//Értékelések listázása a tanórában szereplő diákoknak osztályra szűrve-->
                                <h2 class="tm-block-title"><?php echo e($classname); ?> osztály diákjainak értékelései</h2>
                                <button onclick="location.href = '/tanorak/ujertekeles/<?php echo e($lessonID); ?>/osztaly/<?php echo e($classID); ?>';" >Új értékelés</button>
                                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Azonosító</th>
                                            <th class="th-sm">Név</th>
                                            <th class="th-sm">Értékelések</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        <?php $__currentLoopData = $gradesByStudent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                            <tr>
                                                <td><?php echo e($item["UserID"]); ?></td>
                                                <td><?php echo e($item["name"]); ?></td>
                                                <td>
                                                    <?php $__currentLoopData = $item["grades"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($grade->GetGradeType->Value); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <?php if($status ==5): ?>       <!--//osztály tanórához felvétel-->
                                    <h2 class="tm-block-title"><?php echo e($classname); ?> osztályhoz új értékelések</h2>
                                    <form id="ujFelh" class="formCenterContent" action="/tanorak/ertekelesekmentes" method="post">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="lessonID" id="lessonID" value="<?php echo e($lessonID); ?>">
                                        <input type="hidden" name="classID" id="classID" value="<?php echo e($classID); ?>">
                                        <div class="NewUser">
                                            <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                                <thead>
                                                    <tr>
                                                        <th class="th-sm">Azonosító</th>
                                                        <th class="th-sm">Név</th>
                                                        <th class="th-sm">Értékelések</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">
                                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($item->UserID); ?></td>
                                                            <td><?php echo e($item->LName." ".$item->FName); ?></td>
                                                            <td>
                                                                <select id="gradeID_<?php echo e($item['UserID']); ?>" class="textfield" name="gradeID_<?php echo e($item['UserID']); ?>">
                                                                    <option value="-1">-</option>
                                                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($grade->ID); ?>"><?php echo e($grade->Name."  ".$grade->Value); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>

                                            <div class="inputcolumn">
                                                <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                            </div>
                                        </div>
                                    </form>
                                    
                                <?php else: ?>
                                    <?php if($status ==6): ?>    <!--//Diák jegyéének módosítása-->
                                        <h2 class="tm-block-title"><?php echo e($rating->GetStudent->LName." ".$rating->GetStudent->FName); ?> jegyének módosítása</h2>
                                        <form id="ujFelh" class="formCenterContent" action="/ertekelesmodositas" method="post">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="ratingID" id="ratingID" value="<?php echo e($rating->ID); ?>">
                                            <div class="NewUser">
                                                <div class="NewUser">
                                                    <div class="inputcolumn">
                                                        <label for="value">Érték: </label>
                                                        <select id="gradeTypeID" class="textfield" name="gradeTypeID">
                                                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($grade->ID); ?>" <?php echo e($rating->GradeTypeID == $grade->ID ? 'selected' : ''); ?>><?php echo e($grade->Name."  ".$grade->Value); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="inputcolumn">
                                                        <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                                    </div>
                                                <div class="NewUser">
                                            </div>
                                        </form>
                                            
                                        </div>
                                    <?php else: ?>
                                        <?php if($status==7): ?>      <!--//top X értékelés-->
                                            <h2 class="tm-block-title">Legutóbbi értékelések</h2>
                                            <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                                <thead>
                                                    <tr>
                                                        <th class="th-sm">Azonosító</th>
                                                        <th class="th-sm">Diák Azonosító</th>
                                                        <th class="th-sm">Diák Neve</th>
                                                        <th class="th-sm">Értékelés</th>
                                                        <th class="th-sm">Értékelés módosítása</th>
                                                        <th class="th-sm">Értékelés törlése</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">
                                                    <?php $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($item->ID); ?></td>
                                                            <td><?php echo e($item->GetStudent->UserID); ?></td>
                                                            <td><?php echo e($item->GetStudent->FName." ".$item->GetStudent->LName); ?></td>
                                                            <td><?php echo e($item->GetGradeType->Name." // ".$item->GetGradeType->Value); ?></td>
                                                            <td><button onclick="location.href = '/ertekelesmodositas/<?php echo e($item->ID); ?>';" >Módosítás</button></td>
                                                            <td><button onclick="location.href = '/ertekelestorles/<?php echo e($item->ID); ?>';" >Törlés</button></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>

               
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

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/admin/rating.blade.php ENDPATH**/ ?>