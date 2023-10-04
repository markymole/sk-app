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
                <select name="role" id="role" required class="bg-white border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full">
                    <option value="" <?php echo ($role === '') ? 'selected' : ''; ?>>Select role</option>
                    <option value="SK Chairmain" <?php echo ($role === 'SK Chairmain') ? 'selected' : ''; ?>>SK Chairmain</option>
                    <option value="SK Chairwoman" <?php echo ($role === 'SK Chairwoman') ? 'selected' : ''; ?>>SK Chairwoman</option>
                    <option value="Kagawad" <?php echo ($role === 'Kagawad') ? 'selected' : ''; ?>>Kagawad</option>
                    <option value="Secretary" <?php echo ($role === 'Secretary') ? 'selected' : ''; ?>>Secretary</option>
                    <option value="Treasurer" <?php echo ($role === 'Treasurer') ? 'selected' : ''; ?>>Treasurer</option>
                    <option value="Member" <?php echo ($role === 'Member') ? 'selected' : ''; ?>>Member</option>
                </select>
            </div>

        </div>

        <label for="barangay" class="font-semibold text-sm text-gray-600 pb-1 block">Barangay</label>
        <select name="barangay" id="barangay" required class="bg-white border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full">
            <option value="" <?php echo ($barangay === '') ? 'selected' : ''; ?>>Choose origin barangay</option>
            <option value="Amsic" <?php echo ($barangay === 'Amsic') ? 'selected' : ''; ?>>Amsic</option>
            <option value="Balibago" <?php echo ($barangay === 'Balibago') ? 'selected' : ''; ?>>Balibago</option>
            <option value="Anunas" <?php echo ($barangay === 'Anunas') ? 'selected' : ''; ?>>Anunas</option>
            <option value="Lourdes Northwest" <?php echo ($barangay === 'Lourdes Northwest') ? 'selected' : ''; ?>>Lourdes Northwest</option>
            <option value="Malabanias" <?php echo ($barangay === 'Malabanias') ? 'selected' : ''; ?>>Malabanias</option>
            <option value="Margot" <?php echo ($barangay === 'Margot') ? 'selected' : ''; ?>>Margot</option>
            <option value="Pampang" <?php echo ($barangay === 'Pampang') ? 'selected' : ''; ?>>Pampang</option>
            <option value="Sapangbato" <?php echo ($barangay === 'Sapangbato') ? 'selected' : ''; ?>>Sapangbato</option>
            <option value="Sta. Teresita" <?php echo ($barangay === 'Sta. Teresita') ? 'selected' : ''; ?>>Sta. Teresita</option>
        </select>

        <h5 class="bold text-gray-700 font-semibold mb-4">Account Information</h5>

        <label for="username" class="font-semibold text-sm text-gray-600 pb-1 block">Username</label>
        <input type="text" name="username" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" value="<?php echo $username ?>" />

        <label for="email" class="font-semibold text-sm text-gray-600 pb-1 block">Email</label>
        <input type="email" name="email" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" value="<?php echo $email ?>" />

        <button type="submit" class="transition duration-200 bg-yellow-400 hover:bg-yellow-500 focus:bg-yellow-600 focus:shadow-sm focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50 text-white w-fit px-6 py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
            <span class="inline-block mr-2">Save</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </button>
    </form>
</div>

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
    });
</script>