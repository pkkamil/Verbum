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
            <section class="button-section" v-if="!search">
                <button v-show="moreExists" v-on:click="loadMore">Zobacz więcej</button>
            </section>
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
                nextPage: 1,
                moreExists: false,
                q: {},
                search: false,
            };
        },
        created() {
            this.fetchWords(60);
        },
        methods: {
            fetchWords(items) {
                fetch('api/words/paginate/60')
                    .then(res => res.json())
                    .then(res => {
                        this.words = res.data;
                        if (res.meta.current_page < res.meta.last_page)
                            this.moreExists = true;
                            this.nextPage = res.meta.current_page + 1;
                    })
            },
            loadMore(nextPage) {
                fetch('api/words/paginate/60?page=' + this.nextPage)
                    .then(res => res.json())
                    .then(res => {
                        if (res.meta.current_page < res.meta.last_page) {
                            this.moreExists = true;
                            this.nextPage = res.meta.current_page + 1;
                        } else {
                            this.moreExists = false;
                        }
                        res.data.forEach(data => {
                            this.words.push(data);
                        })
                    })
            },
            submit() {
                fetch('/api/words/search/' + this.q.search)
                .then(res => res.json())
                .then(res => {
                    this.words = res.data;
                })
                this.search = true;
            },
        }
    }
</script>
