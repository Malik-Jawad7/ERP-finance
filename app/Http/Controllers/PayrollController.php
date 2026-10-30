<?php
namespace App\Http\Controllers;
use App\Models\Payroll;
use App\Models\User;
use App\Models\CustomNotification;
use Illuminate\Http\Request;

class PayrollController extends Controller {
    public function index() {
        $payrolls = Payroll::with("user")->orderByDesc("id")->paginate(10);
        return view("payrolls.index", compact("payrolls"));
    }
    
    public function create() {
        $users = User::orderBy("name")->get();
        return view("payrolls.create", compact("users"));
    }
    
    public function store(Request $r) {
        $d = $r->validate([
            "user_id" => "required|exists:users,id",
            "month" => "required|string",
            "basic_salary" => "required|numeric",
            "allowances" => "nullable|numeric",
            "deductions" => "nullable|numeric",
            "status" => "required|in:pending,paid",
            "payment_date" => "nullable|date"
        ]);
        $d["allowances"] = $d["allowances"] ?? 0;
        $d["deductions"] = $d["deductions"] ?? 0;
        $d["net_salary"] = $d["basic_salary"] + $d["allowances"] - $d["deductions"];
        Payroll::create($d);
        
        CustomNotification::create(["title" => "New Payroll", "message" => "Payroll generated for employee.", "icon" => "payroll"]);
        
        return redirect()->route("payrolls.index")->with("success","Payroll generated successfully!");
    }
    
    public function edit(Payroll $payroll) {
        $users = User::orderBy("name")->get();
        return view("payrolls.edit", compact("payroll", "users"));
    }
    
    public function update(Request $r, Payroll $payroll) {
        $d = $r->validate([
            "user_id" => "required|exists:users,id",
            "month" => "required|string",
            "basic_salary" => "required|numeric",
            "allowances" => "nullable|numeric",
            "deductions" => "nullable|numeric",
            "status" => "required|in:pending,paid",
            "payment_date" => "nullable|date"
        ]);
        $d["allowances"] = $d["allowances"] ?? 0;
        $d["deductions"] = $d["deductions"] ?? 0;
        $d["net_salary"] = $d["basic_salary"] + $d["allowances"] - $d["deductions"];
        $payroll->update($d);
        
        CustomNotification::create(["title" => "Payroll Updated", "message" => "Payroll details updated.", "icon" => "payroll"]);
        
        return redirect()->route("payrolls.index")->with("success","Payroll updated successfully!");
    }
    
    public function destroy(Payroll $payroll) {
        $payroll->delete();
        return redirect()->route("payrolls.index")->with("success","Payroll deleted!");
    }
}