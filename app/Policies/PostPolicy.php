<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function author(User $user, Post $post)
    {
        if($user->id == $post->user_id){
            return true;
        }else{
            return false;
        }
    }
    // se le coloca el ? signo de interrogacion para que puedan acceder a los post estando o no logeados los usuarios
    public function published(?User $user, Post $post){

        if ($post->status == 2) {
            return true;
        }else{
            return false;
        }

    }
}
