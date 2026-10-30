
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo e(\App\Models\Setting::where('key', 'company_name')->value('value') ?? 'FinERP'); ?></title>

    <?php
        $favicon = \App\Models\Setting::where('key', 'favicon')->value('value');
        $companyName = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'FinERP';
    ?>

    <?php if($favicon): ?>
        <link rel="icon" href="<?php echo e(asset($favicon)); ?>">
    <?php endif; ?>

    <script>
        document.documentElement.dataset.theme =
            localStorage.getItem('finERP-theme') || 'light';
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            color-scheme: light;
            --page: #f3f6f7;
            --card: #ffffff;
            --text: #10232b;
            --muted: #71808d;
            --border: #e1e7eb;
            --input: #ffffff;
            --input-text: #243746;
            --shadow: 0 20px 55px rgba(15,35,42,.12);
        }

        html[data-theme="dark"] {
            color-scheme: dark;
            --page: #091510;
            --card: #14231f;
            --text: #f1f7f4;
            --muted: #a1b4ab;
            --border: #30463e;
            --input: #1b3029;
            --input-text: #f1f7f4;
            --shadow: 0 20px 55px rgba(0,0,0,.35);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 24px 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--page);
            font-family: 'Inter', sans-serif;
            overflow-y: auto;
            transition: background .25s;
        }

        .auth-card {
            width: 100%;
            max-width: 850px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            border-radius: 16px;
            background: var(--card);
            box-shadow: var(--shadow);
        }

        .brand-panel {
            min-height: 550px;
            padding: 38px 30px 28px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            color: white;
            background: #022d27;
        }

        .brand-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .72;
        }

        .brand-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(0,35,30,.88),
                rgba(0,43,36,.62) 45%,
                rgba(0,27,25,.25) 70%,
                rgba(0,30,27,.94)
            );
        }

        .brand-top,
        .brand-message,
        .brand-features {
            position: relative;
            z-index: 2;
        }

        .brand-title {
            display: block;
            color: #ffffff;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: 4px;
        }

        .brand-subtitle {
            display: block;
            margin-top: 5px;
            color: #d5e4df;
            font-size: 8px;
            letter-spacing: 2px;
        }

        .brand-message {
            margin-top: auto;
            margin-bottom: 35px;
        }

        .brand-message h2 {
            margin: 0;
            max-width: 320px;
            font-size: 26px;
            line-height: 1.3;
            font-weight: 800;
        }

        .brand-message h2 span { color: #f4bd55; }

        .brand-message p {
            max-width: 320px;
            margin-top: 11px;
            color: #e0e9e6;
            font-size: 11px;
            line-height: 1.8;
        }

        .brand-features {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            text-align: center;
        }

        .brand-feature i {
            display: block;
            margin-bottom: 8px;
            color: #f4c76a;
            font-size: 17px;
        }

        .brand-feature span {
            color: white;
            font-size: 10px;
        }

        .form-panel {
            position: relative;
            min-height: 550px;
            padding: 55px 36px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--card);
        }

        .theme-toggle {
            position: absolute;
            top: 17px;
            right: 20px;
            width: 62px;
            height: 32px;
            padding: 3px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid var(--border);
            border-radius: 30px;
            background: var(--page);
            cursor: pointer;
        }

        .theme-toggle i {
            width: 24px;
            height: 24px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            font-size: 12px;
            color: #a8a8a8;
        }

        .theme-toggle .active {
            color: #173b3a;
            background: white;
            box-shadow: 0 1px 4px rgba(0,0,0,.13);
        }

        html[data-theme="dark"] .theme-toggle .active {
            color: #facc15;
            background: #263c34;
        }

        .form-heading h1 {
            margin: 0 0 7px;
            color: var(--text);
            font-size: 23px;
            font-weight: 800;
        }

        .form-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 24px;
        }

        .input-wrap { position: relative; }

        .input-wrap > i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #667787;
            font-size: 14px;
            pointer-events: none;
        }

        .auth-input {
            width: 100%;
            height: 48px;
            padding: 17px 43px 5px;
            border: 1px solid var(--border);
            border-radius: 11px;
            outline: none;
            background: var(--input);
            color: var(--input-text);
            font-family: inherit;
            font-size: 11px;
            transition: border .2s, box-shadow .2s;
        }

        .auth-input::placeholder { color: #a1aab4; }

        .auth-input:focus {
            border-color: #0b8b6b;
            box-shadow: 0 0 0 3px rgba(16,185,129,.10);
        }

        .input-label {
            position: absolute;
            top: 6px;
            left: 42px;
            color: var(--muted);
            font-size: 9px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            top: 0;
            right: 0;
            height: 48px;
            width: 40px;
            border: 0;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
        }

        .terms {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .terms input {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            accent-color: #08745c;
        }

        .auth-link {
            color: #07634f;
            font-size: 10px;
            font-weight: 700;
            text-decoration: none;
        }

        html[data-theme="dark"] .auth-link { color: #65d6ae; }

        .submit-button {
            height: 43px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(100deg,#075b4b,#08745c);
            color: white;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 7px 16px rgba(5,91,73,.16);
            transition: transform .2s, filter .2s;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            filter: brightness(1.08);
        }

        .submit-button i { margin-left: 8px; }

        .form-footer {
            margin-top: 25px;
            text-align: center;
            color: var(--muted);
            font-size: 10px;
        }

        .form-footer a {
            margin-left: 5px;
            color: #07634f;
            font-weight: 700;
            text-decoration: none;
        }

        html[data-theme="dark"] .form-footer a { color: #65d6ae; }

        .error-box {
            margin-top: 14px;
            padding: 10px 12px;
            border-radius: 9px;
            background: #fff0f0;
            color: #b42318;
            font-size: 11px;
        }

        html[data-theme="dark"] .error-box {
            background: #422222;
            color: #ffb4b4;
        }

        @media(max-width: 760px) {
            body {
                padding: 12px;
                align-items: flex-start;
            }

            .auth-card {
                max-width: 480px;
                grid-template-columns: 1fr;
            }

            .brand-panel {
                min-height: 280px;
                padding: 28px 24px 22px;
            }

            .brand-message { margin-bottom: 22px; }
            .brand-message h2 { font-size: 23px; }

            .form-panel {
                min-height: 0;
                padding: 65px 24px 30px;
            }
        }

        @media(max-width: 420px) {
            .brand-features { gap: 4px; }
            .brand-feature span { font-size: 9px; }
            .form-panel {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>

<body>
<main class="auth-card">

    <section class="brand-panel">
        <img class="brand-image"
             src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=85&w=1400&auto=format&fit=crop"
             alt="Modern office building">

        <div class="brand-overlay"></div>

        <div class="brand-top">
            <span class="brand-title">FINERP</span>
            <span class="brand-subtitle">SMARTER BUSINESS MANAGEMENT</span>
        </div>

        <div class="brand-message">
            <h2>Build Your<br>Business <span>Future</span></h2>
            <p>Join businesses using our ERP system to work smarter and grow faster.</p>
        </div>

        <div class="brand-features">
            <div class="brand-feature"><i class="fa-solid fa-coins"></i><span>Finance</span></div>
            <div class="brand-feature"><i class="fa-solid fa-users"></i><span>HR</span></div>
            <div class="brand-feature"><i class="fa-solid fa-cube"></i><span>Inventory</span></div>
            <div class="brand-feature"><i class="fa-solid fa-chart-line"></i><span>Reports</span></div>
        </div>
    </section>

    <section class="form-panel">

        <button type="button" class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
            <i class="fa-solid fa-sun" data-theme-icon="light"></i>
            <i class="fa-solid fa-moon" data-theme-icon="dark"></i>
        </button>

        <div class="form-heading">
            <h1>Create Your Account</h1>
            <p>Fill in your details to get started</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="error-box">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('register')); ?>" class="auth-form">
            <?php echo csrf_field(); ?>

            <div class="input-wrap">
                <i class="fa-regular fa-user"></i>
                <label class="input-label">Full Name</label>
                <input type="text" name="name"
                       value="<?php echo e(old('name')); ?>"
                       class="auth-input"
                       placeholder="Enter your full name"
                       autocomplete="name" required>
            </div>

            <div class="input-wrap">
                <i class="fa-regular fa-envelope"></i>
                <label class="input-label">Email Address</label>
                <input type="email" name="email"
                       value="<?php echo e(old('email')); ?>"
                       class="auth-input"
                       placeholder="you@example.com"
                       autocomplete="email" required>
            </div>

            <div class="input-wrap">
                <i class="fa-solid fa-lock"></i>
                <label class="input-label">Password</label>
                <input type="password" name="password"
                       id="registerPassword"
                       class="auth-input"
                       placeholder="Create a strong password"
                       autocomplete="new-password" required>

                <button type="button" class="password-toggle"
                        onclick="togglePassword('registerPassword', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>

            <div class="input-wrap">
                <i class="fa-solid fa-lock"></i>
                <label class="input-label">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       id="confirmPassword"
                       class="auth-input"
                       placeholder="Re-enter your password"
                       autocomplete="new-password" required>

                <button type="button" class="password-toggle"
                        onclick="togglePassword('confirmPassword', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>

            <label class="terms">
                <input type="checkbox" name="terms" value="1" required>
                <span>
                    I agree to the
                    <a href="#" class="auth-link">Terms &amp; Conditions</a>
                    and
                    <a href="#" class="auth-link">Privacy Policy</a>
                </span>
            </label>

            <button type="submit" class="submit-button">
                Create Account <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="form-footer">
            Already have an account?
            <a href="<?php echo e(route('login')); ?>">Sign In</a>
        </div>
    </section>

</main>

<script>
    function setTheme(theme) {
        document.documentElement.dataset.theme = theme;
        localStorage.setItem('finERP-theme', theme);

        document.querySelectorAll('[data-theme-icon]').forEach(icon => {
            icon.classList.toggle('active', icon.dataset.themeIcon === theme);
        });
    }

    function toggleTheme() {
        const current = localStorage.getItem('finERP-theme') || 'light';
        setTheme(current === 'light' ? 'dark' : 'light');
    }

    function togglePassword(id, button) {
        const input = document.getElementById(id);
        const icon = button.querySelector('i');

        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }

    setTheme(localStorage.getItem('finERP-theme') || 'light');
</script>
</body>
</html>
<?php /**PATH C:\Users\siddiquue traders\Desktop\finance-erp\resources\views/auth/register.blade.php ENDPATH**/ ?>