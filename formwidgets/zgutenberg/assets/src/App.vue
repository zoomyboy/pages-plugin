<template>
    <div class="wrapper" style="min-height: 20vh;">
        <toolbar></toolbar>

        <div class="zg-flex">
            <div class="zg-flex-grow zg-p-6">
                <zgcontent v-model="content"></zgcontent>
            </div>
            <div class="zg-w-sidebar zg-border-l zg-bg-white" v-show="$store.state.sidebar">
                <sidebar></sidebar>
            </div>
        </div>
        <input type="hidden" :name="name" :value="asString">
        <div class="zg-content">
            <modals></modals>
        </div>
    </div>
</template>

<script>
import Zgcontent from './Zgcontent';
import Toolbar from './Toolbar';
import Sidebar from './Sidebar';
import Modals from './components/Modals.vue';

export default {
    data: function() {
        return {
            content: []
        };
    },
    props: {
        name: {},
        handlers: {}
    },
    components: { Zgcontent, Toolbar, Sidebar, Modals },
    computed: {
        asString() {
            return JSON.stringify(this.content);
        }
    },
    mounted() {
        var self = this;

        this.$store.getters.formObj.request(this.handlers.init, {
            success: (data) => {
                this.content = data;
                self.$store.dispatch('getInit', {
                    handlers: this.handlers
                });
            }
        });
    }
};
</script>



