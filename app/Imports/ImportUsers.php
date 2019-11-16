<?php

namespace App\Imports;

use App\Course;
use App\Department;
use App\Section;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportUsers implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $username = (int) $row['username'];
        $firstname = ucwords($row['firstname']);
        $middlename = ucwords($row['middlename']);
        $lastname = ucwords($row['lastname']);
        $email = $row['email'];
        $department = $this->getDepartmentID(Str::upper($row['department']));
        $course = $this->getCourseID(Str::upper($row['course']));
        $year = (int) $row['year'];
        $section = $this->getSectionID(Str::upper($row['section']));

        $contactno = $row['contactno'];
        $address = ucwords($row['address']);

        $password = Str::upper(Str::random(6));
        $role = Str::lower('USER');

        return new User([
            'username' => $username,
            'firstname' => $firstname,
            'middlename' => $middlename,
            'lastname'=> $lastname,
            'email' => $email,
            'department_id' => $department,
            'course_id' => $course,
            'year' => $year,
            'section_id' => $section,
            'contactno' => $contactno,
            'address' => $address,
            'temppassword' => $password,
            'password' => Hash::make($password),
            'role' => $role
        ]);
    }

    public function rules() : array{
        return [
            'firstname' => ['required', 'min:3'],
            'middlename' => ['sometimes', 'min:3'],
            'lastname' => ['required', 'min:3'],
            'email' => ['required', 'unique:users'],
            'username' => ['required', 'unique:users', 'min:3'],
            'contactno' => ['sometimes', 'alpha_dash', 'nullable'],
            'year' => ['numeric']
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

    public function getDepartmentID($department){
        if ($department == null) {
            return null;
        }

        $department = Department::where('abbr', $department)->first();
        return $department->id;
    }

    public function getCourseID($course){
        if ($course == null) {
            return null;
        }

        $course = Course::where('abbr', $course)->first();
        return $course->id;
    }

    public function getSectionID($section){
        if ($section == null) {
            return null;
        }

        $section = Section::where('section', $section)->first();
        return $section->id;
    }
}
