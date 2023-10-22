<?php

require_once('./config/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = new Users();
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $barangay = $_POST['barangay'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // $validated_password = isPasswordValid($password);

    if ($password !== $confirm_password) {
        $_SESSION['registration_error'] = 'Passwords do not match.';
        header('Location: register.php');
        exit();
    } else {
        $result = $users->register_user($username, $email, $password, $first_name, $last_name, $barangay, $role, $gender);

        if ($result) {
            // Registration successful, redirect to a success page
            header('Location: login.php');
            exit();
        } else {
            // Registration failed, display an error message
            $_SESSION['registration_error'] = 'Registration failed. Please try again.';
            header('Location: register.php');
            exit();
        }
    }
}

?>

<!DOCTYPE html>

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
        <div class="px-4 py-6 xs:p-0 mx-auto w-full md:max-w-3xl">
            <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
                <form method="post" class="px-5 py-7">
                    <img src="./assets/logo/logo-v1.png" class="w-4/5 lg:w-2/5 h-24 object-cover mb-6" alt="">
                    <div>
                        <?php
                        if (isset($_SESSION['registration_error'])) {
                            echo '<p class="error-message bg-red-200 border border-red-500 text-red-500 px-4 py-2 rounded-lg mb-5">' . $_SESSION['registration_error'] . '</p>';
                            unset($_SESSION['registration_error']);
                        }
                        ?>
                    </div>
                    <h5 class="bold text-gray-700 font-semibold mb-4">Basic Information</h5>
                    <div class="flex gap-6">
                        <div class="w-full">
                            <label for="first_name" class="font-semibold text-sm text-gray-600 pb-1 block">First Name</label>
                            <input type="text" name="first_name" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                        </div>

                        <div class="w-full">
                            <label for="last_name" class="font-semibold text-sm text-gray-600 pb-1 block">Last Name</label>
                            <input type="text" name="last_name" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                        </div>

                    </div>

                    <div class="flex gap-6">
                        <div class="w-full">
                            <label for="gender" class="font-semibold text-sm text-gray-600 pb-1 block">Gender</label>
                            <select name="gender" id="gender" required class="bg-white border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full ">
                                <option selected>Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Others</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <label for="role" class="font-semibold text-sm text-gray-600 pb-1 block">Role</label>
                            <select name="role" id="role" required class="bg-white border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full">
                                <option selected>Select role</option>
                                <option value="SK Chairmain">SK Chairmain</option>
                                <option value="SK Chairwoman">SK Chairwoman</option>
                                <option value="Kagawad">Kagawad</option>
                                <option value="Secretary">Secretary</option>
                                <option value="Treasurer">Treasurer</option>
                                <option value="Member">Member</option>
                            </select>
                        </div>

                    </div>

                    <label for="barangay" class="font-semibold text-sm text-gray-600 pb-1 block">Barangay</label>
                    <select name="barangay" id="barangay" required class="bg-white border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full">
                        <option selected>Choose origin barangay</option>
                        <option> Amsic </option>
                        <option> Anunas </option>
                        <option> Lourdes Northwest </option>
                        <option> Balibago </option>
                        <option> Malabanias </option>
                        <option> Margot </option>
                        <option> Pampang </option>
                        <option> Sapangbato </option>
                        <option> Sta. Teresita </option>

                    </select>

                    <h5 class="bold text-gray-700 font-semibold mb-4">Account Information</h5>

                    <label for="username" class="font-semibold text-sm text-gray-600 pb-1 block">Username</label>
                    <input type="text" name="username" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />

                    <label for="email" class="font-semibold text-sm text-gray-600 pb-1 block">Email</label>
                    <input type="email" name="email" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />


                    <div class="flex gap-6">
                        <div class="w-full">
                            <label for="password" class="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
                            <div class="relative">
                                <input id="password" type="password" name="password" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                                <div id="passwordErrors" class="absolute bg-white rounded-lg px-3 py-2 mt-2 text-sm w-full top-10" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="confirm_password" class="font-semibold text-sm text-gray-600 pb-1 block">Confirm Password</label>
                            <!-- <input id="confirm_password" type="password" name="confirm_password" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" /> -->
                            <div class="relative">
                                <input id="confirm_password" type="password" name="confirm_password" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                                <div id="cpasswordErrors" class="absolute bg-white rounded-lg px-3 py-2 mt-2 text-sm w-full top-10" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
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

                    <label class="flex items-center mt-2 mb-4 px-1">
                        <input type="checkbox" name="agreed" required class="form-checkbox" />
                        <span class="ml-2 text-gray-600 text-sm">I have agreed to the <a href="#" id="showTermsModal" class="text-blue-500">Terms and Conditions</a></span>
                    </label>


                    <button disabled id="submitBtn" type="submit" class="transition duration-200 bg-gray-400 focus:bg-yellow-700 focus:shadow-sm focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                        <span class="inline-block mr-2">Create Account</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </form>

                <div id="termsModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
                    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 overflow-y-auto">
                        <div class="modal-content py-4 text-left px-6 text-gray-700">
                            <h3 class="text-lg font-semibold">Terms and Conditions</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <div class="mt-4">
                                <button id="closeTermsModal" class="inline-flex items-center justify-center px-6 py-1 mr-3 text-base text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Close</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>


                </div>

                <div class="py-5">
                    <div class="grid grid-cols-2 gap-1">
                        <div class="text-center sm:text-right whitespace-nowrap">
                            <a href="login.php" class="transition flex items-center gap-2 duration-200 mx-5 px-5 py-4 cursor-pointer font-normal text-sm rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 ring-inset">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block align-text-top">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </span>
                                <span class="inline-block ml-1">Back to login</span>
                            </a>
                        </div>
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
        const confirmPasswordInput = document.getElementById('confirm_password');
        const showPasswordBtn = document.getElementById('show-password');
        const hiddenIcon = document.querySelector('.hide-eye-icon');
        const shownIcon = document.querySelector('.show-eye-icon');


        showPasswordBtn.addEventListener('click', function() {
            if (passwordInput.type === 'password' && confirmPasswordInput.type === 'password') {
                passwordInput.type = 'text';
                confirmPasswordInput.type = 'text';
                shownIcon.classList.remove('hidden');
                hiddenIcon.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                confirmPasswordInput.type = 'password';
                shownIcon.classList.add('hidden');
                hiddenIcon.classList.remove('hidden');
            }
        });

        function checkPasswordValidation() {
            var password = $("#password").val();
            var errors = isPasswordValid(password);
            var passwordErrors = $("#passwordErrors");
            checkPasswordsMatch();

            passwordErrors.empty();
            passwordErrors.css("display", "block");
            passwordErrors.css("background-color", "#ffcccc");

            if (errors.length > 0) {
                for (var i = 0; i < errors.length; i++) {
                    passwordErrors.append("<p class='text-xs mt-2 lg:mt-0 lg:text-base text-red-500'>" + errors[i] + "</p>");
                }
            } else {
                passwordErrors.append("<p class='text-green-500'>Password is valid.</p>");
                passwordErrors.css("background-color", "#ccffcc");
            }
        }

        function isPasswordValid(password) {
            var errors = [];

            if (password.length < 8) {
                errors.push("Password must be at least 8 characters.");
            }

            if (!/\d/.test(password)) {
                errors.push("Password must contain at least one number.");
            }

            if (!/[^A-Za-z0-9]/.test(password)) {
                errors.push("Password must contain at least one special character.");
            }

            if (!/[A-Z]/.test(password)) {
                errors.push("Password must contain at least one uppercase letter.");
            }

            return errors;
        }

        $("#password").on("input", function() {
            checkPasswordValidation();
        });

        $("#password").on("blur", function() {
            var passwordErrors = $("#passwordErrors");
            passwordErrors.css("display", "none");
            z
        });

        function checkPasswordsMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            var submitBtn = $("#submitBtn");
            var passwordErrors = $("#cpasswordErrors");

            if (password !== confirmPassword) {
                passwordErrors.empty();
                passwordErrors.append("<p class='text-red-500'>Passwords do not match.</p>");
                submitBtn.prop("disabled", true);
                submitBtn.css("background-color", "#718096");
            } else if (!$("input[name='agreed']").prop("checked")) {
                submitBtn.prop("disabled", true);
                submitBtn.css("background-color", "#718096");
            } else {
                passwordErrors.empty();
                submitBtn.prop("disabled", false);
                submitBtn.css("background-color", "#f59e0b");
            }
        }

        $("#password, #confirm_password").on("input", function() {
            checkPasswordsMatch();
        });

        function checkTermsAgreement() {
            var agreed = $("input[name='agreed']").prop("checked");
            var submitBtn = $("#submitBtn");
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();

            if (agreed && password === confirmPassword && password !== "") {
                submitBtn.prop("disabled", false);
                submitBtn.css("background-color", "#f59e0b");
            } else {
                submitBtn.prop("disabled", true);
                submitBtn.css("background-color", "#718096");
            }
        }

        // $("#password, #confirm_password").on("input", function() {
        //     checkPasswordsMatch();
        // });


        $("input[name='agreed']").change(function() {
            checkTermsAgreement();
        });

        $("#showTermsModal").click(function() {
            $("#termsModal").fadeIn();
        });

        $("#closeTermsModal").click(function() {
            $("#termsModal").fadeOut();
        });
    });
</script>