<template>
    <article class="words">
        <section class="search">
            <form method="POST" @submit.prevent="submit">
                <input type="text" name="q" id="search" placeholder="wyszukaj słowo" v-model="q.search">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </section>
        <section class="all-words">
            <section class="single-word" v-for="word in words" :key="word.id">
                <h3>{{ word.word }}</h3>
                <p>{{ word.translation }}</p>
            </section>
                <h2 class="null" v-if="words.length == 0">Nie znaleziono żadnego słowa o&nbsp;podanej frazie!</h2>
        </section>
    </article>
</template>

<script>
 export default {
        data() {
            return {
                words: [],
                word: {
                    id: '',
                    word: '',
                    translation: '',
                },
                word_id: '',
                q: {},
                search: false,
            };
        },
        created() {
            this.fetchWords();
        },
        methods: {
            fetchWords(items) {
                fetch('/api/section/' + this.$sectionId + '/words')
                    .then(res => res.json())
                    .then(res => {
                        this.words = res.data;
                    })
            },
            submit() {
                if(this.q.search == '') this.q.search = undefined
                fetch('/api/section/' + this.$sectionId + '/search/' + this.q.search)
                .then(res => res.json())
                .then(res => {
                    this.words = res.data;
                })
                this.search = true;
            },
        }
    }
</script>
