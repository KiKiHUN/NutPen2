
$(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
    $('#dtBasicExample').dataTable( {
        order: [[0, 'desc']],
        "language": {
          "search": "Keresés:",
          "lengthMenu": " _MENU_ elem megjelenítése",
          "info": "_START_--_END_, összesen: _TOTAL_",
          "emptyTable": "Úgy tűnik üres a tábla :(",
        }
      } );
  });


