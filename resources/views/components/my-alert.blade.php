<!--BEGIN my alert-->
<div class="alert alert-{{ $alert->type}} alert-dismissible fade show m-2 shadow" role="alert">
  {{ $alert->message }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<!--END my alert-->
