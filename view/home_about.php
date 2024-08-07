<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Homepage</title>
    <link rel="stylesheet" href="../css/home_about.css">
</head>
<body>

<header>
    <h1>AJC Case Manager</h1>
    <nav>
        <ul>
            <li><a href="#">Home/About</a></li>
            <li><a href="https://gh.linkedin.com/in/nyameye-akumia">Contact</a></li>
            <li class="searchbar">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="icon">
                    <g>
                        <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                    </g>
                </svg>
                <input class="input" type="search" placeholder="Search">
            </li>
        </ul>
    </nav>
</header>

<section id="description">
    <h2>Zima Blue</h2>
    <p>Martha Agyeman, Princess Asiru-Balogun and Nyameye Akumia are developing a web application to manage AJC cases.</p>
    <p>The administrator (superadmin) will have additional funcitonality that regular users do not have. Below are their login credentials:</p>
    <p>Administrator Email: superadmin@ashesi.edu.gh</p>
    <p>Administrator Password: Superadmin2024!</p>
    <p></p>
</section>
<div id="middle">
    <button class="button2" onclick="window.location.href = '../login/signup_view.php';">Register</button>
    <button class="button2" onclick="window.location.href = '../login/login_view.php';">Login</button>
    <br>
    <br>
</div>
<footer>
    <p>&copy; 2024 Ashesi Judicial Council, Case Manager. All rights reserved.</p>
</footer>

</body>
</html>