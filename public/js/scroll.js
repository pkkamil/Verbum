let arrow = document.querySelector('i.fa-arrow-circle-down')

if (arrow != null) {
    function changeActivePage(a) {
        if (a == 'unactive')
            document.querySelector('a.down').classList.remove('active')
        else
            document.querySelector('a.down').classList.add('active')
    }

    $(".down").click(function(e) {
        changeActivePage('active')
        if (location.pathname == '/') {
            e.preventDefault()
        }
        if (window.innerWidth > 976) {
            window.scrollTo(0, document.querySelector('.words').offsetTop - $('nav').height() - 16)
        } else {
            document.querySelector('.nav-btn').click()
            window.scrollTo(0, document.querySelector('.words').offsetTop - $('nav').height())
        }
    })

    document.addEventListener('scroll', () => {
        if (window.scrollY < document.querySelector('.words').offsetTop - $('nav').height() - 17) {
            changeActivePage('unactive')
        } else {
            changeActivePage('active')
        }
    })
}

document.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
     if (window.innerWidth > 976) {
        document.querySelector('nav').classList.remove('gray-ww')
        document.querySelector('nav').classList.add('gray')
     } else {
        document.querySelector('nav').classList.remove('gray')
        document.querySelector('nav').classList.add('gray-ww')
    }} else {
        document.querySelector('nav').classList.remove('gray-ww')
        document.querySelector('nav').classList.remove('gray')
    }
})

document.addEventListener('DOMContentLoaded', () => {
    if (window.scrollY > 50) {
        document.querySelector('nav').classList.add('gray')
    }
})

if (window.location.hash == '#slownik') {
    window.location.hash = ''
    $('.down').click()
}
