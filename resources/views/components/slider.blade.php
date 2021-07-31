<div class="row">
    <div class="col text-center mx-5 mt-2 mb-3 fs-3 py-2
                border border-2 border-success border-radius"
         style="background-color: rgb(183, 255, 0);
                background-image: linear-gradient(to right, rgb(18, 255, 18), rgb(183, 255, 0));
                border-radius: 15px;">Galeria</div>
</div>

<div class="row">
    <div class="col-2"></div>
    <div id="carouselExampleIndicators" class="carousel slide col-8" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('images/slider-images/image1.jpg') }}" class="d-block w-100 slide" alt="">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/slider-images/image2.jpg') }}" class="d-block w-100 slide" alt="">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/slider-images/image3.jpg') }}" class="d-block w-100 slide" alt="">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/slider-images/image4.jpg') }}" class="d-block w-100 slide" alt="">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="col-2"></div>
</div>
