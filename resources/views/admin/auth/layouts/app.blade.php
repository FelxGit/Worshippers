<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!-- font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet"/>
        <!-- app custom css -->
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        @stack('assetCss')
    </head>
    <body>
        <main style="position: relative">
          <div class="auth-overlay"></div>
          <div class="auth-panel">
            <div class="left-pane">
              <div class="welcome-text">
                <div>
                  <img class="logo-sm" src="{{ asset('images/communitylogo.png') }}" />
                </div>
                <div>
                  <h5>{{ __('messages.CommunityDevelopers') }}</h5>
                  <p>{{ __('messages.WelcomeToChronoCommunity') }}</p>
                </div>
              </div>
            </div>
            <div class="right-pane">
              @yield('content')
            </div>
          </div>
        </div>
        <script src="{{ asset('js/admin.js') }}"></script>
        @stack('assetJs')
        <noscript>
          This website relies on JavaScript, which you appear to have disabled. You will not be
          able to use many of this website's features without JavaScript enabled.
        </noscript>
    </body>
</html>
