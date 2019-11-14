

function shakeForm() {
     
}



$( document ).ready(function() {
    
    
    $(document).on('click','.to-top',function(e) {     
        $('html, body').animate({scrollTop: $("#reg-form").offset().top}, 1200, function() {
            $("#form-container").effect( "shake", {times:1, distance:2}, 1500 );
        });      
    });





    
    
    
});