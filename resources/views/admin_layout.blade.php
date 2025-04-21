<html>
<head>
    <title>
        Admin Dashboard
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/bootstrap/CSS/bootstrap-4.0.0-dist/css/bootstrap.css">
    <style>
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="flex h-screen">
<!-- Sidebar -->
<div class="bg-blue-800 text-white w-64 p-4 fixed md:relative z-50 h-full transform -translate-x-full md:translate-x-0 md:block shadow-md md:shadow-none" id="sidebar">
    <div class="flex justify-between items-center mb-6">
        <div class="d-flex justify-content-center w-100">
        <img src="/images/images-removebg-preview.png" alt="" height="160px" width="160px">
        </div>
        <button class="md:hidden text-white" onclick="toggleSidebar()">
            <i class="fas fa-times">
            </i>
        </button>
    </div>
    <ul>
        <li class="mb-4">
            <a class="flex items-center" href="{{route('admin.dashboard')}}">
                <i class="fas fa-tachometer-alt mr-2">
                </i>
                Dashboard
            </a>
        </li>
        <li class="mb-4">
            <a class="flex items-center" href="{{route('users.index')}}">
                <i class="fas fa-users mr-2">
                </i>
                Users
            </a>
        </li>
        <li class="mb-4">
            <a class="flex items-center" href="{{route('order.index')}}">
                <i class="fas fa-box mr-2">
                </i>
                Orders
            </a>
        </li>
        <li class="mb-4">
            <a class="flex items-center" href="{{route('product.index')}}">
                <i class="fas fa-box-open mr-2">
                </i>
                Products
            </a>
        </li>
        <li class="mb-4">
            <a class="flex items-center" href="{{route('logout')}}">
                <i class="fas fa-sign-out-alt mr-2">
                </i>
                Logout
            </a>
        </li>
    </ul>
</div>
<!-- Main Content -->
<div class="flex-1 flex flex-col">
    <!-- Content -->
    <div class="flex-1 p-8 m-5">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg md:hidden mb-4" onclick="toggleSidebar()">
            <i class="fas fa-bars">
            </i>
        </button>
        @yield('body')
    </div>
</div>
<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
        } else {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
        }
    }
</script>
</body>
</html>
