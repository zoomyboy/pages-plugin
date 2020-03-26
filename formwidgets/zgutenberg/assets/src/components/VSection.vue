<template>
    <div class="zg-bg-gray-400 zg-shadow">

        <div class="zg-bg-section zg-flex zg-rounded zg-p-3 zg-items-center">
            <input type="text" v-model="value.title" class="zg-flex-grow zg-border-0 zg-leading-none zg-bg-section zg-outline-none zg-text-center zg-text-white zg-w-full">
            <a href="#" @click.prevent="$emit('remove')" class="hover:zg-no-underline"><span class="zg-text-white icon-trash"></span></a>
        </div>

        <div class="zg-p-4 zg-flex zg-flex-col" v-for="(row, index) in this.value.rows">
            <v-row v-model="row.data" :key="index" @remove="removeRow(index)"></v-row>
            <div class="zg-flex zg-justify-center">
                <a href="#" @click.prevent="addRow(index)" class="zg-btn zg-bg-row zg--mt-5">
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
                title: 'Zeile',
                layout: null,
            }).then(data => {
                var columns = data.layout.split(',').map(column => {
                    return {
                        width: column,
                        modules: []
                    };
                });

                var row = { data: {
                    title: data.title,
                    columns: columns
                } };

                var content = this.value;
                content.rows.splice(index+1, 0, row);
                this.$emit('input', content);
            });
        },
        removeRow(index) {
            if (this.value.rows.length === 1) {
                console.log('III');
                var content = this.value;
                content.rows[0].data.columns = content.rows[0].data.columns.map(column => {
                    return { ...column, modules: [] };
                });
                this.$emit('input', content);
                return;
            }

            var content = this.value;
            content.rows.splice(index, 1);
            this.$emit('input', content);
        }
    }
};
</script>
