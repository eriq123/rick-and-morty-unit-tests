<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <main-app />
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>