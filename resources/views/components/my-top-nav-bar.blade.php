<!-- BEGIN Top Nav Bar -->
<div class="d-flex py-3 px-2 align-items-center bd-highlight w-100 overflow-auto">
  <div class="bd-highlight">
    <a class="btn" data-bs-toggle="offcanvas" href="#sideNav" role="button" aria-controls="sideNav">
      <i class="bi-list"></i>
    </a>
  </div>
  <div class="flex-grow-1 ms-2 bd-highlight" id="pageTitle">
    <h5 class="m-0">{{ $pageTitle ?? "Page Title" }}</h5>
  </div>
  @yield('my-top-nav')
</div>
<!-- END Top Nav Bar -->
