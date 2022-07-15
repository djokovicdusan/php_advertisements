<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload new advertisement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="content">
                        <div class="block">
                            <div class="block-header">

                            </div>
                            <div class="block-content  block-content-full">
                                <form method="POST" action="{{route('adItem.store')}}" class="form-horizontal"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group col-md-12">
                                        <label>Type:</label>&nbsp
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type_id" id="videoButton"
                                                   value="1"
                                                   onclick="typeCheckChanged()" checked>
                                            <label class="form-check-label" for="exampleRadios1">
                                                Video
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type_id" id="slideshowButton"
                                                   value="2"
                                                   onclick="typeCheckChanged()">
                                            <label class="form-check-label" for="exampleRadios2">
                                                SlideShow
                                            </label>
                                        </div>

                                    </div>

                                    <div id="videoWrapper" class="block-content mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name:</label>&nbsp
                                            <input name="videoName" type="text" class="form-control"/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input id="videoFile" data-classbutton="btn" data-input="false" type="file"
                                                   accept="video/*" name="videoFile">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Duration:</label>&nbsp
                                            <label id="videoDuration"></label>
                                        </div>

                                    </div>
                                    <div id="slideshowWrapper" class="block-content mt-5">
                                        <div class="form-group col-md-12">
                                            <label>Name:</label>&nbsp
                                            <input name="slideshowName" type="text" class="form-control"/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label c>Interval - How long should each picture be shown:</label>&nbsp
                                            <input id="duration" name="duration" class="form-control" type="text"/>

                                        </div>


                                        <div class="form-group" id="uploader">

                                            {{--                            <input id="imageFile1" data-classbutton="btn" data-input="false" type="file" >--}}
                                            <br><br>

                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="button" style="cursor:pointer "
                                                    class="btn btn-primary">Add new
                                            </button>
                                        </div>


                                    </div>
                                    <div class="form-group col-md-12 d-flex flex-row-reverse ">
                                        <input type="submit" style = "margin-bottom: 1%" class="btn btn-success">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


{{--    {!! Html::script('/js/adItem.js') !!}--}}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="{{asset('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="{{asset('js/adItem.js')}}"></script>

