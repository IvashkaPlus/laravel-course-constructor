<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ru">
<head>
    <meta content="utf-8" charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Styles-->
    <link rel="stylesheet" href="{{ asset('css/libs/bootstrap.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/constructor.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/libs/glyphicons.css')}}"  type="text/css"  />
    <!--Script Libs-->
    <script type="text/javascript" src="{{ asset('js/libs/jquery-3.4.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/libs/popper.min.js')}}" ></script>
    <script type="text/javascript" src="{{ asset('js/libs/bootstrap.js')}}" ></script>
    <!--Custom Scripts-->
    <script type="text/javascript" src="{{ asset('js/quiz-constructor.js')}}" ></script>

    <title>[TEST]Конструктор тестирования</title>
</head>
<body>
<div class="container-fluid" >
    <h1>Редактор тестирования</h1>
</div>
<div class="course-info container-fluid" style='margin-bottom: 1.5em'>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="constructor-section">
                <div class="row">
                    <div class="col-xl-11 col-md-10 col-sm-9 col-xs-6" >
                        <div class="quiz-info-container" data-quiz="{{$quiz->_id}}" data-course="{{$quiz->course_id}}">
                            <div class="quiz-name" style="margin-top: 1.5em"><h1>{{$quiz->title}}</h1></div>
                            <div class="quiz-description"><p>{{$quiz->html}}</p></div>
                        </div>
                    </div>
                    <div class="col-xl-1 col-md-2 col-sm-3 col-xs-6">
                        <div class="button-container-vertical">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-4" align="center">
                                    <div class="update-quiz-info-button constructor-button" data-toggle="modal"
                                         data-hint="true" title="Информация о тестировании" data-target="#updateQuizInfo">
                                        <div class="icon-place">
                                            <span class="glyphicon glyphicon-menu-hamburger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-4" align="center">
                                    <div class="save-quiz-button constructor-button" data-toggle="modal"
                                         data-hint="true"  title="Сохранить тестирование" data-target="#saveQuiz">
                                        <div class="icon-place">
                                            <span class="glyphicon glyphicon-floppy-saved"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="course-details container-fluid" style='margin-bottom: 1.5em'>
    <h3>Вопросы:</h3>
    <div class="row">
        <div class="col-xl-3 col-md-4 col-xs-6">
            <div class="question-container constructor-section">
                @foreach($quiz->questions as $key=>$items)
                    <div class="question" data-question="{{$key}}">{{$items['title']}}</div>
                @endforeach
                <div class="add-question-button" data-toggle="modal" data-target="#addQuestion"><span>Добавить вопрос</span></div>
            </div>
        </div>
        <div class="col-xl-9 col-md-8 col-xs-6">
            @foreach($quiz->questions as $key=>$quest)
                <div class="question-block" data-question="{{$key}}" style="display: none">
                    <div class="question-info-container">
                        <div class="row">
                            <div class="col-xl-11 col-md-10 col-sm-10 col-xs-8">
                                <h4>Вопрос: {{$quest['title']}}</h4>
                            </div>
                            <div class="col-xl-1 col-md-2 col-sm-2 col-xs-4">
                                <div class="button-container-vertical">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                            <div class="update-question-button constructor-button" title="Редактировать вопрос"
                                                     data-hint="true" data-item="{{$key}}" data-target="#updateQuestion">
                                                <div class="icon-place">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                            <div class="delete-question-button constructor-button" data-toggle="modal"
                                                 title="Удалить" data-hint="true" data-target="#deleteQuestion" data-item="">
                                                <div class="icon-place">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3>Ответы:</h3>
                    <div class="answers-container constructor-section">
                        <div class="answers-container">
                            @foreach($quest['answers'] as $key=>$answer)
                            <div class="answer" data-answer="{{$key}}">
                                <div class="row">
                                    <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-xs-8">
                                        <h4>{{$key+1}}) {{$answer['title']}}</h4>
                                        <p>Правильность ответа:
                                        @if($answer['correctness'])
                                            <span style="color: #31bf33 "><strong>Верно</strong></span>
                                            @else
                                            <span style="color: #d10a01"><strong>Неверно</strong></span>
                                        @endif
                                        </p>
                                    </div>
                                    <div class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                        <div class="button-container-vertical">
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                                    <div class="update-answer-button constructor-button" title="Редактировать"
                                                         data-hint="true" data-item="" data-target="#updateAnswer">
                                                        <div class="icon-place">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                                    <div class="delete-answer-button constructor-button" data-toggle="modal"
                                                         title="Удалить" data-hint="true" data-target="#deleteAnswer" data-item="">
                                                        <div class="icon-place">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="add-answer-button" data-toggle="modal" data-target="#addAnswer" style="display: none">
                            <span>Добавить ответ</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!--Modal windows-->
<div class="modal fade" id="addQuestion" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-question-form">
                <div class="modal-header">
                    <h5 class="modal-title" align="center">Введите новый вопрос</h5>
                </div>
                <div class="modal-body">
                    <input class="form-control" name="question-title" placeholder="Вопрос">
                    <small class="form-creation-warning checker">Пожалуйста, введите вопрос!</small>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary add-question-submit">Создать</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateQuestion" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-question-form">
                <div class="modal-header">
                    <h5 class="modal-title" align="center">Изменение</h5>
                </div>
                <div class="modal-body">
                    <input class="form-control" id="questionTitleInput" name="question-title" placeholder="Вопрос">
                    <small class="form-creation-warning checker">Пожалуйста, введите вопрос!</small>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary update-question-submit">Создать</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteQuestion" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Вы действительно хотите удалить этот вопрос?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary delete-question-submit">Да</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addAnswer" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-question-form">
                <div class="modal-header">
                    <h5 class="modal-title" align="center">Введите новый ответ</h5>
                </div>
                <div class="modal-body">
                    <input class="form-control" name="answer-title" placeholder="Ответ">
                    <input class="form-check-input" type="checkbox" value="" id="answerCorrectnessCheck">
                    <label class="form-check-label" for="answerCorrectnessCheck">
                        Корректность ответа
                    </label>
                    <small class="form-creation-warning checker">Пожалуйста, введите ответ!</small>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary add-answer-submit">Создать</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateAnswer" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-question-form">
                <div class="modal-header">
                    <h5 class="modal-title" align="center">Изменение ответа</h5>
                </div>
                <div class="modal-body">
                    <input class="form-control" name="answer-title" placeholder="Ответ">
                    <input class="form-check-input" type="checkbox" value="" id="answerCorrectnessCheck">
                    <label class="form-check-label" for="answerCorrectnessCheck">
                        Корректность ответа
                    </label>
                    <small class="form-creation-warning checker">Пожалуйста, введите ответ!</small>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary update-answer-submit">Создать</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteAnswer" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Вы действительно хотите удалить этот ответ?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary delete-answer-submit">Да</button>
            </div>
        </div>
    </div>
</div>
</body>
