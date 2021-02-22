<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Esto se hace para que ningun usuario pueda modificar el id desde el navegador (inspeccioar )
       /* if ($this->user_id == auth()->user()->id) {
        return true;
       }else{
        return false;
       } */

       return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //para recuperar la informacion del post. para que se habilite el slug al editarlo
        $post = $this->route()->parameter('post');
        //cuando vayamos a crear un nuevo registro funcionan estas reglas
       $rules = [
            'name' => 'required',
            'slug' => 'required|unique:posts',
            'status' => 'required|in:1,2',
            'file' => 'image'
       ];
       //cuando vayamos a editar un registro funcioinaran estas reglas
       if ($post) {
           $rules['slug'] = 'required|unique:posts,slug,' . $post->id;
       }
       if($this->status == 2){
           //se fusionan las dos reglas de validacion las anteriores con unas nuevas
           $rules = array_merge($rules, [

            'category_id' => 'required',
            'tags' => 'required',
            'extract' => 'required',
            'body' => 'required'


           ]);

       }
       return $rules;
    }
}
