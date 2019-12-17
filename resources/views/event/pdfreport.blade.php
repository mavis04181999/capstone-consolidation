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
  <body>

    <div class="header-wrapper">
        <img src="storage/logo/cspc-logo-iso.png" height="100" width="500" alt=""></<img>
        <hr>
        <p style="text-align: center;"><strong>TRAINING PROGRAM EVALUATION</strong></p>
    </div>

    <div class="body-wrapper">
        <p style="text-align: justify;"><strong>Title of Training:&nbsp;<span style="text-decoration: underline;">{{$event->event_name}}</span></strong></p>
        <p style="text-align: justify;"><strong>Date and Venue:&nbsp;<span style="text-decoration: underline;">{{$event->created_at}}: {{$event->location}}</span></strong></p>
        @if ($maxOption == 4)
        <p style="text-align: justify;">Instruction:&nbsp; Please check [ / ] in the appropriate column your evaluation rating on the indicators below. The rating scale ranges from 1-4 where 4 - Excellent; 3 - Very Satisfactory; 2 - Fair; 1 - Poor.</p>
        @else
        <p style="text-align: justify;">Instruction:&nbsp; Please check [ / ] in the appropriate column your evaluation rating on the indicators below. The rating scale ranges from 1-5 where 5 - Excellent; 4 - Very Satisfactory; 3 - Satisfactory; 2 - Fair; 1 - Poor.</p>
        @endif
        <p></p>
        <br>
        <table style="height: 28px;" width="525" class="table-bordered">
            <tbody>
                <tr style="height: 56px;">
                    <td style="width: 194px; text-align: center; height: 56px;"><strong>INDICATOR</strong></td>
                    <td style="width: 194px; text-align: center; height: 56px;">
                        <p><strong>RATING SCALE</strong></p>
                        <table style="height: 30px;" width="173">
                            <tbody>
                                <tr>
                                    {{-- foreach here --}}
                                    @for ($i = 1; $i <= $maxOption; $i++)
                                        <td style="width: 30px; text-align: center;"><strong>{{$i}}</strong></td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 194px; text-align: center; height: 56px;"><strong>REMARKS</strong></td>
                </tr>
                {{-- foreach here --}}
                @foreach ($reports as $report)
                <tr style="height: 28px;">
                    <td style="width: 194px; text-align: center; height: 28px;">{{$report['question']}}</td>
                    <td style="width: 194px; text-align: center; height: 28px;">
                        <table style="height: 30px;" width="173">
                            <tbody>
                                <tr>
                                    @if ($report['count'] == null)
                                        <td style="width: 30px; text-align: center;"><strong>0</strong></td>                                        
                                    @else
                                        @foreach ($report['count'] as $count)                            
                                            <td style="width: 30px; text-align: center;"><strong>{{ $count }}</strong></td>                                        
                                        @endforeach  
                                    @endif

                                </tr>
                            </tbody>
                        </table>
                    </td>
                    @if (isset($report['remarks']))
                        <td style="width: 194px; text-align: center; height: 28px;"><strong>{{ $report['remarks'] }}</strong></td>
                    @else
                        <td style="width: 194px; text-align: center; height: 28px;"><strong>0</strong></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        @if ($maxOption == 5)
            @switch($overAllRating)
                @case($overAllRating == 5)
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }} - Excellent</strong></span></p>
                    @break
                @case($overAllRating >= 4)
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }} - Very Satisfactory</strong></span></p>
                @break
                @case($overAllRating >= 3)
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }} - Satisfactory</strong></span></p>
                @break
                @case($overAllRating >= 2)
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }} - Fair</strong></span></p>
                @break
                @case($overAllRating >= 1)
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }} - Good</strong></span></p>
                @break
                @default
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }}</strong></span></p>
            @endswitch
        @else
            {{-- if max option is 4 --}}
            @switch($overAllRating)
                @case($overAllRating == 4)
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }} - Excellent</strong></span></p>
                @break
                @case($overAllRating >= 3)
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }} - Very Satisfactory</strong></span></p>
                @break
                @case($overAllRating >= 2)
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }} - Fair</strong></span></p>
                @break
                @case($overAllRating >= 1)
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }} - Poor</strong></span></p>
                @break
                @default
                    <p><strong>Overall Rating:</strong>&nbsp;<span style="text-decoration: underline;"><strong>{{ $overAllRating }} / {{ $maxOption }}</strong></span></p>
            @endswitch
        @endif
        <strong><strong>Comments/Suggestions/Recommendations:</strong></strong>
        <hr>
        @foreach ($comments as $comment)
            @if ($comment !== null)
                <p><cite>{{ $comment }}</cite></p>
                <hr>
            @endif
        @endforeach
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