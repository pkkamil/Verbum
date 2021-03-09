<?php
    $active = 'exercises';
    $title = 'Verbum - Ćwiczenia | Dopasowanie';
    $lazy = True;
?>

@extends('layouts.app')
@section('content')
<article class="exercise matching">
    <section class="parts">
        <section class="left-part">
            @foreach ($words as $key => $value)
               <h2><span>{{ $key }}</span></h2>
            @endforeach
        </section>
        <section class="right-part">
            @foreach ($words as $key => $value)
                <h3><span>{{ $value }}</span></h3>
            @endforeach
        </section>
    </section>
    <form action="{{ route('checkAnswers') }}" method="POST" autocomplete="off">
        @csrf
        <input type="hidden" name="A1" id="A1" class="answer">
        <input type="hidden" name="A2" id="A2" class="answer">
        <input type="hidden" name="A3" id="A3" class="answer">
        <input type="hidden" name="A4" id="A4" class="answer">
        <input type="hidden" name="A5" id="A5" class="answer">
        <button type="submit" id="check" disabled>Sprawdź</button>
    </form>
    @if (isset($results))
        <article class="dimmer">
            <section class="result-box">
                <h3>Podsumowanie: </h3>
                @foreach($results as $arr)
                    <h4 @if ($arr['score'] == 'correct') class="correct" @else class="incorrect" @endif>
                        <span class="word">{{ $arr['word'] }}</span> - <span class="translation">{{ $arr['translation'] }}</span>
                    </h4>
                @endforeach
                <a href="{{ url('/exercises/matching') }}"><button class="next reverse-color">Dalej</button></a>
            </section>
        </article>
    @endif
</article>
@if (!isset($results))
<script>
    let words = document.querySelectorAll('h2 span')
    let translations = document.querySelectorAll('h3 span')
    let isA = false
    let isB = false
    let isC = false
    let isD = false
    let isE = false

    words.forEach(w => {
        w.addEventListener('click', () => {
            if (w.classList.contains('clicked') && !w.classList.contains('answered')) {
                readWords()
                w.classList.remove('clicked')
            } else {
                readWords()
                if (!w.classList.contains('answered'))
                    w.classList.add('clicked')
            }
            translations.forEach(t => {
                if (w.classList.contains('clicked') && t.classList.contains('clicked')) {
                    changeStatus(w, t)
                    translations.forEach(t2 => {
                        if (t2.classList.contains('a')) {
                            isA = true
                        } else if (t2.classList.contains('b')) {
                            isB = true
                        } else if (t2.classList.contains('c')) {
                            isC = true
                        } else if (t2.classList.contains('d')) {
                            isD = true
                        } else if (t2.classList.contains('e')) {
                            isE = true
                        }
                    })
                    setAnswers(t, w)
                    countAnswers()
                } else if (w.classList.contains('a') && t.classList.contains('a')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('a')
                        w.classList.remove('a')
                        document.querySelector('#A1').value = ''
                    isA = false
                } else if (w.classList.contains('b') && t.classList.contains('b')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('b')
                        w.classList.remove('b')
                        document.querySelector('#A2').value = ''
                    isB = false
                } else if (w.classList.contains('c') && t.classList.contains('c')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('c')
                        w.classList.remove('c')
                        document.querySelector('#A3').value = ''
                    isC = false
                } else if (w.classList.contains('d') && t.classList.contains('d')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('d')
                        w.classList.remove('d')
                        document.querySelector('#A4').value = ''
                    isD = false
                } else if (w.classList.contains('e') && t.classList.contains('e')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('e')
                        w.classList.remove('e')
                        document.querySelector('#A5').value = ''
                    isE = false
                }
                countAnswers()
            })
        })
    });

    translations.forEach(t => {
        t.addEventListener('click', () => {
            if (t.classList.contains('clicked') && !t.classList.contains('answered')) {
                readTranslations()
                t.classList.remove('clicked')
            } else {
                readTranslations()
                if (!t.classList.contains('answered'))
                    t.classList.add('clicked')
            }
            words.forEach(w => {
                if (w.classList.contains('clicked') && t.classList.contains('clicked')) {
                    changeStatus(w, t)
                    words.forEach(w2 => {
                        if (w2.classList.contains('a')) {
                            isA = true
                        } else if (w2.classList.contains('b')) {
                            isB = true
                        } else if (w2.classList.contains('c')) {
                            isC = true
                        } else if (w2.classList.contains('d')) {
                            isD = true
                        } else if (w2.classList.contains('e')) {
                            isE = true
                        }
                    })
                    setAnswers(t, w)
                    countAnswers()
                } else if (w.classList.contains('a') && t.classList.contains('a')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('a')
                        w.classList.remove('a')
                        document.querySelector('#A1').value = ''
                    isA = false
                } else if (w.classList.contains('b') && t.classList.contains('b')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('b')
                        w.classList.remove('b')
                        document.querySelector('#A2').value = ''
                    isB = false
                } else if (w.classList.contains('c') && t.classList.contains('c')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('c')
                        w.classList.remove('c')
                        document.querySelector('#A3').value = ''
                    isC = false
                } else if (w.classList.contains('d') && t.classList.contains('d')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('d')
                        w.classList.remove('d')
                        document.querySelector('#A4').value = ''
                    isD = false
                } else if (w.classList.contains('e') && t.classList.contains('e')) {
                        t.classList.remove('answered')
                        w.classList.remove('answered')
                        t.classList.remove('e')
                        w.classList.remove('e')
                        document.querySelector('#A5').value = ''
                    isE = false
                }
                countAnswers()
            })
        })
    });

const readWords = () => {
    words.forEach(e => {
        if (e.classList.contains('clicked')) {
            e.classList.remove('clicked')
        }
    })
}

const readTranslations = () => {
    translations.forEach(e => {
        if (e.classList.contains('clicked')) {
            e.classList.remove('clicked')
        }
    })
}

const changeStatus = (w, t) => {
    w.classList.remove('clicked')
    t.classList.remove('clicked')
    w.classList.add('answered')
    t.classList.add('answered')
}

const setAnswers = (t, w) => {
    if (!isA) {
        t.classList.add('a')
        w.classList.add('a')
        document.querySelector('#A1').value = w.textContent + ' | ' + t.textContent
    } else if (!isB) {
        t.classList.add('b')
        w.classList.add('b')
        document.querySelector('#A2').value = w.textContent + ' | ' + t.textContent
    } else if (!isC) {
        t.classList.add('c')
        w.classList.add('c')
        document.querySelector('#A3').value = w.textContent + ' | ' + t.textContent
    } else if (!isD) {
        t.classList.add('d')
        w.classList.add('d')
        document.querySelector('#A4').value = w.textContent + ' | ' + t.textContent
    } else if (!isE) {
        t.classList.add('e')
        w.classList.add('e')
        document.querySelector('#A5').value = w.textContent + ' | ' + t.textContent
    }
}

const countAnswers = () => {
    let answers = document.querySelectorAll('.answer')
    for (let i = 0; i <= 4; i++) {
        if (answers[i].value == '') {
            document.querySelector('#check').disabled = true
            break
        } else
            document.querySelector('#check').disabled = false
    }
}
</script>
@endif
@endsection
