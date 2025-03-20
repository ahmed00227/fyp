<html>
<link rel="stylesheet" href="css/bootstrap/CSS/bootstrap-4.0.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 
     <title>login</title>
    <body>
        <div class="login-pg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="login">
                    <form class="form"  onsubmit="return validated()">
                        <div class="login-back">
                           <h2 class="text-center">LOGIN</h2>
                           <label for="username" >Username</label><br>
                           <input type="text" placeholder="Enter your username" id="username"><br>
                           <div id="email-error">please fill up your email</div>
                           <label for="pwd">Password</label><br>
                           <input type="password" placeholder="Enter your password" id="pwd"><br>
                           <div id="pass-error">please fill up your password</div>
                           <input type="submit" class="submit" value="Login"></button>
                           <p>Don't have an account? <a href="#">Sign up</a></p>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    
    </body>
    <script>
    
        function validated(){
            var user=document.getElementById('username').value.trim();
        var pass=document.getElementById('pwd').value.trim();
        var email_error=document.getElementById('email-error');
        var pwd_error=document.getElementById('pass-error');
        let isvalid=true;
        email_error.style.display = "none";
        pwd_error.style.display = "none";
        if(user==""){
            email_error.style.display="block";
            isvalid=false;
        }
        
        if (pass === "") {
                pwd_error.style.display = "block";
                isvalid = false;
            } 

            return isvalid;
        }
    </script>
</html>