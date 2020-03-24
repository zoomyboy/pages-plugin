<template>
    <div class="zg-border-gray-200 zg-bg-white zg-p-2 zg-flex zg-justify-end" style="border-bottom: solid 1px #eee;">
        <a href="#" class="fa-btn btn-switch" :class="{'enabled': $store.state.sidebar}" @click="toggleSidebar"><span class="icon-cogs"></span></a>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            cb: false
        };
    },
    computed: {
    },
    methods: {
        toggleSidebar() {
            this.$store.commit('sidebar', !this.$store.state.sidebar);
        }
    }
};
</script>
