/* ===== QUALIFICATION CHANGE (ADD + EDIT COMMON) ===== */
        $('#qualification_admin').on('change', function () {
        
            const qual_id   = $(this).val();
            const qual_name = $(this).find('option:selected').data('name');
        
            if (qual_id !== "") {
                $.ajax({
                    url: qualificationURL,
                    type: "POST",
                    data: { qual_id: qual_id },
                    dataType: "json",
                    success: function (data) {
        
                        $('#course_admin')
                            .empty()
                            .append('<option value="">Select Courses</option>');
        
                        $.each(data, function (i, item) {
                            $('#course_admin').append(
                                `<option value="${item.course_id}">${item.course_name}</option>`
                            );
                        });
        
                        $('#course_admin').selectpicker('refresh');
        
                        /* ===== EDIT MODE: course auto select ===== */
                        if (window.EDIT_COURSE_ID) {
                            $('#course_admin')
                                .val(window.EDIT_COURSE_ID)
                                .selectpicker('refresh');
                        }
                    }
                });
            } else {
                $('#course_admin')
                    .empty()
                    .append('<option value="">Select Courses</option>');
                $('#course_admin').selectpicker('refresh');
            }
        });
        
        
        /* ===== EDIT PAGE AUTO LOAD ===== */
        $(document).ready(function () {
        
            if (window.EDIT_QUAL_ID) {
                $('#qualification_admin')
                    .val(window.EDIT_QUAL_ID)
                    .trigger('change');
            }
        
        });