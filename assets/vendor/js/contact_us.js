//contact us form
$(".contact_btn").on('click', function () {
    // Check if user is logged in
    if (typeof isLoggedIn !== 'undefined' && !isLoggedIn) {
        // User is not logged in, show alert and redirect to login page
        var alertMsg = '<div class="alert-warning" style="padding:15px; margin-bottom:20px; border:1px solid #ffc107; background-color:#fff3cd; color:#856404; border-radius:5px;">' +
                       '<strong>Анхааруулга:</strong> Та нэвтэрсэний дараа зурвас илгээнэ үү. Нэвтрэх хуудас руу шилжүүлж байна...' +
                       '</div>';
        
        if ($("#result").length) {
            $("#result").hide().html(alertMsg).slideDown();
        } else {
            alert("Та нэвтэрсэний дараа зурвас илгээнэ үү. Нэвтрэх хуудас руу шилжүүлж байна...");
        }
        
        // Redirect to login page after 2 seconds
        setTimeout(function() {
            window.location.href = '/shuurkhai/user/';
        }, 2000);
        
        return false;
    }

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

    $('#contact-form-data textarea').each(function() {
        if(!$(this).val()){
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
                    
                    // Redirect to login page after 2 seconds
                    setTimeout(function() {
                        window.location.href = '/shuurkhai/user/';
                    }, 2000);
                }
            },
            error: function () {
                alert("Failer");
            }
        });

    }
});