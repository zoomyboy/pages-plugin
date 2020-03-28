<template>
    <div>
        <div class="zg-relative"
            :class="{'zg-mt-6': index !== 0}"
            v-for="(module, index) in value"
            v-if="value.length !== 0" 
        >

            <div class="zg-bg-module zg-flex zg-rounded zg-p-3 zg-items-center">
                <span class="zg-text-gray-600" :class="'icon-'+module.is.icon"></span>
                <input type="text" v-model="module.meta.title" class="zg-flex-grow zg-border-0 zg-leading-none zg-bg-module zg-outline-none zg-text-center zg-text-white zg-w-full">
                <a href="#" @click.prevent="remove(index)" class="hover:zg-no-underline"><span class="zg-text-white icon-trash"></span></a>
            </div>

            <div class="zg-flex zg-justify-center zg-absolute zg-bottom-0 zg--mt-3 zg-w-full">
                <a href="#" @click.prevent="addModule(index)" class="zg-btn zg-btn-sm zg-bg-module">
                    <span class="icon-plus"></span>
                </a>
            </div>

        </div>

        <div v-if="value.length === 0">
            <div class="zg-flex zg-justify-center zg-bottom-0 zg--mt-3 zg-w-full">
                <a href="#" @click.prevent="addModule" class="zg-btn zg-btn-sm zg-bg-module">
                    <span class="icon-plus"></span>
                </a>
            </div>
        </div>

    </div>
</template>

<script>
import subform from '../subform.mixin.js';

export default {

    mixins: [ subform ],

    props: {
        value: {}
    },

    methods: {
        async addModule(index) {
            this.openForm('module', 'Modul einfügen', {}).then(formData => {
                var formData = { ...formData.data };
                this.openForm(formData.is, formData.meta.title, formData.meta).then(moduleData => {
                    formData.meta = moduleData;

                    var content = this.value;
                    content.splice(index+1, 0, formData);
                    this.$emit('input', content);
                }).catch(err => {
                    console.log(err);
                });
            }).catch(err => {
                console.log(err);
            });
        },
        remove(index) {
            this.value.splice(index, 1);
        }
    }
};
</script>
