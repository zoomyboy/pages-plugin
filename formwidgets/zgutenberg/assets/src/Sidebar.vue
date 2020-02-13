<template>
    <div>
        <div class="zg-h-16 zg-flex zg-justify-between zg-bg-gray-200 zg-border-b zg-border-gray-300 zg-items-center zg-px-4">

            <span v-text="block.name"></span>
            <a href="#" @click.prevent="$store.commit('sidebar', false)" class="fa-btn"><span class="fa fa-close"></span></a>


        </div>

        <div v-for="(param, name) in params">

            <div v-if="param.type == 'dropdown'">
                <label :for="name" v-text="param.label"></label>
                <select :id="name" :name="name" @change="publish(name, $event)">
                    <option :value="null" v-text="param.placeholder"></option>
                    <option :value="key" v-for="(value, key) in param.options" v-text="value">></option>
                </select>
            </div>

        </div>
    </div>

</template>

<script>
export default {
    computed: {
        params() {
            return this.$store.getters.sidebarParams;
        },
        block() {
            return this.$store.getters.selectedBlockType;
        }
    },

    methods: {
        publish(name, event) {
            this.$store.commit('updateParams', {
                key: name,
                value: event.target.value
            });
        }
    }
};
</script>
