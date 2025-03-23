<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Folder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folders = Folder::where('user_id', Auth::user()->id)->get();
        $files = File::where('user_id', Auth::user()->id)->get();
        $rootFiles = File::where('user_id', Auth::user()->id)->whereNull('folder_id')->get();
        return view('files', compact('files', 'rootFiles' , 'folders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);
    
        $folderName = Auth::user()->name . '-' . Auth::user()->id . '-' . 'folder';
    
        if (!Storage::disk('public')->exists('uploads/' . $folderName)) {
            Storage::disk('public')->makeDirectory('uploads/' . $folderName);
        }
    
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $path = $file->storeAs('uploads/' . $folderName, $fileName, 'public');
        
        /** @var User $userModel */
        $userModel = Auth::user();
        $userModel->storage_name = $folderName;
        $userModel->save();

        $fileModel = new File;
        $fileModel->name = $fileName;
        $fileModel->path = $path;
        $fileModel->user_id = Auth::user()->id;
        $fileModel->save();
    
        return redirect()->back()->with('success', 'Файл успешно загружен!');
    }
    
    public function folderStore(Request $request) {
        $validatedData = $request->validate([
            'foldersName' => 'required|string|max:255'
        ]);
    
        $foldersName = $validatedData['foldersName'];
        $folderName = Auth::user()->name . '-' . Auth::user()->id . '-' . 'folder';

        if (!Storage::disk('public')->exists('uploads/' . $folderName)) {
            Storage::disk('public')->makeDirectory('uploads/' . $folderName);
        }


        /** @var User $userModel */
        $userModel = Auth::user();
        $userModel->storage_name = $folderName;
        $userModel->save();

        
        Storage::disk('public')->makeDirectory('uploads/' . $userModel->storage_name . '/' . $foldersName);
        $folder = new Folder;
        $folder->name = $foldersName;
        $folder->user_id = Auth::user()->id;
        $folder->path = 'uploads/'. $folderName . '/' . $foldersName;
        $folder->save();
        return redirect()->back()->with('success', 'Папка успешно создана!');
    }

    public function folderAdd(Request $request)
    {
        $folderId = $request->folderId;
        $folder = Folder::find($folderId);
    
        // Проверка наличия файла
        if ($request->hasFile('file')) {
            $file = $request->file('file');
    
            // Проверка, что файл корректен
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                $path = $file->storeAs($folder->path, $fileName, 'public');
    
                $fileModel = new File;
                $fileModel->name = $fileName;
                $fileModel->path = $path;
                $fileModel->user_id = Auth::user()->id;
                $fileModel->folder_id = $folderId;
                $fileModel->save();
    
                return redirect()->back()->with('success', 'Файл успешно добавлен в папку!');
            } else {
                return redirect()->back()->with('error', 'Ошибка при загрузке файла. Пожалуйста, попробуйте еще раз.');
            }
        } else {
            return redirect()->back()->with('error', 'Файл не был загружен. Пожалуйста, попробуйте еще раз.');
        }
    }

    public function folderEdit(Request $request) {
        $request->validate([
            'folderId' => 'required|exists:folders,id',
            'folderName' => 'required|string|max:255|regex:/^[\w\s\-]+$/', 
        ]);
    
        $folderId = $request->folderId;
        $folder = Folder::find($folderId);
    
        $oldPath = 'uploads/' . Auth::user()->storage_name . '/' . $folder->name;
        $newPath = 'uploads/' . Auth::user()->storage_name . '/' . $request->folderName;
    
        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->move($oldPath, $newPath);
            
            $folder->name = $request->folderName;
            $folder->path = $newPath; 
            $folder->save();
    
            $files = File::where('folder_id', $folderId)->get();
            foreach ($files as $file) {
                $file->path = 'uploads/' . Auth::user()->storage_name . '/' . $request->folderName . '/' . $file->name;
                $file->save();
            }
    
            return redirect()->back()->with('success', 'Имя папки успешно изменено!');
        } else {
            return redirect()->back()->with('error', 'Ошибка: старая папка не найдена!');
        }
    }

    public function fileEdit(Request $request) {
        $request->validate([
            'fileId' => 'required|exists:files,id',
            'fileName' => 'required|string|max:255|regex:/^[\w\s\-]+$/', 
        ]);
    
        $fileId = $request->fileId;
        $file = File::find($fileId);
        $fileFolder = Folder::find($file->folder_id);
    
        $oldPath = $file->path;
        $extension = pathinfo($file->name, PATHINFO_EXTENSION); 
        if ($file->folder_id !== null) {
        $newPath = 'uploads/'. Auth::user()->storage_name. '/'. $fileFolder->name . '/'. $request->fileName . '.' . $extension;
        } else {
            $newPath = 'uploads/'. Auth::user()->storage_name . '/'. $request->fileName . '.' . $extension;
        }
        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->move($oldPath, $newPath);
            
            $file->name = $request->fileName . '.' . $extension; 
            $file->path = $newPath;
            $file->save();
        }
    
        return redirect()->back()->with('success', 'Имя файла успешно изменено!');
    }
    

    public function move(Request $request)
    {
        $request->validate([
            'folderId' => 'required|exists:folders,id',
            'fileId' => 'required|exists:files,id',
        ]);

        $file = File::findOrFail($request->fileId);
        $newFolder = Folder::findOrFail($request->folderId);

        $userStorageName = auth()->user()->storage_name;
        $oldFolderPath = 'uploads/' . $userStorageName . '/' . Folder::find($file->folder_id)->name;
        $newFolderPath = 'uploads/' . $userStorageName . '/' . $newFolder->name;

        $filePath = $oldFolderPath . '/' . $file->name;
        if (Storage::exists($filePath)) {
            if (!Storage::exists($newFolderPath)) {
                Storage::makeDirectory($newFolderPath);
            }
            Storage::move($filePath, $newFolderPath . '/' . $file->name);
        }

        $file->folder_id = $request->folderId;
        $file->save();

        return redirect()->back()->with('success', 'Файл успешно перемещен!');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = File::find($id);
        if ($file->user_id == Auth::user()->id) {
            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
            $file->delete();
            return redirect()->back()->with('success', 'Файл успешно удален!');
        }
    }

    public function destroyFolder(string $id)
    {
        $files = File::where('folder_id', $id)->get();;
        $folder = Folder::find($id);
        if ($folder->user_id == Auth::user()->id) {
            if (Storage::disk('public')->exists($folder->path)) {
                Storage::disk('public')->deleteDirectory($folder->path);
                foreach ($files as $file) {
                $file->delete();
                }
            }
            $folder->delete();
            return redirect()->back()->with('success', 'Папка успешно удалена!');
        }
    }
}
