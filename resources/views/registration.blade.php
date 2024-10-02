<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- fontawesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>Document</title>
</head>
<style>
        @media (min-width: 1025px) {
    .h-custom {
    height: 100vh !important;
    }
    }
</style>
<body>
<section class="h-100 h-custom" style="background-color: #8fc4b7;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-8 col-xl-6">
        <div class="card rounded-3">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/img3.webp"
            class="w-100" style="border-top-left-radius: .3rem; border-top-right-radius: .3rem;"
            alt="Sample photo">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2">Registration Info</h3>

            <form action="{{ route('registration.register') }}" method="POST">
                @csrf
                <div class="form-outline mb-4">
                    <input type="text" name="fullname" class="form-control" required />
                    <label class="form-label">Full Name</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="email" name="email" class="form-control" required />
                    <label class="form-label">Email</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" name="username" class="form-control" required />
                    <label class="form-label">Username</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="password" name="password" class="form-control" required />
                    <label class="form-label">Password</label>
                </div>

                <button type="submit" class="btn btn-success btn-lg mb-1">Submit</button>
                </form>


          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>