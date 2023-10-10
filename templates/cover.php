<?php

$cover_image = $image->getUserProfileImage($id, $gender);
?>

<div class="px-3 lg:px-0 max-w-5xl mx-auto mt-10">
    <div class="bg-white border border-gray-300 rounded-lg ">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-baseline px-8 md:px-10 pt-6">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <img src="<?php echo $cover_image ?>" class="h-32 w-32 border-4 object-cover border-white rounded-full cursor-pointer" id="profileImage">
                    <div class="absolute top-30 w-56 bg-white border border-gray-300 rounded-lg shadow-md hidden" id="profilePictureOptions">
                        <ul class="py-2">
                            <li class="cursor-pointer block px-4 py-2 text-sm text-gray-700" id="uploadProfilePicture">Upload Profile Picture</li>
                            <!-- <li class="cursor-pointer block px-4 py-2 text-sm text-gray-700" id="removeProfilePicture">Remove Profile Picture</li> -->
                            <!-- <li class="cursor-pointer block px-4 py-2 text-sm text-gray-700" id="showProfilePicture">Show Profile Picture</li> -->
                        </ul>
                    </div>
                </div>

                <div class="mt-2">
                    <p class="text-base md:text-xl"><?php echo $firstname ?> <?php echo  $lastname ?></p>
                    <p class="text-sm md:text-base text-gray-700"><?php echo $role ?></p>
                    <p class="text-sm md:text-base text-gray-700">From: <?php echo $barangay ?></p>
                </div>

            </div>
            <div class="flex-1 flex flex-col items-center lg:items-end justify-end mt-2">
                <div class="flex items-center mt-2">
                    <button class="flex gap-2 items-center justify-center px-6 py-1 lg:py-1.5 mr-3 text-base text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                        </svg>
                        <span>Follow</span>
                    </button>
                    <button class="flex gap-2 items-center justify-center px-6 py-1 lg:py-1.5 mr-3 text-base text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Message</span>
                    </button>
                </div>
            </div>
        </div>

        <hr class="mt-6">
        <nav class="">
            <div class="px-5 md:px-10 py-4 w-full">
                <div class="flex items-center">
                    <ul class="flex gap-4 justifiy-center md:justify-start flex-row font-medium mt-0 mr-6 md:space-x-8 text-xs md:text-base">
                        <li>
                            <a href="#" id="about-link" class="text-gray-700 dark:text-white hover:underline">About</a>
                        </li>
                        <li>
                            <a href="#" id="followers-link" class="text-gray-700 dark:text-white hover:underline">Followers</a>
                        </li>
                        <li>
                            <a href="#" id="following-link" class="text-gray-700 dark:text-white hover:underline">Following</a>
                        </li>
                        <li>
                            <a href="#" id="photos-link" class="text-gray-700 dark:text-white hover:underline">Photos</a>
                        </li>
                        <li>
                            <a href="#" id="settings-link" class="text-gray-700 dark:text-white hover:underline">Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>
</div>

<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="uploadProfilePictureModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-full sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-base mb-4 leading-6 font-medium text-gray-900">Upload Profile Picture</h3>
                <div class="mt-2">

                    <img id="profileImagePreview" class="hidden w-40 h-40 mt-4 mx-auto border-4 border-white rounded-full" />

                    <div id="upload-container" class="flex items-center justify-center w-full">
                        <label for="profileImageInput" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input name="profile_image" accept="image/*" id="profileImageInput" type="file" class="hidden" />
                        </label>
                    </div>

                    <p class="text-sm text-gray-500 mt-2" id="selectedProfileImage">No file selected</p>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" id="uploadProfilePictureButton">
                    Upload
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closeUploadProfilePictureModal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const profileImageInput = document.getElementById('profileImageInput');
    const selectedProfileImage = document.getElementById('selectedProfileImage');
    const profileImagePreview = document.getElementById('profileImagePreview');
    const uploadContainer = document.getElementById('upload-container');

    function toggleProfilePictureOptions() {
        const dropdown = document.getElementById('profilePictureOptions');
        dropdown.classList.toggle('hidden');
    }

    const profileImage = document.getElementById('profileImage');
    profileImage.addEventListener('click', toggleProfilePictureOptions);

    const uploadProfilePicture = document.getElementById('uploadProfilePicture');
    uploadProfilePicture.addEventListener('click', function() {
        const dropdown = document.getElementById('profilePictureOptions');
        dropdown.classList.toggle('hidden');

        $('#uploadProfilePictureModal').fadeIn();
    });


    const closeUploadProfilePictureModal = document.getElementById('closeUploadProfilePictureModal');

    closeUploadProfilePictureModal.addEventListener('click', function() {
        $('#uploadProfilePictureModal').fadeOut();
        dropdown.classList.toggle('hidden');
    });

    const cancelUploadProfilePictureModal = document.getElementById('closeUploadProfilePictureModal');

    cancelUploadProfilePictureModal.addEventListener('click', function() {
        profileImageInput.value = '';

        uploadContainer.style.display = 'block';
        profileImagePreview.style.display = 'none';
        selectedProfileImage.textContent = 'No file selected';

    });


    profileImageInput.addEventListener('change', function() {
        const selectedFile = this.files[0];
        if (selectedFile) {
            selectedProfileImage.textContent = selectedFile.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                profileImagePreview.src = e.target.result;
            };
            reader.readAsDataURL(selectedFile);

            uploadContainer.style.display = 'none';
            profileImagePreview.style.display = 'block';
        } else {
            selectedProfileImage.textContent = 'No file selected';
            profileImagePreview.src = '';
            profileImage.style.display = 'block';
        }
    });

    const uploadProfilePictureButton = document.getElementById('uploadProfilePictureButton');
    uploadProfilePictureButton.addEventListener('click', function() {
        const formData = new FormData();
        const profileImageInput = document.getElementById('profileImageInput');
        formData.append('profile_image', profileImageInput.files[0]);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', './upload_profile.php', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                location.reload();
                $('#uploadProfilePictureModal').fadeOut();

            } else {
                console.error('Profile picture upload failed:', xhr.statusText);
            }
        };

        xhr.send(formData);
    });
</script>