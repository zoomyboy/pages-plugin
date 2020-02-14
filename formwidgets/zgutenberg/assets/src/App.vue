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
        <input type="hidden" :name="name" :value="asString">
    </div>
</template>

<script>
import Zgcontent from './Zgcontent';
import Toolbar from './Toolbar';
import Sidebar from './Sidebar';

export default {
    props: {
        name: {},
        handlers: {}
    },
    components: { Zgcontent, Toolbar, Sidebar },
    computed: {
        asString() {
            return this.$store.getters.asString();
        }
    },
    mounted() {
        var self = this;

        this.$store.getters.formObj.request(this.handlers.init, {
            success: (data) => {
                self.$store.dispatch('getInit', {
                    data: data,
                    handlers: this.handlers
                });
            }
        });
    }
};
</script>



