<template>
    <div></div>
</template>

<script>
import BlockMixin from '../block.mixin.js';
import StripMixin from '../strip.mixin.js';

export default {

    props: {
        value: {}
    },

    mounted() {
        this.$emit('confirm', this.value);
    }

};

const params = {
    icon: 'header',
    name: 'Seitentitel',
    params: {}
};

export { params };
</script>

