<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Event Certificate</title>

  <link rel="stylesheet" href="css/app.css">
</head>
<style>
  *{
    padding: 0;
    margin: 0;
  }
  #certificate-img {
    margin-top: 1em;
    width: 100%;
    background-size: cover;
    background-position: center;
    
  }
  #certificate {
    /* background-image: url('') */
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-content: center;
    text-align: center;
  }
  #certificate h1 {
    margin-top: 625px;
    margin-left: 525px;
    font-size: 51px;
  }
</style>
<body>

  <section id="certificate">
    <img id="certificate-img" src="storage/event-certificate/{{ $event->event_certificate }}">
    <h1>{{ $participant->certificate_name }}</h1>
  </section>

</body>
</html>