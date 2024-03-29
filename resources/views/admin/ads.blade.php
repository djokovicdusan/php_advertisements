<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Advertisements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Page Content -->
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-6 col-xl-4">
                                <button type="button" id="goToCreate" class="btn btn-primary">
                                    <a style="color: white; text-decoration: none" href="{{route('ads.add')}}">Create new advertisement block</a>
                                </button>
                            </div>
                        </div>

                        </br>

                        <div class="row">
                            <!-- Dynamic Table Full Pagination -->
                            <div class="block col-sm-11">
                                {{--<div class="block-header">--}}
                                {{--<h3 class="block-title">Dynamic Table--}}
                                {{--<small>Full pagination</small>--}}
                                {{--</h3>--}}
                                {{--</div>--}}
                                <div class="block-content block-content-full">
                                    {{--                    {!! Form::open(array('method' => 'DELETE', 'id' => 'userForm', 'role' => 'form')) !!}--}}
                                    {{--                    {!! Form::submit(null, ['id' => 'userButton', 'class' => 'btn btn-primary createEditButton', 'style' => 'display: none;']) !!}--}}
                                    {{--                    {!! Form::close() !!}--}}
                                    <form id="formAdDetail" method="get" action="{{route('ads.get')}}">
                                        <input type="text" id="inputStartTime" name="start_time" hidden/>
                                        <div class="dataTables">
                                            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                                            <table style="cursor: pointer"
                                                class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination showCursor"
                                                id="table">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th>Name</th>
                                                    <th>Start</th>
                                                    <th>End</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($ads as $num => $ad)
                                                    <tr id="user_{{ $ad->id }}" class="gradeX single">
                                                        <td class="text-center font-size-sm">{{ $num + 1 }}</td>
                                                        <td class="font-w600 font-size-sm">{{ $ad->name }}</td>
                                                        <td class="font-w600 font-size-sm">{{ $ad->start_time }}</td>
                                                        <td class="font-w600 font-size-sm">{{ $ad->end_time }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END Dynamic Table Full Pagination -->
                        <div class="row">
                            <div class="col-sm-6 col-xl-4">
                                {{--                <button type="button" id="goToCarousel" class="btn btn-primary">Go to Carousel</button>--}}
                                <a href="{{route('carousel')}}" class="btn btn-primary" target="_blank">Go to Carousel</a>
                            </div>
                        </div>

                    </div>
                    <!-- END Page Content -->
                </div>
            </div>
        </div>
    </div>
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
<script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>


<!--Export table button CSS-->

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">



<script src="{{asset('js/ads.js')}}"></script>
