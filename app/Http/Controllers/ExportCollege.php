<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportCollege extends Controller
{
    public function exportCsv()
    {
        $fileName = 'registered_college_students.csv';

        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            // Define column width
            $columnWidth = 24;

            // Headers
            $headers = [
                'Last Name',
                'First Name',
                'Middle Initial',
                'Course and Year',
                'Address',
                'Birthday',
                'Contact Person',
                'Contact Number',
                'Id Number',
                'Email',
            ];

            fputcsv($handle, $this->padColumns($headers, $columnWidth), ',');

            // Data rows
            $students = DB::table('registered_college_students')->get();

            foreach ($students as $student) {
                fputcsv($handle, $this->padColumns([
                    $student->lastname,
                    $student->firstname,
                    $student->middleinitial,
                    $student->courseyear,
                    $student->address,
                    $student->birthday,
                    $student->contactperson,
                    $student->contactnumber,
                    $student->idnumber,
                    $student->email,
                ], $columnWidth), ',');
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }

    private function padColumns(array $columns, int $width): array
    {
        return array_map(function ($column) use ($width) {
            return str_pad(substr($column, 0, $width), $width);
        }, $columns);
    }
}
