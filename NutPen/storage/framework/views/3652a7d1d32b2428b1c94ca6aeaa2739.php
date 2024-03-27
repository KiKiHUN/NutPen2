

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
                <?php if($status == 0): ?>    <!--//tanórák-->
                    <h2 class="tm-block-title">Tanórák</h2>
                    <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                        <thead>
                            <tr>
                                <th class="th-sm">Azonosító</th>
                                <th class="th-sm">Tanár</th>
                                <th class="th-sm">Tantárgy</th>
                                <th class="th-sm">Hossz</th>
                                <th class="th-sm">Napok száma</th>
                                <th class="th-sm">Naptár megnyitása</th>
                                <th class="th-sm">Osztályok listázása</th>
                                <th class="th-sm">Óra módosítása</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->ID); ?></td>
                                    <td><?php echo e($item->GetTeacher->FName." ".$item->GetTeacher->LName); ?></td>
                                    <td><?php echo e($item->GetSubject->Name); ?></td>
                                    <td><?php echo e($item->Minutes); ?> perc</td>
                                    <td>
                                    <?php 
                                            $notNullCount = 0;
                                            foreach (unserialize($item->WeeklyTimes) as $day => $time) {
                                                // Check if the time is not null
                                                if ($time !== null) {
                                                    // If it's not null, increment the counter
                                                    $notNullCount++;
                                                }
                                            }
                                            echo ($notNullCount) ;
                                        ?>
                                    </td>
                                    <td><button onclick="location.href = '/naptar/tanorak/<?php echo e($item->ID); ?>';" >Naptár</button></td>
                                    <td><button onclick="location.href = '/osztalyok/tanora/<?php echo e($item->ID); ?>';" >Osztályok listázása</button></td>
                                    <td><button onclick="location.href = '/tanoramodositas/<?php echo e($item->ID); ?>';" >Szerkesztés</button></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <?php if($status == 2): ?>       <!--//új tanóra-->
                        <h2 class="tm-block-title">Új Tanóra</h2>
                        
                            <form id="ujFelh" class="formCenterContent" action="/ujtanoramentes" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="NewUser">
                                    <div class="inputcolumn">
                                        <label for="teacher">Osztályfőnök: </label>
                                        <select id="teacher" class="textfield" name="teacher">
                                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($teacher->UserID); ?>"><?php echo e($teacher->FName." ".$teacher->LName.", ID: ".$teacher->UserID); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="subject">Tantárgy: </label>
                                        <select id="subject" class="textfield" name="subject">
                                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($subject->ID); ?>"><?php echo e($subject->Name.", ID: ".$subject->ID); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="Minutes">Hossz (perc)</label>
                                        <input name="Minutes" type="number" class="textfield" id="Minutes"
                                            value="" required />
                                    </div>
                                    
                                    <div class="inputcolumn">
                                        <label for="startDate">Mettől:</label>
                                        <input type="date" id="startDate" min="2000-06-07" max="2500-06-14" name="startDate"/>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="endDate">Meddig:</label>
                                        <input type="date" id="endDate" min="2000-06-07" max="2500-06-14" name="endDate"/>
                                    </div>
                                

                                    <div class="inputcolumn">
                                        <label for="weektable">Meddig:</label>
                                        <div class="weektable" id="weektable",name="weektable">
                                            <table>
                                            <thead>
                                                <tr>
                                                <th></th>
                                                <th>Hétfő</th>
                                                <th>Kedd</th>
                                                <th>Szerda</th>
                                                <th>Csütrörtök</th>
                                                <th>Péntek</th>
                                                <th>Szombat</th>
                                                <th>Vasárnap</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td>Aktivál</td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Monday" data-day="Monday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Tuesday" data-day="Tuesday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Wednesday" data-day="Wednesday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Thursday" data-day="Thursday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Friday" data-day="Friday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Saturday" data-day="Saturday"></td>
                                                <td><input type="checkbox" class="day-checkbox textfield" name="CHK_Sunday" data-day="Sunday"></td>
                                                </tr>
                                                <tr>
                                                <td>Időpont</td>
                                                <td><input type="time" class="time-picker" name="TM_Monday" data-day="Monday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Tuesday" data-day="Tuesday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Wednesday" data-day="Wednesday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Thursday" data-day="Thursday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Friday" data-day="Friday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Saturday" data-day="Saturday" disabled></td>
                                                <td><input type="time" class="time-picker" name="TM_Sunday" data-day="Sunday" disabled></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="activated">Aktiválva: </label>
                                        <td><input type="checkbox" name="activated" id="activated" class="textfield" value="1"></td>
                                    </div>

                                    <div class="inputcolumn">
                                        <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                    </div>
                                <div class="NewUser">
                            </form>
                        </div>
                    <?php else: ?>
                        <?php if($status ==3): ?>        <!--//tanóra módosítás-->

                            <h2 class="tm-block-title">Tanóra módosítás</h2>
                            <form id="ujFelh" class="formCenterContent" action="/tanoramodositas" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="lessonID" id="lessonID" value="<?php echo e($lesson->ID); ?>">
                                <div class="NewUser">
                                    <div class="inputcolumn">
                                        <label for="teacher">Osztályfőnök: </label>
                                        <select id="teacher" class="textfield" name="teacher">
                                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($teacher->UserID); ?>" <?php echo e($lesson->TeacherID == $teacher->UserID ? 'selected' : ''); ?>><?php echo e($teacher->FName." ".$teacher->LName.", ID: ".$teacher->UserID); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="subject">Tantárgy: </label>
                                        <select id="subject" class="textfield" name="subject">
                                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($subject->ID); ?>" <?php echo e($lesson->SubjectID == $subject->ID ? 'selected' : ''); ?>><?php echo e($subject->Name.", ID: ".$subject->ID); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="Minutes">Hossz (perc)</label>
                                        <input name="Minutes" type="number" class="textfield" id="Minutes"
                                            value="<?php echo e($lesson->Minutes); ?>" required />
                                    </div>
                                    
                                    <div class="inputcolumn">
                                        <label for="startDate">Mettől:</label>
                                        <input type="date" id="startDate" min="2000-06-07" max="2500-06-14" value="<?php echo e($lesson->StartDate); ?>" name="startDate"/>
                                    </div>
                                    <div class="inputcolumn">
                                        <label for="endDate">Meddig:</label>
                                        <input type="date" id="endDate" min="2000-06-07" max="2500-06-14" value="<?php echo e($lesson->EndDate); ?>" name="endDate"/>
                                    </div>
                                
                                    <div class="inputcolumn">
                                        <label for="weektable">Meddig:</label>
                                        <div class="weektable" id="weektable",name="weektable">
                                            <table>
                                            <thead>
                                                <tr>
                                                <th></th>
                                                <th>Hétfő</th>
                                                <th>Kedd</th>
                                                <th>Szerda</th>
                                                <th>Csütrörtök</th>
                                                <th>Péntek</th>
                                                <th>Szombat</th>
                                                <th>Vasárnap</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                        $a="";
                                                        $a=$a.$lesson->WeeklyTimes;
                                                        $TimeTable=unserialize($a);
                                                    ?>
                                                    <td>Aktivál</td>
                                                    <?php $__currentLoopData = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td><input type="checkbox" class="day-checkbox textfield" name="CHK_<?php echo e($day); ?>" data-day="<?php echo e($day); ?>" <?php echo e(isset($TimeTable[$day]) ? 'checked' : ''); ?>></td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tr>
                                                <tr>
                                                    <td>Időpont</td>
                                                    <?php $__currentLoopData = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td><input type="time" class="time-picker" name="TM_<?php echo e($day); ?>" data-day="<?php echo e($day); ?>" value="<?php echo e(isset($TimeTable[$day]) ? $TimeTable[$day] : ''); ?>" <?php echo e(isset($TimeTable[$day]) ? '' : 'disabled'); ?>></td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="inputcolumn">
                                        <label for="activated">Aktiválva: </label>
                                        <td><input type="checkbox" name="activated" id="activated" class="textfield"  <?php echo e($lesson->Active ? 'checked' : ''); ?>></td>
                                    </div>

                                    <div class="inputcolumn">
                                        <input type="submit" value="Mentés" class=" btn-success margined-send-btn">
                                    </div>
                            
                            </form>
                                
                            </div>
                        <?php else: ?>
                            <?php if($status ==4): ?>       <!-- //Tanórához kapcsolt osztályok és diákok és értékelés-->
                                <h2 class="tm-block-title">Osztályok</h2>
                                <button onclick="location.href = '/tanorak/osztalyhozzad/<?php echo e($lessonID); ?>';" >Új osztály hozzáadása a tanórához</button>
                                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                                    <thead>
                                        <tr>
                                            <th class="th-sm">Azonosító</th>
                                            <th class="th-sm">Név</th>
                                            <th class="th-sm">Osztályfőnök</th>
                                            <th class="th-sm">Osztály értékelései</th>
                                            <th class="th-sm">Diákok listázása</th>
                                            <th class="th-sm">Osztály eltávolítás</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item->ID); ?></td>
                                                <td><?php echo e($item->Name); ?></td>
                                                <td><?php echo e($item->GetTeacher->FName." ".$item->GetTeacher->LName); ?></td>
                                                <td><button onclick="location.href = '/ertekelesek/tanora/<?php echo e($lessonID); ?>/osztaly/<?php echo e($item->ID); ?>';" >Értékelések</button></td>
                                                <td><button onclick="location.href = '/osztaly/diakok/<?php echo e($item->ID); ?>';" >Diákok listázása</button></td>
                                                <td><button onclick="location.href = '/tanora/<?php echo e($lessonID); ?>/osztalytorles/<?php echo e($item->ID); ?>';" >Törlés</button></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <?php if($status ==5): ?>        <!--//osztály tanórához felvétel-->
                                    <h2 class="tm-block-title">Osztályok felvétele a tanórára</h2>
                                                    
                                    <form id="ujFelh" class="formCenterContent" action="/tanorak/osztalyhozzad/mentes" method="post">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="lessonID" id="lessonID" value="<?php echo e($lessonID); ?>">
                                        <div class="NewUser">
                                            <div class="inputcolumn">
                                                <label for="classID">Osztály: </label>
                                                <select id="classID" class="textfield" name="classID">
                                                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($class->ID); ?>"><?php echo e($class->Name."   Osztályfőnök: ".$class->GetTeacher->FName." ".$class->GetTeacher->LName." ID:".$class->ClassMasterID); ?></option>
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

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/admin/lesson.blade.php ENDPATH**/ ?>