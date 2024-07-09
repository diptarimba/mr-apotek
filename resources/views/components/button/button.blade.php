@props(['url' => '#', 'label' => 'Submit', 'colour' => 'green', 'id' => null])
@isset($url)
    <a href="{{ $url }}">
    @endisset
    <button {{$id ? 'id='.$id : ''}}
        class="btn m-1 text-white bg-{{ $colour }}-500 border-{{ $colour }}-500 hover:bg-{{ $colour }}-600 hover:border-{{ $colour }}-600 focus:bg-{{ $colour }}-600 focus:border-{{ $colour }}-600 focus:ring focus:ring-{{ $colour }}-500/30 active:bg-{{ $colour }}-600 active:border-{{ $colour }}-600">{{ $label }}</button>
    @isset($url)
    </a>
@endisset
