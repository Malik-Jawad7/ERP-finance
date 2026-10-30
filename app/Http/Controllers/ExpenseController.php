<?php
namespace App\Http\Controllers;
use App\Models\Expense;
use Illuminate\Http\Request;
class ExpenseController extends Controller {
    public function index() { $expenses = Expense::orderByDesc("spent_at")->paginate(10); return view("expenses.index", compact("expenses")); }
    public function create() { return view("expenses.create"); }
    public function store(Request $r) { $r->validate(["title"=>"required","amount"=>"required","spent_at"=>"required"]); Expense::create($r->all()); \App\Models\CustomNotification::create(["title" => "New Expense", "message" => "Expense recorded successfully.", "icon" => "expense"]); return redirect()->route("expenses.index")->with("success","Expense created!"); }
    public function edit(Expense $expense) { return view("expenses.edit", compact("expense")); }
    public function update(Request $r, Expense $expense) { $r->validate(["title"=>"required","amount"=>"required","spent_at"=>"required"]); $expense->update($r->all()); return redirect()->route("expenses.index")->with("success","Expense updated!"); }
    public function destroy(Expense $expense) { $expense->delete(); return redirect()->route("expenses.index")->with("success","Expense deleted!"); }
    public function destroyAll() { Expense::query()->delete(); return redirect()->route("expenses.index")->with("success","All expenses deleted!"); }
}