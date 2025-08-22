<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Navy & Yellow Theme</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-navy: #0a192f;
            --accent-yellow: #ffd43b;
            --light-navy: #172a45;
            --light-gray: #f8f9fa;
            --text-light: #e6f1ff;
            --text-gray: #8892b0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: white;
            color: var(--light-navy);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .auth-container {
            display: flex;
            flex: 1;
            min-height: 100vh;
        }

        .auth-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
        }

        .auth-form {
            max-width: 450px;
            margin: 0 auto;
            width: 100%;
        }

        .auth-logo {
            margin-bottom: 1rem;
            text-align: center;
        }

        .auth-logo img {
            height: 100px;
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .auth-description {
            color: var(--text-gray);
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 0;
            /* hapus padding kanan-kiri biar rapih */
            background-color: transparent;
            /* transparan, gak ada background */
            border: none;
            /* hilangkan semua border */
            border-bottom: 2px solid var(--primary-navy);
            /* garis bawah saja */
            border-radius: 0;
            /* buang radius biar lurus */
            color: var(--primary-navy);
            /* teks jelas */
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-bottom-color: var(--accent-yellow);
            /* pas fokus jadi kuning */
            box-shadow: 0 1px 0 0 var(--accent-yellow);
            /* garis glowing tipis */
            background-color: transparent;
        }


        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-gray);
            cursor: pointer;
        }

        .password-container {
            position: relative;
        }

        /* button start */
        .btn-primary {
            width: 100%;
            padding: 20px 40px;
            color: var(--primary-navy);
            font-family: Helvetica, sans-serif;
            font-weight: bold;
            font-size: 1.2rem;
            text-align: center;
            text-decoration: none;
            background-color: var(--accent-yellow);
            display: block;
            border: none;
            position: relative;
            cursor: pointer;


            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            text-shadow: 0px 1px 0px rgba(10, 25, 47, 0.3);
            filter: dropshadow(color=rgba(10, 25, 47, 0.3), offx=0px, offy=1px);

            -webkit-box-shadow: inset 0 1px 0 #FFE5C4, 0 10px 0 rgba(10, 25, 47, 0.7);
            -moz-box-shadow: inset 0 1px 0 #FFE5C4, 0 10px 0 rgba(10, 25, 47, 0.7);
            box-shadow: inset 0 1px 0 #FFE5C4, 0 10px 0 rgba(10, 25, 47, 0.7);

            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;

            transition: all 0.5s ease;
        }

        .btn-primary:hover {
            background-color: var(--accent-yellow);
            transform: translateY(0);
        }

        .btn-primary:active {
            top: 10px;
            background-color: #e6b800;

            -webkit-box-shadow: inset 0 1px 0 #FFE5C4, inset 0 -3px 0 rgba(10, 25, 47, 0.7);
            -moz-box-shadow: inset 0 1px 0 #FFE5C4, inset 0 -3px 0 rgba(10, 25, 47, 0.7);
            box-shadow: inset 0 1px 0 #FFE5C4, inset 0 -3px 0 rgba(10, 25, 47, 0.7);
        }

        /* Shadow effect under button */
        .btn-container {
            position: relative;
            display: block;
            width: 100%;
            margin: 25px 0;
        }

        .btn-container::after {
            content: "";
            height: 100%;
            width: 100%;
            padding: 4px;
            position: absolute;
            bottom: -15px;
            left: 0;
            z-index: -1;
            background-color: rgba(10, 25, 47, 0.4);
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        /* button end */

        .auth-links {
            display: flex;
            justify-content: space-between;
            margin: 1.5rem 0;
        }

        .auth-link {
            color: var(--light-navy);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .auth-divider {
            text-align: center;
            position: relative;
            margin: 2rem 0;
            color: var(--text-gray);
        }

        .auth-divider::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 42%;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .auth-divider::after {
            content: "";
            position: absolute;
            right: 0;
            top: 50%;
            width: 42%;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .auth-providers {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .auth-provider {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-navy);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .auth-provider:hover {
            background-color: var(--accent-yellow);
        }

        .auth-provider:hover i {
            color: var(--primary-navy);
        }

        .auth-provider i {
            color: var(--text-light);
            font-size: 1.2rem;
        }

        .auth-graphics {
            position: relative;
            width: 100%;
            height: 100vh;
            /* full layar */
            overflow: hidden;
        }

        .auth-graphics img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* biar gif selalu penuh tanpa pecah */
            z-index: 1;
        }

        .graphic-content {
            position: relative;
            z-index: 2;
            /* biar di atas gif */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100%;
            padding: 2rem;
            color: #fff;
            /* default putih, nanti bisa override */
            background: rgba(0, 0, 0, 0.3);
            /* optional: overlay gelap tipis supaya teks jelas */
        }

        .graphic-title {
            font-size: 3rem;
            /* jumbo tron */
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .graphic-description {
            font-size: 1.25rem;
            max-width: 700px;
            margin: 0 auto;
        }


        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: var(--accent-yellow);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .floating-button span {
            color: var(--primary-navy);
            font-weight: 600;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-side">
            <div class="auth-form">
                <div class="auth-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-18 w-18 object-contain" />
                </div>

                <h1 class="auth-title">Welcome back!</h1>
                <p class="auth-description">Log in and pick up where you left off.</p>

                <form method="POST" action="/login">
                    @csrf
                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-with-icon">

                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="form-control" placeholder="you@example.com" required autofocus>
                        </div>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <div class="form-label-row">
                            <label for="password" class="form-label">Password</label>

                        </div>
                        <div class="input-with-icon">
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="••••••••" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="auth-links">
                        <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                    </div>


                    {{-- Submit --}}
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>


                {{-- <div class="auth-divider">Or continue with</div> --}}

                {{-- <div class="auth-providers">
                    <div class="auth-provider">
                        <i class="fab fa-google"></i>
                    </div>
                    <div class="auth-provider">
                        <i class="fab fa-gitlab"></i>
                    </div>
                    <div class="auth-provider">
                        <i class="fab fa-microsoft"></i>
                    </div>
                </div>
                
                <div class="auth-signup">
                    Don't have an account? <a href="#" class="auth-link">Sign up</a>.
                </div> --}}
            </div>
        </div>

        <div class="auth-side auth-graphics">
            <div class="graphic-content">
                <img src="{{ asset('images/bg-login.gif') }}" />
                <h2 class="graphic-title">Secure Access</h2>
                <p class="graphic-description">Your data is protected with enterprise-grade security and encryption.</p>
            </div>
        </div>
    </div>


    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' :
                '<i class="far fa-eye-slash"></i>';
        });
    </script>
</body>

</html>
