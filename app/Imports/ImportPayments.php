<?php

namespace App\Imports;

use App\Event;
use App\Payment;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportPayments implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    public function __construct(Event $event) {
        // $this->$event = $event;
        $this->getEvent = $event;
        $event_id = $event;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $event = $this->getEvent->id;
        $user_id = $this->getUser($row['username']);
        $receipt = strtoupper($row['receipt']);
        $date = Carbon::parse($row['date'])->format('Y-m-d');

        return new Payment([
            'event_id' => $event,
            'user_id' => $user_id,
            'receipt' => $receipt,
            'date' => $date,
        ]);
    }

    public function rules() : array {
        return [
            'username' => ['required', 'exists:users,username'],
            'receipt' => ['required', 'min: 3', 'unique:payments,receipt'],
            'date' => ['required']
        ];
    }

    public function failures(){
        return $this->failures;
    }

    public function headingRow(){
        // import item starts on first row
        return 1;
    }

    public function batchSize(): int{
        // most optimal and standard for reading time
        return 1000;
    }

    public function chunkSize(): int{
        // most optimal and standard for memory consumption to make it under control
        return 1000;
    }

    public function getUser($username) {
        
        $user = User::where('username', $username)->first();

        return $user->id;

    }
}
