@props(['message' => '', 'color' => '', 'copy' => false])

<div class="mb-2 relative flex justify-between px-5 py-2 border-2 text-{{$color}}-500 border-{{$color}}-200 rounded alert-dismissible">
    <p>{{$message}}</p>
    <div class="flex items-end">
        @if($copy)
        <button class="alert-copy text-lg text-slate-500 hover:text-{{$color}}-600" onclick="navigator.clipboard.writeText('{{$message}}')"> <i class="mdi mdi-content-copy"></i> </button>
        @endif
        <button class="alert-close ltr:ml-auto rtl:mr-auto text-{{$color}}-400 text-lg"><i class="mdi mdi-close"></i></button>
    </div>
</div>
