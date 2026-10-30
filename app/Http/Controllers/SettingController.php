<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index() {
        $settings = DB::table("settings")->pluck("value", "key")->toArray();
        return view("settings", compact("settings"));
    }

    public function update(Request $request) {
        $data = $request->except(["_token", "_method", "logo", "favicon"]);
        
        // Ensure uploads directory exists
        if (!file_exists(public_path('uploads'))) {
            mkdir(public_path('uploads'), 0777, true);
        }

        // Save Logo directly to public/uploads
        if ($request->hasFile("logo")) {
            $file = $request->file("logo");
            $filename = "logo_" . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data["logo"] = "uploads/" . $filename;
        }

        // Save Favicon directly to public/uploads
        if ($request->hasFile("favicon")) {
            $file = $request->file("favicon");
            $filename = "favicon_" . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data["favicon"] = "uploads/" . $filename;
        }

        foreach($data as $key => $value) {
            DB::table("settings")->updateOrInsert(
                ["key" => $key],
                ["value" => $value, "updated_at" => now(), "created_at" => now()]
            );
        }
        return redirect()->back()->with("success", "Settings updated successfully! Refresh the page to see the changes.");
    }
}