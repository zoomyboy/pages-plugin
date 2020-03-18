<template>
    <div class="zg-border-gray-200 zg-bg-white zg-p-4 zg-flex zg-justify-between" style="border-bottom: solid 1px #eee;">
        <div class="zg--mx-2 zg-flex">
            <div class="zg-px-2 zg-relative">
                <a href="#" class="fa-btn" @click.prevent="cb = !cb"><span class="fa-plus fa fa-xs"></span></a>
            </div>
            <div class="zg-px-2">
                <a href="#" class="fa-btn"><span class="fa-info fa fa-xs"></span></a>
            </div>
            <div class="zg-px-2">
                <a href="#" class="fa-btn"><span class="fa-th fa fa-xs"></span></a>
            </div>
        </div>

        <div class="zg--mx-4 zg-flex">
            <div class="zg-px-4">
                <a href="#" class="fa-btn btn-switch" :class="{'enabled': $store.state.sidebar}" @click="toggleSidebar"><span class="fa fa-cogs"></span></a>
            </div>
        </div>

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
