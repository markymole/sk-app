<?php
function renderPosts(&$posts)
{
    require_once './config/autoload.php';

    $image = new Images();
    $date = new General();

    if (!empty($posts)) {
        foreach ($posts  as $post) {
            $post_id = $post['post_id'];
            $post_type = $post['post_type'];
            $post_content = $post['post_content'];
            $author_id = $post['author'];
            $first_name = $post['first_name'];
            $post_image = $post['image_src'];
            $likes = $post['like_count'];
            $comments = $post['comment_count'];

            $last_name = $post['last_name'];
            $created_at = $post['created_at'];
            $archived = $post['archived'];

            $post_author = $first_name . ' ' . $last_name;
            // $barangay = $post['barangay'];
            $barangay = $post['author_barangay'];

            $role = $post['role'];
            $gender = $post['gender'];

            $image_src = $image->getUserProfileImage($author_id, $gender);
            $formatted_date = $date->formatDate($created_at);

            $imageDiv = '';

            if (!empty($post_image)) {
                $imageDiv = <<<HTML
            <a href="post.php?post_id=$post_id">
                <img src="$post_image" class="rounded-lg" alt="">
            </a>
HTML;
            }

            if (isset($_SESSION['user_id'])) {
                $isAuthor = ($_SESSION['user_id'] == $author_id);
            } else {
                $isAuthor = false;
            }

            if ($archived === 0) {

                echo <<<HTML
            <div class="mt-6 w-full" id="post-$post_id">
                <div class='flex items-center justify-center  '>
                    <div class="rounded-xl border p-5 shadow-md bg-white w-full">
                        <div class="flex w-full items-center justify-between border-b pb-3">
                            <div class="flex items-center space-x-4">
                                <a href="profile.php?user_id=$author_id">                                
                                    <img class="h-9 w-9 rounded-full" src="$image_src" alt="">
                                </a>
                                <div class="">
                                    <div class="text-sm lg:text-lg font-bold text-gray-800">$post_author</div>
                                    <p class="hidden lg:block text-xs lg:text-sm text-gray-700">$role</p>
                                    <div class="block lg:hidden text-xs text-neutral-500">$formatted_date</div>
                                </div>
                               
                            </div>
                            <div class="flex items-center space-x-8">
                                <button class="hidden lg:block rounded-2xl border bg-neutral-100 px-3 py-1 text-xs font-semibold ">$barangay</button>
                                <div class="hidden lg:block text-xs text-neutral-500">$formatted_date</div>
                                <!-- buttons -->
                                <div class="flex justify-end space-x-2 relative">
HTML;
                if ($isAuthor) {
                    echo <<<HTML
                                        <button id="post-setting-$post_id" data-key-setting="$post_id" class="post-setting-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-gray-700 w-6 h-6">
                                            <path fill-rule="evenodd" d="M4.5 12a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm6 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm6 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" clip-rule="evenodd" />
                                        </svg>
                                        </button>
                            
                                        <div id="post-action-$post_id" data-key-setting="$post_id" class="hidden top-6 absolute bg-white border border-gray-300 py-2 px-2 rounded-lg shadow-lg">
                                            <a class="edit-post-btn text-gray-600 w-full flex cursor-pointer items-center transition px-8 py-1 rounded-md hover:bg-yellow-100 hover:text-yellow-500" data-post-id="$post_id" data-post-content="$post_content" data-image-src="$image_src" data-post-image="$post_image" data-first-name="$first_name" data-last-name="$last_name" data-formatted-date="$formatted_date">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-1.5 h-4 w-4 md:h-5 md:w-5">
                                                    <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                                                </svg>

                                                <span class="text-sm">Edit</span>
                                            </a>
                                            <div class="delete-post-btn mt-1 text-gray-600 w-full flex cursor-pointer items-center transition px-8 py-1 rounded-md hover:bg-yellow-100 hover:text-yellow-500" data-post-id="$post_id">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mr-1.5 h-4 w-4 md:h-5 md:w-5">
                                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-sm">Delete</span>
                                            </div>
                                        </div>
HTML;
                }
                echo <<<HTML
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-6 grid sm:grid-cols-1 lg:grid-cols-2 gap-4">
                            $imageDiv
                            <div class="text-sm text-gray-700">$post_content</div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between text-gray-800">
                                <div class="flex space-x-4 md:space-x-8">
                                    <button class="like-post-btn text-gray-700 flex cursor-pointer items-center transition hover:text-slate-600" data-post-id="$post_id">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                        <span class="like-count">$likes</span>
                                    </button>
                                    <a href="post.php?post_id=$post_id">  
                                        <button type="button" class=" text-gray-700 flex cursor-pointer items-center transition hover:text-slate-600" 
                                            data-post-id="$post_id">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            <span>$comments</span>
                                        </button>
                                    </a>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
HTML;
            }
        }
    } else {
        echo <<<HTML
    <div class="rounded-xl border p-5 shadow-md bg-white w-full text-gray-700 mt-6 text-center">
        <img src="assets/illustrations/no_record.jpg" class="w-1/2 mx-auto" alt="">
        <h5>No post/announcement found</h5>
    </div>

HTML;
    }
}
