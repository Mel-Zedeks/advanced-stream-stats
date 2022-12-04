<template>
    <div class="min-h-full bg-gray-200 pb-12">
        <div class="w-full bg-blue-900 pt-16 pb-24 text-center">
            <h4 class="text-2xl text-gray-100">Choose the right plan for you</h4>
            <p class="text-sm text-gray-100 mt-2">Pricing built for businesses of all sizes. Choose package that suits
                your needs.</p>

        </div>
        <div class="w-full 2xl:w-3/4 flex items-center justify-center px-8 md:px-32 lg:px-16 2xl:px-0 mx-auto -mt-8">
            <div class="w-full grid grid-cols-1 xl:grid-cols-2 gap-16">

                <PricingPlanCard :plan="plan" v-for="plan in plans" :key="plan.id"  @purchase-clicked="selectPricingPlan">
                    <template v-slot="features">
<!--                        <PricingPlanFeature :title="feature.name" :is-active="true"-->

<!--                                            v-for="feature in price.features" :key="feature.id"></PricingPlanFeature>-->
                    </template>
                </PricingPlanCard>

            </div>
        </div>
    </div>

</template>

<script setup>

import PricingPlanCard from "@/Components/PricingPlanCard.vue";

import {Inertia} from "@inertiajs/inertia";

defineProps({
    plans: Object
})
function selectPricingPlan(e) {
    return  Inertia.visit(route('subscription.create', e))
}
</script>

<style scoped>

</style>
