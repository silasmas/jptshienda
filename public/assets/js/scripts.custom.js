/**
 * Custom scripts
 * 
 * @author Xanders Samoth
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
/* Necessary headers for APIs */
// var headers = {'Authorization': 'Bearer ' + $('#custom-style').attr('blp-api-token'), 'Accept': 'application/json', 'X-localization': navigator.language};

$(document).ready(function () {
    /* Return false when click on "#" link */
    $('[href="#"]').on('click', function (e) {
        return false;
    });

    $('.back-to-top').click(function (e) {
        $("html, body").animate({ scrollTop: "0" });
    });

    /* Multiline text truncation */
    $('.paragraph-ellipsis').multilineTruncation('.paragraph2', 2, '.roll-block a');
    $('.paragraph-ellipsis').multilineTruncation('.paragraph3', 3, '.roll-block a');
    $('.paragraph-ellipsis').multilineTruncation('.paragraph4', 4, '.roll-block a');
    $('.paragraph-ellipsis').multilineTruncation('.paragraph5', 5, '.roll-block a');

    /* Animate number counter */
    $('.counter').animateCounter(4000);

    /* Upload news/user cropped photo */
    var modal1 = $('#cropModal1');
    var retrievedAvatar = document.getElementById('retrieved_image1');
    var cropper;

    $('#avatar').on('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            retrievedAvatar.src = url;
            var modal = new bootstrap.Modal(document.getElementById('cropModal1'), {
                keyboard: false
            });

            modal.show();
        };

        if (files && files.length > 0) {
            var reader = new FileReader();

            reader.onload = function () {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $(modal1).on('shown.bs.modal', function () {
        cropper = new Cropper(retrievedAvatar, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '#cropModal1 .preview'
        });

    }).on('hidden.bs.modal', function () {
        cropper.destroy();

        cropper = null;
    });

    $('#cropModal1 #crop').click(function () {
        // Ajax loading image to tell user to wait
        $('.user-image').attr('src', currentHost + '/assets/img/ajax-loading.gif');

        var canvas = cropper.getCroppedCanvas({
            width: 700,
            height: 700
        });

        canvas.toBlob(function (blob) {
            URL.createObjectURL(blob);
            var reader = new FileReader();

            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64_data = reader.result;
                var entity_id = document.getElementById('user_id').value;
                var apiUrl = currentHost + '/api/user/update_avatar_picture/' + parseInt($('#userId').val());
                var datas = JSON.stringify({ 'id': parseInt($('#userId').val()), 'user_id': entity_id, 'image_64': base64_data });

                modal1.hide();

                $.ajax({
                    headers: headers,
                    type: 'PUT',
                    contentType: 'application/json',
                    url: apiUrl,
                    dataType: 'json',
                    data: datas,
                    success: function (res) {
                        $(this).attr('src', res);
                        window.location.reload();
                    },
                    error: function (xhr, error, status_description) {
                        console.log(xhr.responseJSON);
                        console.log(xhr.status);
                        console.log(error);
                        console.log(status_description);
                    }
                });
            };
        });
    });

    /* Auto-resize textarea */
    autosize($('textarea'));

    /* jQuery Date picker */
    var currentLanguage = $('html').attr('lang');

    $('#register_birthdate').datepicker({
        dateFormat: currentLanguage.startsWith('fr') ? 'dd/mm/yy' : 'mm/dd/yy',
        onSelect: function () {
            $(this).focus();
        }
    });

    /* On select change, update de country phone code */
    $('#select_country1').on('change', function () {
        var countryPhoneCode = $(this).val();

        $('#phone_code_text1 .text-value').text(countryPhoneCode);
        $('#phone_code1').val(countryPhoneCode);
    });
    $('#select_country2').on('change', function () {
        var countryPhoneCode = $(this).val();

        $('#phone_code_text2 .text-value').text(countryPhoneCode);
        $('#phone_code2').val(countryPhoneCode);
    });
    $('#select_country3').on('change', function () {
        var countryPhoneCode = $(this).val();

        $('#phone_code_text3 .text-value').text(countryPhoneCode);
        $('#phone_code3').val(countryPhoneCode);
    });

    /* On select, show/hide some blocs */
    // IDENTITY DOC DESCRIPTION
    $('#register_image_name').on('change', function () {
        if ($('#register_image_name option').filter(':selected').text() == 'Autre' || $('#register_image_name option').filter(':selected').text() == 'Other') {
            $('#docDescription').removeClass('d-none');

        } else {
            $('#docDescription').addClass('d-none');
        }
    });

    /* On check, show/hide some blocs */
    // OFFER TYPE
    $('#donationType .form-check-input').each(function () {
        $(this).on('click', function () {
            if ($('#anonyme').is(':checked')) {
                $('#donorIdentity, #otherDonation').addClass('d-none');

            } else {
                $('#donorIdentity, #otherDonation').removeClass('d-none');
            }
        });
    });
    // TRANSACTION TYPE
    $('#paymentMethod .form-check-input').each(function () {
        $(this).on('click', function () {
            if ($('#bank_card').is(':checked')) {
                $('#phoneNumberForMoney').addClass('d-none');

            } else {
                $('#phoneNumberForMoney').removeClass('d-none');
            }
        });
    });

    /* Hover stretched link */
    $('.card-body + .stretched-link').each(function () {
        $(this).hover(function () {
            $(this).addClass('changed');

        }, function () {
            $(this).removeClass('changed');
        });
    });

    /* Mark all notifications as read */
    $('#markAllRead').click(function (e) {
        e.preventDefault();

        $.ajax({
            headers: headers,
            type: 'PUT',
            contentType: 'application/json',
            url: currentHost + '/api/notification/mark_all_read/' + parseInt($(this).attr('data-user-id')),
            success: function () {
                window.location.reload();
            },
            error: function (xhr, error, status_description) {
                console.log(xhr.responseJSON);
                console.log(xhr.status);
                console.log(error);
                console.log(status_description);
            }
        });
    });

    /* Run an ajax function every second */
    // setInterval(function () {
    // }, 1000);
});
