<template>
    <editable :tag="params.tag" @void="onVoid" @click="select" class="c" @input="updateContent" :value="content" @enter="onEnter"></editable>
</template>

<script>
import BlockMixin from '../block.mixin.js';
import StripMixin from '../strip.mixin.js';

export default {
    props: {},

    computed: {
        params() {
            return  this.$store.getters.block(this.$vnode.key).params;
        },
        content() {
            return this.$store.getters.block(this.$vnode.key).content;
        }
    },

    mixins: [ BlockMixin, StripMixin ],

    methods: {
        updateContent(content, key) {
            this.$store.commit('updateBlock', {
                id: this.$vnode.key,
                params: this.params,
                content: content
            });
        },
        select() {
            this.$emit('click');
        },
        onEnter(content, key) {
            var self = this;

            this.$store.dispatch('addBlock', {
                ...self.$store.getters.block(self.$vnode.key),
                content: '',
                after: this.$vnode.key
            });
        },
        onVoid() {
            console.log('AAA');
            this.$store.commit('destroyBlock', this.$vnode.key);
        },
        onFocus() {
            this.$el.focus();
        }
    }
};

const render = function(createElement) {

};

const params = {
    icon: 'header',
    is: 'paragraph',
    name: 'Absatz',
    params: {},
    content: ''
};

export { render, params };
</script>
