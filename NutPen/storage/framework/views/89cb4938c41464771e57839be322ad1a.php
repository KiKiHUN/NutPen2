<div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col messagediv">
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
                        <label for="userMSGText">Üzenet:</label>
                        <input type="text" class="form-control msg-reply-text" id="userMSGText" placeholder="Kezdj el írni...">
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
            <?php if(count($messages)==0): ?>
                Nincs üzenet
            <?php else: ?>
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
            <?php endif; ?>
            
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\NutPen2\NutPen\resources\views/message.blade.php ENDPATH**/ ?>