<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Papacino Snacks & Drinks - Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f8f4f0 0%, #f2e3d5 50%, #e8d5c3 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 420px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .login-box {
      width: 100%;
      background: white;
      border-radius: 24px;
      padding: 40px 35px;
      box-shadow: 0 8px 30px rgba(94, 58, 47, 0.08);
      position: relative;
      margin-bottom: 20px;
      border: 1px solid rgba(168, 105, 53, 0.1);
    }

    .logo-box {
      width: 70px;
      height: 70px;
      margin: 0 auto 25px;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f9f1e9;
      border-radius: 16px;
    }

    .logo-outline {
      width: 40px;
      height: 40px;
      border: 3px solid #A86935;
      border-radius: 8px;
      position: relative;
    }

    .logo-outline::after {
      content: "";
      position: absolute;
      width: 20px;
      height: 20px;
      border: 2px solid #A86935;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .title {
      color: #5E3A2F;
      font-size: 28px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 8px;
      letter-spacing: -0.2px;
    }

    .subtitle {
      color: #8a7569;
      font-size: 15px;
      text-align: center;
      margin-bottom: 32px;
      line-height: 1.5;
      font-weight: 400;
    }

    .form-group {
      margin-bottom: 22px;
    }

    .label {
      display: block;
      color: #5E3A2F;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 8px;
      padding-left: 5px;
    }

    .input {
      width: 100%;
      height: 48px;
      background: #f9f9f9;
      border-radius: 12px;
      border: 1px solid #e5d9cf;
      padding: 0 18px;
      font-size: 15px;
      font-family: 'Poppins', sans-serif;
      transition: all 0.2s ease;
    }

    .input:focus {
      outline: none;
      border-color: #A86935;
      background: white;
      box-shadow: 0 0 0 3px rgba(168, 105, 53, 0.1);
    }

    .input::placeholder {
      color: #b8a99e;
    }

    .remember-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 26px;
      font-size: 14px;
      color: #5E3A2F;
    }

    .remember-option {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .remember-section input[type="checkbox"] {
      width: 18px;
      height: 18px;
      border: 1.5px solid #d4c6b9;
      border-radius: 4px;
      accent-color: #A86935;
    }

    .forgot-link {
      color: #A86935;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }

    .forgot-link:hover {
      color: #8d5a2d;
      text-decoration: underline;
    }

    .login-button {
      width: 100%;
      height: 48px;
      background: #A86935;
      border-radius: 12px;
      border: none;
      color: white;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      transition: all 0.3s;
      letter-spacing: 0.2px;
    }

    .login-button:hover {
      background: #8d5a2d;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(168, 105, 53, 0.25);
    }

    .login-button:active {
      transform: translateY(0);
    }

    .footer {
      color: rgba(94, 58, 47, 0.6);
      font-size: 13px;
      text-align: center;
      margin-top: 10px;
    }

    /* Responsive */
    @media (max-width: 480px) {
      .login-box {
        padding: 32px 24px;
        border-radius: 20px;
      }
      
      .title {
        font-size: 24px;
      }
      
      .subtitle {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-box">
      <div class="logo-box">
        <div class="logo-outline"></div>
      </div>
      
      <h1 class="title">Papacino Snacks & Drinks</h1>
      <p class="subtitle">login untuk menggunakan fitur</p>
      
      <form action="{{ route('login') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px; text-align: center;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div style="color: red; margin-bottom: 15px; text-align: center;">
                {{ session('error') }}
            </div>
        @endif

        <div class="form-group">
          <label class="label">Username</label>
          <input type="text" class="input" placeholder="Masukan Username" name="username" value="{{ old('username') }}">
          @error('username')
              <span style="color: red; font-size: 12px;">{{ $message }}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label class="label">Password</label>
          <input type="password" class="input" placeholder="Masukan password" name="password">
          @error('password')
              <span style="color: red; font-size: 12px;">{{ $message }}</span>
          @enderror
        </div>
        
        <button type="submit" class="login-button">Login</button>
      </form>
    </div>
    
    <p class="footer">© 2025 Papacino Snacks & Drinks. All rights reserved.</p>
  </div>
</body>
</html>