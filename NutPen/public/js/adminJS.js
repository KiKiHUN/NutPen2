$('.filterbtn').click(function() {
    window.location = '/felhasznalok/' + $(this).attr("value");
});
$('#SaveBannBTN').click(function() {
    let json = JSON.stringify(banneds);

    console.log(json);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/kitiltasmodositas', 
        method: 'POST',
        contentType: 'application/json',
        data: json,
        success: function(response) {
        console.log('válasz:', response);
        if (response.status!=0) {
            alert("hiba: "+response.message);
        }else
        {
            alert(response.message);
        }
        },
        error: function(xhr, status, error) {
        // Handle error response from the server
        alert("hiba: \n"+xhr.responseText)
        }
    });
});

let banneds=[];

$('.CHK_IDbanning').click(function() {
    
    var found =false;
    var ind=-1;
    for (let index = 0; index < banneds.length; index++) {
        const element = banneds[index];
        if (element.ID==$(this).attr("banningid")) {
            found=true;
            ind=index;
        }  
    }
    var $row = $(this).closest('tr');
    if (found) {
        banneds[ind].IDBanned=$(this).is(':checked');
        if (($(this).val()==banneds[ind].IDBanned)&&($row.find('.CHK_IPbanning').val()==banneds[ind].IPBanned)) {
            banneds.splice(ind, 1);
        }
    }else
    {
        var isCheckedIP = $row.find('.CHK_IPbanning').is(':checked');
        let newbann = 
        {
            "ID": $(this).attr("banningid"),
            "IDBanned": $(this).is(':checked'),
            "IPBanned": isCheckedIP,
        }
        banneds.push(newbann);
    }
    
});
$('.CHK_IPbanning').click(function() {
    
    var found =false;
    var ind=-1;
    for (let index = 0; index < banneds.length; index++) {
        const element = banneds[index];
        if (element.ID==$(this).attr("banningid")) {
            found=true;
            ind=index;
        }  
    }
    var $row = $(this).closest('tr');
    if (found) {
        banneds[ind].IPBanned=$(this).is(':checked');
        if (($(this).val()==banneds[ind].IPBanned)&&($row.find('.CHK_IDbanning').val()==banneds[ind].IDBanned)) {
            banneds.splice(ind, 1);
        }
       
    }else
    {
        var isCheckedID = $row.find('.CHK_IDbanning').is(':checked');
        let newbann = 
        {
            "ID": $(this).attr("banningid"),
            "IDBanned": isCheckedID,
            "IPBanned": $(this).is(':checked'),
        }
        banneds.push(newbann);
    }
    
});