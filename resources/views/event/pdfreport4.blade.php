<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Report - {{ $event->event_name }}</title>

    <link rel="stylesheet" href="css/app.css">
</head>
<style>
    /* .event-report p{
        text-align: justify;
    }
    .event-report p strong span{
        text-decoration: underline;
    } */
</style>
<body>

    <section class="header">
        <img src="storage/logo/cspc-logo-iso.png" height="125" width="500" alt="">
        <hr>
        <p style="text-align: center;"><strong>TRAINING PROGRAM EVALUATION</strong></p>
    </section>
    <section class="body">
        <div class="event-report">
            <p style="text:align: justify;"><strong>Title of Training/Program:&nbsp; <span style="text-decoration: underline;">{{ $event->event_name }}</span></strong></p>
            <p style="text:align: justify;"><strong>Date and Venue:&nbsp; <span style="text-decoration: underline;">{{ $event->created_at.': '.$event->location }}</span></strong></p>
            <p style="text:align: justify;"><strong>Instruction:&nbsp;  Please check [ / ] in the appropriate column your evaluation rating on the indicators below. The rating scales ranges from 1 - 4, where 4 - Excellent, 3 - Very Satisfactory, 2 - Satisfactory, 1 - Poor</strong></p>

            <br>

            <table width="525" style="height: 28px;" class="table-bordered">
                <tbody>
                    <tr style="height: 56px;">
                        <td style="height: 56px; width: 194px; text-align: center;"><strong>INDICATOR</strong></td>
                        <td style="height: 56px; width: 194px; text-align: center;">
                            <p><strong>RATING SCALE</strong></p>
                            <table style="height: 30px" width="173">
                                <tbody>
                                    <tr>
                                        @for ($i = 1; $i <= $maxOption; $i++)
                                            <td style="width: 30px; text-align:center;"><strong>{{ $i }}</strong></td>
                                        @endfor
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="height: 56px; width: 194px; text-align:center;"><strong>REMARKS</strong></td>
                    </tr>
                    @foreach ($reports as $report)
                        <tr style="height: 28px;">
                            <td style="height: 28px; width: 194px; text-align:center;">{{$report['question'] }}</td>
                            <td style="height: 28px; width: 194px; text:align:center;">
                                <table style="height: 30px;" width="173">
                                    <tbody>
                                        <tr>
                                            @if ($report['count'] == null)
                                                <td style="width: 30px; text-align:center;"><strong>0</strong></td>
                                            @else
                                                @foreach ($report['count'] as $count)
                                                    <td style="width: 30px; text-align:center;"><strong>{{ $count }}</strong></td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            @if (isset($reports['remarks']))
                                <td style="height: 28px; width:194px; text-align: center;"><strong>{{ $report['remarks'] }}</strong></td>
                            @else
                                <td style="height: 28px; width: 194px; text-align: center;"><strong>0</strong></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <br>

            @switch($overAllRating)
                @case($overAllRating >= 4)
                    <p><strong>Overall Rating: {{ $overAllRating.' / '. $maxOption }} - Excellent</strong></p>
                    @break
                @case($overAllRating >= 3)
                    <p><strong>Overall Rating: {{ $overAllRating.' / '. $maxOption }} - Very Satisfactory</strong></p>
                    @break
                @case($overAllRating >= 2)
                    <p><strong>Overall Rating: {{ $overAllRating.' / '. $maxOption }} - Satisfactory</strong></p>
                    @break
                @case($overAllRating >= 1)
                    <p><strong>Overall Rating: {{ $overAllRating.' / '. $maxOption }} - Poor</strong></p>
                    @break
                @default
                    <p><strong>Overall Rating: {{ $overAllRating.' / '. $maxOption }}</strong></p>
            @endswitch

            <p><strong>Comments/Suggestions/Recommendations</strong></p>

            <hr>

            @foreach ($comments as $comment)
                @if ($comments != null)
                    <p><cite>{{ $comment }}</cite></p>
                    <hr>
                @endif
            @endforeach
        </div>
    </section>
    
</body>
</html>