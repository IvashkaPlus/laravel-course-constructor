$(document).ready(function () {

    $("#courseNameInput").change(function () {
        var text = $(this).val();
        if (text.length === 0)
            $('.form-course-creation-warning.name').show();
        else
            $('.form-course-creation-warning.name').hide();
    });

    $('#courseSmallDescriptionInput').keyup(function () {
        var text = $(this).val();
        $('.form-symbol-counter').find('span').text(text.length);
        if (text.length > 150)
            $(".form-symbol-counter").addClass('warning');
        else
            $(".form-symbol-counter").removeClass('warning');

    });

    $('.submit-add-course').click(function () {
        var courseLowDesc = $("textarea[name=low_desc]").val();
        var courseFullDesc = $("textarea[name=full_desc]").val();
        var courseName = $("input[name=name]").val();

        if (courseLowDesc.length > 150
            || courseLowDesc.length === 0
            || courseFullDesc.length === 0
            || courseName.length === 0) {
            $('.form-course-creation-warning.checker').show();
        } else {
            $("#courseCreateForm").submit();
        }
    });

});
