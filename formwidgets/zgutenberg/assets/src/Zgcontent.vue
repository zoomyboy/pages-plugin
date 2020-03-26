<template>
    <div class="zg-content">
        <div v-for="(section, index) in value" :class="{'zg-mt-6': index !== 0}" class="zg-relative zg-bg-gray-400 zg-shadow" v-if="value.length !== 0">

            <div class="zg-bg-section zg-flex zg-rounded zg-p-3 zg-items-center">
                <input type="text" v-model="section.meta.title" class="zg-flex-grow zg-border-0 zg-leading-none zg-bg-section zg-outline-none zg-text-center zg-text-white zg-w-full">
                <a href="#" @click.prevent="edit(section, index)" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-cog"></span></a>
                <a href="#" @click.prevent="remove(index)" class="hover:zg-no-underline"><span class="zg-text-white icon-trash"></span></a>
            </div>

            <v-section v-model="section.rows" :key="index"></v-section>

            <div class="zg-flex zg-justify-center zg-absolute zg-bottom-0 zg--mt-5 zg-w-full">
                <a href="#" @click.prevent="addSection(index)" class="zg-btn zg-bg-section">
                    <span class="icon-plus"></span>
                </a>
            </div>

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
        edit(section, index) {
            this.openForm('section_edit', 'Sektion bearbeiten', section.meta).then(data => {
                section.meta = { ...section.meta, ...data };
            });
        },
        addSection(index) {
            this.openForm('section', 'Sektion einfügen', {
                title: 'Sektion',
                type: 'section'
            }).then(data => {
                var columns = data.layout.split(',').map(column => {
                    return {
                        width: column,
                        modules: []
                    };
                });

                var data = { 
                    meta: data,
                    rows: [{ data: { title: 'Zeile', columns: columns} }]
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
