<template>
    <div class="zg-content">
        <component v-for="(block, index) in $store.state.renderedBlocks" :is="block.is" :key="index" :class="classes(block, index)" class="zg-component" @click="select(index)"></component>
    </div>
</template>

<script>
export default {
    methods: {
        select(index) {
            this.$store.commit('select', index);
        },
        classes(block, index) {
            return {
                'selected': this.$store.state.selected === index
            };
        }
    }
};
</script>
