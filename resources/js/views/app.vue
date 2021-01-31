<template>
    <div>
        <h3 class="text-center" style="margin-top:1em;">Puzzle Solver</h3>
        <form @submit.prevent="sendPuzzle">
            <div class="form-group">
                <label>Puzzle Strings</label>
                <input type="text" class="form-control" v-model="puzzleStrings">
                <small class="form-text text-muted">Seperate each word with comma</small>
            </div>
            <filereader @load="loadTextFromFile"></filereader>
            <div class="form-group">
                <label>Words to Find</label>
                <input type="text" class="form-control" v-model="solutionStrings">
                <small class="form-text text-muted">Seperate each word with comma</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <answers :answers="answers"></answers>
    </div>
</template>

<script>
import axios from 'axios';
import answers from './answers.vue';
import Filereader from './filereader.vue';

export default {
  components: { answers, Filereader },
    data() {
        return {
            puzzleStrings: "",
            solutionStrings: "",
            answers: "",
        };
    },
    mounted() {
        this.setDefaults();
    },
    methods: {
        setDefaults() {
            this.puzzleStrings = "GQLVMISSIOSSTUDVUWMSE, AEGLUSVICTRIXSDUCUNIA, RUNQAEMIMPERIPHPUMADI, YRIASBJLUMINCUBICULEM, ASSIVDVSERGTSOPERENRH";
            this.solutionStrings = "VUEJS, PHP, REDIS, POSTGRES, GARY, BALL";
        },
        sendPuzzle() {
            var puzzle = JSON.stringify(this.puzzleStrings.split(','));
            var solution = JSON.stringify(this.solutionStrings.split(','));

            return axios.post('/api/solve-puzzle', {
                puzzle: puzzle,
                solutions: solution,
            }).then(response => 
                this.answers = response.data
            );
        },
        loadTextFromFile(ev) {
            this.puzzleStrings = "";
            var puzzleArray = JSON.parse(ev);

            puzzleArray.forEach(puzzle => {
                this.puzzleStrings = this.puzzleStrings + puzzle+ ",";
            });
        }
    }
}
</script>