<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
     //Habilitamos la asignacion masiva
     protected $fillable = ['name', 'slug'];

     //metodo para mostrar el slug en vez del ID
     public function getRouteKeyName()
     {
         return "slug";
     }

    //relacion muchos a muchos inversa polimorfica
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

   


}
