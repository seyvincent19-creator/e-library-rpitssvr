<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <link rel="icon" type="image/png" href="{{ asset('assets/image/img_welcome/RPITST.png') }}">

        {{-- Link Icon --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        {{-- Link Bootstarp5 --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        {{-- Link Custom --}}
        <link rel="stylesheet" href="{{ asset('assets/css/style_auth/style_auth.css') }}">
    </head>
    <body>
        <div id="back-img">
            <!-----------------------Main Container --------------------->
            <div class="container d-flex justify-content-center align-items-center min-vh-100">
                <!-----------------------Login Container --------------------->
                <div class="row border rounded-5 p-3 bg-white shadow box-area">
                    <!-----------------------Left Box --------------------->
                    <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background-color: #103cbe;">
                        <div class="featured-image">
                            <img src="{{ asset('assets/image/img_welcome/RPITST.png') }}" class="img-fluid" id="img-prit" alt="image">
                        </div>
                        <p class="text-white fs-4" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Library Digital</p>
                        <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Regional Polytechnic Institute TECHO SEN Svay Rieng</small>
                    </div>
                    <!-----------------------Right Box --------------------->
                    <div class="col-md-6 right-box">
                        <div class="row align-items-center">
                            <div class="header-text mb-2">
                                <h4 class="text-center fw-bold">Login</h4>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success py-2 small">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('login.action') }}" method="POST" class="form">
                                @csrf

                                <div class="mb-1">
                                    <label for="email" >Email : </label>
                                    <input type="email" name="email" class="form-control bg-light" placeholder="Email..." >

                                    @error('email')
                                        <span class="text-danger error">* {{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- <div class="text-danger mt-1">* Error email</div> -->

                                <div class="mb-1" id="input_password">
                                    <label for="password" >Password : </label>
                                    <input type="password" name="password" class="form-control bg-light " id="password" placeholder="Password...">
                                    <span id="togglePassword">
                                        <i class="fa fa-eye" id="eyeIcon"></i>
                                    </span>

                                    @error('password')
                                        <span class="text-danger error">* {{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="input-group mb-2 d-flex justify-content-between">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="formCheck">
                                        <label for="formCheck" class="form-check-label text-secondary"><small>Remeber Me</small></label>
                                    </div>
                                    <div class="forgot">
                                        <small><a href="#">Forgot Password?</a></small>
                                    </div>
                                </div>


                                <div class="input-group mb-2 mt-3">
                                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                                </div>
                                <div class="input-group mb-3 text-center">
                                    <button class="btn btn-lg btn-light w-100 fs-6"><img src="{{ asset('assets/image/img_auth/google.png') }}" id="img-google"><small>Sing In with Google</small></button>
                                </div>
                                <div class="row">
                                    <small>Don't have account? <a href="{{ url('/register') }}">Register</a></small>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>





        {{-- Link Script Bootstrap5 --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/script_auth/script_auth.js') }}"></script>

    </body>
</html>
