<template>
    <div class="bg-white shadow-2xl rounded-lg py-4">
        <p class="text-xl text-center font-bold text-blue-600">{{ plan.name }}</p>
        <p class="text-center py-8">
                    <span class="text-4xl font-bold text-gray-700">
                        $<span >{{ plan.price }}</span>
                    </span>
            <span class="text-xs uppercase text-gray-500">
                        / <span >{{ plan.type }}</span>
                    </span>
        </p>
        <ul class="border-t border-gray-300 py-8 space-y-6">
            <slot name="features"></slot>
        </ul>
        <slot></slot>
        <div class="flex items-center justify-center mt-6">
            <button  class="bg-blue-600 hover:bg-blue-700 px-8 py-2 text-sm text-gray-200 uppercase rounded font-bold transition duration-150" title="Purchase" @click.prevent="$emit('purchaseClicked',{plan:plan.id})">Purchase</button>
        </div>
    </div>
</template>

<script setup>
defineEmits(['purchaseClicked'])
defineProps({
    plan:{
        type:Object,
        default:{
            id:1,
            name:"Free",
            price:"0.00",
            type:"month"
        }
    }
})
</script>

<style scoped>

</style>
