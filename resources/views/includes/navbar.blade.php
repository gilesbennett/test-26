<div class="navbar bg-base-100 shadow-sm flex flex-row justify-between px-4">
    <h1 class="uppercase font-bold text-xl">Rick & Morty Encyclopaedia</h1>
    <button type="button" class="btn btn-ghost btn-circle"
            x-data="themeToggle" @click="toggle" aria-label="Toggle dark mode">
        <x-heroicon-o-sun class="switcher-icon-light w-6 h-6"/>
        <x-heroicon-o-moon class="switcher-icon-dark w-6 h-6"/>
    </button>
</div>
