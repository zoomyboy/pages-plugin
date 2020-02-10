<template>
    <div class="zg-h-16 zg-flex zg-justify-between zg-bg-gray-200 zg-border-b zg-border-gray-300 zg-items-center zg-px-4">
        <div></div>

        <div>
            <a href="#" @click.prevent="$store.commit('sidebar', false)" class="fa-btn"><span class="fa fa-close"></span></a>
        </div>

    </div>
</template>

<script>
export default {

};
</script>
