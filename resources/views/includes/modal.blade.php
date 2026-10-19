<div class="modal" id="character-{{ $character->id }}" role="dialog"
     aria-labelledby="character-{{ $character->id }}-name">
    <div class="modal-box max-w-6xl">
        <a href="#!" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">
            <x-heroicon-o-x-mark class="w-5 h-5"/>
        </a>

        <div class="flex flex-col sm:flex-row gap-6">
            <img src="{{ $character->image }}" alt="{{ $character->name }}"
                 width="300" height="300" loading="lazy"
                 class="rounded-box w-40 h-40 sm:w-48 sm:h-48 object-cover shrink-0">

            <div class="space-y-3">
                <h2 id="character-{{ $character->id }}-name" class="text-2xl font-bold">{{ $character->name }}</h2>

                <span
                    class="badge {{ $character->status->badgeClass() }} uppercase">{{ $character->status->label() }}</span>

                <dl class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-1 text-sm">
                    <dt class="uppercase font-bold">Species:</dt>
                    <dd class="uppercase">{{ $character->species }}@if ($character->hasSubtype())
                            <span class="uppercase font-bold">({{ $character->type }})</span>
                        @endif</dd>

                    <dt class="uppercase font-bold">Gender:</dt>
                    <dd class="uppercase">{{ $character->gender }}</dd>

                    <dt class="uppercase font-bold">Origin:</dt>
                    <dd class="uppercase">{{ $character->origin }}</dd>

                    <dt class="uppercase font-bold">Last seen:</dt>
                    <dd class="uppercase">{{ $character->location }}</dd>

                    <dt class="uppercase font-bold">Episodes :</dt>
                    <dd class="uppercase">{{ count($character->episodeIds) }}</dd>
                </dl>
            </div>

        </div>
        <div class="mt-4">
            @if(count($character->episodeIds) != 0)
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-2">
                    @foreach ($character->episodeIds as $id)
                        @isset ($episodes[$id])
                            <div class="text-xs">
                                <span class="font-bold uppercase">{{ $episodes[$id]->name }}</span>
                                (#{{ $episodes[$id]->id }})
                                <br>
                                <span class="text-xxs">{{ $episodes[$id]->airdate }}</span>
                            </div>
                        @endisset
                    @endforeach
                </div>
            @else
                No episodes listed
            @endif
        </div>
    </div>

    <a href="#!" class="modal-backdrop" aria-label="Close">Close</a>
</div>
