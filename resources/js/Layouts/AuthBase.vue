<template>

    <div>
        <NavBar></NavBar>
        <div class="flex overflow-hidden bg-white pt-16">
            <SideBar/>
            <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
            <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
                <main class="p-8">
                    <slot/>
                </main>
                <FooterComponent/>

            </div>
        </div>

    </div>
</template>

<script setup>

import NavBar from "@/Components/NavBar.vue";
import SideBar from "@/Components/SideBar.vue";
import FooterComponent from "@/Components/FooterComponent.vue";
</script>

<style scoped>

</style>
