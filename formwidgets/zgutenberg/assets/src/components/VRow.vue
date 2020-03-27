<template>
    <div class="zg-p-4 zg-flex zg--mx-4">

        <div class="zg-p-4" :key="index" v-for="(column, index) in this.value" :class="'zg-w-'+column.width">
            <v-column v-model="column.modules"></v-column>
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
