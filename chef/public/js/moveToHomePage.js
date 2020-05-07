       function moveToHomePage(t){
         jQuery(document).ready(function(){
               $.ajaxSetup({
                  headers: {
                      'Authorization':'Bearer ' + t,
                      'Content-Type':"application/json",
                      'Accept':'application/json',
                  }
              });
               jQuery.ajax({
                  url: '/api/home',
                  method: 'get', 
               });
            });
       }