<!--BEGIN my search query-->
@if (isset($currentSearchQuery))
<p>Showing results for query: <b>{{ $currentSearchQuery }}</b>. <a href="{{ route('preference.reset', ['name'=>'currentSearchQuery']).'?redirect='."http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; }}">Clear</a></p>
@endif
<!--END my search query-->
