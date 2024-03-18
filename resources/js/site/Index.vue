<template>
    <div>
        <Header></Header>

        <!-- ======= Hero Section ======= -->
        <section id="hero">
            <div
                id="heroCarousel"
                data-bs-interval="5000"
                class="carousel slide carousel-fade"
                data-bs-ride="carousel"
            >
                <ol
                    class="carousel-indicators"
                    id="hero-carousel-indicators"
                ></ol>

                <div class="carousel-inner" role="listbox">
                    <!-- Slide 1 -->
                    <div
                        class="carousel-item active"
                        style="
                            background-image: url(http://localhost:8000/site/assets/img/slide/slide-1.jpg);
                        "
                    >
                        <div class="carousel-container">
                            <div class="container">
                                <h5 class="mb-3">
                                    Making Boxes in All Shapes & Sizes
                                </h5>
                                <h2
                                    class="animate__animated animate__fadeInDown"
                                >
                                    Eco Friendly <span>Boxes</span>
                                </h2>
                                <p class="animate__animated animate__fadeInUp">
                                    Creative Boxes offer a wide range of custom
                                    packaging options. <br />
                                    Let us help you create the perfect packaging
                                    for your business.
                                </p>
                                <p class="animate__animated animate__fadeInUp">
                                    Contact us today for a free quote
                                </p>
                                <form class="d-flex" style="width: 40%">
                                    <input
                                        class="form-control"
                                        type="search"
                                        placeholder="Search product by name or category"
                                    />
                                    <button
                                        class="btn btn-search d-flex"
                                        type="submit"
                                    >
                                        <i class="bi bi-search me-2"></i>Search
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div
                        class="carousel-item"
                        style="
                            background-image: url(http://localhost:8000/site/assets/img/slide/slide-2.jpg);
                        "
                    >
                        <div class="carousel-container">
                            <div class="container">
                                <h5 class="mb-3">
                                    Making Boxes in All Shapes & Sizes
                                </h5>
                                <h2
                                    class="animate__animated animate__fadeInDown"
                                >
                                    Eco Friendly <span>Boxes</span>
                                </h2>
                                <p class="animate__animated animate__fadeInUp">
                                    Creative Boxes offer a wide range of custom
                                    packaging options. <br />
                                    Let us help you create the perfect packaging
                                    for your business.
                                </p>
                                <p class="animate__animated animate__fadeInUp">
                                    Contact us today for a free quote
                                </p>
                                <form class="d-flex" style="width: 40%">
                                    <input
                                        class="form-control"
                                        type="search"
                                        placeholder="Search product by name or category"
                                    />
                                    <button
                                        class="btn btn-search d-flex"
                                        type="submit"
                                    >
                                        <i class="bi bi-search me-2"></i>Search
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div
                        class="carousel-item"
                        style="
                            background-image: url(http://localhost:8000/site/assets/img/slide/slide-3.jpg);
                        "
                    >
                        <div class="carousel-container">
                            <div class="container">
                                <h5 class="mb-3">
                                    Making Boxes in All Shapes & Sizes
                                </h5>
                                <h2
                                    class="animate__animated animate__fadeInDown"
                                >
                                    Eco Friendly <span>Boxes</span>
                                </h2>
                                <p class="animate__animated animate__fadeInUp">
                                    Creative Boxes offer a wide range of custom
                                    packaging options. <br />
                                    Let us help you create the perfect packaging
                                    for your business.
                                </p>
                                <p class="animate__animated animate__fadeInUp">
                                    Contact us today for a free quote
                                </p>
                                <form class="d-flex" style="width: 40%">
                                    <input
                                        class="form-control"
                                        type="search"
                                        placeholder="Search product by name or category"
                                    />
                                    <button
                                        class="btn btn-search d-flex"
                                        type="submit"
                                    >
                                        <i class="bi bi-search me-2"></i>Search
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <a
                    class="carousel-control-prev"
                    href="#heroCarousel"
                    role="button"
                    data-bs-slide="prev"
                >
                    <span
                        class="carousel-control-prev-icon bi bi-chevron-left"
                        aria-hidden="true"
                    ></span>
                </a>

                <a
                    class="carousel-control-next"
                    href="#heroCarousel"
                    role="button"
                    data-bs-slide="next"
                >
                    <span
                        class="carousel-control-next-icon bi bi-chevron-right"
                        aria-hidden="true"
                    ></span>
                </a>
            </div>
        </section>
        <!-- End Hero -->

        <main id="main" style="overflow-x: hidden">
            <!-- ======= About Us Section ======= -->
            <section id="about" class="about">
                <div class="container">
                    <div class="section-title">
                        <p class="mb-2">Making Boxes in All Shapes & Sizes.</p>
                        <h2>Your Custom Packging Partner</h2>
                    </div>

                    <div class="row">
                        <div
                            class="col-lg-3"
                            v-for="(box, index) in custom_boxes"
                            :key="index"
                        >
                            <div class="card rounded-0">
                                <img
                                    :src="'/storage/thumb/' + box.picture_0"
                                    alt="..."
                                />

                                <router-link
                                    :to="{
                                        name: 'view-product',
                                        params: {
                                            product: box.url,
                                        },
                                    }"
                                    class="product-detail"
                                >
                                    View Details
                                </router-link>
                            </div>
                            <p class="text-center mt-3">{{ box.name }}</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End About Us Section -->
            <!-- ======= Our Clients Section ======= -->
            <section id="clients" class="clients">
                <div class="container">
                    <div class="section-title">
                        <p class="mb-2">Making Boxes in All Shapes & Sizes.</p>
                        <h2>One Plateform For All Solutions</h2>
                        <p>
                            Creative Boxes offer a wide range of custom
                            packaging options. Let us help <br />
                            you create the perfect packaging for your business.
                        </p>
                    </div>
                </div>

                <div class="container">
                    <div class="row mt-3 mb-5">
                        <div class="col-md-2">
                            <img
                                src="site/assets/img/icons/1.svg"
                                alt="logo-1"
                                style="display: block; margin: auto"
                            />
                            <p class="text-center mt-3">Quick Turnaround</p>
                        </div>
                        <div class="col-md-2">
                            <img
                                src="site/assets/img/icons/2.svg"
                                alt="logo-1"
                                style="display: block; margin: auto"
                            />
                            <p class="text-center mt-3">Custom Style & Size</p>
                        </div>
                        <div class="col-md-2">
                            <img
                                src="site/assets/img/icons/3.svg"
                                alt="logo-1"
                                style="display: block; margin: auto"
                            />
                            <p class="text-center mt-3">
                                No Die & Pallet Charges
                            </p>
                        </div>
                        <div class="col-md-2">
                            <img
                                src="site/assets/img/icons/4.svg"
                                alt="logo-1"
                                style="display: block; margin: auto"
                            />
                            <p class="text-center mt-3">Free Shipping</p>
                        </div>
                        <div class="col-md-2">
                            <img
                                src="site/assets/img/icons/5.svg"
                                alt="logo-1"
                                style="display: block; margin: auto"
                            />
                            <p class="text-center mt-3">
                                Environmentally Responsible
                            </p>
                        </div>
                        <div class="col-md-2">
                            <img
                                src="site/assets/img/icons/6.svg"
                                alt="logo-1"
                                style="display: block; margin: auto"
                            />
                            <p class="text-center mt-3">
                                High QualityOffset Printing
                            </p>
                        </div>
                    </div>
                </div>

                <div style="background-color: #f2f3eb">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6" style="position: relative">
                                <div
                                    style="
                                        position: absolute;
                                        top: 50%;
                                        transform: translate(0px, -50%);
                                    "
                                >
                                    <p>Making Boxes in All Shapes & Sizes.</p>
                                    <h2>EXCELLENCE IN CUSTOM</h2>
                                    <h2>BOXED WITH LOGO</h2>
                                    <button
                                        class="btn btn-quote rounded-0 me-3"
                                    >
                                        Get Quote
                                    </button>
                                    <a
                                        href="./Products.html"
                                        class="btn btn-outline-success rounded-0"
                                    >
                                        Boxes By Styles</a
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img
                                    src="site/assets/img/at3.png"
                                    class="img-fluid"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Our Clients Section -->

            <!-- ======= Our Clients Section ======= -->
            <section id="clients" class="clients">
                <div class="container">
                    <div class="section-title">
                        <p class="mb-3">Making Boxes in All Shapes & Sizes.</p>
                        <h2>CUSTOM ADD-ONS</h2>
                        <p>
                            Customize the box sleeves from our wide range of
                            materials and finishes. Can’t find what you are
                            looking for? No Worries, <br />
                            Reach out to submit a request for your personalized
                            box sleeves.
                        </p>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card rounded-0">
                                        <img
                                            src="site/assets/img/ad_ons/Gold Foil.jpg"
                                            alt="..."
                                        />
                                        <h4>Gloss</h4>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="card rounded-0">
                                        <img
                                            src="site/assets/img/ad_ons/Gold Foil.jpg"
                                            alt="..."
                                        />
                                        <h4>Holographic</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card rounded-0">
                                <img
                                    src="site/assets/img/ad_ons/Matt.jpg"
                                    alt="..."
                                />
                                <h4>Matt</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card rounded-0">
                                        <img
                                            src="site/assets/img/ad_ons/Gold Foil.jpg"
                                            alt="..."
                                        />
                                        <h4>Soft Touch</h4>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="card rounded-0">
                                        <img
                                            src="site/assets/img/ad_ons/Gold Foil.jpg"
                                            alt="..."
                                        />
                                        <h4>Gold Foil</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Our Clients Section -->

            <!-- ======= One Platform Section ======= -->
            <section id="platform" class="platform">
                <div
                    class=""
                    style="
                        margin-right: unset !important;
                        margin-left: 5% !important;
                    "
                >
                    <div class="section-title">
                        <p class="mb-2 sub-head">
                            Making Boxes in All Shapes & Sizes.
                        </p>
                        <h2>One Platform For All Solutions</h2>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="slider">
                                <div class="slide-track">
                                    <div class="slide">
                                        <div
                                            class="bg-image card shadow-1-strong m-3"
                                            style="
                                                background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/003.webp');
                                            "
                                        >
                                            <div
                                                class="card-body text-white p-4"
                                            >
                                                <h5 class="card-title mt-2">
                                                    Save Time
                                                </h5>
                                                <p class="card-text mt-3">
                                                    Customize the box sleeves
                                                    from our wide range of
                                                    materials and finishes.
                                                    Can’t find what you are
                                                    looking for? No Worries,
                                                    Reach out to submit a
                                                    request for your
                                                    personalized box sleeves
                                                </p>
                                                <p>
                                                    Creative Boxes is an
                                                    emerging custom boxes
                                                    manufacturer based in the
                                                    UK. We aim to provide one
                                                    platform to meet all custom
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div
                                            class="bg-image card shadow-1-strong m-3"
                                            style="
                                                background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/003.webp');
                                            "
                                        >
                                            <div
                                                class="card-body text-white p-4"
                                            >
                                                <h5 class="card-title mt-2">
                                                    Save Time
                                                </h5>
                                                <p class="card-text mt-3">
                                                    Customize the box sleeves
                                                    from our wide range of
                                                    materials and finishes.
                                                    Can’t find what you are
                                                    looking for? No Worries,
                                                    Reach out to submit a
                                                    request for your
                                                    personalized box sleeves
                                                </p>
                                                <p>
                                                    Creative Boxes is an
                                                    emerging custom boxes
                                                    manufacturer based in the
                                                    UK. We aim to provide one
                                                    platform to meet all custom
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div
                                            class="bg-image card shadow-1-strong m-3"
                                            style="
                                                background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/003.webp');
                                            "
                                        >
                                            <div
                                                class="card-body text-white p-4"
                                            >
                                                <h5 class="card-title mt-2">
                                                    Save Time
                                                </h5>
                                                <p class="card-text mt-3">
                                                    Customize the box sleeves
                                                    from our wide range of
                                                    materials and finishes.
                                                    Can’t find what you are
                                                    looking for? No Worries,
                                                    Reach out to submit a
                                                    request for your
                                                    personalized box sleeves
                                                </p>
                                                <p>
                                                    Creative Boxes is an
                                                    emerging custom boxes
                                                    manufacturer based in the
                                                    UK. We aim to provide one
                                                    platform to meet all custom
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div
                                            class="bg-image card shadow-1-strong m-3"
                                            style="
                                                background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/003.webp');
                                            "
                                        >
                                            <div
                                                class="card-body text-white p-4"
                                            >
                                                <h5 class="card-title mt-2">
                                                    Save Time
                                                </h5>
                                                <p class="card-text mt-3">
                                                    Customize the box sleeves
                                                    from our wide range of
                                                    materials and finishes.
                                                    Can’t find what you are
                                                    looking for? No Worries,
                                                    Reach out to submit a
                                                    request for your
                                                    personalized box sleeves
                                                </p>
                                                <p>
                                                    Creative Boxes is an
                                                    emerging custom boxes
                                                    manufacturer based in the
                                                    UK. We aim to provide one
                                                    platform to meet all custom
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div
                                            class="bg-image card shadow-1-strong m-3"
                                            style="
                                                background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/003.webp');
                                            "
                                        >
                                            <div
                                                class="card-body text-white p-4"
                                            >
                                                <h5 class="card-title mt-2">
                                                    Save Time
                                                </h5>
                                                <p class="card-text mt-3">
                                                    Customize the box sleeves
                                                    from our wide range of
                                                    materials and finishes.
                                                    Can’t find what you are
                                                    looking for? No Worries,
                                                    Reach out to submit a
                                                    request for your
                                                    personalized box sleeves
                                                </p>
                                                <p>
                                                    Creative Boxes is an
                                                    emerging custom boxes
                                                    manufacturer based in the
                                                    UK. We aim to provide one
                                                    platform to meet all custom
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div
                                            class="bg-image card shadow-1-strong m-3"
                                            style="
                                                background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/003.webp');
                                            "
                                        >
                                            <div
                                                class="card-body text-white p-4"
                                            >
                                                <h5 class="card-title mt-2">
                                                    Save Time
                                                </h5>
                                                <p class="card-text mt-3">
                                                    Customize the box sleeves
                                                    from our wide range of
                                                    materials and finishes.
                                                    Can’t find what you are
                                                    looking for? No Worries,
                                                    Reach out to submit a
                                                    request for your
                                                    personalized box sleeves
                                                </p>
                                                <p>
                                                    Creative Boxes is an
                                                    emerging custom boxes
                                                    manufacturer based in the
                                                    UK. We aim to provide one
                                                    platform to meet all custom
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End One Platform Section -->

            <!-- ======= Our Clients Section ======= -->
            <section id="clients" class="clients">
                <div class="container">
                    <div class="section-title">
                        <h5 class="mb-3">Making Boxes in All Shapes & Sizes</h5>
                        <h2 style="text-transform: unset">
                            Let's take you out of the box
                        </h2>
                        <p>
                            Customize the box sleeves from our wide range of
                            materials and finishes. <br />
                            Can’t find what you are looking for?
                        </p>
                    </div>

                    <div class="player">
                        <img
                            src="site/assets/img/video.png"
                            class="img-responsive"
                            style="
                                display: block;
                                margin: auto;
                                width: 60%;
                                height: 60%;
                            "
                        />
                    </div>

                    <img
                        src="site/assets/img/map.svg"
                        class="img-responsive"
                        style="display: block; margin: auto"
                    />
                </div>
            </section>
            <!-- End Our Clients Section -->

            <section class="index-contact" style="background-color: #f2f3eb">
                <div>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="info-graphic">
                                    <img
                                        src="site/assets/img/what-make-us-difference.svg"
                                        class="img-fluid"
                                    />
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <h5>Market Comparison</h5>
                                <h1 class="mb-3">Get Instant Quote</h1>
                                <form
                                    @submit.prevent="instantQoute"
                                    @keydown="form.onKeydown($event)"
                                >
                                    <div class="row">
                                        <label
                                            for="exampleInput1"
                                            class="form-label"
                                            >Size</label
                                        >
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-3"
                                        >
                                            <div class="mb-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput1"
                                                    placeholder="length"
                                                    v-model="form.length"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-3"
                                        >
                                            <div class="mb-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput2"
                                                    placeholder="width"
                                                    v-model="form.width"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-3"
                                        >
                                            <div class="mb-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput3"
                                                    placeholder="height"
                                                    v-model="form.height"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-6 col-lg-3"
                                        >
                                            <div class="mb-4">
                                                <select
                                                    class="form-select change-select-color"
                                                    aria-label="Default select example"
                                                    v-model="form.size"
                                                    style="
                                                        background-color: rgb(
                                                            214,
                                                            140,
                                                            69
                                                        );
                                                    "
                                                >
                                                    <option selected value="in">
                                                        In
                                                    </option>
                                                    <option value="cm">
                                                        cm
                                                    </option>
                                                    <option value="mm">
                                                        mm
                                                    </option>
                                                    <option value="ml">
                                                        ml
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <label
                                            for="exampleInput1"
                                            class="form-label"
                                            >Quantity</label
                                        >
                                        <div
                                            class="col-sm-12 col-md-4 col-lg-4"
                                        >
                                            <div class="mb-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput4"
                                                    placeholder="Qty"
                                                    v-model="form.Qty"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-4 col-lg-4"
                                        >
                                            <div class="mb-4">
                                                <select
                                                    class="form-select"
                                                    aria-label="Default select example"
                                                    v-model="form.color"
                                                >
                                                    <option selected>
                                                        Select Color
                                                    </option>
                                                    <option value="blue">
                                                        Blue
                                                    </option>
                                                    <option value="green">
                                                        Green
                                                    </option>
                                                    <option value="red">
                                                        Red
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-4 col-lg-4"
                                        >
                                            <div class="mb-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput5"
                                                    placeholder="Product Name"
                                                    v-model="form.product_name"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-4 col-lg-4"
                                        >
                                            <div class="mb-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput6"
                                                    placeholder="Computer Name"
                                                    v-model="form.computer_name"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-4 col-lg-4"
                                        >
                                            <div class="mb-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput7"
                                                    placeholder="Phone"
                                                    v-model="form.phone"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-4 col-lg-4"
                                        >
                                            <div class="mb-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput8"
                                                    placeholder="E-mail Address"
                                                    v-model="form.email"
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-12 col-lg-12"
                                        >
                                            <div class="mb-4">
                                                <textarea
                                                    class="form-control"
                                                    id="exampleFormControlTextarea1"
                                                    rows="5"
                                                    placeholder="Write a short message"
                                                    v-model="form.message"
                                                ></textarea>
                                            </div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-12 col-lg-6"
                                        >
                                            <div class="mb-4 d-flex">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput9"
                                                    placeholder="6"
                                                    :value="randomNumber1"
                                                    ref="num1Input"
                                                />
                                                <span
                                                    style="
                                                        padding: 5px;
                                                        font-size: 24px;
                                                    "
                                                    >+</span
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput10"
                                                    placeholder="5"
                                                    :value="randomNumber2"
                                                    ref="num2Input"
                                                />
                                                <span
                                                    style="
                                                        padding: 5px;
                                                        font-size: 24px;
                                                    "
                                                    >=</span
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="exampleInput9"
                                                    placeholder="Ans"
                                                    v-model="sum"
                                                    ref="num3Input"
                                                />
                                            </div>
                                            Verify if you're human
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-12 col-lg-6"
                                        >
                                            <button>Submit Now</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======= Single Product Similar ======= -->

            <section class="single-product-similar">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center">
                                Making Boxes in All Shapes & Sizes
                            </h5>
                            <h1 class="mb-5">Latest Products & Trends</h1>
                            <div
                                id="customer-product-carousel"
                                class="carousel slide"
                                data-bs-ride="carousel"
                            >
                                <div class="carousel-inner">
                                    <div
                                        v-for="(boxGroup, index) in splitBoxes"
                                        :key="index"
                                        :class="
                                            index == 0
                                                ? 'carousel-item active'
                                                : 'carousel-item'
                                        "
                                    >
                                        <div class="container">
                                            <div class="row">
                                                <div
                                                    class="col-sm-12 col-md-6 col-lg-3"
                                                    v-for="(
                                                        box, boxIndex
                                                    ) in boxGroup"
                                                    :key="boxIndex"
                                                >
                                                    <div class="card rounded-0">
                                                        <img
                                                            :src="
                                                                '/storage/thumb/' +
                                                                box.picture_0
                                                            "
                                                        />
                                                        <router-link
                                                            :to="{
                                                                name: 'view-product',
                                                                params: {
                                                                    product:
                                                                        box.url,
                                                                },
                                                            }"
                                                            class="product-detail"
                                                        >
                                                            View Details
                                                        </router-link>
                                                    </div>
                                                    <p
                                                        class="text-center product-head mt-3"
                                                    >
                                                        {{ box.name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    class="carousel-control-prev"
                                    type="button"
                                    data-bs-target="#customer-product-carousel"
                                    data-bs-slide="prev"
                                >
                                    <span
                                        class="carousel-control-prev-icon"
                                        aria-hidden="true"
                                    ></span>
                                    <span class="visually-hidden"
                                        >Previous</span
                                    >
                                </button>
                                <button
                                    class="carousel-control-next"
                                    type="button"
                                    data-bs-target="#customer-product-carousel"
                                    data-bs-slide="next"
                                >
                                    <span
                                        class="carousel-control-next-icon"
                                        aria-hidden="true"
                                    ></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- ======= End Single Product Similar ======= -->
        </main>
        <!-- End #main -->

        <Footer></Footer>
    </div>
</template>

<script>
import Header from "../site/Header.vue";
import Footer from "../site/Footer.vue";
export default {
    data: () => ({
        boxes: [],
        custom_boxes: [],
        randomNumber1: null,
        randomNumber2: null,
        sum: "",
        form: new Form({
            length: null,
            width: null,
            height: null,
            size: "In",
            Qty: "",
            color: "blue",
            product_name: "",
            computer_name: null,
            phone: null,
            email: null,
            message: null,
        }),
    }),
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        generateRandomNumber() {
            // Generate a random number between 1 and 100 (you can adjust the range as needed)
            return Math.floor(Math.random() * 100) + 1;
        },
        getCategories() {
            axios
                .post("api/custom-boxes")
                .then((response) => {
                    this.boxes = response.data.slider;
                    this.custom_boxes = response.data.custom_boxes;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        async instantQoute() {
            const num1 = parseInt(this.$refs.num1Input.value);
            const num2 = parseInt(this.$refs.num2Input.value);
            const userAnswer = parseInt(this.$refs.num3Input.value);
            if (num1 + num2 != userAnswer) {
                // If the answer is correct, call the instantQoute method to submit the form
                alert("Incorrect answer. Please try again.");
                return false;
            }
            const response = await this.form
                .post("/api/instantqoute")
                .then((response) => {
                    // Handle successful response
                    // console.log("File uploaded successfully:", response.data);
                    // Additional logic here
                    this.form.clear();
                    this.form.reset();
                    this.randomNumber1 = this.generateRandomNumber();
                    this.randomNumber2 = this.generateRandomNumber();
                    this.sum = null;
                    Swal.fire({
                        icon: "success",
                        title: "Request Process!",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                })
                .catch((error) => {
                    // Handle error response
                    console.error("File upload failed:", error.response.data);
                    Swal.fire({
                        icon: "error",
                        title: error.response.data.message,
                        showConfirmButton: false,
                        timer: 2500,
                    });
                });
        },
    },
    mounted() {},
    created() {
        this.getCategories();
        this.randomNumber1 = this.generateRandomNumber();
        this.randomNumber2 = this.generateRandomNumber();
    },
    computed: {
        splitBoxes() {
            const groupSize = 4;
            const splitArray = [];
            let currentIndex = 0;

            while (currentIndex < this.boxes.length) {
                splitArray.push(
                    this.boxes.slice(currentIndex, currentIndex + groupSize)
                );
                currentIndex += groupSize;
            }

            return splitArray;
        },
    },

    components: {
        Header,
        Footer,
    },

    watch: {},
};
</script>
