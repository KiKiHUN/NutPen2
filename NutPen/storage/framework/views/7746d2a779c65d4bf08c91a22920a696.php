

<?php $__env->startSection('navbar'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    

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
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-clock"></i>
            <span>
                Felhasználó <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/felhasznalok">Listázás</a>
            <a class="dropdown-item" href="/felhasznalok/uj">Új</a>
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
    <div class="row">
        <div class="col">
            <p class="text-white mt-5 mb-5">Hello, <b><?php echo e($user->FName); ?></b></p>
            <input type="hidden" id="UserID" value="<?php echo e($user->UserID); ?>">
        </div>
    </div>
    <!-- row -->
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
            <div class="tm-bg-primary-dark tm-block">
                <h2 class="tm-block-title">Performance</h2>
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-overflow">
                <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">  <!--chatmodal--> 
                    <div class="modal-dialog" role="document">
                      <div class="modal-content modal-bg">
                        <div class="modal-header modal-head">
                          <h5 class="modal-title modal-title2" id="messageModalLabel">Csetfal</h5>
                          <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body modal-inside">
                            <input type="hidden" id="ReplyOtherUserID" value="">
                            <input type="hidden" id="MessageID" value="">
                            <div id="modal-sender" class="modal-msg">
                                <p><strong> <span id="senderNameTag"></span></strong></p>
                                <div id="baseMessageContent"></div>
                            </div>
                            <hr>
                            <div id="modal-target"  class="modal-msg">
                                <p><strong> <span id="replyNameTag"></span></strong></p>
                                <div id="replyContent"></div>
                            </div>
                            <hr>
                            <div class="modal-msg reply-msg">
                                <label for="replyText">Válaszolás:</label>
                                <input type="text" class="form-control msg-reply-text" id="replyText" placeholder="Kezdj el írni...">
                            </div>
                          <button type="button" class="btn btn-primary" id="sendReply">Elküld</button>
                        </div>
                      </div>
                    </div>
                </div>


                <div class="modal fade" id="newMessageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true"> <!--newchatmodal-->
                    <div class="modal-dialog" role="document">
                      <div class="modal-content modal-bg">
                        <div class="modal-header modal-head">
                          <h5 class="modal-title modal-title2" id="messageModalLabel">Új üzenet</h5>
                          <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body modal-inside">
                             <div class="form-group">
                                <label for="newMSGTargetID">Címzet azonosító:</label>
                                <input type="text" class="form-control" id="newMSGTargetID" placeholder="Cél azonosító...">
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="newMSGText">Üzenet</label>
                                <input type="text" class="form-control" id="newMSGText" placeholder="Kezdj el írni egy üzenetet...">
                            </div>
                          <button type="button" class="btn btn-primary" id="sendNewMSG">Elküld</button>
                        </div>
                      </div>
                    </div>
                  </div>
                


                <div class="msg-title">
                    <h2 class="tm-block-title">Üzenetek</h2>
                    <button type="button" id="btn-newmsg" class="close msg-new" aria-label="Új üzenet">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <div class="tm-notification-items">
                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="MessageModal media tm-notification-item" id="msg_<?php echo e($msg->ID); ?>" 
                        data-basemsg="<?php echo e(json_encode($msg->basemsg->Message)); ?>" 
                        data-basesenderid="<?php echo e(json_encode($msg->basemsg->SenderID)); ?>"
                        data-reply="<?php echo e($msg->reply ? json_encode($msg->reply->Message) : "null"); ?>"
                        data-replysenderid="<?php echo e($msg->reply ? json_encode($msg->reply->SenderID) : "null"); ?>"
                        >

                        <?php if((!$msg->reply&&$msg->basemsg->TargetID==$user->UserID)||($msg->reply&&$msg->reply->TargetID==$user->UserID)): ?>
                            <?php if(!$msg->reply): ?>
                                <input type="hidden" id="OtherUserID" value="<?php echo e($msg->basemsg->SenderID); ?>">
                                <div class="tm-gray-circle msg-received"><img src="img/chat.png" alt="Avatar Image" class="rounded-circle msgcircleimg"></div>
                                <div class="media-body">
                                    <p class="mb-2">
                                        <b><?php echo e($msg->basemsg->SenderID); ?> </b>  küldött egy üzenetet<br>
                                    <span class="tm-small tm-text-color-secondary">Ekkor: <?php echo e($msg->basemsg->SentDateTime); ?> </span>
                                </div>
                            <?php else: ?>
                                <input type="hidden" id="OtherUserID" value="<?php echo e($msg->reply->SenderID); ?>">
                                <div class="tm-gray-circle msg-received"><img src="img/chat.png" alt="Avatar Image" class="rounded-circle msgcircleimg"></div>
                                <div class="media-body">
                                    <p class="mb-2">
                                        <b><?php echo e($msg->reply->SenderID); ?> </b>  küldött egy üzenetet<br>
                                    <span class="tm-small tm-text-color-secondary">Ekkor:<?php echo e($msg->reply->SentDateTime); ?> </span>
                                </div>
                            <?php endif; ?>        
                        <?php else: ?>
                            <?php if(!$msg->reply): ?>
                            <input type="hidden" id="OtherUserID" value="<?php echo e($msg->basemsg->TargetID); ?>">
                            <div class="tm-gray-circle msg-sent"><img src="img/chat.png" alt="Avatar Image" class="rounded-circle msgcircleimg"></div>
                            <div class="media-body">
                                <p class="mb-2">
                                    <b><?php echo e($msg->basemsg->TargetID); ?> </b>-nak/nek küldtél egy üzenetet<br>
                                <span class="tm-small tm-text-color-secondary">Ekkor: <?php echo e($msg->basemsg->SentDateTime); ?> </span>
                            </div>
                            <?php else: ?>
                                <input type="hidden" id="OtherUserID" value="<?php echo e($msg->reply->TargetID); ?>">
                                <div class="tm-gray-circle msg-sent"><img src="img/chat.png" alt="Avatar Image" class="rounded-circle msgcircleimg"></div>
                                <div class="media-body">
                                    <p class="mb-2">
                                        <b><?php echo e($msg->reply->TargetID); ?> </b>-nak/nek küldtél egy üzenetet<br>
                                    <span class="tm-small tm-text-color-secondary">Ekkor:  <?php echo e($msg->reply->SentDateTime); ?>  </span>
                                </div>
                            <?php endif; ?>        

                           
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                <h2 class="tm-block-title">Orders List</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ORDER NO.</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">OPERATORS</th>
                            <th scope="col">LOCATION</th>
                            <th scope="col">DISTANCE</th>
                            <th scope="col">START DATE</th>
                            <th scope="col">EST DELIVERY DUE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row"><b>#122349</b></th>
                            <td>
                                <div class="tm-status-circle moving">
                                </div>Moving
                            </td>
                            <td><b>Oliver Trag</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>485 km</b></td>
                            <td>16:00, 12 NOV 2018</td>
                            <td>08:00, 18 NOV 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122348</b></th>
                            <td>
                                <div class="tm-status-circle pending">
                                </div>Pending
                            </td>
                            <td><b>Jacob Miller</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>360 km</b></td>
                            <td>11:00, 10 NOV 2018</td>
                            <td>04:00, 14 NOV 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122347</b></th>
                            <td>
                                <div class="tm-status-circle cancelled">
                                </div>Cancelled
                            </td>
                            <td><b>George Wilson</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>340 km</b></td>
                            <td>12:00, 22 NOV 2018</td>
                            <td>06:00, 28 NOV 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122346</b></th>
                            <td>
                                <div class="tm-status-circle moving">
                                </div>Moving
                            </td>
                            <td><b>William Aung</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>218 km</b></td>
                            <td>15:00, 10 NOV 2018</td>
                            <td>09:00, 14 NOV 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122345</b></th>
                            <td>
                                <div class="tm-status-circle pending">
                                </div>Pending
                            </td>
                            <td><b>Harry Ryan</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>280 km</b></td>
                            <td>15:00, 11 NOV 2018</td>
                            <td>09:00, 17 NOV 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122344</b></th>
                            <td>
                                <div class="tm-status-circle pending">
                                </div>Pending
                            </td>
                            <td><b>Michael Jones</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>218 km</b></td>
                            <td>18:00, 12 OCT 2018</td>
                            <td>06:00, 18 OCT 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122343</b></th>
                            <td>
                                <div class="tm-status-circle moving">
                                </div>Moving
                            </td>
                            <td><b>Timmy Davis</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>218 km</b></td>
                            <td>12:00, 10 OCT 2018</td>
                            <td>08:00, 18 OCT 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122342</b></th>
                            <td>
                                <div class="tm-status-circle moving">
                                </div>Moving
                            </td>
                            <td><b>Oscar Phyo</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>420 km</b></td>
                            <td>15:30, 06 OCT 2018</td>
                            <td>09:30, 16 OCT 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122341</b></th>
                            <td>
                                <div class="tm-status-circle moving">
                                </div>Moving
                            </td>
                            <td><b>Charlie Brown</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>300 km</b></td>
                            <td>11:00, 10 OCT 2018</td>
                            <td>03:00, 14 OCT 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122340</b></th>
                            <td>
                                <div class="tm-status-circle cancelled">
                                </div>Cancelled
                            </td>
                            <td><b>Wilson Cookies</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>218 km</b></td>
                            <td>17:30, 12 OCT 2018</td>
                            <td>08:30, 22 OCT 2018</td>
                        </tr>
                        <tr>
                            <th scope="row"><b>#122339</b></th>
                            <td>
                                <div class="tm-status-circle moving">
                                </div>Moving
                            </td>
                            <td><b>Richard Clamon</b></td>
                            <td><b>London, UK</b></td>
                            <td><b>150 km</b></td>
                            <td>15:00, 12 OCT 2018</td>
                            <td>09:20, 26 OCT 2018</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>
<script src="/js/msgModal.js"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/admin/admin_dashboard.blade.php ENDPATH**/ ?>