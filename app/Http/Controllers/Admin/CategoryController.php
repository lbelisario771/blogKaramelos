<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    
    //Se crea para proteger las rutas de los usarios ya que en el archivo WEb.php de Routes, las rutas son creadas por el RESOURCE
    public function __construct()
    {
        $this->middleware('can:admin.categories.index')->only('index');
        $this->middleware('can:admin.categories.create')->only('create', 'store');
        $this->middleware('can:admin.categories.edit')->only('edit', 'update');
        $this->middleware('can:admin.categories.destroy')->only('destroy');

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

   
    public function create()
    {
        return view('admin.categories.create');
    }

    
    public function store(Request $request)
    {
        //reglas de validacion

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);
            $category = Category::create($request->all());
            return redirect()->route('admin.categories.index')->with('info', 'Registro guardado con exito');
    }

   
    public function edit(Category $category)
    {
        
        return view('admin.categories.edit', compact('category'));
    }

   
    public function update(Request $request, Category $category)
    {
         //reglas de validacion

         $request->validate([
            'name' => 'required',
            'slug' => "required|unique:categories,slug,$category->id"
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories.edit', $category)->with('info', 'Registro actualizado con exito');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('info', 'Registro eliminado con exito');
    }
}
