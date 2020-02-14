<template>
    <ul ref="input" class="c">
        <li :key="key" v-on:keydown.enter="addElement(key, $event)" v-for="(point, key) in innerContent" contenteditable="true" v-html="point.content" @blur="updateContent(key, $event)" @keydown.backspace="onDeleteChar($event, key)" @paste="onPaste($event, key)"></li>
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
        addElement(index, event) {
            var self = this;
            event.preventDefault();

            this.$store.commit('addBlockIndex', {
                id: this.$vnode.key,
                index: index+1,
                value: {content: ''}
            });

            this.$nextTick(function() {
                self.$el.children[index+1].focus();
            });
        },
        onPaste(e, key) {
            var self = this;
            document.activeElement.blur();
            this.$store.commit('updateBlockIndex', {
                id: this.$vnode.key,
                index: key,
                value: {'content': this.s(e.clipboardData.getData('text').replace("\n", ""))}
            });
        },
        onFocus() {
            this.$refs.input.firstChild.focus();
        },
        updateContent(key, event) {
            this.$store.commit('updateBlockIndex', {
                id: this.$vnode.key,
                index: key,
                value: {'content': event.target.innerHTML}
            });
        },
        onDeleteChar(event, index) {
            if (event.target.innerHTML == '') {
                event.preventDefault();
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
