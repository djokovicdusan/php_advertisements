<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset("css/carousel.css")}}">

</head>
<body>

{{--@foreach($ad->adItem as $adItem)--}}
{{--    <p>{{}}</p>--}}


@if($adsAdItem->startsFromSecond==0)
    <input id="carouselInterval" type="number" value="{{$adItem->duration}}" hidden>
@else
    <input id="carouselInterval" type="number" value="{{$adsAdItem->duration_in_ad}}" hidden>
@endif
<input id="refreshInterval" type="number" value="{{$refreshInterval}}" hidden>
<input id="refreshIntervalMilliSeconds" type="number" value="{{$refreshIntervalMilliSeconds}}" hidden>
<input id="carouselStartTime" type="number" value="{{$adItemStartTime}}" hidden>
<input id="carouselStartTimeMilliSeconds" type="number" value="{{$adItemStartTimeMilliSeconds}}" hidden>
<input id="adItemName" type="number" value="{{$adItem->file_name}}" hidden>


@if($adItem->type_id == 1)
    {{--            ubaciti kao video--}}
    <div class="video-container">
        <video id="videoCarousel" controls loop autoplay muted class="d-block w-100" alt="First slide"
               style="overflow: hidden;">
            <source src="{{asset('/assets/ads/video/'.$adItem->file_name)}}">
        </video>
    </div>

@else

    <div id="SmallCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($adItem->files as $key => $file)
                <div class="carousel-item {{ $key==0 ? "active" : "" }}">
                    <img class="" style="  object-fit: cover; width: 100%; min-height: 100%;"
                         src="{{ asset('../storage/app/public/'.$file) }}">
                </div>
            @endforeach
        </div>
    </div>
    @endif
    </div>

</body>


</html>
{{--@section('pageScripts')--}}
{{--{!! Html::script('/js/carousel.js') !!}--}}
<script src="https://code.jquery.com/jquery-3.2.1.js"
        integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="{{asset('js/carousel.js')}}"></script>
{{--@stop--}}








