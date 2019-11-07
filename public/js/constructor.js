$(document).ready(function () {

    //Course Material

    let lessons = $('.lesson');
    let courseID = $(".course-info-container").data('course');
    let tempItem = '';
    let modal = $(".modal");
    let lessonItems = $('.lesson-item');

    //Listeners

    //Lessons

    $(".lesson").click(function (){
        if($(this).hasClass('selected')){return}

        let lesson_id = $(this).data('lesson');
        let lesson_items = $('.lesson-item');

        $('.lesson-item').hide();
        $('.lesson').removeClass('selected');
        $(this).addClass('selected');

        for(let i = 0; i < lesson_items.length; i++){
            if ($('.lesson-item').eq(i).data('lesson') == lesson_id){
                $('.lesson-item').eq(i).show();
            }
        }
    });

    $(".add-lesson-submit").click(function(){
        let title = $("input[name=lesson-title]").val();
        if (title.length === 0) {
            $('.form-creation-warning.checker').show();
        }
        else {
            $('.form-creation-warning.checker').hide();
            let token = $('meta[name=csrf-token]').attr("content");
            let dataObj = {
                _token: token,
                courseId: courseID,
                lessonTitle: title
            };
            $.ajax({
                    url: "http://localhost/laravel/public/constructor/create-lesson",
                    method: "POST",
                    data: dataObj,
                    success: location.reload()
            });
        }
    });

    $(".update-lesson-submit").click(function(){

    });

    $(".delete-lesson-submit").click(function(){
        let lesson = $(".lesson.selected").data('lesson');
        let token = $('meta[name=csrf-token]').attr("content");
        let dataObj = {
            _token: token,
            courseId: courseID,
            lessonId: lesson
        };
        $.ajax({
            url: "http://localhost/laravel/public/constructor/delete-lesson",
            method: "POST",
            data: dataObj,
            success: location.reload()
        });
    });

    //Lesson Items

    $(".modal-lesson-item-lecture").click(function(){
        $('#addLessonItem').modal('toggle');
        $('#addLecture').modal('toggle');
    });

    $(".modal-lesson-item-video").click(function(){
        $('#addLessonItem').modal('toggle');
        $('#addVideo').modal('toggle');
    });

    $(".modal-lesson-item-quiz").click(function(){
        $('#addLessonItem').modal('toggle');
        $('#addQuiz').modal('toggle');
    });

    $(".create-lesson-item-lecture").click(function(){
        let lectureTitle = $("#addLecture input[name=lectureTitle]").val();
        let lectureText = $("#addLecture textarea[name=html-lecture]").val();
        let type = "Лекция";
        if(lectureTitle.length === 0
        || lectureText.length === 0){
            $('.form-creation-warning.checker').show();
        } else {
            $('.form-creation-warning.checker').hide();
            let lesson = $(".lesson.selected").data('lesson');
            let token = $('meta[name=csrf-token]').attr("content");
            let dataObj = {
                _token: token,
                lessonItemTitle: lectureTitle,
                html: lectureText,
                lessonId: lesson,
                lessonItemType: type,
                courseId: courseID,
            };
            $.ajax({
                url: "http://localhost/laravel/public/constructor/create-lesson-item",
                method: "POST",
                data: dataObj,
                success: location.reload()
            });
        }
    });

    $(".create-lesson-item-video").click(function(){
        let videoTitle = $("#add-video-form input[name=videoTitle]").val();
        let videoText = $("#add-video-form textarea[name=html-video]").val();
        let videoUrl = $("#add-video-form input[name=url]").val();
        if (videoTitle.length === 0
            || videoText.length === 0
            || videoUrl.length === 0){
            $('.form-creation-warning.checker').show();
        } else {
            $('.form-creation-warning.checker').hide();
            let lesson = $(".lesson.selected").data('lesson');
            let token = $('meta[name=csrf-token]').attr("content");
            let dataObj = {
                _token: token,
                lessonItemTitle: videoTitle,
                html: videoText,
                lessonId: lesson,
                url: videoUrl,
                lessonItemType: "Видео",
                courseId: courseID,
            };
            $.ajax({
                url: "http://localhost/laravel/public/constructor/create-lesson-item",
                method: "POST",
                data: dataObj,
                success: location.reload()
            });
        }
    });

    $(".create-lesson-item-quiz").click(function(){
        let quizTitle = $("#add-lesson-form input[name=quizTitle]").val();
        let quizText = $("#add-lesson-form textarea[name=html-quiz]").val();
        if (quizTitle.length === 0
            || quizText.length === 0){
            $('.form-creation-warning.checker').show();
        } else {
            $('.form-creation-warning.checker').hide();
            let lesson = $(".lesson.selected").data('lesson');
            let token = $('meta[name=csrf-token]').attr("content");
            let dataObj = {
                _token: token,
                lessonItemTitle: quizTitle,
                html: quizText,
                lessonId: lesson,
                lessonItemType: "Тестирование",
                courseId: courseID,
            };
            $.ajax({
                url: "http://localhost/laravel/public/constructor/create-lesson-item",
                method: "POST",
                data: dataObj,
                success: function (data) {
                    let url = "http://localhost/laravel/public/constructor/quiz/id_" + data;
                    location.assign(url);
                }
            });
        }
    });

    $(".update-lesson-item-button").click(function(){
        let token = $('meta[name=csrf-token]').attr("content");
        let dataObj = {
            _token: token,
            lessonItemId: $(this).data("item")
        };
        $.ajax({
            url: "http://localhost/laravel/public/constructor/get-lesson-item",
            method: "POST",
            data: dataObj,
            success: function (item) {
                tempItem = item._id;
                switch (item.type) {
                    case "Лекция":
                        $('#updateLecture #lectureTitleInput').val(item.title);
                        $('#updateLecture #lectureTextInput').val(item.html);
                        $('#updateLecture').modal('toggle');
                        break;
                    case "Видео":
                        break;
                    case "Тестирование":
                        let url = "http://localhost/laravel/public/constructor/quiz/id_" + tempItem;
                        location.assign(url);
                        break;
                }
            }
        });
    });

    $(".update-lesson-item-lecture").click(function(){
        let lectureTitle = $("#updateLecture input[name=lectureTitle]").val();
        let lectureText = $("#updateLecture textarea[name=html-lecture]").val();
        let type = "Лекция";
        console.log('0');
        if(lectureTitle.length === 0
            || lectureText.length === 0){
            $('.form-creation-warning.checker').show();
        } else {
            $('.form-creation-warning.checker').hide();
            let lesson = $(".lesson.selected").data('lesson');
            let token = $('meta[name=csrf-token]').attr("content");
            let dataObj = {
                _token: token,
                lessonItemTitle: lectureTitle,
                html: lectureText,
                lessonId: lesson,
                lessonItemType: type,
                courseId: courseID,
                lessonItemId: tempItem,
            };
            tempItem = '';
            $.ajax({
                url: "http://localhost/laravel/public/constructor/update-lesson-item",
                method: "POST",
                data: dataObj,
                success: location.reload()
            });
        }
    });

    $(".delete-lesson-item-submit").click(function(){
        let token = $('meta[name=csrf-token]').attr("content");
        let lesson = $(".lesson.selected").data('lesson');
        let dataObj = {
            _token: token,
            lessonId: lesson,
            lessonItemId: tempItem
        };
        tempItem = '';
        $.ajax({
            url: "http://localhost/laravel/public/constructor/delete-lesson-item",
            method: "POST",
            data: dataObj,
            success: location.reload()
        });
    });

    $(".delete-lesson-item-button").click(function(){
        tempItem = ($(this).data("item"));
    });

    //Course

    $(".update-course-button").click(function () {
        let dataObj = {
            courseId: courseID,
            _token: $('meta[name=csrf-token]').attr("content")
        };
       $.ajax({
            url:'http://localhost/laravel/public/constructor/get-course',
            method: 'POST',
            data: dataObj,
           success: function (data) {
               $('#updateCourse #courseNameInput').val(data.title);
               $('#updateCourse #courseSmallDescriptionInput').val(data.description);
               $('#updateCourse #courseFullDescriptionInput').val(data.full_description);
               $('.form-symbol-counter').find('span').text(data.description.length);
               if (text.length > 150)
                   $(".form-symbol-counter").addClass('warning');
               else
                   $(".form-symbol-counter").removeClass('warning');
               $('#updateCourse').modal('toggle');
           }
        })
    });

    $(".update-course-submit").click(function(){
        if($('#updateCourse #courseNameInput').val() === ''
           || $('#updateCourse #courseSmallDescriptionInput').val() === ''
           || $('#updateCourse #courseFullDescriptionInput').val() === ''){
            $('.form-creation-warning.checker').show();
        } else {
            $('.form-creation-warning.checker').hide();
            let dataObj = {
                _token: $('meta[name=csrf-token]').attr("content"),
                courseTitle: $('#updateCourse #courseNameInput').val(),
                courseLowDesc: $('#updateCourse #courseSmallDescriptionInput').val(),
                courseFullDesc: $('#updateCourse #courseFullDescriptionInput').val(),
                courseId: courseID
            };
            $.ajax({
                url: 'http://localhost/laravel/public/constructor/update-course',
                data: dataObj,
                method: 'POST',
                success: location.reload()
            });
        }

    });

    $(".delete-course-button").click(function(){
        let token = $('meta[name=csrf-token]').attr("content");
        $('#deleteCourseForm input[name=_token]').attr('value', token);
        $('#deleteCourseForm input[name=courseId]').val(courseID);
    });

    //Удаление курса во view в модалке

    $('#courseSmallDescriptionInput').keyup(function () {
        var text = $(this).val();
        $('.form-symbol-counter').find('span').text(text.length);
        if (text.length > 150)
            $(".form-symbol-counter").addClass('warning');
        else
            $(".form-symbol-counter").removeClass('warning');
    });

    // Modal

    $('.modal').on('hidden.bs.modal', function (e) {
        $('.form-creation-warning.checker').hide();
        $(this).find('input').val('');
        $(this).find('textarea').val('');
    });

    modal.find('input').val('');
    modal.find('textarea').val('');

    if(lessons.length > 0){
        lessons.first().click();
        $(".delete-lesson-button").show();
        $(".add-lesson-item-button").show();
    }

    // Tooltip

    $(function () {
        $('[data-hint="true"]').tooltip(
            {
                delay: { show: 100, hide: 100 },
                placement: 'left'
            })
    })


});
