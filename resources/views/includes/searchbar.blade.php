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
        <div class="flex flex-row">
            <fieldset>
                <legend class="sr-only">Status</legend>

                <div class="join">
                    <input type="radio" name="status" value=""
                           class="join-item btn btn-sm checked:btn-primary" aria-label="Any"
                           @checked(empty($filters['status']))
                           @change="submit">

                    @foreach (\App\Models\CharacterStatus::cases() as $status)
                        <input type="radio" name="status" value="{{ $status->value }}"
                               class="join-item btn btn-sm {{ $status->radioClass() }}"
                               aria-label="{{ $status->label() }}"
                               @checked(($filters['status'] ?? null) === $status->value)
                               @change="submit">
                    @endforeach
                </div>
            </fieldset>
        </div>
        <div class="flex flex-row">
            <fieldset>
                <legend class="sr-only">Gender</legend>

                <div class="join">
                    <input type="radio" name="gender" value=""
                           class="join-item btn btn-sm checked:btn-primary" aria-label="Any"
                           @checked(empty($filters['gender']))
                           @change="submit">

                    @foreach (\App\Models\CharacterGender::cases() as $gender)
                        <input type="radio" name="gender" value="{{ $gender->value }}"
                               class="join-item btn btn-sm {{ $gender->radioClass() }}"
                               aria-label="{{ $gender->label() }}"
                               @checked(($filters['gender'] ?? null) === $gender->value)
                               @change="submit">
                    @endforeach
                </div>
            </fieldset>
        </div>
    </div>

</form>
