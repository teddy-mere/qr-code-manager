@php
    $message = null;
    $type = null;
    $bgClass = '';
    
    if (Session::get('success')) {
        $message = Session::get('success');
        $type = 'success';
        $bgClass = 'bg-green-100 text-green-900';
    } elseif (Session::get('error')) {
        $message = Session::get('error');
        $type = 'error';
        $bgClass = 'bg-red-100 text-red-900';
    } elseif (Session::get('warning')) {
        $message = Session::get('warning');
        $type = 'warning';
        $bgClass = 'bg-yellow-100 text-yellow-900';
    } elseif (Session::get('info')) {
        $message = Session::get('info');
        $type = 'info';
        $bgClass = 'bg-blue-100 text-blue-900';
    } elseif ($errors->any()) {
        $type = 'errors';
        $bgClass = 'bg-red-100 text-red-900';
    }
@endphp

@if($type)
<div class="fixed top-0 right-0 m-6 z-50">
    <div data-state="show" class="data-[state=show]:animate-in data-[state=hide]:animate-out flash-message rounded-lg shadow-lg px-4 py-3 {{ $bgClass }} max-w-3xl sm:max-w-xl min-w-60 flex items-start justify-between text-sm fade-in slide-in-from-top-8 fade-out slide-out-to-top-8 fill-mode-forwards" role="alert">
        <div class="flex-1">
            @if($type === 'errors')
                @if(count($errors) > 1)
                <strong>Merci de vérifier les erreurs suivantes :</strong>
                <ul class="mt-2 ml-4 list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @else
                    {{ $errors->first() }}
                @endif
            @else
                {{ $message }}
            @endif
        </div>
        <button class="flash-close ml-4 hover:opacity-70 cursor-pointer" aria-label="Fermer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>
</div>
@endif