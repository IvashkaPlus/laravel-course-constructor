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
    <script type="text/javascript" src="{{ asset('js/constructor.js')}}" ></script>

    <title>[TEST]Конструктор курсов</title>
</head>
<body>
<div class="container-fluid" >
    <h1>Редактор курса</h1>
</div>
<div class="course-info container-fluid" style='margin-bottom: 1.5em'>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="constructor-section">
                <div class="row">
                    <div class="col-xl-2 col-md-2 col-sm-3 col-xs-12">
                        <div class="course-avatar-container">
                            <img alt="Иконка курса" src="{{asset('img/document.svg')}}" width="100%"/>
                        </div>
                    </div>
                    <div class="col-xl-9 col-md-8 col-sm-6 col-xs-6 course-info-container" data-course="{{$course->id}}">
                        <div class="course-name" style="margin-top: 1.5em"><h1>{{$course->title}}</h1></div>
                        <div class="course-description">
                            <p>{{$course->description}}</p>
                            <p>Автор курса:<br>Количество уроков: {{count($course->lessons)}}</p>
                        </div>
                    </div>
                    <div class="col-xl-1 col-md-2 col-sm-3 col-xs-6">
                        <div class="button-container-vertical">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-4" align="center">
                                    <div class="teacher-list-button constructor-button disabled" data-toggle="modal"
                                         data-hint="true" title="Преподаватели курса" data-target="#teacherList">
                                        <div class="icon-place">
                                            <span class="glyphicon glyphicon-education"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-4" align="center">
                                    <div class="update-course-button constructor-button" data-toggle="modal"
                                         data-hint="true" title="Информация о курсе" data-target="#updateCourse">
                                        <div class="icon-place">
                                            <span class="glyphicon glyphicon-menu-hamburger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-4" align="center">
                                    <div class="delete-course-button constructor-button" data-toggle="modal"
                                         data-hint="true"  title="Удалить курс" data-target="#deleteCourse">
                                        <div class="icon-place">
                                            <span class="glyphicon glyphicon-trash" style="color: #a50a01 "></span>
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
    <div class="row">
        <div class="col-md-4 col-xs-6">
            <h3>Уроки:</h3>
            <div class="lessons-container constructor-section">
                @foreach($course->lessons as $lesson)
                    <div class="lesson" data-lesson="{{$lesson->id}}">Урок: {{$lesson->title}}</div>
                @endforeach
                <div class="add-lesson-button" data-toggle="modal" data-target="#addLesson"><span>Добавить урок</span></div>
            </div>
        </div>
        <div class="col-md-8 col-xs-6">
            <div class="row">
                <div class="col-xl-10 col-md-8 col-sm-6 col-xs-6">
                    <h3>Материалы урока:</h3>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 col-xs-6">
                    <div class="delete-lesson-button" data-toggle="modal" data-target="#deleteLesson" style="display: none"><span>Удалить урок</span></div>
                </div>
            </div>
            <div class="lesson-items-container constructor-section">
                <div class="lesson-items-container">
                    @foreach($lesson_items as $key=>$items)
                        @foreach($items as $item)
                        <div class="lesson-item" data-lesson="{{$key}}" style="display: none">
                            <div class="row">
                                <div class="col-xl-10 col-md-10 col-sm-10 col-xs-8">
                                    <div class="lesson-item-info" >
                                        <h4>{{$item->type}}: {{$item->title}}</h4>
                                        <p>{{$item->html}}</p>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-2 col-xs-4">
                                    <div class="button-container-vertical">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                                <div class="update-lesson-item-button constructor-button" title="Редактировать"
                                                data-hint="true" data-item="{{$item->_id}}">
                                                    <div class="icon-place">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" align="center">
                                                <div class="delete-lesson-item-button constructor-button" data-toggle="modal"
                                                     title="Удалить" data-hint="true" data-target="#deleteLessonItem" data-item="{{$item->_id}}">
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
                     @endforeach
                </div>
                <div class="add-lesson-item-button" data-toggle="modal" data-target="#addLessonItem" style="display: none">
                    <span>Добавить материал</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Windows -->
<div class="modal bd-example-modal-lg fade" id="updateCourse" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Изменение информации курса</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="courseNameInput">Название курса</label>
                    <input class="form-control" name="name" id="courseNameInput" placeholder="Название курса">
                </div>
                <div class="form-group">
                    <label for="courseSmallDescriptionInput">Краткое описание курса</label>
                    <textarea class="form-control" name="low_desc" id="courseSmallDescriptionInput" placeholder="Кратко опишите, о чем ваш курс"></textarea>
                    <small class="form-symbol-counter"><span>0</span>/150</small>
                </div>
                <div class="form-group">
                    <label for="courseSmallDescriptionInput">Описание курса</label>
                    <textarea rows="10" class="form-control" name="full_desc" id="courseFullDescriptionInput" placeholder="Опишите как можно подробннее ваш курс. Программа обучения, для кого этот курс, какие знания и навыки приобретёт ученик"></textarea>
                </div>

                <input type="file" name="picture" id="courseAvatarUpload" disabled>

                <small class="form-creation-warning checker">Пожалуйста, заполните все поля корректно!</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary update-course-submit">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteCourse" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{asset('constructor/delete-course')}}"  id="deleteCourseForm" method="post">
                <input type="hidden" name="_token" value="">
                <input name="courseId" value="{{$course->id}}" style="display: none">
                <div class="modal-header">

                    <h5 class="modal-title" align="center">Вы действительно хотите удалить данный курс?</h5>
                </div>
                <div class="modal-body">
                    <p class="text-attention">Внимание!</p> <p>Все материалы и уроки, связанные с курсом будут удалены!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary delete-course-submit">Да</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addLesson" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-lesson-form">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" align="center">Введите название нового урока</h5>
                </div>
                <div class="modal-body">
                    <input class="form-control" name="lesson-title" placeholder="Название урока">
                    <small class="form-creation-warning checker">Пожалуйста, введите название урока!</small>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary add-lesson-submit">Создать</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteLesson" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Вы действительно хотите удалить этот урок?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary delete-lesson-submit">Да</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addLessonItem" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Выберете, что нужно добавить к вашему уроку:</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="constructor-button modal-lesson-item-lecture add-lesson-item">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="icon-place large">
                                            <span class="glyphicon glyphicon-text-size"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 button-content">
                                        Лекция
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="constructor-button modal-lesson-item-video add-lesson-item">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="icon-place large">
                                            <span class="glyphicon glyphicon-film"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 button-content">
                                        Видеозапись
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="constructor-button modal-lesson-item-quiz add-lesson-item">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="icon-place large">
                                            <span class="glyphicon glyphicon-check"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 button-content">
                                        Тестирование
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
<div class="modal bd-example-modal-lg fade" id="addLecture" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Новая лекция</h5>
            </div>
            <div class="modal-body">
                <form id="lectureCreateForm">
                    <div class="form-group">
                        <label for="lectureTitleInput">Название лекции</label>
                        <input class="form-control" name="lectureTitle" id="lectureTitleInput" placeholder="Название лекции">
                    </div>
                    <div class="form-group">
                        <label for="lectureTextInput">Текст лекции</label>
                        <textarea rows="10" class="form-control" name="html-lecture" id="lectureTextInput" placeholder=""></textarea>
                    </div>
                    <small class="form-creation-warning checker">Пожалуйста, заполните все поля корректно!</small>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary create-lesson-item-lecture">Добавить</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addVideo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Новое видео</h5>
            </div>
            <div class="modal-body">
                <form id="add-video-form">
                    <div class="form-group">
                        <label for="videoTitleInput">Название</label>
                        <input class="form-control" name="videoTitle" id="videoTitleInput" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="videoTitleInput">Ссылка на видео (только YouTube)</label>
                        <input class="form-control" name="url" id="videoUrlInput" placeholder="Пример: https://youtu.be/0eOu0R24F-c">
                    </div>
                    <div class="form-group">
                        <label for="videoTextInput">Описание видео</label>
                        <textarea rows="5" class="form-control" name="html-video" id="videoTextInput"
                                  placeholder="Опишите в двух словах, о чем в видео пойдет речь"></textarea>
                    </div>
                    <small class="form-creation-warning checker">Пожалуйста, заполните все поля корректно!</small>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary create-lesson-item-video">Добавить</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addQuiz" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Новое тестирование</h5>
            </div>
            <div class="modal-body">
                <form id="videoCreateForm">
                    <div class="form-group">
                        <label for="quizTitleInput">Название</label>
                        <input class="form-control" name="quizTitle" id="quizTitleInput" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="quizTextInput">Описание тестирования</label>
                        <textarea rows="5" class="form-control" name="html-quiz" id="quizTextInput"
                                  placeholder=""></textarea>
                    </div>
                    <small class="form-creation-warning checker">Пожалуйста, заполните все поля корректно!</small>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary create-lesson-item-quiz">Добавить</button>
            </div>
        </div>
    </div>
</div>
<div class="modal bd-example-modal-lg fade" id="updateLecture" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Изменение лекции</h5>
            </div>
            <div class="modal-body">
                <form id="lectureCreateForm">
                    <div class="form-group">
                        <label for="lectureTitleInput">Название лекции</label>
                        <input class="form-control" name="lectureTitle" id="lectureTitleInput" placeholder="Название лекции">
                    </div>
                    <div class="form-group">
                        <label for="lectureTextInput">Текст лекции</label>
                        <textarea rows="10" class="form-control" name="html-lecture" id="lectureTextInput" placeholder=""></textarea>
                    </div>
                    <small class="form-creation-warning checker">Пожалуйста, заполните все поля корректно!</small>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary update-lesson-item-lecture">Изменить</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateVideo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Изменить информация о видео</h5>
            </div>
            <div class="modal-body">
                <form id="update-video-form">
                    <div class="form-group">
                        <label for="videoTitleInput">Название</label>
                        <input class="form-control" name="videoTitle" id="videoTitleInput" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="videoUrlInput">Ссылка на видео (только YouTube)</label>
                        <input class="form-control" name="url" id="videoUrlInput" placeholder="Пример: https://youtu.be/0eOu0R24F-c">
                    </div>
                    <div class="form-group">
                        <label for="videoTextInput">Описание видео</label>
                        <textarea rows="5" class="form-control" name="html-video" id="videoTextInput"
                                  placeholder="Опишите в двух словах, о чем в видео пойдет речь"></textarea>
                    </div>
                    <small class="form-creation-warning checker">Пожалуйста, заполните все поля корректно!</small>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary update-lesson-item-video">Изменить</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteLessonItem" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" align="center">Вы действительно хотите удалить материал?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary delete-lesson-item-submit" data-item="">Да</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
