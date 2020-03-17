<template>
    <div>

    </div>
</template>

<script>
export default {

    props: {
        value: []
    },

    mounted() {
        if (this.value.children.length == 0) {
            this.$store.commit('addModal', { 'is': 'selectrow' });
        }
    }
};
</script>
