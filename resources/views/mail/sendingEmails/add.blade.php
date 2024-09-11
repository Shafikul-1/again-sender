<x-app-layout>
    @php
        $errorClass = 'mt-[4rem] text-sm absolute left-0 w-full';
        $wrapper = 'relative flex items-center';
        $inputAttributeClass =
            'px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border outline-[#007bff] rounded transition-all dark:focus:text-white';
    @endphp

    <x-form action="{{ route('sendingemails.store') }}" method="POST" :fields="[
        [
            'type' => 'text',
            'name' => 'mails',
            'id' => 'mails',
            'placeholder' => 'Enter your mails',
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
            'type' => 'datetime-local',
            'name' => 'send_time',
            'id' => 'send_time',
            'placeholder' => 'Enter your send_time',
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
            'name' => 'mail_subject',
            'id' => 'mail_subject',
            'placeholder' => 'Enter your mail_subject',
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
            'name' => 'mail_body',
            'id' => 'mail_body',
            'placeholder' => 'Enter your mail_body',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
            ],
        ],
        [
            'type' => 'file',
            'name' => 'mail_files[]',
            'id' => 'mail_files',
            'placeholder' => 'Enter your mail_files',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'multiple' => 'multiple',
            ],
        ],[
            'type' => 'number',
            'name' => 'schedule_time',
            'id' => 'schedule_time',
            'placeholder' => 'Enter your schedule_time',
            'errorClass' => $errorClass,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
            ],
        ],
    ]"
        :submit="[
            'text' => 'Submit',
            'attributes' => [
                'class' => 'bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700'
            ]
        ]"
        class="space-y-6 font-[sans-serif] text-[#333] max-w-md mx-auto submitForm" enctype="multipart/form-data">

    </x-form>
</x-app-layout>
