<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Participants - {{ $event->event_name }}</title>

    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <section class="header">
        <img src="storage/logo/cspc-logo-iso.png" height="125" width="500" alt="">
        <hr>
        <p style="text-align: center;"><strong>Participants - {{ $event->event_name }}</strong></p>
    </section>

    <section class="body" id="participants">
        <table class="table table-bordered">
            <thead>
                <tr class="text-center">
                    <th>USERNAME</th>
                    <th>PASSWORD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($participants as $participant)
                    <tr class="text-center">
                        <td>{{$participant->user->username}}</td>
                        <td>{{$participant->user->temppassword}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>
</html>