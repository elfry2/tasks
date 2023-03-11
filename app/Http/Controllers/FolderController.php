<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AlertQueueController;
use App\Models\Folder;

class FolderController extends Controller
{
    //
    public function create(Request $request)
    {
      if (empty($request->title)) {
        AlertQueueController::enqueue([
          'type'=>'danger',
          'message'=>'Folder title cannot be empty.'
        ]);
      } else {
        if (Folder::where('parent_user', Auth::id())
           ->where('title', $request->title)->first() != null ||
           $request->title == 'General') {
             AlertQueueController::enqueue([
               'type'=>'danger',
               'message'=>'List '.$request->title.' already exists.'
             ]);
        } else {
          Folder::create([
            'title'=>$request->title,
            'parent_user'=>Auth::id()
          ]);

          AlertQueueController::enqueue([
            'type'=>'success',
            'message'=>'List created successfully.'
          ]);

          $justCreatedFolder = Folder::where('parent_user', Auth::id())
                              ->orderBy('id', 'desc')
                              ->first();

          PreferenceController::createOrUpdate('currentFolder', $justCreatedFolder->id, new Request());
        }
      }

      if(isset($request->redirect)) return redirect($request->redirect);
      return redirect(route('task.index'));
    }

    public function edit($id, Request $request)
    {
      if (empty($request->title)) {
        AlertQueueController::enqueue([
          'type'=>'danger',
          'message'=>'Folder title cannot be empty.'
        ]);
      } else {
        Folder::where('parent_user', Auth::id())
        ->where('id', $id)
        ->update([
          'title'=>$request->title,
          'parent_user'=>Auth::id()
        ]);

        AlertQueueController::enqueue([
          'type'=>'success',
          'message'=>'List updated successfully.'
        ]);

        $justUpdatedFolder = Folder::where('parent_user', Auth::id())
                            ->orderBy('updated_at', 'desc')
                            ->first();

        PreferenceController::createOrUpdate('currentFolder', $justUpdatedFolder->id, new Request());
      }

      if(isset($request->redirect)) return redirect($request->redirect);
      return redirect(route('task.index'));
    }

    public function delete($id)
    {
      Folder::where('parent_user', Auth::id())
      ->where('id', $id)
      ->delete();

      AlertQueueController::enqueue([
        'type'=>'success',
        'message'=>'List deleted successfully.'
      ]);

      return redirect(route('task.index'));
    }
}
