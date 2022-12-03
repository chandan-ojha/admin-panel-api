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
     * Purpose: Get Single Employee Information
     * Route: api/pp/get-single-employee-info
     * Method: Get
     * Parameter: emp_id
    */
    public function get_single_employee_info($emp_id){
        $employee_info = Employee::where('id',$emp_id)->first();

        //~ Check Availability of data
        if(!empty($employee_info)){
            return $this->sendResponse(200,'Success.',
                [
                    'employee_info' => $employee_info
                ]
            );
        }
        //~ Empty Data Response
        return $this->sendError('204','Data not found!');
    }

    /*
     * API: 3
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
                'message' =>"Employee created successfully!",
                'id' => $employee->id,
                'name' => $employee->name,
                'position' => $employee->position,
                'age' => $employee->age,
                'start_date' => $employee->start_date,
                'salary' => $employee->salary
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

    /*
     * API: 4
     * Purpose: Update Employee
     * Route: api/pp/update-employee
     * Method: Put
     * Parameter: emp_id
    */
    public function update_employee(Request $request, $emp_id){
        $update_employee = Employee::where('id',$emp_id)->first();
        $update_employee->name = $request->name;
        $update_employee->position = $request->position;
        $update_employee->age = $request->age;
        $update_employee->start_date = $request->start_date;
        $update_employee->salary = $request->salary;

        if($update_employee->save())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Employee updated successfully!",
                'id' => $update_employee->id,
                'name' => $update_employee->name,
                'position' => $update_employee->position,
                'age' => $update_employee->age,
                'start_date' => $update_employee->start_date,
                'salary' => $update_employee->salary
            ]);
        }
        else
        {
            return response()->json([
                'status_code' =>400,
                'message' =>"Employee not updated !"
            ]);
        }

    }

    /*
     * API: 5
     * Purpose: Delete Employee
     * Route: api/pp/delete-employee
     * Method: delete
     * Parameter: emp_id
    */
    public function delete_employee($emp_id){
        $employee = Employee::where('id',$emp_id)->first();

        if($employee->delete())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Employee deleted successfully!"
            ]);
        }
        else {
            return response()->json([
                'status_code' =>400,
                'message' =>"Employee not deleted!"
            ]);
        }

    }
}
