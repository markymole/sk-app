<?php
if (!empty($post)) {
    $post_id = $post['post_id'];
    $post_type = $post['post_type'];
    $post_content = $post['post_content'];
    $author_id = $post['author'];
    $first_name = $post['first_name'];
    $post_image = $post['image_src'];

    $last_name = $post['last_name'];
    $created_at = $post['created_at'];
    $archived = $post['archived'];


    $post_author = $first_name . ' ' . $last_name;
    $barangay = $post['barangay'];
    $role = $post['role'];
    $gender = $post['gender'];

    $likes = $post['num_likes'];
    $comments = $post['num_comments'];

    $image_src = $image->getUserProfileImage($author_id, $gender);
    $formatted_date = $date->formatDate($created_at);
}
?>

<div class="">
    <div>
        <div class="bg-white mt-0 lg:mt-10 border-t lg:border-none md:w-1/2 mx-auto lg:rounded-xl">
            <div class="flex items-center justify-between px-6">
                <div class="flex items-center space-x-3 mt-3 mb-2">
                    <a href="profile.php?user_id=<?php echo $author_id ?>">

                        <img class="h-9 w-9 rounded-full" src="<?php echo $image_src ?>" alt="">
                    </a>
                    <div>
                        <div class="text-base font-semibold text-slate-700"><?php echo $post_author ?></div>
                        <p class="hidden lg:block text-xs lg:text-sm text-gray-700"><?php echo $role ?></p>
                        <div class="flex lg:hidden items-center space-x-8">
                            <div class="text-xs text-neutral-500"><?php echo $formatted_date ?></div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end space-x-2 relative">

                    <div class="hidden lg:block items-center space-x-8 mr-6">
                        <div class="text-xs text-neutral-500"><?php echo $formatted_date ?></div>
                    </div>
                    <!-- <button id="post-setting">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-gray-700 w-6 h-6">
                            <path fill-rule="evenodd" d="M4.5 12a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm6 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm6 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" clip-rule="evenodd" />
                        </svg>
                    </button> -->

                    <div id="post-action" class="hidden top-6 absolute bg-white border border-gray-300 py-3 px-6 rounded-lg shadow-lg">
                        <button class="edit-post-btn text-gray-600 flex cursor-pointer items-center transition hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-1.5 h-4 w-4 md:h-5 md:w-5">
                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                            </svg>
                            <span class="text-sm">Edit</span>
                        </button>
                        <div class="delete-post-btn mt-2 text-gray-600 flex cursor-pointer items-center transition hover:text-slate-600" data-post-id="$post_id">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-1.5 h-4 w-4 md:h-5 md:w-5">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm">Delete</span>
                        </div>
                    </div>


                </div>
            </div>
            <hr>

            <div class="text-start px-6">
                <p class="post-content mt-2 mb-2" id="modalContent"><?php echo $post_content ?></p>
            </div>
            <?php if (!empty($post_image)) : ?>
                <div class="">
                    <img src="<?php echo $post_image ?>" class="modal-image h-96 w-full object-cover" id="modalImage">
                </div>
            <?php endif; ?>
            <div class="px-6 mt-4 mb-4 pb-4">
                <div class="flex items-center justify-between text-slate-500">
                    <div class="flex space-x-4 md:space-x-8">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <button class="like-post-btn flex cursor-pointer items-center transition hover:text-slate-600" data-post-id="<?php echo $post_id ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                <span class="like-count"><?php echo $likes ?></span>
                            </button>
                        <?php else : ?>
                            <button class="like-post-btn flex cursor-pointer items-center transition hover:text-slate-600" data-post-id="<?php echo $post_id ?>" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.20-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                <span class="like-count"><?php echo $likes ?></span>
                            </button>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <button type="button" class="flex cursor-pointer items-center transition hover:text-slate-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span id="modalComment"><?php echo $comments ?></span>
                            </button>
                        <?php else : ?>
                            <button type="button" class="flex cursor-pointer items-center transition hover:text-slate-600" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span id="modalComment"><?php echo $comments ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <div class="comment-container mt-2 px-3 md:px-6">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="w-full mt-4 mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <input class="hidden" type="text" value="<?php echo $post_id ?>" name="post_id">
                            <input type="hidden" name="action" value="create_comment">
                            <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                                <label for="comment" class="sr-only">Your comment</label>
                                <textarea id="comment_content" name="comment_content" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a comment..." required></textarea>
                            </div>
                            <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                                <div class="flex pl-0 space-x-1 sm:pl-2">
                                    <div class="icons flex text-gray-500 m-2">
                                        <div class="flex">
                                            <input type="file" name="comment_image" accept="image/*" id="fileInput" style="display:none;">
                                            <label for="fileInput" class="flex items-center">
                                                <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <p id="selectedFileName" class="text-xs">No files selected</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="inline-flex items-center justify-center px-6 py-1 lg:py-1.5 mr-3 text-base text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                                    Post comment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <div>
                <?php include 'comments-section.php' ?>
            </div>

        </div>

    </div>

</div>