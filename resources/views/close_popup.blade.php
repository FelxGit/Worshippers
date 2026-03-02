<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Close Window</title>
    </head>
    <body>
        <script>
            let token = {!! json_encode(request()->data['token'] ?? null) !!};
            let user = {!! json_encode(request()->data['user'] ?? null) !!};

            // Check if token and user exist before proceeding
            if (token && user) {
                localStorage.setItem('community.jwt', JSON.stringify(token));
                localStorage.setItem('community.user', JSON.stringify(user));
            }

            window.opener.location.reload();  //instructs the parent window to reload its content from the server.
            window.close();
        </script>
    </body>
</html>
