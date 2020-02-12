<template>
    <div class="wrapper" style="min-height: 20vh;">
        <toolbar></toolbar>

        <div class="zg-flex">
            <div class="zg-flex-grow zg-px-3 zg-py-6">
                <zgcontent></zgcontent>
            </div>
            <div class="zg-w-sidebar zg-border-l zg-bg-white" v-show="$store.state.sidebar">
                <sidebar></sidebar>
            </div>
        </div>
        <output></output>
        <input type="hidden" :name="name" :value="asString">
    </div>
</template>

<script>
import Zgcontent from './Zgcontent';
import Toolbar from './Toolbar';
import Sidebar from './Sidebar';
import Output from './Output.vue';

export default {
    props: {
        name: {},
        handlers: {}
    },
    components: { Zgcontent, Toolbar, Sidebar, Output },
    computed: {
        asString() {
            return this.$store.getters.asString();
        }
    },
    mounted() {
        var self = this;
        var $form = window.jQuery(this.$el).closest('form');
        var formId = Math.random().toString(36).substring(7) + Math.random().toString(36).substring(7);
        $form.attr('id', formId);

        $form.request(this.handlers.init, {
            success: (data) => {
                self.$store.commit('init', {
                    data: data,
                    handlers: this.handlers,
                    form: formId
                });
            }
        });
    }
};
</script>



