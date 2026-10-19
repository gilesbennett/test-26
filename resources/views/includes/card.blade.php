<div class="card bg-base-100 w-full shadow-sm">
    <figure>
        <img class="w-full aspect-square object-cover" src="{{ $character->image }}" alt="{{ $character->name }}">
    </figure>
    <div class="card-body items-center">
        <h2 class="card-title">{{ $character->name }}</h2>
        <div class="card-actions">
            <a href="#character-{{ $character->id }}" class="btn btn-sm btn-primary">
                View full details
            </a>
        </div>
    </div>
</div>
