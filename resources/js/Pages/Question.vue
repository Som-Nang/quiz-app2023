<script setup>
import { ref, computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import Layout from "@/Components/layouts/index.vue";
import NewQuestModal from "@/Components/layouts/NewQuestionModal.vue";

const page = usePage();
const success = computed(() => page.props.flash.success);
const showNewQuestionModal = ref(false);
const createdQuestion = ref(null);
const newAnswers = ref([]);
const answers = ref([]);
const sellectedAnswer = ref(null);
const selectedQuestion = ref([]);
const showViewQuestionModal = ref(false);
const selectChangeRadio = ref(null);
let answerID = 1;

function createQuestion() {
    showNewQuestionModal.value = true;
}
function destroyModal() {
    showNewQuestionModal.value = false;
    showViewQuestionModal.value = false;
}

function addAnswer() {
    const newAnswer = {
        id: answerID++,
        answer: "",
        correct_answer: 0,
    };
    newAnswers.value.push(newAnswer);
}
function handleRadioToggle(Id) {
    (sellectedAnswer.value = Id),
        newAnswers.value.forEach((answer) => {
            if (answer.id === Id) {
                answer.correct_answer = 1;
            } else {
                answer.correct_answer = 0;
            }
        });
}
function validateAnswer() {
    for (const answer of newAnswers.value) {
        if (answer.answer.trim() === "") {
            return false;
        }
    }
    return true;
}
function answerCount() {
    if (newAnswers.length < 4) {
        alert("Four Answer required for submit");
    } else if (newAnswers.length === 4) {
        return true;
    }
    return false;
}

function submitQuestion() {
    if (!createdQuestion.value) {
        alert("Question can not be blank!");
        return false;
    }
    if (!validateAnswer() && !answerCount()) {
        alert("Fill all input before submitting!");
        return false;
    }
    router.post("/question", {
        question: createdQuestion.value,
        answers: newAnswers.value,
    });

    router.on("success", () => {
        (createQuestion.value = null), (newAnswers.value = []);
    });
}

const props = defineProps({
    questions: Object,
    errors: Object,
});

function viewQuestion(index) {
    showViewQuestionModal.value = true;
    selectedQuestion.value = props.questions[index];
    answers.value = props.questions[index].answers;
}

function handleRadioChange(Id) {
    selectChangeRadio.value = Id;

    answers.value.forEach((answer) => {
        if (answer.id === Id) {
            answer.correct_answer = 1;
        } else {
            answer.correct_answer = 0;
        }
    });
}

function updateAnswers() {
    router.put("/answers", answers.value, (onSuccess) => {
        showViewQuestionModal.value = false;
    });
}
</script>

<template>
    <Layout>
        <div class="overflow-x-auto">
            <button @click="createQuestion" class="btn btn-primary my-2 px-6">
                Create
            </button>
            <table class="table">
                <!-- head -->
                <thead class="bg-gray-200 text-gray-900">
                    <tr>
                        <th></th>
                        <th>Question</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-100">
                    <tr
                        v-for="(question, index) in questions"
                        class="hover cursor-pointer"
                    >
                        <th>{{ index + 1 }}</th>
                        <td>{{ question.question }}</td>
                        <td class="space-x-2">
                            <button
                                @click="viewQuestion(index)"
                                class="btn btn-info"
                            >
                                View
                            </button>
                            <button class="btn btn-success">Edit</button>
                            <button class="btn btn-error">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Teleport to="body">
            <NewQuestModal :show="showNewQuestionModal" @close="destroyModal">
                <template #header>
                    <h3>Create New Question</h3>
                </template>

                <template #success>
                    <h3 v-if="success">{{ success }}</h3>
                </template>
                <template #body>
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Question</span>
                        </div>
                        <input
                            v-model="createdQuestion"
                            type="text"
                            placeholder="Type here"
                            class="input input-bordered input-info w-full"
                        />
                    </label>
                    <div class="py-4">
                        <table class="table">
                            <!-- head -->
                            <thead class="bg-gray-200 text-gray-900">
                                <tr class="">
                                    <th>#</th>
                                    <th>Answer</th>
                                    <th>Correct?</th>
                                </tr>
                            </thead>
                            <tbody
                                class="text-gray-900"
                                v-for="(answer, index) in newAnswers"
                            >
                                <tr class="cursor-pointer">
                                    <th>1</th>
                                    <td>
                                        <label class="form-control w-full">
                                            <input
                                                v-model="answer.answer"
                                                type="text"
                                                placeholder="Answer"
                                                class="input input-bordered input-info w-full bg-gray-100"
                                            />
                                        </label>
                                    </td>
                                    <td class="pl-16">
                                        <input
                                            :check="answer.correct_answer === 1"
                                            :value="answer.id"
                                            @change="
                                                handleRadioToggle(answer.id)
                                            "
                                            type="radio"
                                            name="radio-7"
                                            class="radio radio-info"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
                <template #footer>
                    <div class="space-x-2 flex justify-end">
                        <button
                            @click="addAnswer"
                            v-if="newAnswers.length < 4"
                            class="btn btn-outline btn-warning"
                        >
                            +
                        </button>
                        <button
                            v-if="newAnswers.length > 3"
                            @click="submitQuestion"
                            class="btn btn-outline btn-info"
                        >
                            Submit
                        </button>
                        <button
                            @click="destroyModal"
                            class="btn btn-outline btn-error"
                        >
                            Close
                        </button>
                    </div>
                </template>
            </NewQuestModal>

            <NewQuestModal :show="showViewQuestionModal" @close="destroyModal">
                <template #header>
                    <h1>View Question / Answer</h1>
                </template>

                <template #success>
                    <h3 class="text-success" v-if="success">{{ success }}</h3>
                </template>

                <template #body>
                    <h1>{{ selectedQuestion.question }}</h1>

                    <table class="table">
                        <!-- head -->
                        <thead class="bg-gray-200 text-gray-900">
                            <tr class="">
                                <th>#</th>
                                <th>Answer</th>
                                <th>Correct?</th>
                            </tr>
                        </thead>
                        <tbody
                            class="text-gray-900"
                            v-for="(answer, index) in answers"
                        >
                            <tr class="cursor-pointer">
                                <th>{{ index + 1 }}</th>
                                <td>
                                    <label class="form-control w-full">
                                        <input
                                            v-model="answer.answer"
                                            type="text"
                                            placeholder="Answer"
                                            class="input input-bordered input-info w-full bg-gray-100"
                                        />
                                    </label>
                                </td>
                                <td class="pl-16">
                                    <input
                                        :checked="answer.correct_answer"
                                        :value="answer.id"
                                        @change="handleRadioChange(answer.id)"
                                        type="radio"
                                        name="radio-7"
                                        class="radio radio-info"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </template>

                <template #footer>
                    <div class="flex justify-end space-x-2">
                        <button
                            @click="destroyModal"
                            class="btn btn-outline btn-error"
                        >
                            Close
                        </button>

                        <button
                            @click="updateAnswers"
                            class="btn btn-outline btn-info"
                        >
                            Save
                        </button>
                    </div>
                </template>
            </NewQuestModal>
        </Teleport>
    </Layout>
</template>
