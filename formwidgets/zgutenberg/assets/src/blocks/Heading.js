import { debounce } from 'lodash';
import BlockMixin from '../block.mixin.js';

const component = {
    mixins: [BlockMixin],
    render(createElement) {
        var self = this;
        return createElement(this.params.tag, {
            attrs: { contenteditable: 'true' },
            ref: 'input',
            class: [ 'c' ],
            on: {
                click(e) {
                    self.$emit('click');
                },
                keydown: (e) => {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        self.$store.dispatch('addBlock', {
                            component: 'paragraph',
                            params: {},
                            content: ''
                        });
                    }
                },
                blur: debounce(e => {
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
    },

    computed: {
        params: {
            set(v) {},
            get() { return this.$store.state.renderedBlocks[this.$vnode.key].params; }
        },
        content: {
            set(v) {},
            get() { return this.$store.state.renderedBlocks[this.$vnode.key].content; }
        }
    },
};

const render = function(createElement) {

};

const params = {
    icon: 'heading',
    is: 'heading',
    name: 'Überschrift',
    params: {
        tag: 'h2'
    },
    content: 'Überschrift'
};

export { component, render, params };
