<template>
    <div id="answers" v-if="answers.length" class="text-center">
        <h5>Puzzle Answers</h5>
        <span v-for="(answer, index) in answers" :key="index">
            {{ answer }}<br/>
        </span>
    </div>
</template>

<script>
    export default {
        props:['answers']
    }
</script>