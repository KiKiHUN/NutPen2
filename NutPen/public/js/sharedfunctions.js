
        
function showDetails(DayTimes) 
{
    console.log(DayTimes);
    var out="";
    for(var i = 0; i < DayTimes.length; i++) {
        var endTime=addMinutesToTime(DayTimes[i].Time,DayTimes[i].Lenght);
        out=out+DayNameTranslate(DayTimes[i].Day)+": "+DayTimes[i].Time+"->"+endTime+"\n";
    }
    alert(out);
    
}

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
    alert(gradeName + " igazolást kapott ekkor:\n" + gradeDateTime);
}
function showGradeDetails(gradeName, gradeDateTime) {
    alert(gradeName + " értékelést kapott ekkor:\n" + gradeDateTime);
}

//<script src="{{ asset('/js/sharedfunctions.js') }}" type="text/javascript" defer></script>
function showGradeDetailsAndAskToEdit(gradeName, gradeDateTime,link) {
    if ( confirm(gradeName + " értékelést kapott ekkor:\n" + gradeDateTime +"\n \nSzeretnéd módosítani? \nOK->folytatás vagy Mégsem->megszakít.") == true) {
        window.location.replace(link);
    } 
}

function showMissingDetailsAndAskToEdit(link) {
    if ( confirm("Még nincs igazolva." +"\n \nSzeretnéd módosítani? \nOK->folytatás vagy Mégsem->megszakít.") == true) {
        window.location.replace(link);
    } 
}

function AskForCommentText(studentid,homeworkid) {
    if ( confirm("Szeretnéd módosítani? \nOK->folytatás vagy Mégsem->megszakít.") == true) {
        var comment=prompt("Itt lehet kommentet hozzáfűzni az adott házifeladathoz:");
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
                alert(response.message);
                location.reload();
            }
            },
            error: function(xhr, status, error) {
            // Handle error response from the server
            alert("hiba: \n"+xhr.responseText)
            }
        });
    } 
}