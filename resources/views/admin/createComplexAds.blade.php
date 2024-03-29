<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new complex advertisement block') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="content">

                        <form method="post" action="{{route('ad.storeComplexAds')}}" class="form-horizontal"
                              enctype="multipart/form-data">
                            @csrf
                            <div id="addWrapper" class="block-content">
                                <div class="form-group col-md-12">
                                    <label>Name:</label>&nbsp
                                    <input name="addName" type="text" required class="form-control"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Start:</label>&nbsp
                                    <input name="addStart" type="datetime-local" required class="form-control"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#mainItemModal">
                                        Select main advertisement(item)
                                    </button>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Main advertisement(item):</label>&nbsp

                                    <div class="uploadDoc row" id="mainItem">

                                    </div>


                                </div>

                                <div class="form-group col-md-12">
                                    <label>Other items:</label>&nbsp

                                    <div class="row uploadDoc" id="allItems">

                                        <div class="col-sm-1" hidden>
                                            <a class="btn-check">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>

                                    </div>

                                </div>


                            </div>
                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#Mymodal">
                                        Select other advertisements(items)
                                    </button>

                                    {{--                                    <a href="{{url("ads/adItem")}}" >--}}
                                    {{--                                        <button type="button" class="btn btn-primary">--}}
                                    {{--                                            Upload advertisements(items)--}}
                                    {{--                                        </button>--}}
                                    {{--                                    </a>--}}
                                </div>
                            </div>

                            <div class="container">

                                <!-- .modal -->
                                <div class="modal fade" id="Mymodal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    ×
                                                </button>
                                                <h4 class="modal-title">

                                                </h4>
                                            </div>
                                            <div class="modal-body" style="width: 750px; margin: auto">

                                                <table id="tableItems" class="table  table-bordered"
                                                       style="width:100%;  overflow: hidden; cursor: pointer">
                                                    <thead>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Duration / No of cycles</th>
                                                    <th hidden>Id</th>
                                                    <th>Created at</th>
                                                    <th>Preview</th>

                                                    </thead>
                                                    <tbody>

                                                    @foreach($adItems as $adItem)

                                                        <tr>
                                                            <td>{{ $adItem->file_name }} </td>
                                                            <td>{{ $adItem->type_id == 1 ? "Video" : "Slideshow" }} </td>
                                                            <td>{{ $adItem->duration }} </td>
                                                            <td hidden>{{ $adItem->id }} </td>
                                                            <td>{{ $adItem->created_at }} </td>
                                                            <td>
                                                                @if($adItem->type_id == 1)
                                                                    <a href="{{asset('/assets/ads/video/'.$adItem->file_name)}}"
                                                                       target="_blank">Preview</a>
                                                                @else <a
                                                                    href="{{route('slideshow.preview',['adItem'=>$adItem])}}"
                                                                    target="_blank">Preview</a>
                                                                @endif
                                                            </td>
                                                        </tr>

                                                    @endforeach


                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="buttonFinish" type="button" data-dismiss="modal"
                                                        class="btn btn-primary">
                                                    Ok
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="mainItemModal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    ×
                                                </button>
                                                <h4 class="modal-title">

                                                </h4>
                                            </div>
                                            <div class="modal-body" style="width: 750px; margin: auto">

                                                <table id="tableItemsMainItemModal" class="table  table-bordered"
                                                       style="width:100%;  overflow: hidden; cursor: pointer">
                                                    <thead>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Duration / No of cycles</th>
                                                    <th hidden>Id</th>
                                                    <th>Created at</th>
                                                    <th>Preview</th>

                                                    </thead>
                                                    <tbody>

                                                    @foreach($adItems as $adItem)

                                                        <tr>
                                                            <td>{{ $adItem->file_name }} </td>
                                                            <td>{{ $adItem->type_id == 1 ? "Video" : "Slideshow" }} </td>
                                                            <td>{{ $adItem->duration }} </td>
                                                            <td hidden>{{ $adItem->id }} </td>
                                                            <td>{{ $adItem->created_at }} </td>
                                                            <td>
                                                                @if($adItem->type_id == 1)
                                                                    <a href="{{asset('/assets/ads/video/'.$adItem->file_name)}}"
                                                                       target="_blank">Preview</a>
                                                                @else <a
                                                                    href="{{route('slideshow.preview',['adItem'=>$adItem])}}"
                                                                    target="_blank">Preview</a>
                                                                @endif
                                                            </td>
                                                        </tr>

                                                    @endforeach


                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="buttonFinish" type="button" data-dismiss="modal"
                                                        class="btn btn-primary">
                                                    Ok
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 d-flex flex-row-reverse ">
                                <input type="submit" style="margin-bottom: 1%" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="{{asset('js/createComplexAds.js')}}"></script>


