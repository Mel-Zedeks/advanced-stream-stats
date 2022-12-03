<template>
    <div class="flex justify-between items-center space-x-2 cursor-pointer">
        <div class="rounded-full border border-gray-100 max-h-12 w-auto p-2">
            ML
        </div>
        <div>
            <span class="text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                {{ $page.props.auth.user.full_name }}
            </span>
        </div>

    </div>
</template>

<script setup>

</script>

<style scoped>

</style>
