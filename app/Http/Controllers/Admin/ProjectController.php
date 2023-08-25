<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::paginate(15);

        return view("admins.project.index", compact("projects"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admins.project.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $data = $request->validate([
            'title'=> ['required', 'unique:projects', 'min:10', 'max:255'],
            'image'=> ['required', 'image'],
            'content'=> ['required', 'min:10'],
        ]);

        if ($request->hasFile('image')){
            $img_path = Storage::put('uploads/image', $request['image']);//salvo l'immagine preso in uploads e la metto nella storage
            $data['image'] = $img_path;
        }
        
        $data['slug'] = Str::of($data['title'])->slug('-');
        $newProject = Project::create($data);

        return redirect()->route('admin.projects.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view("admins.project.show", compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admins.project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //validazione dei dati
        $data = $request->validate([
            'title'=> ['required', 'min:10', 'max:255', Rule::unique('projects')->ignore($project->id)],
            'image'=> ['image'],
            'content'=> ['required', 'min:10'],
        ]);

        if ($request->hasFile('image')){
            Storage::delete($project->image);
            $img_path = Storage::put('uploads/image', $request['image']);//salvo l'immagine preso in uploads e la metto nella storage
            $data['image'] = $img_path;
        }

        $data['slug'] = Str::of($data['title'])->slug('-');

        $project->update($data);
        return redirect()->route('admin.projects.show', compact('project'));

        //aggiornamento seguito a validazione corretta
        //reindirizzamento alla index o alla show
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        Storage::delete($project->image);
        $project->delete();
        return redirect()->route('admin.projects.index');
    }
}
