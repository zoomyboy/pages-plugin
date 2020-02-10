import { debounce } from 'lodash';
import BlockMixin from '../block.mixin.js';

const component = {
    props: {
        params: {},
        content: {}
    },
    mixins: [BlockMixin],
    render(createElement) {
        var self = this;
        return createElement(this.params.tag, {
            attrs: { contenteditable: 'true' },
            ref: 'input',
            class: [ 'c' ],
            on: {
                keydown: (e) => {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        self.$store.commit('addBlock', {
                            component: 'paragraph',
                            params: {},
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
    icon: 'heading',
    name: 'Überschrift',
    params: {
        tag: 'h2'
    },
    content: 'Überschrift'
};

export { component, render, params };
