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