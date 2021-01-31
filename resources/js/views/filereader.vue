<template>
    <div class="form-group">
        <label>Or Import File</label>
        <input type="file" class="form-control-file" @change="loadFile">
        <p class="text-danger" v-if="fileError">File must be type JSON. Please try a different one.</p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fileError:false
            }
        },
        methods: {
            loadFile(ev) {
                const file = ev.target.files[0];

                if (file['type'] != 'application/json') {
                    this.fileError = true;
                    return;
                }

                this.fileError = false;

                const reader = new FileReader();

                reader.onload = e => this.$emit("load", e.target.result);
                reader.readAsText(file);
            }
        }
    }
</script>