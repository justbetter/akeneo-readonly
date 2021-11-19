@if (file_exists(public_path('storage/logo.png')))
    <img {{ $attributes }} src="{{ url('storage/logo.png') }}"/>
@else
    <h1 {{ $attributes->merge(['class' => 'text-3xl']) }}>{{ config('app.name') }}</h1>
@endif
