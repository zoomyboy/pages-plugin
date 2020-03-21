<template>
    <div class="zg-bg-gray-800 zg-rounded zg-p-2 zg-flex zg-items-center flex">
        <input type="text" v-model="value.name" class="zg-leading-none zg-bg-gray-800 zg-outline-none zg-text-center zg-text-white zg-w-full zg-border-0 flex-grow">
        <a href="#" @click.prevent="edit" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-cog"></span></a>
        <a href="#" @click.prevent="remove" class="hover:zg-no-underline"><span class="zg-text-white icon-trash"></span></a>
    </div>
</template>

<script>
import VColumn from './VColumn';

export default {

    props: {
        value: {}
    },

    components: { VColumn },

    methods: {
        edit() {
            this.$store.dispatch('modal/open', {
                'component': this.value.is,
                params: { value: this.value }
            }).then(data => {
                this.$emit('input', data);
            }).catch(err => {
                console.log(err);
            });
        },
        remove() {
            this.$emit('remove');
        }
    },

    async created() {
        if (this.value.new) {
            this.$store.dispatch('modal/open', {
                'component': this.value.is,
                params: { value: this.value }
            }).then(data => {
                this.$emit('input', { ...data, new: false });
                this.$emit('permanent');
            }).catch(err => {
                this.$emit('destroy');
            });
        }
    }
};
</script>
