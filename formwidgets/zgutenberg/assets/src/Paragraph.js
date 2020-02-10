import { debounce } from 'lodash';

export default {
    props: {
        params: {
            default: function() {
                return {
                    tag: 'h2'
                };
            }
        }
    },
    render(createElement) {
        return createElement('div', { class: 'content' }, [
            createElement(this.params.tag, {
                attrs: { contenteditable: 'true' },
                on: {
                    input: debounce((e) => {
                        this.$store.commit('updateBlock', {
                            id: this.$vnode.key,
                            params: this.params,
                            content: e.target.innerHTML
                        });
                    }, 300)
                },
                style: {
                    outline: 'none'
                },
            }, 'Überschrift')
        ]);
    },
    mounted() {
        this.$el.focus();
    }
};

