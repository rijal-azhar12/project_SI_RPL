<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Papacino Login</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #E8D5C3 0%, #F2E3D5 50%, #C47E45 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 960px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .login-box {
      width: 100%;
      background: white;
      border-radius: 50px;
      padding: 60px 80px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      position: relative;
      margin-bottom: 20px;
    }

    .logo-box {
      width: 75px;
      height: 75px;
      margin: 0 auto 30px;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo-outline {
      width: 65px;
      height: 62px;
      outline: 4px solid #A86935;
      outline-offset: -2px;
      border-radius: 5px;
    }

    .title {
      color: #5E3A2F;
      font-size: 40px;
      font-weight: 400;
      text-align: center;
      margin-bottom: 15px;
    }

    .subtitle {
      color: #808080;
      font-size: 24px;
      text-align: center;
      margin-bottom: 40px;
    }

    .form-group {
      margin-bottom: 30px;
    }

    .label {
      display: block;
      color: #5E3A2F;
      font-size: 24px;
      font-weight: 400;
      margin-bottom: 10px;
    }

    .input {
      width: 100%;
      height: 60px;
      background: #EEEEEE;
      border-radius: 30px;
      border: 1px solid #A86935;
      padding: 0 25px;
      font-size: 18px;
      font-family: 'Poppins', sans-serif;
    }

    .input:focus {
      outline: none;
      border: 2px solid #A86935;
    }

    .remember-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      font-size: 20px;
      color: #5E3A2F;
    }

    .remember-option {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .remember-section input[type="checkbox"] {
      width: 25px;
      height: 25px;
      border: 1px solid #5E3A2F;
      border-radius: 5px;
    }

    .forgot-link {
      color: #A86935;
      text-decoration: none;
    }

    .forgot-link:hover {
      text-decoration: underline;
    }

    .login-button {
      width: 100%;
      height: 65px;
      background: #A86935;
      border-radius: 50px;
      border: none;
      color: white;
      font-size: 24px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      transition: background 0.3s;
    }

    .login-button:hover {
      background: #8d5a2d;
    }

    .footer {
      color: rgba(0, 0, 0, 0.5);
      font-size: 18px;
      text-align: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .login-box {
        padding: 40px 30px;
        border-radius: 30px;
      }
      
      .title {
        font-size: 32px;
      }
      
      .subtitle {
        font-size: 20px;
      }
      
      .label, .remember-section, .login-button {
        font-size: 18px;
      }
      
      .input {
        height: 50px;
      }
      
      .login-button {
        height: 55px;
      }
    }

    @media (max-width: 480px) {
      .login-box {
        padding: 30px 20px;
        border-radius: 20px;
      }
      
      .title {
        font-size: 28px;
      }
      
      .subtitle {
        font-size: 18px;
      }
      
      .label, .remember-section, .login-button {
        font-size: 16px;
      }
      
      .remember-section {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
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
      <p class="subtitle">Log in to manage sales, menu, and reports for Papacino.</p>
      
      <form>
        <div class="form-group">
          <label class="label">Username</label>
          <input type="text" class="input" placeholder="Enter your username">
        </div>
        
        <div class="form-group">
          <label class="label">Password</label>
          <input type="password" class="input" placeholder="Enter your password">
        </div>
        
        <div class="remember-section">
          <div class="remember-option">
            <input type="checkbox" id="remember">
            <label for="remember">Remember me</label>
          </div>
          <a href="#" class="forgot-link">Forgot password?</a>
        </div>
        
        <button type="submit" class="login-button">Login</button>
      </form>
    </div>
    
    <p class="footer">© 2025 Papacino Snacks & Drinks. All rights reserved.</p>
  </div>
</body>
</html>