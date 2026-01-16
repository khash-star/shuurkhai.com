//contact us form
$(".contact_btn").on('click', function () {
    //disable submit button on click
    // $(".contact_btn").attr("disabled", "disabled");
    // $(".contact_btn b").text('Sending');
    $(".contact_btn i").removeClass('d-none');

    //simple validation at client's end
    var post_data, output;
    var proceed = "true";
    // var allBlank;

    var str = $('#contact-form-data').serializeArray();

    $('#contact-form-data input').each(function() {
        if(!$(this).val()){
            // alert('Some fields are empty');
            proceed = "false";
        }
    });

    if (proceed == "true") {

        var accessURL =  "views/contact-mailer.php";
        //data to be sent to server
        $.ajax({
            type: 'POST',
            // url: 'vendor/contact-mailer.php',
            url: accessURL,
            data: str,
            success: function (response) {
                    output = '<div class="alert-success" style="padding:10px 15px; margin-bottom:30px;">' + response + '</div>';
                    //reset values in all input fields
                    $('.contact-form input').val('');
                    $('.contact-form textarea').val('');
                if ($("#result").length) {
                    // alert("yes");
                    $("#result").hide().html(output).slideDown();
                    $(".contact_btn i").addClass('d-none');
                
                }
            },
            error: function () {
                alert("Failer");
            }
        });

    }
});