@extends('page')

@section('title', 'Website')
@section('title_header', 'Gregor’s Website')
@section('desc_header', 'Created ' . auth()->user()->created_at->format('d. F, Y'))

@section('content')
    <div class="website-content">
    <div class="container pt-3">
        @include('messages')

        @if(auth()->user()->site->is_created)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success my-4 alert-dismissible d-flex justify-content-between align-items-center">
                        <div>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Your Demo Website is launching</h5>
                            Please wait while we deploy your own WordPress Website where you can try out and break things while learning!
                        </div>
                        <span id="launchSpinner" class="spinner-border spinner-border-lg text-light ml-auto" role="status" aria-hidden="true"></span>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->site->is_suspended)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning my-4 alert-dismissible text-white d-flex justify-content-between align-items-center">
                        <div>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-times"></i> Your Demo Website is paused</h5>
                            Due to inactivity, we have paused your Website. Don’t worry, you can reactivate it with just a click!
                        </div>
                        <button type="button" class="btn btn-primary bg-white border border-secondary shadow-sm" onclick="window.location.href='{{ route('website.resume') }}'">
                            Re-activate <i class="fas fa-arrow-alt-circle-up"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="row pt-3">
            <!-- Card on the Left -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- My Website Section -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span>
                                <i class="fas fa-user-circle mr-2"></i>
                                My Website
                            </span>
                            <button class="btn btn-dark align-self-center" data-toggle="modal" data-target="#siteBackupModal">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>

                        <!-- Website URL Section -->
                        <div class="form-group">
                            <label for="websiteUrl">Website URL</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="websiteUrl" value="https://{{ auth()->user()->site->domain }}" placeholder="Enter URL" aria-label="Website URL" aria-describedby="websiteBtn">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="websiteBtn"><i class="fas fa-link"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Wordpress Login URL Section -->
                        <div class="form-group">
                            <label for="wordpressUrl">Wordpress Login URL</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="wordpressUrl" value="https://{{ auth()->user()->site->domain }}/wp-login.php" placeholder="Enter URL" aria-label="Wordpress URL" aria-describedby="wordpressBtn">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="wordpressBtn"><i class="fas fa-link"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Username and Password Section in the Same Row -->
                        <div class="form-group row">
                            <div class="col">
                                <label for="login">Username</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="login" value="{{ auth()->user()->site->username }}" placeholder="Enter username" aria-label="Username" aria-describedby="copyUsernameBtn">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="copyUsernameBtn"><i class="far fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" value="{{ auth()->user()->site->password }}" placeholder="Enter password" aria-label="Password" aria-describedby="copyPasswordBtn">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="showPasswordBtn"><i class="far fa-eye"></i></button>
                                        <button class="btn btn-outline-secondary" type="button" id="copyPasswordBtn"><i class="far fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card on the Right
            <div class="col-md-6">
                <div class="card website-preview">
                    <div class="card-header">
                        <h5 class="card-title m-0">Preview</h5>
                    </div>
                    <img class="card-img-top align-self-center" src="{{ asset('img/preview-default.png') }}" alt="Card image cap">
                    <div class="card-body">
                        <h3>Greg's website coming soon</h3>
                    </div>
                </div>
            </div>
            -->
            <!-- Card on Right with Laptop -->
                    <div class="col-md-6 macbook w-100 d-flex justify-content-center flex-column">
                        <div class="screen">
                            <div class="viewport" style="background-image:url('{{ auth()->user()->site->screenshot ?: '/img/poh-screenshot.png' }}');">
                            </div>
                        </div>
                        <div class="base"></div>
                        <div class="notch"></div>
                    </div>
        </div>

        <div class="row website-buttons">
            <!-- Row 1 -->
            <div class="col-md-12 mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5><b>Clear Cache</b></h5>
                        <p>In case you run into any issues, you can run a restart to unfreeze any potential things.</p>
                    </div>
                    <form action="{{ route('website.clearCache') }}" method="POST" id="clearCacheForm">
                        @csrf
                        <button id="clearCacheBtn" class="btn btn-primary align-self-center" onclick="toggleClearCacheSpinner()">
                            <span id="clearCacheBtnText">Clear Cache</span>
                            <span id="clearCacheBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <i id="clearCacheBtnIcon" class="fas fa-sync-alt ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="col-md-12 mt-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5><b>Rebuild</b></h5>
                        <p>In case you run into any issues, you can run a restart to unfreeze any potential things.</p>
                    </div>
                    <form action="{{ route('website.deleteAndRebuild') }}" method="POST" id="rebuildForm">
                        @csrf
                        <button id="rebuildBtn" class="btn btn-danger align-self-center" onclick="toggleRebuildSpinner()">
                            Delete & Rebuild
                            <span id="rebuildBtnText" class="fas fa-trash ml-2"></span>
                            <span id="rebuildBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="alert alert-dismissible bg-dark text-white d-flex justify-content-between align-items-center w-100">
                    <div>
                        <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5> Take your site live, with your own Domain!</h5>
                        Are you ready to take your website live? I offer premium hosting exclusively for my course customers!
                    </div>
                    <button class="btn btn-primary bg-white border border-secondary shadow-sm ml-3" data-toggle="modal" data-target="#requestAccessModal">
                        Go live!
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Access Modal -->
    <div class="modal fade" id="siteBackupModal" tabindex="-1" role="dialog" aria-labelledby="requestAccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h1 class="mb-4">Site Backup</h1>
                    <div class="mb-4">
                        <p>Would you like to request to get a full backup of your page?</p>
                    </div>
                    <form action="{{ route('website.backupRequest') }}" method="POST">
                        @csrf
                        <button class="btn btn-primary">
                            Request now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/website.css') }}">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            const websiteUrlInput = $('#websiteUrl');
            const websiteBtn = $('#websiteBtn');
            const wordpressUrlInput = $('#wordpressUrl');
            const wordpressBtn = $('#wordpressBtn');
            const passwordInput = $('#password');
            const loginInput = $('#login');
            const showPasswordBtn = $('#showPasswordBtn');
            const copyPasswordBtn = $('#copyPasswordBtn');
            const copyUsernameBtn = $('#copyUsernameBtn');

            passwordInput.attr('type', 'password');

            websiteBtn.click(function() {
                const url = websiteUrlInput.val();
                if (url.trim() !== '') {
                    window.open(url, '_blank');
                }
            });

            wordpressBtn.click(function() {
                const wordpressUrl = wordpressUrlInput.val();
                if (wordpressUrl.trim() !== '') {
                    window.open(wordpressUrl, '_blank');
                }
            });

            copyUsernameBtn.click(function() {
                loginInput.select();
                document.execCommand('copy');
                window.getSelection().removeAllRanges();
            });

            showPasswordBtn.click(function() {
                passwordInput.attr('type', passwordInput.attr('type') === 'password' ? 'text' : 'password');
            });

            copyPasswordBtn.click(function() {
                passwordInput.select();
                document.execCommand('copy');
                window.getSelection().removeAllRanges();
            });
        });

        function toggleRebuildSpinner() {
            // Disable the button
            $('#rebuildBtn').prop('disabled', true);

            // Toggle visibility of the spinner and button text
            $('#rebuildBtnSpinner').toggleClass('d-none');
            $('#rebuildBtnText').toggleClass('d-none');

            // Submit the form immediately
            $('#rebuildForm').submit();
        }

        function toggleClearCacheSpinner() {
            // Disable the button
            $('#clearCacheBtn').prop('disabled', true);

            // Toggle visibility of the spinner, button text, and icon
            $('#clearCacheBtnSpinner').toggleClass('d-none');
            $('#clearCacheBtnIcon').toggleClass('d-none');

            // Submit the form immediately
            $('#clearCacheForm').submit();
        }

    </script>

@stop
