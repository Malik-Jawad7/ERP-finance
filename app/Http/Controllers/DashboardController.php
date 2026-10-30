<?php
namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $thisMonthStart = now()->startOfMonth();
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd   = now()->subMonth()->endOfMonth();

        // Revenue
        $totalRevenue = Invoice::where("status","paid")->sum("total");
        $revenueThis  = Invoice::where("status","paid")->whereBetween("issued_at", [$thisMonthStart, now()])->sum("total");
        $revenueLast  = Invoice::where("status","paid")->whereBetween("issued_at", [$lastMonthStart, $lastMonthEnd])->sum("total");

        // Outstanding
        $outstanding = Invoice::whereIn("status", ["sent","overdue"])->sum("total");
        $outThis     = Invoice::whereIn("status", ["sent","overdue"])->whereBetween("issued_at", [$thisMonthStart, now()])->sum("total");
        $outLast     = Invoice::whereIn("status", ["sent","overdue"])->whereBetween("issued_at", [$lastMonthStart, $lastMonthEnd])->sum("total");

        // Expenses & Profit
        $totalExpenses = Expense::sum("amount");
        $netProfit     = $totalRevenue - $totalExpenses;
        $expThis       = Expense::whereBetween("spent_at", [$thisMonthStart, now()])->sum("amount");
        $expLast       = Expense::whereBetween("spent_at", [$lastMonthStart, $lastMonthEnd])->sum("amount");
        $profitThis    = $revenueThis - $expThis;
        $profitLast    = $revenueLast - $expLast;

        // Clients
        $activeClients = Client::where("status","active")->count();

        $kpis = [
            ["label"=>"Total Revenue","value"=>$this->formatMoney($totalRevenue),"delta"=>$this->fmt($this->pct($revenueThis,$revenueLast)),"up"=>$revenueThis>=$revenueLast,"color"=>"indigo","icon"=>"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2"],
            ["label"=>"Outstanding","value"=>$this->formatMoney($outstanding),"delta"=>$this->fmt($this->pct($outThis,$outLast)),"up"=>$outThis>=$outLast,"color"=>"amber","icon"=>"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"],
            ["label"=>"Net Profit","value"=>$this->formatMoney($netProfit),"delta"=>$this->fmt($this->pct($profitThis,$profitLast)),"up"=>$profitThis>=$profitLast,"color"=>"emerald","icon"=>"M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"],
            ["label"=>"Active Clients","value"=>number_format($activeClients),"delta"=>"+0","up"=>true,"color"=>"sky","icon"=>"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"],
        ];

        // Cashflow Chart
        $cashflow = collect(range(6,0))->map(function($m){
            $s = now()->subMonths($m)->startOfMonth();
            $e = now()->subMonths($m)->endOfMonth();
            $inc = Invoice::where("status", "paid")->whereBetween("issued_at", [$s, $e])->sum("total");
            $exp = Expense::whereBetween("spent_at", [$s, $e])->sum("amount");
            return ["label"=>$s->format("M Y"),"income"=>(float)$inc,"expense"=>(float)$exp];
        });

        // Recent Data
        $recentTransactions = Transaction::orderByDesc("occurred_at")->take(5)->get();
        $recentInvoices = Invoice::with("client")->orderByDesc("issued_at")->take(5)->get();
        
        $topClients = Client::withSum(["invoices as paid_total"=>fn($q)=>$q->where("status","paid")],"total")
            ->having("paid_total", ">", 0)
            ->orderByDesc("paid_total")
            ->take(4)
            ->get();

        return view("dashboard", compact("kpis","cashflow","recentTransactions","recentInvoices","topClients"));
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