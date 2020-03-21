<template>
    <div class="zg-bg-gray-800 zg-rounded zg-p-2 zg-flex zg-items-center flex">
        <input type="text" v-model="value.name" class="zg-leading-none zg-bg-gray-800 zg-outline-none zg-text-center zg-text-white zg-w-full zg-border-0 flex-grow">
        <a href="#" @click.prevent="edit" class="hover:zg-no-underline"><span class="zg-text-white icon-cog"></span></a>
    </div>
</template>

<script>
import VColumn from './VColumn';

export default {

    props: {
        value: {},
        new: {
            type: Boolean,
            required: true
        },
        component: {
            required: true,
            type: String
        }
    },

    components: { VColumn },

    methods: {
        edit() {
            this.$store.dispatch('modal/open', {
                'component': this.component,
                params: { params: this.value }
            }).then(data => {
                this.$emit('input', data);
            }).catch(err => {
                    
            });
        }
    },

    mounted() {
        if (this.new) {
            this.$store.dispatch('modal/open', {
                'component': this.component,
                params: { params: this.value }
            }).then(data => {
                this.$emit('input', data);
                this.$emit('permanent');
            }).catch(err => {
                this.$emit('destroy');
            });
        }
    }
};
</script>
