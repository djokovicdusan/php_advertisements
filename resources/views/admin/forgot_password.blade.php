
@include('inc._global.views.head_start')
@include('inc._global.views.head_end')
@include('inc._global.views.page_start')


<!-- Page Content -->
<div class="bg-image" style="background-image: url({{ asset('assets/img/cover/photo6@2x.jpg') }});">
    <div class="hero-static bg-white-95">
        <div class="content">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <!-- Reminder Block -->
                    <div class="block block-themed block-fx-shadow mb-0">
                        <div class="block-header">
                            <h3 class="block-title">Password Reminder</h3>
                            <div class="block-options">
                                <a class="btn-block-option" href="login" data-toggle="tooltip" data-placement="left" title="Sign In">
                                    <i class="fa fa-sign-in-alt"></i>
                                </a>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="p-sm-3 px-lg-4 py-lg-5">
                                <h1 class="mb-2">OneUI</h1>
                                <p>Please provide your account’s email and we will send you your password.</p>

                                <!-- Reminder Form -->
                                <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _es6/pages/op_auth_reminder.js) -->
                                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                {{--<form class="js-validation-reminder" action="be_pages_auth_all.html" method="POST">--}}
                                    {{--<div class="form-group py-3">--}}
                                        {{--<input type="text" class="form-control form-control-lg form-control-alt" id="reminder-credential" name="reminder-credential" placeholder="Username or Email">--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group row">--}}
                                        {{--<div class="col-md-6 col-xl-5">--}}
                                            {{--<button type="submit" class="btn btn-block btn-primary">--}}
                                                {{--<i class="fa fa-fw fa-envelope mr-1"></i> Send Mail--}}
                                            {{--</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</form>--}}

                                {!! Form::open(array('method' => 'POST', 'url' => 'auth/forgot_password/', 'class' => 'js-validation-signin', 'role' => 'form', 'novalidate' => 'novalidate')) !!}
                                <div class="py-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-alt form-control-lg" id="login-username" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 col-xl-5">
                                        <button type="submit" class="btn btn-block btn-primary">
                                            <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Send Mail
                                        </button>
                                    </div>
                                </div>
                            {{--</form>--}}
                            {!! Form::close() !!}
                                <!-- END Reminder Form -->
                            </div>
                        </div>
                    </div>
                    <!-- END Reminder Block -->
                </div>
            </div>
        </div>
        <div class="content content-full font-size-sm text-muted text-center">
            <strong><?php echo 'ShowDown'; ?></strong> &copy; <span data-toggle="year-copy"></span>
        </div>
    </div>
</div>
<!-- END Page Content -->

@include('inc._global.views.page_end')
@include('inc._global.views.footer_start')

{{--<!-- Page JS Plugins -->--}}
{!! Html::script('/js/plugins/jquery-validation/jquery.validate.min.js') !!}

{{--<!-- Page JS Code -->--}}
{!! Html::script('/js/pages/op_auth_signin.min.js') !!}

@include('inc._global.views.footer_end')
