<template>
    <div class="zg-content zg-px-6">
        <div class="zg-relative zg-bg-gray-400 zg-shadow"
            :class="{'zg-mt-6': index !== 0}"
            v-for="(section, index) in value"
            v-if="value.length !== 0" 
        >

            <div class="zg-bg-section zg-flex zg-rounded zg-p-3 zg-items-center">
                <input type="text" v-model="section.meta.title" class="zg-flex-grow zg-border-0 zg-leading-none zg-bg-section zg-outline-none zg-text-center zg-text-white zg-w-full">
                <a href="#" @click.prevent="edit(section, index)" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-cog"></span></a>
                <a href="#" @click.prevent="remove(index)" class="hover:zg-no-underline"><span class="zg-text-white icon-trash"></span></a>
            </div>

            <v-section v-model="section.rows" :key="index"></v-section>

            <div class="zg-flex zg-justify-center zg-absolute zg-bottom-0 zg--mt-3 zg-w-full">
                <a href="#" @click.prevent="addSection(index)" class="zg-btn zg-btn-sm zg-bg-section">
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
                section: { title: 'Sektion' },
                row: { title: 'Zeile' },
            }).then(formData => {
                var columns = formData.layout.split(',').map(column => {
                    return {
                        width: column,
                        modules: []
                    };
                });

                var newSection = { 
                    meta: formData.section,
                    rows: [ {
                        meta: formData.row,
                        columns: columns
                    } ]
                };

                if (typeof index == "undefined") {
                    this.$emit('input', [ newSection ]);
                    return;
                }

                var content = this.value;
                content.splice(index+1, 0, newSection);
                this.$emit('input', content);
            });
        }
    }
};
</script>
