import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('image', () => ({
    open: false,

    toggle() {
        const element = this.$refs.image;

        if (element.src.length === 0) {
            element.src = element.dataset.src;
        }

        this.open = !this.open
    }
}))

Alpine.start();
