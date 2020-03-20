<template>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" @click="$emit('close')" class="close">×</button>
            <h4 class="modal-title">Zeile einfügen</h4>
        </div>
        <div class="modal-body">
            <div class="zg-flex zg-flex-wrap zg--mx-3">
                <div class="zg-p-3 zg-w-1/3 zg-mb-6" v-for="row in rows">
                    <a href="#" @click.prevent="$emit('confirm', row)" class="zg-flex zg--mx-1">
                        <span v-for="width in row" class="zg-px-1" :class="'zg-w-'+width">
                            <span class="zg-bg-row zg-h-6 zg-block zg-rounded"></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="modal-footer"></div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            rows: [
                [ 'full' ],
                [ '1/2', '1/2'],
                [ '1/3', '1/3', '1/3' ],
                [ '1/3', '2/3' ],
                [ '2/3', '1/3' ]
            ]
        };
    },

    props: {
        handlers: {}
    }
};
</script>

