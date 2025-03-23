@extends('layouts.layout')

@section('content')

<head>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    <div class="list-container">

        <div class="panel">
            <a href="{{ route('home') }}">
                <div class="logo">
                    <i class="fa-duotone fa-solid fa-clipboard-list"
                        style="--fa-primary-color: #dbdbdb; --fa-secondary-color: #dbdbdb;"></i>
                </div>
            </a>

            <div class="controls">
                <div class="dropdown-button createTaskBtn">
                    <ul class="dropdown">
                        <div class="dropdown-title">
                            <span>Создать задачу <i class="fa-solid fa-pen-to-square"
                                    style="color: #000000; margin-left: 4px"></i></i></span>
                        </div>
                        <div class="dropdown-items">
                            <form action="{{ route('create') }}" method="POST">
                                @csrf
                                <li>
                                    <input type="text" class="form-control inputEdit" name="name" placeholder="Название"
                                        autocomplete="off">
                                    <textarea type="text" class="form-control inputEdit descriptionEdit" name="description"
                                        placeholder="Описание"></textarea>
                                    <select class="form-select inputEdit" name="status" aria-label="Default select example">
                                        <option value="Активно">Активно</option>
                                        <option value="Завершено">Завершено</option>
                                        <option value="Ожидание">Ожидание</option>
                                    </select>
                                    <input type="date" class="form-control inputEdit no-calendar" name="deadline"
                                        placeholder="Дедлайн">
                                </li>
                                <li>
                                    <button type="submit" class="btnnav">Сохранить <i class="fa-solid fa-circle-check"
                                            style="color: #2b2b2b; margin-left: 5px"></i></button>
                                </li>
                            </form>
                        </div>
                    </ul>
                </div>

                {{-- ========================================= Dropdown ========================================= --}}
                <div class="dropdown-button dropdown-sort-btn">
                    <ul class="dropdown dropdown-sort">
                        <div class="dropdown-title">
                            <span>Сортировать по <i class="fa-solid fa-arrow-up-wide-short"
                                    style="color: #000000; margin-left: 4px"></i></span>
                        </div>
                        <div class="dropdown-items">
                            {{-- Основной выпадающий список --}}

                            <li>
                                <input type="checkbox" id="date-checkbox" />
                                <label for="date-checkbox" class="dateLabel"><i class="fa-solid fa-calendar-days"
                                        style="color: #000000;"></i> Дате </label>
                                <input type="date" id="date-input" class="date-input form-control"
                                    onchange="updateDate(this.value)" />
                                <script>
                                    function updateDate(date) {
                                        const url = new URL(window.location.href);
                                        url.searchParams.set('date', date);
                                        window.location.href = url.toString();
                                    }
                                </script>
                            </li>
                            {{-- Внутренний выпадающий список --}}
                            <li>
                                <span class="dropdownLayerBtn"><i class="fa-solid fa-sort"></i> Алфавиту </span>
                                <ul class="dropdownLayer">
                                    <div class="dropdown-items-layer statuses">
                                        <li class="selectBtn">
                                            <a href="{{ route('home', ['sort' => 'asc']) }}"> <i
                                                    class="fa-solid fa-chevron-right" style="color: #000000;"></i><i
                                                    class="fa-solid fa-arrow-up-a-z" style="color: #000000;"></i> По
                                                возрастанию</a>
                                        </li>
                                        <li class="selectBtn">
                                            <a href="{{ route('home', ['sort' => 'desc']) }}"> <i
                                                    class="fa-solid fa-chevron-right" style="color: #000000;"></i><i
                                                    class="fa-solid fa-arrow-down-z-a" style="color: #000000;"></i> По
                                                убыванию</a>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                            {{-- /Внутренний выпадающий список --}}

                            {{-- Внутренний выпадающий список 2 --}}
                            <li>
                                <span class="dropdownLayerBtn"><i class="fa-solid fa-circle-info"
                                        style="color: #000000;"></i> Статусу</span>
                                <ul class="dropdownLayer">
                                    <div class="dropdown-items-layer statuses">
                                        <li class="selectBtn">
                                            <a href="{{ route('home') }}">
                                                <i class="fa-solid fa-chevron-right" style="color: #000000;"></i> Все
                                            </a>
                                        </li>
                                        <li class="selectBtn btnActive">
                                            <a href="{{ route('home', ['status' => 'Активно']) }}">
                                                <i class="fa-solid fa-chevron-right" style="color: #000000;"></i> Активно
                                            </a>
                                        </li>
                                        <li class="selectBtn btnCompleted">
                                            <a href="{{ route('home', ['status' => 'Завершено']) }}">
                                                <i class="fa-solid fa-chevron-right" style="color: #000000;"></i> Завершено
                                            </a>
                                        </li>
                                        <li class="selectBtn btnQueue">
                                            <a href="{{ route('home', ['status' => 'Ожидание']) }}">
                                                <i class="fa-solid fa-chevron-right" style="color: #000000;"></i> Ожидание
                                            </a>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                            {{-- /Внутренний выпадающий список 2 --}}

                            {{-- /Основной выпадающий список --}}
                        </div>
                    </ul>
                </div>
                <div class="btnCloud">

                    <button onclick="window.location='{{route('files')}}'" class="btnnav "><span>Файлы</span> <i
                            class="fa-solid fa-cloud-arrow-up" style="color: #000000; margin-left: 4px"></i></button>
                </div>
                <div class="calendar">
                    <button class="btnnav"><a href="{{route('calendars.index')}}">Календарь <i
                                class="fa-solid fa-calendar-days" style="color: #000000; margin-left: 4px"></i></a></button>

                </div>

                {{-- ========================================= /Dropdown ========================================= --}}

            </div>

        </div>

        <div class="windows-container">
            <div class="sidebar">
                <div class="btnCloud">
                    <button onclick="window.location='{{route('files')}}'" class="btnnav ">
                    <i class="fa-solid fa-cloud-arrow-up" style="color: #000000; margin-left: 16px;"></i>
                    <span>Файлы</span> 
                </button>    
                </div>

                <div class="calendar">
                    <button class="btnnav"><a href="{{route('calendars.index')}}">
                    <i class="fa-solid fa-calendar-days" style="color: #000000; "></i></a>
                    <span>Календарь</span> 
                </button>    
                </div>

                <!-- <div class="btnForum">
                    <button class="btnnav"><a href="#">
                    <i class="fa-solid fa-list-check" style="color: #000000;"></i></a>
                    <span>Форум</span> 
                </button>
                </div>

                <div class="btnBlog">
                    <button class="btnnav"><a href="#">
                    <i class="fa-solid fa-blog" style="color: #000000;"></i></a>
                    <span>Блог</span> 
                </button>
                </div>

                <div class="btnShop">
                    <button class="btnnav"><a href="#">
                    <i class="fa-solid fa-cart-shopping" style="color: #000000;"></i></a>
                    <span>Le Магазин</span> 
                </button>
                </div> -->

            </div>
            <div class="windows">

                @if (isset($tasks))
                    @foreach ($tasks as $task)
                        <div class="window">
                            <div class="context">
                                <div class="title">
                                    {{ $task->name }}
                                </div>
                                <div class="status">
                                    <span class="
                                    @if ($task->status == 'Активно') sSucсess 
                                    @elseif ($task->status == 'Завершено')
                                        sDanger
                                    @elseif ($task->status == 'Ожидание')
                                    sDepleted @endif">{{ $task->status }}
                                    </span>
                                </div>
                                <div class="deadline">
                                    До {{ $task->deadline }}
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="description">
                                {{ $task->description }}
                            </div>
                            <button type="button" class="btnnav editButton" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $task->id }}">
                                <i class="fa-solid fa-pen" style="color: black"></i>
                            </button>
                            <button type="button" class="btnnav deleteButton" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $task->id }}">
                                <i class="fa-solid fa-trash" style="color: #ff0000;"></i>
                            </button>
                        </div>

                        <!-- Modal -->
                        <form action="{{ route('edit', $task->id) }}" method="POST">
                            @csrf
                            <div class="modal fade" id="exampleModal{{ $task->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog ">
                                    <div class="modal-content editModal">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Редактирование задачи:
                                                <br>{{ $task->name }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input value="{{ $task->name }}" type="text" class="form-control inputEdit" name="name"
                                                placeholder="Название">
                                            <textarea value="{{ $task->description }}" type="text"
                                                class="form-control inputEdit descriptionEdit" name="description"
                                                placeholder="Описание">{{ $task->description }}</textarea>
                                            <select class="form-select inputEdit" name="status" aria-label="Default select example">
                                                <option class="selectContext" value="" disabled>Выберите статус</option>
                                                <!-- Опционально: заголовок для выбора -->
                                                <option value="Активно" {{ $task->status === 'Активно' ? 'selected' : '' }}>Активно
                                                </option>
                                                <option value="Завершено" {{ $task->status === 'Завершено' ? 'selected' : '' }}>
                                                    Завершено</option>
                                                <option value="Ожидание" {{ $task->status === 'Ожидание' ? 'selected' : '' }}>
                                                    Ожидание</option>
                                            </select>
                                            <input value="{{ $task->deadline }}" type="date" class="form-control inputEdit"
                                                name="deadline" placeholder="Дедлайн">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btnnav">Сохранить <i class="fa-solid fa-circle-check"
                                                    style="color: #2b2b2b; margin-left: 5px"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Modal для удаления -->
                        <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content editModal">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Подтвердите удаление</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Вы уверены, что хотите удалить задачу: <strong>{{ $task->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('delete', $task->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btnnav" style="color: rgb(255, 0, 0)">Удалить</button>
                                            <button type="button" class="btnnav" data-bs-dismiss="modal">Отмена</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @auth
                        <h1>Нет заданий</h1>
                    @endauth
                @endif
                @guest
                    <h1>Вы не авторизованны</h1>
                @endguest
            </div>
        </div>



        <!-- Modal -->
        <form action="{{ route('create') }}" method="POST">
            @csrf
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content editModal">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Создание задачи</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control inputEdit" name="name" placeholder="Название">
                            <textarea type="text" class="form-control inputEdit descriptionEdit" name="description"
                                placeholder="Описание"></textarea>
                            <select class="form-select inputEdit" name="status" aria-label="Default select example">
                                <option value="Активно">Активно</option>
                                <option value="Завершено">Завершено</option>
                                <option value="Ожидание">Ожидание</option>
                            </select>
                            <input type="date" class="form-control inputEdit" name="deadline" placeholder="Дедлайн">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btnnav">Сохранить <i class="fa-solid fa-circle-check"
                                    style="color: #2b2b2b; margin-left: 5px"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </div>
@endsection