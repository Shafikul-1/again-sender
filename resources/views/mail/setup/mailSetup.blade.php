<x-app-layout>
    @section('title', 'Add Email')
    @php
        $errorClass = 'mt-[4rem] text-sm absolute left-0 w-full';
        $wrapper = 'relative flex items-center';
        $inputAttributeClass =
            'px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border outline-[#007bff] rounded transition-all dark:focus:text-white';
    @endphp
    <h2 class="text-center font-bold text-4xl dark:text-white mt-5">Mail Setup Form </h2>

    <div onclick="showModal()" class="flex items-center justify-end mt-3 w-full h-full button">
        <a href="#_"
            class="relative rounded px-5 py-2.5 overflow-hidden group bg-green-500 hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
            <span
                class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
            <span class="relative text-black">Add Signature Link</span>
        </a>
    </div>

    <x-model>
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
    </x-model>

    <x-form action="{{ route('mailsetup.store') }}" method="POST" :fields="[
        [
            'type' => 'text',
            'name' => 'mail_transport',
            'id' => 'mail_transport',
            'placeholder' => 'Enter your mail_transport',
            'value' => 'smtp',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'text',
            'name' => 'mail_host',
            'id' => 'mail_host',
            'placeholder' => 'Enter your mail_host',
            'value' => 'smtp.gmail.com',
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            // 'label' => [
            //     'name' => 'Enter your mail_host',
            //     'attributes' => [
            //         'class' => '',
            //     ],
            // ],
        ],
        [
            'type' => 'text',
            'name' => 'mail_port',
            'id' => 'mail_port',
            'placeholder' => 'Enter your mail_port',
            'value' => '587',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'text',
            'name' => 'mail_username',
            'id' => 'mail_username',
            'placeholder' => 'Enter your mail_username',
            'errorClass' => 'mt-[4rem] text-sm absolute left-0 w-full',
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'text',
            'name' => 'mail_password',
            'id' => 'mail_password',
            'placeholder' => 'Enter your mail_password',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'text',
            'name' => 'mail_encryption',
            'id' => 'mail_encryption',
            'placeholder' => 'Enter your mail_encryption',
            'value' => 'tls',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'text',
            'name' => 'mail_from',
            'id' => 'mail_from',
            'placeholder' => 'Enter your mail_from',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'text',
            'name' => 'mail_sender_name',
            'id' => 'mail_sender_name',
            'placeholder' => 'Enter your mail_sender_name',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'text',
            'name' => 'sender_department',
            'id' => 'sender_department',
            'placeholder' => 'Enter your sender_department',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'text',
            'name' => 'sender_company_logo',
            'id' => 'sender_company_logo',
            'placeholder' => 'Enter your sender_company_logo',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'text',
            'name' => 'sender_website',
            'id' => 'sender_website',
            'placeholder' => 'Enter your website',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'number',
            'name' => 'sender_number',
            'id' => 'sender_number',
            'placeholder' => 'Enter your sender_number',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
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
                'class' => 'bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700'
            ]
        ]"
        class="space-y-6 font-[sans-serif] text-[#333] max-w-full mx-auto submitForm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6">

        <div class="otherLinks flex gap-4">
            <!-- All ICon Show -->
        </div>
        {{-- <div class="space-y-4">
             <!-- If Other Input Fild Add -->
        </div> --}}
    </x-form>

</x-app-layout>
<script>
    let otherLinksData = [];
    let linkIndex = 0;
</script>
@vite(['resources/js/modal.js']);
