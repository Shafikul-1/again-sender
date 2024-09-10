<x-app-layout>
    @php
        $errorClass = 'mt-[4rem] text-sm absolute left-0 w-full';
        $wrapper = 'relative flex items-center';
        $inputAttributeClass =
            'px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border outline-[#007bff] rounded transition-all';
    @endphp
    <x-form action="{{ route('mailsetup.store') }}" method="POST" formHeading="<h2 class='font-extrabold text-4xl dark:text-white text-center'>Mail Setup Form</h2>" :fields="[
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
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
        [
            'type' => 'number',
            'name' => 'mail_username',
            'id' => 'mail_username',
            'placeholder' => 'Enter your mail_username',
            'errorClass' => 'mt-[4rem] text-sm absolute left-0 w-full',
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
            'value' => 'tls',
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
            'name' => 'department',
            'id' => 'department',
            'placeholder' => 'Enter your department',
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
            'name' => 'whatsapp_link',
            'id' => 'whatsapp_link',
            'placeholder' => 'Enter your whatsapp_link',
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
            'name' => 'instagram_link',
            'id' => 'instagram_link',
            'placeholder' => 'Enter your instagram_link',
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
            'name' => 'website',
            'id' => 'website',
            'placeholder' => 'Enter your website',
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
            'name' => 'profile_link',
            'id' => 'profile_link',
            'placeholder' => 'Enter your profile_link',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
            ],
            'additionalContent' => '<i class=\'fa-regular fa-envelope w-[18px] h-[18px] absolute right-4\'></i>',
        ],
    ]"
        :submit="[
            'text' => 'Send',
            'attributes' => [
                'class' => 'bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700',
            ],
        ]"
        class="space-y-6 font-[sans-serif] text-[#333] max-w-md mx-auto" />


</x-app-layout>
