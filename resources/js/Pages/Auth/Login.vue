<template>
    <GuestBase>
        <div class="max-w-md w-full space-y-8">
            <div class="text-red-600" v-if="form.errors">
                <ul>
                    <li v-for="(error,eindex) in form.errors" :key="eindex">{{ error }}</li>
                </ul>
            </div>
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-bold text-gray-900">
                    Welcom Back!
                </h2>
                <p class="mt-2 text-sm text-gray-500">Please sign in to your account</p>
            </div>

            <form class="mt-8 space-y-6" @submit.prevent="submit" method="POST">
                <input type="hidden" name="remember" value="true">
                <div class="relative">
                    <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">Email</label>
                    <input
                        class=" w-full text-base px-4 py-2 border-b border-gray-300 focus:outline-none rounded-2xl focus:border-indigo-500"
                        type="email" placeholder="" v-model="form.email">
                </div>
                <div class="mt-8 content-center">
                    <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">
                        Password
                    </label>
                    <input
                        class="w-full content-center text-base px-4 py-2 border-b rounded-2xl border-gray-300 focus:outline-none focus:border-indigo-500"
                        type="password" v-model="form.password" placeholder="Enter your password">
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox"
                               class="h-4 w-4 bg-blue-500 focus:ring-blue-400 border-gray-300 rounded" v-model="form.remember">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <Link :href="route('forgot-password.create')" class="text-indigo-400 hover:text-blue-500">
                            Forgot your password?
                        </Link>
                    </div>
                </div>
                <div>
                    <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center bg-gradient-to-r from-indigo-500 to-blue-600  hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-4  rounded-full tracking-wide font-semibold  shadow-lg cursor-pointer transition ease-in duration-500">
                        Sign in
                    </button>
                </div>
                <p class="flex flex-col items-center justify-center mt-10 text-center text-md text-gray-500">
                    <span>Don't have an account?</span>
                    <Link :href="route('register.create')"
                          class="text-indigo-400 hover:text-blue-500 no-underline hover:underline cursor-pointer transition ease-in duration-300">
                        Register
                    </Link>
                </p>
            </form>
        </div>
    </GuestBase>
</template>

<script setup>

import GuestBase from "@/Layouts/GuestBase.vue";
import {useForm, Link} from "@inertiajs/inertia-vue3";
// form data
const form = useForm({
    email: "",
    password: "",
    remember: false,
})

function submit() {
    form.post(route('login.store'), {
        onFinish: () => {

        }
    })
}
</script>

<style scoped>

</style>
