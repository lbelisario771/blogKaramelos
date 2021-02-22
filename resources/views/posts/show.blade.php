<x-app-layout>
    <div class="container py-8">
        <h1 class="text-4xl font-bold text-gray-600">{{$post->name}}</h1>

        <div class="text-lg text-gray-500 mb-2">
            {!!$post->extract!!} {{-- se usan dos signos exclamacion para que no muestren las etiquetas <p>  </p --}}
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- contenido principal --}}
            <div class="lg:col-span-2">
                <figure>
                   @if ($post->image)
                   <img class="w-full h-80 object-cover object-center" src="{{Storage::url($post->image->url)}}" alt="imagen">
                   @else
                   <img class="w-full h-80 object-cover object-center" src="https://cdn.pixabay.com/photo/2020/12/10/10/17/jasper-national-park-5819878__340.jpg" alt="imagen">
                   @endif
                </figure>

                <div class="text-base text-gray-700 mt-4">
                    {!!$post->body!!} {{-- se usan dos signos exclamacion para que no muestren las etiquetas <p>  </p --}}
                </div>

            </div>

            {{-- contenido relacionado --}}
            <aside>

               <h1 class="text-2xl font-bold text-yellow-500 mb-4"> Mas en {{$post->category->name}}</h1>
                    
                    <ul>
                        @foreach ($similares as $similar)

                            <li class="mb-4">
                                <a class="flex" href="{{route('posts.show', $similar)}}">
                                   @if ($similar->image)
                                   <img class="w-36 h-20 object-cover object-center" src="{{Storage::url($similar->image->url)}}" alt="Imagen">
                                   @else
                                   <img class="w-36 h-20 object-cover object-center" src="https://cdn.pixabay.com/photo/2020/12/10/10/17/jasper-national-park-5819878__340.jpg" alt="Imagen">
                                   @endif
                                    <span class="ml-2 text-green-400">{{$similar->name}}</span>
                                </a>
                            </li>
                            
                        @endforeach
                    </ul>


            </aside>
        </div>

    </div>
</x-app-layout>
