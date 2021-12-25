<div class="row">
    <div id="carouselIndicators" class="col-12 col-sm-10 col-md-10 col-lg-8
                                        carousel slide mx-auto" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
        </div>
        <div class="carousel-inner border border-2">

            <div class="carousel-item active">
                <img alt="Zdjęcie z gry #1" src="{{ asset('assets/images/slider_images/image1.jpg') }}" class="d-block w-100 slide">
            </div>

            <div class="carousel-item">
                <img alt="Zdjęcie z gry #2" src="{{ asset('assets/images/slider_images/image2.jpg') }}" class="d-block w-100 slide">
            </div>

            <div class="carousel-item">
                <img alt="Zdjęcie z gry #3" src="{{ asset('assets/images/slider_images/image3.jpg') }}" class="d-block w-100 slide">
            </div>

            <div class="carousel-item">
                <img alt="Zdjęcie z gry #4" src="{{ asset('assets/images/slider_images/image4.jpg') }}" class="d-block w-100 slide">
            </div>

            <div class="carousel-item">
                <img alt="Zdjęcie z gry #5" src="{{ asset('assets/images/slider_images/image5.jpg') }}" class="d-block w-100 slide">
            </div>

            <div class="carousel-item">
                <img alt="Zdjęcie z gry #6" src="{{ asset('assets/images/slider_images/image6.jpg') }}" class="d-block w-100 slide">
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
