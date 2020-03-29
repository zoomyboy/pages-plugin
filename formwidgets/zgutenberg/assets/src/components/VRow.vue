<template>
    <div class="zg-p-4 zg-flex zg--mx-4">

        <div class="zg-p-4" :key="index" v-for="(column, index) in this.value" :class="'zg-w-'+column.width">
            <v-column v-model="column.modules" @create="createModule(index, $event)" @edit="editModule(index, $event)" @delete="deleteModule(index, $event)"></v-column>
        </div>

    </div>
</template>

<script>
import VColumn from './VColumn';
import subform from '../subform.mixin.js';

export default {

    mixins: [ subform ],

    props: {
        value: {}
    },

    methods: {
        createModule(index, moduleIndex) {
            var modules = this.value[index].modules;

            this.openForm('module', 'Modul einfügen', {}).then(formData => {
                var formData = { ...formData.data };
                this.openForm(formData.is, formData.meta.title, formData.meta).then(moduleData => {
                    formData.meta = moduleData;

                    modules.splice(moduleIndex+1, 0, formData);
                }).catch(err => {
                    console.log(err);
                });
            }).catch(err => {
                console.log(err);
            });
        },
        editModule(index, moduleIndex) {
            var module = this.value[index].modules[moduleIndex];
            this.openForm(module.is, module.meta.title, module.meta).then(moduleData => {
                module.meta = moduleData;
            }).catch(err => {
                console.log(err);
            });
        },
        deleteModule(index, moduleIndex) {
            this.value[index].modules.splice(moduleIndex, 1);
        }
    },

    components: { VColumn }

};
</script>
