@extends('layouts.layout')

@section('content')

    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <div class="list-container">
        <div class="files-title">
            <h1>Файлы</h1>
            <i class="fa-solid fa-file"></i>

        </div>

        <div class="folder-container">
            <div class="folder-create">
                <div class="dropdown-button createFolderBtn createTaskBtn">
                    <ul class="dropdown">
                        <div class="dropdown-title">
                            <i class="fa-solid fa-folder-plus"
                                style="color: #000000; font-size: 19px; margin-top: 3px;"></i>
                        </div>
                        <div class="dropdown-items">
                            <form action="{{ route('folder.store') }}" method="POST">
                                @csrf
                                <li>
                                    <input type="text" class="form-control inputEdit" name="foldersName"
                                        placeholder="Название" autocomplete="off">
                                </li>
                                <li>
                                    <button type="submit" class="btnnav"><i class="fa-solid fa-check"
                                            style="position: relative; bottom: 2px;"></i></button>
                                </li>
                            </form>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="folder-items">
                <h2>Папки</h2>
                @foreach ($folders as $folder)
                            <div class="folder-item ">
                                <div class="folder">
                                    <div class="dropdown-button dropdown-folder-btn">

                                        <div class="context-menu" id="context-menu-{{ $folder->id }}">
                                            <div class="context-btns">
                                                <div class="btnContext"><i class="fa-solid fa-chevron-right"
                                                        style="color: #000000;"></i>
                                                    <button type="button" class="" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $folder->id }}">
                                                        <i class="fa-solid fa-pen" style="color: #000000;"></i>
                                                        Переименовать
                                                    </button>
                                                </div>
                                                <div class="btnContext"><i class="fa-solid fa-chevron-right"
                                                        style="color: #000000;"></i><button type="button" class=""
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $folder->id }}">
                                                        <i class="fa-solid fa-file-circle-plus" style="color: #000000;"></i>
                                                        Добавить файл
                                                    </button>
                                                </div>
                                                <div class="btnContext"><i class="fa-solid fa-chevron-right"
                                                        style="color: #000000;"></i>

                                                    <form action="{{ route('destroy.folder', $folder->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="contextDelete"><i class="fa-regular fa-trash-can"
                                                                style="color: #ff0000;"></i> Удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="dropdown dropdown-folder">

                                            <div class="folder-add">
                                                <form action="{{ route('folder.add') }}" enctype="multipart/form-data" method="post">
                                                    @csrf
                                                    <label class="upload-to-folder" for="file-to-folder-input-{{ $folder->id }}">
                                                        <i class="fa-solid fa-file-circle-plus" style="color: #000000;"></i>
                                                    </label>
                                                    <input type="hidden" name="folderId" value="{{ $folder->id }}">
                                                    <input type="file" name="file" id="file-to-folder-input-{{ $folder->id }}"
                                                        class="form-control file-to-folder-input" placeholder='Добавить файл в папку'>
                                                    <button type="submit" class="btnnav">
                                                        <i class="fa-solid fa-check" style="position: relative; bottom: 2px;"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="dropdown-title menu-item" data-menu="context-menu-{{ $folder->id }}">
                                                <div class="divide-actions">
                                                </div>
                                                <a href="#" class="ifolder"><i class="fa-solid fa-folder"></i><i
                                                        class="fa-solid fa-folder-open"></i> {{ $folder->name }}</a>
                                            </div>

                                            <div class="folder-actions">
                                                <form action="{{ route('destroy.folder', $folder->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class=""><i class="fa-regular fa-trash-can"
                                                            style="color: #ff0000;"></i></button>
                                                </form>
                                            </div>

                                            <div class="dropdown-items">
                                                <div class="divider-folder"></div>

                                                @php
                                                    $folderFiles = $files->where('folder_id', $folder->id);
                                                @endphp

                                                @if ($folderFiles->isEmpty())
                                                    <li>
                                                        <h6>В этой папке файлы не найдены</h6>
                                                    </li>
                                                @else
                                                    @foreach ($folderFiles as $file)
                                                        <div class="context-menu menu-item" id="context-menu-{{ $file->id }}">
                                                            <div class="context-btns">
                                                                <div class="btnContext"><i class="fa-solid fa-chevron-right"
                                                                        style="color: #000000;"></i>
                                                                    <button type="button" class="" data-bs-toggle="modal"
                                                                        data-bs-target="#editModal{{ $file->id }}">
                                                                        <i class="fa-solid fa-pen" style="color: #000000;"></i>
                                                                        Переименовать
                                                                    </button>
                                                                </div>
                                                                <div class="btnContext"><i class="fa-solid fa-chevron-right"
                                                                        style="color: #000000;"></i>

                                                                    <form action="{{ route('destroy.file', $file->id) }}" method="POST"
                                                                        style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="contextDelete"><i
                                                                                class="fa-regular fa-trash-can" style="color: #ff0000;"></i>
                                                                            Удалить
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <li>
                                                            <div class="file-item menu-item" data-menu="context-menu-{{ $file->id }}">
                                                                <a href="{{ asset('storage/' . $file->path) }}">
                                                                    <i class="fa-solid fa-file-alt"></i> {{ $file->name }}
                                                                </a>

                                                                <div class="file-actions">
                                                                    <!-- Button Modal move folder -->
                                                                    <button type="button" class="btnnav" data-bs-toggle="modal"
                                                                        data-bs-target="#exampleModal{{ $file->id }}">
                                                                        <i class="fa-solid fa-share" style="color: #000000;"></i>
                                                                    </button>

                                                                    <form action="{{ route('destroy.file', $file->id) }}" method="POST"
                                                                        style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btnnav">
                                                                            <i class="fa-solid fa-xmark" style="color: #ff0000;"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                @endforeach
            </div>




            @foreach ($folders as $folder)
                <!-- <div class="context-menu-lmb menu-item-lmb" id="context-menu-lmb-{{ $folder->id }}">
                    <div class="context-btns">
                        <div class="btnContext"><button type="button" class="some-action">{{ $folder->name }}</button></div>
                        <div class="btnContext"><button type="button" class="some-action">Действие
                                2</button></div>
                    </div>
                </div> -->

                <!-- Modal add to folder -->
                <form action="{{ route('folder.add') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal fade" id="exampleModal{{ $folder->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content editModal addModal">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        <i class="fa-solid fa-file-circle-plus" style="color: #000000;"></i> <span
                                            class="fs-4">Добавить
                                            файл в</span>
                                        <br>
                                        <span>"{{ $folder->name }}"</span>
                                    </h1>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <input type="hidden" name="folderId" value="{{ $folder->id }}">
                                    <div class="addToFolder">
                                        <input type="file" name="file" id="file-to-folder-input-{{ $folder->id }}"
                                            class="form-control " placeholder='Добавить файл в папку'>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btnnav">Добавить файл <i class="fa-solid fa-circle-check"
                                            style="color: #2b2b2b; margin-left: 5px"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                {{-- Modal Edit Name --}}

                <form action="{{ route('folder.edit') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal fade" id="editModal{{ $folder->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content editModal addModal">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        <i class="fa-solid fa-pen" style="color: #000000;"></i> <span class="fs-4">Переименовать
                                            папку</span>
                                    </h1>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <input type="hidden" name="folderId" value="{{ $folder->id }}">
                                    <div class="addToFolder">
                                        <input type="text" name="folderName" id="file-to-folder-input-{{ $folder->id }}"
                                            class="form-control " placeholder='Название папки' value="{{ $folder->name }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btnnav">Подтвердить <i class="fa-solid fa-circle-check"
                                            style="color: #2b2b2b; margin-left: 5px"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach

            @foreach ($files as $file)
                <!-- Modal move folder -->
                <form action="{{ route('files.move') }}" method="POST">
                    @csrf
                    <input type="hidden" name="fileId" value="{{ $file->id }}">
                    <div class="modal fade" id="exampleModal{{ $file->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content editModal moveModal">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        <i class="fa-solid fa-share" style="color: #000000;"></i> <span class="fs-4">Перенос
                                            файла</span>
                                        <br>
                                        <span>"{{ $file->name }}"</span>
                                        <br>
                                        в папку <i class="fa-solid fa-turn-down" style="color: #000000;"></i>
                                    </h1>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="folder-move-list">
                                        @foreach ($folders as $folder)
                                            <div class="form-check">
                                                <label class="form-check-label" for="folder-{{ $folder->id }}">
                                                    <input type="radio" class="form-check-input" id="folder-{{ $folder->id }}"
                                                        name="folderId" value="{{ $folder->id }}" required>
                                                    <i class="fa-solid fa-folder"></i> {{ $folder->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btnnav">Переместить <i class="fa-solid fa-circle-check"
                                            style="color: #2b2b2b; margin-left: 5px"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Modal Edit Name for file --}}

                <form action="{{ route('file.edit') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal fade" id="editModal{{ $file->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content editModal addModal">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        <i class="fa-solid fa-pen" style="color: #000000;"></i> <span class="fs-4">Переименовать
                                            файл</span>
                                    </h1>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <input type="hidden" name="fileId" value="{{ $file->id }}">
                                    <div class="addToFolder">
                                        <input type="text" name="fileName" id="file-to-folder-input-{{ $file->id }}"
                                            class="form-control " placeholder='Название файла'
                                            value="{{ pathinfo($file->name, PATHINFO_FILENAME) }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btnnav">Подтвердить <i class="fa-solid fa-circle-check"
                                            style="color: #2b2b2b; margin-left: 5px"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach


            <div class="files-cycle">

                <div class="folder-create">
                    <div class="dropdown-button createFolderBtn createTaskBtn">
                        <ul class="dropdown">
                            <div class="dropdown-title">
                                <i class="fa-solid fa-file-circle-plus" style="color: #000000;"></i>
                            </div>
                            <div class="dropdown-items">
                                <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <li>
                                        <input type="file" class="form-control inputEdit" name="file" placeholder="Название"
                                            autocomplete="off">
                                    </li>
                                    <li>
                                        <button type="submit" class="btnnav"><i class="fa-solid fa-check"
                                                style="position: relative; bottom: 2px;"></i></button>
                                    </li>
                                </form>
                            </div>
                        </ul>
                    </div>
                </div>

                <h2>Файлы</h2>
                <div class="file-items">
                    @if (!empty($rootFiles) && $rootFiles->isNotEmpty())

                        @foreach ($rootFiles as $file)

                            <div class="context-menu menu-item" id="context-menu-{{ $file->id }}">
                                <div class="context-btns">
                                    <div class="btnContext"><i class="fa-solid fa-chevron-right" style="color: #000000;"></i>
                                        <button type="button" class="" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $file->id }}">
                                            <i class="fa-solid fa-pen" style="color: #000000;"></i>
                                            Переименовать
                                        </button>
                                    </div>
                                    <div class="btnContext"><i class="fa-solid fa-chevron-right" style="color: #000000;"></i>

                                        <form action="{{ route('destroy.file', $file->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="contextDelete"><i class="fa-regular fa-trash-can"
                                                    style="color: #ff0000;"></i> Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @if ($file->folder_id == null)
                                <div class="file-item menu-item" data-menu="context-menu-{{ $file->id }}">
                                    <a href="{{ asset('storage/' . $file->path) }}"><i class="fa-solid fa-file-alt"></i>
                                        {{ $file->name }}</a>
                                    <div class="file-actions">
                                        <form action="{{ route('destroy.file', $file->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btnnav"><i class="fa-solid fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>

                            @endif
                        @endforeach
                    @else
                        <h6>Файлов не обнаружено</h6>
                    @endif
                </div>

            </div>



        </div>
    </div>

@endsection