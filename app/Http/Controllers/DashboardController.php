<?php
namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\Account;
use App\Models\Payroll;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $thisMonthStart = now()->startOfMonth();
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd   = now()->subMonth()->endOfMonth();

        // ---------- Revenue ----------
        $totalRevenue = Invoice::where("status","paid")->sum("total");
        $revenueThis  = Invoice::where("status","paid")->whereBetween("issued_at", [$thisMonthStart, now()])->sum("total");
        $revenueLast  = Invoice::where("status","paid")->whereBetween("issued_at", [$lastMonthStart, $lastMonthEnd])->sum("total");

        // ---------- Outstanding ----------
        $outstanding = Invoice::whereIn("status", ["sent","overdue","partial"])->sum("total");
        $outThis     = Invoice::whereIn("status", ["sent","overdue","partial"])->whereBetween("issued_at", [$thisMonthStart, now()])->sum("total");
        $outLast     = Invoice::whereIn("status", ["sent","overdue","partial"])->whereBetween("issued_at", [$lastMonthStart, $lastMonthEnd])->sum("total");

        // ---------- Expenses ----------
        $totalExpenses = Expense::sum("amount");
        $expThis       = Expense::whereBetween("spent_at", [$thisMonthStart, now()])->sum("amount");
        $expLast       = Expense::whereBetween("spent_at", [$lastMonthStart, $lastMonthEnd])->sum("amount");

        // ---------- Payroll ----------
        $totalPayroll = Payroll::where("status", "paid")->sum("net_salary");

        // ---------- Net Profit ----------
        $netProfit     = $totalRevenue - $totalExpenses - $totalPayroll;
        $profitThis    = $revenueThis - $expThis;
        $profitLast    = $revenueLast - $expLast;

        // ---------- Cash in Hand ----------
        $cashInHand = Account::sum("balance");

        // ---------- Payments ----------
        $totalPayments = Payment::sum("amount");
        $paymentsThis  = Payment::whereBetween("paid_at", [$thisMonthStart, now()])->sum("amount");
        $paymentsLast  = Payment::whereBetween("paid_at", [$lastMonthStart, $lastMonthEnd])->sum("amount");

        // ---------- Clients ----------
        $activeClients = Client::where("status","active")->count();

        $kpis = [
            ["label"=>"Total Revenue","value"=>$this->formatMoney($totalRevenue),"delta"=>$this->fmt($this->pct($revenueThis,$revenueLast)),"up"=>$revenueThis>=$revenueLast,"color"=>"indigo","icon"=>"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2"],
            ["label"=>"Outstanding","value"=>$this->formatMoney($outstanding),"delta"=>$this->fmt($this->pct($outThis,$outLast)),"up"=>$outThis>=$outLast,"color"=>"amber","icon"=>"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"],
            ["label"=>"Total Expenses","value"=>$this->formatMoney($totalExpenses),"delta"=>$this->fmt($this->pct($expThis,$expLast)),"up"=>$expThis<=$expLast,"color"=>"rose","icon"=>"M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"],
            ["label"=>"Net Profit","value"=>$this->formatMoney($netProfit),"delta"=>$this->fmt($this->pct($profitThis,$profitLast)),"up"=>$profitThis>=$profitLast,"color"=>"emerald","icon"=>"M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"],
            ["label"=>"Cash In Hand","value"=>$this->formatMoney($cashInHand),"delta"=>"+0","up"=>true,"color"=>"sky","icon"=>"M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"],
            ["label"=>"Payments Received","value"=>$this->formatMoney($totalPayments),"delta"=>$this->fmt($this->pct($paymentsThis,$paymentsLast)),"up"=>$paymentsThis>=$paymentsLast,"color"=>"teal","icon"=>"M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"],
        ];

        // ---------- Cashflow Chart (7 months) ----------
        $cashflow = collect(range(6,0))->map(function($m){
            $s = now()->subMonths($m)->startOfMonth();
            $e = now()->subMonths($m)->endOfMonth();
            $inc = Invoice::where("status", "paid")->whereBetween("issued_at", [$s, $e])->sum("total");
            $exp = Expense::whereBetween("spent_at", [$s, $e])->sum("amount");
            return ["label"=>$s->format("M Y"),"income"=>(float)$inc,"expense"=>(float)$exp];
        });

        // ---------- Recent ----------
        $recentTransactions = Transaction::orderByDesc("occurred_at")->take(5)->get();
        $recentInvoices = Invoice::with("client")->orderByDesc("issued_at")->take(5)->get();
        $recentPayments = Payment::with("invoice.client")->orderByDesc("id")->take(5)->get();

        $topClients = Client::withSum(["invoices as paid_total"=>fn($q)=>$q->where("status","paid")],"total")
            ->having("paid_total", ">", 0)
            ->orderByDesc("paid_total")
            ->take(4)
            ->get();

        return view("dashboard", compact("kpis","cashflow","recentTransactions","recentInvoices","recentPayments","topClients"));
    }

    private function formatMoney($amount) {
        $currency = Setting::where('key', 'currency')->value('value') ?? 'USD';
        $symbols = ['USD' => '$', 'PKR' => 'Rs ', 'EUR' => '€', 'GBP' => '£'];
        $symbol = $symbols[$currency] ?? '$';

        $sign = $amount < 0 ? '-' : '';
        $abs = abs($amount);
        if ($abs >= 1000000000) return $sign . $symbol . number_format($abs / 1000000000, 1) . 'B';
        if ($abs >= 1000000) return $sign . $symbol . number_format($abs / 1000000, 1) . 'M';
        if ($abs >= 1000) return $sign . $symbol . number_format($abs / 1000, 1) . 'K';
        return $sign . $symbol . number_format($abs, 0);
    }

    private function pct($c,$p){ if($p==0) return $c>0?100:0; return (($c-$p)/abs($p))*100; }
    private function fmt($d){ return ($d>=0?"+":"").number_format($d,1)."%"; }
}