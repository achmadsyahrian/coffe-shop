<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$outlet->name}}</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('p_dashboard/css/styles.min.css') }}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-4">
            <div class="card mb-0">
              <div class="card-body">
                <div class="d-flex justify-content-center">
                  <img src="{{ asset('favicon.png') }}" alt="Logo" class="img-fluid" style="max-width: 100px; height: auto;">
                </div>

                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100 h3">
                    <strong>{{ $outlet->name }}</strong>
                </a>
                <p class="text-center">Please Login here <i class="far fa-laugh-wink"></i>
                @if (session()->has('loginError'))  
                  <div class="alert alert-danger text-center" role="alert">
                     {{ session('loginError') }}
                  </div>
                @elseif(session()->has('success'))
                  <div class="alert alert-success text-center" role="alert">
                     {{ session('success') }}
                  </div>
                @endif
                <form action="/login" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="username" class="form-control @error('username') is-invalid @enderror" autofocus name="username" id="username" aria-describedby="emailHelp" value="{{ old('username') }}">
                    @error('username')
                     <div class="invalid-feedback">
                      {{ $message }}
                     </div>
                  @enderror
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                     @error('password')
                        <div class="invalid-feedback">
                        {{ $message }}
                        </div>
                     @enderror
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Does not have an account yet?</p>
                    <a class="text-primary fw-bold ms-2" href="/register">Create an account</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('p_dashboard/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="https://kit.fontawesome.com/5d3ac04a7f.js" crossorigin="anonymous"></script>
  <script src="{{ asset('p_dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>