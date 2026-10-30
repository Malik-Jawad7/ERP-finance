<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Department;
use App\Models\CustomNotification;
use Illuminate\Http\Request;
class EmployeeController extends Controller {
    public function index() { $employees = Employee::with("department")->orderByDesc("id")->paginate(10); return view("employees.index", compact("employees")); }
    public function create() { $departments = Department::all(); return view("employees.create", compact("departments")); }
    public function store(Request $r) { 
        $r->validate(["name"=>"required"]);
        Employee::create($r->all()); 
        CustomNotification::create(["title" => "New Employee", "message" => "Employee {$r->name} added.", "icon" => "user"]);
        return redirect()->route("employees.index")->with("success","Employee created!"); 
    }
    public function edit(Employee $employee) { $departments = Department::all(); return view("employees.edit", compact("employee", "departments")); }
    public function update(Request $r, Employee $employee) { 
        $r->validate(["name"=>"required"]);
        $employee->update($r->all()); 
        return redirect()->route("employees.index")->with("success","Employee updated!"); 
    }
    public function destroy(Employee $employee) { $employee->delete(); return redirect()->route("employees.index")->with("success","Employee deleted!"); }
    public function destroyAll() { Employee::query()->delete(); return redirect()->route("employees.index")->with("success","All employees deleted!"); }
}