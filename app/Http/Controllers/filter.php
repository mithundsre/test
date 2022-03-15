<?php

namespace App\Http\Controllers;

use App\Models\student;
use Illuminate\Http\Request;

class filter extends Controller
{
    public function filter(Request $request)
    {
        if($request->ajax())
        {
            if($request->from_date != '' && $request->to_date != '')
            {
                $data = student::whereBetween('dob', array($request->from_date, $request->to_date))
                    ->get();
            }
            else
            {
                $data = student::orderBy('dob', 'desc')->get();
            }
            echo json_encode($data);
        }
    }
}
