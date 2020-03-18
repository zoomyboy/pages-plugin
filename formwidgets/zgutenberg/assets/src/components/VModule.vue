<template>
    <div class="bg-gray-800 rounded p-2 flex items-center">
        <div class="title w-full">
            <input type="text" v-model="value.name" class="leading-none bg-gray-800 outline-none text-center text-white w-full">
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
