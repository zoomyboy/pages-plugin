<template>
    <div>
        <div class="control-popup modal fade in" v-for="(item, index) in items" :key="index" style="display: block;">
            <div class="modal-dialog">
                <v-component :is="item.component" v-bind="item.params" @close="close(index)" @confirm="confirm(index, $event)"></v-component>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        items() {
            return this.$store.getters['modal/all'];
        },
        any() {
            return this.$store.getters['modal/any'];
        }
    },
    methods: {
        close(index) {
            this.items[index].reject();
            this.$store.dispatch('modal/close', index);
        },
        confirm(index, event) {
            this.items[index].resolve(event);
            this.$store.dispatch('modal/close', index);
        }
    }
};
</script>

<style scoped>
    .bg-black-transparent {
        background: rgba(0, 0, 0, 0.3);
    }
</style>
