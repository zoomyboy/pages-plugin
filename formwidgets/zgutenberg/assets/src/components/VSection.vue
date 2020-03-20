<template>
    <div class="zg-bg-sektion zg-bg-gray-200">

        <div class="zg-bg-section zg-flex zg-rounded zg-p-3 zg-items-center">
            <div class="actions zg-w-1/4"></div>
            <div class="title zg-w-2/4">
                <input type="text" v-model="value.title" class="zg-border-0 zg-leading-none zg-bg-section zg-outline-none zg-text-center zg-text-white zg-w-full">
            </div>
            <div class="dropdown w-1/4">
                
            </div>
        </div>

        <div class="zg-p-4 zg-flex zg--mx-4">
            <div class="zg-p-4" :key="index" v-for="(column, index) in this.value.columns" :class="'zg-w-'+column.width">
                <v-column v-model="column.modules" @click="select(index)"></v-column>
            </div>
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
