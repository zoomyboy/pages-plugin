<template>
    <ul ref="input" class="c">
        <li :key="key" v-on:keydown.enter="addElement(key, $event)" v-for="(point, key) in innerContent" contenteditable="true" v-html="point.content" @blur="updateContent(key, $event)" @keydown.backspace="onDeleteChar($event, key)"></li>
    </ul>
</template>

<script>
import { debounce } from 'lodash';
import BlockMixin from '../block.mixin.js';

export default {
    data: function() {
        return {
            innerContent: []
        };
    },

    props: {
        params: {},
        content: {}
    },

    mixins: [BlockMixin],

    methods: {
        addElement(index, event) {
            var self = this;
            event.preventDefault();

            this.innerContent.splice(index+1, 0, {content: ''});
            this.$nextTick(function() {
                self.$el.children[index+1].focus();
            });

            this.$store.commit('updateBlock', {
                id: this.$vnode.key,
                params: this.params,
                content: this.innerContent
            });
        },
        onFocus() {
            this.$refs.input.firstChild.focus();
        },
        updateContent(key, event) {
            if (typeof this.innerContent[key] == 'undefined') { return false; }
            this.innerContent[key].content = event.target.innerHTML;
            this.$store.commit('updateBlock', {
                id: this.$vnode.key,
                params: this.params,
                content: this.innerContent
            });
        },
        onDeleteChar(event, index) {
            if (event.target.innerHTML == '') {
                event.preventDefault();
                console.log(event.target.innerHTML);
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

                this.innerContent.splice(index, 1);
                this.$nextTick(function() {
                    self.$el.children[nextFocus].focus();
                });

                this.$store.commit('updateBlock', {
                    id: this.$vnode.key,
                    params: this.params,
                    content: this.innerContent
                });
            }
        }
    },
    created() {
        this.innerContent = this.content;
    }
};

const render = function(createElement) {

};

const params = {
    icon: 'list',
    name: 'List',
    params: {},
    content: [{content: ''}]
};

export { render, params };
</script>
