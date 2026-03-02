=<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!-- font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- app custom css -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        @stack('assetCss')
    </head>
    <body>
        <div>
          <section>
              @yield('content')
          </section>
        </div>

        @stack('assetJs')
        <script src="{{ mix('js/app.js') }}"></script>

        <noscript>
          This website relies on JavaScript, which you appear to have disabled. You will not be
          able to use many of this website's features without JavaScript enabled.
        </noscript>
    </body>
</html>
