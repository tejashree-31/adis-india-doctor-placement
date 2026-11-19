// ========================= 12-11-2025 ===================================

$(document).ready(function () {
    $("#final_agreement").on("input blur", function () {
      // alert("hello");
        let value = $(this).val().trim();
        let regex = /^[0-9]*\.?[0-9]*$/; // allows numbers and one decimal point

        if (value === "") {
            $("#agreementError").text("Final Agreement is required");
        } else if (!regex.test(value)) {
            $("#agreementError").text("Only numbers and decimals are allowed");
            // remove invalid characters
            $(this).val(value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1'));
        } else {
            $("#agreementError").text("");
        }
    });
    
    
      $("#advanced_payment").on("input blur", function () {
        let value = $(this).val().trim();

        if (value === "") {
            $("#advance_payment_Error").text("Final advanced_payment is required");
        } else if (!/^[0-9]+$/.test(value)) {
            $("#advance_payment_Error").text("Only numbers are allowed");
        } else {
            $("#advance_payment_Error").text("");
        }
    });
    
     $("input[name='company_regis_type']").on("change", function () {

        if ($("#radio_paid").is(":checked")) {
            $("#paid_input_box").show();   // show input box
        } else {
            $("#paid_input_box").hide();   // hide input box
        }

    });
 
});

  document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".addr-toggle").forEach(function (btn) {

        btn.addEventListener("click", function () {

            let td = this.closest("td");
            let short = td.querySelector(".addr-short");
            let full = td.querySelector(".addr-full");

            if (full.classList.contains("d-none")) {
                full.classList.remove("d-none");
                short.classList.add("d-none");
                this.textContent = "Less";
            } else {
                full.classList.add("d-none");
                short.classList.remove("d-none");
                this.textContent = "More";
            }

        });

    });

});


// ======================== Sent Invoice ================================

$(document).ready(function () {

    $(document).on('change', '.send_email', function () {

        let job_status_id = $(this).data('job_status_id'); 
        let status = $(this).is(':checked') ? 1 : 0;
        // alert(status);
        $.ajax({
            url: updateEmailStatus,
            type: "POST",
            data: {
                job_status_id: job_status_id,
                send_email: status
            },
            success: function (response) {

                // Show success message
                $("#updateSuccessMsg").fadeIn().delay(1000).fadeOut();

                // Reload page after small delay
                setTimeout(function () {
                    location.reload();
                }, 1200);  
            }
        });

    });
    
});

$(document).ready(function () {
    
    $(document).on('change', '.send_email_recived_client_payment', function () {

    let checkbox = $(this);
    let job_status_id = checkbox.data('job_status_id');
    let status = checkbox.is(':checked') ? 1 : 0;

    // Confirmation box
    let msg = status == 1 
        ? "Are you sure? You want to mark this Payment as RECEIVED?"
        : "Are you sure? You want to UNDO received status?";

    if (!confirm(msg)) {
        // If user cancels → revert checkbox to old state
        checkbox.prop('checked', !status);
        return;
    }

    // If confirmed → send ajax request
    $.ajax({
        url: updateClient_recive_Status,
        type: "POST",
        data: {
            job_status_id: job_status_id,
            send_email: status
        },
        success: function (response) {

            $("#updateSuccessMsg_status")
                .html("Updated Successfully")
                .fadeIn()
                .delay(1000)
                .fadeOut();

            setTimeout(function () {
                location.reload();
            }, 0);
        }
    });

});
    
    
});

$(document).ready(function () {
    
      $('#disscount').on('input', function() {
        if (/\D/.test(this.value)) {  // Non-digit detected
            $('#disscount_maxError').show();
            this.value = this.value.replace(/\D/g, '');
        } else {
            $('#disscount_maxError').hide();
        }
    });

    // If DB has yes → enable input
    if ($("#discount_chk").is(":checked")) {
        $("#disscount").prop("disabled", false);
    }

    // Checkbox toggle
    $("#discount_chk").on("change", function () {
        if ($(this).is(":checked")) {
            $("#disscount").prop("disabled", false);
        } else {
            $("#disscount").prop("disabled", true).val('');
        }
    });
});

// =============================== 06-12-2025 ================================

$(document).ready(function () {
	// alert("hello");
	$(document).on('change', '.send_email_agreement_to_client', function () {

    let checkbox = $(this);
    let email_send_id = checkbox.data('email_send_id');
    let status = checkbox.is(':checked') ? 1 : 0;
    // alert(email_send_id);
    // Confirmation box
   let msg = status == 1 
    ? "Are you sure you want to send the agreement?" 
    : "Are you sure you want to undo the received status?";

    if (!confirm(msg)) {
        // If user cancels → revert checkbox to old state
        checkbox.prop('checked', !status);
        return;
    }

    // If confirmed → send ajax request
    $.ajax({
        url: updateClient_email_Status,
        type: "POST",
        data: {
            email_send_id: email_send_id,
            send_email: status
        },
        success: function (response) {

            $("#updateSuccessMsg_status")
                .html("Updated Successfully")
                .fadeIn()
                .delay(1000)
                .fadeOut();

            setTimeout(function () {
                location.reload();
            }, 0);
        }
    });

});


});

// ===========================  09-12-2025 ======================================

$(document).ready(function () {

    // If DB has yes → enable input
    if ($("#tds_status").is(":checked")) {
    	// alert("hello");
        $("#tds_status_amount").prop("disabled", false);
    }

    // Checkbox toggle
    $("#tds_status").on("change", function () {
        if ($(this).is(":checked")) {
            $("#tds_status_amount").prop("disabled", false);
        } else {
            $("#tds_status_amount").prop("disabled", true).val('');
        }
    });
});

// ===========================  19-01-2026 ======================================



$(document).ready(function () {

    // 🔹 Page reload नंतर message दाखवण्यासाठी
    if (sessionStorage.getItem('agreementSent') === 'true') {
        $("#updateSuccessMsg")
            .text('Agreement email sent successfully.')
            .fadeIn()
            .delay(2000)
            .fadeOut();

        sessionStorage.removeItem('agreementSent');
    }

    $(document).on('change', '.candidte_agre_status', function () {

        let checkbox = $(this);
        let job_status_id = checkbox.data('job_status_id');
        let status = checkbox.is(':checked') ? 1 : 0;

        let msg = status == 1
            ? "Are you sure you want to send the Agreement?"
            : "Are you sure you want to undo the received status?";

        if (!confirm(msg)) {
            checkbox.prop('checked', !status);
            return;
        }

        $.ajax({
            url: SendagreementCandidate,
            type: "POST",
            dataType: "json",
            data: {
                job_status_id: job_status_id,
                send_email: status
            },
            success: function (response) {

                if (response.status === true) {

                    // ✅ success flag set करा
                    sessionStorage.setItem('agreementSent', 'true');

                    // ✅ page reload
                    location.reload();

                } else {
                    alert(response.message);
                    checkbox.prop('checked', !status);
                }
            },
            error: function () {
                alert("Something went wrong. Please try again.");
                checkbox.prop('checked', !status);
            }
        });

    });
    

});

// ================ salary nigosiation ==================================

    $(document).ready(function () {

    function toggleSalaryInputs() {

        if ($("#salary_negotiation").is(":checked")) {
        
            // Negotiation YES → readonly
            $("#salary_min, #salary_max")
                .prop("readonly", true)
                .prop("required", false);
        } else {
            // Negotiation NO → editable
            $("#salary_min, #salary_max")
                .prop("readonly", false)
                .prop("required", true);
        }
    }

    // Checkbox click
    $("#salary_negotiation").on("change", function () {
        toggleSalaryInputs();
    });

    // Page load (edit / refresh case)
    toggleSalaryInputs();

});

// ============================post vacuncy upadte for hide show ============================================

$(document).on('change', '.toggle-input', function() {

    var posting_id = $(this).data('id');
    var status = $(this).is(':checked') 
                 ? 'Post Active' 
                 : 'Post Inactive';
   

    $.ajax({
        url: ChangeToggle,
        type: "POST",
        data: {
            posting_id: posting_id,
            posting_status: status
        },
        success: function(response){
            console.log("Updated");
        }
    });

});

  $(document).ready(function () {
     $('#lead_admin').select2({
        placeholder: "Select Job Role",
        allowClear: true,
        width: '100%'
       });
        // Cancel add role
    	  $('#cancellead_admin').click(function () {
    	    $('#leadInputWrapper_admin').slideUp();
    	    $('#newlead_admin').val('');
    	  });
    
    	  // Show input on Add button click
    	  $('#addleadBtn_admin').click(function () {
    	    // alert("hello");
    	    $('#leadInputWrapper_admin').slideDown();
    	    $('#newlead_admin').val('').focus();
    	  });
    
    
    	  $('#savelead_admin').click(function () {
        // alert("hello");
          const newRole = $('#newlead_admin').val().trim();
          // alert(newRole);
    
          if (newRole === '') {
            toastr.error('Please enter a lead.');
            return;
          }
    
        const exists = $('#lead_admin option').filter(function () {
          return $(this).text().toLowerCase() === newRole.toLowerCase();
        }).length > 0;
    
        if (exists) {
          toastr.warning('lead already exists!');
          return;
        }
    
          $.ajax({
            url: addleadURL,
            type: "POST",
            data: { lead_name: newRole },
            dataType: "json",
            success: function (response) {
              if (response.status === 'success') {
                const newOption = $('<option>', {
                  value: response.lead_id,
                  text: response.lead_name,
                  selected: true
                });
                $('#lead_admin').append(newOption).val(response.lead_id).trigger('change');
    
                $('#leadInputWrapper_admin').slideUp();
                $('#newlead_admin').val('');
                toastr.success('lead added successfully.');
              } else {
                toastr.error(response.message || 'Failed to add lead.');
              }
            },
            error: function () {
              toastr.error('Server error. Please try again.');
            }
          });
        });


    });
    
    
// ================ otp verify status ==========================

  $(document).on('change', '.statusToggle', function () {
  	// alert("hello");
    let toggle = $(this);
    let status = toggle.is(':checked') ? 'active' : 'inactive';
    let id = toggle.data('id');

    toggle.prop('disabled', true); // disable while updating

    $.ajax({
        url: tblUserOtpStatus,
        type: "POST",
        data: {
            uid: id,
            status: status
        },
        success: function (res) {

            if(res.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: 'Status updated successfully',
                    timer: 1500,
                    showConfirmButton: false
                });
            }

        },
        error: function () {

            
            toggle.prop('checked', !toggle.is(':checked'));

            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Something went wrong'
            });
        },
        complete: function () {
            toggle.prop('disabled', false);
        }
    });

});



















































