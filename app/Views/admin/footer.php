<!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2025 Adis India Placement Pvt Ltd, Inc, All right reserved.</span>

                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>admin_assests/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/recruiterjs.js"></script>
    <script src="<?php echo base_url(); ?>admin_assests/assets/js/admin_allpage.js"></script>
    <script src="<?php echo base_url(); ?>admin_assests/assets/js/useful.js"></script>
      <script src="<?php echo base_url(); ?>admin_assests/assets/js/admin_validation.js"></script>
    <script src="<?= base_url(); ?>admin_assests/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script> const adminStatus ="<?= base_url('admin/update_admin_status') ?>";</script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>admin_assests/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>admin_assests/assets/js/sb-admin-2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/toastr.min.js"></script>

    <!-- Page level plugins -->
    <!-- <script src="<?//= base_url(); ?>admin_assests/assets/vendor/chart.js/Chart.min.js"></script> -->

    <!-- Page level custom scripts -->
   <!--  <script src="<?//= base_url(); ?>admin_assests/assets/js/demo/chart-area-demo.js"></script>
    <script src="<?//= base_url(); ?>admin_assests/assets/js/demo/chart-pie-demo.js"></script> -->
    <script src="<?= base_url(); ?>admin_assests/assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>admin_assests/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->
    <!-- Page level custom scripts -->
    <script src="<?= base_url(); ?>admin_assests/assets/js/demo/datatables-demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/jobportal/js/bootstrap-select.min.js"></script>
   
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
           const tblUserOtpStatus = "<?= base_url('admin/tblUserOtpStatus') ?>";
      </script>
     <script>
        const cityPincodeURL = "<?= base_url('admin/get_pincode') ?>";
    </script>
    <script type="text/javascript">
        $(document).ready(function () 
        {
            $(".comment-text").each(function () {
                var fullText = $(this).html().trim();
                var lineHeight = parseInt($(this).css("line-height"));
                var height = $(this).height();

                // Add "Read More" link only if text is long
                if (this.scrollHeight > height) {
                    $(this).after('<a href="javascript:void(0);" class="read-more">Read More</a>');

                    $(this).data("full-text", fullText); // save full text
                }
            });

            // Toggle
            $(document).on("click", ".read-more", function () {
                var $td = $(this).prev(".comment-text");

                if ($(this).text() === "Read More") {
                    $td.css({
                        "-webkit-line-clamp": "unset",
                        "max-height": "none"
                    });
                    $(this).text("Read Less");
                } else {
                    $td.css({
                        "-webkit-line-clamp": "3",
                        "max-height": "4.5em" // ~3 lines height
                    });
                    $(this).text("Read More");
                }
            });

            //delete 
           $(".delete-btn").on("click", function() {
            var blogId = $(this).data("id");
            var row = $(this).closest("tr");
    
            if(confirm("Are you sure you want to delete this blog?")) {
                $.ajax({
                    url: "<?= base_url('admin/delete_blog/'); ?>" + blogId,
                    type: "POST",
                    success: function(response) {
                        if(response.status === 'success') {
                            row.fadeOut(500, function() { $(this).remove(); });
    
                            // Show flash message
                            $("#flash-message").html(`
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Blog deleted successfully!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);
                        } else {
                            $("#flash-message").html(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ${response.message || "Failed to delete blog."}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);
                        }
                    },
                    error: function() {
                        $("#flash-message").html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Something went wrong.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                });
            }
        });
            });

         $("#institute_name").on("blur", function() {  // when input loses focus
        let instituteName = $(this).val();

        if (instituteName.length > 0) {
            $.ajax({
                url: "<?= base_url('check-institute') ?>",  // route in CI
                method: "POST",
                data: { institute_name: instituteName },
                success: function(response) {
                    if (response.exists) {
                        $("#institute_error").text("Institute name already exists!");
                        $("#institute_name").addClass("is-invalid");
                    } else {
                        $("#institute_error").text("");
                        $("#institute_name").removeClass("is-invalid").addClass("is-valid");
                    }
                }
            });
        }
    });
    
       $(".delete-btn-award").on("click", function() {
                var awardId = $(this).data("id");
                var row = $(this).closest("tr");

                if(confirm("Are you sure you want to delete this Award?")) {
                    $.ajax({
                        url: "<?= base_url('admin/delete_award/'); ?>" + awardId,
                        type: "POST",
                        success: function(response) {
                            if(response.status === 'success') {
                                row.fadeOut(500, function() { $(this).remove(); });

                                // Show flash message
                                $("#flash-message").html(`
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        Award deleted successfully!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                `);
                            } else {
                                $("#flash-message").html(`
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        ${response.message || "Failed to delete Award."}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                `);
                            }
                        },
                        error: function() {
                            $("#flash-message").html(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Something went wrong.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);
                        }
                    });
                }
            });
    </script>
    <script>
        $(document).ready(function(){

            $("#institute_name").on("input", function(){
                let instName = $(this).val();

                
                let emailName = instName.replace(/\s+/g, '').toLowerCase();

                if(emailName.length > 0){
                    $("#institute_email").val(emailName + "@gmail.com");
                } else {
                    $("#institute_email").val('');
                }
            });

        });
</script>
<script>
       const qualificationURL ="<?= base_url('get-courses') ?>";
      const selectedCourse = "<?= isset($data['course_id']) ? esc($data['course_id']) : '' ?>";
     
</script>   
 <script>
        const addJobRoleURL = "<?= base_url('recruiter/add_job_role') ?>";
</script>
<script>
        const addQualificationURL = "<?= base_url('recruiter/add_qualification') ?>";
</script>
<script type="text/javascript">
          const addCoursesURL ="<?= base_url('recruiter/add_course') ?>";
</script>
<script type="text/javascript">
          const addDepartmentURL ="<?= base_url('recruiter/add_department') ?>";
</script>
<script type="text/javascript">
     const addcityeURL = "<?= base_url('admin/add_city') ?>";
</script>
<script type="text/javascript">
     const featchStates = "<?= base_url('admin/fetch_states') ?>";
</script>
<script type="text/javascript">
    const featchDisrict = "<?= base_url('admin/fetch_districts') ?>";
</script>
<script type="text/javascript">
     const featchCity = "<?= base_url('admin/fetch_cities') ?>";
</script> 
<script type="text/javascript">
    const fetchStatesedit = "<?= base_url('admin/fetch_states_edit') ?>";
</script> 
<script type="text/javascript">
     const fetchDistrictsedit = "<?= base_url('admin/fetch_districts_edit') ?>";
</script>  
<script type="text/javascript">
    const fetchCitiesedit = "<?= base_url('admin/fetch_cities_edit') ?>";
</script>
<script type="text/javascript">
    const updateEmailStatus = "<?= base_url('admin/update_admin_email_status')?>";
    const updateClient_recive_Status = "<?= base_url('admin/update_recived_client_payment_status') ?>";
</script>
<script type="text/javascript">
    const updateClient_email_Status ="<?= base_url('admin/update_client_email_status') ?>";
</script>
<script type="text/javascript">
    const SendagreementCandidate ="<?= base_url('admin/sendagreementCandidate') ?>";
</script>
<script type="text/javascript">
  

$(document).ready(function () {

    $(document).on('change', '.send_email_resume_to_client', function () {

        let checkbox = $(this);

        // get both ids
        let user_id = checkbox.data('user-id');
        let jobseeker_id = checkbox.data('jobseeker-id');
        // alert(user_id);
        // alert(jobseeker_id);

        let status = checkbox.is(':checked') ? 1 : 0;

        // debug
        // alert(user_id + ' | ' + jobseeker_id);

        let msg = status == 1
            ? "Are you sure you want to send the Resume?"
            : "Are you sure you want to undo the received status?";

        if (!confirm(msg)) {
            checkbox.prop('checked', !status);
            return;
        }

        $.ajax({
           url: "<?= base_url('admin/update_Resume_Client_email_Status') ?>",
            type: "POST",
            data: {
                user_id: user_id,
                jobseeker_id: jobseeker_id,
                send_email: status
            },
            success: function (response) {

                $("#updateSuccessMsg_status")
                    .html("Updated Successfully")
                    .fadeIn()
                    .delay(1000)
                    .fadeOut();
            }
        });

    });

});

</script>
<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.toggle-more', function () {
        var moreText = $(this).siblings('.more-text');
        if (moreText.hasClass('d-none')) {
            moreText.removeClass('d-none');
            $(this).text('Less...');
        } else {
            moreText.addClass('d-none');
            $(this).text('More...');
        }
    });
});
</script>
<script>
function viewAndDownload(url) {
    window.open(url, '_blank'); // view
    setTimeout(() => {
        const a = document.createElement('a');
        a.href = url;
        a.download = '';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }, 2000);
}
</script>

<script>
$(document).on('change', '.agreementUpload', function () {

    let jobStatusId = $(this).data('id');
    let fileInput  = this;
    let file       = fileInput.files[0];

    if (!file) return;

    if (file.type !== 'application/pdf') {
        alert('Only PDF allowed');
        fileInput.value = '';
        return;
    }

    let formData = new FormData();
    formData.append('job_status_id', jobStatusId);
    formData.append('agreement_file', file);

    $('#status-' + jobStatusId).html('Uploading... ⏳');

    $.ajax({
        url: "<?= base_url('upload-agreement-ajax') ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function (res) {

            if (res.status === 'success') {

                $('#status-' + jobStatusId).html('Uploaded ✔');

                // hide file input after upload (optional)
                $(fileInput).hide();

                // show uploaded file link
                $('#file-' + jobStatusId).html(
                    `<a href="${res.file_url}" target="_blank">
                        📄 ${res.file_name}
                     </a>`
                );

            } else {
                $('#status-' + jobStatusId).html('Failed ❌');
            }
        },

        error: function () {
            $('#status-' + jobStatusId).html('Error ❌');
        }
    });
});

$(document).ready(function(){

    $(".award-desc").each(function(){

        var textLength = $(this).text().length;

        if(textLength > 200){

            $(this).addClass("short");
            $(this).after('<a href="#" class="read-toggle">Read More</a>');

        }

    });

    $(document).on("click",".read-toggle",function(e){

        e.preventDefault();

        var content = $(this).prev(".award-desc");

        if(content.hasClass("short")){
            content.removeClass("short");
            $(this).text("Read Less");
        }else{
            content.addClass("short");
            $(this).text("Read More");
        }

    });

});
</script>
<script>
    window.EDIT_QUAL_ID   = "<?= $single_posting_edit['qual_id'] ?? '' ?>";
    window.EDIT_COURSE_ID = "<?= $single_posting_edit['course_id'] ?? '' ?>";
</script>

<script type="text/javascript">
        const ChangeToggle ="<?= base_url('admin/update-ChangeToggle-status') ?>";
        const addleadURL ="<?= base_url('admin/add_lead_url') ?>";
</script>

</body>

</html>