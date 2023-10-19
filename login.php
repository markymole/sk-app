<!DOCTYPE html>

<?php

require_once('./config/autoload.php');

if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $users = new Users();

  $emailOrUsername = $_POST["email_or_username"];
  $password = $_POST["password"];

  $user = $users->login($emailOrUsername, $password);

  if ($user) {
    header("Location: index.php");
    exit();
  } else {
    $_SESSION['login_error'] = "Invalid email/username or password.";
    header("Location: login.php");
    exit();
  }
}

?>

<html>

<head>
  <title>SK Webby App</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<div>

  <div class="min-h-screen bg-gray-900 flex flex-col justify-center sm:py-12">
    <div class="p-4 xs:p-0 mx-auto w-full md:max-w-md">
      <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
        <form method="post" class="px-5 py-7">
          <img src="./assets/logo/logo-v1.png" class="w-4/5 lg:w-2/3 h-24 object-cover mx-auto mb-6" alt="">
          <?php
          if (isset($_SESSION['login_error'])) {
            echo '<p class="error-message bg-red-200 border border-red-500 text-red-500 px-4 py-2 rounded-lg mb-5">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']);
          }
          ?>
          <label for="email_or_username" class="font-semibold text-sm text-gray-600 pb-1 block">Username</label>
          <input type="text" name="email_or_username" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />

          <label for="password" class="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
          <input id="password" type="password" name="password" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />

          <div class="text-xs flex justify-end mb-4 text-gray-600">
            <button id="show-password" type="button" class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hide-eye-icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden show-eye-icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>

              <span>Show password</span>
            </button>

          </div>
          <button type="submit" class="transition duration-200 bg-yellow-400 hover:bg-yellow-500 focus:bg-yellow-600 focus:shadow-sm focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
            <span class="inline-block mr-2">Login</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </button>
        </form>
        <div class="py-5">
          <div class="">
            <div class="text-center sm:text-right whitespace-nowrap">
              <a href="register.php" class="transition flex items-center gap-2 duration-200 mx-5 px-5 py-4 cursor-pointer font-normal text-sm rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 ring-inset">
                <span>
                  <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                  </svg>
                </span>
                <span class="inline-block ml-1">Don't have an account?</span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="py-5">
        <div class="grid grid-cols-2 gap-1">
          <div class="text-center sm:text-left whitespace-nowrap">
            <a href="index.php" class="transition duration-200  px-5 py-4 cursor-pointer font-normal text-sm rounded-lg text-gray-300 hover:text-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:text-yellow-400 focus:ring-opacity-50 ring-inset">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block align-text-top">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              <span class="inline-block ml-1">Back to your-app.com</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</html>

<script>
  $(document).ready(function() {
    const passwordInput = document.getElementById('password');
    const showPasswordBtn = document.getElementById('show-password');
    const hiddenIcon = document.querySelector('.hide-eye-icon');
    const shownIcon = document.querySelector('.show-eye-icon');


    showPasswordBtn.addEventListener('click', function() {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        shownIcon.classList.remove('hidden');
        hiddenIcon.classList.add('hidden');
      } else {
        passwordInput.type = 'password';
        shownIcon.classList.add('hidden');
        hiddenIcon.classList.remove('hidden');
      }
    });
  });
</script>