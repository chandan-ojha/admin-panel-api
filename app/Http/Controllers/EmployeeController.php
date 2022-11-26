<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    /*
     * Project Name: Admin Panel
     * Development Start-End: 24th November 2022 to 25th November 2022
     * Author: Chandan
    */
    public function get_employee_list()
    {
        $employee_list = Employee::get(['id','name','position','age','start_date','salary']);

        //~ Check Availability of data
        if(count($employee_list )>0){
            return $this->sendResponse(200,'Success.',
                [
                    'count_data' => count($employee_list),
                    'employee_list' => $employee_list
                ]
            );
        }
        //~ Empty Data Response
        return $this->sendError('204','Data not found!');
    }
}
