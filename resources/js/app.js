import Alpine from '@alpinejs/csp'

Alpine.data('themeToggle', () => ({
    toggle() {
        const root = document.documentElement
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
        const current = root.dataset.theme ?? (prefersDark ? 'dark' : 'corporate')
        const next = current === 'dark' ? 'corporate' : 'dark'

        root.dataset.theme = next
        document.cookie = `theme=${next}; path=/; max-age=31536000; SameSite=Lax`
    },
}))

Alpine.data('filters', () => ({
    submit() {
        this.$refs.form.requestSubmit()
    },

    clearName() {
        this.$refs.name.value = ''
        this.submit()
    },
}))

Alpine.data('dismissable', () => ({
    open: true,

    close() {
        this.open = false
    },
}))

window.Alpine = Alpine
Alpine.start()
