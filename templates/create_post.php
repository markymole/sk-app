<?php
if ($role !== "Member" && $role !== "Guest" && $role !== "Unkown") {
    echo <<<HTML
                <div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="bg-white mt-6 mx-auto flex flex-col text-gray-800 border rounded-lg border-gray-300 p-4 shadow-sm w-full px-5 md:px-4 pt-6 pb-4">
                        <input type="hidden" name="action" value="create_post">    
                        <div class="post-preview ">
                            <div>
                                <img class="rounded-lg object-cover mb-2 w-full h-52" id="previewImage" style="display: none;" src="" alt="">
                            </div>
                        </div>
                        <textarea name="post_content" required class="description bg-gray-100 rounded-lg sec p-3 min-h-30 border border-gray-300 outline-none" spellcheck="false" placeholder="Describe everything about this post here"></textarea>

                        <div class="flex justify-between items-center mt-2">
                            <div class="icons flex gap-3 text-gray-500">
                                <div class="flex">
                                    <input type="file" name="post_image" accept="image/*" id="fileInput" style="display:none;">
                                    <label for="fileInput" class="flex items-center">
                                        <svg class="mr-2 cursor-pointer hover:text-gray-700 border border-gray-300 rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        <p id="selectedFileName" class="text-xs hidden sm:block">No files selected</p>
                                    </label>
                                </div>

                            </div>

                            <div class="buttons flex justify-end gap-2">
                                <button type="submit" class="inline-flex items-center justify-center px-6 py-1 mr-3 text-base text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Post</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
HTML;
}
