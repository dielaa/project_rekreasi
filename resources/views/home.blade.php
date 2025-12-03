@extends('templates.app')

@section('content')
    <div id="intro-example" class="p-5 text-center bg-image"
      style="background-image: url('https://i.pinimg.com/1200x/92/00/1b/92001b5c2108b12d0a474ca8d0e77529.jpg');">
      <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
        <div class="d-flex justify-content-center align-items-center h-100">
          <div class="text-white">
            <h1 class="mb-3">Welcome To Sea World Ancol</h1>
            <p>Dive into Wonder. Walk Through the Heart of the Sea.</p>
            <h5 class="mb-4"></h5>
          </div>
        </div>
      </div>
    </div>
  <div class="content-wrapper">
    <h2>About Sea World</h2>
    <p>Dive into a world of underwater wonder at Sea World Ancol, Jakarta's legendary marine edutainment destination. With
      over 18,000 aquatic creatures from freshwater and saltwater habitats, Sea World blends education, conservation, and
      entertainment into one unforgettable experience.
      Whether you're here to learn, explore, or simply be amazed, Sea World offers immersive attractions that bring the
      ocean to life.
    </p>
    <br />
    <section class="mb-5">
      <div class="row gx-lg-5">
        <h2 style="text-align: center; margin-bottom: 1rem;">Our Highlights</h2>
        <div class="col-lg-6 mb-5">
          <div class="d-flex align-items-start">
            <div class="flex-shrink-0">
              <div class="p-2 badge-primary rounded-4">
                <img src="https://i.pinimg.com/1200x/51/dd/f2/51ddf2da86da7b941d73cbce30646c3a.jpg" alt="App Image"
                  style="width: 100px; height: 100px;">
              </div>
            </div>
            <div class="flex-grow-1 ms-4">
              <p class="fw-bold mb-1">Antasena Tunne</p>
              <p class="text-muted mb-1">
                Step into the heart of the ocean through the Antasena Tunnel a massive walk through aquarium holding five
                million liters of seawater. Surrounded by hundreds of marine species, you'll feel like you're strolling
                along the ocean floor
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-5">
          <div class="d-flex align-items-start">
            <div class="flex-shrink-0">
              <div class="p-2 badge-primary rounded-4">
                <img src="https://i.pinimg.com/1200x/a3/cc/18/a3cc186efed9ab8e3c9cd97f3f7ce310.jpg" alt="App Image"
                  style="width: 100px; height: 100px;">
              </div>
            </div>
            <div class="flex-grow-1 ms-4">
              <p class="fw-bold mb-1">Shark Aquarium</p>
              <p class="text-muted mb-1">
                Get up close with the ocean's most iconic predators. The Shark Aquarium features blacktip reef sharks,
                hammerheads, and lion sharks in a safe, awe-inspiring environment. </p>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-5">
          <div class="d-flex align-items-start">
            <div class="flex-shrink-0">
              <div class="p-2 badge-primary rounded-4">
                <img
                  src="https://awsimages.detik.net.id/community/media/visual/2021/02/04/dev-misteri-kehidupan-dunia-laut-di-seaworld.jpeg?w=600&q=90"
                  alt="App Image" style="width: 100px; height: 100px;">
              </div>
            </div>
            <div class="flex-grow-1 ms-4">
              <p class="fw-bold mb-1">Deep Sea Museum</p>
              <p class="text-muted mb-1">
                Discover ocean mysteries at the Deep Sea Museum, featuring preserved specimens and rare creatures like the
                ancient Coelacanth. A quiet, fascinating space where science meets storytelling for curious minds of all
                ages. </p>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-5">
          <div class="d-flex align-items-start">
            <div class="flex-shrink-0">
              <div class="p-2 badge-primary rounded-4">
                <img
                  src="https://www.ancol.com/shared/file-manager/Unit%20Informasi/SEA%20WORLD/SEA-WORLD---DIGITAL-GALLERY.jpg"
                  alt="App Image" style="width: 100px; height: 100px;">
              </div>
            </div>
            <div class="flex-grow-1 ms-4">
              <p class="fw-bold mb-1"> Digital Gallery</p>
              <p class="text-muted mb-1">
                Explore marine life with Sea World's Digital Gallery. Scan QR codes to unlock fun facts, species profiles,
                videos, and conservation tips making it a modern, interactive way to learn while you explore.
              </p>
            </div>
          </div>
        </div>
      </div>
      <hr class="my-5" />
        <h2 style="text-align: center;">Our Vision, Mission, and Goals</h2>
        <p>SeaWorld aims to introduce the public to freshwater and marine ecosystems in an innovative and interactive way,
          contribute to the preservation of marine species through education and rehabilitation programs, and provide
          high-quality recreational experiences that combine fun and learning</p>
        <br />
        <div style="display: flex; justify-content: center; gap: 40px;">
          <div style="flex: 1; padding-right: 20px; border-right: 2px solid #ccc;">
            <h2>Vision</h2>
            <ul>
              <li>Provide an engaging and educational experience about aquatic life for dateors of all ages.</li>
              <li>Support marine conservation through rehabilitation programs and awareness campaigns.</li>
              <li>Foster appreciation for biodiversity and environmental stewardship.</li>
            </ul>
          </div>
          <div style="flex: 1; padding-left: 20px;">
            <h2 style="display: flex;">Mission</h2>
            <ul>
              <li>Introduce the public to freshwater and marine ecosystems in an innovative way.</li>
              <li>Contribute to the preservatinoton of marine species through education and rehabilitation programs.</li>
              <li>Provide high-quality recreational experiences that combine fun and learning.</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="container my-5">
        <div class="row gx-lg-5">
          <h2 style="text-align: center;">Map and Location Section</h2>
          <p style="text-align: center;">Find Sea World Ancol at Jl. Lodan Timur No.7, North Jakarta. Use the map below to
            get directions. </p>
          <div class="map-container justify-content-center" style="text-align: center;">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.0337686208613!2d106.84023502498947!3d-6.1261581938605705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a1e22b8ad5c1b%3A0x8eea0c4c3f8cb410!2sSea%20World%20Indonesia!5e0!3m2!1sid!2sid!4v1756652260680!5m2!1sid!2sid"
              width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <p style="text-align: center;">Curious about what's around? <a href="https://www.ancol.com/peta"
              target="_blank">Check out the interactive map of Ancol</a> to explore the full park layout.</p>
        </div>
      </div>
  </div>
  </section>
@endsection