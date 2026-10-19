@php
    $alertClasses = ['success' => 'alert-success', 'warning' => 'alert-warning', 'error' => 'alert-error'];
@endphp

<div class="toast toast-top toast-end z-50">
    @foreach ($alertClasses as $type => $alertClass)
        @if (session($type))
            <div role="alert" class="alert {{ $alertClass }}" x-data="dismissable" x-show="open">
                <span>{{ session($type) }}</span>
                <button type="button" class="btn btn-sm btn-ghost" @click="close" aria-label="Dismiss">✕</button>
            </div>
        @endif
    @endforeach
    @if ($errors->any())
        <div role="alert" class="alert alert-error" x-data="dismissable" x-show="open">
            <span>{{ $errors->first() }}</span>
            <button type="button" class="btn btn-sm btn-ghost" @click="close" aria-label="Dismiss">✕</button>
        </div>
    @endif
</div>
