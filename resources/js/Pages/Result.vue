<script setup>
import Layout from "@/Components/layouts/index.vue";

defineProps({
    percentage:Number,
    comment: String
})
</script>

<template>
    <Layout class=""> 
       <h1>{{percentage}}</h1>

       <h3>{{ comment }}</h3>
    </Layout>
   
</template>
