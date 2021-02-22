<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del Post']) !!}

    @error('name')
     
        <small class="text-danger">{{$message}}</small>
        
    @enderror
</div>
<div class="form-group">
    {!! Form::label('slug', 'Slug') !!}
    {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el slug del Post', 'readonly']) !!}

    @error('slug')
        
        <small class="text-danger">{{$message}}</small>
    
    @enderror
</div>
<div class="form-group">
    {!! Form::label('category_id', 'Categorias') !!}
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
    @error('category_id')
        
        <small class="text-danger">{{$message}}</small>
    
    @enderror
</div>
<div class="form-group">
    <p class="font-weigth-bold">Etiquetas</p>
    @foreach ($tags as $tag)
        <label class="mr-2">
            {!! Form::checkbox('tags[]', $tag->id, null) !!}
            {{$tag->name}}
        </label>
        
    @endforeach
    @error('tags')
        <br>
        <small class="text-danger">{{$message}}</small>
    
    @enderror
</div>
<div class="form-group">
    <p class="font-weigth-bold">Estado</p> 
    <label>
        {!! Form::radio('status', 1, true) !!}
        Borrador
    </label>
    <label>
        {!! Form::radio('status', 2) !!}
        Publicado
    </label>
    <hr>
    @error('status')
        
        <small class="text-danger">{{$message}}</small>
    
    @enderror
</div>

{{-- subir imagenes al servidor --}}
 <div class="row mb-3">
    <div class="col">
        <div class="image-wrapper">
           @isset ($post->image)   {{-- se coloca isset para verificar que lo que colocamos ahi esta definido (en vez de if) --}}
                <img id="picture" src="{{Storage::url($post->image->url)}}" alt="">
                @else 
                <img id="picture" src="https://cdn.pixabay.com/photo/2020/12/10/10/17/jasper-national-park-5819878__340.jpg" alt="">
           @endisset
        </div>
        
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('file','Imagen a mostrar en el Post') !!}
            {!! Form::file('file', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}
           
            @error('file')
            <small class="text-danger">{{$message}}</small>
            @enderror
            
        </div>
        
        <p><strong> Seleccione una imagen para su Post</strong></p>
    </div>

 </div>



<div class="form-group">
    {!! Form::label('extract', 'Extracto:') !!}
    {!! Form::textarea('extract', null,  ['class' => 'form-control']) !!}
    @error('extract')
        
        <small class="text-danger">{{$message}}</small>

    @enderror
</div>
<div class="form-group">
    {!! Form::label('body', 'Cuerpo del Post:') !!}
    {!! Form::textarea('body', null,  ['class' => 'form-control']) !!}
    @error('body')
        
        <small class="text-danger">{{$message}}</small>

    @enderror
</div>