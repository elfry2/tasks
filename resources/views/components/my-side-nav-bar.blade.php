<!-- BEGIN Side Nav Bar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sideNav" aria-labelledby="sideNavLabel">
  <div class="offcanvas-header">
    <a href="/" class="text-decoration-none text-dark"><h5 class="offcanvas-title" id="sideNavLabel">{{ env('APP_NAME') ?? 'Application Name' }}</h5></a>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body px-0">
    <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item border-bottom-0">
        <h2 class="accordion-header" id="flush-headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
            <i class="me-2 bi-person-circle"></i>{{ Auth::user()->name }}
          </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            <form method="POST" action="{{ route('logout') }}">
              <div class="list-group list-group-flush">
                  @csrf
                  <!--<a href="{{ route('password.email') }}" class="list-group-item list-group-item-action border-bottom-0"><i class="me-2 bi-lock"></i>Change password</a>-->
                  <a onclick="event.preventDefault(); this.closest('form').submit();" href="#" class="list-group-item list-group-item-action border-bottom-0"><i class="me-2 bi-box-arrow-left"></i>Log out</a>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="accordion-item border-bottom-0">
        <h2 class="accordion-header" id="flush-headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
            <i class="bi-list me-2"></i>Lists
          </button>
        </h2>
        <div id="flush-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            <div class="list-group list-group-flush">
              <div class="d-flex align-child-center bd-highlight">
                <div class="flex-grow-1 bd-highlight"><a href="{{ route('preference.reset', ['name'=>'currentFolder']).'?redirect='.route('task.index')  }}" class="@if(!isset($currentFolder) || $currentFolder->title===null) {{ 'fw-bold' }}@endif border-0 list-group-item list-group-item-action border-bottom-0"></i>General</a></div>
              </div>
              @foreach($folders as $folder)
              <div class="d-flex align-child-center bd-highlight">
                <div class="flex-grow-1 bd-highlight"><a href="{{ route('preference.set', ['name'=>'currentFolder', 'value'=>$folder->id]).'?redirect='.route('task.index')  }}" class="
                  @if(isset($currentFolder) && $currentFolder->title===$folder->title)
                  fw-bold
                  @endif border-0 list-group-item list-group-item-action border-bottom-0"></i>{{ $folder->title }}</a></div>
                <div class="bd-highlight"><a data-bs-toggle="collapse" href="#editListDropdown{{ $folder->id }}" class="btn" href="#"><i class="bi-pencil-square"></i></a></div>
                <div class="bd-highlight"><a data-bs-toggle="collapse" href="#deleteListDropdown{{ $folder->id }}" class="btn" href="#"><i class="bi-trash"></i></a></div>
              </div>
              <div class="collapse" id="editListDropdown{{ $folder->id }}">
                <div class="card mt-2">
                  <div class="card-body">
                    <p><b>Rename {{ $folder->title }}?</b></p>
                    <form action="{{ route('folder.edit', ['id'=>$folder->id]) }}">
                      <div class="input-group">
                        <input type="text" name="title" class="form-control" id="newListNameTextInput" placeholder="New name for {{ $folder->title }}" autocomplete="off" required>
                        <a class="btn btn-outline-secondary" onclick="this.closest('form').submit();return false;" href="#"><i class="bi-chevron-right"></i></a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="collapse" id="deleteListDropdown{{ $folder->id }}">
                <div class="card mt-2">
                  <div class="card-body">
                    <p><b>Delete {{ $folder->title }}?</b></p>
                    <small>Deleting the list will delete its child tasks. <a class="text-danger" href="{{ route('folder.delete', ['id'=>$folder->id]) }}">Delete</a></small>
                  </div>
                </div>
              </div>
              @endforeach
              <a data-bs-toggle="collapse" href="#addNewListDropdown" class="list-group-item list-group-item-action border-bottom-0"></i><b><i class="bi-plus-lg me-2"></i>Add new list</b></a>
              <div class="collapse" id="addNewListDropdown">
                <div class="card mt-2">
                  <div class="card-body">
                    <p><b>Add a new list?</b></p>
                    <form action="{{ route('folder.create') }}">
                      <div class="input-group">
                        <input type="text" name="title" class="form-control" id="newListNameTextInput" placeholder="Name for the new list" autocomplete="off" required>
                        <a class="btn btn-outline-secondary" onclick="this.closest('form').submit();return false;" href="#"><i class="bi-chevron-right"></i></a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="accordion-item">
          <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <i class="bi-info-circle me-2"></i>About
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              <div class="my-4">
                <center><strong>Created with <i class="bi-heart-fill"></i> by <a class="text-dark" href="{{ env('DEV_WEBSITE_URL') }}" target="_blank">{{ env('DEV_NAME') }}</a></strong></center>
              </div>
              <div class="list-group list-group-flush">
                <a data-bs-toggle="collapse" href="#donateDropdown" target="_blank" class="list-group-item list-group-item-action border-bottom-0"><i class="bi-piggy-bank me-2"></i>Donate</a>
                <div class="collapse show" id="donateDropdown">
                  <div class="card mt-2">
                    <div class="card-body">
                      <small>{{ env('APP_NAME') }} is a free (as in both free beer and free speech) software. We rely solely on donations to fund the development. If you think the software is useful somehow, please consider <a href="{{ env('DEV_DONATION_URL') }}" target="_blank">donating</a>.</small><br><br>
                      <small>You can find the source code <a href="{{ env('SOURCE_CODE_URL') }}" target="_blank">here</a>.</small>
                    </div>
                  </div>
                </div>
                <a data-bs-toggle="collapse" href="#getHelpDropdown" target="_blank" class="list-group-item list-group-item-action border-bottom-0"><i class="bi-question-circle me-2"></i>Send feedback / get help</a>
                <div class="collapse" id="getHelpDropdown">
                  <div class="card mt-2">
                    <div class="card-body">
                      <small>To send feedback or get help, please send an email to <b>{{ env('DEV_EMAIL')}}</b>. We'll be in touch ASAP. <a href="mailto:{{ env('DEV_EMAIL')}}">Compose</a></small>
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
<!-- END Side Nav Bar-->
