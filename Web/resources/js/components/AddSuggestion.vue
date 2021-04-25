<template>
    <section>
        <section class="similar">
            <h2>Podobne słowa</h2>
            <ul>
                <li v-for="word in similarWords" :key="word.id">{{ word }}</li>
            </ul>
            <p class="other">+ <span></span> innych słów</p>
        </section>
        <h1>Dodawanie nowego słowa</h1>
        <form method="POST" @submit.prevent="submit">
            <div class="word-group group">
                <label for="word">En</label>
                <input type="text" id="word" name="word" value="" required autofocus placeholder="Word" v-model="suggestion.word" v-on:input="findSimilar">
            </div>
            <div class="translation-group group">
                <label for="translation">Pl</label>
                <input type="text" id="translation" name="translation" value="" required placeholder="Tłumaczenie" v-model="suggestion.translation">
            </div>
            <button type="submit">Dodaj</button>
        </form>
    </section>
</template>

<script>
 export default {
        data() {
            return {
                suggestion: {},
                similarWords: [],
            };
        },
        methods: {
            submit() {
                axios.post('/api/suggestion/new/'+ this.$userId, this.suggestion)
                .then(res => this.suggestion = {})
            },
            findSimilar() {
                if (this.suggestion.word.length >= 3) {
                    const request = async () => {
                        const response = await fetch('/api/suggestion/similar/' + this.suggestion.word)
                        const json = await response.json()
                        this.similarWords = []
                        json.data.forEach(data => {
                            this.similarWords.push(data.word)
                        })
                        await this.check()
                    }
                    request()
                } else {
                    this.similarWords = []
                    document.querySelector('.similar').style.display = 'none'
                    document.querySelector('.other').style.display = 'none'
                }
            },
            check() {
                 if (this.similarWords.length == 0) {
                    document.querySelector('.similar').style.display = 'none'
                    document.querySelector('.other').style.display = 'none'
                } else if (this.similarWords.length > 0 && this.similarWords.length < 6) {
                    document.querySelector('.similar').style.display = 'block'
                    document.querySelector('.other').style.display = 'none'
                } else {
                    document.querySelector('.similar').style.display = 'block'
                    document.querySelector('.other span').textContent = this.similarWords.length - 5
                    document.querySelector('.other').style.display = 'block'
                }
                this.similarWords = this.similarWords.slice(0, 5)
            },
        }
    }
</script>
