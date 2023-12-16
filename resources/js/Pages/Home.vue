<script setup>
import Layout from "@/Components/layouts/index.vue";
import {Link} from '@inertiajs/vue3'
</script>

<template>
    <Layout class=""> 
        <div class="h-screen flex flex-col justify-center items-center p-8">
            <p class="text-8xl p-8">QUIZ APPLICATION</p>
            <Link href="/quiz" class="btn btn-info w-full h-16 text-center">Start the Quiz</Link>
        </div>  
    </Layout>
   
</template>

