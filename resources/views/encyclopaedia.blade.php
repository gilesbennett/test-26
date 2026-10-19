@extends('layouts.main')

@section('content')
    <div>
        <div class="px-4 pt-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-5 gap-8 gap-x-8">
                @forelse($characters as $character)
                    @include('includes.card', ['character' => $character])
                @empty
                    <div class="col-span-full text-center">
                        <h3 class="uppercase font-bold">No characters returned.</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

