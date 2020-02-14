import { debounce } from 'lodash';
import BlockMixin from '../block.mixin.js';
import StripMixin from '../strip.mixin.js';

const component = {
    mixins: [ BlockMixin, StripMixin ],

    computed: {
        params() {
            return typeof this.$store.getters.block(this.$vnode.key) === 'undefined' ? {} : this.$store.getters.block(this.$vnode.key).params;
        },
        content() {
            return typeof this.$store.getters.block(this.$vnode.key) === 'undefined' ? '' : this.$store.getters.block(this.$vnode.key).content;
        }
    },

    render(createElement) {
        var self = this;
        return createElement('p', {
            attrs: { contenteditable: 'true' },
            ref: 'input',
            class: [ 'c' ],
            on: {
                keydown: (e) => {
                    if (e.keyCode == 13 && !e.shiftKey) {
                        e.preventDefault();
                        document.activeElement.blur();
                        self.$store.dispatch('addBlock', {
                            ...self.$store.getters.block(self.$vnode.key),
                            content: ''
                        });

                        return;
                    }
                    
                    // Delete paragraph if backspace is pressed
                    if (event.target.innerHTML == '' && e.keyCode == 8) {
                        this.$store.commit('destroyBlock', this.$vnode.key);
                        return;
                    }
                },
                paste(e) {
                    document.activeElement.blur();
                    self.$store.commit('updateBlock', {
                        id: self.$vnode.key,
                        params: self.params,
                        content: self.s(e.clipboardData.getData('text'))
                    });
                },
                blur: debounce(e => {
                    console.log(e.target.innerHTML);
                    self.$store.commit('updateBlock', {
                        id: self.$vnode.key,
                        params: self.params,
                        content: e.target.innerHTML
                    });
                }, 300)
            },
            style: {
                outline: 'none'
            },
            domProps: {
                innerHTML: this.content
            }
        }, []);
    },

    methods: {
        onFocus() {
            this.$refs.input.focus();
        }
    }

};

const render = function(createElement) {

};

const params = {
    icon: 'paragraph',
    is: 'paragraph',
    name: 'Absatz',
    params: {},
    content: ''
};

export { component, render, params };
