<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/font/bootstrap-icons.css">

    <!-- My CSS -->
    <link href="/css/my-style.css" rel="stylesheet">

    <!-- Google Fonts CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <title>{{ env('APP_NAME') }}</title>
  </head>
  <body>
    <div class="container">
      <div class="row vertical-center align-items-center">
        <div class="col-sm-5">
          <h1 class="fw-bold">Get <span class="bg-dark text-light px-1">organised</span>.</h1>
          <p><b>{{ env('APP_NAME') }}</b> sorts your tasks out for you so you can declutter your mind and actually start doing them.</p>
          <div class="mt-5">
            @if(Auth::id() !== null)
            <a class="btn bg-dark text-light" href="/tasks">See your tasks</a>
            @else
            <a class="btn bg-dark text-light" href="/register">Get started</a>
            <a class="btn" href="/login">Log in</a>
            @endif
          </div>
        </div>
        <div class="col-sm-6 hide-on-small-screen">
          <a href="https://undraw.co/illustrations" target="_blank">
            <img width="100%" src="/images/undraw_Reading_time_re_phf7.png" alt="Illustration by unDraw. Click to go to the artist's website.">
          </a>
        </div>
      </div>
    </div>
  </body>
</html>
