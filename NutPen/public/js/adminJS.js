$('.filterbtn').click(function() {
    window.location = '/admin/felhasznalok/' + $(this).attr("value");
});


$('#SaveBannBTN').click(function() {
    if (banneds.length==0) {
        alert("Nincs mit módosítani");
        return;
    }
    let json = JSON.stringify(banneds);

    console.log(json);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/admin/kitiltasmodositas', 
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
            banneds.length = 0
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


  $(document).ready(function() {
    
    $('.day-checkbox').change(function() {
        var day = $(this).data('day');
        var timePicker = $('.time-picker[data-day="' + day + '"]');
        if ($(this).prop('checked')) {
          timePicker.prop('disabled', false);
        } else {
          timePicker.prop('disabled', true);
        }
      });

    if( $('#teacher').length )         // use this if you are using id to check
    {
        $("#teacher").select2({         //https://phppot.com/jquery/dropdown-with-search-using-jquery/
       
        });
    }
    if( $('#subjects').length )         // use this if you are using id to check
    {
        $("#subjects").select2({         //https://phppot.com/jquery/dropdown-with-search-using-jquery/
       
        });
    }
    if( $('#studentID').length )         // use this if you are using id to check
    {
        $("#studentID").select2({         //https://phppot.com/jquery/dropdown-with-search-using-jquery/
       
        });
    }
    if( $('#classID').length )         // use this if you are using id to check
    {
        $("#classID").select2({         //https://phppot.com/jquery/dropdown-with-search-using-jquery/
       
        });
    }

    if( $('#role').length )         // use this if you are using id to check
    {
        var additionalAttributes = $('#additional-attributes').data('attributes');
      
        // Define the additional fields for each role
        const additionalFields = {
            Diák: [
                { id:'bPlace', name: 'Születéshely', type: 'text', defaultValue: '' },
                { id:'studentCardNum',name: 'Diákigazolvány szám', type: 'number', defaultValue: '' },
                { id:'studentTeachID',name: 'Tanítási azonosító', type: 'number', defaultValue: '' },
                { id:'remainingVerifications',name: 'Fennmaradó igazolások száma', type: 'number', defaultValue: 3 }
                ],
            Tanár: [
                { id:'teachID', name: 'Tanítási azonosító', type: 'number', defaultValue: '' }
                ]
        };
        
       
    // Function to update additional fields based on selected role
    function updateAdditionalFields() {
        var selectedRole = $('#role option:selected').text();
        var fields = additionalFields[selectedRole];

        if (additionalAttributes!=null) {
            // Update additionalFields with received values if not empty
           Object.keys(additionalAttributes).forEach(key => {
               const value = additionalAttributes[key];
                   const field = fields.find(f => f.id === key);
                   if (field) {
                       field.defaultValue = value;
                   }
           });
       }
        // Clear previous additional fields
        $('#additional-fields').empty();
        if (fields) {
            for (let index = 0; index < fields.length; index++) {
                var inputType = (fields[index].type === 'number') ? 'number' : 'text';
                $('#additional-fields').append(
                    '<div class="inputcolumn">'+
                        '<label for="lname">'+fields[index].name+': </label>'+
                        '<input type="'+inputType+'" class="textfield" id="aditional'+index+'" name="aditional'+index+'" value="' + fields[index].defaultValue + '" required>'+
                    '</div>'
                );
            }
        }
       
       
    }

    // Listen for changes in the select options box
    $('#role').change(function() {
        updateAdditionalFields();
    });

    // Initially update additional fields based on the selected role
    updateAdditionalFields();
    }
   
   
});

$('#SaveBannerBTN').click(function() {
    var selectedBanner = $('input[type="radio"].CHK_bannerEN:checked');
    var banningId=null;
    if(selectedBanner.length > 0) {
        banningId = selectedBanner.attr('banningid');
    } 
    if (banningId==null) {
        alert("Nincs ID kiválasztva");
        return;
    }
    console.log(banningId);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/admin/bannervalasztas', 
        method: 'POST',
        data: {
            banningId 
        },
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
$('#SaveBannerHeadUserBTN').click(function() {
    var selectedBanner = $('input[type="radio"].CHK_bannerEN:checked');
    var banningId=null;
    if(selectedBanner.length > 0) {
        banningId = selectedBanner.attr('banningid');
    } 
    if (banningId==null) {
        alert("Nincs ID kiválasztva");
        return;
    }
    console.log(banningId);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/fo/bannervalasztas', 
        method: 'POST',
        data: {
            banningId 
        },
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