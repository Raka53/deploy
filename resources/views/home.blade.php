<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - Application Choices</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
          width: 100vw;
    height: 100vh;
            background-image: url("{{ asset('img/3.png') }}");;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: rgba(0, 31, 63, 0.5); /* Biru langit malam dengan opacity */
            color: white;
        }

        .navbar-brand {
            margin: 0 auto; /* Menempatkan teks di tengah */
        }

        .app-card {
            margin: 20px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .app-card:hover {
            transform: scale(1.05);
        }

        .card-img-top {
            height: 150px;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .app-card:hover .card-img-top {
            transform: scale(1.1);
        }

        .card-title, .card-text {
            color: #3498db; /* Biru */
        }

        .btn-primary {
            background-color: #3498db; /* Biru */
            border-color: #3498db; /* Biru */
        }

        .btn-primary:hover {
            background-color: #2980b9; /* Biru lebih gelap pada hover */
            border-color: #2980b9; /* Biru lebih gelap pada hover */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand mx-auto" href="/home">Home Apps</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item">

                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
              </li>
          </ul>
      </div>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" >
        @csrf
    </form>

    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card app-card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="App 1">
                    <div class="card-body">
                        <h5 class="card-title">HRIS</h5>
                        <p class="card-text">Description for Application 1. Lorem ipsum dolor sit amet.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">HRIS</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card app-card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="App 2">
                    <div class="card-body">
                        <h5 class="card-title">Application 2</h5>
                        <p class="card-text">Description for Application 2. Lorem ipsum dolor sit amet.</p>
                        <a href="{{ route('dashboardAbsen') }}" class="btn btn-primary">Open App 2</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card app-card">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="App 3">
                    <div class="card-body">
                        <h5 class="card-title">Application 3</h5>
                        <p class="card-text">Description for Application 3. Lorem ipsum dolor sit amet.</p>
                        <a href="#" class="btn btn-primary">Open App 3</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
