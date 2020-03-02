<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="utf-8" charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Styles-->
    <link rel="stylesheet" href="{{ asset('css/libs/bootstrap.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/course-studying.css')}}" type="text/css" />
    <!--Script Libs-->
    <script type="text/javascript" src="{{ asset('js/libs/jquery-3.4.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/libs/popper.min.js')}}" ></script>
    <script type="text/javascript" src="{{ asset('js/libs/bootstrap.js')}}" ></script>
    <script type="text/javascript" src="{{ asset('js/course-learning.js')}}" ></script>
    <!--Custom Scripts-->

    <title>[TEST]Изучение курса</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                    <div class="lesson-list">
                        @foreach($course->lessons as $lesson)
                            <div class="lesson" data-lesson="{{$lesson->id}}">
                                <div class="lesson-container" data-lesson="{{$lesson->id}}">
                                    <h3>Урок: {{$lesson->title}}</h3>
                                </div>
                                <div class="items-list" data-lesson="{{$lesson->id}}">
                                    @foreach($lesson_items[$lesson->id] as $item)
                                        <div class="material-container" data-item="{{$item->_id}}">
                                            <h5>{{$item->type}}: {{$item->title}}</h5>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="material-content">
                    <div class="material-title-container">
                        <h1></h1>
                    </div>
                    <div class="material-html-container">
                        <p>Пройдите первое тестирование для проверки знаний.</p>
                        <form action="" class="test-form" method="post">
                            <div class="form-group">
                                <h4 class="question-container">Вопрос 1</h4>
                                <div class="form-check">
                                    <input type="radio" name="quest1" class="form-check-input test-answer" id="answer-11" />
                                    <label for="answer-11" class="form-check-label test-answer">Ответ 1</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio"  name="quest1" class="form-check-input test-answer test-answer" id="answer-12" />
                                    <label for="answer-12" class="form-check-label test-answer">Ответ 2</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio"  name="quest1" class="form-check-input test-answer test-answer" id="answer-13" />
                                    <label for="answer-13" class="form-check-label test-answer">Ответ 3</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio"  name="quest1" class="form-check-input test-answer test-answer" id="answer-14" />
                                    <label for="answer-14" class="form-check-label test-answer">Ответ 4</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <h4 class="question-container">Вопрос 2</h4>
                                <div class="form-check">
                                    <input type="checkbox" name="quest2" class="form-check-input test-answer" id="answer-21" />
                                    <label for="answer-21" class="form-check-label checkbox test-answer">Ответ 1</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox"  name="quest2" class="form-check-input test-answer" id="answer-22" />
                                    <label for="answer-22" class="form-check-label checkbox test-answer">Ответ 2</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox"  name="quest2" class="form-check-input test-answer" id="answer-23" />
                                    <label for="answer-23" class="form-check-label checkbox test-answer">Ответ 3</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox"  name="quest2" class="form-check-input test-answer" id="answer-24" />
                                    <label for="answer-24" class="form-check-label checkbox test-answer">Ответ 4</label>
                                </div>
                            </div>
                            <button id="sendTest">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
