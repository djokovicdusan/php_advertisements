@extends('admin.layouts.backend')

@section('content')

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">Items</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">App</li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="">Items</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        item ads
{{--        <form action="ads/adItem">--}}

{{--        </form>--}}
        <div>
            @foreach($adItems as $adItem)

                <p> {{ $adItem->fileName }} </p>

            @endforeach

        </div>

        <a href="{{ route('adItem')}}" class="btn btn-primary">Ad item</a>




    </div>
    <!-- END Page Content -->
@endsection

@section('pageScripts')
    {!! Html::script('/js/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('/js/plugins/datatables/dataTables.bootstrap4.min.js') !!}
    {{--    {!! Html::script('/js/plugins/datatables/buttons/dataTables.buttons.min.js') !!}--}}
    {{--    {!! Html::script('/js/plugins/datatables/buttons/buttons.print.min.js') !!}--}}
    {{--    {!! Html::script('/js/plugins/datatables/buttons/buttons.html5.min.js') !!}--}}
    {{--    {!! Html::script('/js/plugins/datatables/buttons/buttons.flash.min.js') !!}--}}
    {{--    {!! Html::script('/js/plugins/datatables/buttons/buttons.colVis.min.js') !!}--}}
    {{--    {!! Html::script('js/uploadFiles.js') !!}--}}
    {{--    {!! Html::script('js/dynamicInputNames.js') !!}--}}

    {{--    {!! Html::script('/js/pages/be_tables_datatables.min.js') !!}--}}
    {{--    {!! Html::script('/js/users.js') !!}--}}
@stop
<?php>
