<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Expense;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo Users for Roles
        User::create(["name"=>"Super Admin","email"=>"admin@finerp.test","password"=>Hash::make("password"),"role"=>"admin"]);
        User::create(["name"=>"Accountant","email"=>"accountant@finerp.test","password"=>Hash::make("password"),"role"=>"accountant"]);
        User::create(["name"=>"Viewer","email"=>"viewer@finerp.test","password"=>Hash::make("password"),"role"=>"viewer"]);

        // Demo Clients
        $clients = [
            ["name"=>"Acme Corp","email"=>"billing@acme.test","company"=>"Acme","status"=>"active"],
            ["name"=>"Nova Studios","email"=>"ar@nova.test","company"=>"Nova","status"=>"active"],
            ["name"=>"Zephyr Logistics","email"=>"ap@zephyr.test","company"=>"Zephyr","status"=>"active"],
            ["name"=>"Orbit Media","email"=>"finance@orbit.test","company"=>"Orbit","status"=>"active"],
            ["name"=>"Lumen Health","email"=>"billing@lumen.test","company"=>"Lumen","status"=>"active"],
        ];
        foreach($clients as $c){ Client::create($c); }

        // Demo Invoices (with fixed amounts to prevent errors)
        for($i=1; $i<=15; $i++){
            $amount = rand(1500, 18000);
            Invoice::create([
                "invoice_no" => "INV-" . str_pad($i, 4, "0", STR_PAD_LEFT),
                "client_id" => rand(1, 5),
                "amount" => $amount,
                "tax" => $amount * 0.05,
                "total" => $amount * 1.05,
                "status" => ["paid","paid","sent","overdue"][rand(0,3)],
                "issued_at" => now()->subDays(rand(1, 60)),
                "due_at" => now()->addDays(rand(1, 30)),
            ]);
        }

        // Demo Expenses
        for($i=0; $i<10; $i++){
            Expense::create([
                "title" => "Office Expense " . $i,
                "category" => "office",
                "amount" => rand(100, 3000),
                "spent_at" => now()->subDays(rand(1, 30)),
            ]);
        }

        // Demo Transactions
        for($i=0; $i<20; $i++){
            Transaction::create([
                "title" => "Transaction " . $i,
                "reference" => "TXN-" . str_pad($i, 5, "0", STR_PAD_LEFT),
                "type" => ["income","expense","payout"][rand(0,2)],
                "amount" => rand(500, 10000),
                "occurred_at" => now()->subDays(rand(1, 90)),
            ]);
        }
    }
}