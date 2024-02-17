$('.MessageModal').click(function() {
    var userID = $('#UserID').val();
    var basemsg = JSON.parse($(this).data('basemsg'));
    var reply = $(this).data('reply') !== 'null' ? JSON.parse($(this).data('reply')) : null;
    var baseSenderID = JSON.parse($(this).data('basesenderid'));
    var replySenderID = JSON.parse($(this).data('replysenderid'));

    var senderDisplayName = "";
    $("#modal-sender").removeClass();
    if (baseSenderID === userID) {
      senderDisplayName='Te küldted:';
      $("#modal-sender").addClass("modal-msg msg-color-user");
    }else
    {
      senderDisplayName=baseSenderID+' küldte:' ;
      $("#modal-sender").addClass("modal-msg msg-color-other");
    }
    $('#senderNameTag').text(senderDisplayName);
    $("div").addClass("important");
    $("#modal-target").removeClass();
    if (reply!=null) {
      var ReplyDisplayName="";
      if (replySenderID === userID) {
        $('#sendReply').text('Üzenet frisítése'); 
        ReplyDisplayName="Te küldted:";
        $("#modal-target").addClass("modal-msg msg-color-user");
      } else {
        $('#sendReply').text('Üzenet küldése'); 
        ReplyDisplayName=replySenderID+' küldte:';
        $("#modal-target").addClass("modal-msg msg-color-other");
      }
    }else 
    {
      ReplyDisplayName="Nincs válasz üzenet :(";
      $('#sendReply').text('Üzenet küldése'); 
      $("#modal-target").addClass("modal-msg msg-color-nothing");
    }
    $('#replyNameTag').text(ReplyDisplayName);
    var messageID = $(this).attr('id');
    $('#MessageID').val(messageID);

    var otherUserID = $(this).find('#OtherUserID').val();
    $('#ReplyOtherUserID').val(otherUserID);
    
    $('#baseMessageContent').html('<p>' + basemsg + '</p>');
    if (reply) {
      $('#replyContent').html('<p>' + reply + '</p>');
    } else {
      $('#replyContent').html('<p></p>');
    }

    // Show the modal
    $('#messageModal').modal('show');
});

$('#btn-newmsg').click(function() {
  $('#newMessageModal').modal('show');
});

$('#sendNewMSG').click(function() {
  var Message = $('#newMSGText').val();
  var UserID = $('#UserID').val();
  var TargetID = $('#newMSGTargetID').val();

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  $.ajax({
    url: '/newmsg', 
    method: 'POST',
    data: {
      SenderID: UserID,
      TargetID: TargetID,
      message: Message
    },
    success: function(response) {
      console.log('válasz:', response);
      if (response.status!=0) {
        alert("hiba: "+response.message);
      }else
      {
        UpdateOnReply();
      }
    },
    error: function(xhr, status, error) {
      // Handle error response from the server
      alert("hiba: \n"+xhr.responseText)
    }
  });
});


$('#sendReply').click(function() {
  var replyMessage = $('#replyText').val();
  var UserID = $('#UserID').val();
  var OtherUSerID = $('#ReplyOtherUserID').val();

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  $.ajax({
    url: '/savemsg', 
    method: 'POST',
    data: {
      SenderID: UserID,
      TargetID: OtherUSerID,
      message: replyMessage
    },
    success: function(response) {
      console.log('válasz:', response);
      if (response.status!=0) {
        alert("hiba: "+response.message);
      }else
      {
        UpdateOnReply();
      }
    },
    error: function(xhr, status, error) {
      // Handle error response from the server
      alert("hiba: \n"+xhr.responseText)
    }
  });
});

function UpdateOnReply ()
{ 
    var messageID=$('#MessageID').val();
    localStorage.setItem('selectedMessageID', messageID);
    // Reload the page or refresh the messages list
    location.reload();
}

$( document ).ready(function() {
 
  var selectedMessageID = localStorage.getItem('selectedMessageID');
  if (selectedMessageID!="-1") {
    // Perform a click on the message based on the stored ID
    $('#' + selectedMessageID).click();
    localStorage.setItem('selectedMessageID', -1);
}
});