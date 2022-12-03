<template>
    <GuestBase>
        <Head title="Registration"></Head>
        <div class="max-w-md w-full space-y-8">
            <div class="text-red-600" v-if="form.errors">
                <ul>
                    <li v-for="(error,eindex) in form.errors" :key="eindex">{{ error }}</li>
                </ul>
            </div>
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold text-gray-900">
                    Register
                </h2>

            </div>

            <form class="mt-8 space-y-6" @submit.prevent="submit" method="POST">
                <input type="hidden" name="remember" value="true">
                <div class="">
                    <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">First Name</label>
                    <input
                        class=" w-full text-base px-4 py-2 border-b border-gray-300 focus:outline-none rounded-2xl focus:border-indigo-500"
                        type="text" placeholder="" v-model="form.first_name">
                </div>
                <div class="">
                    <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">Last Name</label>
                    <input
                        class=" w-full text-base px-4 py-2 border-b border-gray-300 focus:outline-none rounded-2xl focus:border-indigo-500"
                        type="text" placeholder="" v-model="form.last_name">
                </div>
                <div class="">
                    <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">Email</label>
                    <input
                        class=" w-full text-base px-4 py-2 border-b border-gray-300 focus:outline-none rounded-2xl focus:border-indigo-500"
                        type="email" placeholder="mail@mail.com" v-model="form.email">
                </div>
                <div class="">
                    <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">Twitch Username</label>
                    <input
                        class=" w-full text-base px-4 py-2 border-b border-gray-300 focus:outline-none rounded-2xl focus:border-indigo-500"
                        type="text" placeholder="" v-model="form.twitch_username">
                </div>
                <div class="mt-8 content-center">
                    <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">
                        Password
                    </label>
                    <input
                        class="w-full content-center text-base px-4 py-2 border-b rounded-2xl border-gray-300 focus:outline-none focus:border-indigo-500"
                        type="password" v-model="form.password" placeholder="Enter your password">
                </div>
                <div class="mt-8 content-center">
                    <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">
                        Confirm Password
                    </label>
                    <input
                        class="w-full content-center text-base px-4 py-2 border-b rounded-2xl border-gray-300 focus:outline-none focus:border-indigo-500"
                        type="password" v-model="form.password_confirmation" placeholder="Enter your password">
                </div>
                <div>
                    <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center bg-gradient-to-r from-indigo-500 to-blue-600  hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-4  rounded-full tracking-wide font-semibold  shadow-lg cursor-pointer transition ease-in duration-500">
                        Register
                    </button>
                </div>
                <p class="flex flex-col items-center justify-center mt-10 text-center text-md text-gray-500">
                    <span>Already have an account?</span>
                    <Link :href="route('login.create')"
                          class="text-indigo-400 hover:text-blue-500 no-underline hover:underline cursor-pointer transition ease-in duration-300">
                        Login
                    </Link>
                </p>
            </form>
        </div>
    </GuestBase>
</template>

<script setup>
import GuestBase from "@/Layouts/GuestBase.vue";
import {useForm, Link, Head} from "@inertiajs/inertia-vue3";

const form = useForm({
    first_name: "",
    last_name: "",
    email: "",
    twitch_username: "",
    password: "",
    password_confirmation: "",
})

const submit = function () {
    form.post(route('register.store'))
}
</script>

<style scoped>

</style>
