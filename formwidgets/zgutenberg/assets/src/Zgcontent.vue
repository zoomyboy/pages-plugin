<template>
    <div class="zg-content">
        <div v-if="value.length != 0">
            <v-section v-for="(section, index) in value" v-odel="section" :key="index" @click="select(index)"></v-section>
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
        addSection(index) {
            if (typeof index == "undefined") {
                this.$emit('input', [ { type: 'section', children: [] } ]);
                return;
            }

            var content = this.value;
            content.splice(index, 0, { type: 'section', children: [] });
            this.$emit('input', content);
        }
    }
};
</script>
