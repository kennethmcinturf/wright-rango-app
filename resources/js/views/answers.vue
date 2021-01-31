<template>
    <div id="answers">
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