<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;//se importa la paginacion

class PostsIndex extends Component
{
    use WithPagination;//se usa la paginacion
    protected $paginationTheme = "bootstrap"; //para usar las clases de bootstrap
    public $search;
    public function updatingsearch()
    {
        $this->resetPage();

    }

    public function render()
    {
        //Metodo para recupèrar el listado de Post  del usuario autentificado
        $posts = Post::where('user_id', auth()->user()->id)
                        ->where('name', 'LIKE', '%'. $this->search . '%')
                        ->latest('id')
                        ->paginate();
        return view('livewire.admin.posts-index', compact('posts'));
    }
}
