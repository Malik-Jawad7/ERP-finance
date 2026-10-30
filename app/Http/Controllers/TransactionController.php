<?php
namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Vendor;
use App\Models\CustomNotification;
use Illuminate\Http\Request;

class TransactionController extends Controller {
    public function index() { 
        $transactions = Transaction::with(["account","vendor"])->orderByDesc("occurred_at")->paginate(10); 
        return view("transactions.index", compact("transactions")); 
    }
    public function create() { 
        $accounts = Account::all(); $vendors = Vendor::all(); 
        return view("transactions.create", compact("accounts","vendors")); 
    }
    public function store(Request $r) { 
        $d = $r->validate([
            "title" => "required|string|max:255",
            "type"=>"required", 
            "amount"=>"required|numeric", 
            "occurred_at"=>"required|date"
        ]);
        $latest = Transaction::withTrashed()->orderByDesc("id")->first(); 
        $d["reference"] = "TXN-" . str_pad(($latest ? $latest->id + 1 : 1), 5, "0", STR_PAD_LEFT);
        $d["account_id"] = $r->account_id; 
        $d["vendor_id"] = $r->vendor_id; 
        $d["description"] = $r->description;
        
        Transaction::create($d); 
        CustomNotification::create(["title" => "New Transaction", "message" => "Transaction {$d['reference']} recorded.", "icon" => "transaction"]);
        return redirect()->route("transactions.index")->with("success","Transaction recorded!"); 
    }
    public function edit(Transaction $transaction) { 
        $accounts = Account::all(); $vendors = Vendor::all(); 
        return view("transactions.edit", compact("transaction","accounts","vendors")); 
    }
    public function update(Request $r, Transaction $transaction) { 
        $d = $r->validate([
            "title" => "required|string|max:255",
            "type"=>"required", 
            "amount"=>"required|numeric", 
            "occurred_at"=>"required|date"
        ]);
        $d["account_id"] = $r->account_id; 
        $d["vendor_id"] = $r->vendor_id; 
        $d["description"] = $r->description;
        $transaction->update($d); 
        return redirect()->route("transactions.index")->with("success","Transaction updated!"); 
    }
    public function destroy(Transaction $transaction) { 
        $transaction->delete(); 
        return redirect()->route("transactions.index")->with("success","Transaction deleted!"); 
    }
    public function destroyAll() { 
        Transaction::query()->delete(); 
        return redirect()->route("transactions.index")->with("success","All transactions deleted!"); 
    }
}