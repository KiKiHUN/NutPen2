
function disableBTN(ID, maxperc=null) {
    if (document.getElementById('nmb_'+ID).disabled) {
        a = document.getElementById('nmb_'+ID);
        a.disabled = false;
        a.value = null;
    } else {
        a = document.getElementById('nmb_'+ID);
        a.disabled = true;
        a.value = maxperc;
    }
}
var list = [];
function listahozad(id) {
    if (document.getElementById("nmb_" + id).value != 0 && document.getElementById("nmb_" + id).value != null) {
        if (!checkinside(id)) {
            list.push(id);
            console.log("hozzáadva: " + id);
        }
    } else {
        if (checkinside(id)) {
            const index = list.indexOf(id);
        const x = list.splice(index, 1);
        console.log("törölve: " + x);
        }

    }
}
function listatorol(id) {
    if (document.getElementById("nmb_" + id).value != 0 && document.getElementById("nmb_" + id).value != null) {
        if (checkinside(id)) {
            const index = list.indexOf(id);
            const x = list.splice(index, 1);
            console.log("törölve: " + x);
            document.getElementById("nmb_" + id).value=null;
            if(document.getElementById("chk_"+id).checked==true)
            {
                disableBTN(id);
                document.getElementById("chk_"+id).checked=false;
            }


        }
    } else {
        if (checkinside(id)) {
        const index = list.indexOf(id);
        const x = list.splice(index, 1);
        console.log("törölve: " + x);
        }
    }
}
function checkinside(id) {
    for (let index = 0; index < list.length; index++) {
        if (id == list[index]) {
            return true;
        }
    }
    return false;
}
function kuldes() {
    var kilista = [];
    list.forEach(element => {
        segedlista={
            azonosito: element,
            kesettperc: document.getElementById("nmb_"+element).value,
            diakTanoraID: document.getElementById("id_"+element).value
        }
        kilista.push(segedlista);
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
     jQuery.ajax({
        url: "/hianyzas/tarolas",
        method: 'POST',
        data:
        {
           adatok: JSON.stringify(kilista)
        }
        ,
        success: function(result){
           console.log(result);
           if(result=="akurvaeletmukodik")
           {
            alert("Sikeres bevitel.");
            window.location.href = "/hianyzas";
           }
           if(result=="hatbazdmegvalamirossz")
           {
            alert("Sikertelen bevitel.");
           }
        },
        error:function(result){
            console.log("Hát itt valami nem jó: "+result);
         }});
}
