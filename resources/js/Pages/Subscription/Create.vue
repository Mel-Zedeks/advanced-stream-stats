<template>
    <div class="w-full h-screen">
        <div
            class="flex justify-center flex-col items-center w-full h-screen">

            <div class="">
                <p class="space-x-4"><span>Selected Plan</span><span
                    class="text-xl text-center font-bold text-blue-600">{{ plan.name }}</span></p>
                <p class="text-center py-8">
                    <span class="text-4xl font-bold text-gray-700">
                        $<span>{{ plan.price }}</span>
                    </span>
                    <span class="text-xs uppercase text-gray-500">
                        / <span>{{ plan.type }}</span>
                    </span>
                </p>
            </div>
            <div class="p-8 bg-gray-100 flex flex-col w-1/2 ">

                <form @submit.prevent="submit">

                    <div ref="dropInRef"></div>

                    <button
                        type="submit"
                        class="mt-8 border border-transparent hover:border-gray-300 bg-gray-900 hover:bg-white text-white hover:text-gray-900 flex justify-center items-center py-4 rounded w-full">
                        <span class="text-base leading-4">Pay </span>
                    </button>
                </form>


            </div>
        </div>
    </div>
</template>

<script setup>
import {defineProps, onMounted} from "vue";
import dropIn from "braintree-web-drop-in"
import {useForm} from "@inertiajs/inertia-vue3";

const dropInRef = ref(null)
const props = defineProps({
    plan: Object,
    userToken: String
})
const form = useForm({
    paymentMethodNonce: "",
})
const dropInInstance = ref(null);
const paypalConfig = ref({
    flow: "vault",
    amount: props.price,
    currency: props.currencyIsoCode,
    displayName: "Advanced Stream Stats"
})
onMounted(() => {
    dropIn.create({
        authorization: props.userToken,
        container: dropInRef.value,
        locale: "en_US",
        // threeDSecure: true,
        card: {
            cardholderName: true,
        },
        paypal: paypalConfig.value,
        paymentOptionPriority: ['card', 'paypal']
    }).then((dropinInstance) => {

        dropInInstance.value = dropinInstance
        // return dropIn.dataCollector.create({
        //     client: dropinInstance
        // }).then(function (dataCollectorInstance) {
        //     form.deviceData = dataCollectorInstance.deviceData;
        // });
    }).catch((error) => {
        console.log(error)
    });
})
function submit() {
    dropInInstance.value.requestPaymentMethod().then((payload) => {
        form.paymentMethodNonce = payload.nonce
        // dropInInstance.value.clearSelectedPaymentMethod()
        form.post(route('checkout.store'))
    }).catch((error) => {
        console.log(error)
    })

}

</script>

<style scoped>

</style>
