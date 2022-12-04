<template>
<AuthBase>

    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-8 ">
        <div class="flex justify-between items-center" v-if="$page.props.auth.subscription!==null">
            <div>Subscription: <span class="text-blue-500 font-bold">{{$page.props.auth.subscription.name}}</span></div>
            <div>Status: <span class="text-blue-500 font-bold">{{$page.props.auth.subscription.ends_at===null?"Active":"Cancelled"}}</span></div>
            <Link class="bg-red-500 text-white p-2 rounded-md" v-if="$page.props.auth.subscription.ends_at===null" :href="route('subscription.destroy',{id:$page.props.auth.subscription.braintree_id})">Cancel</Link>
            <Link class="bg-blue-500 text-white p-2 rounded-md" v-if="$page.props.auth.subscription.ends_at!==null" :href="route('subscription.destroy',{id:$page.props.auth.subscription.braintree_id})">Reactivate</Link>
        </div>
        <div v-else class="flex justify-end">
            <Link v-if="$page.props.auth.subscription===null" :href="route('subscription.index')" class="hidden sm:inline-flex ml-5 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mr-3">
                Subscribe
            </Link>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Transactions</h3>
             </div>
            <div class="flex-shrink-0">
                <a href="#" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg p-2"> </a>
            </div>
        </div>
        <div class="flex flex-col mt-8">
            <div class="overflow-x-auto rounded-lg">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr >
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Transaction ID
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date & Time
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr v-for="transaction in transactions" :key="transaction.id">
                                <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-900">
                                    {{ transaction.id}}
                                </td>
                                <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                    {{ transaction.createdAt.date }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ transaction.amount }} {{transaction.currencyIsoCode}}
                                </td>
                                <td class="p-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ transaction.status }}
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</AuthBase>
</template>

<script setup>
import AuthBase from "@/Layouts/AuthBase.vue";
import {Link} from "@inertiajs/inertia-vue3"

defineProps({
    subscriptions:Object,
    transactions:Object
})
</script>

<style scoped>

</style>
