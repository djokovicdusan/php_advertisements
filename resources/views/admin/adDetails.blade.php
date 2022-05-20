<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$ad->name}}
        </h2>
    </x-slot>


    <!-- Page Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <input hidden value="{{ $ad }}" id="ad">
                    <input hidden type="text" value="{{ route('ad.destroy', 0) }}" id="route-url" />
                    <div class="content">


                        <div class="dataTables">
                            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                            <table
                                class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination showCursor"
                                id="table">
                                <thead>
                                {{--                <th>No</th>--}}
                                <th class="text-center">No</th>
                                <th class="text-center">Ad item name</th>
                                <th class="text-center">Number of cycles</th>

                                </thead>
                                <tbody>
                                <p hidden>{{$num=1}}</p>
                                @foreach($ad->adsAdItem as $adsAdItem)

                                    <tr id="user_{{ $ad->id }}" class="gradeX single pe-auto">
                                        <td >{{$num++}}</td>
                                        <td class="">{{$adsAdItem->adItem->file_name}}</td>

                                        <td class="font-w600 font-size-sm">{{$adsAdItem->number_of_cycles}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <form action="{{ route('ad.destroy',$ad) }}" method="POST" id="route-appender">
                            <div class="form-group">
                            @csrf
                            <button type="submit" onclick="return myFunction();" class="btn btn-danger w-24">Delete</button>
                            </div>
                        </form>

                        <form action="{{ route('ad.update',$ad) }}" method="POST" id="route-appender">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label class ="col-2">New start time:</label>&nbsp
                                <input name="addStart" type="datetime-local" required class="col-8"/>
                                <button type="submit" class="btn btn-primary justify-content-end">Update</button>
                            </div>

                        </form>


                        {{--        <a href="{{ route('adItem')}}" class="btn btn-primary">Ad item</a>--}}


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</x-app-layout>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
{{--<script src="{{asset('js/datatables/dataTables.bootstrap4.min.js')}}"></script>--}}
{{--<script src="{{asset('js/datatables/jquery.dataTables.min.js')}}"></script>--}}

<!--Import jQuery before export.js-->

<!--Data Table-->
<script type="text/javascript" src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>


<!--Export table button CSS-->

<link rel="stylesheet" href="{{asset('css/adDetails.css')}}"/>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

<script>
    function myFunction() {
        if(!confirm("Are you sure you want to delete this ad?"))
            event.preventDefault();
    }
</script>

