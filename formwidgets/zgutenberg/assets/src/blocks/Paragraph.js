import { debounce } from 'lodash';
import BlockMixin from '../block.mixin.js';

const component = {
    mixins: [ BlockMixin ],

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

    render(createElement) {
        var self = this;
        return createElement('p', {
            attrs: { contenteditable: 'true' },
            ref: 'input',
            class: [ 'c' ],
            on: {
                keydown: (e) => {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        self.$store.commit('addBlock', {
                            component: 'paragraph',
                            params: {tag: 'p'},
                            content: ''
                        });
                    }
                },
                input: debounce(e => {
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
        }, this.content);
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
    name: 'Absatz',
    params: {},
    content: ''
};

export { component, render, params };
