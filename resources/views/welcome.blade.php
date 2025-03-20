<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="css/bootstrap/CSS/bootstrap-4.0.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/styling.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<!-- <body class="hero">
  
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <header style="align-items:center">
                    <div class="logo">
                        <img src="images/images-removebg-preview.png" alt="" height="80px" width="80px">
                        <h2><span class="text-info">MEDI</span><span class="text-warning">FAST</span></h2>
                    </div>
                    

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
                <div class="col-md-12">
                    <input type="text" class="search-pro"  placeholder="search for products" >
                    </div>
                </div>
             
               
           
            @yield('content')
        </div>
        <main>
                    <div class="row">
                        <div class="col-md-6">
                            <h1>the high</h1>
                            <h1>standards in</h1>
                            <h1>medicine supplies</h1>
                           
                        </div>
                        <div class="class col-md-6">
                        
                    </div>
                    </div>
                </main>
    </div>
    </div>
</body> -->
<div id="home-cont">
 <div class="container" >
    <div class="row">
    <div class="col-md-12">
      <header>
            <div class="logo">
            <img src="images/images-removebg-preview.png" alt="" height="70px" width="70px">
            <h2><span style="color:darkblue;" >MEDI</span><span  style="color:rgb(235, 168, 0);" >FAST</span></h2>
            </div>
            <div class="menus">
                <nav>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li><a href="">About</a></li>
                        <li><a href="">Chatbot</a></li>
                        <li><a href="">Contact us</a></li>
                    </ul>
                </nav>
            </div>
            
        <div class="search-sec">
            <div class="search-bar">
          
                <input type="text" id="search" placeholder="Search for products"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </div>
            <div class="login-btn">
            <button class="btn ">Login</button>
            </div>
          
        </div>
        </div>

      </header>
    </div>
 </div>
 </div>
 <div class="images">
 <div class="section">
     
 <div class="container">
    <div class="row">
        <div class="col-lg-8">
      
         <div class="high-stan">
            
         <h1>Welcome to our <span style="color:darkblue;">MEDI</span><span style="color:orange;">FAST</span></h1>
         <h4> The store aims to create a seamlessshopping experience  <br>for its customers, with high-quality products <br>and expert support readily available online.</h4>
         </div>
         <div class="header-btn">
           <button class="btn " id="shop-now">Shop Now</button>
           <button class="btn " id="sign-up">Sign up</button>
           </div>
        </div>
    </div>
 </div>
 </div>

 </div>
 <div class="service">
 <div class="container">
    <div class="row">
        <div class="col-md-4">
        <i class="fas fa-shipping-fast"></i>
            <h2>fast delivery</h2>
            <p>Medifast offers fast and reliable delivery, ensuring your medical supplies and healthcare products reach you quickly and securely, right at your doorstep.</p>
            </div>
            <div class="col-md-4">
            <i class="fa-solid fa-file-contract"></i>
            <h2>license of government</h2>
            <p>Medifast is a health and wellness company that follows government rules. In 2012, it paid a fine for false weight-loss claims. It follows laws to keep its business fair and honest.</p>
            </div>
            <div class="col-md-4">
            <i class="fa-solid fa-user-tie"></i>
            <h2>support 24/7</h2>
            <p>It ensures that customers can get help anytime, day or night, for their queries, orders, or any support they need.</p>
            </div>
         

      
    </div>
 </div>
 </div>
 <div class="discount">
    <div class="container">
        <div class="row">
            <div class="col-md-8" id="disc-center">
                <div class="discount-content">
                <h1>you get any medicine on 10% discount</h1>
                <p> Enjoy a 10% discount on your purchases! Save more while getting the best services and products. Shop now and take advantage of this special offer</p>
                <button class="btn ">Buy now</button>
                </div>
                
            </div>
        </div>
    </div>
 </div>
 <div class="card-area">
<div class="container">
    <div class="row">
        
            <div class="col-md-4">
               <div class="card">
                <img src="images/dental.jpg" alt="">
                <div class="overlay">
                <h3>dental & oral care</h3>
                <p> Includes toothpaste, toothbrushes, mouthwash, dental floss, teeth whitening kits, and gum care products.</p>
                <button class="btn">shop dental care</button>
                </div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="card">
                <img src="images/skin-care.jpg" alt="">
                <div class="overlay">
                <h3>Skin & beauty care </h3>
                <p> Includes skincare, haircare, and beauty products like face creams, serums, body lotions, shampoos, sunscreens, and anti-aging products.</p>
                <button class="btn">explore beauty</button>
                </div>
                
               </div>
            </div>
            <div class="col-md-4">
               <div class="card">
                <img src="images/vitamin.jpg" alt="">
                <div class="overlay">
                <h3>vitamins & supplements</h3>
                <p>Covers essential vitamins, multivitamins, protein powders, immunity boosters, herbal supplements, and wellness drinks.</p>
            <button class="btn">Boost your health</button>
                </div>
               </div>
            </div>

    </div>
</div>
</div>
</html>