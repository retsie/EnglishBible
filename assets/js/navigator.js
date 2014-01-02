$(function(){

     $("#bookBtn").click(function(){
           $("#bookList").html(preBook);
           $("#chapter").html(preChapter);
           $(".book").slideDown(); 
           $("#bookOverlay").show(); 
           loadBookList(); 
     });

     $("#bookOverlay").click(function(){
          $(".book").slideUp(); 
           $("#bookOverlay").hide();
     });

      $("#searchBtn").click(function(){
           $(".search").slideDown(); 
           $("#searchOverlay").show();  
     });
     $("#all").click(function(){
           testament = "all";
           if($("#inputSearch").val() != ""){
               searchPhrase($("#inputSearch").val());
           } 
     });
     $("#old").click(function(){
           testament = "old";
            if($("#inputSearch").val() != ""){
               searchPhrase($("#inputSearch").val());
           } 
     });
     $("#new").click(function(){
           testament = "new";
            if($("#inputSearch").val() != ""){
               searchPhrase($("#inputSearch").val());
           }  
     });

     $("#search").click(function(){
          searchPhrase($("#inputSearch").val());
     });

     $("#searchOverlay").click(function(){
          $(".search").slideUp(); 
           $("#searchOverlay").hide();
     });
     

     $("#chapter").click(function(){
          if(tempBookId){
           loadChapter(tempBookId, tempBookName); 
           }
     });

     $("#bookList").click(function(){
       loadBookList();
     });

     $("#verse").click(function(){
          if(tempChapId){
           loadVerse(tempChapId);
           } 
     });

     $("#back").click(function(){
           loadBack(); 
     });

     $("#forward").click(function(){
           loadForward(); 
     });

     $("#getBible").click(function(){
           loadBible(); 
     });

     initialVerse();

});


