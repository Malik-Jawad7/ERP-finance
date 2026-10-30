<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Client;
use App\Models\CustomNotification;
use Illuminate\Http\Request;
class ProjectController extends Controller {
    public function index() { $projects = Project::with("client")->orderByDesc("id")->paginate(10); return view("projects.index", compact("projects")); }
    public function create() { $clients = Client::all(); return view("projects.create", compact("clients")); }
    public function store(Request $r) { 
        $r->validate(["name"=>"required"]);
        Project::create($r->all()); 
        CustomNotification::create(["title" => "New Project", "message" => "Project {$r->name} created.", "icon" => "project"]);
        return redirect()->route("projects.index")->with("success","Project created!"); 
    }
    public function edit(Project $project) { $clients = Client::all(); return view("projects.edit", compact("project", "clients")); }
    public function update(Request $r, Project $project) { 
        $r->validate(["name"=>"required"]);
        $project->update($r->all()); 
        return redirect()->route("projects.index")->with("success","Project updated!"); 
    }
    public function destroy(Project $project) { $project->delete(); return redirect()->route("projects.index")->with("success","Project deleted!"); }
    public function destroyAll() { Project::query()->delete(); return redirect()->route("projects.index")->with("success","All projects deleted!"); }
}