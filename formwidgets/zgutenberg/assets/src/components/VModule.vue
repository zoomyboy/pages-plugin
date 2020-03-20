<template>
    <div class="zg-bg-gray-800 zg-rounded zg-p-2 zg-flex zg-items-center">
        <div class="title w-full">
            <input type="text" v-model="value.name" class="zg-leading-none zg-bg-gray-800 zg-outline-none zg-text-center zg-text-white zg-w-full zg-border-0">
        </div>
    </div>
</template>

<script>
import VColumn from './VColumn';

export default {

    props: {
        value: {}
    },

    components: { VColumn },

    mounted() {
        if (this.value.columns.length == 0) {
            this.$store.dispatch('modal/open', {
                'component': 'selectrow'
            }).then(data => {
                this.value.columns = data.map(column => {
                    return {
                        width: column,
                        modules: []
                    };
                });
            }).catch(err => {
                console.log(err);
                this.$emit('destroy');
            });
        }
    }
};
</script>
