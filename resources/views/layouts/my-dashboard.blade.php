<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font/bootstrap-icons.css" rel="stylesheet">

    <!-- My CSS -->
    <link href="/css/my-style.css" rel="stylesheet">

    <!-- Google Fonts CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <title>@if(isset($pageTitle)){{$pageTitle.' | ' }}@endif{{ env('APP_NAME') }}</title>
  </head>
  <body>
    @include('components.my-side-nav-bar')
    @include('components.my-top-nav-bar')
    <div class="container-fluid">
      @include('components.my-search-query')
      @yield('my-content-area')
    </div>
    @include('components.my-bottom-nav-bar')
    @include('components.my-fixed-bottom-nav-bar')
    <div class="h-25 hide-on-wide-screen"></div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/my-script.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>
