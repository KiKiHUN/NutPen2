
        
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

    $('.calendarbutton').click(function() {
      getevents();
    });
    $('.calendarStudFiltbutton').click(function() {
      let studid=$(this).attr("value"); // Hide the edit button
     getFilteredToStudentevents(studid);
    });
    $('.calendarLesFiltbutton').click(function() {
      let lesid=$(this).attr("value"); // Hide the edit button
      getlesssoncalendar(lesid);
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

function fillevents(eventdata)
{ 
    moment.locale('hu');
    var now = moment();
  console.log(now.startOf('week').add(9, 'h').format('X'));
    /**
     * M any events
     */
    let events = [];
    events = eventdata.map(function(event) {
        return {
            start: event.start,
            end: event.end,
            title: event.title,
            content: event.content,
            category: event.category
        };
    });
   

    /**
     * A daynote
     */
    var daynotes = [
     /* {
        time: now.startOf('week').add(60, 'h').add(30, 'm').format('X'),
        title: 'Leo\'s holiday',
        content: 'yo',
        category: 'holiday'
      }*/
    ];

    /**
     * Init the calendar
     */
    var calendar = $('#calendar').Calendar({
      locale: 'hu',
      defaultView: {
            largeScreen:'week',
            smallScreen:'week',
            smallScreenThreshold: 1000
          },
        
      weekday: {
        timeline: {
          intervalMinutes: 60,
          fromHour: 6,
          format:'HH:mm'
          
        },
        dayline: {
                weekdays: [0, 1, 2, 3, 4, 5, 6],
                format:'dddd MM/DD',
                heightPx: 40,
                month: {
                  format:'YYYY MMMM',
                  heightPx: 30,
                  weekFormat:'w'
                }
              }
          
      },
      month: 
      {
          format:'YYYY MMMM',
          heightPx: 31,
          weekline: {
              format:'w',
              heightPx: 80
          },
          dayheader: {
              weekdays: [0, 1, 2, 3, 4, 5, 6],
              format:'dddd',
              heightPx: 30
          },
          day: {
              format:'MM/DD'
          }
      },
      
        

          
      events: events,
      daynotes: daynotes
    }).init();

    /**
     * Listening for events
     */

    $('#calendar').on('Calendar.init', function(event, instance, before, current, after){
      console.log('event : Calendar.init');
      console.log(instance);
      console.log(before);
      console.log(current);
      console.log(after);
    });
    $('#calendar').on('Calendar.daynote-mouseenter', function(event, instance, elem){
      console.log('event : Calendar.daynote-mouseenter');
      console.log(instance);
      console.log(elem);
    });
    $('#calendar').on('Calendar.daynote-mouseleave', function(event, instance, elem){
      console.log('event : Calendar.daynote-mouseleave');
      console.log(instance);
      console.log(elem);
    });
    $('#calendar').on('Calendar.event-mouseenter', function(event, instance, elem){
      console.log('event : Calendar.event-mouseenter');
      console.log(instance);
      console.log(elem);
    });
    $('#calendar').on('Calendar.event-mouseleave', function(event, instance, elem){
      console.log('event : Calendar.event-mouseleave');
      console.log(instance);
      console.log(elem);
    });
    $('#calendar').on('Calendar.daynote-click', function(event, instance, elem, evt){
      console.log('event : Calendar.daynote-click');
      console.log(instance);
      console.log(elem);
      console.log(evt);
    });
    $('#calendar').on('Calendar.event-click', function(event, instance, elem, evt){
      console.log('event : Calendar.event-click');
      console.log(instance);
      console.log(elem);
      console.log(evt);
    });
    $('#calendarmodal').modal('show').find('.modal-dialog').slideDown();
}

function getevents()
{
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url: '/naptar', 
    method: 'GET',
    success: function(response) {
    console.log('válasz:', response);
    if (response.status!=0) {
        alert("hiba: "+response.message);
    }else
    {
        let eventdata=JSON.parse(response.data);
        fillevents(eventdata);
            
    }
    },
    error: function(xhr, status, error) {
    // Handle error response from the server
    alert("hiba: \n"+xhr.responseText)
    }
});
}
function getFilteredToStudentevents(studid)
{
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
      url: '/naptar/diak/'+studid, 
      method: 'GET',
      success: function(response) {
      console.log('válasz:', response);
      if (response.status!=0) {
          alert("hiba: "+response.message);
      }else
      {
          let eventdata=JSON.parse(response.data);
          fillevents(eventdata);
              
      }
      },
      error: function(xhr, status, error) {
      // Handle error response from the server
      alert("hiba: \n"+xhr.responseText)
      }
  });
}
function getlesssoncalendar(lessonid)
{
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    url: '/naptar/tanorak/'+lessonid, 
    method: 'GET',
    success: function(response) {
    console.log('válasz:', response);
    if (response.status!=0) {
        alert("hiba: "+response.message);
    }else
    {
        let eventdata=JSON.parse(response.data);
        fillevents(eventdata);
            
    }
    },
    error: function(xhr, status, error) {
    // Handle error response from the server
    alert("hiba: \n"+xhr.responseText)
    }
});
}