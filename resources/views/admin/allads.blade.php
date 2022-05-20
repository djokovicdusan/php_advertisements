
@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">All Ads</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">App</li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="">All Ads</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">

        <div class="row">
            <div class="col-sm-6 col-xl-4">
                <button type="button" id="goToCreate" class="btn btn-primary">Add Advertisment</button>
            </div>
        </div>

        </br>

        <div class="row">
            <!-- Dynamic Table Full Pagination -->
            <div class="block col-sm-11">

                <div class="block-content block-content-full">
{{--                    {!! Form::open(array('method' => 'DELETE', 'id' => 'userForm', 'role' => 'form')) !!}--}}
{{--                    {!! Form::submit(null, ['id' => 'userButton', 'class' => 'btn btn-primary createEditButton', 'style' => 'display: none;']) !!}--}}
{{--                    {!! Form::close() !!}--}}
                    <div class="dataTables_scroll">
                        <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination" id="table">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th>{{Lang::get('dictionary.ad_name')}}</th>
                                <th>{{Lang::get('dictionary.ad_start_time')}}</th>
                                <th>{{Lang::get('dictionary.ad_end_time')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ads as $num => $ad)
                                <tr id="user_{{ $ad->id }}" class="gradeX single">
                                    <td class="text-center font-size-sm">{{ $num + 1 }}</td>
                                    <td class="font-w600 font-size-sm">{{ $ad->name }}</td>
                                    <td class="font-w600 font-size-sm">{{ $user->start_time }}</td>
                                    <td class="font-w600 font-size-sm">{{ $user->end_time }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Dynamic Table Full Pagination -->

    </div>
    <!-- END Page Content -->
@endsection

    <script src="{{asset('/js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
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
    <script src="{{asset('js/ads.js')}}"></script>


<style>
    #table{
        cursor: pointer;
    }
</style>
