export default {
    watch: {
        selected(newValue, oldValue) {
            if (newValue === this.$vnode.key) {
                this.onFocus();
            }
        }
    },

    computed: {
        selected: {
            set(v) {
                this.$store.commit('select', this.$vnode.key);
            },
            get() {
                return this.$store.state.selected;
            }
        }
    },

    mounted() {
        if (this.$store.state.selected === this.$vnode.key) {
            this.onFocus();
        }
    }
};
