<template>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" @click="$emit('close')" class="close">×</button>
            <h4 class="modal-title">Modul einfügen</h4>
        </div>
        <div class="modal-body">
            <div class="flex flex-wrap -mx-3">
                <div class="p-3 w-1/3 mb-6" v-for="(block, c) in blocks" :key="c">
                    <a href="#" @click.prevent="$emit('confirm', block)" class="block-item zg-p-2 zg-bg-gray-200 zg-p-2 zg-flex zg-flex-col">
                        <span :class="'fa fa-lg fa-'+block.icon"></span>
                        <span v-html="block.name"></span>
                    </a>
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
