$( document ).ready(function() {
    $.get("/GetLoginBanner", function(data, status){
        const obj = JSON.parse(data);
        console.log(obj);
        if (obj!=null) {
          $( ".Banner" ).append("<div id='BannerContent'></div>");
          $( "#BannerContent" ).append("<h1 class='BannerHead'>"+obj.header+"</h1>");
          $( "#BannerContent" ).append("<h3 class='BannerDesc'>"+obj.description+"</h3>");
          $( "#BannerContent" ).append("<img class='BannerIMG' src='"+obj.file+"'></img>");
        }
       
      });

});
