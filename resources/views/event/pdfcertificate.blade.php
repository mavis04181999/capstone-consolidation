<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <title>Capstone Perspiration</title>
  </head>
  <style>
      * {
          margin: 0;
          padding: 0;
      }
      .certificate {
        width: 100%;
      }
      .showcase {
        background-size: cover;
        background-position: center;
        /* height: 100vh; */
        
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        
        text-align: center;
        /* padding: 0 20px; */
      }
  </style>
  <body>

    <div class="header-wrapper">

    </div>

    <div class="body-wrapper">
        <div class="showcase mt-4">
            <img class="certificate" src="storage/event-certificate/{{ $event->event_certificate }}" alt="">
            <h2 style=" margin-top: 575px; margin-right: 250px;;" class="float-right certificate-name">{{ $participant->certificate_name }}</h2>
        </div>
    </div>

    <div class="footer-wrapper">

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>