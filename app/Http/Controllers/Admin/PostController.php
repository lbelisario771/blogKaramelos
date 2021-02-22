<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage; //para mover las imagenes a la carpeta public que es la unica que accede el navegador


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Se usa el metodo pluck para el laravel collective tome los nombres de las categorias
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //PARA QUE LARAVEL GUARDE EN LA CARPETA PUBLIC SE CAMBIA EN CONFIG -> FILESYSTEM  (LOCAL) POR 'Public'
        //return Storage::put('posts', $request->file('file'));
        
        $post = Post::create($request->all());
        if ($request->file('file')) {
            $url = Storage::put('posts', $request->file('file'));
            $post->image()->create([
                'url' => $url
            ]);
        }

        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }
        return redirect()->route('admin.posts.edit', $post); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //se hace referencia al  Policy asociado al User
        $this->authorize('author', $post);
         //Se usa el metodo pluck para el laravel collective tome los nombres de las categorias
         $categories = Category::pluck('name', 'id');
         $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        //se hace referencia al  Policy asociado al User
        $this->authorize('author', $post);

        $post->update($request->all());

        // Si se actualliza una imagen se hace esto, se pregunta si esta mandando alguna imagen
        if ($request->file('file')) {
            $url = Storage::put('posts', $request->file('file'));

            //Preguntamos si este post ya contaba con una imagen, la borramos
            if ($post->image) {
                Storage::delete($post->image->url);

                $post->image()->update([
                    'url' => $url
                ]);
            }else{
                $post->image()->create([ //se crea un nuevo registro, y en el campo url coloca la imagen que acabammos de subir
                    'url' =>  $url
                ]);
            }
            
        }
        if ($request->tags) {
            $post->tags()->sync($request->tags);//El metodo sync sincroniza la coleccion que se esta mandando por este metodo  con los registros que tengmos actualmente en la tabla intermedia postag
        }
        return redirect()->route('admin.posts.edit', $post)->with('info', 'El Post se actualizo con exito'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //se hace referencia al  Policy asociado al User
        $this->authorize('author', $post);

        $post->delete();
        return redirect()->route('admin.posts.index')->with('info', 'El Post se elimino con exito'); 
    }
}
