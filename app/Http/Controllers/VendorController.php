<?php
namespace App\Http\Controllers;
use App\Models\Vendor;
use App\Models\CustomNotification;
use Illuminate\Http\Request;

class VendorController extends Controller {
    public function index() { $vendors = Vendor::orderByDesc("id")->paginate(10); return view("vendors.index", compact("vendors")); }
    public function create() { return view("vendors.create"); }
    public function store(Request $r) { 
        $r->validate(["name"=>"required"]);
        Vendor::create($r->all()); 
        CustomNotification::create(["title" => "New Vendor", "message" => "Vendor '{$r->name}' added.", "icon" => "user"]);
        return redirect()->route("vendors.index")->with("success","Vendor created!"); 
    }
    public function edit(Vendor $vendor) { return view("vendors.edit", compact("vendor")); }
    public function update(Request $r, Vendor $vendor) { 
        $r->validate(["name"=>"required"]);
        $vendor->update($r->all()); 
        CustomNotification::create(["title" => "Vendor Updated", "message" => "Vendor '{$vendor->name}' updated.", "icon" => "user"]);
        return redirect()->route("vendors.index")->with("success","Vendor updated!"); 
    }
    public function destroy(Vendor $vendor) { $vendor->delete(); return redirect()->route("vendors.index")->with("success","Vendor deleted!"); }
    public function destroyAll() { Vendor::query()->delete(); return redirect()->route("vendors.index")->with("success","All vendors deleted!"); }
}