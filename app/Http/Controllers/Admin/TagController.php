<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    
     //Se crea para proteger las rutas de los usarios ya que en el archivo WEb.php de Routes, las rutas son creadas por el RESOURCE
     public function __construct()
     {
         $this->middleware('can:admin.tags.index')->only('index');
         $this->middleware('can:admin.tags.create')->only('create', 'store');
         $this->middleware('can:admin.tags.edit')->only('edit', 'update');
         $this->middleware('can:admin.tags.destroy')->only('destroy');
 
     }


    public function index()
    {
        $tags = Tag::all();
        return view('admin.tags.index', compact('tags'));
    }

    
    public function create()
    {
        return view('admin.tags.create');
    }

    
    public function store(Request $request)
    {
         //reglas de validacion

         $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:tags'
        ]);
            $tag = Tag::create($request->all());
            return redirect()->route('admin.tags.index')->with('info', 'Registro guardado con exito');
    }

    
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required',
            'slug' => "required|unique:tags,slug,$tag->id"
        ]);

        $tag->update($request->all());
        return redirect()->route('admin.tags.edit', $tag)->with('info', 'Registro actualizado con exito');
    }

    
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('info', 'Registro eliminado con exito');
    }
}
