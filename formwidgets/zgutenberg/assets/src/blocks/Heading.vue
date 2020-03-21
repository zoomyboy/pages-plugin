<template>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" @click="$emit('close')" class="close">×</button>
            <h4 class="modal-title" v-html="params.name"></h4>
        </div>
        <div class="modal-body">
            <input type="text" class="form-control" v-model="content"></text>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary zg-mt-2" @click="$emit('confirm', output)" data-dismiss="modal">Speichern</button>
            <button type="button" class="btn btn-default zg-mt-2" @click="$emit('close')" data-dismiss="modal">Abbrechen</button>
        </div>
    </div>
</template>

<script>
import BlockMixin from '../block.mixin.js';
import StripMixin from '../strip.mixin.js';

export default {
    data: function() {
        return {
            content: ''
        }
    },

    props: {
        params: {}
    },

    computed: {
        output() {
            // @todo assign tag h2, h3, h4
            return { ...this.params, content: this.content, tag: 'h2' };
        }
    },


    created() {
        this.content = this.params.content;
    }
};

const render = function(createElement) {

};

const params = {
    icon: 'header',
    is: 'paragraph',
    name: 'Überschrift',
    params: {},
    content: ''
};

export { render, params };
</script>
