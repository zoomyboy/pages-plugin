<template>
    <div class="zg-p-6">
        <div class="zg-relative zg-bg-gray-300"
            :class="{'zg-mt-6': index !== 0}"
            v-for="(row, index) in value"
            v-if="value.length !== 0" 
        >

            <div class="zg-bg-row zg-flex zg-rounded zg-p-3 zg-items-center">
                <input type="text" v-model="row.meta.title" class="zg-flex-grow zg-border-0 zg-leading-none zg-bg-row zg-outline-none zg-text-center zg-text-white zg-w-full">
                <a href="#" @click.prevent="editRow(row)" class="zg-mr-2 hover:zg-no-underline"><span class="zg-text-white icon-cog"></span></a>
                <a href="#" @click.prevent="remove(index)" class="hover:zg-no-underline"><span class="zg-text-white icon-trash"></span></a>
            </div>

            <v-row v-model="row.columns" :key="index"></v-row>

            <div class="zg-flex zg-justify-center zg-absolute zg--mt-3 zg-w-full">
                <a href="#" @click.prevent="addRow(index)" class="zg-btn zg-btn-sm zg-bg-row">
                    <span class="icon-plus"></span>
                </a>
            </div>

        </div>

    </div>
</template>

<script>
import VRow from './VRow';
import subform from '../subform.mixin.js';

export default {
    mixins: [ subform ],

    props: {
        value: {}
    },

    components: { VRow },

    methods: {
        addRow(index) {
            this.openForm('row', 'Zeile einfügen', {
                row: { title: 'Zeile' },
            }).then(formData => {
                var columns = formData.layout.split(',').map(column => {
                    return {
                        width: column,
                        modules: []
                    };
                });

                var newRow = {
                    meta: formData.row,
                    columns: columns
                };

                var content = this.value;
                content.splice(index+1, 0, newRow);
                this.$emit('input', content);
            });
        },
        editRow(row) {
            this.openForm('row_edit', 'Zeile bearbeiten', { row: row.meta }).then(formData => {
                row.meta = formData.row;
            });
        },
        remove(index) {
            if (this.value.length === 1) {
                var content = this.value;
                content[0].columns = content[0].columns.map(column => {
                    return { ...column, modules: [] };
                });
                this.$emit('input', content);
                return;
            }

            var content = this.value;
            content.splice(index, 1);
            this.$emit('input', content);
        },
    }
};
</script>
