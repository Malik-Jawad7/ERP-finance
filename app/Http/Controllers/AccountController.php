<?php
namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\CustomNotification;
use Illuminate\Http\Request;

class AccountController extends Controller {
    public function index() { $accounts = Account::orderByDesc("id")->paginate(10); return view("accounts.index", compact("accounts")); }
    public function create() { return view("accounts.create"); }
    public function store(Request $r) { 
        $r->validate(["name"=>"required", "balance"=>"required|numeric"]);
        Account::create($r->all()); 
        CustomNotification::create(["title" => "New Account", "message" => "Account '{$r->name}' created.", "icon" => "account"]);
        return redirect()->route("accounts.index")->with("success","Account created!"); 
    }
    public function edit(Account $account) { return view("accounts.edit", compact("account")); }
    public function update(Request $r, Account $account) { 
        $r->validate(["name"=>"required", "balance"=>"required|numeric"]);
        $account->update($r->all()); 
        CustomNotification::create(["title" => "Account Updated", "message" => "Account '{$account->name}' updated.", "icon" => "account"]);
        return redirect()->route("accounts.index")->with("success","Account updated!"); 
    }
    public function destroy(Account $account) { $account->delete(); return redirect()->route("accounts.index")->with("success","Account deleted!"); }
    public function destroyAll() { Account::query()->delete(); return redirect()->route("accounts.index")->with("success","All accounts deleted!"); }
}