$(document).ready(function () {
  //========== recruiter Image Preview =======================
  $('#imageInput').on('change', function () {
    const file = this.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#previewImage').attr('src', e.target.result).show();
        $('#editBtn, #deleteBtn').show();
      };
      reader.readAsDataURL(file);
    }
  });

  // Edit image
  $('#editBtn').on('click', function () {
    $('#imageInput').click();
  });

  // Delete image
  $('#deleteBtn').on('click', function () {
    $('#previewImage').attr('src', '').hide();
    $('#editBtn, #deleteBtn').hide();
    $('#imageInput').val('');
  });

  //========== Job Image Preview ===========================================

  //   $('#imageInput_job').on('change', function () {
  //   const file = this.files[0];
  //   if (file && file.type.startsWith('image/')) {
  //     const reader = new FileReader();
  //     reader.onload = function (e) {
  //       $('#previewImage_job').attr('src', e.target.result).show();
  //       $('#editBtn_job, #deleteBtn_job').show();
  //     };
  //     reader.readAsDataURL(file);
  //   }
  // });

  // // Edit image
  // $('#editBtn_job').on('click', function () {
  //   $('#imageInput_job').click();
  // });

  // // Delete image
  // $('#deleteBtn_job').on('click', function () {
  //   $('#previewImage_job').attr('src', '').hide();
  //   $('#editBtn_job, #deleteBtn_job').hide();
  //   $('#imageInput_job').val('');
  // });

//===============================================================================

  // Show/hide hospital type
  // $('#industry').on('changed.bs.select', function () {
  //    // alert("hello");
  //   const selectedText = $(this).find("option:selected").text().trim().toLowerCase();
  //   $('#hospitalTypeDiv').toggle(selectedText === 'Hospital');
  // });

    $('.selectpicker').selectpicker(); // initialize Bootstrap Select

  // your change handler
  $('#industry').on('changed.bs.select', function () {
    const selectedText = $(this).find("option:selected").text().trim().toLowerCase();
    $('#hospitalTypeDiv').toggle(selectedText === 'hospital');
  });

  // Initialize Select2
  $('#job_role').select2({
    placeholder: "Select Job Role",
    allowClear: true,
    width: '100%'
  });

  $('#course').select2({
      placeholder: "Select Course",
      allowClear: true,
      width: '100%'
    });

  $('#location').select2({
      placeholder: "Select Location",
      allowClear: true,
      width: '100%'
    });

  $('#qualification').select2({
      placeholder: "Select Qualification",
      allowClear: true,
      width: '100%'
    }); 
    
     $('#department').select2({
      placeholder: "Select Department",
      allowClear: true,
      width: '100%'
    }); 

$('#qualification_job').select2('destroy').select2({
  placeholder: "Select Qualification",
  allowClear: true,
  width: '100%'
});
$('#current_city').select2('destroy').select2({
  placeholder: "Select City",
  allowClear: true,
  width: '100%'
});



  // Cancel add role
  $('#cancelJobRole').click(function () {
    $('#jobRoleInputWrapper').slideUp();
    $('#newJobRole').val('');
  });

  // Show input on Add button click
  $('#addJobRoleBtn').click(function () {
    // alert('hi');
    $('#jobRoleInputWrapper').slideDown();
    $('#newJobRole').val('').focus();
  });

});


 $('#saveJobRole').click(function () {
    // alert("hello");
      const newRole = $('#newJobRole').val().trim();
      // alert(newRole);

      if (newRole === '') {
        toastr.error('Please enter a job role.');
        return;
      }

    const exists = $('#job_role option').filter(function () {
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
            $('#job_role').append(newOption).val(response.job_id).trigger('change');

            $('#jobRoleInputWrapper').slideUp();
            $('#newJobRole').val('');
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

$(document).ready(function () {
  $('#addQualificationBtn').click(function () {
    $('#qualificationInputWrapper').slideDown();
    $('#newQualification').val('').focus();
  });

  $('#cancelQualification').click(function () {
    $('#qualificationInputWrapper').slideUp();
    $('#newQualification').val('');
  });

  $('#saveQualification').click(function () {
    const newQualification = $('#newQualification').val().trim();

    if (newQualification === '') {
      toastr.error('Please enter a qualification.');
      return;
    }

    const exists = $('#qualification option').filter(function () {
      return $(this).text().toLowerCase() === newQualification.toLowerCase();
    }).length > 0;

    if (exists) {
      toastr.warning('Qualification already exists!');
      return;
    }

    $.ajax({
      url: addQualificationURL,
      type: "POST",
      data: { qualification_name: newQualification },
      dataType: "json",
      success: function (response) {
        if (response.status === 'success') {
          const newOption = $('<option>', {
            value: response.qual_id,
            text: response.qualification_name,
            selected: true
          });
          $('#qualification').append(newOption).val(response.id).trigger('change');

          $('#qualificationInputWrapper').slideUp();
          $('#newQualification').val('');
          toastr.success('Qualification added successfully.');
        } else {
          toastr.error(response.message || 'Failed to add qualification.');
        }
      },
      error: function () {
        toastr.error('Server error. Please try again.');
      }
    });
  });
});

// ============================= jobseeker ========================================//

 $(document).ready(function () {
  // Show input
  $('#addQualificationBtn_job').click(function () {
    $('#qualificationInputWrapper_job').slideDown();
    $('#newQualification_job').val('').focus();
  });

  // Cancel input
  $('#cancelQualification_job').click(function () {
    $('#qualificationInputWrapper_job').slideUp();
    $('#newQualification_job').val('');
  });

  // Save new qualification
  $('#saveQualification_job').click(function () {
    const newQualification = $('#newQualification_job').val().trim();

    if (newQualification === '') {
      toastr.error('Please enter a qualification.');
      return;
    }

    // Check if already exists in dropdown
    const exists = $('#qualification_job option').filter(function () {
      return $(this).text().toLowerCase() === newQualification.toLowerCase();
    }).length > 0;

    if (exists) {
      toastr.warning('Qualification already exists!');
      return;
    }

    // Send AJAX to add
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
            selected: true
          });

          $('#qualification_job').append(newOption).val(response.id);

          // Reset and close
          $('#qualificationInputWrapper_job').slideUp();
          $('#newQualification_job').val('');
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

$(document).ready(function () {
// $('#course_job').select2({ 
//   placeholder: "Select Course",
//   allowClear: true,
//   width: '100%'
// });

  $('#course_job').on('change', function () {
        if ($(this).val()) {
            $('#course_job').next('.select2-container')
                .removeClass('is-invalid')
                .css('border', '');
        }
    });
});


$('#qualification_job').on('change', function () {
  const qual_id = $(this).val();

  if (qual_id !== "") {
    $.ajax({
      url: qualificationURL,
      type: "POST",
      data: { qual_id: qual_id },
      dataType: "json",
      success: function (data) {
        $('#course_job').empty().append('<option value=""></option>');

        $.each(data, function (index, item) {
          const isSelected = (item.course_id == selectedCourse_job) ? 'selected' : '';
          // alert(isSelected);
          $('#course_job').append('<option value="' + item.course_id + '" ' + isSelected + '>' + item.course_name + '</option>');
        });

        if (selectedCourse_job) {
          $('#course_job').val(selectedCourse_job).trigger('change');
        }
      }
    });
  } else {
    $('#course_job').empty().append('<option value=""></option>').trigger('change');
  }
});



// ========================add course ====================================

 $(document).ready(function () {
    // ✅ Toastr config (optional customization)
    toastr.options = {
      closeButton: true,
      progressBar: true,
      timeOut: 3000,
      positionClass: "toast-top-center"
    };

    // ✅ Show the input field to add a course
    $('#showAddCourse_job').on('click', function () {
      // alert("hello");
      $('#newCourseInput_job').val('');
      $('#newCourseWrapper_job').show();
      $('#newCourseInput_job').focus();
    });

    // ✅ Cancel adding new course
    $('#cancelNewCourse_job').on('click', function () {
      $('#newCourseWrapper_job').hide();
    });

    // ✅ Save course via AJAX
    $('#saveNewCourse_job').on('click', function () {
      const courseName = $('#newCourseInput_job').val().trim();
      const qualificationId = $('#qualification_job').val();
     alert(qualificationId);
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
          qualification_id: qualificationId
        },

        dataType: "json",
        success: function (response) {
          if (response.status === 'success') {
            const newId = response.course_id;
            const newName = response.course_name;

            // ✅ Add to dropdown and select it
            $('#course_job')
              .append(`<option value="${newId}" selected>${newName}</option>`)
              .val(newId);

            $('#newCourseWrapper_job').hide();
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
    $('#newCourseInput_job').on('keypress', function (e) {
      if (e.which === 13) {
        $('#saveNewCourse_job').click();
      }
    });
  });


// =================================== change course ==============================

 // $('#course').select2({
 //      placeholder: "Select Course",
 //      allowClear: true,
 //      width: '100%'
 //    });
 //  $('#qualification').on('change', function () {

 //      const qual_id = $(this).val();
      
 //      if (qual_id !== "") {
 //        $.ajax({
 //          url: qualificationURL,
 //          type: "POST",
 //          data: { qual_id: qual_id },
 //          dataType: "json",
 //          success: function (data) {
            
 //            $('#course').empty().append('<option value=""></option>');

 //            $.each(data, function (index, item) {
 //              $('#course').append('<option value="' + item.course_id + '">' + item.course_name + '</option>');
 //            });

            
 //            $('#course').val(null).trigger('change'); 
 //          },
          
 //        });
 //      } else {
 //        $('#course').empty().append('<option value=""></option>').trigger('change');
 //      }
 //    });




// alert($data['course_id']);
$(document).ready(function () {
$('#course').select2({ 
  placeholder: "Select Course",
  allowClear: true,
  width: '100%'
});
});

$('#qualification').on('change', function () {
  const qual_id = $(this).val();

  if (qual_id !== "") {
    $.ajax({
      url: qualificationURL,
      type: "POST",
      data: { qual_id: qual_id },
      dataType: "json",
      success: function (data) {
        $('#course').empty().append('<option value=""></option>');

        $.each(data, function (index, item) {
          const isSelected = (item.course_id == selectedCourse) ? 'selected' : '';
          $('#course').append('<option value="' + item.course_id + '" ' + isSelected + '>' + item.course_name + '</option>');
        });

        if (selectedCourse) {
          $('#course').val(selectedCourse).trigger('change');
        }
      }
    });
  } else {
    $('#course').empty().append('<option value=""></option>').trigger('change');
  }
});

// =================================== disable enable courses =====================

  //  $(document).ready(function () {
  //   function toggleCourseDropdown() {
  //     const selectedOption = $('#qualification option:selected');
  //     const name = selectedOption.data('name')?.trim();

  //     if (name === 'Any Graduation' || name === '10/12th') {
  //       $('#course').prop('disabled', true);
  //     } else {
  //       $('#course').prop('disabled', false);
  //     }

  //     $('#course').selectpicker('refresh'); // refresh UI
  //   }

  //   // When qualification changes
  //   $('#qualification').on('changed.bs.select', toggleCourseDropdown);

  //   // Run initially on load
  //   toggleCourseDropdown();
  // });


  $('#qualification').on('change', function () {
    const selectedOption = $(this).find('option:selected');
    const name = selectedOption.data('name')?.trim();

    if (name === 'Any Graduation' || name === '10/12th') {
      $('#course').prop('disabled', true);
    } else {
      $('#course').prop('disabled', false);
    }
  });

  // Trigger on load
  $('#qualification').trigger('change');

  // ================================= add courses ===================================

   $(document).ready(function () {
    // ✅ Toastr config (optional customization)
    toastr.options = {
      closeButton: true,
      progressBar: true,
      timeOut: 3000,
      positionClass: "toast-top-center"
    };

    // ✅ Show the input field to add a course
    $('#showAddCourse').on('click', function () {
      // alert("hello");
      $('#newCourseInput').val('');
      $('#newCourseWrapper').show();
      $('#newCourseInput').focus();
    });

    // ✅ Cancel adding new course
    $('#cancelNewCourse').on('click', function () {
      $('#newCourseWrapper').hide();
    });

    // ✅ Save course via AJAX
    $('#saveNewCourse').on('click', function () {
      const courseName = $('#newCourseInput').val().trim();
      const qualificationId = $('#qualification').val();
     alert(qualificationId);
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
          qualification_id: qualificationId
        },

        dataType: "json",
        success: function (response) {
          if (response.status === 'success') {
            const newId = response.course_id;
            const newName = response.course_name;

            // ✅ Add to dropdown and select it
            $('#course')
              .append(`<option value="${newId}" selected>${newName}</option>`)
              .val(newId);

            $('#newCourseWrapper').hide();
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
    $('#newCourseInput').on('keypress', function (e) {
      if (e.which === 13) {
        $('#saveNewCourse').click();
      }
    });
  });


  //  $('#imageUpload').on('change', function (e) {
   
  //   const file = e.target.files[0];

  //   if (!file || !file.type.startsWith('image/')) {
  //     alert("Please select a valid image file.");
  //     return;
  //   }

 
  //   const reader = new FileReader();
  //   reader.onload = function (event) {
  //     $('#logoDisplay').html(`<img src="${event.target.result}" alt="Uploaded Logo">`);
  //   };
  //   reader.readAsDataURL(file);

    
  //   const formData = new FormData();
  //   formData.append('compny_profile', file);

  //   $.ajax({
  //     url: imageUpload,
  //     type: "POST",
  //     data: formData,
  //     contentType: false,
  //     processData: false,
  //     success: function () {
  //       console.log("Image uploaded successfully.");
  //     },
  //     error: function () {
  //       alert("Upload failed.");
  //     }
  //   });
  // });

 $(document).ready(function () {
      $('#imageUpload').on('change', function (e) {
      const file = e.target.files[0];
      if (!file || !file.type.startsWith('image/')) {
        alert("Please select a valid image file.");
        return;
      }

      const reader = new FileReader();
      reader.onload = function (event) {
        // Replace only image part, not the label
        $('#logoDisplay').html(`
          <img src="${event.target.result}" id="logoImage" alt="Company Logo">
          <label for="imageUpload" class="camera-icon">&#x1F4F7;</label>
        `);
      };
      reader.readAsDataURL(file);

      // Upload to server
      const formData = new FormData();
      formData.append('compny_profile', file);

      $.ajax({
        url: imageUpload,
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
          console.log("Image uploaded successfully");
        },
        error: function () {
          alert("Upload failed");
        }
      });
    });
    });


 
   // ====================================== about ========================//
   $('#editTrigger').on('click', function () {
  const currentText = $('#companyText').text().trim();

  $('#companyText').hide();
  $('#editTextarea').val(currentText).show().focus();
});

// Save on blur (or press Enter if you prefer)
$('#editTextarea').on('blur', function () {
  const newText = $(this).val().trim();

  $.ajax({
    url: addAbout,
    method: "POST",
    data: {about_description: newText},
    success: function () {
      $('#companyText').text(newText).show();
      $('#editTextarea').hide();
    },
    error: function () {
      alert("Failed to save.");
    }
  });
});

//======================== tabs1 =====================================//

 $(document).ready(function () {
    $('#goToPublish').on('click', function () {
      $('#draft').removeClass('show active');
      $('#publish').addClass('show active');

      $(this).addClass('active');
      $('#goToDraft').removeClass('active');
    });

    $('#goToDraft').on('click', function () {
      $('#publish').removeClass('show active');
      $('#draft').addClass('show active');

      $(this).addClass('active');
      $('#goToPublish').removeClass('active');
    });
  });
// ====================== tabs2 ========================================//

 $(document).ready(function () {
  $('#goToPublish_update').on('click', function () {
    $('#draft_update, #preview_update').removeClass('show active');
    $('#publish_update').addClass('show active');

    $(this).addClass('active');
    $('#goToDraft_update, #goToPreview_update').removeClass('active');
  });

  $('#goToDraft_update').on('click', function () {
    $('#publish_update, #preview_update').removeClass('show active');
    $('#draft_update').addClass('show active');

    $(this).addClass('active');
    $('#goToPublish_update, #goToPreview_update').removeClass('active');
  });

  $('#goToPreview_update').on('click', function () {
    $('#publish_update, #draft_update').removeClass('show active');
    $('#preview_update').addClass('show active');

    $(this).addClass('active');
    $('#goToPublish_update, #goToDraft_update').removeClass('active');
  });
});
// =========================================================================//

  // $('#galleryForm').on('submit', function(e) {
    
  //   e.preventDefault();

  //   let formData = new FormData(this);

  //   $.ajax({
  //     url: Savegallery,
  //     method: "POST",
  //     data: formData,
  //     contentType: false,
  //     processData: false,
  //     beforeSend: function () {
  //       $('#galleryStatus').html('<p style="color:blue;">Submitting...</p>');
  //     },
  //     success: function(response) {
  //       $('#galleryStatus').html('<p style="color:green;">Saved successfully!</p>');
  //       $('#galleryPreview').html(response);
  //     },
  //     error: function() {
  //       $('#galleryStatus').html('<p style="color:red;">Failed to submit.</p>');
  //     }
  //   });
  //   });

//  $(document).ready(function () {

  
//   $('#images').on('change', function () {
//     const files = this.files;

//     if (files.length > 3) {
//       alert("You can only upload a maximum of 3 images.");
//       $(this).val(''); // Clear the file input
//     }
//   });

 
//   $('#galleryForm').on('submit', function (e) {
//     e.preventDefault();

//     const selectedFiles = $('#images')[0].files;

//     if (selectedFiles.length > 3) {
//       alert("Only 3 images are allowed.");
//       return;
//     }

//     let formData = new FormData(this);

//     $.ajax({
//       url: Savegallery,
//       method: "POST",
//       data: formData,
//       contentType: false,
//       processData: false,
//       beforeSend: function () {
//         $('#galleryStatus').html('<p style="color:blue;">Submitting...</p>');
//       },
//       success: function (response) {
       
//          $('#galleryStatus').html('<p style="color:green;">Saved successfully!</p>');
//         $('#galleryPreview').html(response);

       
//         $('#goToPublish_update').removeClass('active');
//         $('#goToDraft_update').addClass('active');
//       },
//       error: function () {
//         $('#galleryStatus').html('<p style="color:red;">Failed to submit.</p>');
//       }
//     });
//   });

// });


 $(document).ready(function () {

  // 🧪 Limit image selection to 3 files
  $('#images').on('change', function () {
    const files = this.files;

    if (files.length > 3) {
      alert("You can only upload a maximum of 3 images.");
      $(this).val(''); // Clear the file input
    }
  });

  // ✅ Handle form submit via AJAX
  $('#galleryForm').on('submit', function (e) {
    e.preventDefault();

    const selectedFiles = $('#images')[0].files;

    if (selectedFiles.length > 3) {
      alert("Only 3 images are allowed.");
      return;
    }

    let formData = new FormData(this);

    $.ajax({
      url: Savegallery,
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('#galleryStatus').html('<p style="color:blue;">Submitting...</p>');
      },
      success: function (response) {
        $('#galleryStatus').html('<p style="color:green;">Saved successfully!</p>');
        $('#galleryPreview').html(response);

        // ✅ Mark the active tab in localStorage BEFORE refresh
        localStorage.setItem('activeTab', 'gallery');

        // ✅ Reload the page to reflect changes (gallery tab will stay active)
        setTimeout(function () {
          location.reload();
        }, 500);
      },
      error: function () {
        $('#galleryStatus').html('<p style="color:red;">Failed to submit.</p>');
      }
    });
  });

  // ✅ Restore active tab after reload (if any)
  const activeTab = localStorage.getItem('activeTab');
  if (activeTab === 'gallery') {
    $('#goToPublish_update').removeClass('active');
    $('#goToDraft_update').addClass('active');

     $('#publish_update').removeClass('show active');
    $('#draft_update').addClass('show active');

    

    // // Optional: show/hide tab content sections (if any)
    // $('#companyDetailsTabContent').hide();
    // $('#galleryTabContent').show();

    localStorage.removeItem('activeTab');
  }

});

 $(document).on('click', '.delete-gallery', function () {
  const id = $(this).data('id');

  if (confirm("Are you sure you want to delete this item?")) {
    $.ajax({
      url:  deleteGalleryUrl + "/" + id,
      type: "GET",
      success: function (response) {
        if (response.status === 'success') {
          $('#media_' + id).remove();
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function () {
        alert("Failed to delete. Try again.");
      }
    });
  }
});

 // ======================== status dropdown =====================================

 $(document).ready(function () {
  // alert('hello');
    // 🔁 Function to apply background color based on selected status
   function updateSelectColor(selectElement) {
          const value = $(selectElement).val();
          const $select = $(selectElement);

          // Remove old classes and inline styles
          $select.removeClass('bg-success bg-warning bg-secondary text-white');
          $select.removeAttr("style");

          // Apply new color based on value
          if (value === 'Closed') {
              $select.addClass('bg-success text-white');   // Green
          } else if (value === 'Hold') {
              $select.addClass('bg-warning');              // Yellow
          } else if (value === 'Interview Schedule') {
              $select.css({"background-color":"orange", "color":"#fff"}); // Orange
          } else if (value === 'Rejected') {
              $select.css({"background-color":"#dc3545", "color":"#fff"}); // Red
          }else if (value === 'Profile_shared_client') {
              $select.css({"background-color":"#59C1E3", "color":"#fff"}); // Red
          } else {
              $select.addClass('bg-secondary text-white'); // Gray
          }
      }

      // 🔹 Run on page load for all dropdowns
      $(".admin-status-dropdown").each(function() {
          updateSelectColor(this);
      });

      // 🔹 Run when value changes
      $(".admin-status-dropdown").on("change", function() {
          updateSelectColor(this);
      });

    // ✅ Apply color on page load
    $('.admin-status-dropdown').each(function () {
        updateSelectColor(this);
    });

    // ✅ On dropdown value change
    $('.admin-status-dropdown').on('change', function () {

        // Update color
        updateSelectColor(this);

        // Get values
        const id = $(this).data('id');
        const status = $(this).val();

       
        $.ajax({
            url: adminStatus, // Adjust URL if needed
            type: 'POST',
            data: {
                id: id,
                status: status
            },
            success: function (response) {
                console.log('Status updated successfully');
                // Optional: Show a success message or toast here
            },
            error: function () {
                console.error('Error updating status');
                // Optional: Show an error message or toast here
            }
        });
    });
});

 // ============================ jobseeker job role ============================


  $('#cancelJobRole_jobseeker').click(function () {
    $('#jobRoleInputWrapper_jobseeker').slideUp();
    $('#newJobRole_jobseeker').val('');
  });

  // Show input on Add button click
  $('#addJobRoleBtn_jobseeker').click(function () {
     // alert('hi');
    $('#jobRoleInputWrapper_jobseeker').slideDown();
    $('#newJobRole_jobseeker').val('').focus();
  });

   $('#saveJobRole_jobseeker').click(function () {
    // alert("hello");
      const newRole = $('#newJobRole_jobseeker').val().trim();
      // alert(newRole);

      if (newRole === '') {
        toastr.error('Please enter a job role.');
        return;
      }

    const exists = $('#job_role_jobseeker option').filter(function () {
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
            $('#job_role_jobseeker').append(newOption).val(response.job_id).trigger('change');

            $('#jobRoleInputWrapper_jobseeker').slideUp();
            $('#newJobRole_jobseeker').val('');
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
   // ============================= 1-10-2025 =========================
   


  
   




 

