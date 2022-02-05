<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="content">

                        <form method="post" action="{{route('ad.store')}}" class="form-horizontal"
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
                                    <label>Items:</label>&nbsp

                                    <div class="row uploadDoc" id="allItems">
                                        {{--                        <div class="col-sm-8"><input type="text" class="form-control" name="cycles[]" placeholder="No of cycles"--}}
                                        {{--                                                     hidden></div>--}}
                                        <div class="col-sm-1" hidden><a class="btn-check"><i
                                                    class="fa fa-times"></i></a></div>
                                        {{--                        <input type="text" value="" class="itemIds" hidden name="itemIds[]">--}}
                                    </div>


                                </div>


                            </div>
                            <div class="block-content">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#Mymodal">
                                        Select ad items
                                    </button>

                                    <a href="{{url("ads/adItem")}}">
                                        <button type="button" class="btn btn-primary">
                                            Upload ad items
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <div class="container">
                                <h2></h2>
                                <!-- .Launch Modal Button-->


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
                                                       style="width:100%; table-layout: fixed; overflow: hidden">
                                                    <thead>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Duration / No of cycles</th>
                                                    <th hidden>Id</th>
                                                    <th>Created at</th>

                                                    </thead>
                                                    <tbody>

                                                    @foreach($adItems as $adItem)

                                                        <tr>
                                                            <td>{{ $adItem->file_name }} </td>
                                                            <td>{{ $adItem->type_id }} </td>
                                                            <td>{{ $adItem->duration }} </td>
                                                            <td hidden>{{ $adItem->id }} </td>
                                                            <td>{{ $adItem->created_at }} </td>
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
                            <button type="submit" class="btn btn-success">Submit</button>
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
<script src="{{asset('js/addAd.js')}}"></script>



