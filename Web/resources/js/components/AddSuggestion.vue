<template>
    <form method="POST" @submit.prevent="submit">
        <div class="word-group group">
            <label for="word">En</label>
            <input type="text" id="word" name="word" value="" required autofocus placeholder="Word" v-model="suggestion.word">
        </div>
        <div class="translation-group group">
            <label for="translation">Pl</label>
            <input type="text" id="translation" name="translation" value="" required placeholder="Tłumaczenie" v-model="suggestion.translation">
        </div>
        <button type="submit">Dodaj</button>
    </form>
</template>

<script>
 export default {
        data() {
            return {
                suggestion: {},
            };
        },
        methods: {
            submit() {
                axios.post('/api/suggestion/new/'+ this.$userId, this.suggestion)
                .then(res => this.suggestion = {})
            },
        }
    }
</script>
