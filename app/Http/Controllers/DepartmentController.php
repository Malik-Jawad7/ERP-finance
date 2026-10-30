<?php
namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\CustomNotification;
use Illuminate\Http\Request;
class DepartmentController extends Controller {
    public function index() { $departments = Department::withCount("employees")->orderByDesc("id")->paginate(10); return view("departments.index", compact("departments")); }
    public function create() { return view("departments.create"); }
    public function store(Request $r) { 
        $r->validate(["name"=>"required"]);
        Department::create($r->all()); 
        CustomNotification::create(["title" => "New Department", "message" => "Department {$r->name} created.", "icon" => "department"]);
        return redirect()->route("departments.index")->with("success","Department created!"); 
    }
    public function edit(Department $department) { return view("departments.edit", compact("department")); }
    public function update(Request $r, Department $department) { 
        $r->validate(["name"=>"required"]);
        $department->update($r->all()); 
        return redirect()->route("departments.index")->with("success","Department updated!"); 
    }
    public function destroy(Department $department) { $department->delete(); return redirect()->route("departments.index")->with("success","Department deleted!"); }
    public function destroyAll() { Department::query()->delete(); return redirect()->route("departments.index")->with("success","All departments deleted!"); }
}