$( document ).ready(function() {
    
    
    
    
    
    /*
     * FORM-1
     * question one buttons
     */   
    $(document).on('click','.type-button',function(e) {     
        
        var children = $(this).closest('.question-row').find('.type-button');
        
        $(children).removeClass("active");

        $(this).addClass("active");
        
    });
    
    
    /*
     * FORM-1
     * supplier buttons
     */   
    $(document).on('click','.supplier-image',function(e) {     
        
        var children = $(this).closest('.question-row').find('.supplier-image');
        
        $(children).removeClass("active");

        $(this).addClass("active");
        
    });
    
    
    
    
    /*
     * FORM-1
     * plan select or not sure
     */   
    $( "#plan-select" ).change(function() {
        if ($(this).val().length > 0) {
            $("#plan-circle").find(".round-button-circle").removeClass("active");
        }
    });
    
    $(document).on('click','#plan-circle .round-button-circle',function(e) { 
        $("#plan-select").val("").change();
    });
    
    
    
    
    
    /*
     * FORM-1-4
     * circle buttons
     */   
    $(document).on('click','.round-button-circle',function(e) {     
        
        var children = $(this).closest('.question-row').find('.round-button-circle');
        
        $(children).removeClass("active");

        $(this).addClass("active");
        
    });
    
    
    
    /*
     * FORM-3
     * supplier list select
     */   
    $(document).on('click','.result-row',function(e) {     
        
        $("#form-control").find(".column-price-button").removeClass("active");
        
        $(this).find(".column-price-button").addClass("active");
        
    });
    
    
    $(document).on('click','#view-more',function(e) {     
        
        $(".hidden").removeClass("hidden");
        $("#view-more").addClass("hidden");
        
    });
    
    

    
    
    
    
    
    
});