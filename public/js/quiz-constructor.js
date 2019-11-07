$(document).ready(function () {

    let modal = $(".modal");
    let questions = $('.question');
    let quizID = $(".quiz-info-container").data('quiz');
    let courseID = $(".quiz-info-container").data('course');
    let currentAnswerUpdating = '';

    $(".question").click(function (){
        if($(this).hasClass('selected')){return}

        let quest_id = $(this).data('question');
        let question_blocks = $('.question-block');

        $('.question-block').hide();

        $('.question').removeClass('selected');
        $(this).addClass('selected');

        for(let i = 0; i < question_blocks.length; i++){
            if ($('.question-block').eq(i).data('question') == quest_id){
                $('.question-block').eq(i).show();
                break;
            }
        }

    });

    // Questions

    $(".add-question-submit").click(function(){
        let title = $("#addQuestion input[name=question-title]").val();
        if (title.length === 0) {
            $('.form-creation-warning.checker').show();
        }
        else {
            $('.form-creation-warning.checker').hide();
            let token = $('meta[name=csrf-token]').attr("content");
            let dataObj = {
                _token: token,
                quizId: quizID,
                questTitle: title
            };
            $.ajax({
                url: "http://localhost/laravel/public/constructor/create-question",
                method: "POST",
                data: dataObj,
                success: location.reload()
            });
        }
    });

    $(".update-question-button").click(function(){
        let token = $('meta[name=csrf-token]').attr("content");
        let dataObj = {
            _token: token,
            questionId: $('.question.selected').data('question'),
            quizId: quizID,
        };
        $.ajax({
            url: "http://localhost/laravel/public/constructor/get-question",
            method: "POST",
            data: dataObj,
            success: function (item) {
                $('#updateQuestion input[name=question-title]').val(item);
                $('#updateQuestion').modal('toggle');
            }
        });
    });

    $(".update-question-submit").click(function(){
        let title = $("#updateQuestion input[name=question-title]").val();
        let quest_id = $('.question.selected').data('question');
        if (title.length === 0) {
            $('.form-creation-warning.checker').show();
        }
        else {
            $('.form-creation-warning.checker').hide();
            let token = $('meta[name=csrf-token]').attr("content");
            let dataObj = {
                _token: token,
                quizId: quizID,
                questTitle: title,
                questionId:quest_id
            };
            $.ajax({
                url: "http://localhost/laravel/public/constructor/update-question",
                method: "POST",
                data: dataObj,
                success: location.reload()
            });
        }
    });

    $(".delete-question-submit").click(function(){
        let question = $(".question.selected").data('question');
        let token = $('meta[name=csrf-token]').attr("content");
        let dataObj = {
            _token: token,
            courseId: courseID,
            questionId: question
        };
        $.ajax({
            url: "http://localhost/laravel/public/constructor/delete-question",
            method: "POST",
            data: dataObj,
            success: location.reload()
        });
    });

    // Answers

    $(".add-answer-button").click(function(){
        let title = $("#addAnswer input[name=answer-title]").val();
        let quest_id = $('.question.selected').data('question');
        let correctnessInfo = $('#addAnswer #answerCorrectnessCheck').val();
        if (title.length === 0) {
            $('.form-creation-warning.checker').show();
        }
        else {
            $('.form-creation-warning.checker').hide();
            let token = $('meta[name=csrf-token]').attr("content");
            let dataObj = {
                _token: token,
                quizId: quizID,
                answerTitle: title,
                questionId: quest_id,
                correctness: correctnessInfo,
            };
            $.ajax({
                url: "http://localhost/laravel/public/constructor/create-answer",
                method: "POST",
                data: dataObj,
                success: location.reload()
            });
        }
    });

    $(".update-answer-button").click(function(){
        let token = $('meta[name=csrf-token]').attr("content");
        let dataObj = {
            _token: token,
            questionId: $('.question.selected').data('question'),
            quizId: quizID,
            answerId: $(this).data("item")
        };
        $.ajax({
            url: "http://localhost/laravel/public/constructor/get-question",
            method: "POST",
            data: dataObj,
            success: function (item) {
                $('#updateAnswer input[name=answer-title]').val(item);
                $('#updateAnswer #answerCorrectnessCheck').val();
                currentAnswerUpdating = $(this).data("item");
                $('#updateAnswer').modal('toggle');
            }
        });
    });

    $(".update-answer-submit").click(function(){
        let title = $("#addAnswer input[name=answer-title]").val();
        let quest_id = $('.question.selected').data('question');
        let correctnessInfo = $('#addAnswer #answerCorrectnessCheck').val();
        if (title.length === 0) {
            $('.form-creation-warning.checker').show();
        }
        else {
            $('.form-creation-warning.checker').hide();
            let token = $('meta[name=csrf-token]').attr("content");
            let dataObj = {
                _token: token,
                quizId: quizID,
                answerTitle: title,
                questionId: quest_id,
                correctness: correctnessInfo,
                answerId: currentAnswerUpdating
            };
            $.ajax({
                url: "http://localhost/laravel/public/constructor/update-answer",
                method: "POST",
                data: dataObj,
                success: location.reload()
            });
        }
    });

    $(".delete-answer-submit").click(function(){
        let question = $(".question.selected").data('question');
        let token = $('meta[name=csrf-token]').attr("content");
        let dataObj = {
            _token: token,
            courseId: courseID,
            questionId: question,
            quizId: quizID,
            answerId: currentAnswerUpdating
        };
        $.ajax({
            url: "http://localhost/laravel/public/constructor/delete-answer",
            method: "POST",
            data: dataObj,
            success: location.reload()
        });
    });

    $(".delete-answer-button").click(function(){
        currentAnswerUpdating = ($(this).data("item"));
    });


    $(".save-quiz-button").click(function () {
       let url = "http://localhost/laravel/public/constructor/course/id" + courseID;
        location.assign(url);
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        $('.form-creation-warning.checker').hide();
        $(this).find('input').val('');
        $(this).find('textarea').val('');
    });

    modal.find('input').val('');
    modal.find('textarea').val('');

    if(questions.length > 0){
        questions.first().click();
        $(".delete-question-button").show();
        $(".add-answer-button").show();
    }

});
