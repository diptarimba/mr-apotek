@props(['id' => '', 'label' => '', 'colour' => 'violet', 'class' => ''])

<button {{$id ? 'id='.$id.'' : ''}} type="button"
    class="inline-flex justify-center w-full px-4 py-2 mt-3 text-white font-medium sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm rounded-md shadow-sm border text-gray-700 bg-{{$colour}}-500  border-{{$colour}}-500 btn dark:text-gray-100 hover:bg-{{$colour}}-600 hover:border-{{$colour}}-600 focus:outline-none focus:ring-2 focus:ring-{{$colour}}-500/30 dark:bg-zinc-700 dark:border-zinc-600 dark:hover:bg-zinc-600 dark:focus:bg-zinc-600 dark:focus:ring-zinc-700 dark:focus:ring-{{$colour}}-500/20 {{$class}}"
    >{{$label}}</button>
