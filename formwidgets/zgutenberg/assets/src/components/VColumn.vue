<template>
    <div>
        <div v-if="value.length != 0">
            <div v-for="(module, index) in value">
                <v-module v-model="module.data" :key="index" @click="select(index)" @remove="remove(index)" :new="module.new" :component="module.component" @permanent="permanent(module)"></v-module>
            </div>
        </div>
        <div class="zg-flex zg-justify-center" v-else>
            <a href="#" @click.prevent="addModule()" class="zg-btn zg-bg-gray-800">
                <span class="icon-plus"></span>
            </a>
        </div>
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
