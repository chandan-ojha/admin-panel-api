<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

/*
 * Project Name: Admin Panel
 * Development Start-End: 24th November 2022 to 25th November 2022
 * Author: Chandan
*/

class EmployeeController extends BaseController
{
    /*
     * API: 1
     * Purpose: Get Employee List
     * Route: api/pp/get-employee-list
     * Method: Get
    */
    public function get_employee_list(){
        $employee_list = Employee::get(['id','name','position','age','start_date','salary']);

        //~ Check Availability of data
        if(count($employee_list)>0){
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

    /*
     * API: 2
     * Purpose: Create Employee
     * Route: api/pp/create-employee
     * Method: Post
    */
    public function create_employee(Request $request){
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->age = $request->age;
        $employee->start_date = $request->start_date;
        $employee->salary = $request->salary;

        if($employee->save())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Employee created successfully!"
            ]);
        }
        else
        {
            return response()->json([
                'status_code' =>400,
                'message' =>"Employee not created!"
            ]);
        }
    }
}
