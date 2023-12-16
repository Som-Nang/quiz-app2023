<script setup>
import Layout from "@/Components/layouts/index.vue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    questions: Object,
});
const currentIndex = ref(0);
const currentQuestion = computed(() => {
    return props.questions[currentIndex.value];
});
const totalQuestion = computed(() => props.questions.length);
const lastQuestion = computed(
    () => currentIndex.value === props.questions.length - 1
);
const answers = computed(() => {
    return props.questions[currentIndex.value].answers;
});
const selectedAnswer = ref(null)
const result = ref(0)
function selectOption(index) {
    // alert(index)
    selectedAnswer.value=index
}
function nextQuestion() {
    if(selectedAnswer.value !== null){
        if(props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer==1){
            result.value++;
        }
        currentIndex.value++;
        selectedAnswer.value=null
    }
}
function caculateResult(){
    if(props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer==1){
            result.value++;
        }
        router.post('/results',[
        {
            results:{
                'score' :result.value,
                'totalQuestion' :totalQuestion.value 
            }
        }    
        
        ])
}
</script>

<template>
    <Layout>
        <div class="bg-gray-100 p-12 px-72 rounded-md">
            <div class="py-2">
                <p class="text-gray-800 text-lg">
                    Question {{ currentIndex + 1 }} out of {{ totalQuestion }}
                </p>
            </div>
            <table class="table border border-gray-400">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="text-xl text-gray-800">
                            {{ currentQuestion.question }}
                        </th>
                    </tr>
                </thead>
                <tbody class="">
                    <tr
                    :class="{'selected':index===selectedAnswer}"
                        @click="selectOption(index)"
                        v-for="(answer, index) in answers"
                        class="hover cursor-pointer"
                    >
                       
                            <th>{{ index + 1 }}</th>
                            <td>{{ answer.answer }}</td>
                    
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-end space-x-2 py-2">
                <button
                    @click="nextQuestion"
                    v-if="!lastQuestion"
                    class="btn btn-warning"
                >
                    Next
                </button>
                <button @click="caculateResult" v-if="lastQuestion" class="btn btn-success">
                    Submit
                </button>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.selected{
    background-color: rgb(11, 155, 227);
    color: #fff;
}
</style>

