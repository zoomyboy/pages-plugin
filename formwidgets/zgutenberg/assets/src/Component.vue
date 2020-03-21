<template>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" @click="$emit('close')" class="close">×</button>
            <h4 class="modal-title" v-html="value.name"></h4>
        </div>
        <div class="modal-body">
            <div v-for="(param, name) in params">

                <div v-if="param.type == 'dropdown'">
                    <label :for="name" v-text="param.label"></label>
                    <select :id="name" v-model="innerValues[name]">
                        <option :value="null" v-text="param.placeholder"></option>
                        <option :value="key" v-for="(value, key) in param.options" v-text="value">></option>
                    </select>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary zg-mt-2" @click="$emit('confirm', output)" data-dismiss="modal">Speichern</button>
            <button type="button" class="btn btn-default zg-mt-2" @click="$emit('close')" data-dismiss="modal">Abbrechen</button>
        </div>
    </div>
</template>

<script>
import { debounce } from 'lodash';

export default {

    data: function() {
        return {
            innerValues: {}
        };
    },

    props: {
        value: {}
    },

    computed: {
        output() {
            return { ...this.value, params: this.innerValues };
        },
        params() {
            return this.$store.state.blocks[this.value.component].params;
        }
    },

    created() {
        for (const key in this.value.params) {
            this.innerValues[key] = this.value.params[key];
        }
    }

};
</script>
