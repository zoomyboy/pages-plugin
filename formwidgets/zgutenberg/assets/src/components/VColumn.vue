<template>
    <div>
        <div v-if="value.length != 0">
            <div v-for="(module, index) in value">
                <v-module v-model="module.data" :key="index" @click="select(index)" @destroy="destroy(index)"></v-module>
            </div>
        </div>
        <div class="flex justify-center" v-else>
            <a href="#" @click.prevent="addModule()" class="rounded-full flex justify-center items-center w-12 h-12 block bg-gray-800 text-white">
                <span class="fa fa-plus fa-xs"></span>
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
        addModule() {
            this.$store.dispatch('modal/open', {
                'component': 'selectblock'
            }).then(module => {
                var content = this.value;
                content.push({ data: module });
                this.$emit('input', content);
            }).catch(err => {
            });
        }
    },

    mounted() {
    }
};
</script>
