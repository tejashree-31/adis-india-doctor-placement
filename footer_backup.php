
<footer class="site-footer">

      <a href="#top" class="smoothscroll scroll-top">
        <span class="icon-keyboard_arrow_up"></span>
      </a>

      <div class="container">
        <div class="row mb-5">
          <div class="col-6 col-md-3 mb-4 mb-md-0">
            <h3>Search Trending</h3>
            <ul class="list-unstyled">
              <li><a href="#">Web Design</a></li>
              <li><a href="#">Graphic Design</a></li>
              <li><a href="#">Web Developers</a></li>
              <li><a href="#">Python</a></li>
              <li><a href="#">HTML5</a></li>
              <li><a href="#">CSS3</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3 mb-4 mb-md-0">
            <h3>Company</h3>
            <ul class="list-unstyled">
              <li><a href="#">About Us</a></li>
              <li><a href="#">Career</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">Resources</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3 mb-4 mb-md-0">
            <h3>Support</h3>
            <ul class="list-unstyled">
              <li><a href="#">Support</a></li>
              <li><a href="#">Privacy</a></li>
              <li><a href="#">Terms of Service</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3 mb-4 mb-md-0">
            <h3>Contact Us</h3>
            <div class="footer-social">
              <a href="#"><span class="icon-facebook"></span></a>
              <a href="#"><span class="icon-twitter"></span></a>
              <a href="#"><span class="icon-instagram"></span></a>
              <a href="#"><span class="icon-linkedin"></span></a>
            </div>
          </div>
        </div>

        <div class="row text-center">
          <div class="col-12">
            <p class="copyright"><small>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;2022 Adis India Placement Pvt Ltd, Inc, All right reserved. <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
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
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/recruiterjs.js"></script>
    <script>
      const selectedCourse = "<?= isset($data['course_id']) ? esc($data['course_id']) : '' ?>";
      const qualificationURL ="<?= base_url('get-courses') ?>";
      


</script>
    <!-- <script src="<?php //echo base_url(); ?>assets/jobportal/js/recruiterjs.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/jobportal/js/modal.js"></script>

   <script>
  // $(document).ready(function () {
  //   $('.select').selectpicker();

  //   $('#industry1').on('changed.bs.select', function () {
  //     const selectedText = $(this).find("option:selected").text().trim().toLowerCase();
  //     $('#hospitalTypeDiv1').toggle(selectedText === 'hospital');
  //   });
  // });


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
  // $(document).ready(function() {
  //   $('#job_role').select2({
  //     placeholder: "Select job_role",
  //     allowClear: true,
  //     width: '100%'
  //   });
  // });
</script>

<script>
// $(document).ready(function () {
//   // Show input on "Add" button click
//   $('#addJobRoleBtn').click(function () {
//     $('#jobRoleInputWrapper').show();
//     $('#newJobRole').val('').focus();
//   });

// });

// $('#cancelJobRole').click(function () {
//   $('#jobRoleInputWrapper').hide();
//   $('#newJobRole').val('');
// });
// </script>
<script>
  const addJobRoleURL = "<?= base_url('recruiter/add_job_role') ?>";
</script>
<script>
  const addQualificationURL = "<?= base_url('recruiter/add_qualification') ?>";
</script>


<script type="text/javascript">
    const addCoursesURL ="<?= base_url('recruiter/add_course') ?>";
</script>
<script>
  const imageUpload ="<?= base_url('recruiter/upload_company_profile') ?>";
  const addAbout ="<?= base_url('recruiter/add_about') ?>";
  const Savegallery ="<?= base_url('recruiter/add_gallery') ?>";

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
$(document).ready(function () {
    $('.selectpicker').selectpicker();

    $('form').on('submit', function (e) {
        const selected = $('#expected_cities').val();
        if (!selected || selected.length === 0) {
            e.preventDefault();
            $('#expectedCitiesError').show();
        } else {
            $('#expectedCitiesError').hide();
        }
    });
});
</script>
<script>
  const deleteGalleryUrl = "<?= base_url('recruiter/delete_gallery_item') ?>";
 // $(document).ready(function () {
 //    $('#goToPublish').on('click', function () {
 //      $('#draft').removeClass('show active');
 //      $('#publish').addClass('show active');

 //      $(this).addClass('active');
 //      $('#goToDraft').removeClass('active');
 //    });

 //    $('#goToDraft').on('click', function () {
 //      $('#publish').removeClass('show active');
 //      $('#draft').addClass('show active');

 //      $(this).addClass('active');
 //      $('#goToPublish').removeClass('active');
 //    });
 //  });

//  $(document).ready(function () {
//   $('#goToPublish_update').on('click', function () {
//     $('#draft_update, #preview_update').removeClass('show active');
//     $('#publish_update').addClass('show active');

//     $(this).addClass('active');
//     $('#goToDraft_update, #goToPreview_update').removeClass('active');
//   });

//   $('#goToDraft_update').on('click', function () {
//     $('#publish_update, #preview_update').removeClass('show active');
//     $('#draft_update').addClass('show active');

//     $(this).addClass('active');
//     $('#goToPublish_update, #goToPreview_update').removeClass('active');
//   });

//   $('#goToPreview_update').on('click', function () {
//     $('#publish_update, #draft_update').removeClass('show active');
//     $('#preview_update').addClass('show active');

//     $(this).addClass('active');
//     $('#goToPublish_update, #goToDraft_update').removeClass('active');
//   });
// });

</script>



  </body>
</html>