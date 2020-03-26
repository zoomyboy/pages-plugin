<template>
    <div>
        <div v-if="header" class="zg-p-3 zg-flex zg-flex-col zg-items-center">
            <a class="btn btn-primary" href="#" @click.prevent="editHeader">Kopfbereich</a>
        </div>

    </div>

</template>

<script>
import subform from './subform.mixin.js';

export default {
    mixins: [ subform ],
    
    data: function() {
        return {
            modalContent: '',
            loaded: false
        };
    },

    props: {
        value: {},
        header: {
            type: Boolean,
            required: true
        }
    },

    methods: {
        async editHeader() {
            this.openForm('header', 'Kopfbereich bearbeiten', this.value.placeholders.header).then(data => {
                this.value.placeholders.header = data;
            });
        }
    },
};
</script>
