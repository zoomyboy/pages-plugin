<template>
    <div class="zg-content">
        <component v-for="(block, c) in $store.state.renderedBlocks" :is="block.is" :key="c"></component>
    </div>
</template>

