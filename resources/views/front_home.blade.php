@extends('layouts.front')
@section('title')
<?php
//$seotools->setTitle('Sel-Jegat');
//$seotools->setDescription('Label Manufacturer and Sticker Manufacture for customers from diverse industries. We have in place, a dynamic quality management system which is ISO 9001:2008 certified, by TUV SUD, India');
//$seotools->opengraph()->setUrl(url('/'));
//$seotools->setCanonical(url('/'));
//$seotools->opengraph()->addProperty('type', 'WebPage');
//$seotools->jsonLd()->addImage(url('assets/images/logo.png'));
//echo $seotools->generate();
?>
@endsection
@push('pre_css')
@endpush
@push('css')
<style>
    .quotes {
        padding: 50px 10px;
        text-align: center;
        font-size: 20px;
        background: #8e2927;
        color: #fff;
    }


    .quotes p{
    padding: 10px 0px;
    }
    .quotes .la{
    font-size: 50px;
}

#owl-slide .owl-item{
    display: block;
    width: 100%;
    height: auto;
}


</style>

@endpush
@push('js')
<script>

$(document).ready(function() {
$("#owl-slide").owlCarousel({
 singleItem:true,
 items: 1,
 loop: true,
            center: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true


});


 
});
</script>


@endpush
@section('body_class','')
@section('content')

<div id="owl-slide" class="owl-carousel owl-theme" style="width:100%;">
 
<div class="item"><img src="{{ url('fassets/images/slide3.jpg') }}" alt="slide3"></div>
 
  <div class="item"><img src="{{ url('fassets/images/slide2.jpg') }}" alt="slide2"></div>
   <div class="item"><img src="{{ url('fassets/images/slide4.jpg') }}" alt="slide4"></div>
  <div class="item"><img src="{{ url('fassets/images/slide5.jpg') }}" alt="slide5"></div>

 
</div>


<div class="quotes">


    <div class="item active offset-md-2 col-md-8 col-10 offset-1">
        <span class="quote d-flex align-items-center justify-content-center">
            <i class="la la-quote-left"></i>
        </span>

        <p>Breathe in the essence of creativity; And touch the spirit of humanity</p>
      
        <p>Bathe in the healing light of quite divinity; And discover the depth of your soul’s beauty</p>
      
        <p>Quite the mind for momentous revelation; And now listen to the whisper of Inspiration</p>

        <span class="quote d-flex align-items-center justify-content-center">
            <i class="la la-quote-right"></i>
        </span>
    </div>

</div>




@stop