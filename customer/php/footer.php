 <!-- Footer-->
 <footer class="position-relative z-index-10 d-print-none shadow-soft border-light  bg-white">
    <!-- Main block - menus, subscribe form-->
    <div class="py-6  text-muted bg-white">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
            <div class="fw-bold text-uppercase text-dark mb-3">Portal</div>            
          </div>
          <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
            <h6 class="text-uppercase text-dark mb-3">Links</h6>
            <ul class="list-unstyled">
              <li><a class="text-muted" href="../">Home</a></li>
              <li><a class="text-muted" href="../php/logout.php">Sign out</a></li>
              <li><a class="text-muted" href="reservations.php">Reservations</a></li>
              <li><a class="text-muted" href="settings.php">Settings</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Copyright section of the footer-->
    <div class="py-4 fw-light bg-primary text-gray-300">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 text-center text-md-start">
            <p class="text-sm mb-md-0">&copy; 2021, All rights reserved.</p>
          </div>
          <div class="col-md-6">
            <ul class="list-inline mb-0 mt-2 mt-md-0 text-center text-md-end">
              <!-- <li class="list-inline-item"><img class="w-2rem" src="../../../assets/img/brand/visa.svg" alt="..."></li>
              <li class="list-inline-item"><img class="w-2rem" src="../../../assets/img/brand//mastercard.svg" alt="...">
              </li>
              <li class="list-inline-item"><img class="w-2rem" src="../../../assets/img/brand/paypal.svg" alt="..."></li>
              <li class="list-inline-item"><img class="w-2rem" src="../../../assets/img/brand/western-union.svg" alt="...">
              </li> -->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- JavaScript files-->
  <script>
    // ------------------------------------------------------- //
    //   Inject SVG Sprite - 
    //   see more here 
    //   https://css-tricks.com/ajaxing-svg-sprite/
    // ------------------------------------------------------ //
    function injectSvgSprite(path) {

      var ajax = new XMLHttpRequest();
      ajax.open("GET", path, true);
      ajax.send();
      ajax.onload = function (e) {
        var div = document.createElement("div");
        div.className = 'd-none';
        div.innerHTML = ajax.responseText;
        document.body.insertBefore(div, document.body.childNodes[0]);
      }
    }
    // to avoid CORS issues when viewing using file:// protocol, using the demo URL for the SVG sprite
    // use your own URL in production, please :)
    // https://demo.bootstrapious.com/directory/1-0/icons/orion-svg-sprite.svg
    //- injectSvgSprite('${path}icons/orion-svg-sprite.svg'); 
    injectSvgSprite('https://demo.bootstrapious.com/directory/1-4/icons/orion-svg-sprite.svg');
  </script>
  <!-- jQuery-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <!-- Bootstrap JS bundle - Bootstrap + PopperJS-->
  <script src="../vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Magnific Popup - Lightbox for the gallery-->
  <script src="../vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
  <!-- Smooth scroll-->
  <script src="../vendor/smooth-scroll/dist/smooth-scroll.min.js"></script>
  <!-- Bootstrap Select-->
  <script src="../vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
  <!-- Object Fit Images - Fallback for browsers that don't support object-fit-->
  <script src="../vendor/object-fit-images/ofi.min.js"></script>
  <!-- Swiper Carousel                       -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.min.js"></script>
  <script>
    var basePath = ''
  </script>
  <!-- Main Theme JS file    -->
  <script src="../../assets/js/theme.js"></script>
  <!-- Map-->
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>

  <!-- Available tile layers-->
  <script src="../assets/js/map-detail.js"> </script>
<script src="../assets/js/map-category.js"> </script>
  <!-- Daterange picker-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"> </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-date-range-picker/0.19.0/jquery.daterangepicker.min.js"></script>
  <script src="../assets/js/datepicker-category.js"> </script>
  <!-- Price Slider-->
  <script src="../vendor/nouislider/dist/nouislider.min.js"></script>
  <script>
    var snapSlider = document.getElementById('slider-snap');
    min = 40, max = 300
    noUiSlider.create(snapSlider, {
      start: [min, max],
      snap: false,
      connect: true,
      step: 1,
      range: {
        <?php
                $greatestquery = "SELECT GREATEST(MAX(priceStandard),MAX(priceQueen),MAX(priceKing)) FROM hotel.hotel";
                $leastquery = "SELECT LEAST(MIN(priceStandard),MIN(priceQueen),MIN(priceKing)) FROM hotel.hotel";
                $greatestresult = $conn->query($greatestquery);
                $leastresult=$conn->query($leastquery);
                if($greatestresult){
                  $greatest = $greatestresult->fetch_row();
                }
                if($leastresult){
                  $least = $leastresult->fetch_row();
                }
                
                
        ?>
        
        'min':<?php
        if(isset($least)){
          echo $least[0];
        }else{
          echo "40";
        }
         
         ?>,
        'max':<?php 
        if(isset($greatest)){
          echo $greatest[0];
        }else{
          echo "500";
        }
        
        ?>

      }
    });
    var snapValues = [
      document.getElementById('slider-snap-value-from'),
      document.getElementById('slider-snap-value-to')
    ];
    var inputValues = [
      document.getElementById('slider-snap-input-from'),
      document.getElementById('slider-snap-input-to')
    ];
    snapSlider.noUiSlider.on('update', function (values, handle) {
      snapValues[handle].innerHTML = values[handle];
      inputValues[handle].value = values[handle];
    })
  </script>
</body>

</html>
