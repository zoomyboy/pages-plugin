<template>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" @click="$emit('close')" class="close">×</button>
            <h4 class="modal-title">Zeile einfügen</h4>
        </div>
        <div class="modal-body">
            <div class="flex flex-wrap -mx-3">
                <div class="p-3 w-1/3 mb-6" v-for="row in rows">
                    <a href="#" @click.prevent="$emit('confirm', row)" class="flex -mx-1">
                        <span v-for="width in row" class="px-1" :class="'w-'+width">
                            <span class="bg-row h-12 block rounded"></span>
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

