 $(document).ready(function() {
	$('#country_id, #state_id, #district_id,#city_id').select2({
	    width: '100%',
	    allowClear: true,
	    placeholder: "Select"
	});


	$('#state_id').on('change', function() {
    var state_id = $(this).val();
    //alert(state_id);

    $.ajax({
        url: "fetch_districts",
        type: "POST",
        data: {state_id: state_id},
        success: function(result) {
            $('#district_id').html(result);

            // Refresh Select2
            $('#district_id').trigger('change.select2');
        }
    });
});

	$('#district_id').on('change', function(){
        let district_id = $(this).val();

        $.ajax({
            url: "fetch_cities",
            type: "POST",
            data: {district_id: district_id},
            dataType: "json",
            success: function(data){
                $('#city_id').empty().append('<option value="">Select City</option>');
                
                $.each(data, function(key, value){
                    $('#city_id').append('<option value="'+value.id+'">'+value.name+'</option>');
                });

                $('#city_id').trigger('change.select2');
            }
        });
    });

		$('#o_id').select2({
	    width: '100%',
	    allowClear: true,
	    placeholder: "Select"
	});

		$('#trainingType').select2({
	    width: '100%',
	    allowClear: true,
	    placeholder: "Select"
	});

            $('#type_meeting').select2({
        width: '100%',
        allowClear: true,
        placeholder: "Select"
    });


        $('#participants').select2({
        width: '100%',
        allowClear: true,
        placeholder: "Select"
    });

        $('#expected_time_duration').select2({
        width: '100%',
        allowClear: true,
        placeholder: "Select Hours"
    });

 	});

// =====================================24-06-2026 =============================//
  $('#language_name').select2({
        width: '100%',
        allowClear: true,
        placeholder: "Select"
    });
  $('#lice_reg_name').select2({
        width: '100%',
        allowClear: true,
        placeholder: "Select"
    });
    $('#experience_years').select2({
        width: '100%',
        allowClear: true,
        placeholder: "Select"
    });
  
  $('#experience_months').select2({
        width: '100%',
        allowClear: true,
        placeholder: "Select"
    });


  $(document).ready(function(){

    function toggleAppointment() {
        var selected = $("#trainingType").val();
        // alert(selected);

        if (Array.isArray(selected)) {
            selected = selected[0];
        }

        if (selected == "ld") {
            $("#appointmentBlock").show();
        } else {
            $("#appointmentBlock").hide();
        }
    }

    // Normal select change
    $("#trainingType").on("change", toggleAppointment);

    // Bootstrap select change
    $("#trainingType").on("changed.bs.select", toggleAppointment);

});

$(document).ready(function(){
    // alert("hello");
    $("#participants").on("change", function(){

        

        var alertBox = $("#participantAlert");
        var highRange = ["30 – 50","50 – 70","70 – 100","100 +"];

        var selectedValue = $(this).val();

        if (highRange.includes(selectedValue)) {
            alertBox.show();
        } else {
            alertBox.hide();
        }

    });

});

  $(document).ready(function(){

    $('#trainer_mobile_no').on('input', function(){
        var val = $(this).val();
        var errorMsg = '';

        // Check for non-digit characters
        if(/[^0-9]/.test(val)){
            errorMsg = 'Please enter digits only';
        }

        // Remove non-digit characters
        val = val.replace(/[^0-9]/g, '');

        // Limit to 10 digits
        if(val.length > 10){
            val = val.slice(0, 10);
            errorMsg = 'Maximum 10 digits allowed';
        }

        $(this).val(val);

        // Show or hide error message
        if(errorMsg != ''){
            $('#mobileError').text(errorMsg).show();
        } else {
            $('#mobileError').hide();
        }
    });

});

// Function to open modal
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  modal.classList.add('show');
  modal.style.display = 'block';
}

// Function to close modal
function closeModal(modal) {
  modal.classList.remove('show');
  setTimeout(() => modal.style.display = 'none', 350);
}

// Open modal when card is clicked
document.querySelectorAll('.why-card').forEach(card => {
  card.addEventListener('click', () => {
    const modalId = card.getAttribute('data-modal');
    if(modalId) openModal(modalId);
  });
});

// Close buttons
document.querySelectorAll('.custom-modal').forEach(modal => {
  const closeBtn = modal.querySelector('.close');
  const cancelBtn = modal.querySelector('.btn-secondary');

  closeBtn.addEventListener('click', () => closeModal(modal));
  cancelBtn.addEventListener('click', () => closeModal(modal));

  // Close on clicking outside modal content
  modal.addEventListener('click', (e) => {
    if(e.target === modal) closeModal(modal);
  });
});
// =============================================//
$(document).ready(function(){

    function loadStates(country_id){
        $.ajax({
            url: "fetch_states",
            type: "POST",
            data: {country_id: country_id},
            success: function(result){
                $('#state_id').html(result).trigger('change');
            }
        });
    }

    // Page load la call
    var country_id = $('#country_id').val();
    if(country_id != ''){
        loadStates(country_id);
    }

    // Change var call
    $('#country_id').on('change', function(){
        
        loadStates($(this).val());
    });

});


// ================ validation mobile & email ===================================









