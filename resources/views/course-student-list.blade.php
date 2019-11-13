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

    <title>[TEST]Обучающиеся на курсе</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="constructor-section">
                    <div class="course-info-detailed">
                        <div class="course-features">
                            <h1>Курс: {{$course->title}}</h1>
                            <p>Количество учеников: {{count($students)}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="student-list-table">
            <div class="row">
                <div class="col-2 head-student-list-table"><p class="head-student-list-table-text">ИД студента</p></div>
                <div class="col-6 head-student-list-table"><p class="head-student-list-table-text">ФИО студента</p></div>
                <div class="col-2 head-student-list-table"><p class="head-student-list-table-text">Статус курса</p></div>
                <div class="col-2 head-student-list-table last"><p class="head-student-list-table-text">Оценка за курс</p></div>
            </div>
            @foreach($students as $student)
                <div class="row">
                    <div class="col-2 row-student-list-table">{{$student->student_id}}</div>
                    <div class="col-6 row-student-list-table">{{$student->user->second}} {{$student->user->first}} {{$student->user->third}}</div>
                    <div class="col-2 row-student-list-table">
                        @if($student->status == 0)
                            <span>Назначен</span>
                        @elseif($student->status == 1)
                            <span>Назначен</span>
                        @else

                            <span>Пройден</span>
                        @endif
                    </div>
                    <div class="col-2 row-student-list-table last">
                        @if($student->final_grade == 0)
                            <span>Неизвестно</span>
                        @else
                            <span>{{$student->final_grade}}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
