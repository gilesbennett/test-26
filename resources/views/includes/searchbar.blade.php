<form method="GET" action="{{ route('encyclopaedia.get') }}" x-data="filters" x-ref="form">
    <div class="navbar bg-base-100 shadow-sm flex flex-col lg:flex-row justify-between px-4 w-full gap-2">
        <div class="flex flex-row items-start gap-x-2">
            <input type="search" name="name" x-ref="name"
                   value="{{ $filters['name'] ?? '' }}"
                   class="input join-item" placeholder="Search by name"
                   @input.debounce.400ms="submit">
            @if (! empty($filters['name']))
                <button type="button" class="btn join-item" aria-label="Clear search" @click="clearName">
                    Clear
                </button>
            @endif
        </div>
    </div>
</form>
