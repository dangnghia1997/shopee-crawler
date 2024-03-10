<script setup>

import Card from "@/Components/Card.vue";
</script>

<template>
<div class="basis-4/5">
    <div class="flex gap-4 my-4">
        <div class="p-4 bg-red-400 text-white border-2 border-black">
            SortBy: ABC
        </div>
        <div class="p-4 bg-red-400 text-white border-2 border-black">
            SortBy: ABC
        </div>
    </div>
    <div class="grid grid-cols-4 flex-wrap gap-4">
        <Card v-for="_ in [1,2,3,4,5,6, 7,8,9,10]" :key="_" />
    </div>
    <div class="flex gap-4 my-4 justify-center">
        <div class="px-4 py-2 min-w-4 rounded-md bg-white text-black" v-for="i in [1,2,3,4,5,6]" :key="i">
            {{i}}
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
