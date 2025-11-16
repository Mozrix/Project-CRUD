<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      crossorigin="anonymous"
    />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
    crossorigin="anonymous">

    <link rel="stylesheet" type='text/css' href="{{ asset('css/home.css') }}">

    <title>Lifesport</title>
  </head>
  <body>
    <div class="card-header">
        <div class="my-centered-block d-block mx-auto">
            <img class="logo img-responsive my-centered-block d-block mx-auto" src="{{ asset('image/logo.png') }}" alt="">
        </div>
    </div>
        <div class="row justify-content-between p-4 mt-5 my-centered-block mx-auto">
            <a href="/booking" class="text-decoration-none block">
            <div class="text-center">
                <p class="my-3 prod-name">Lampung Walk</p>
                <img class="image" src="{{ asset('image/lwfutsal.png') }}">
                <div class="price text-white">
                    <h6 class="mb-0">120k/H</h6>
                </div>
            </div></a>
            <a href="/booking" class="text-decoration-none block">
            <div class="text-center">
                <p class="my-3 prod-name">GOR Uin</p>
                <img class="image" src="{{ asset('image/uin.png') }}">
                <div class="price text-white">
                    <h6 class="mb-0">150k/H</h6>
                </div>
            </div></a>
            <a href="/booking" class="text-decoration-none block">
            <div class="text-center">
                <p class="my-3 prod-name">Twin Futsal</p>
                <img class="image" src="{{ asset('image/twin.png') }}">
                <div class="price text-white">
                    <h6 class="mb-0">100k/H</h6>
                </div>
            </div></a>
            <a href="/booking" class="text-decoration-none block">
            <div class="text-center">
                <p class="my-3 prod-name">Ghinan Futsal</p>
                <img class="image" src="{{ asset('image/ghinan.png') }}">
                <div class="price text-white">
                    <h6 class="mb-0">80k/H</h6>
                </div>
            </div></a>
        </div>

        <div class="row justify-content-between px-4 my-centered-block mx-auto">
            <a href="/booking" class="text-decoration-none block">
            <div class="text-center">
                <p class="my-3 prod-name">Lampung Futsal</p>
                <img class="image" src="{{ asset('image/LF.png') }}">
                <div class="price text-white">
                    <h6 class="mb-0">120k/H</h6>
                </div>
            </div></a>
            <a href="/booking" class="text-decoration-none block">
            <div class="text-center">
                <p class="my-3 prod-name">Srikandi Futsal</p>
                <img class="image" src="{{ asset('image/srikandi.png') }}">
                <div class="price text-white">
                    <h6 class="mb-0">100k/H</h6>
                </div>
            </div></a>
            <a href="/booking" class="text-decoration-none block">
            <div class="text-center">
                <p class="my-3 prod-name">Raya Futsal</p>
                <img class="image" src="{{ asset('image/raya.png') }}">
                <div class="price text-white">
                    <h6 class="mb-0">80k/H</h6>
                </div>
            </div></a>
            <a href="/booking" class="text-decoration-none block">
                <div class="text-center">
                    <p class="my-3 prod-name">Futsal Jempol</p>
                    <img class="image" src="{{ asset('image/jempol.png') }}">
                    <div class="price text-white">
                        <h6 class="mb-0">100k/H</h6>
                    </div>
                </div></a>
        </div>
</div>
    <script 
        src="https://code.jquery.com/jquery-3.7.1.js" 
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" 
        crossorigin="anonymous"></script>
    <script 
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" 
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" 
        crossorigin="anonymous"></script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>

    <script 
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
      crossorigin="anonymous"></script>

    <script 
        src="{{ asset('js/home.js') }}"></script>
  </body>
</html>