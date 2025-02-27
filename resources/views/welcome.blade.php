<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap/CSS/bootstrap-4.0.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/styling.css">

</head>

<body id="home">
  
    <div class=" hero">
        <div class="row">
            <div class="col-md-12">
                <header style="align-items:center">
                    <div class="logo">
                        <img src="images/images-removebg-preview.png" alt="" height="80px" width="80px">
                        <h2><span class="text-info">MEDI</span><span class="text-warning">FAST</span></h2>
                    </div>
                    <input type="text" style="height:2rem;padding:0.5rem;margin:0.5rem;" placeholder="search for products">

                    <nav>
                        <ul class="float-left" id="menus">
                            <li><a href="">Home</a></li>
                            <li><a href="">About us</a></li>
                            <li><a href="">Chatbot</a></li>
                            <li><a href="">Contact us</a></li>
                        </ul>
                        <button class="btn btn-primary mt-3 ml-5">sign up</button>
                        <button class="btn btn-primary mt-3 ml-2">login</button>
                    </nav>
                </header>
                <main>
                    <div class="row">
                        <div class="col-md-6">
                            <h1>the high</h1>
                            <h1>standards in</h1>
                            <h1>medicine supplies</h1>
                           
                        </div>
                        <div class="class col-md-6">
                        <img src="images/image.jpg" alt="" width="100%" >
                    </div>
                    </div>
                </main>
               
            </div>
            @yield('content')
        </div>
    </div>
    </div>
</body>

</html>