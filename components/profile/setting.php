<?php
require_once './config/autoload.php';

$user = new Users();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $userInfo = $user->getLoggedInUserInfo($userId);

    if ($userInfo) {
        $firstName = $userInfo['first_name'];
        $lastName = $userInfo['last_name'];
        $email = $userInfo['email'];
        $username = $userInfo['username'];
        $barangay = $userInfo['barangay'];
        $role = $userInfo['role'];
        $gender = $userInfo['gender'];
    } else {
    }
} else {
}

?>

<div class="p-2 lg:px-8 lg:py-4">
    <form id="update-user-form" method="post" class="px-5 py-7">
        <h5 class="bold text-gray-700 font-semibold mb-4">Basic Information</h5>
        <div class="flex gap-6">
            <div class="w-full">
                <label for="first_name" class="font-semibold text-sm text-gray-600 pb-1 block">First Name</label>
                <input type="text" name="first_name" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" value="<?php echo $firstName ?>" />
            </div>

            <div class="w-full">
                <label for="last_name" class="font-semibold text-sm text-gray-600 pb-1 block">Last Name</label>
                <input type="text" name="last_name" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" value="<?php echo $lastName ?>" />
            </div>
        </div>

        <div class="flex gap-6">
            <div class="w-full">
                <label for="gender" class="font-semibold text-sm text-gray-600 pb-1 block">Gender</label>
                <select name="gender" id="gender" required class="bg-white border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full">
                    <option value="" <?php echo ($gender === '') ? 'selected' : ''; ?>>Select gender</option>
                    <option value="male" <?php echo ($gender === 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($gender === 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="others" <?php echo ($gender === 'others') ? 'selected' : ''; ?>>Others</option>
                </select>
            </div>

            <div class="w-full">
                <label for="role" class="font-semibold text-sm text-gray-600 pb-1 block">Role</label>
                <input type="role" name="role" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" value="<?php echo $role ?>" readonly />
            </div>

        </div>

        <label for="barangay" class="font-semibold text-sm text-gray-600 pb-1">Barangay</label>
        <input type="text" name="barangay" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" value="<?php echo $barangay ?>" readonly />

        <h5 class="bold text-gray-700 font-semibold mb-4">Account Information</h5>

        <label for="username" class="font-semibold text-sm text-gray-600 pb-1 block">Username</label>
        <input type="text" name="username" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" value="<?php echo $username ?>" />

        <label for="email" class="font-semibold text-sm text-gray-600 pb-1 block">Email</label>
        <input type="email" name="email" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" value="<?php echo $email ?>" />

        <div>
            <button id="deleteAccountBtn" type="button" class="transition duration-200 bg-red-500 hover:bg-red-600 focus:bg-red-600 focus:shadow-sm focus:ring-4 focus:ring-red-500 focus:ring-opacity-50 text-white w-fit px-6 py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">Delete Account</button>
            <button type="submit" class="transition duration-200 bg-yellow-400 hover:bg-yellow-500 focus:bg-yellow-600 focus:shadow-sm focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50 text-white w-fit px-6 py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                <span class="inline-block mr-2">Save</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>
        </div>
    </form>

    <div class="account_modal" id="deleteAccountModal">
        <div class="account_modal_content mx-auto rounded-lg">
            <div id="deleteForm">
                <input type="hidden" name="post_id" id="deletePostID" value="">
                <div class="bg-white mt-6 mx-auto flex flex-col text-gray-800 rounded-lg border-gray-300 p-4 shadow-sm w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-red-500 font-bold uppercase text-lg">You are trying to delete your account</p>
                    <p class="mb-4 font-medium">Confirm your password to proceed</p>
                    <input type="password" name="cpassworddel" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                    <p class="delete-status text-red-500"></p>
                    <div class="mt-6 buttons gap-2">
                        <button id="closeAccountModal" type="button" class="btn border border-gray-300 p-1 px-4 font-semibold cursor-pointer text-gray-500 ml-auto rounded">Cancel</button>
                        <button disabled id="confirmDeleteBtn" type="button" class="inline-flex items-center justify-center px-6 py-1 lg:py-1.5 mr-3 text-base text-center text-white rounded bg-red-400 hover:bg-red-500 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .account_modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .account_modal_content {
        position: absolute;
        min-width: 30%;
        max-width: 100%;
        min-height: 20vh;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
    }

    #confirmDeleteBtn:disabled {
        cursor: not-allowed;
        background-color: gray;
    }
</style>

<script>
    $(document).ready(function() {
        $("#update-user-form").submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "./controllers/update_user.php",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert("User information updated successfully.");
                    } else {
                        alert("Failed to update user information.");
                    }
                }
            });
        });

        $('#deleteAccountBtn').click(function(e) {
            e.preventDefault();
            $('#deleteAccountModal').fadeIn();
        });

        $('#closeAccountModal').click(function() {
            $('#deleteAccountModal').fadeOut();
        });

        $('input[name="cpassworddel"]').on('input', function() {
            var passwordToDelete = $(this).val();
            var confirmDeleteBtn = $('#confirmDeleteBtn');

            if (passwordToDelete.trim() === '') {
                confirmDeleteBtn.prop('disabled', true);
            } else {
                confirmDeleteBtn.prop('disabled', false);
            }
        });

        $('#confirmDeleteBtn').click(function() {
            var passwordToDelete = $('input[name="cpassworddel"]').val();

            $.ajax({
                type: 'POST',
                url: './controllers/delete_account.php',
                data: {
                    cpassworddel: passwordToDelete
                },
                success: function(response) {
                    const parsedResponse = JSON.parse(response);
                    if (parsedResponse.success) {
                        console.log('account deleted');
                        location.reload();
                    } else {
                        $('.delete-status').text(parsedResponse.message);
                        console.log('response: ', parsedResponse.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting account:', error);
                    $('.delete-status').text('Error: ' + error); // Display the error status
                }
            });
        });
    });
</script>