$(document).ready(function () {

    let modal = $(".modal");
    let questions = $('.question');
    let quizID = $(".quiz-info-container").data('quiz');
    let courseID = $(".quiz-info-container").data('course');
    let currentAnswerUpdating = '';

    // Quiz

    $(".save-quiz-button").click(function () {
        let url = "http://localhost/laravel/public/constructor/course/id" + courseID;
        location.assign(url);
    });

    $(".update-quiz-info-button").click(function () {
        let dataObj = {
            lessonItemId: quizID,
            _token: $('meta[name=csrf-token]').attr("content")
        };
        $.ajax({
            url: 'http://localhost/laravel/public/constructor/get-lesson-item',
            method: 'POST',
            data: dataObj,
            success: function (data) {
                $('#updateQuizInfo #quizTitleInput').val(data.title);
                $('#updateQuizInfo #quizTextInput').val(data.html);
                $('#updateQuizInfo').modal('toggle');
            }
        })
    });

    $(".update-quiz-info-submit").click(function () {
        let quizTitle = $('#updateQuizInfo #quizTitleInput').val();
        let quizText = $('#updateQuizInfo #quizTextInput').val();
        if (quizTitle.length === 0
            || quizText.length === 0) {
            $('.form-creation-warning.checker').show();
        } else {
            $('.form-creation-warning.checker').hide();
            let dataObj = {
                _token: $('meta[name=csrf-token]').attr("content"),
                lessonItemTitle: quizTitle,
                html: quizText,
                courseId: courseID,
                lessonItemId: quizID
            };
            $.ajax({
                url: "http://localhost/laravel/public/constructor/update-lesson-item",
                method: "POST",
                data: dataObj,
                success: location.reload()
            });
        }
    });

    $(".update-quiz-goal-condition-button").click(function () {
        let dataObj = {
            quizId: quizID,
            _token: $('meta[name=csrf-token]').attr("content")
        };
        $.ajax({
            url: 'http://localhost/laravel/public/constructor/get-goal-condition',
            method: 'POST',
            data: dataObj,
            success: function (data) {
                if (data != null) {
                    $('#editGoalCondition #conditionInput5').val(data.gc5);
                    $('#editGoalCondition #conditionInput4').val(data.gc4);
                    $('#editGoalCondition #conditionInput3').val(data.gc3);
                }
                $('#editGoalCondition').modal('toggle');
            }
        })
    });

    $(".update-quiz-goal-condition-submit").click(function () {
        let gc5 = +$('#editGoalCondition #conditionInput5').val();
        let gc4 = +$('#editGoalCondition #conditionInput4').val();
        let gc3 = +$('#editGoalCondition #conditionInput3').val();
        $.ajax({
            url: 'http://localhost/laravel/public/constructor/get-question-count',
            method: 'POST',
            data: {
                quizId: quizID,
                _token: $('meta[name=csrf-token]').attr("content"),
            },
            success: function (quizQuestionCount) {
                if (gc5 < gc4
                    || gc4 < gc3
                    || gc5 < gc3
                    || gc5 > +quizQuestionCount
                    || gc5 === 0
                    || gc4 === 0
                    || gc3 === 0
                    || gc5 === gc4
                    || gc5 === gc3
                    || gc3 === gc4) {
                    $('.form-creation-warning.checker').show();
                } else {
                    $('.form-creation-warning.checker').hide();
                    let dataObj = {
                        quizId: quizID,
                        _token: $('meta[name=csrf-token]').attr("content"),
                        cond5: gc5,
                        cond4: gc4,
                        cond3: gc3,
                    };
                    $.ajax({
                        url: 'http://localhost/laravel/public/constructor/edit-goal-condition',
                        method: 'POST',
                        data: dataObj,
                        success: function () {
                            location.reload()
                        }
                    });
                }
            }
        });
    });

    $(".update-quiz-goal-condition-delete").click(function () {
        $.ajax({
            url: 'http://localhost/laravel/public/constructor/delete-goal-condition',
            method: 'POST',
            data: {
                quizId: quizID,
                _token: $('meta[name=csrf-token]').attr("content"),
            },
            success: function () {
                location.reload()
            }
        });
    });


    // Questions
    {


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
            }
        }
    });

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
            questionId: question,
            quizId: quizID,
        };
        $.ajax({
            url: "http://localhost/laravel/public/constructor/delete-question",
            method: "POST",
            data: dataObj,
            success: location.reload()
        });
    });
    }
    // Answers
    {



    $(".add-answer-submit").click(function(){
        let title = $("#addAnswer input[name=answer-title]").val();
        let quest_id = $('.question.selected').data('question');
        let correctnessInfo = $('#addAnswer #answerCorrectnessCheck').prop('checked');
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
            url: "http://localhost/laravel/public/constructor/get-answer",
            method: "POST",
            data: dataObj,
            success: function (item) {
                $('#updateAnswer input[name=answer-title]').val(item.title);
                $('#updateAnswer #answerCorrectnessCheck').prop( "checked", item.correctness);
                currentAnswerUpdating = dataObj.answerId;
                $('#updateAnswer').modal('toggle');
            }
        });
    });

    $(".update-answer-submit").click(function(){
        let title = $("#updateAnswer input[name=answer-title]").val();
        let quest_id = $('.question.selected').data('question');
        let correctnessInfo = $('#updateAnswer #answerCorrectnessCheck').prop('checked');
        if (title.length === 0) {
            $('.form-creation-warning.checker').show();
        }
        else {
            console.log(currentAnswerUpdating);
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
    }
    // Modal
    {
    $('.form-creation-warning.checker').hide();

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
    }
});
