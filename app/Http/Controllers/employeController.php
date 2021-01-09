<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use Illuminate\Support\Facades\DB;

class employeController extends Controller
{
    public function getEmployees(Request $request){

        $employee = Employee::select(
            'id',
            'code',
            'name',
            'first_name',
            'second_first_name',
            'email',
            'contract_type',
            'status',
            DB::raw("CONCAT(name, ' ', first_name, ' ', second_first_name) as full_name")
        );

        if($request->name == ""){
            $employee = $employee->whereRaw("CONCAT('name', ' ', 'first_name', ' ', 'second_first_name') like '%$request->name%'");
        }

        $employee = $employee->where('status', '!=', 0)
            ->orderBy('name')
        ->get();

        return $employee;
    }

    public function storage(Request $request){
        $employee = new Employee($request->all());
        $employee->save();
    }

    public function updateEmployee(Request $request){
        $employee = Employee::findOrfail($request->id);
        $employee($request->all());
        $employee->save();
    }

    public function activate(Request $request){
        $employee = Employee::findOrFail($request->id);
        $employee->status = 1;
        $employee->save();
    }

    public function deactivate(Request $request){
        $employee = Employee::findOrFail($request->id);
        $employee->status = 0;
        $employee->save();
    }

    public function veriFyCode(Request $request){
        $employee = Employee::where('code', '=', $request->code)->first();

        if(empty($employee)){
            return false;
        }else return true;
    }

    public function veriFyEmail(Request $request){
        $employee = Employee::where('email', '=', $request->email)->first();

        if(empty($employee)){
            return false;
        }else return true;
    }
}
