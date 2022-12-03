<template>
    <li class="flex items-center space-x-2 px-8">
                        <span :class="{'bg-blue-600':isActive, 'bg-gray-300':!isActive}" class=" rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </span>
        <span class="text-gray-600 capitalize">{{ title }}</span>
    </li>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        default: "Free Setup Guidance"
    },
    isActive: {
        type:Boolean,
        default:false
    }
})

</script>

<style scoped>

</style>
