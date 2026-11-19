$('#saveBtn').click(function (e) {

    // CV option validation
    if (!$('input[name="cv_option"]:checked').length) {
        e.preventDefault();
        $('#cvOptionError_client').text('Please select a CV option.').show();
        return false;
    } else {
        $('#cvOptionError_client').hide();
    }

    let cvOption = $('input[name="cv_option"]:checked').val();

    // Resume validation
    if (cvOption == 'yes') {

        if ($('#resume_client')[0].files.length === 0) {

            e.preventDefault();

            $('#resume_client').addClass('is-invalid');
            $('#resume_client').next('.invalid-feedback').show();

            return false;

        } else {

            $('#resume_client').removeClass('is-invalid');
            $('#resume_client').next('.invalid-feedback').hide();
        }
    }

});

$(document).ready(function () {

    if ($('#resume_upload_section_client').length && $('#cv_plan_section_client').length) {

        function toggleCVSection() {
            var cvOption = $('input[name="cv_option"]:checked').val();

            if (cvOption == 'yes') {
                $('#resume_upload_section_client').show();
                $('#cv_plan_section_client').hide();
            } else if (cvOption == 'no') {
                $('#resume_upload_section_client').hide();
                $('#cv_plan_section_client').show();
            }
        }

        toggleCVSection();

        $('input[name="cv_option"]').on('change', function () {
            toggleCVSection();
        });
    }

});

// ==================================== 21-07-2026 =============================================
$(document).ready(function () {

    function toggleInsuranceDiv() {

        var qual_id = $('#qualification_job').val();

        if (!qual_id) {
            qual_id = $('#qualification_job_edit').val();
        }

        console.log("Qualification :", qual_id);

        if (qual_id == '37') {
            $('.insuranceDiv').show();
        } else {
            $('.insuranceDiv').hide();
            $('input[name="insurance_policy"]').prop('checked', false);
        }
    }

    // Create page
    $('#qualification_job').on('changed.bs.select change', function () {
        toggleInsuranceDiv();
    });

    // Edit page
    $('#qualification_job_edit').on('changed.bs.select change', function () {
        toggleInsuranceDiv();
    });

    // Page load
    setTimeout(function () {
        toggleInsuranceDiv();
    }, 300);

});

// $(document).ready(function () {

//     function toggleInsuranceDiv() {
//         var qual_id = $('#qualification_job').val();

//         if (qual_id == '37') {
//             $('.insuranceDiv').show();
//         } else {
//             $('.insuranceDiv').hide();
//             $('input[name="insurance_policy"]').prop('checked', false);
//         }
//     }

//     // selectpicker change
//     $('#qualification_job').on('changed.bs.select', function () {
//         toggleInsuranceDiv();
//     });

//     // page load la check
//     toggleInsuranceDiv();
// });