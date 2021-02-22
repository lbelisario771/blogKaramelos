<?php

namespace App\Observers;

use App\Models\Post;
use PhpParser\Node\Stmt\If_;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    //SE VA UTILIZAR PARA PASARLE EL ID DEL USUARIO AL POST (OCULTO) Y PROTEGERLO DE AQUELLOS QUE MOFIQUEN LA PAGINA DESDE INSPECCIONAR
    public function creating(Post $post) 
    {
        $post->user_id = auth()->user()->id;
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
     //Este evento se va activa justo antes de borrar el post, para eliminar la imagen primero
     public function deleting(Post $post)
    {
        //llamamos al objeto post y preguntamos si exite una imagen asociada a ese post
        if($post->image){ 
            Storage::delete($post->image->url);
        }
    }
    //HAY QUE REGISTRAR EL OBSERVER EN APP/PROVIDER/EVENTSERVICEPROVIDER
}
