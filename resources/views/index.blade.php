<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="utf-8" charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Styles-->
    <link rel="stylesheet" href="{{ asset('css/libs/bootstrap.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/constructor.css')}}" type="text/css" />
    <!--Script Libs-->
    <script type="text/javascript" src="{{ asset('js/libs/jquery-3.4.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/libs/popper.min.js')}}" ></script>
    <script type="text/javascript" src="{{ asset('js/libs/bootstrap.js')}}" ></script>
    <!--Custom Scripts-->
    <script type="text/javascript" src="{{ asset('js/course_create.js')}}" ></script>

    <title>[TEST]Выберите курс</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="main-block-name" align="center">
                    <h1>Выберите курс</h1>
                </div>
            </div>
            <div class="col-12">
                <div class="container-fluid">
                    <div class="constructor-section">
                        <div class="row">
                            @foreach($courses as $course)
                                <div class="col-4" align="center">
                                    <a href="constructor/course/id{{$course->id}}">
                                    <div class="course-button edit">
                                        <div class="course-avatar-container">
                                            <img src="" alt="">
                                        </div>
                                        <div class="course-info-container">
                                            <h5>{{$course->title}}</h5>
                                            <p>{{$course->description}}</p>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            @endforeach
                            <div class="col-4" align="center">
                                <div class="course-button add" data-toggle="modal" data-target="#addCourse">
                                    <h5>Добавить новый курс</h5>
                                    <img src="{{asset('img/plus-15-15.png')}}" alt="Добавить курс">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Add course modal window-->
    <div class="modal bd-example-modal-lg fade" id="addCourse" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" align="center">Новый курс</h5>
                </div>
                <div class="modal-body">
                    <form action="{{asset('constructor/create-course')}}" method="post" id="courseCreateForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="courseNameInput">Название курса</label>
                            <input class="form-control" name="name" id="courseNameInput" placeholder="Название курса">
                            <small class="form-course-creation-warning name">Введите название курса!</small>
                        </div>
                        <div class="form-group">
                            <label for="courseSmallDescriptionInput">Краткое описание курса</label>
                            <textarea class="form-control" name="low_desc" id="courseSmallDescriptionInput" placeholder="Кратко опишите, о чем ваш курс"></textarea>
                            <small class="form-symbol-counter"><span>0</span>/150</small>
                        </div>
                        <div class="form-group">
                            <label for="courseSmallDescriptionInput">Описание курса</label>
                            <textarea rows="10" class="form-control" name="full_desc" id="courseSmallDescriptionInput" placeholder="Опишите как можно подробннее ваш курс. Программа обучения, для кого этот курс, какие знания и навыки приобретёт ученик"></textarea>
                            <small class = "form-hint">Описание не должно быть пустым</small>
                        </div>

                            <input type="file" name="picture" id="courseAvatarUpload">

                        <small class="form-course-creation-warning checker">Пожалуйста, заполните все поля корректно!</small>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary submit-add-course">Добавить</button>
                </div>
            </div>
        </div>
    </div>
</body>

