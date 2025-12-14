<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="{{asset('img/seaworld.png')}}" type="image/x-icon">
  <title>Sea World Ancol</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    #intro-example {
      height: 100vh;
      margin: 0;
      padding-top: 0;
      background-size: cover !important;
      background-position: top center !important;
      background-repeat: no-repeat !important;
    }

    @media (min-width: 992px) {
      #intro-example {
        height: 100vh;
      }

      .content-wrapper {
        padding: 3rem;
      }

      body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        height: 100%;
        display: flex;
        flex-direction: column;
      }


      .page-wrapper {
        min-height: calc(100vh - 130px);
        display: flex;
        flex-direction: column;
      }

      footer {
        margin-top: auto;
      }
    }

    .navbar-nav .nav-link {
      color: white;
    }

    .navbar-scrolled {
      background-color: #004d73e4 !important;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 6px rgba(126, 49, 49, 0.2);
    }

    .navbar {
      transition: background-color 0.3s ease;
    }

    /* Biar saat di-hover juga tetap putih */
    .navbar .nav-link:hover,
    .navbar .nav-link.dropdown-toggle:hover {
      color: white !important;
    }

    .navbar .nav-link.dropdown-toggle:focus,
    .navbar .nav-link.dropdown-toggle.show {
      color: white !important;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top"> <!-- Container wrapper -->
    <div class="container">
      <!-- Navbar brand -->
      <a class="navbar-brand me-2" href="">
        <img src="{{asset('img/seaworld.png')}}" height="50px" alt="Seaworld Logo" loading="lazy" />
      </a>
      <!-- Toggle button -->
      <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarCenteredExample"
        aria-controls="navbarCenteredExample" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse justify-content-center color: white" id="navbarCenteredExample">
        <!-- Left links -->
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('ticket')}}">Ticket</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('promo')}}">Promo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('facility')}}">Facility</a>
        </ul>
        <!-- Left links -->
      </div>
      <div class="d-flex align-items-center">
        @guest
          <!-- Kalau BELUM login -->
          <a href="{{route('login')}}" type="button" class="btn btn-link px-3 me-2">
            Login
          </a>
          <a href="{{route('register')}}" type="button" class="btn btn-primary me-3">
            Register
          </a>
        @endguest

        @auth
          <!-- Kalau SUDAH login -->
          <div class="dropdown">
            <a class="btn btn-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="/profile">Profile</a></li>

              @if(in_array(\Auth::user()->role, ['admin', 'staff']))
                <li><a class="dropdown-item" href="{{route('dashboard.dashboard')}}">Dashboard</a></li>
              @endif

              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        @endauth
        @if (session('alert'))
          <script>
            alert("{{ session('alert') }}");
          </script>
        @endif

      </div>

      <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
  </nav>
  <div class="page-wrapper">
    @yield('content')
  </div>

    <footer class="bg-body-tertiary text-center text-lg-start mt-5">
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: #004d73e4; color: white;">
        © 2025 Sea World Ancol.
        <p class="mb-0">
          <i class="fa-solid fa-location-dot"></i> Jl. Lodan Timur No.7, Jakarta Utara |
          <i class="fa-solid fa-phone"></i> (021) 29222222
      </div>
      <!-- Copyright -->
    </footer>

    <!-- MDB -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
      </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous">
      </script>
    <!-- MDB -->
    <script type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
    <script>
      document.addEventListener("scroll", function () {
        const navbar = document.querySelector(".navbar");
        if (window.scrollY > 50) {
          navbar.classList.add("navbar-scrolled");
        } else {
          navbar.classList.remove("navbar-scrolled");
        }
      });
    </script>
    @stack('scripts')

</body>

</html>