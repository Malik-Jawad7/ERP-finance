<?php
namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\CustomNotification;
use Illuminate\Http\Request;

class InvoiceController extends Controller {
    public function index() { 
        $invoices = Invoice::with("client")->orderByDesc("id")->paginate(10); 
        return view("invoices.index", compact("invoices")); 
    }
    public function create() { 
        $clients = Client::where("status","active")->orderBy("name")->get(); 
        return view("invoices.create", compact("clients")); 
    }
    public function store(Request $r) { 
        $d = $r->validate(["client_id"=>"required","amount"=>"required|numeric","status"=>"required","issued_at"=>"required|date"]);
        $d["tax"] = (float)($r->tax ?? 0); 
        $d["amount"] = (float)$d["amount"]; 
        $d["total"] = $d["amount"] + $d["tax"];
        
        $userInvoices = Invoice::where('user_id', auth()->id())->count();
        $nextNumber = $userInvoices + 1;
        
        $prefix = 'INV-';
        do {
            $invoiceNo = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            $exists = Invoice::where('user_id', auth()->id())->where('invoice_no', $invoiceNo)->exists();
            if ($exists) $nextNumber++;
        } while ($exists);
        
        $d["invoice_no"] = $invoiceNo;
        $d["user_id"] = auth()->id();
        
        Invoice::create($d); 
        
        // ONLY ONE Notification
        CustomNotification::create([
            "title" => "New Invoice", 
            "message" => "Invoice {$invoiceNo} generated successfully.", 
            "icon" => "invoice"
        ]);
        
        return redirect()->route("invoices.index")->with("success","Invoice created!"); 
    }
    public function edit(Invoice $invoice) { 
        $clients = Client::where("status","active")->orderBy("name")->get(); 
        return view("invoices.edit", compact("invoice", "clients")); 
    }
    public function update(Request $r, Invoice $invoice) { 
        $d = $r->validate(["client_id"=>"required","amount"=>"required|numeric","status"=>"required","issued_at"=>"required|date"]);
        $d["tax"] = (float)($r->tax ?? 0); 
        $d["amount"] = (float)$d["amount"]; 
        $d["total"] = $d["amount"] + $d["tax"];
        
        $invoice->update($d); 
        
        // ONLY ONE Notification
        CustomNotification::create([
            "title" => "Invoice Updated", 
            "message" => "Invoice {$invoice->invoice_no} updated successfully.", 
            "icon" => "invoice"
        ]);
        
        return redirect()->route("invoices.index")->with("success","Invoice updated!"); 
    }
    public function destroy(Invoice $invoice) { 
        $invoice->delete(); 
        return redirect()->route("invoices.index")->with("success","Invoice deleted!"); 
    }
    public function destroyAll() { 
        Invoice::query()->delete(); 
        return redirect()->route("invoices.index")->with("success","All invoices deleted!"); 
    }
}