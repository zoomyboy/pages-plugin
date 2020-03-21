<template>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" @click="$emit('close')" class="close">×</button>
            <h4 class="modal-title" v-html="value.name"></h4>
        </div>
        <div class="modal-body">
            <textarea class="form-control" v-model="content" rows="20"></textarea>
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
        value: {}
    },

    computed: {
        output() {
            return { ...this.value, content: this.content };
        }
    },

    created() {
        this.content = this.value.content;
    }
};

const params = {
    icon: 'list',
    name: 'Liste',
    params: {
        content: ''
    }
};

export { params };
</script>
