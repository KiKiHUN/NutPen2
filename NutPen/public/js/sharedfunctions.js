
        
function showDetails(DayTimes) 
{
    console.log(DayTimes);
    var out="";
    for(var i = 0; i < DayTimes.length; i++) {
        var endTime=addMinutesToTime(DayTimes[i].Time,DayTimes[i].Lenght);
        //out=out+DayNameTranslate(DayTimes[i].Day)+": "+DayTimes[i].Time+"->"+endTime+"\n";
        out += '<div class="day-divider">' + DayNameTranslate(DayTimes[i].Day) + ' : <span class="boldmodaltext timepadding">' + DayTimes[i].Time + ' - ' + endTime + '</span></div>';
    }
    $('#classinfomodal .modal-body').html(out);
    $('#classinfomodal').modal('show').find('.modal-dialog').slideDown();
    //alert(out);
    
}
$(".close").click(function() {
    $("#myModal").css("display", "none");
});

function addMinutesToTime(timeString, minutesToAdd) 
{
    var timeParts = timeString.split(':');
    var hours = parseInt(timeParts[0], 10);
    var minutes = parseInt(timeParts[1], 10);

    
    var date = new Date();
    date.setHours(hours);
    date.setMinutes(minutes);

    
    date.setMinutes(date.getMinutes() + minutesToAdd);

    
    var resultHours = date.getHours();
    var resultMinutes = date.getMinutes();

    
    resultMinutes = (resultMinutes < 10 ? '0' : '') + resultMinutes;

    var resultTimeString = resultHours + ':' + resultMinutes;

    return resultTimeString;
}

function DayNameTranslate(Day) 
{
    var hunDay = "";
    switch(Day) {
        case "Monday":
            hunDay = "Hétfő";
            break;
        case "Tuesday":
            hunDay = "Kedd";
            break;
        case "Wednesday":
            hunDay = "Szerda";
            break;
        case "Thursday":
            hunDay = "Csütörtök";
            break;
        case "Friday":
            hunDay = "Péntek";
            break;
        case "Saturday":
            hunDay = "Szombat";
            break;
        case "Sunday":
            hunDay = "Vasárnap";
            break;
    }
    return hunDay;
}


       
function showMissingDetails(gradeName, gradeDateTime) {
    var out = '<div class="grade-info"><span class="boldmodaltext">' + gradeName + '</span> igazolást kapott ekkor:</div>';
    out += '<div >' + gradeDateTime + '</div>';
    $('#gradedetailsmodal .modal-body').html(out);
    $('#gradedetailsmodal').modal('show').find('.modal-dialog').slideDown();
}
function showGradeDetails(gradeName, gradeDateTime) {
    //alert(gradeName + " értékelést kapott ekkor:\n" + gradeDateTime);

    var out = '<div class="grade-info"><span class="boldmodaltext">' + gradeName + '</span> értékelést kapott ekkor:</div>';
    out += '<div >' + gradeDateTime + '</div>';
    $('#gradedetailsmodal .modal-body').html(out);
    $('#gradedetailsmodal').modal('show').find('.modal-dialog').slideDown();
}

//<script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
function showGradeDetailsAndAskToEdit(gradeName, gradeDateTime,link) {
    var out = '<div class="grade-info"><span class="boldmodaltext">' + gradeName + '</span> értékelést kapott ekkor:</div>';
    out += '<div >' + gradeDateTime + '</div>';
    $('#gradedetailsWithEditmodal .modal-body').html(out);
    $('#gradedetailsWithEditmodal').modal('show').find('.modal-dialog').slideDown();
    $('#editButton').click(function() {
        window.location.href=link;
      });
  
    //if ( confirm(gradeName + " értékelést kapott ekkor:\n" + gradeDateTime +"\n \nSzeretnéd módosítani? \nOK->folytatás vagy Mégsem->megszakít.") == true) {
    //    window.location.replace(link);
    //} 
}

function showMissingDetailsAndAskToEdit(link) {
    
    var out = '<div class="grade-info"><span class="boldmodaltext">Még nincs igazolva!</span></div>';
    out += '<div > Szeretné módosítani?</div>';
    $('#gradedetailsWithEditmodal .modal-body').html(out);
    $('#gradedetailsWithEditmodal').modal('show').find('.modal-dialog').slideDown();
    $('#editButton').click(function() {
        window.location.href=link;
    });
}

$(document).ready(function() {
    $('#editButton').click(function() {
      $(this).hide(); // Hide the edit button
    });

    $('#gradedetailsWithEditmodal').on('hidden.bs.modal', function() {
      $('#editButton').show(); // Show the edit button when the modal is closed
    });
  });

function AskForCommentText(studentid,homeworkid,text) {

    var out = '<div class="grade-info"><span class="boldmodaltext">Seretné a hozzászólást módosítani?</span></div>';
    $('#gradedetailsWithEditmodal .modal-body').html(out);
    $('#gradedetailsWithEditmodal').modal('show').find('.modal-dialog').slideDown();
    $('#editButton').click(function() {
        if ($('#commentinput').length === 0) {
            var editForm = '<div class="row"><div class="form-group modaledit"><label for="commentinput">Hozzászólás módosítása:</label><input type="text" class="form-control modaledittext" id="commentinput" value="'+text+'"></div>';
            var saveButton = '<button type="button" class="btn btn-secondary btn-savemodal btn-modalgomb" id="saveButton">Mentés</button></div>';
            $('#gradedetailsWithEditmodal .modal-body').append(editForm + saveButton);
    
            $('#saveButton').click(function() {
                var comment = $('#commentinput').val();
                console.log('Edited Grade:', comment);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/tanar/hfkomment/', 
                    method: 'POST',
                    data:
                    {
                        comment,
                        studentid,
                        homeworkid
                    },
                    success: function(response) {
                    console.log('válasz:', response);
                    if (response.status!=0) {
                        alert("hiba: "+response.message);
                    }else
                    {
                        location.reload();
                    }
                    },
                    error: function(xhr, status, error) {
                    // Handle error response from the server
                    alert("hiba: \n"+xhr.responseText)
                    }
                });


              $('#gradedetailsWithEditmodal').modal('hide');
            });
        }
    });
}

