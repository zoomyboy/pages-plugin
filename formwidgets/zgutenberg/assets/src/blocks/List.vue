<template>
    <ul ref="input" class="c" @click="$emit('click')">
        <editable tag="li" @void="deletePoint(key)" :key="key" v-for="(point, key) in innerContent" @input="updateContent" :value="point.content" @enter="onEnter"></editable>
    </ul>
</template>

<script>
import { debounce } from 'lodash';
import BlockMixin from '../block.mixin.js';
import StripMixin from '../strip.mixin.js';

export default {

    props: {},

    computed: {
        params() {
            return typeof this.$store.getters.block(this.$vnode.key) === 'undefined' ? {} : this.$store.getters.block(this.$vnode.key).params;
        },
        innerContent() {
            return typeof this.$store.getters.block(this.$vnode.key) === 'undefined' ? [] : this.$store.getters.block(this.$vnode.key).content;
        }
    },

    mixins: [BlockMixin, StripMixin],

    methods: {
        onEnter(content, key) {
            var self = this;

            this.$store.commit('addBlockIndex', {
                id: this.$vnode.key,
                index: key + 1,
                value: {content: ''}
            });

            this.$nextTick(function() {
                self.$el.children[key+1].focus();
            });
        },
        onFocus() {
            
        },
        updateContent(content, key) {
            this.$store.commit('updateBlockIndex', {
                id: this.$vnode.key,
                index: key,
                value: {'content': content}
            });
        },
        deletePoint(index) {
            var self = this;

            if (index == this.innerContent.length - 1) {
                var nextFocus = index - 1;
            } else if (this.innerContent.length > 1) {
                var nextFocus = index;
            }

            if (this.innerContent.length == 1) {
                // delete the whole component
                this.$store.commit('destroyBlock', this.$vnode.key);
                return;
            }

            this.$store.commit('destroyBlockIndex', {
                id: this.$vnode.key,
                index: index
            });

            this.$nextTick(function() {
                self.$el.children[nextFocus].focus();
            });
        }
    }
};

const render = function(createElement) {

};

const params = {
    icon: 'list',
    is: 'list',
    name: 'List',
    params: {},
    content: [{content: ''}]
};

export { render, params };
</script>
