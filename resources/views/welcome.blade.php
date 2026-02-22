<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPITST E-Library</title>

    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/image/img_welcome/RPITST.png') }}">

    <!-- Link Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">

    <!-- Link Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style_welcome/swiper-bundle.min.css') }}">

    <!-- Link Custom -->
    <link rel="stylesheet" href="{{ asset('assets/css/style_welcome/style.css') }}">

    <style>
        /* ========== Book Detail Modal ========== */
        .book-modal {
            position: fixed;
            inset: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
            transition: visibility .3s, opacity .3s;
        }
        .book-modal.show-modal {
            visibility: visible;
            opacity: 1;
        }
        .book-modal__overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,.55);
            cursor: pointer;
        }
        .book-modal__box {
            position: relative;
            background: var(--container-color);
            border-radius: 16px;
            padding: 2rem;
            max-width: 680px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
            z-index: 1;
            transform: translateY(30px);
            transition: transform .3s;
        }
        .book-modal.show-modal .book-modal__box {
            transform: translateY(0);
        }
        .book-modal__close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: var(--title-color);
            cursor: pointer;
            line-height: 1;
            padding: 4px;
        }
        .book-modal__close:hover { color: var(--first-color); }
        .book-modal__inner {
            display: grid;
            grid-template-columns: 130px 1fr;
            gap: 1.5rem;
            align-items: start;
        }
        @media (max-width: 540px) {
            .book-modal__inner { grid-template-columns: 1fr; }
            .book-modal__cover { margin: 0 auto; }
        }
        .book-modal__cover {
            width: 130px;
            height: 175px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0,0,0,.2);
        }
        .book-modal__title {
            font-family: var(--second-font);
            font-size: var(--h2-font-size);
            color: var(--title-color);
            margin-bottom: .35rem;
            line-height: 1.3;
        }
        .book-modal__author {
            color: var(--first-color);
            font-size: var(--small-font-size);
            font-weight: var(--font-semi-bold);
            margin-bottom: 1rem;
        }
        .book-modal__table {
            width: 100%;
            border-collapse: collapse;
            font-size: var(--small-font-size);
            margin-bottom: 1rem;
        }
        .book-modal__table td {
            padding: .3rem .5rem;
            border-bottom: 1px solid var(--border-color);
        }
        .book-modal__table td:first-child {
            font-weight: var(--font-semi-bold);
            color: var(--title-color);
            width: 38%;
        }
        .book-modal__badge {
            display: inline-block;
            background: var(--first-color);
            color: var(--white-color);
            font-size: .68rem;
            font-weight: var(--font-semi-bold);
            padding: .2rem .6rem;
            border-radius: 20px;
            letter-spacing: .4px;
        }
        .book-modal__btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--first-color);
            color: var(--white-color);
            padding: .7rem 1.4rem;
            border-radius: 8px;
            font-weight: var(--font-semi-bold);
            font-size: var(--small-font-size);
            cursor: pointer;
            border: none;
            text-decoration: none;
            box-shadow: 0 4px 10px hsla(230,72%,32%,.35);
            transition: background .25s;
        }
        .book-modal__btn:hover { background: hsl(230,62%,56%); color: var(--white-color); }
        .book-modal__btn--outline {
            background: transparent;
            border: 2px solid var(--first-color);
            color: var(--first-color);
            box-shadow: none;
        }
        .book-modal__btn--outline:hover {
            background: var(--first-color);
            color: var(--white-color);
        }
        .book-modal__nopdf {
            font-size: var(--small-font-size);
            color: var(--text-color);
        }

        /* ========== PDF badge on featured card ========== */
        .featured__pdf-badge {
            position: absolute;
            top: .6rem;
            right: .6rem;
            background: #dc3545;
            color: #fff;
            font-size: .65rem;
            font-weight: 600;
            padding: .2rem .55rem;
            border-radius: 20px;
            letter-spacing: .4px;
        }

        /* ========== Stats strip ========== */
        .stats-strip {
            background: var(--first-color);
            color: #fff;
            text-align: center;
            padding: .55rem 1rem;
            font-size: var(--small-font-size);
            font-weight: var(--font-semi-bold);
            letter-spacing: .5px;
        }

        /* ========== Dark theme overrides ========== */
        body.dark-theme .book-modal__table td { border-color: hsl(230,16%,30%); }
    </style>
</head>
<body>

    <!-- Stats Strip -->
    @if($totalBooks > 0)
    <div class="stats-strip">
        <i class="ri-book-2-fill"></i>
        {{ $totalBooks }} {{ Str::plural('book', $totalBooks) }} available in our digital library
    </div>
    @endif

    <!--==================== Header ====================-->
    <header class="header" id="header">
        <div class="nav container">
            <a href="{{ route('home') }}" class="nav__logo">
                <img src="{{ asset('assets/image/img_welcome/RPITST.png') }}" alt="">
                <p>បណ្ណាល័យអេឡិចត្រូនិក <br><span>RPITST E-Library</span></p>
            </a>

            <!--==================== Menu ====================-->
            <div class="nav__menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="#home" class="nav__link active-link">
                            <i class="ri-home-4-fill"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="#featured" class="nav__link">
                            <i class="ri-book-2-fill"></i>
                            <span>Featured</span>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="#reading" class="nav__link">
                            <i class="ri-book-3-fill"></i>
                            <span>Reading & Resources</span>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="#new" class="nav__link">
                            <i class="ri-book-marked-fill"></i>
                            <span>New Books</span>
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="#testimonial" class="nav__link">
                            <i class="ri-message-3-fill"></i>
                            <span>Testimonial</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!--==================== Nav Action ====================-->
            <div class="nav__actions">
                <!-- Search Button -->
                <i class="ri-search-line search-button" id="search-button"></i>

                <!-- Login Button with Popup -->
                <div class="nav__user-wrap">
                    @auth
                        <i class="ri-user-3-line login-button" id="login-button"></i>
                        <div class="nav__user-popup" id="user-popup">
                            <div class="popup__arrow"></div>
                            <div class="popup__header">
                                <div class="popup__avatar">
                                    <i class="ri-user-3-line"></i>
                                </div>
                                <div class="popup__header-text">
                                    <strong>{{ Auth::user()->name }}</strong>
                                    <span>{{ ucfirst(Auth::user()->role) }}</span>
                                </div>
                            </div>
                            <a href="{{ route('user.dashboard') }}" class="popup__btn popup__btn--login">
                                <i class="ri-dashboard-line"></i>
                                My Dashboard
                            </a>
                            <a href="{{ url('user/books') }}" class="popup__btn popup__btn--login">
                                <i class="ri-book-shelf-line"></i>
                                Book Library
                            </a>
                            @if(in_array(Auth::user()->role, ['admin','librarian']))
                            <a href="{{ url('admin/dashboard') }}" class="popup__btn popup__btn--login">
                                <i class="ri-dashboard-line"></i>
                                Admin Panel
                            </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="popup__btn popup__btn--register" style="width:100%;text-align:left;cursor:pointer;background:none;border:none;padding:.75rem 1rem;font-size:inherit;">
                                    <i class="ri-logout-box-line"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <i class="ri-user-line login-button" id="login-button"></i>
                        <div class="nav__user-popup" id="user-popup">
                            <div class="popup__arrow"></div>
                            <div class="popup__header">
                                <div class="popup__avatar">
                                    <i class="ri-user-3-line"></i>
                                </div>
                                <div class="popup__header-text">
                                    <strong>គណនីរបស់អ្នក</strong>
                                    <span>ចូល ឬ ចុះឈ្មោះ</span>
                                </div>
                            </div>
                            <a href="{{ url('login') }}" class="popup__btn popup__btn--login">
                                <i class="ri-login-box-line"></i>
                                Login
                            </a>
                            <a href="{{ url('registration') }}" class="popup__btn popup__btn--register">
                                <i class="ri-user-add-line"></i>
                                Registration
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Theme Button -->
                <i class="ri-moon-line change-theme" id="theme-button"></i>
            </div>
        </div>
    </header>

    <!--==================== Search ====================-->
    <div class="search" id="search-content">
        <form action="{{ url('user/books') }}" method="GET" class="search__form">
            <i class="ri-search-line search__icon"></i>
            <input type="search" name="search" class="search__input" placeholder="What are you looking for?">
        </form>
        <i class="ri-close-line search__close" id="search-close"></i>
    </div>

    <!--==================== Main ====================-->
    <main class="main">

        <!--==================== Home ====================-->
        <section class="home section" id="home">
            <div class="home__container container grid">
                <div class="home__data">
                    <h1 class="home__title">
                        Browse & <br>
                        Choose the book you need
                    </h1>
                    <p class="home__description">
                        សូមស្វែងរក និងទទួលបានបទពិសោធន៍ថ្មីជាមួយ
                        ប្រព័ន្ធបណ្ណាល័យអេឡិចត្រូនិចរបស់វិទ្យាស្ថាន(RPITST E-Library)
                        ដែលប្រមូលផ្តុំសៀវភៅនិងឯកសារឌីជីថលជាច្រើនប្រភេទទៅតាមមុខវិជ្ជាដែលអ្នកកំពុងសិក្សា
                        ស្រាវជ្រាវ ដើម្បីបង្កើនចំណេះដឹងនិងការអភិវឌ្ឍជំនាញវិជ្ជាជីវៈរបស់អ្នក។
                    </p>
                    <a href="{{ url('user/books') }}" class="button">Explore Now</a>
                </div>

                <!-- Hero Swiper (decorative) -->
                <div class="home__images">
                    <div class="home__swiper swiper">
                        <div class="swiper-wrapper">
                            @if($featuredBooks->count() > 0)
                                @foreach($featuredBooks->take(6) as $book)
                                <article class="home__article swiper-slide">
                                    <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="home__img"
                                         onerror="this.onerror=null;this.src='{{ asset('assets/images/default-book.svg') }}'">
                                </article>
                                @endforeach
                            @else
                                <article class="home__article swiper-slide">
                                    <img src="{{ asset('assets/image/img_welcome/61EJPSaTuhL._SY425_.jpg') }}" alt="e-book" class="home__img">
                                </article>
                                <article class="home__article swiper-slide">
                                    <img src="{{ asset('assets/image/img_welcome/81Ewq3X1DrL._SY342_.jpg') }}" alt="e-book" class="home__img">
                                </article>
                                <article class="home__article swiper-slide">
                                    <img src="{{ asset('assets/image/img_welcome/71PwKVfEwJL._SY425_.jpg') }}" alt="e-book" class="home__img">
                                </article>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--==================== Services ====================-->
        <section class="services section">
            <div class="services__container container grid">
                <article class="services__card">
                    <i class="ri-download-2-line"></i>
                    <h3 class="services__title">Free Downloads</h3>
                    <p class="services__description">Users can download books for free with a registered account</p>
                </article>
                <article class="services__card">
                    <i class="ri-arrow-left-right-line"></i>
                    <h3 class="services__title">Book Borrowing</h3>
                    <p class="services__description">You can borrow books from the E-Library</p>
                </article>
                <article class="services__card">
                    <i class="ri-customer-service-2-line"></i>
                    <h3 class="services__title">24/7 Support</h3>
                    <p class="services__description">Call us anytime</p>
                </article>
            </div>
        </section>

        <!--==================== Featured Books ====================-->
        <section class="featured section" id="featured">
            <h2 class="section__title">Featured Books</h2>

            @if($featuredBooks->count() > 0)
            <div class="featured__container container">
                <div class="featured__swiper swiper">
                    <div class="swiper-wrapper">
                        @foreach($featuredBooks as $book)
                        <article class="featured__card swiper-slide">
                            {{-- PDF badge --}}
                            @if($book->file)
                                <span class="featured__pdf-badge">
                                    <i class="ri-file-pdf-line"></i> PDF
                                </span>
                            @endif

                            <img src="{{ $book->image_url }}"
                                 alt="{{ $book->title }}"
                                 class="featured__img"
                                 onerror="this.onerror=null;this.src='{{ asset('assets/images/default-book.svg') }}'">

                            <h3 class="featured__title">{{ Str::limit($book->title, 40) }}</h3>
                            <p class="featured__description">{{ Str::limit($book->subject, 45, '...') }}</p>

                            <button class="button btn-open-modal"
                                    data-id="{{ $book->id }}"
                                    data-title="{{ $book->title }}"
                                    data-author="{{ $book->author }}"
                                    data-subject="{{ $book->subject }}"
                                    data-category="{{ Str::title($book->category) }}"
                                    data-language="{{ ucfirst($book->language) }}"
                                    data-pages="{{ $book->pages }}"
                                    data-date="{{ $book->published_date }}"
                                    data-qty="{{ $book->quantity }}"
                                    data-location="{{ strtoupper($book->location) }}"
                                    data-image="{{ $book->image_url }}"
                                    data-fileurl="{{ $book->file_url ?? '' }}">
                                View Details
                            </button>
                        </article>
                        @endforeach
                    </div>

                    <div class="swiper-button-prev">
                        <i class="ri-arrow-left-s-line"></i>
                    </div>
                    <div class="swiper-button-next">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                </div>
            </div>
            @else
            <div class="container" style="text-align:center;padding:3rem 0;color:var(--text-color);">
                <i class="ri-book-2-line" style="font-size:3rem;display:block;margin-bottom:1rem;"></i>
                <p>No books in the catalog yet. Check back soon!</p>
            </div>
            @endif
        </section>

        <!--==================== Reading & Resources ====================-->
        <section class="reading section" id="reading">
            <div class="reading__container container grid">
                <div class="reading__data">
                    <h2 class="reading__title section__title">
                        Explore Books & Academic Resources
                    </h2>
                    <p class="reading__description">
                        បណ្ណាល័យអេឡិចត្រូនិចរបស់យើង ផ្តល់ជូនសៀវភៅ
                        និងឯកសារសិក្សាចម្រុះសម្រាប់គាំទ្រការសិក្សារបស់និស្សិត
                        ដូចជា សៀវភៅមេរៀន សៀវភៅយោង ឯកសារស្រាវជ្រាវ
                        និងនិក្ខេបបទរបស់និស្សិត។
                        នៅពេលដែលអ្នកមានគណនីនៅលើគេហទំព័រ E-Library
                        អ្នកអាចទាញយកសៀវភៅ និង និក្ខេបបទ បានគ្រប់ពេលវេលា។
                    </p>
                    <a href="{{ url('user/books') }}" class="button">ចូលមើលបណ្ណាល័យ</a>
                </div>
                <div class="reading__images">
                    <img src="{{ asset('assets/image/img_welcome/UPIfQXbxauV8mRr3FJEE0pZNLYbt5TNVFHG1AuQR.png') }}" alt="e-book" class="reading__img-1">
                    <img src="{{ asset('assets/image/img_welcome/2G4zkr8LboyVDN5C4xFs1PWO7eDVj9OTViY5vCBM.png') }}" alt="thesis" class="reading__img-2">
                </div>
            </div>
        </section>

        <!--==================== New Books ====================-->
        <section class="new section" id="new">
            <h2 class="section__title">New Books</h2>

            @if($newBooks->count() > 0)
            <div class="new__container container">
                <div class="new__swiper swiper">
                    <div class="swiper-wrapper">
                        @foreach($newBooks as $book)
                        <div class="new__card swiper-slide btn-open-modal"
                             style="cursor:pointer;"
                             data-id="{{ $book->id }}"
                             data-title="{{ $book->title }}"
                             data-author="{{ $book->author }}"
                             data-subject="{{ $book->subject }}"
                             data-category="{{ Str::title($book->category) }}"
                             data-language="{{ ucfirst($book->language) }}"
                             data-pages="{{ $book->pages }}"
                             data-date="{{ $book->published_date }}"
                             data-qty="{{ $book->quantity }}"
                             data-location="{{ strtoupper($book->location) }}"
                             data-image="{{ $book->image_url }}"
                             data-fileurl="{{ $book->file_url ?? '' }}">

                            <img src="{{ $book->image_url }}"
                                 alt="{{ $book->title }}"
                                 class="new__img"
                                 onerror="this.onerror=null;this.src='{{ asset('assets/images/default-book.svg') }}'">
                            <div>
                                <h2 class="new__title">{{ Str::limit($book->title, 35) }}</h2>
                                <p class="new__description">{{ Str::limit($book->subject, 40, '...') }}</p>
                                <div class="new__stars">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-half-fill"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="swiper-button-prev">
                        <i class="ri-arrow-left-s-line"></i>
                    </div>
                    <div class="swiper-button-next">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                </div>
            </div>
            @else
            <div class="container" style="text-align:center;padding:3rem 0;color:var(--text-color);">
                <i class="ri-book-marked-line" style="font-size:3rem;display:block;margin-bottom:1rem;"></i>
                <p>No new books yet.</p>
            </div>
            @endif
        </section>

        <!--==================== Join ====================-->
        <section class="join section">
            <div class="join__container">
                <img src="{{ asset('assets/image/img_welcome/banner-e-library.jpg') }}" alt="image" class="join_bg">
                <div class="join__data container grid">
                    <h2 class="join__title section__title">
                        ចុះឈ្មោះឥឡូវនេះ ដើម្បីទាញយកសៀវភៅ
                        និងនិក្ខេបបទ សម្រាប់ការសិក្សា និងស្រាវជ្រាវរបស់អ្នក។
                    </h2>
                    <a href="{{ url('registration') }}" class="button">ចុះឈ្មោះ</a>
                </div>
            </div>
        </section>

        <!--==================== Testimonial ====================-->
        <section class="testimonial section" id="testimonial">
            <h2 class="section__title">Student and Lecturer Opinions</h2>
            <div class="testimonial__container container">
                <div class="testimonial__swiper swiper">
                    <div class="swiper-wrapper">
                        <article class="testimonial__card swiper-slide">
                            <img src="{{ asset('assets/image/img_welcome/testimonial-perfil-1.png') }}" alt="image" class="testimonial__img">
                            <h2 class="testimonial__title">Bopha</h2>
                            <p class="testimonial__description">
                                ខ្ញុំចូលចិត្តប្រើប្រាស់ E-Library នេះ ព្រោះអាចចូលមើល
                                និងទាញយកសៀវភៅបានយ៉ាងរហ័ស និងងាយស្រួល។
                                វាជួយសន្សំពេលវេលា និងបង្កើនប្រសិទ្ធភាពការសិក្សា។
                            </p>
                            <div class="testimonial__starts">
                                <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
                            </div>
                        </article>
                        <article class="testimonial__card swiper-slide">
                            <img src="{{ asset('assets/image/img_welcome/testimonial-perfil-2.png') }}" alt="image" class="testimonial__img">
                            <h2 class="testimonial__title">Chamroeun</h2>
                            <p class="testimonial__description">
                                បណ្ណាល័យអេឡិចត្រូនិចនេះជួយឱ្យខ្ញុំស្វែងរកសៀវភៅ
                                និងនិក្ខេបបទបានយ៉ាងងាយស្រួល។ ខ្ញុំអាចទាញយកឯកសារ
                                សម្រាប់ការសិក្សា និងស្រាវជ្រាវបានគ្រប់ពេលវេលា។
                            </p>
                            <div class="testimonial__starts">
                                <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
                            </div>
                        </article>
                        <article class="testimonial__card swiper-slide">
                            <img src="{{ asset('assets/image/img_welcome/testimonial-perfil-3.png') }}" alt="image" class="testimonial__img">
                            <h2 class="testimonial__title">Chantha</h2>
                            <p class="testimonial__description">
                                ប្រព័ន្ធ E-Library មានភាពងាយស្រួលក្នុងការស្វែងរក
                                និងទាញយកឯកសារសិក្សា។ វាជាឧបករណ៍សំខាន់
                                ដែលគាំទ្រការសិក្សា និងស្រាវជ្រាវរបស់និស្សិត។
                            </p>
                            <div class="testimonial__starts">
                                <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
                            </div>
                        </article>
                        <article class="testimonial__card swiper-slide">
                            <img src="{{ asset('assets/image/img_welcome/testimonial-perfil-4.png') }}" alt="image" class="testimonial__img">
                            <h2 class="testimonial__title">Samnang</h2>
                            <p class="testimonial__description">
                                ខ្ញុំចូលចិត្តប្រើប្រាស់ E-Library នេះព្រោះអាចចូលមើល
                                និងទាញយកសៀវភៅបានយ៉ាងរហ័ស និងងាយស្រួល។
                            </p>
                            <div class="testimonial__starts">
                                <i class="ri-star-fill"></i><i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
                            </div>
                        </article>
                    </div>
                    <div class="swiper-button-prev"><i class="ri-arrow-left-s-line"></i></div>
                    <div class="swiper-button-next"><i class="ri-arrow-right-s-line"></i></div>
                </div>
            </div>
        </section>

    </main>

    <!--==================== Footer ====================-->
    <footer class="footer">
        <div class="footer__container container grid">
            <div>
                <a href="{{ route('home') }}" class="footer__logo">
                    <p>បណ្ណាល័យអេឡិចត្រូនិក <br><span>RPITST E-Library</span></p>
                </a>
                <p class="footer__description">
                    ស្វែងរក និងទាញយកសៀវភៅ ឯកសារសិក្សា <br>
                    និក្ខេបបទ ដើម្បីគាំទ្រដល់ការសិក្សា <br>
                    ស្រាវជ្រាវ ក្នុងការអភិវឌ្ឍចំណេះដឹងរបស់និស្សិត។
                </p>
            </div>
            <div class="footer__data grid">
                <div>
                    <h3 class="footer__title">អំពីបណ្ណាល័យ</h3>
                    <ul class="footer__links">
                        <li><a href="{{ route('home') }}" class="footer__link">អំពីយើង</a></li>
                        <li><a href="{{ url('user/books') }}" class="footer__link">ស្វែងរកសៀវភៅ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="footer__title">សេវាកម្ម</h3>
                    <ul class="footer__links">
                        <li><a href="{{ url('user/books') }}" class="footer__link">ស្វែងរកសៀវភៅ</a></li>
                        <li><a href="{{ url('user/books') }}?category=thesis" class="footer__link">និក្ខេបបទ</a></li>
                        <li><a href="{{ url('registration') }}" class="footer__link">ចុះឈ្មោះ</a></li>
                        <li><a href="{{ url('login') }}" class="footer__link">ចូលគណនី</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="footer__title">ទំនាក់ទំនង</h3>
                    <ul class="footer__links">
                        <li><address class="footer__info">Email : info@rpisvr.edu.kh</address></li>
                        <li><address class="footer__info">Phone : +855 953 2333</address></li>
                        <li>
                            <address class="footer__info">
                                ភូមិមេភ្លើង សង្កាត់ស្វាយរៀង ក្រុងស្វាយរៀង ខេត្តស្វាយរៀង
                            </address>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="footer__title">បណ្ដាញសង្គម</h3>
                    <div class="footer__social">
                        <a href="https://web.facebook.com/R.P.I.T.S.S.R" target="_blank" class="footer__socail-link">
                            <i class="ri-facebook-circle-fill"></i>
                        </a>
                        <a href="https://www.youtube.com/@RPITSSR" target="_blank" class="footer__socail-link">
                            <i class="ri-youtube-fill"></i>
                        </a>
                        <a href="https://t.me/+x8upPsGtNvsyZDQ1" target="_blank" class="footer__socail-link">
                            <i class="ri-telegram-2-fill"></i>
                        </a>
                        <a href="https://www.tiktok.com/@rpisvr" target="_blank" class="footer__socail-link">
                            <i class="ri-tiktok-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <span class="footer__copy">
            &#169; 2026 វិទ្យាស្ថានពហុបច្ចេកទេស ភូមិភាគតេជោសែន ស្វាយរៀង. រក្សាសិទ្ធិគ្រប់យ៉ាង។
        </span>
    </footer>

    <!--==================== Scroll Up ====================-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="ri-arrow-up-line"></i>
    </a>

    <!-- ==================== Book Detail Modal ==================== -->
    <div class="book-modal" id="bookModal">
        <div class="book-modal__overlay" id="modalOverlay"></div>
        <div class="book-modal__box">
            <button class="book-modal__close" id="modalClose" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
            <div class="book-modal__inner">
                <img id="modalCover" src="" alt="Book Cover" class="book-modal__cover">
                <div>
                    <h3 class="book-modal__title" id="modalTitle"></h3>
                    <p class="book-modal__author" id="modalAuthor"></p>
                    <table class="book-modal__table">
                        <tr><td>Subject</td><td id="modalSubject"></td></tr>
                        <tr><td>Category</td><td id="modalCategory"></td></tr>
                        <tr><td>Language</td><td id="modalLanguage"></td></tr>
                        <tr><td>Pages</td><td id="modalPages"></td></tr>
                        <tr><td>Published</td><td id="modalDate"></td></tr>
                        <tr><td>Qty Available</td><td id="modalQty"></td></tr>
                        <tr><td>Location</td><td id="modalLocation"></td></tr>
                    </table>
                    <div id="modalActions"></div>
                </div>
            </div>
        </div>
    </div>

    <!--==================== Scripts ====================-->
    <script src="{{ asset('assets/js/script_welcome/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('assets/js/script_welcome/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script_welcome/script.js') }}"></script>

    <script>
        // ─── Book Detail Modal ───────────────────────────────────────────
        const bookModal   = document.getElementById('bookModal');
        const modalClose  = document.getElementById('modalClose');
        const modalOverlay = document.getElementById('modalOverlay');

        // Pass auth state and base URL from Laravel
        const IS_AUTH = @json(Auth::check());
        const DOWNLOAD_BASE = '{{ url("user/books") }}';
        const LOGIN_URL = '{{ url("login") }}';

        function openModal(data) {
            document.getElementById('modalCover').src    = data.image   || '';
            document.getElementById('modalTitle').textContent  = data.title    || '-';
            document.getElementById('modalAuthor').textContent = data.author   || '-';
            document.getElementById('modalSubject').textContent  = data.subject  || '-';
            document.getElementById('modalCategory').textContent = data.category || '-';
            document.getElementById('modalLanguage').textContent = data.language || '-';
            document.getElementById('modalPages').textContent    = data.pages    || '-';
            document.getElementById('modalDate').textContent     = data.date     || '-';
            document.getElementById('modalQty').textContent      = data.qty      || '-';
            document.getElementById('modalLocation').textContent = data.location || '-';

            const actionsEl = document.getElementById('modalActions');
            const fileUrl = data.fileurl;

            if (fileUrl) {
                if (IS_AUTH) {
                    actionsEl.innerHTML =
                        `<a href="${DOWNLOAD_BASE}/${data.id}/download" class="book-modal__btn">
                            <i class="ri-download-2-line"></i> Download PDF
                        </a>`;
                } else {
                    actionsEl.innerHTML =
                        `<a href="${LOGIN_URL}" class="book-modal__btn book-modal__btn--outline">
                            <i class="ri-lock-line"></i> Login to Download PDF
                        </a>`;
                }
            } else {
                actionsEl.innerHTML =
                    `<span class="book-modal__nopdf"><i class="ri-file-damage-line"></i> No PDF available — visit the library to borrow this book.</span>`;
            }

            bookModal.classList.add('show-modal');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            bookModal.classList.remove('show-modal');
            document.body.style.overflow = '';
        }

        modalClose.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', closeModal);
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

        // Attach to all "View Details" buttons and new__card clicks
        document.querySelectorAll('.btn-open-modal').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                openModal({
                    id:       this.dataset.id,
                    title:    this.dataset.title,
                    author:   this.dataset.author,
                    subject:  this.dataset.subject,
                    category: this.dataset.category,
                    language: this.dataset.language,
                    pages:    this.dataset.pages,
                    date:     this.dataset.date,
                    qty:      this.dataset.qty,
                    location: this.dataset.location,
                    image:    this.dataset.image,
                    fileurl:  this.dataset.fileurl,
                });
            });
        });
    </script>
</body>
</html>
