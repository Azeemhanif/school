
//For password eye on login page
$(document).ready(function () {
    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
});



$(document).ready(function () {
    $('#example').DataTable();
});

//For Sweatalert on delete student

$(document).ready(function () {
    $('.delete-confirm').on('click', function (event) {
        event.preventDefault();
        const url = $(this).attr('href');
        swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',

            buttons: ["Cancel", "Yes!"],
        }).then(function (value) {
            if (value) {
                window.location.href = url;
            }
        });
    });
});


//For change student status

$(document).ready(function () {

    var count = 0;
    $("#allcheck").click(function () {
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        if ($(this).prop("checked") == true) {
            count = 1;
        } else {
            count = 0;
        }
    });

    $(".status").change(function () {
        if ($(this).prop('checked')) {
            count = count + 1;
        } else {
            count = count - 1;
        }
    });

    $("#activate").click(function () {
        if (count != 0) {
            $('#stdStatus').empty().val("activate");
            $('#submitBtn').click();
        } else {
            alert('Please select a atleast one record!');
        }

    });

    $("#deactivate").click(function () {
        if (count != 0) {
            $('#stdStatus').empty().val("deactivate");
            $('#submitBtn').click();
        } else {
            alert('Please select a atleast one record!');
        }
    });
    $("#delete").click(function () {
        if (count != 0) {
            $('#stdStatus').empty().val("delete");
            $('#submitBtn').click();
        } else {
            alert('Please select a atleast one record!');
        }


    });

});
