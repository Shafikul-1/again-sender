<x-app-layout>
    @section('title', 'Edit Email')
    @php
        $errorClass = 'mt-[4rem] text-sm absolute left-0 w-full';
        $wrapper = 'relative flex items-center';
        $inputAttributeClass =
            'px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border outline-[#007bff] rounded transition-all dark:focus:text-white';
    @endphp

    <h2 class="font-bold text-center dark:text-white text-4xl mt-5">Setup Mail Update Form</h2>
   <div onclick="showModal()" class="flex items-center justify-end mt-3 w-full h-full button">
    <a href="#_"
        class="relative rounded px-5 py-2.5 overflow-hidden group bg-green-500 hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
        <span
            class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
        <span class="relative text-black">Add Signature Link</span>
    </a>
</div>

<div
    class="modal hidden fixed inset-0 p-4  flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]">
    <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-8 relative">
        <svg onclick="hideModal()" xmlns="http://www.w3.org/2000/svg"
            class="w-3.5 cursor-pointer shrink-0 fill-gray-400 hover:fill-red-500 float-right"
            viewBox="0 0 320.591 320.591">
            <path
                d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                data-original="#000000"></path>
            <path
                d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                data-original="#000000"></path>
        </svg>

        <div class="my-8 text-center">
            <h4 class="text-3xl text-gray-800 font-extrabold">Add Signature Link & Icon</h4>
        </div>
        <div class="relative flex items-center my-2">
            <input type="text" placeholder="Enter Icon Link"
                class="px-4 py-3 bg-white text-gray-800 w-full text-sm border border-gray-300 focus:border-blue-600 outline-none rounded-lg"
                other-icon-link="iconlink" />
        </div>
        <div class="relative flex items-center my-2">
            <input type="text" placeholder="Enter Your Link"
                class="px-4 py-3 bg-white text-gray-800 w-full text-sm border border-gray-300 focus:border-blue-600 outline-none rounded-lg"
                other-acc-link="yourlink" />
        </div>

        <button onclick="addLinks()" type="button"
            class="px-5 py-2.5 !mt-8 w-full bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg tracking-wide">Add</button>
    </div>
</div>

    <x-form action="{{ route('mailsetup.update', $editData->id) }}" method="PUT"
        :fields="[
            [
                'type' => 'text',
                'name' => 'mail_transport',
                'id' => 'mail_transport',
                'placeholder' => 'Enter your mail_transport',
                'value' => $editData->mail_transport,
                'errorClass' => $errorClass,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'text',
                'name' => 'mail_host',
                'id' => 'mail_host',
                'placeholder' => 'Enter your mail_host',
                'value' => $editData->mail_host,
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
                'errorClass' => $errorClass,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
            ],
            [
                'type' => 'text',
                'name' => 'mail_port',
                'id' => 'mail_port',
                'placeholder' => 'Enter your mail_port',
                'value' => $editData->mail_port,
                'errorClass' => $errorClass,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'text',
                'name' => 'mail_username',
                'id' => 'mail_username',
                'placeholder' => 'Enter your mail_username',
                'errorClass' => 'mt-[4rem] text-sm absolute left-0 w-full',
                'value' => $editData->mail_username,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'text',
                'name' => 'mail_password',
                'id' => 'mail_password',
                'placeholder' => 'Enter your mail_password',
                'errorClass' => $errorClass,
                'value' => $editData->mail_password,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'text',
                'name' => 'mail_encryption',
                'id' => 'mail_encryption',
                'placeholder' => 'Enter your mail_encryption',
                'value' => $editData->mail_encryption,
                'errorClass' => $errorClass,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'text',
                'name' => 'mail_from',
                'id' => 'mail_from',
                'placeholder' => 'Enter your mail_from',
                'value' => $editData->mail_from,
                'errorClass' => $errorClass,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'text',
                'name' => 'mail_sender_name',
                'id' => 'mail_sender_name',
                'placeholder' => 'Enter your mail_sender_name',
                'errorClass' => $errorClass,
                'value' => $editData->mail_sender_name,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'text',
                'name' => 'sender_department',
                'id' => 'sender_department',
                'placeholder' => 'Enter your sender_department',
                'errorClass' => $errorClass,
                'value' => $editData->sender_department,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'text',
                'name' => 'sender_company_logo',
                'id' => 'sender_company_logo',
                'placeholder' => 'Enter your sender_company_logo',
                'errorClass' => $errorClass,
                'value' => $editData->sender_company_logo,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'text',
                'name' => 'sender_website',
                'id' => 'sender_website',
                'placeholder' => 'Enter your website',
                'errorClass' => $errorClass,
                'value' => $editData->sender_website,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'number',
                'name' => 'sender_number',
                'id' => 'sender_number',
                'placeholder' => 'Enter your sender_number',
                'errorClass' => $errorClass,
                'value' => $editData->sender_number,
                'wrapper' => [
                    'class' => $wrapper,
                ],
                'attributes' => [
                    'class' => $inputAttributeClass,
                ],
                'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            ],
            [
                'type' => 'hidden',
                'name' => 'other_links',
                'id' => 'otherLinksArray',
            ],
        ]"
        :submit="[
            'text' => 'Submit',
            'attributes' => [
                'class' => 'bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 w-['.'7rem'.'] h-['.'3rem'.']'
            ]
        ]"
         class="space-y-6 font-[sans-serif] text-[#333] max-w-full mx-auto submitForm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6" >

       <div class="">
        <h3 class="text-2xl font-bold dark:text-white">Other Links</h3>
        <div class="otherLinks flex gap-4 mt-5 ">
            @foreach ($editData->other_links as $index => $otherLinks)
                <div class="relative rounded-full border p-3 dark:border-white" data-index="{{ $otherLinks['linkIndex'] }}">
                    <i class="fa fa-solid fa-xmark absolute top-[-15px] right-0 dark:text-white cursor-pointer" onclick="otherIconRemove(this)"></i>
                    <a href="{{ $otherLinks['yourLink'] }}">
                        <img width="25px" src="{{ $otherLinks['iconLink'] }}" alt="">
                    </a>
                </div>
            @endforeach
        </div>
       </div>

    </x-form>

    <script>
        let otherLinksData = @json($editData->other_links);
        let linkIndex = otherLinksData.length;
    </script>

    @vite(['resources/js/modal.js']);
</x-app-layout>
