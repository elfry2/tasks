<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Task;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\AlertQueueController;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index(Request $request)
    {
      $parameters = [];
      $maxRecordPerPage = 20;
      $currentPage = 1;

      $parameters['totalPageCount'] = 1;

      if (isset($request->page)) {
        $currentPage = $request->page;
      }

      $parameters['hasTask'] = Task::where('parent_user', Auth::id())
        ->where('parent_folder', PreferenceController::read('currentFolder'))
        ->first();

      $parameters['folders'] = Folder::where('parent_user', Auth::id())
                 ->orderBy('title', 'asc')
                 ->get();

      $parameters['currentFolder'] = null;
      if (PreferenceController::read('currentFolder') !== null) {
        $parameters['currentFolder'] = Folder::where('parent_user', Auth::id())
                                       ->where('id', PreferenceController::read('currentFolder'))
                                       ->first();
      }

      $parameters['tasks'] = Task::where('parent_user', Auth::id());

      // Filter tasks by current folder
      if(isset($parameters['currentFolder'])){
        $parameters['tasks'] = $parameters['tasks']->where('parent_folder', $parameters['currentFolder']->id);
        $parameters['pageTitle'] = $parameters['currentFolder']->title;
      } else {
        $parameters['tasks'] = $parameters['tasks']->where('parent_folder', null);
        $parameters['pageTitle'] = 'General';
      }

      // Filter tasks by current completion status
      $parameters['currentTaskCompletionStatus'] = PreferenceController::read('currentTaskCompletionStatus');
      if ($parameters['currentTaskCompletionStatus']) {
        $parameters['tasks'] = $parameters['tasks']->where('is_completed', true);
      } else {
        $parameters['tasks'] = $parameters['tasks']->where('is_completed', false);
      }

      // Filter tasks by search query
      if (isset($request->q))
        PreferenceController::createOrUpdate('currentSearchQuery', $request->q, new Request);

      if (!empty(PreferenceController::read('currentSearchQuery'))) {
        $parameters['currentSearchQuery'] = PreferenceController::read('currentSearchQuery');
        $fuzzifiedSearchQuery = '';

        for($i = 0; $i<strlen($parameters['currentSearchQuery']); $i++) {
          $fuzzifiedSearchQuery.=$parameters['currentSearchQuery'][$i].'%';
        }
        $parameters['tasks'] = $parameters['tasks']->where('title', 'LIKE', '%'.$fuzzifiedSearchQuery);
      }

      // Filter by page & number of items per page
      if(isset($request->p)){

      } else {
        // code...
      }

      // Order tasks by order preference
      if (!empty(PreferenceController::read('tasksOrderBy'))) {
        if (PreferenceController::read('tasksOrderBy') == 'updated_at') {
          $parameters['tasks'] = $parameters['tasks']
                                 ->orderBy(Str::Snake(PreferenceController::read('tasksOrderBy')), 'desc');
        } else {
          $parameters['tasks'] = $parameters['tasks']
                                 ->orderBy(Str::Snake(PreferenceController::read('tasksOrderBy')), 'asc');
        }
      } else {
        $parameters['tasks'] = $parameters['tasks']->orderBy('due_date', 'asc');
      }

      if ($parameters['tasks']->count()!=0) {
        $parameters['totalPageCount'] = ceil($parameters['tasks']
          ->count()/$maxRecordPerPage);
      } else $totalPageCount = 1;

      $parameters['tasks'] = $parameters['tasks']->get();

      // If the order preference is by due date, put tasks without a due date in
      // the front-most indices.
      if (empty(PreferenceController::read('tasksOrderBy'))
          || PreferenceController::read('tasksOrderBy') === 'due_date') {
        $tasksWithoutADueDate =
        $parameters['tasks']->intersect(Task::where('due_date', null)->get());
        $tasksWithDueDates =
        $parameters['tasks']->diff(Task::where('due_date', null)->get());

        $tasksWithDueDates = $tasksWithDueDates->merge($tasksWithoutADueDate);

        $parameters['tasks'] = $tasksWithDueDates;
      }

      //Limit result count and skip as per current page
      $parameters['tasks'] = $parameters['tasks']->skip(($currentPage-1)*$maxRecordPerPage)
        ->take($maxRecordPerPage);

      $parameters['tasksOrderBy'] = PreferenceController::read('tasksOrderBy');
      $parameters['alerts'] = AlertQueueController::dequeueAll();

      return view('my-tasks', $parameters);
    }

    public function create(Request $request){
      $dueDate = null;
      $isCompleted = false;

      if (isset($request->taskDueDate)) {
        if(!isset($request->taskDueTime)) $request->taskDueTime = "00:00:00";
        else $request->taskDueTime.=":00";
        $dueDate = $request->taskDueDate.' '.$request->taskDueTime;
      }

      $isCompleted = false;
      if (isset($request->taskIsCompleted)
          && $request->taskIsCompleted === "on"){
            $isCompleted = true;
            PreferenceController::createOrUpdate('currentTaskCompletionStatus', true, new Request);
          } else {
            PreferenceController::createOrUpdate('currentTaskCompletionStatus', false, new Request);
          }


      $parentFolder = PreferenceController::read('currentFolder');
      if ($parentFolder == '') $parentFolder == null;

      Task::create([
        'due_date'=>$dueDate,
        'title'=>$request->taskTitle,
        'description'=>$request->taskDescription,
        'parent_folder'=>$parentFolder,
        'parent_user'=>Auth::id(),
        'is_completed'=>$isCompleted

      ]);

      AlertQueueController::enqueue([
        'type'=>'success',
        'message'=>'Task created successfully.'
      ]);

      return redirect(route('task.index'));
    }

    public function edit(Request $request, $id){
      $dueDate = null;
      $isCompleted = false;

      if (isset($request->taskDueDate)) {
        if(!isset($request->taskDueTime)) $request->taskDueTime = "00:00:00";
        else $request->taskDueTime.=":00";
        $dueDate = $request->taskDueDate.' '.$request->taskDueTime;
      }

      $isCompleted = false;
      if (isset($request->taskIsCompleted)
          && $request->taskIsCompleted === "on"){
            $isCompleted = true;
            PreferenceController::createOrUpdate('currentTaskCompletionStatus', true, new Request);
          } else {
            PreferenceController::createOrUpdate('currentTaskCompletionStatus', false, new Request);
          }


      $parentFolder = PreferenceController::read('currentFolder');
      if ($parentFolder == '') $parentFolder == null;

      Task::where('parent_user', Auth::id())
      ->where('id', $id)->update([
        'due_date'=>$dueDate,
        'title'=>$request->taskTitle,
        'description'=>$request->taskDescription,
        'parent_folder'=>$parentFolder,
        'parent_user'=>Auth::id(),
        'is_completed'=>$isCompleted,
        'updated_at'=>date('Y-m-d H:i:s')

      ]);

      AlertQueueController::enqueue([
        'type'=>'success',
        'message'=>'Task updated successfully.'
      ]);

      return redirect(route('task.index'));
    }

    public function delete(Request $request, $id){
      Task::where('parent_user', Auth::id())
      ->where('id', $id)
      ->delete();

      AlertQueueController::enqueue([
        'type'=>'success',
        'message'=>'Task deleted successfully.'
      ]);

      return redirect(route('task.index'));
    }

    public function toggleCompletionStatus($id)
    {
      $task = Task::where('parent_user', Auth::id())
      ->where('id', $id)
      ->first();

      if (!$task->is_completed) {
        Task::where('parent_user', Auth::id())
        ->where('id', $id)
        ->update([
          'is_completed'=>true
        ]);

        AlertQueueController::enqueue([
          'type'=>'success',
          'message'=>'Task '.$task->title.' completed!'
        ]);
      } else {
        Task::where('parent_user', Auth::id())
        ->where('id', $id)
        ->update([
          'is_completed'=>false
        ]);

        AlertQueueController::enqueue([
          'type'=>'success',
          'message'=>'Task '.$task->title.' marked incomplete.'
        ]);
      }

      return redirect(route('task.index'));
    }
}
