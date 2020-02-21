import StripMixin from './strip.mixin.js';

export default {
    mixins: [ StripMixin ],

    props: {
        tag: {
            type: String
        },
        value: {

        }
    },

    render(createElement) {
        var self = this;

        return createElement(this.tag, {
            attrs: {
                contenteditable: 'true'
            },
            domProps: {
                innerHTML: this.value
            },
            ref: 'input',
            on: {
                click() {
                    self.$emit('click');
                },
                blur(e) {
                    self.$emit('input', e.target.innerHTML, self.$vnode.key);
                },
                keydown(e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        e.target.blur();
                        self.$emit('enter', e.target.innerHTML, self.$vnode.key);
                    }

                    if (e.keyCode == 8 && e.target.innerHTML === '') {
                        e.preventDefault();
                        e.target.blur();
                        self.$emit('void');
                    }
                },
                paste(e) {
                    e.preventDefault();

                    var selection = window.getSelection();

                    var range = selection.getRangeAt(0);
                    var before = e.target.innerHTML.substr(0, range.startOffset);
                    var after = e.target.innerHTML.substr(range.endOffset);

                    var inserted = before + self.s(e.clipboardData.getData('text').replace("\n", ""));
                    e.target.innerHTML = inserted + after;

                    e.target.focus()
                    document.getSelection().collapse(e.target.firstChild, inserted.length)
                }
            }
        }, []);
    }
};
