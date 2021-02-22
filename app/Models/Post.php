<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //se habilita la asignacion masiva / se pudo utilizar el metodo fillable , se incluye los campos al contrario los que quiero asignar masivamente
    protected $guarded = ['id', 'created_at', 'updated_at']; //solo se colocan los campos que no quieren que se asignen masivamente
    //relacion 1 a muchos (inversa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    //relacion muchos a muchos
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    //relacion 1 a 1 polimorfica
    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }
    
}
