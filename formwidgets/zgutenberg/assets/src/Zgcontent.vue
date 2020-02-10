<template>
    <div class="zg-content">
        <component v-for="(block, c) in $store.state.renderedBlocks" :is="block.component" :params="block.params" :content="block.content" :key="c"></component>
    </div>
</template>

