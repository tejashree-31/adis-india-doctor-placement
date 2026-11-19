<div class="whatsapp-container">

<div class="whatsapp-text">Doctors Job Here </div>

<a href="https://wa.me/919607559547?text=Hello%20I%20am%20a%20doctor%20looking%20for%20job" target="_blank">
<img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" width="50">
</a>

</div>

<style>

.whatsapp-container{
position:fixed;
bottom:20px;
right:20px;
z-index:9999;
text-align:center;
}

.whatsapp-text{
background:#f05867;
color:#fff;
font-size:13px;
padding:5px 10px;
border-radius:15px;
margin-bottom:5px;
font-weight:600;
animation:blink 1s infinite;
}

@keyframes blink{
0%{opacity:1;}
50%{opacity:0.4;}
100%{opacity:1;}
}

</style>
<footer class="site-footer">
    <a href="#top" class="smoothscroll scroll-top">
        <span class="icon-keyboard_arrow_up"></span>
    </a>

      <div class="container">
        <div class="row mb-5">
          <div class="col-6 col-md-3 mb-4 mb-md-0">
            <h3>Our Services</h3>
            <ul class="list-unstyled">
              <li><a href="https://adisindiaplacement.com" target="_blank" rel="noopener noreferrer">Web Design</a></li>
              <li><a href="https://adisindiaplacement.com" target="_blank" rel="noopener noreferrer">Web Developers</a></li>
              <li><a href="https://www.facebook.com/adisindia2021" target="_blank" rel="noopener noreferrer">AdisIndia Digital </a></li>
               <li><a href="https://www.facebook.com/inspirecreativegarment/" target="_blank" rel="noopener noreferrer">Inspire creative garments </a></li>
                <li><a href="https://wonderfuljodi.com/" target="_blank" rel="noopener noreferrer">Wonderfuljodi </a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3 mb-4 mb-md-0">
            <h3>Company</h3>
            <ul class="list-unstyled">
              <li><a href="<?= base_url('about'); ?>">About Us</a></li>
              <li><a href="<?= base_url('display-blogs'); ?>">Blog</a></li>
             <li><a href="<?= base_url('gallery'); ?>">Gallery</a></li>
            <li><a href="<?= base_url('display-blogs'); ?>"><span class="latest-news-blink">Latest News</span></a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3 mb-4 mb-md-0">
            <h3>Support</h3>
            <ul class="list-unstyled">
              <li><a href="<?= base_url('contact_us'); ?>">Contact Us</a></li>
              <li><a href="<?= base_url('privacy'); ?>">Privacy Policy</a></li>
              <li><a href="<?= base_url('terms_of_service'); ?>">Terms of Service</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3 mb-4 mb-md-0">
            <h3>Connect With Us</h3>
            <div class="footer-social">
              <a href="https://www.facebook.com/adisindiaplacement" target="_blank" rel="noopener noreferrer"><span class="icon-facebook"></span></a>
              <a href="https://x.com/adisindia2015" target="_blank" rel="noopener noreferrer"><span class="icon-twitter"></span></a>
              <a href="https://www.instagram.com/adisindiaplacementpvtltd/" target="_blank" rel="noopener noreferrer"><span class="icon-instagram"></span></a>
              <a href="https://www.linkedin.com/company/adisindiaplacement/" target="_blank" rel="noopener noreferrer"><span class="icon-linkedin"></span></a>
            </div>
          </div>
        </div>

        <div class="row text-center">
          <div class="col-12">
            <p class="copyright"><small>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;2025 Adis India Placement Pvt Ltd, Inc, All right reserved.
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></small></p>
          </div>
        </div>
      </div>
    </footer>
  
  </div>

    <!-- SCRIPTS -->
    <script src="<?php echo base_url(); ?>assets/jobportal/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/isotope.pkgd.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/stickyfill.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/jquery.fancybox.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/jquery.easing.1.3.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/jobportal/js/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/jquery.animateNumber.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/owl.carousel.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/jobportal/js/bootstrap-select.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/jobportal/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/formvalidation.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/toastr.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/jobportal/js/traning.js"></script>
     <script src="<?php echo base_url(); ?>assets/jobportal/js/otpsending.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/jobportal/js/modal.js"></script>
   
    <script>
        const qualificationURL ="<?= base_url('get-courses') ?>";
        const selectedCourse = "<?= isset($data['course_id']) ? esc($data['course_id']) : '' ?>";
       const selectedCourse_job = "<?= isset($data_course['course_id']) ? esc($data_course['course_id']) : '' ?>";
  </script>
<script src="https://www.jotform.com/website-widgets/embed/019fa2db1698700084b0972bfdb273f45fc1"></script>
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="<?php echo base_url(); ?>assets/jobportal/js/recruiterjs.js"></script>

<!-- ===================================== 25-06-2026 ==================================== -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<!-- ===================================== 25-06-2026 ==================================== -->
   <script src="<?php echo base_url(); ?>assets/jobportal/js/new_js.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.ckeditor').forEach((element) => {

        ClassicEditor
            .create(element)
            .then(editor => {
                console.log('Editor Loaded');
            })
            .catch(error => {
                console.error(error);
            });

    });

});

$(document).ready(function () {

    // $('input[name="linkdin_profile"]').on('change', function () {

    //     if ($(this).val() === 'Yes') {
    //         $('#linkedin_url_div').slideDown();
    //     } else {
    //         $('#linkedin_url_div').slideUp();
    //         $('input[name="linkedin_url"]').val('');
    //     }

    // });

    $(document).ready(function () {

    function toggleLinkedinUrl() {

        if ($('input[name="linkdin_profile"]:checked').val() === 'Yes') {
            $('#linkedin_url_div').slideDown();
        } else {
            $('#linkedin_url_div').slideUp();
        }

    }

    // Edit page load
    toggleLinkedinUrl();

    // Radio change
    $('input[name="linkdin_profile"]').on('change', function () {

        if ($(this).val() === 'Yes') {
            $('#linkedin_url_div').slideDown();
        } else {
            $('#linkedin_url_div').slideUp();
            $('input[name="linkedin_url"]').val('');
        }

    });

});

});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<script>
let cropper = null;

// Hide initially
$('.crop-area').hide();
$('#candi_profile_cropBtn').hide();
$('#candi_profile_croppedPreview').hide();

$('#candi_profile_imageInput').on('change', function(e){

    const file = e.target.files[0];

    if(!file) return;

    // Show crop area & button after image selection
    $('.crop-area').show();
    $('#candi_profile_cropBtn').show();

    const reader = new FileReader();

    reader.onload = function(event){

        $('#candi_profile_imagePreview')
            .attr('src', event.target.result)
            .show();

        if(cropper){
            cropper.destroy();
        }

        cropper = new Cropper(
            document.getElementById('candi_profile_imagePreview'),
            {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                dragMode: 'move',
                background: false
            }
        );
    };

    reader.readAsDataURL(file);
});

$('#candi_profile_cropBtn').on('click', function(){

    if(!cropper){
        alert('Please select image first');
        return;
    }

    let canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300
    });

    let croppedImage = canvas.toDataURL('image/png');

    $('#candi_profile_croppedPreview')
        .attr('src', croppedImage)
        .show();

    $('#candi_profile_cropped_image').val(croppedImage);

    // Hide crop area and button
    $('.crop-area').hide();
    $('#candi_profile_cropBtn').hide();

    // Destroy cropper
    cropper.destroy();
    cropper = null;
});
</script>

<script type="text/javascript">
let editCropper = null;

$('#edit_candi_profile_imageInput').on('change', function (e) {

    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();

    reader.onload = function (e) {

        const image = document.getElementById('edit_candi_profile_imagePreview');

        image.src = e.target.result;

        image.onload = function () {

            $('.edit-crop-area').show();
            $('#edit_candi_profile_cropBtn').show();

            if (editCropper) {
                editCropper.destroy();
            }

            editCropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true
            });

        };
    };

    reader.readAsDataURL(file);
});

$('#edit_candi_profile_cropBtn').on('click', function () {

    if (!editCropper) {
        alert('Cropper not initialized');
        return;
    }

    const canvas = editCropper.getCroppedCanvas({
        width: 300,
        height: 300
    });

    if (!canvas) {
        alert('Canvas not created');
        return;
    }

    const croppedImage = canvas.toDataURL('image/png');

    $('#edit_candi_profile_preview')
        .attr('src', croppedImage)
        .css('display', 'block');

    $('#edit_candi_profile_cropped_image').val(croppedImage);

    $('.edit-crop-area').hide();
    $('#edit_candi_profile_cropBtn').hide();

    editCropper.destroy();
    editCropper = null;
});
</script>
   <!-- ===================================== 25-06-2026 ==================================== -->
    <?php if (session()->getFlashdata('success')): ?>
      <script>
        $(document).ready(function () {
          toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-center",
            timeOut: 4000,
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
          };
          toastr.success("<?= session()->getFlashdata('success') ?>");
        });
      </script>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <script>
          $(document).ready(function () {
            toastr.error("<?= session()->getFlashdata('error') ?>");
          });
        </script>
      <?php endif; ?>
      <script>
        const addJobRoleURL = "<?= base_url('recruiter/add_job_role') ?>";
      </script>
      <script>
        const addQualificationURL = "<?= base_url('recruiter/add_qualification') ?>";
      </script>
      <script>
        // const qualificationURL ="<?= base_url('get-courses') ?>";
      </script>

      <script type="text/javascript">
          const addCoursesURL ="<?= base_url('recruiter/add_course') ?>";
      </script>
      <script>
         // Department Add Functionality
        $(document).ready(function () {
          $('#addDepartmentBtn').on('click', function () {
            $('#newDepartmentInput').val('');
            $('#departmentInputWrapper').show();
            $('#newDepartmentInput').focus();
          });
        
          $('#cancelDepartmentBtn').on('click', function () {
            $('#departmentInputWrapper').hide();
          });
        
          $('#saveDepartmentBtn').on('click', function () {
            const deptName = $('#newDepartmentInput').val().trim();
            if (!deptName) {
              alert('Please enter a department name.');
              return;
            }
        
            $.ajax({
              url: "<?= base_url('recruiter/add_department') ?>",
              method: "POST",
              data: { department_name: deptName },
              dataType: "json",
              success: function (response) {
                if (response.status === 'success') {
                  const newId = response.dept_id;
                  const newName = response.department_name;
        
                  $('#department')
                    .append(`<option value="${newId}" selected>${newName}</option>`)
                    .val(newId)
                    .trigger('change');
        
                  $('#departmentInputWrapper').hide();
                } else {
                  alert(response.message || 'Department already exists.');
                }
              },
              error: function () {
                alert('Something went wrong while adding the department.');
              }
            });
          });
        });

</script>

<script>
$('#termsCheckbox').on('change', function () {
  $('#publishBtn').prop('disabled', !this.checked);
});
 
</script>
   <script>


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
      toggleHospitalTypeDiv();
    });
  });
</script>
<script>
  const imageUpload ="<?= base_url('recruiter/upload_company_profile') ?>";
  const addAbout ="<?= base_url('recruiter/add_about') ?>";
  const Savegallery ="<?= base_url('recruiter/add_gallery') ?>";
  const deleteGalleryUrl = "<?= base_url('recruiter/delete_gallery_item') ?>";
</script>
<script>
  document.getElementById("clearForm").addEventListener("change", function() {
    if (this.checked) {
      // Clear text input
      document.querySelector("input[name='job_role']").value = "";

      // Reset selects
      document.querySelector("select[name='location_id']").selectedIndex = -1;
      document.querySelector("select[name='employment_type']").selectedIndex = -1;

      // Refresh bootstrap-select
      if (typeof $ !== 'undefined' && $('.selectpicker').length) {
        $('.selectpicker').selectpicker('refresh');
      }

      // Uncheck after clearing
      setTimeout(() => this.checked = false, 500);
    }
  });
</script>

<script>
    $(document).ready(function () {

    // alert("hello ✅ JS Working");

    // ✅ Select2 Initialize
    $('#qualification_job_edit').select2({
        placeholder: "Select Qualification",
        allowClear: true,
        width: '100%'
    });

    $('#course_job_edit').select2({
        placeholder: "Select Course",
        allowClear: true,
        width: '100%'
    });

    // ✅ Qualification Change Event
    $('#qualification_job_edit').on('change', function () {

        const qual_id = $(this).val();
        console.log("Qualification Changed:", qual_id);

        if (!qual_id) {
            $('#course_job_edit').empty().append('<option value=""></option>').trigger('change');
            return;
        }

        $.ajax({
            url: qualificationURL,
            type: "POST",
            data: { qual_id: qual_id },
            dataType: "json",
            success: function (data) {
                console.log("AJAX Response:", data);

                $('#course_job_edit').empty().append('<option value="">Select Course</option>');

                const selectedNorm = String(selectedCourse_job).trim();

                $.each(data, function (index, item) {
                    $('#course_job_edit').append(
                        `<option value="${item.course_id}" ${item.course_id == selectedNorm ? 'selected' : ''}>${item.course_name}</option>`
                    );
                });

                $('#course_job_edit').val(selectedNorm).trigger('change');
            },
            error: function (xhr, status, err) {
                console.log("AJAX Error:", err);
            }
        });
    });

    // ✅ Auto trigger for EDIT page
    $('#qualification_job_edit').trigger('change');
});


const texts = [
    "Local Excellence And Global Reach"
    
];

let speed = 80;
let textIndex = 0;
let charIndex = 0;
let currentText = "";
let isDeleting = false;

function typeEffect() {
    currentText = texts[textIndex];
    let displayText = document.getElementById("typing-text");

    if (!isDeleting) {
        displayText.textContent = currentText.substring(0, charIndex++);
        if (charIndex > currentText.length) {
            isDeleting = true;
            setTimeout(typeEffect, 1500);
            return;
        }
    } else {
        displayText.textContent = currentText.substring(0, charIndex--);
        if (charIndex < 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
        }
    }

    setTimeout(typeEffect, isDeleting ? 40 : speed);
}

document.addEventListener("DOMContentLoaded", typeEffect);

</script>


<script>
var counted = 0;

$(window).scroll(function() {

    var oTop = $('.counter-wrapper').offset().top - window.innerHeight;

    if (counted == 0 && $(window).scrollTop() > oTop) {

        $('.count').each(function () {

            var $this = $(this),
            countTo = $this.attr('data-count');

            $({ countNum: $this.text() }).animate({
                countNum: countTo
            },

            {

                duration: 2000,
                easing: 'swing',

                step: function () {

                    if($this.hasClass('percent')){
                        $this.text(Math.floor(this.countNum) + "%");
                    }else{
                        $this.text(Math.floor(this.countNum) + "+");
                    }

                },

                complete: function () {

                    if($this.hasClass('percent')){
                        $this.text(this.countNum + "%");
                    }else{
                        $this.text(this.countNum + "+");
                    }

                }

            });

        });

        counted = 1;
    }

});
</script>
<script type="text/javascript">
  $(document).ready(function () {

    function toggleSpouseField() {
        var married = $('#married').is(':checked');

        if (married) {
            $('#spouseField').show();
        } else {
            $('#spouseField').hide();

            // optional: clear selection
            $('input[name="spouse_type"]').prop('checked', false);
        }
    }

    
    toggleSpouseField();


    $('input[name="marital_status"]').on('change', function () {
        toggleSpouseField();
    });

});
</script>
<script type="text/javascript">

    var FetchSendMail = "<?= base_url('jobseeker/new_send_jobseeker') ?>";
    var sessionUid = "<?= session()->get('uid'); ?>";
</script>

<script type="text/javascript">
  $(document).ready(function () {

    $("#closeAd").click(function () {
        $("#adBox").fadeOut();
    });

});
</script>
<!-- ========================== 26-06-2026  ======================================== -->
<script type="text/javascript">
$('#saveBtn').click(function (e) {

    // CV option validation
    if (!$('input[name="cv_option"]:checked').length) {
        e.preventDefault();
        $('#cvOptionError').text('Please select a CV option.').show();
        return false;
    } else {
        $('#cvOptionError').hide();
    }

    let cvOption = $('input[name="cv_option"]:checked').val();

    // Resume validation
    if (cvOption == 'yes') {

        if ($('#resume')[0].files.length === 0) {

            e.preventDefault();

            $('#resume').addClass('is-invalid');
            $('#resume').next('.invalid-feedback').show();

            return false;

        } else {

            $('#resume').removeClass('is-invalid');
            $('#resume').next('.invalid-feedback').hide();
        }
    }

});



</script>
<script type="text/javascript">

    $(document).ready(function () {

    if ($('#resume_upload_section').length && $('#cv_plan_section').length) {

        function toggleCVSection() {
            var cvOption = $('input[name="cv_option"]:checked').val();

            if (cvOption == 'yes') {
                $('#resume_upload_section').show();
                $('#cv_plan_section').hide();
            } else if (cvOption == 'no') {
                $('#resume_upload_section').hide();
                $('#cv_plan_section').show();
            }
        }

        toggleCVSection();

        $('input[name="cv_option"]').on('change', function () {
            toggleCVSection();
        });
    }

});
</script>
<script type="text/javascript">
$(document).ready(function () {

    function updateExperienceNumbers() {
        $('.experience-title').each(function(index) {
            $(this).text('Experience ' + (index + 1));
        });
    }

    $('#addExperience').click(function () {

        // Current experience count
        let index = $('.experience-box').length;

        let html = `
        <div class="experience-box">

            <h6 class="experience-title" style="color:#b8860b;font-weight:600;margin-bottom:15px;">
                Experience
            </h6>

            <button type="button"
                class="removeExperience"
                onclick="$(this).closest('.experience-box').remove(); updateExperienceNumbers();">
                &times;
            </button>

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label>Company Name</label>
                    <input type="text" name="company_name[]" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label>Designation</label>
                    <input type="text" name="designation[]" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label>Start Date</label>
                    <input type="month" name="start_date[]" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label>End Date</label>
                    <input type="month" name="end_date[]" class="form-control end-date">
                </div>

                <div class="form-group col-md-12">
                    <div class="form-check">

                        <input type="hidden"
                               name="currently_working[${index}]"
                               value="0">

                        <input type="checkbox"
                               name="currently_working[${index}]"
                               value="1"
                               class="form-check-input current-job">

                        <label class="form-check-label">
                            Currently Working Here
                        </label>

                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>Job Description</label>
                    <textarea name="job_description[]" class="form-control" rows="3"></textarea>
                </div>

            </div>

        </div>`;

        $('#experience_container').append(html);

        updateExperienceNumbers();
    });

    $(document).on('click', '.removeExperience', function () {
        $(this).closest('.experience-box').remove();
        updateExperienceNumbers();
    });

    $(document).on('change', '.current-job', function () {

        let endDate = $(this)
            .closest('.experience-box')
            .find('.end-date');

        if ($(this).is(':checked')) {
            endDate.val('');
            endDate.prop('disabled', true);
        } else {
            endDate.prop('disabled', false);
        }
    });

    updateExperienceNumbers();

});
</script>


<script type="text/javascript">
    
  $(document).ready(function () {

    function updateEditExperienceNumbers() {

        $('.edit-experience-title').each(function (index) {

            $(this).text('Experience ' + (index + 1));

        });

    }

    // Add Experience
    $('#editAddExperience').click(function () {

        let index = $('.edit-experience-box').length;

        let html = `
        <div class="edit-experience-box">

            <h6 class="edit-experience-title">
                Experience
            </h6>

            <button type="button" class="editRemoveExperience">&times;</button>

            <input type="hidden" name="experience_id[]" value="">

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label>Organization Name</label>
                    <input type="text" name="company_name[]" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label>Designation</label>
                    <input type="text" name="designation[]" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label>Start Date</label>
                    <input type="month" name="start_date[]" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label>End Date</label>
                    <input type="month" name="end_date[]" class="form-control edit-end-date">
                </div>

                <div class="form-group col-md-12">

                    <input type="hidden"
                           name="currently_working[${index}]"
                           value="0">

                    <div class="form-check">

                        <input type="checkbox"
                               class="form-check-input edit-current-job"
                               id="edit_current_job_${index}"
                               name="currently_working[${index}]"
                               value="1">

                        <label class="form-check-label"
                               for="edit_current_job_${index}">
                            Currently Working Here
                        </label>

                    </div>

                </div>

                <div class="form-group col-md-12">
                    <label>Job Description</label>
                    <textarea name="job_description[]" class="form-control" rows="3"></textarea>
                </div>

            </div>

        </div>`;

        $('#edit_experience_container').append(html);

        updateEditExperienceNumbers();

    });

    // Remove Experience
    $(document).on('click', '.editRemoveExperience', function () {

        $(this).closest('.edit-experience-box').remove();

        updateEditExperienceNumbers();

    });

    // Currently Working
    $(document).on('change', '.edit-current-job', function () {

        let endDate = $(this)
            .closest('.edit-experience-box')
            .find('.edit-end-date');

        if ($(this).is(':checked')) {

            endDate.val('');
            endDate.prop('disabled', true);

        } else {

            endDate.prop('disabled', false);

        }

    });

    // Existing Records
    $('.edit-current-job').trigger('change');

    updateEditExperienceNumbers();

});
</script>

  </body>
</html>