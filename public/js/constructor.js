$(document).ready(function () {

    //Course Material

    let lessons = $('.lesson');
    let courseID = $(".course-info-container").data('course');
    let tempItem;
    let modal = $(".modal");

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

    $(".create-lesson-item-lecture").click(function(){
        let lectureTitle = $("#addLecture input[name=lectureTitle]").val();
        let lectureText = $("#addLecture textarea[name=html-lecture]").val();
        let type = "Лекция";
        console.log('1');
        if(lectureTitle.length == 0
        || lectureText.length == 0){
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
            // console.log(dataObj);
            $.ajax({
                url: "http://localhost/laravel/public/constructor/create-lesson-item",
                method: "POST",
                data: dataObj,
                success: location.reload()
            });
        }
    });

    $(".create-lesson-item-video").click(function(){
        let videoTitle = $("input[name=videoTitle]").val();
        let videoText = $("textarea[name=html-video]").val();
        let videoUrl = $("input[name=url]").val();
        if (videoTitle.length == 0
            || videoText.length == 0
            || videoUrl.length == 0){
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
                }
            }
        });
    });

    // $('#updateLecture').on('hidden.bs.modal', function (e) {
    //     $('#updateLecture #lectureTitleInput').val('');
    //     $('#updateLecture #lectureTextInput').val('');
    //     tempItem = '';
    // });

    $('.modal').on('hidden.bs.modal', function (e) {
        $(this).find('input').val('');
        $(this).find('textarea').val('');
    });

    $(".update-lesson-item-lecture").click(function(){
        let lectureTitle = $("#updateLecture input[name=lectureTitle]").val();
        let lectureText = $("#updateLecture textarea[name=html-lecture]").val();
        let type = "Лекция";
        console.log('0');
        if(lectureTitle.length == 0
            || lectureText.length == 0){
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
        // console.log(dataObj);
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

    $(".update-course-submit").click(function(){
    });

    $(".delete-course-submit").click(function(){

    });

    modal.find('input').val('');
    modal.find('textarea').val('');

    if(lessons.length > 0){
        lessons.first().click();
        $(".delete-lesson-button").show();
    }

    // Tooltip

    $(function () {
        $('[data-hint="true"]').tooltip(
            {
                delay: { show: 100, hide: 100 },
                placement: 'left'
            })
    })

    //Quiz Constructor

});
