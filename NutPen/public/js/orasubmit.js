$( document ).ready(function() {
    document.getElementById("tanar").value=document.getElementById("tanarok").value;
    var e = document.getElementById("tantargyak");
    var text = e.options[e.selectedIndex].text;
    document.getElementById("tantargy").value=text;
});
function selectedChanged(i)
{
   switch (i) {
    case 0:
        document.getElementById("tanar").value=document.getElementById("tanarok").value;
        break;
    case 1:
        var e = document.getElementById("tantargyak");
        var text = e.options[e.selectedIndex].text;
        document.getElementById("tantargy").value=text;
        break;
   }
};
