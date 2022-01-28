@include('layouts._commonpartials.css.lightbox')
<div class="row p-1 m-0 card">
      <div class="col-md-12">
            <div class="row m-2" >
                  @foreach($images as $image)
                    <div class="column">
                      <img src="{{$image->address}}" onclick="openModal();currentSlide({{$loop->iteration}})" class="hover-shadow" style="max-width:200px; max-height: 200px;" >
                    </div>
                  @endforeach
            </div>
      </div>
</div>
<div id="myModal" class="modal">
      <div class="modal-content">
            @foreach($images as $image)
                <div class="mySlides">
                  <div class="closebutton">
                        <a onclick="closeModal()">
                              <svg class="icon icon-3xl">
                                   <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-x-circle')}}"></use>
                              </svg>
                        </a>
                  </div>
                  <img src="{{$image->address}}" style="">
                  <div class="text-center bg-info text-white h4">
                        {{$image->description}}
                  </div>
                </div>
            @endforeach

            <!-- Next/previous controls -->
            <a class="prev" onclick="plusSlides(-1)">
                  <svg class="icon icon-3xl">
                       <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-chevron-double-left')}}"></use>
                  </svg>
            </a>
            <a class="next" onclick="plusSlides(1)">
                  <svg class="icon icon-3xl" >
                       <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-chevron-double-right')}}"></use>
                  </svg>
            </a>

            <!-- Caption text -->
            <div class="caption-container">
                  <p id="caption"></p>
            </div>

      </div>
</div>
<script>
      function openModal() {
        document.getElementById("myModal").style.display = "block";
        document.getElementById("myModal").style.zIndex = "10000";
      }

      function closeModal() {
        document.getElementById("myModal").style.display = "none";
      }

      var slideIndex = 1;
      showSlides(slideIndex);

      function plusSlides(n) {
        showSlides(slideIndex += n);
      }

      function currentSlide(n) {
        showSlides(slideIndex = n);
      }

      function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        //var dots = document.getElementsByClassName("demo");
       // var captionText = document.getElementById("caption");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        /*for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }*/
        slides[slideIndex-1].style.display = "block";
        //dots[slideIndex-1].className += " active";
        //captionText.innerHTML = dots[slideIndex-1].alt;
      }                       
</script>