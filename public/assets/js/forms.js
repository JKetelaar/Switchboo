$(document).ready(function () {



    $(document).on('click tap touchstart', '#quote_step_one_energySupplier', function (e) {
        $('#hiddenImageSelection').val(null);
        let children = $(this).closest('.question-row').find('.supplier-image');
        $(children).removeClass("active");
    });

    /*
     * FORM-1
     * supplier buttons
     */
    $(document).on('click tap touchstart', '.supplier-image', function (e) {

        let children = $(this).closest('.question-row').find('.supplier-image');

        $('#hiddenImageSelection').val('asd');
        $('#quote_step_one_energySupplier').val(null);

        $(children).removeClass("active");

        $(this).addClass("active");

    });


    /*
     * FORM-1
     * plan select or not sure
     */
    $("#plan-select").change(function () {
        if ($(this).val().length > 0) {
            $("#plan-circle").find(".round-button-circle").removeClass("active");
        }
    });

    $(document).on('click tap touchstart', '#plan-circle .round-button-circle', function (e) {
        $("#plan-select").val("").change();
    });


    /*
     * FORM-1-4
     * circle buttons
     */
    $(document).on('click tap touchstart', '.round-button-circle', function (e) {

        var children = $(this).closest('.form-check').find('.round-button-circle');

        $(children).removeClass("active");
        $(this).addClass("active");

    });


    /*
     * FORM-3
     * supplier list select
     */
    $(document).on('click tap touchstart','.result-row',function(e) {

        $("#form-control").find(".result-row").removeClass("active");

        $(this).addClass("active");

    });


    $(document).on('click tap touchstart', '#view-more', function (e) {

        $(".hidden").removeClass("hidden");
        $("#view-more").addClass("hidden");

    });


});
