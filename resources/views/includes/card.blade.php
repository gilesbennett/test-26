<div class="card bg-base-100 w-full shadow-sm">
    <figure>
        <img class="w-full " src="{{ $character->image }}" alt="{{ $character->name }}">
    </figure>
    <div class="card-body items-center">
        <h2 class="card-title">{{ $character->name }}</h2>
        <div class="card-actions">
            <button class="btn">
                View full details
            </button>
        </div>
    </div>
</div>
