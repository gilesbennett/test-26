@extends('layouts.main')

@section('content')
    <div class="hero min-h-[70vh]">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <a href="{{ route('encyclopaedia.get') }}" class="btn btn-primary">Browse characters</a>
            </div>
        </div>
    </div>
@endsection
