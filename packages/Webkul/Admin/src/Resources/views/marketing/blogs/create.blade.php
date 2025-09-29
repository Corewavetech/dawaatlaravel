<x-admin::layouts>            

    <x-slot:title>
        Create - Blog
    </x-slot>

    <x-admin::form :action="route('admin.marketing.blogs.store')" method="POST" enctype="multipart/form-data">
        <!-- Header -->
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap mb-[20px]">
            <p class="text-xl font-bold text-gray-800 dark:text-white">Create Blog</p>

            <div class="flex items-center gap-x-2.5">
                <a href="{{ route('admin.marketing.blogs.index') }}" class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800">
                    Back
                </a>

                <button type="submit" class="primary-button">
                    Publish
                </button>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="flex gap-2.5 max-xl:flex-wrap" style="margin-top: 20px;">
            <!-- Left Panel -->
            <div class="flex flex-1 flex-col gap-4 max-xl:flex-auto">
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        Blog Details
                    </p>

                    <!-- Author -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">Author Name</x-admin::form.control-group.label>
                        <input type="text" id="author" name="author" placeholder="John Doe"
                            class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300" />
                        <x-admin::form.control-group.error control-name="author" />
                    </x-admin::form.control-group>

                    <!-- Title -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">Title</x-admin::form.control-group.label>
                        <input type="text" id="title" name="title" placeholder="Enter blog title"
                            class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300" />
                        <x-admin::form.control-group.error control-name="title" />
                    </x-admin::form.control-group>

                    <!-- Slug (auto-generated) -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">Slug</x-admin::form.control-group.label>
                        <input type="text" id="slug" name="slug" placeholder="auto-generated-slug"
                            class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300" />
                        <x-admin::form.control-group.error control-name="slug" />
                    </x-admin::form.control-group>

                    <!-- Content with CKEditor -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">Content</x-admin::form.control-group.label>
                        <textarea name="content" id="content-editor" rows="10"
                            class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300"></textarea>
                        <x-admin::form.control-group.error control-name="content" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">SEO Title</x-admin::form.control-group.label>
                        <input type="text" id="seo_title" name="seo_title" placeholder="SEO title"
                            class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300" />
                        <x-admin::form.control-group.error control-name="seo_title" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">SEO Description</x-admin::form.control-group.label>
                        <input type="text" id="seo_description" name="seo_description" placeholder="SEO description"
                            class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300" />
                        <x-admin::form.control-group.error control-name="seo_description" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">SEO Keywords</x-admin::form.control-group.label>
                        <input type="text" id="seo_keywords" name="seo_keywords" placeholder="seo Keywords"
                            class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300" />
                        <x-admin::form.control-group.error control-name="seo_keywords" />
                    </x-admin::form.control-group>

                </div>
            </div>

            <!-- Right Panel -->
            <div class="flex w-[360px] max-w-full flex-col gap-4">
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">Settings</p>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">Type</x-admin::form.control-group.label>
                        <select name="type" id="type" class="custom-select w-full rounded-md border bg-white px-3 py-2.5 text-sm font-normal text-gray-600 transition-all hover:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400">
                            <option value="">Choose</option>
                            <option value="Recipe">Recipe</option>
                            <option value="Blog">Blog</option>
                        </select>
                        
                        <x-admin::form.control-group.error control-name="type" />
                    </x-admin::form.control-group>

                    <!-- Image Upload + Preview -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">Image</x-admin::form.control-group.label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="w-full text-sm text-gray-600 dark:text-gray-300" onchange="previewImage(event)" />
                        <x-admin::form.control-group.error control-name="image" />

                        <div class="mt-2">
                            <img id="image-preview" src="#" alt="Image Preview" class="hidden max-h-40 rounded-md border" />
                        </div>
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>Tags</x-admin::form.control-group.label>
                        <input type="text" id="tags" name="tags" placeholder="Enter tags separated by commas"
                            class="w-full rounded-md border px-3 py-2.5 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300" />
                        <x-admin::form.control-group.error control-name="tags" />
                    </x-admin::form.control-group>

                </div>
            </div>
        </div>

    </x-admin::form>


    @pushOnce('scripts')                    
        <script>   
        
            $(document).off('keyup', '#title').on('keyup', '#title', function(){
                let title = $(this).val();
                let slug = title.toLowerCase()
                                    .replace(/[^a-z0-9\s-]/g, '')  
                                    .trim()
                                    .replace(/\s+/g, '-');   
                                
                $('#slug').val(slug);
            });

            function previewImage(event) {
                const [file] = event.target.files;
                if (file) {
                    const preview = document.getElementById('image-preview');
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove('hidden');
                }
            }
            
        </script>
    @endPushOnce        

</x-admin::layouts>
