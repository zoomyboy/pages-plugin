<template>
    <div v-if="value" class="zg-top-full zg-absolute zg-top-0 zg-left-0 zg-bg-white zg-shadow-lg zg-rounded-sm addblock" :class="{'zg-hidden': value == false, 'zg-block': value == true}">
        <div class="zg-flex zg-flex-wrap zg--mx-1">
            <div v-for="(block, c) in blocks" class="zg-px-1">
                <a href="#" @click="addBlock(block, c)" class="block-item zg-p-2 zg-bg-gray-200 zg-p-2 zg-flex zg-flex-col">
                    <span :class="'fa fa-lg fa-'+block.icon"></span>
                    <span v-html="block.name"></span>
                </a>
            </div>
        </div>
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
    },
    data: function() {
        return {
            dropdown: false
        };
    },
    methods: {
        addBlock(v, componentName) {
            this.$store.commit('addBlock', {
                component: componentName,
                params: v.params,
                content: v.content
            });
            this.$emit('input', false);
        }
    }
};
</script>

<style scoped>
.addblock {
    width: 400px;
    top: 100%;
    border: 1px #eee solid;
    border-radius: 3px;
    padding: 20px;
}

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
