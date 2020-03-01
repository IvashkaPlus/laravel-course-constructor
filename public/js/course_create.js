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

    // Edit course

    $(".edit-course-button").click(function (){
       let courseId = $(this).data('course');
       location.assign('http://localhost/laravel/public/constructor/course/id' + courseId);
    });

    // Setting course to students

    $('#studentSearcher').keyup(function (){
        let text = $(this).val();
        $.ajax(
            {
                url: "http://localhost/laravel/public/constructor/get-candidates",
                data:{
                    _token: $('meta[name=csrf-token]').attr("content"),
                    ln_query: text
                },
                method: 'POST',
                success: function (candidates) {
                    let html_candidates = '';
                    if(candidates.length === 0){
                        html_candidates = '<p>Пользователи не найдены</p>';
                    } else {
                        for(let i = 0; i<candidates.length; i++){
                            html_candidates += '<div class="candidate-block">\n' +
                                '<div class="form-check">\n' +
                                '<input class="form-check-input candidate-input" type="checkbox" value="" id="candidate'
                                + candidates[i].id + '" data-student="'+ candidates[i].id +  '">\n' +
                                '<label class="form-check-label" for="candidate' + candidates[i].id + '">\n' +
                                candidates[i].second + ' ' + candidates[i].first + ' ' + candidates[i].third +
                                '                                        </label>\n' +
                                '                                    </div>\n' +
                                '                                </div>';
                        }
                    }
                    $('#candidateToCourse').html(html_candidates);
                }
            }
        )
    });

    $(".set-course-submit").click(function (){
        let visible_students = $('.candidate-input');
        let students_to_set = [];
        for(let i = 0; i<visible_students.length; i++){
            if($(visible_students[i]).prop('checked')){
                students_to_set.push($(visible_students[i]).data('student'));
            }
        }
        if(students_to_set.length === 0){
            $('.form-creation-warning.checker').show();
        } else {
            $('.form-creation-warning.checker').hide();
            let dataObj = {
                _token: $('meta[name=csrf-token]').attr("content"),
                courseId: $(this).data('course'),
                studentsArray: students_to_set,
            };
            $.ajax({
                url: "http://localhost/laravel/public/constructor/set-course-to-student",
                data: dataObj,
                method: "POST",
                success: function (data) {
                    let html_candidates = 'Добавлено студентов на курс в количестве: ' + data.length;
                    $('#candidateToCourse').html(html_candidates);
                },
            });
        }
    });

    $(".course-setter-modal").click(function (){
        let courseId = $(this).data('course');
        $(".set-course-submit").data('course', courseId);
    });

    $(".course-student-list").click(function (){
        let courseId = $(this).data('course');
        location.assign('http://localhost/laravel/public/constructor/student-list/course/id' + courseId);
    });

    // Start course

    $(".course-start").click(function () {
        let courseId = $(this).data('course');
        let studentId = 1;
        let dataObj = {
            _token: $('meta[name=csrf-token]').attr("content"),
            courseId: courseId,
            studentId: studentId,
        };
        $.ajax({
            url: "http://localhost/laravel/public/course/check-student",
            data: dataObj,
            method: "POST",
            success: function (data) {
                if (data === '1'){
                    location.assign('http://localhost/laravel/public/course/learning/id' + courseId);
                } else {
                    alert("Чтобы попасть на данный курс, обратитесь к преподавателю");
                }
            },
        });
    });

});
