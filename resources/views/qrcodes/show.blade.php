@extends('layouts.guest')
@section('title', $qrcode->title)

@section('content')
<div class="min-h-screen bg-sidebar p-4 flex flex-col items-center">
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">{{ $qrcode->title }}</h1>

        @foreach($qrcode->fields as $field)
        <div class="mb-4 bg-background rounded-lg shadow p-4">
            <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ $field['label'] }}</h2>
            <p class="text-gray-900 dark:text-gray-100">{{ $field['value'] }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection