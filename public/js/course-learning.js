$(document).ready(function () {

    let item_list = $('.items-list');

    /* Material list listeners */

    $(".material-container").click(function (){

        $('.material-container.selected').addClass('showed');

        if($(this).hasClass('selected')){
            return;
        }

        $('.material-container').removeClass('selected');
        $(this).addClass('selected');

        let token = $('meta[name=csrf-token]').attr("content");

        let dataObj = {
            materialId: $(this).data('item'),
            _token: token
        };
        $.ajax({
            url: "http://localhost/laravel/public/course/get-material",
            method: "POST",
            data: dataObj,
            success: function (data) {
                $(".material-title-container h1").html(data.title);
                let temp_info;
                switch(data.type) {
                    case "Лекция":
                        $(".material-html-container").html(htmlPrettify(data.html));
                        break;
                    case "Видео":
                        let html = htmlPrettify(data.html);
                        $(".material-html-container").html(html + data.url);
                        break;
                    case "Тестирование":
                        testCreator(data);
                        break;
                }
            }
        });

    });

    $(".lesson-container").click(function (){
        let lesson_id = $(this).data('lesson');
        let current_item_list = null;

        for(let i = 0; i < item_list.length; i++){
            if (item_list.eq(i).data('lesson') === lesson_id){
                current_item_list = item_list.eq(i);
                if(current_item_list.hasClass('visible')){
                    return;
                } else {
                    item_list.hide();
                    item_list.removeClass('visible');
                    current_item_list.addClass('visible');
                    current_item_list.slideDown(500);
                    break;
                }
            }
        }

        current_item_list.children().eq(0).click();
    });

    $(".lesson-container").eq(0).click();

    function htmlPrettify(html) {
        let temp_info = "<p>" + html;
        temp_info = temp_info.replace(/(?:\r\n|\r|\n)/g, "</p><p>");
        temp_info += "</p>";
        return temp_info
    }

    function testCreator (testData) {
        let testInfo = htmlPrettify(testData.html);
        let testQuests = testData.questions;
        $(".material-html-container").html(testInfo);
        $(".material-html-container").append(" <form id=\"test-form\"></form>");
        for (let i = 0; i < testQuests.length; i++){
            let answerGroupContainer = "<div class=\"form-group\" data-question=" + i + "></div>"
            $("#test-form").append(answerGroupContainer);
            let questInfo = "<h4>" + testQuests[i].title + "</h4>";
            $(".form-group[data-question=" + i + " ]").append(questInfo);
            let isMultipleAnswers = multipleTrueAnswersCheck(testQuests[i].answers);
            for (let j = 0; j < testQuests[i].answers.length; j++){
                let formCheckHtml = "<div class=\"form-check\"data-answer=" + j + "></div>";
                $(".form-group[data-question=" + i + " ]").append(formCheckHtml);
                let answerInfo = "";
                if (isMultipleAnswers){
                    answerInfo = "<input type=\"checkbox\" name=\"quest" +
                        i +
                        "\" class=\"form-check-input test-answer\" id=\"answer" +
                        i + j +
                        "\"/>\n<label for=\"answer" +
                        i + j +
                        "\" class=\"form-check-label test-answer checkbox\">" +
                        testQuests[i].answers[j].title +
                        "</label>";
                } else {
                    answerInfo = "<input type=\"radio\" name=\"quest" +
                        i +
                        "\" class=\"form-check-input test-answer\" id=\"answer" +
                        i + j +
                        "\"/>\n<label for=\"answer" +
                        i + j +
                        "\" class=\"form-check-label test-answer\">" +
                        testQuests[i].answers[j].title +
                        "</label>";
                }
                $(".form-group[data-question=" + i + " ] .form-check[data-answer=" + j + " ]").append(answerInfo);
            }
        }
        $("#test-form").append("<button id=\"sendTest\">Отправить</button>");
    }

    function multipleTrueAnswersCheck(answers) {
        let count = 0;
        for (let j = 0; j < answers.length; j++)
            if (answers[j].correctness)
                count++;
        return count > 1;
    }



});
