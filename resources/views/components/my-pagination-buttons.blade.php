<!--BEGIN my pagination buttons-->
<form method="get">
  @csrf
  @if (isset($_GET['q']))
  <input type="hidden" name="q" value="{{ $_GET['q'] }}">
  @endif
  <input type="hidden" name="page" value="@if (isset($_GET['page']) && $_GET['page'] > 1){{ $_GET['page']-1 }}@else{{ '1' }}@endif">
  <div class="ms-2 bd-highlight"><a onclick="this.closest('form').submit();return false;" class="btn @if (!isset($_GET['page']) || $_GET['page'] <= 1){{ "disabled" }}@endif" title="Previous page"><i class="bi-chevron-left"></i></a></div>
</form>
<div class="ms-2 bd-highlight"><a class="btn" data-bs-toggle="modal" data-bs-target="#pageNumberModal" href="#">@if (!isset($_GET['page']) || $_GET['page'] <= 1){{ "1" }}@else{{ $_GET['page'] }}@endif</a></div>
<!-- BEGIN page number modal -->
<div class="modal fade" id="pageNumberModal" tabindex="-1" aria-labelledby="pageNumberModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pageNumberModalLabel">Jump to page...</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
        @csrf
        @if (isset($_GET['q']))
        <input type="hidden" name="q" value="{{ $_GET['q'] }}">
        @endif
        <div class="modal-body">
          <input type="number" min="1" max="{{ $totalPageCount ?? '1' }}" name="page" class="form-control" id="pageNumberTextInput" autocomplete="off" value="@if (isset($_GET['page'])){{ $_GET['page'] }}@else{{ '1' }}@endif">
        </div>
        <div class="modal-footer">
          <a class="btn" href="#" onclick="document.getElementById('pageNumberTextInput').value='1'">First</a>
          <a class="btn" href="#" onclick="document.getElementById('pageNumberTextInput').value='{{ $totalPageCount ?? '1' }}'">Last</a>
          <button type="submit" class="btn btn-primary"><i class="me-2 bi-chevron-right"></i>Jump</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END page number modal -->
<form method="get">
  @csrf
  @if (isset($_GET['q']))
  <input type="hidden" name="q" value="{{ $_GET['q'] }}">
  @endif
  <input type="hidden" name="page" value="@if (isset($_GET['page'])){{ $_GET['page']+1 }}@else{{ '2' }}@endif">
  <div class="ms-2 bd-highlight"><a onclick="this.closest('form').submit();return false;" class="btn @if (!isset($totalPageCount) || $totalPageCount==1 || (isset($_GET['page'])) && $_GET['page'] >= $totalPageCount){{ "disabled" }}
  @endif" title="Next page"><i class="bi-chevron-right"></i></a></div>
</form>
<!--END my pagination buttons-->
