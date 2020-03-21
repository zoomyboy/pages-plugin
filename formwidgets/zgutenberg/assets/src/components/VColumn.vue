<template>
    <div class="zg-flex zg-flex-col zg-items-center">
        <v-module v-model="module.data" :key="index" @click="select(index)" @remove="remove(index)" :new="module.new" :component="module.component" @permanent="permanent(module)" v-for="(module, index) in value" :class="{'zg-mt-1': index != 0}"></v-module>
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
        addModule() {
            this.$store.dispatch('modal/open', {
                'component': 'selectblock'
            }).then(({ block, c }) => {
                var content = this.value;
                content.push({ data: block, new: true, component: c });
                this.$emit('input', content);
            }).catch(err => {
            });
        },
        remove(index) {
            this.value.splice(index, 1);
        }
    },

    mounted() {
    }
};
</script>
