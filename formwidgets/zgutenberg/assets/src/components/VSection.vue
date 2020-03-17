<template>
    <div>

    </div>
</template>

<script>
export default {

    props: {
        value: {}
    },

    mounted() {
        if (this.value.children.length == 0) {
            this.$store.dispatch('modal/open', {
                'component': 'selectrow'
            }).then(data => {
                console.log(data);
            }).catch(err => {
                this.$emit('destroy');
            });
        }
    }
};
</script>
