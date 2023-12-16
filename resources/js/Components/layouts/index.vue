<script setup>
import Header from '@/Components/layouts/Footer.vue';
import Footer from '@/Components/layouts/Header.vue';
</script>

<template>
    <div class="container ">
  

    
    <Footer/>
    <div class="p-8">
    <slot />
    </div>
    <Header/>
</div>
</template>