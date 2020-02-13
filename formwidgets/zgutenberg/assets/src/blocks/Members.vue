<template>
    <div v-html="content"></div>
</template>

<script>
import { debounce } from 'lodash';
import BlockMixin from '../block.mixin.js';

export default {

    data: function() {
        return {
            content: ''
        };
    },

    computed: {
        params() {
            return typeof this.$store.getters.block(this.$vnode.key) === 'undefined' ? {} : this.$store.getters.block(this.$vnode.key).params;
        }
    },

    mixins: [BlockMixin],

    watch: {
        params(newValue) {
            this.$store.getters.formObj.request('onUpdateComponent', {
                data: { component: 'members', params: newValue },
                success: (data) => {
                    this.content = data;
                }
            });
        }
    },

    methods: {
        onFocus() {}
    }
};

const render = function(createElement) {

};

const params = {
    icon: 'users',
    name: 'Mitglieder',
    loadParams: 'members'
};

export { render, params };
</script>
