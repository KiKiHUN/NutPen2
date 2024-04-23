$(document).ready(function() {

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
        var selectedRole = $('#role').attr("value");
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
                        ' <p class="text-white mt-5 mb-5">'+fields[index].name+': '+
                        '<b>' + fields[index].defaultValue + ' </b>'+
                    '</p>'
                );
            }
        }
       
       
    }
    
    updateAdditionalFields();
    }


});
