<x-app-layout>
    @section('title', 'Edit Sending Email')
    @php
        $errorClass = 'mt-[4rem] text-sm absolute left-0 w-full';
        $wrapper = 'relative flex items-center';
        $inputAttributeClass =
            'px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border outline-[#007bff] rounded transition-all dark:focus:text-white';
    @endphp

    <x-form action="{{ route('sendingemails.update', $sendingEmailEdit->id) }}" method="PUT" :fields="[
        [
            'type' => 'text',
            'name' => 'mails',
            'id' => 'mails',
            'placeholder' => 'Enter your mails',
            'errorClass' => $errorClass,
            'value' => $sendingEmailEdit->mails,
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
            'value' => $sendingEmailEdit->send_time,
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
            'value' => $sendingEmailEdit->mail_content[0]->mail_subject,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
            ],
        ],
        [
            'type' => 'text',
            'name' => 'schedule_time',
            'id' => 'schedule_time',
            'placeholder' => 'Enter your schedule time',
            'errorClass' => $errorClass,
            'value' => $sendingEmailEdit->wait_minute,
            'wrapper' => [
                'class' => $wrapper,
            ],
            'attributes' => [
                'class' => $inputAttributeClass,
                'autocomplete' => 'off',
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
        ],
    ]"
        class="space-y-6 font-[sans-serif] text-[#333] max-w-full mx-auto submitForm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6" enctype="multipart/form-data">
        <div class="relative flex items-center flex-col">
            <select name="mail_from" id="mail_from"
                class="px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border outline-[#007bff] rounded transition-all dark:focus:text-white">
                @foreach ($userSetupEmails as $email)
                    <option value="{{ $email->mail_from }}"
                        {{ $email->id == $sendingEmailEdit->mailsetup_id ? 'selected' : '' }}
                        class="text-black bg-gray-200">
                        {{ $email->mail_from }}
                    </option>
                @endforeach
            </select>
            @error('mail_from')
                <p class="text-red-500 text-start">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-4">
            @error('mail_body')
                <p class="text-red-500">{{ $message }}</p>
            @enderror

            <div>
                <x-texteditor name="mail_body" rows="25" cols="40" class="w-full border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $sendingEmailEdit->mail_content[0]->mail_body }}" />
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-9 py-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"> Submit </button>
            </div>
        </div>
    </x-form>
</x-app-layout>

@vite(['resources/js/modal.js']);
