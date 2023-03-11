<!-- BEGIN Content Area -->
@extends('layouts.my-dashboard')
@section('my-top-nav')
  <div class="btn-group">
    <a href="{{ route('preference.reset', ['name'=>'currentTaskCompletionStatus']).'?redirect='.route('task.index') }}" class="btn @if(!$currentTaskCompletionStatus) {{ 'btn-dark' }} @else {{ 'btn-outline-dark' }} @endif" aria-current="page">Incomplete</a>
    <a href="{{ route('preference.set', ['name'=>'currentTaskCompletionStatus', 'value'=>'true']).'?redirect='.route('task.index') }}" class="btn @if($currentTaskCompletionStatus) {{ 'btn-dark' }} @else {{ 'btn-outline-dark' }} @endif" aria-current="page">Completed</a>
  </div>
  @include('components.my-button-sized-separator-button')

  <!-- BEGIN task creation button -->
  <div class="ms-2 bd-highlight"><a href="#" class="btn" title="Add new task" data-bs-toggle="modal" data-bs-target="#taskCreationModal"><i class="bi-plus-lg"></i> <span class="ms-2 hide-on-small-screen">New task</span></a></div>
  <!-- BEGIN task creation modal -->
  <div class="modal fade" id="taskCreationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add new task into {{ $currentFolder->title ?? 'General' }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('task.create') }}">
            <div class="mb-3">
              <label for="taskTitleTextInput" class="form-label">Title</label>
              <input type="text" class="form-control" id="taskTitleTextInput" name="taskTitle" placeholder="Buy eggs" required>
            </div>
            <div class="mb-3">
              <label for="dueDateDateInput" class="form-label">Due date</label>
              <div class="row">
                <div class="col-7">
                  <input type="date" class="form-control" id="taskDueDateDateInput" name="taskDueDate">
                </div>
                <div class="col-5">
                  <input type="time" class="form-control" id="taskDueTimeTimeInput" name="taskDueTime" value="23:59">
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="taskDescriptionTextArea" class="form-label">Description</label>
              <textarea class="form-control task-description-text-area" name="taskDescription" id="taskDescriptionTextArea" placeholder="The brown ones, not purple."></textarea>
            </div>
            <div class="mb-3">
              <input class="form-check-input" type="checkbox" name="taskIsCompleted" id="flexCheckDefault">
              <label class="form-check-label" for="flexCheckDefault">
                Mark completed
              </label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary"><i class="bi-plus-lg me-2"></i>Add task</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- END task creation modal -->
  <!-- END task creation button -->

  @include('components.my-search-button')
  @include('components.my-reload-button')
  <div class="ms-2 bd-highlight"><a href="#" class="btn" title="Sort by..." data-bs-toggle="modal" data-bs-target="#taskSortingModal"><i class="bi-sort-alpha-down"></i></a></div>
  <!-- BEGIN task sorting button -->
  <div class="modal fade" id="taskSortingModal" tabindex="-1" aria-labelledby="taskSortingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="taskSortingModalLabel">Sort by...</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <center>
            <div class="btn-group" role="group" aria-label="Basic example">
              <a class="btn {{ (!isset($tasksOrderBy) || $tasksOrderBy == 'due_date') ? 'btn-dark' : 'btn-outline-dark' }}" href="{{ route('preference.set', ['name'=>'tasksOrderBy', 'value'=>'due_date']).'?redirect='.route('task.index') }}">Due date</a>
              <a class="btn {{ (isset($tasksOrderBy) && $tasksOrderBy == 'updated_at') ? 'btn-dark' : 'btn-outline-dark' }}" href="{{ route('preference.set', ['name'=>'tasksOrderBy', 'value'=>'updated_at']).'?redirect='.route('task.index') }}">Last updated</a>
              <a class="btn {{ (isset($tasksOrderBy) && $tasksOrderBy == 'title') ? 'btn-dark' : 'btn-outline-dark' }}" href="{{ route('preference.set', ['name'=>'tasksOrderBy', 'value'=>'title']).'?redirect='.route('task.index') }}">Title</a>
            </div>
          </center>
        </div>
      </div>
    </div>
  </div>
  <!-- END task sorting button -->
  @include('components.my-button-sized-separator-button')
  @include('components.my-pagination-buttons')
@endsection

@section('my-content-area')
  @if (!isset($tasks) || $tasks->count() < 1)
    <center class="center">
      <h3 class="text-muted mx-2">
      @if ($hasTask && !$currentTaskCompletionStatus && (!isset($_GET['page']) || $_GET['page'] <= 1))
        @php
          $noTaskDueText = [
            'Rest easy for now~',
            'Perhaps treat yourself an ice cream?',
            'How about watching that movie everyone\'s been hyping about?',
            'Any place you wanna visit?',
            'Time for an old hobby, perhaps?'
          ];
        @endphp
        No task due. Yay! {{ $noTaskDueText[array_rand($noTaskDueText)] }}
      @else
        No task yet. Click on the <b><i class="bi-plus-lg"></i> <span class="hide-on-small-screen">New task</span></b> button to create one.
      @endif
    </h3></center>
  @else
    @foreach ($tasks as $task)
      <div class="card border me-2 mb-2 dashboard-content-card float-start">
        <div class="card-body">
          <div class="d-flex align-items-center bd-highlight w-100">
            <div class="flex-grow-1 bd-highlight">
              <small class="card-subtitle mb-2 {{ (isset($task->due_date) && (date_format(date_create($task->due_date), 'Y-m-d H:i') < date('Y-m-d H:i')) && !$task->is_completed) ? 'text-danger' : 'text-muted'}}">{{ $task->due_date ? ('Due '.date_format(date_create($task->due_date), 'l, Y/m/d H:i')) : 'No due date' }}</small>
            </div>
            <div class="dropdown">
              <a class="btn" href="#" title="Previous page" id="dropdownMenuLink" data-bs-toggle="dropdown"><i class="bi-three-dots-vertical"></i></a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#taskModificationModal{{ $task->id }}"><i class="bi-card-text me-2"></i>View details</a></li>
                <li><a class="dropdown-item" href="{{ route('task.toggleCompletionStatus', ['id'=>$task->id]) }}"><i class="{{ $task->is_completed?'bi-square':'bi-check-square'}} me-2"></i>{{ $task->is_completed?'Mark incomplete':'Mark completed'}}</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#task{{ $task->id }}DeletionModal"><i class="bi-trash me-2"></i>Delete</a></li>
              </ul>
            </div>
            <!-- BEGIN task {{ $task->id }} deletion modal -->
            <!-- Modal -->
            <div class="modal fade" id="task{{ $task->id }}DeletionModal" aria-labelledby="task{{ $task->id }}DeletionModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="task{{ $task->id }}DeletionModalLabel">Delete task {{ $task->title }}?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>This action cannot be undone. @if (!$task->is_completed) If you want to mark the task as completed, click on <b><i class="bi bi-check-square me-1"></i>Mark completed</b> instead. @endif</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('task.delete', ['id'=>$task->id]) }}" class="btn btn-danger"><i class="bi bi-trash me-2"></i>Delete</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- END task {{ $task->id }} deletion modal -->
          </div>
          <div class="dashboard-content-card-main-text overflow-hidden">
            <a class="text-dark text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#taskModificationModal{{ $task->id }}"><h5 class="card-text">{{ substr($task->title, 0, 80).(strlen($task->title)>80?'...':'') }}</h5></a>
          </div>
          <div class="d-flex mt-1 align-items-center bd-highlight w-100">
            <div class="flex-grow-1 bd-highlight">
              <small class="{{ $task->is_completed ? 'text-success' : 'text-muted' }}">{{ $task->is_completed ? 'Completed' : 'Incomplete' }}</small>
            </div>
            <div class="bd-highlight">
              <a href="{{ route('task.toggleCompletionStatus', ['id'=>$task->id]) }}" class="btn"><i class="{{ $task->is_completed ? 'bi-check-square text-success' : 'bi-square' }}"></i></a>
            </div>
          </div>
        </div>
      </div>
      <!-- BEGIN task modification modal -->
      <div class="modal fade" id="taskModificationModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Task details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('task.edit', ['id'=>$task->id]) }}">
                <div class="mb-3">
                  <label for="taskTitleTextInput" class="form-label">Title</label>
                  <input type="text" class="form-control" id="taskTitleTextInput" name="taskTitle" placeholder="Buy eggs" value="{{ $task->title }}"required>
                </div>
                <div class="mb-3">
                  <label for="dueDateDateInput" class="form-label">Due date</label>
                  <div class="row">
                    <div class="col-7">
                      <input type="date" class="form-control" id="taskDueDateDateInput" name="taskDueDate" value="{{ isset($task->due_date) ? date_format(date_create($task->due_date), 'Y-m-d') : ''}}">
                    </div>
                    <div class="col-5">
                      <input type="time" class="form-control" id="taskDueTimeTimeInput" name="taskDueTime" value="{{ isset($task->due_date) ? date_format(date_create($task->due_date), 'H:i') : '23:59'}}">
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="taskDescriptionTextArea" class="form-label">Description</label>
                  <textarea class="form-control task-description-text-area" name="taskDescription" id="taskDescriptionTextArea" placeholder="The brown ones, not purple.">{{ $task->description }}</textarea>
                </div>
                <div class="mb-3">
                  <input class="form-check-input" type="checkbox" name="taskIsCompleted" id="flexCheckDefault{{ $task->id }}" {{ $task->is_completed ? 'checked' : '' }}>
                  <label class="form-check-label" for="flexCheckDefault{{ $task->id }}">
                    Mark completed
                  </label>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary"><i class="bi-pencil-square me-2"></i>Update task</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- END task modification modal -->
      @endforeach
  @endif
@endsection
<!-- END Content Area -->

@section('my-bottom-nav')
  @if (isset($tasks) && $tasks->count() > 0)
    @include('components.my-pagination-buttons')
  @endif
@endsection

@section('my-fixed-bottom-nav')
  @foreach ($alerts as $alert)
    @include('components.my-alert')
  @endforeach
  <div class="hide-on-wide-screen">
    <div class="d-flex flex-row-reverse p-2 bd-highlight">
      <a href="#" class="text-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#taskCreationModal">
        <div class="bg-white border shadow me-1 mb-1 floating-add-button p-2 d-flex align-items-center justify-content-center hide-on-wide-screen">
          <h3 class="m-0 p-0"><i class="bi bi-plus-lg"></i></h3>
        </div>
      </a>
    </div>
  </div>
@endsection
