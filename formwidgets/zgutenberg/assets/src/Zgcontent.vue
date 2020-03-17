<template>
    <div class="zg-content">
        <div v-if="value.length != 0">
            <div v-for="(section, index) in value">
                <v-section v-model="section.data" :key="index" @click="select(index)" @destroy="destroy(index)"></v-section>
            </div>
        </div>
        <div class="flex justify-center" v-else>
            <a href="#" @click.prevent="addSection()" class="rounded-full flex justify-center items-center w-12 h-12 block bg-section text-white">
                <span class="fa fa-plus fa-xs"></span>
            </a>
        </div>
    </div>
</template>

<script>
import VSection from './components/VSection';
export default {
    props: {
        value: {}
    },

    components: { VSection },

    methods: {
        destroy(index) {
            var content = this.value;
            content.splice(index, 1);
            this.$emit('input', content);
        },
        addSection(index) {
            if (typeof index == "undefined") {
                this.$emit('input', [ { type: 'section', data: { children: [] } } ]);
                return;
            }

            var content = this.value;
            content.splice(index, 0, { type: 'section', data: { children: [] } });
            this.$emit('input', content);
        }
    }
};
</script>
