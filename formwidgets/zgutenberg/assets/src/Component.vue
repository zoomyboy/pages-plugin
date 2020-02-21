<template>
    <div v-html="content" @click="select"></div>
</template>

<script>
import { debounce } from 'lodash';
import BlockMixin from './block.mixin.js';

export default {

    props: {
        block: {}
    },

    data: function() {
        return {
            content: ''
        };
    },

    mixins: [BlockMixin],

    computed: {
        params() {
            return typeof this.$store.getters.block(this.$vnode.key) === 'undefined' ? {} : this.$store.getters.block(this.$vnode.key).params;
        }
    },

    watch: {
        params(newValue) {
            this.render();
        }
    },

    methods: {
        select() {
            this.$store.commit('select', this.$vnode.key);
        },
        onFocus() {},
        render() {
            if (Object.keys(this.params).map(param => this.params[param]).some(param => param.value === null && param.required === true)) {
                this.content = 'Bitte alle Parameter definieren';
                return;
            }

            this.$store.getters.formObj.request('onUpdateComponent', {
                data: { component: this.block.component, params: this.params },
                success: (data) => {
                    this.content = data;
                }
            });
        }
    },

    mounted() {
        this.render();
    }

};
</script>
