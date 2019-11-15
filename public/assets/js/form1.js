$(document).ready(function () {


    /*
     * user for hiding/showing elements based on form-1 buttons
     * {ID : element class}*
    */

    const element_obj = {
        gasonly: ".gas-supplier",
        gasandelectricity: ".gas-and-electricity",
        electricityonly: ".electricity-supplier"

};



    /*
     * FORM-1
     * rectangle
     */
    $(document).on('click tap touchstart', '.type-button', function (e) {

        let children = $(this).closest('.form-check').find('.type-button');

        $(children).removeClass("active");

        $(this).addClass("active");
    });


    $('#gas-and-electricity, #gas-only, #electricity-only').change(function() {

        //define which element is now selected and remove the dashes
        let element_id = $(this).attr('id').replace(/-/g, '');

        $.each(element_obj, function (key, value) {

            if (key === element_id) {
                console.log("showing: " + value)
                $(value).removeClass('hide-element');
                $(value).addClass('show-element');
            } else {
                console.log("hiding: " + value);
                $(value).removeClass('show-element');
                $(value).addClass('hide-element');
            }
        });

    });




        $('[name="quote_step_one[sameSupplier]"]').change(function(){

            //define which element is now selected and remove the dashes
            let data_id = $(this).attr('data-id');

            if (data_id === "yes") {
                $('.gas-and-electricity').addClass("show-element").removeClass('hide-element')
                $('.electricity-supplier').addClass("hide-element").removeClass('show-element')
                $('.gas-supplier').addClass("hide-element").removeClass('show-element')
            } else {
                $('.gas-and-electricity').addClass("hide-element").removeClass('show-element')
                $('.electricity-supplier').addClass("show-element").removeClass('hide-element')
                $('.gas-supplier').addClass("show-element").removeClass('hide-element')
            }
            $('.dual-fuel').removeClass('hide-element').addClass('show-element');

    });







});