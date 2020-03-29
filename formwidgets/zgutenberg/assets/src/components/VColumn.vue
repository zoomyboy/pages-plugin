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
                <a href="#" @click.prevent="$emit('edit', index)" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-cog"></span></a>
                <a href="#" @click.prevent="$emit('delete', index)" class="hover:zg-no-underline"><span class="zg-text-white icon-trash"></span></a>
            </div>

            <div class="zg-flex zg-justify-center zg-absolute zg--mt-3 zg-w-full">
                <a href="#" @click.prevent="$emit('create', index)" class="zg-btn zg-btn-sm zg-bg-module">
                    <span class="icon-plus"></span>
                </a>
            </div>

        </div>

        <div v-if="value.length === 0">
            <div class="zg-flex zg-justify-center zg--mt-3 zg-w-full">
                <a href="#" @click.prevent="$emit('create')" class="zg-btn zg-btn-sm zg-bg-module">
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
    }

};
</script>
