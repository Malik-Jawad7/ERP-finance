<?php
namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\CustomNotification;
use Illuminate\Http\Request;

class PaymentController extends Controller {
    public function index() {
        $payments = Payment::with("invoice.client")->orderByDesc("id")->paginate(10);
        return view("payments.index", compact("payments"));
    }
    
    public function create(Request $request) {
        $invoices = Invoice::whereIn("status", ["sent", "overdue", "partial"])->with("client")->get();
        $selectedInvoice = $request->invoice_id;
        return view("payments.create", compact("invoices", "selectedInvoice"));
    }
    
    public function store(Request $r) {
        $d = $r->validate([
            "invoice_id" => "required|exists:invoices,id",
            "amount" => "required|numeric|min:0.01",
            "method" => "required",
            "paid_at" => "required|date",
        ]);
        
        // FIX: User-specific receipt number
        $userPaymentsCount = Payment::where("user_id", auth()->id())->count();
        $nextNumber = $userPaymentsCount + 1;
        
        // Ensure unique (loop in case of deletion gaps)
        do {
            $receiptNo = "RCP-" . str_pad($nextNumber, 5, "0", STR_PAD_LEFT);
            $exists = Payment::where("user_id", auth()->id())->where("receipt_no", $receiptNo)->exists();
            if ($exists) $nextNumber++;
        } while ($exists);
        
        $d["receipt_no"] = $receiptNo;
        $d["user_id"] = auth()->id();
        $d["reference"] = $r->reference;
        $d["notes"] = $r->notes;
        
        $payment = Payment::create($d);
        
        // Update invoice status
        $invoice = Invoice::find($d["invoice_id"]);
        $totalPaid = Payment::where("invoice_id", $invoice->id)->sum("amount");
        
        if ($totalPaid >= $invoice->total) {
            $invoice->status = "paid";
        } else {
            $invoice->status = "partial";
        }
        $invoice->save();
        
        CustomNotification::create([
            "title" => "New Payment",
            "message" => "Payment {$receiptNo} of " . number_format($d['amount'], 2) . " recorded.",
            "icon" => "payment"
        ]);
        
        return redirect()->route("payments.show", $payment)->with("success", "Payment recorded! Receipt ready.");
    }
    
    public function show(Payment $payment) {
        $payment->load("invoice.client");
        return view("payments.show", compact("payment"));
    }
    
    public function destroy(Payment $payment) {
        $payment->delete();
        return redirect()->route("payments.index")->with("success", "Payment deleted!");
    }
}