
$(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip()
        $('.view-button').click(function () {
            let row = $(this).closest('tr');
            $('#modal-title').text(row.find('td:eq(0)').text());
            $('#modal-firstname').text(row.find('td:eq(1)').text());
            $('#modal-lastname').text(row.find('td:eq(2)').text());
            $('#modal-email').text(row.find('td:eq(3)').text());
            $('#modal-contactnumber').text( row.find('td:eq(4)').text());
            $('#modal-address').text(row.find('td:eq(5)').text());
        });
        $('#cancel-edit').click(function () {
            $('.edit-contact').hide();
            $('.create-contact').show();
        });
        $(".edit-button").click(function () {
            $('.create-contact').hide();
            $('.edit-contact').show();
            $("body").scrollTop(0);
            let currentRow = $(this).closest("tr");
            $("#edit-title").val(currentRow.find("td:eq(0)").text());
            $("#edit-firstname").val(currentRow.find("td:eq(1)").text());
            $("#edit-lastname").val(currentRow.find("td:eq(2)").text());
            $("#edit-email").val(currentRow.find("td:eq(3)").text());
            $("#edit-contactnumber").val(currentRow.find("td:eq(4)").text());
            $("#edit-address").val(currentRow.find("td:eq(5)").text());
            $("#edit-description").val(currentRow.find("td:eq(6)").text());
            $("#edit-contact-id").val(currentRow.find(".edit-button").data("contact-id"));
        });
        $("#submit-edit").click(function (e) {
            e.preventDefault();
            let formData = $("#edit-form").serialize();
            let title = $("#edit-title").val();
            let firstname = $("#edit-firstname").val();
            let lastname = $("#edit-lastname").val();
            let email = $("#edit-email").val();
            let contactnumber = $("#edit-contactnumber").val();
            let address = $("#edit-address").val();
            $(".validation-message").remove();
            if (title.trim() === "") {
                $("#edit-title").after('<span class="validation-message">Title cannot be blank.</span>');
            }
            if (firstname.trim() === "") {
                $("#edit-firstname").after('<span class="validation-message">First Name cannot be blank.</span>');
            }
            if (lastname.trim() === "") {
                $("#edit-lastname").after('<span class="validation-message">Last Name cannot be blank.</span>');
            }
            if (email.trim() === "") {
                $("#edit-email").after('<span class="validation-message">Email cannot be blank.</span>');
            }
            if (address.trim() === "") {
                $("#edit-address").after('<span class="validation-message">Address cannot be blank.</span>');
            }

            let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (!emailPattern.test(email)) {
                $("#edit-email").after('<span class="validation-message">Please enter a valid email address.</span>');
            }
            if (!$.isNumeric(contactnumber)) {
                $("#edit-contactnumber").after('<span class="validation-message">Contact Number must be a valid number.</span>');
            }
            if (title.trim() !== "" && firstname.trim() !== "" && lastname.trim() !== "" && emailPattern.test(email) && $.isNumeric(contactnumber) && address.trim() !== "") {
                $.ajax({
                    url: '/contact/information/list',
                    method: 'POST',
                    data: {
                        'data': formData
                    },
                    success: function (data) {
                        location.reload();
                    },
                    error: function (error) {

                    }
                });

            }
        });
    }
)
;
