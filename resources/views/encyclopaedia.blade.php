@extends('layouts.main')

@section('content')
    @include('includes.searchbar')
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

@section('pagination')
    <div class="my-8 flex justify-center">
        {{ $characters->withQueryString()->onEachSide(1)->links() }}
    </div>
@endsection

@section('modals')
    @foreach ($characters as $character)
        @include('includes.modal', ['character' => $character, 'episodes' => $episodes])
    @endforeach
@endsection

