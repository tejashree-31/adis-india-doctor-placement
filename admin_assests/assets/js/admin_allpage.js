$(document).ready(function ()
{
	// =============== job role ==================================
	$('#location_id').select2({
    placeholder: "Select Location",
    allowClear: true,
    width: '100%'
  });

	$('#city_id').on('change', function () {
		
  		const city_id = $(this).val();
		  if (city_id !== "") {
		    $.ajax({
		      url: cityPincodeURL,
		      type: "POST",
		      data: { city_id: city_id },
		      dataType: "json",
		      success: function (data) {
		        if (data && data.pincode) {
		          $('#cities_pincode').val(data.pincode);
		        } else {
		          $('#cities_pincode').val('');
		        }
		      }
		    });
		  } else {
		    $('#cities_pincode').val('');
		  }
		});
	// =================================== job role =============================
	 $('#job_role_admin').select2({
    placeholder: "Select Job Role",
    allowClear: true,
    width: '100%'
   });
    // Cancel add role
	  $('#cancelJobRole_admin').click(function () {
	    $('#jobRoleInputWrapper_admin').slideUp();
	    $('#newJobRole_admin').val('');
	  });

	  // Show input on Add button click
	  $('#addJobRoleBtn_admin').click(function () {
	    // alert("hello");
	    $('#jobRoleInputWrapper_admin').slideDown();
	    $('#newJobRole_admin').val('').focus();
	  });


	  $('#saveJobRole_admin').click(function () {
    // alert("hello");
      const newRole = $('#newJobRole_admin').val().trim();
      // alert(newRole);

      if (newRole === '') {
        toastr.error('Please enter a job role.');
        return;
      }

    const exists = $('#job_role_admin option').filter(function () {
      return $(this).text().toLowerCase() === newRole.toLowerCase();
    }).length > 0;

    if (exists) {
      toastr.warning('Job role already exists!');
      return;
    }

      $.ajax({
        url: addJobRoleURL,
        type: "POST",
        data: { job_role: newRole },
        dataType: "json",
        success: function (response) {
          if (response.status === 'success') {
            const newOption = $('<option>', {
              value: response.job_id,
              text: response.job_role,
              selected: true
            });
            $('#job_role_admin').append(newOption).val(response.job_id).trigger('change');

            $('#jobRoleInputWrapper_admin').slideUp();
            $('#newJobRole_admin').val('');
            toastr.success('Job role added successfully.');
          } else {
            toastr.error(response.message || 'Failed to add job role.');
          }
        },
        error: function () {
          toastr.error('Server error. Please try again.');
        }
      });
    });


	 // ====================== Qualification ==========================================

	  
	  $('#qualification_admin').select2({
      placeholder: "Select Category",
      allowClear: true,
      width: '100%'
    }); 
		$(document).ready(function () {
		  // Show input
		  $('#addQualificationBtn_admin').click(function () {
		  	// alert("hello");
		    $('#qualificationInputWrapper_admin').slideDown();
		    $('#newQualification_admin').val('').focus();
		  });

		  // Cancel input
		  $('#cancelQualification_admin').click(function () {
		    $('#qualificationInputWrapper_admin').slideUp();
		    $('#newQualification_admin').val('');
		  });

		  // Save new qualification
		  $('#saveQualification_admin').click(function () {
		    const newQualification = $('#newQualification_admin').val().trim();

		    if (newQualification === '') {
		      toastr.error('Please enter a qualification.');
		      return;
		    }

		    
		    const exists = $('#qualification_admin option').filter(function () {
		      return $(this).text().toLowerCase() === newQualification.toLowerCase();
		    }).length > 0;

		    if (exists) {
		      toastr.warning('Qualification already exists!');
		      return;
		    }

		    
		    $.ajax({
		      url: addQualificationURL, // ← make sure this is declared in <script>
		      type: "POST",
		      data: { qualification_name: newQualification },
		      dataType: "json",
		      success: function (response) {
		        console.log("Response:", response);
		        if (response.status === 'success') {
		          // Append new option
		          const newOption = $('<option>', {
		            value: response.qual_id,
		            text: response.qualification_name,
		            'data-name': response.qual_id, 
		            selected: true
		          });

		          $('#qualification_admin').append(newOption).val(response.id);

		          // Reset and close
		          $('#qualificationInputWrapper_admin').slideUp();
		          $('#newQualification_admin').val('');
		          toastr.success('Qualification added successfully.');
		        } else {
		          toastr.error(response.message || 'Failed to add qualification.');
		        }
		      },
		      error: function (xhr) {
		        console.error("AJAX error:", xhr.responseText);
		        toastr.error('Server error. Please try again.');
		      }
		    });
		  });
		});


		// ====================== chnage course job =============================//


// 		$('#qualification_admin').on('change', function () {
//         const qual_id = $(this).val(); // Gets the ID
//         const qual_name = $(this).find('option:selected').data('name'); // Gets the name
    
//             if (qual_id !== "") {
//                 $.ajax({
//                     url: qualificationURL,
//                     type: "POST",
//                     data: { qual_id: qual_id },
//                     dataType: "json",
//                     success: function (data) {
//                         $('#course_admin').empty().append('<option value="">Select Courses</option>');
        
//                         $.each(data, function (i, item) {
//                             $('#course_admin').append(`<option value="${item.course_id}">${item.course_name}</option>`);
//                         });
        
//                         $('#course_admin').selectpicker('refresh');
//                     }
//                 });
//             } else {
//                 $('#course_admin').empty().append('<option value="">Select Courses</option>');
//                 $('#course_admin').selectpicker('refresh');
//             }
// 		});

       

		$('#course_admin').select2({
        placeholder: "Select Higher Qualification",
        allowClear: true,
        width: '100%'
        });
		 $('#showAddCourse_admin').on('click', function () {
     
          $('#newCourseInput_admin').val('');
          $('#newCourseWrapper_admin').show();
          $('#newCourseInput_admin').focus();
        });

    // ✅ Cancel adding new course
    $('#cancelNewCourse_admin').on('click', function () {
      $('#newCourseWrapper_admin').hide();
    }); 


	 $(document).ready(function () {
	    // ✅ Toastr config (optional customization)
	    toastr.options = {
	      closeButton: true,
	      progressBar: true,
	      timeOut: 3000,
	      positionClass: "toast-top-center"
	    };

	    // ✅ Show the input field to add a course
	    $('#showAddCourse_admin').on('click', function () {
	   
	      $('#newCourseInput_admin').val('');
	      $('#newCourseWrapper_admin').show();
	      $('#newCourseInput_admin').focus();
	    });

	    // ✅ Cancel adding new course
	    $('#cancelNewCourse_admin').on('click', function () {
	      $('#newCourseWrapper_admin').hide();
	    });

	    // ✅ Save course via AJAX
	    $('#saveNewCourse_admin').on('click', function () {
	      const courseName = $('#newCourseInput_admin').val().trim();
	      const qualificationId = $('#qualification_admin').val();
	      // alert(courseName);
	      // alert(qualificationId);
	      if (!courseName) {
	        toastr.error('Please enter a course name.');
	        return;
	      }

	      if (!qualificationId) {
	        toastr.warning('Please select a qualification first.');
	        return;
	      }

	     $.ajax({
				  url: addCoursesURL, // ✅ Your CI4 controller route
				  method: "POST",
				  data: {
				    course_name: courseName,
				    qualification_id: $('#qualification_admin').val() // ✅ pick current qualification
				  },
				  dataType: "json",
				  success: function (response) {
				    if (response.status === 'success') {
				      const newId = response.course_id;
				      const newName = response.course_name;
				      const qualId = response.qualification_id; // ✅ get qualification_id from backend response
				      // ✅ Add to dropdown and select it
				      $('#course_admin')
				        .append(`<option value="${newId}" selected>${newName}</option>`)
				        .val(newId);

				      $('#newCourseWrapper_admin').hide();
				      toastr.success('Course added successfully!');
				    } else {
				      toastr.error(response.message || 'Course already exists.');
				    }
				  },
				  error: function () {
				    toastr.error('Something went wrong. Please try again.');
				  }
				});
	    });



	    // ✅ Pressing Enter in the input triggers Save
	    $('#newCourseInput_admin').on('keypress', function (e) {
	      if (e.which === 13) {
	        $('#saveNewCourse_admin').click();
	      }
	    });
	  });

	 // ============= add department =============================

		$(document).ready(function () {
				 $('#department_admin').select2({
	    placeholder: "Select Department",
	    allowClear: true,
	    width: '100%'
	  });
			  toastr.options = {
	      closeButton: true,
	      progressBar: true,
	      timeOut: 3000,
	      positionClass: "toast-top-center"
	    };
		  $('#addDepartmentBtn_admin').on('click', function () {
		  	// alert('hello');
		    $('#newDepartmentInput_admin').val('');
		    $('#departmentInputWrapper_admin').show();
		    $('#newDepartmentInput_admin').focus();
		  });

		  $('#cancelDepartmentBtn_admin').on('click', function () {
		    $('#departmentInputWrapper_admin').hide();
		  });

		});

		 $('#saveDepartmentBtn_admin').on('click', function () {
	    const deptName = $('#newDepartmentInput_admin').val().trim();
	    if (!deptName) {
	      alert('Please enter a department name.');
	      return;
	    }
	    $.ajax({
	      url: addDepartmentURL,
	      method: "POST",
	      data: { department_name: deptName },
	      dataType: "json",
	      success: function (response) {
	        if (response.status === 'success') {
	          const newId = response.dept_id;
	          const newName = response.department_name;

	          $('#department_admin')
	            .append(`<option value="${newId}" selected>${newName}</option>`)
	            .val(newId)
	            .trigger('change');

	          $('#departmentInputWrapper_admin').hide();
	          toastr.success('Course added successfully!');
	        } else {
	           toastr.error(response.message || 'Course already exists.');
	        }
	      },
	      error: function () {
	        toastr.error('Something went wrong. Please try again.');
	      }
	    });
	  });

	// ================== validation ===================
	 $('#number_of_vacancies').on('input', function() {
        if (/\D/.test(this.value)) {  // Non-digit detected
            $('#vacanciesError').show();
            this.value = this.value.replace(/\D/g, '');
        } else {
            $('#vacanciesError').hide();
        }
    });
	  $('#experience_min').on('input', function() {
        if (/\D/.test(this.value)) {  // Non-digit detected
            $('#experience_minError').show();
            this.value = this.value.replace(/\D/g, '');
        } else {
            $('#experience_minError').hide();
        }
    });
     $('#experience_max').on('input', function() {
        if (/\D/.test(this.value)) {  // Non-digit detected
            $('#experience_maxError').show();
            this.value = this.value.replace(/\D/g, '');
        } else {
            $('#experience_maxError').hide();
        }
    });
     $('#salary_min').on('input', function() {
        if (/\D/.test(this.value)) {  // Non-digit detected
            $('#salary_minError').show();
            this.value = this.value.replace(/\D/g, '');
        } else {
            $('#salary_minError').hide();
        }
    });
      $('#salary_max').on('input', function() {
        if (/\D/.test(this.value)) {  // Non-digit detected
            $('#salary_maxError').show();
            this.value = this.value.replace(/\D/g, '');
        } else {
            $('#salary_maxError').hide();
        }
    });




});
// ===========================================
  // your change handler

     function toggleHospitalTypeDiv() {
    // Get the selected option's text
    var selectedText = $('#industry1 option:selected').text().toLowerCase().trim();

    if (selectedText === 'hospital') {
      $('#hospitalTypeDiv1').show();
    } else {
      $('#hospitalTypeDiv1').hide();
    }
  }

  $(document).ready(function () {
    // Run on page load (important for edit)
    toggleHospitalTypeDiv();

    // Run on dropdown change
    $('#industry1').on('change', function () {
    	// alertr("hello");
      toggleHospitalTypeDiv();
    });
  });

  // ============= delete emp ==============================

  $(document).ready(function() {
    $('.delete-emp').on('click', function(e) {
    	// alert("hello");
        e.preventDefault(); // prevent default link action
        var link = $(this).attr('href');

        if (confirm('Are you sure you want to delete this?')) {
            window.location.href = link; // redirect if confirmed
        }
    });
});



 // ========================16-10-2025 ================================
  $(document).ready(function() {
    $('.delete-post').on('click', function(e) {
    	// alert("hello");
        e.preventDefault(); // prevent default link action
        var link = $(this).attr('href');

        if (confirm('Are you sure you want to delete this?')) {
            window.location.href = link; // redirect if confirmed
        }
    });
     }); 
     
    //  ==============================27/10/2025 ===================================================
    $(document).ready(function() {
 
    $('#country_id, #state_id, #district_id').select2({
        width: '100%',
        allowClear: true,
        placeholder: "Select"
    });
    
    $('#country_id').on('change', function() {
       
    var country_id = $(this).val();
    alert('Please select States');
    $.ajax({
            url: "fetch_states",
            type: "POST",
            data: {country_id: country_id},
            success: function(result) {
    
                // Set new state options
                $('#state_id').html(result);
    
                // **Refresh Select2 dropdown**
                $('#state_id').trigger('change.select2');
            }
        });
    });
    
    $('#state_id').on('change', function() {
       
    var state_id = $(this).val();

    alert("Please Select District");
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
        alert("Please Select Cities");
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
    
});  



// ==================================Add employer City =======================


 $(document).ready(function() 
 {
 
	 $('#city_id').select2({
		    placeholder: "Select City",
		    allowClear: true,
		    width: '100%'
		   });
    // Cancel add role
	  $('#cancelcity_admin').click(function () {
	    $('#cityInputWrapper_admin').slideUp();
	    $('#newcity_admin').val('');
	  });

	  // Show input on Add button click
	  $('#addcityBtn_admin').click(function () {
	    // alert("hello");
	    $('#cityInputWrapper_admin').slideDown();
	    $('#newcity_admin').val('').focus();
	  });

    $('#savecity_admin').click(function () {
    const newCity = $('#newcity_admin').val().trim();
    const country_id = $('#country_id').val(); // Make sure your country select has id="country_id"
    const state_id = $('#state_id').val();     // Make sure your state select has id="state_id"
    const district_id = $('#district_id').val(); // Make sure your district select has id="district_id"
    // alert(country_id);
    // alert(state_id);
    // alert(district_id);
    if (newCity === '') {
        toastr.error('Please enter city.');
        return;
    }

    // Check if city already exists
    const exists = $('#city_id option').filter(function () {
        return $(this).text().toLowerCase() === newCity.toLowerCase();
    }).length > 0;

    if (exists) {
        toastr.warning('City already exists!');
        return;
    }

    // Validate that country, state, district are selected
    if (!country_id || !state_id || !district_id) {
        toastr.error('Please select country, state, and district first.');
        return;
    }

    $.ajax({
        url: addcityeURL, // Your controller URL to save city
        type: "POST",
        data: {
            name: newCity,
            country_id: country_id,
            state_id: state_id,
            district_id: district_id
        },
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                const newOption = $('<option>', {
                    value: response.id,
                    text: response.name,
                    selected: true
                });
                $('#city_id').append(newOption).val(response.id).trigger('change');

                $('#cityInputWrapper_admin').slideUp();
                $('#newcity_admin').val('');
                toastr.success('City added successfully.');
            } else {
                toastr.error(response.message || 'Failed to add city.');
            }
        },
        error: function () {
            toastr.error('Server error. Please try again.');
        }
    });
});

});

// ========================================= edit states ===============================
$(document).ready(function () { 

    // Initialize Select2
    $('#country_id').select2();
    $('#state_id_edit').select2();

    var selectedCountry = $('#country_id').val();
    var selectedState   = $('#state_id_edit').data('selected'); // get selected state from view
  
    // Load states when page opens
    function loadEditStates(country_id, selected_state) {
        $.ajax({
            url: fetchStatesedit, // ✅ use variable here
            type: "POST",
            data: { country_id: country_id, selected_state: selected_state },
            success: function(result){
                $('#state_id_edit').html(result);

                // Re-initialize select2 after replacing data
                $('#state_id_edit').select2();

                // Set selected value (important)
                if(selected_state){
                    $('#state_id_edit').val(selected_state).trigger('change');
                }
            }
        });
    }

    // Auto-load on page load
    if (selectedCountry) {
        loadEditStates(selectedCountry, selectedState);
    }

    // Load when user changes country manually
    $('#country_id').on('change', function () {
        loadEditStates($(this).val(), ''); // no selected state on manual change
    });

});

// =========================== distrct edit =========================================
 
$(document).ready(function () {

    $("#state_id_edit").select2();
    $("#district_id_edit").select2();

    let state_id = $("#state_id_edit").data("selected");
    let selected_district = $("#district_id_edit").data("selected");

    console.log("STATE:", state_id);
    console.log("DISTRICT:", selected_district);

    loadDistricts(state_id, selected_district);

    $("#state_id_edit").on("change", function () {
        loadDistricts($(this).val(), "");
    });

    function loadDistricts(state_id, selected_district) {

        if (!state_id) {
            $("#district_id_edit").html('<option value="">Select District</option>').trigger('change');
            return;
        }

        $.ajax({
            url: fetchDistrictsedit,
            type: "POST",
            data: { state_id: state_id },
            dataType: "json",
            success: function (districts) {

                let districtDropdown = $("#district_id_edit");
                districtDropdown.html('<option value="">Select District</option>');

                $.each(districts, function (index, district) {
                    districtDropdown.append(
                        `<option value="${district.district_id}">${district.district_name}</option>`
                    );
                });

                // ✅ Most Important Fix (Wait then Set Value)
                if (selected_district) {
                    setTimeout(function () {
                        districtDropdown.val(String(selected_district)).trigger('change');
                    }, 200); // Delay 200ms
                } else {
                    districtDropdown.trigger('change');
                }
            }
        });
    }

});

$(document).ready(function () {

    $("#district_id_edit").select2();
    $("#city_id_edit").select2();

    let district_id = $("#district_id_edit").data("selected");
    let selected_city = $("#city_id_edit").data("selected");

    // console.log("DISTRICT:", district_id);
    // console.log("CITY:", selected_city);

    loadCities(district_id, selected_city);

    $("#district_id_edit").on("change", function () {
        loadCities($(this).val(), "");
    });

    function loadCities(district_id, selected_city) {
        if (!district_id) {
            $("#city_id_edit").html('<option value="">Select City</option>').trigger('change');
            return;
        }

        $.ajax({
            url: fetchCitiesedit,
            type: "POST",
            data: { district_id: district_id },
            dataType: "json",
            success: function (cities) {
                // console.log("CITIES:", cities);

                let cityDropdown = $("#city_id_edit");
                cityDropdown.empty().append('<option value="">Select City</option>');

                $.each(cities, function (index, city) {
                    cityDropdown.append(
                        `<option value="${city.id}">${city.name}</option>`
                    );
                });

                // ✅ Ensure correct matching & Select2 refresh
                if (selected_city) {
                    setTimeout(() => {
                        cityDropdown.val(String(selected_city)).trigger('change.select2');
                        // console.log("Set selected city:", selected_city);
                    }, 500);
                } else {
                    cityDropdown.trigger('change.select2');
                }
            },
            error: function (xhr, status, error) {
                console.error("City Load Error:", error);
            }
        });
    }

});




// =============================== Add city edit =================================

 $(document).ready(function() {
 	// alert("hi");

    // Cancel add role
	  $('#cancelcity_admin_edit').click(function () {
	    $('#cityInputWrapper_admin_edit').slideUp();
	    $('#newcity_admin_edit').val('');
	  });

	  // Show input on Add button click
	  $('#addcityBtn_admin_edit').click(function () {
	    // alert("hello");
	    $('#cityInputWrapper_admin_edit').slideDown();
	    $('#newcity_admin_edit').val('').focus();
	  });

$('#savecity_admin_edit').click(function () {
    const newCity = $('#newcity_admin_edit').val().trim();
    const country_id = $('#country_id').val(); // Make sure your country select has id="country_id"
    const state_id = $('#state_id_edit').val();     // Make sure your state select has id="state_id"
    const district_id = $('#district_id_edit').val(); // Make sure your district select has id="district_id"
    // alert(country_id);
    // alert(state_id);
    // alert(district_id);
    if (newCity === '') {
        toastr.error('Please enter city.');
        return;
    }

    // Check if city already exists
    const exists = $('#city_id_edit option').filter(function () {
        return $(this).text().toLowerCase() === newCity.toLowerCase();
    }).length > 0;

    if (exists) {
        toastr.warning('City already exists!');
        return;
    }

    // Validate that country, state, district are selected
    if (!country_id || !state_id || !district_id) {
        toastr.error('Please select country, state, and district first.');
        return;
    }

    $.ajax({
        url: addcityeURL, // Your controller URL to save city
        type: "POST",
        data: {
            name: newCity,
            country_id: country_id,
            state_id: state_id,
            district_id: district_id
        },
        dataType: "json",
        success: function (response) {
            if (response.status === 'success') {
                const newOption = $('<option>', {
                    value: response.id,
                    text: response.name,
                    selected: true
                });
                $('#city_id_edit').append(newOption).val(response.id).trigger('change');

                $('#cityInputWrapper_admin_edit').slideUp();
                $('#newcity_admin_edit').val('');
                toastr.success('City added successfully.');
            } else {
                toastr.error(response.message || 'Failed to add city.');
            }
        },
        error: function () {
            toastr.error('Server error. Please try again.');
        }
    });
});

});

// ==========================   delete contact ========================//


  $(document).ready(function () {

    // DELETE CONTACT
    $(document).on('click', '.delete-contact', function (e) {
        e.preventDefault();

        const link = $(this).attr('href');

        if (confirm('Are you sure you want to delete this contact?')) {
            window.location.href = link;
        }
    });

});














