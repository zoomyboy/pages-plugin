<template>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" @click="$emit('close')" class="close">×</button>
            <h4 class="modal-title">Modul einfügen</h4>
        </div>
        <div class="modal-body">
            <div class="zg-flex zg-flex-wrap zg--mx-2">
                <div class="zg-px-2 zg-w-1/3 zg-mb-4" v-for="(block, c) in blocks" :key="c">
                    <button type="button" class="w-full btn btn-primary btn-lg px-2" @click.prevent="$emit('confirm', { block: block, c: c })">
                        <span :class="'icon-'+block.icon"></span>
                        <span v-html="block.name"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="modal-footer"></div>
    </div>

</template>

<script>
export default {
    props: {
        value: {}
    },
    computed: {
        blocks() {
            return this.$store.state.blocks;
        }
    }
};
</script>

<style scoped>
.block-item {
    width: 80px;
    height: 80px;
    display: flex;
    flex-direction: column;
    color: #666666;
    justify-content: space-around;
    align-items: center;
}
</style>
