<template>
    <div class="zg-content">
        <div v-if="value.length != 0">
            <div v-for="(section, index) in value" :class="{'zg-mt-6': index !== 0}">
                <v-section v-model="section.data" :key="index" @click="select(index)" @remove="remove(index)"></v-section>
                <div class="zg-flex zg-justify-center">
                    <a href="#" @click.prevent="addSection(index)" class="zg-btn zg-bg-section zg--mt-5">
                        <span class="icon-plus"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="zg-flex zg-justify-center" v-else>
            <a href="#" @click.prevent="addSection()" class="zg-btn zg-bg-section">
                <span class="icon-plus"></span>
            </a>
        </div>
    </div>
</template>

<script>
import VSection from './components/VSection';
import subform from './subform.mixin.js';

export default {
    mixins: [ subform ],

    props: {
        value: {}
    },

    components: { VSection },

    methods: {
        remove(index) {
            var content = this.value;
            content.splice(index, 1);
            this.$emit('input', content);
        },
        addSection(index) {
            this.openForm('section', 'Sektion einfügen', {
                title: 'Sektion',
                layout: null,
                background: null,
                type: 'section'
            }).then(data => {
                var columns = data.layout.split(',').map(column => {
                    return {
                        width: column,
                        modules: []
                    };
                });

                var data = { 
                    type: data.type,
                    data: { columns: columns, title: data.title, background: data.background }
                };

                if (typeof index == "undefined") {
                    this.$emit('input', [ data ]);
                    return;
                }

                var content = this.value;
                content.splice(index+1, 0, data);
                this.$emit('input', content);
            });
        }
    }
};
</script>
