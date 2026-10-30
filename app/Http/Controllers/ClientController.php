<?php
namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;
class ClientController extends Controller {
    public function index() { $clients = Client::withCount("invoices")->orderByDesc("id")->paginate(10); return view("clients.index", compact("clients")); }
    public function create() { return view("clients.create"); }
    public function store(Request $r) { $r->validate(["name"=>"required","status"=>"required"]); Client::create($r->all()); \App\Models\CustomNotification::create(["title" => "New Client", "message" => "A new client was added.", "icon" => "user"]); return redirect()->route("clients.index")->with("success","Client created!"); }
    public function edit(Client $client) { return view("clients.edit", compact("client")); }
    public function update(Request $r, Client $client) { $r->validate(["name"=>"required","status"=>"required"]); $client->update($r->all()); return redirect()->route("clients.index")->with("success","Client updated!"); }
    public function destroy(Client $client) { $client->delete(); return redirect()->route("clients.index")->with("success","Client deleted!"); }
    public function destroyAll() { Client::query()->delete(); return redirect()->route("clients.index")->with("success","All clients deleted!"); }
}