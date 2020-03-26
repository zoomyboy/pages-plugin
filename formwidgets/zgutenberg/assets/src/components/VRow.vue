<template>
    <div class="zg-bg-gray-300 zg-shadow">

        <div class="zg-bg-row zg-flex zg-rounded zg-p-3 zg-items-center">
            <input type="text" v-model="value.title" class="zg-flex-grow zg-border-0 zg-leading-none zg-bg-row zg-outline-none zg-text-center zg-text-white zg-w-full">
            <a href="#" @click.prevent="$emit('remove')" class="hover:zg-no-underline"><span class="zg-text-white icon-trash"></span></a>
        </div>

        <div class="zg-p-4 zg-flex zg--mx-4">
            <div class="zg-p-4" :key="index" v-for="(column, index) in this.value.columns" :class="'zg-w-'+column.width">
                <v-column v-model="column.modules"></v-column>
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

    components: { VColumn }

};
</script>
