<template>
    <div class="zg-flex zg-flex-col zg-items-center">
        <v-module v-model="module.data" :key="index" @click="select(index)" @remove="remove(index)" @permanent="permanent(module)" v-for="(module, index) in value" :class="{'zg-mt-1': index != 0}"></v-module>
        <a href="#" @click.prevent="addModule()" class="zg-btn zg-bg-gray-800" :class="{'zg-mt-1': value.length != 0}">
            <span class="icon-plus"></span>
        </a>
    </div>
</template>

<script>
import VModule from './VModule';

export default {

    props: {
        value: {}
    },

    components: { VModule },

    methods: {
        permanent(module) {
            module.new = false;
        },
        async addModule() {
            var params = await this.$store.dispatch('modal/open', {
                'component': 'selectblock'
            });

            if (params.block.is == 'comp') {
                var componentParams = this.$store.state.blocks[params.c].params;
                var innerValues = {};
                for (const key in componentParams) {
                    innerValues[key] = componentParams[key].value;
                }
            }

            var content = this.value;
            content.push({ data: {
                ...{ ...params.block, params: innerValues },
                new: true,
                component: params.c
            }});

            this.$emit('input', content);
        },
        remove(index) {
            this.value.splice(index, 1);
        }
    }
};
</script>
