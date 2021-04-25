<template>
    <article class="words">
        <section class="search">
            <form method="POST" @submit.prevent="submit">
                <input type="text" name="q" id="search" placeholder="wyszukaj słowo" v-model="q.search">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </section>
        <section class="all-words">
            <section class="single-word blank" v-for="word in words" :key="word.id" :id="word.id" v-on:click="add" :class="addedWords.includes(word.id) ? 'a' : ''">
                <h3 :id="word.id">{{ word.word }}</h3>
                <p :id="word.id">{{ word.translation }}</p>
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
                addedWords: [],
            };
        },
        created() {
            this.check();
            this.fetchWords(60);
        },
        updated() {
            this.catchAdded();
            this.setUpBlank();
        },
        methods: {
            check() {
                document.querySelectorAll('.added section').forEach(sect => {
                    this.addedWords.push(sect.id.slice(1))
                    sect.addEventListener('click', (e) => {
                        if (e.target.nodeName == 'H3' || e.target.nodeName == 'P')
                            var element = e.path[1]
                        else
                            var element = e.target
                        element.remove()
                        if (document.getElementById(element.id.slice(1)))
                            document.getElementById(element.id.slice(1)).classList.remove('a')
                        for (var i = 0; i < this.addedWords.length; i++) {
                            if (this.addedWords[i] == element.id.slice(1)) {
                                this.addedWords.splice(i, 1)
                                break;
                            }
                        }
                        document.getElementById('words').value = this.addedWords
                        if (this.addedWords.length >= 4) {
                            document.querySelector('.empty').style.display = 'none'
                            document.querySelector('form button').disabled = false
                            document.querySelector('form button').classList.remove('disabled')
                        } else {
                            document.querySelector('.empty').style.display = 'block'
                            document.querySelector('form button').disabled = true
                            document.querySelector('form button').classList.add('disabled')
                        }
                    })
                })
            },
            setUpBlank() {
                for (var i = 0; i < this.addedWords.length; i++) {
                    if (document.getElementById(this.addedWords[i]))
                        document.getElementById(this.addedWords[i]).classList.add('a')
                }
            },
            fetchWords(items) {
                fetch('/api/section/paginate/60')
                    .then(res => res.json())
                    .then(res => {
                        this.words = res.data;
                        if (res.meta.current_page < res.meta.last_page)
                            this.moreExists = true;
                            this.nextPage = res.meta.current_page + 1;
                    })
            },
            loadMore(nextPage) {
                fetch('/api/section/paginate/60?page=' + this.nextPage)
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
                if(this.q.search == '') this.q.search = undefined
                fetch('/api/section/search/' + this.q.search)
                .then(res => res.json())
                .then(res => {
                    this.words = res.data;
                })
                this.search = true;
            },
            catchAdded() {
                document.querySelectorAll('.all-words .blank').forEach(el => {
                    if (this.addedWords.includes(el.id))
                        el.classList.add('a')
                })
            },
            add(e) {
                if (e.path[1].className == 'all-words')
                    var element = e.target
                else
                    var element = e.path[1]

                // Dodawanie słów do listy
                if (element.classList.contains('a') && this.addedWords.includes(element.id)) {
                    element.classList.remove('a')
                    document.querySelector('#n' + element.id).remove()
                    for (var i = 0; i < this.addedWords.length; i++) {
                        if (this.addedWords[i] == element.id) {
                            this.addedWords.splice(i, 1)
                            break;
                        }
                    }
                    document.getElementById('words').value = this.addedWords
                } else {
                    element.classList.add('a')
                    this.addedWords.push(element.id)
                    document.getElementById('words').value = this.addedWords

                    var section = document.createElement('section')
                    section.classList.add('single-word')
                    section.id = 'n' + element.id
                    section.addEventListener('click', (e) => {
                        if (e.target.nodeName == 'H3' || e.target.nodeName == 'P')
                            var element = e.path[1]
                        else
                            var element = e.target
                        element.remove()
                        if (document.getElementById(element.id.slice(1)))
                            document.getElementById(element.id.slice(1)).classList.remove('a')
                        for (var i = 0; i < this.addedWords.length; i++) {
                            if (this.addedWords[i] == element.id.slice(1)) {
                                this.addedWords.splice(i, 1)
                                break;
                            }
                        }
                        document.getElementById('words').value = this.addedWords
                        if (this.addedWords.length >= 4) {
                            document.querySelector('form button').disabled = false
                            document.querySelector('form button').classList.remove('disabled')
                        } else {
                            document.querySelector('form button').disabled = true
                            document.querySelector('form button').classList.add('disabled')
                        }
                    })
                    var header = document.createElement('h3')
                    header.textContent = element.querySelector('h3').textContent
                    var paragraph = document.createElement('p')
                    paragraph.textContent = element.querySelector('p').textContent
                    section.appendChild(header)
                    section.appendChild(paragraph)
                    document.querySelector('.added').appendChild(section)
                }

                if (this.addedWords.length >= 4) {
                    document.querySelector('.empty').style.display = 'none'
                    document.querySelector('form button').disabled = false
                    document.querySelector('form button').classList.remove('disabled')
                } else {
                    document.querySelector('.empty').style.display = 'block'
                    document.querySelector('form button').disabled = true
                    document.querySelector('form button').classList.add('disabled')
                }
            }
        }
    }
</script>
