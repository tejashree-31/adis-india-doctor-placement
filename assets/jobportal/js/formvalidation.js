$(document).ready(function () {
  function checkInputs() {
    let allFilled = true;

    $('#myForm input[required], #myForm select[required], #myForm textarea[required]').each(function () {
      const $this = $(this);
      const type = $this.attr('type');
      const isFile = type === 'file';
      const isSelectPicker = $this.hasClass('selectpicker');
      const $dropdownToggle = isSelectPicker ? $this.parent().find('.dropdown-toggle') : null;
      const value = $this.val().trim();

      let isInvalid = false;

      // ✅ Pincode validation
      if ($this.attr('name') === 'pincode') {
        const pincodePattern = /^[1-9][0-9]{5}$/;
        isInvalid = !pincodePattern.test(value);
      }

      // ✅ Mobile number validation
      else if ($this.attr('name') === 'mobile_number') {
        const mobilePattern = /^[6-9]\d{9}$/;
        isInvalid = !mobilePattern.test(value);
      }

      // ✅ Default required validation
      else {
        isInvalid = (isFile && this.files.length === 0) || value === '';
      }

      if (isInvalid) {
        $this.addClass('is-invalid');
        $this.siblings('.invalid-feedback').show();
        if (isSelectPicker) $dropdownToggle.addClass('is-invalid');
        allFilled = false;
      } else {
        $this.removeClass('is-invalid');
        $this.siblings('.invalid-feedback').hide();
        if (isSelectPicker) $dropdownToggle.removeClass('is-invalid');
      }
    });

    $('#saveBtn').prop('disabled', !allFilled);
  }

  // Restrict mobile number to digits only
  $('#company-website-fb').on('input', function () {
    this.value = this.value.replace(/\D/g, '');
  });

  // Restrict pincode to digits only
  $('#company-tagline').on('input', function () {
    this.value = this.value.replace(/\D/g, '');
  });

  // Watch for changes
  $('#myForm input[required], #myForm textarea[required]').on('input change', checkInputs);
  $('#myForm select[required]').on('changed.bs.select change', checkInputs);

  // Initial check
  checkInputs();
});

//============================== recruiter Posting ======================//



$(document).ready(function () {
  function checkInputs() {
    let allFilled = true;

    // Validate required inputs, textareas, selects
    $('#recruiterpost input[required], #recruiterpost textarea[required], #recruiterpost select[required]').each(function () {
      const $field = $(this);
      const value = $field.val()?.trim();
      const type = $field.attr('type');
      const name = $field.attr('name');

      let isInvalid = (type === 'file' && this.files.length === 0) || value === '';

      // Numeric validation
      const numericFields = ['experience_min', 'experience_max', 'salary_min', 'salary_max', 'vacancies'];
      if (numericFields.includes(name)) {
        isInvalid = isInvalid || !/^\d+$/.test(value);
      }

      if (isInvalid) {
        $field.addClass('is-invalid');
        allFilled = false;
      } else {
        $field.removeClass('is-invalid');
      }
    });

    // ✅ Job Role Dropdown
    const jobRole = $('#job_role').val();
    if (!jobRole) {
      $('#job_role').addClass('is-invalid');
      $('#jobRoleError').show();
      allFilled = false;
    } else {
      $('#job_role').removeClass('is-invalid');
      $('#jobRoleError').hide();
    }

    // ✅ Gender Checkbox
    const genderChecked = $('input[name="gender[]"]:checked').length > 0;
    if (!genderChecked) {
      $('#genderError').show();
      allFilled = false;
    } else {
      $('#genderError').hide();
    }

    // ✅ Employment Type Radio
    const employmentChecked = $('input[name="employment_type"]:checked').length > 0;
    if (!employmentChecked) {
      $('#employmentTypeError').show();
      allFilled = false;
    } else {
      $('#employmentTypeError').hide();
    }

    // ✅ Shift Time Radio
    const shiftChecked = $('input[name="shift_time"]:checked').length > 0;
    if (!shiftChecked) {
      $('#shiftTimeError').show();
      allFilled = false;
    } else {
      $('#shiftTimeError').hide();
    }

    // ✅ Enable or disable Save button
    $('#postingsave').prop('disabled', !allFilled);
  }

  // Restrict to digits only in numeric fields
  $('#experience_min, #experience_max, #salary_min, #salary_max, #vacancies').on('input', function () {
    this.value = this.value.replace(/\D/g, '');
  });

  // Trigger checkInputs on relevant field changes
  $('#recruiterpost input[required], #recruiterpost textarea[required], #recruiterpost select[required]').on('input change', checkInputs);
  $('input[name="employment_type"], input[name="gender[]"], input[name="shift_time"]').on('change', checkInputs);
  $('#job_role').on('change', checkInputs);

  // Initial validation on page load
  checkInputs();
});





