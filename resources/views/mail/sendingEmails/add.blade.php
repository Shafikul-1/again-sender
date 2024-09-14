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
        // [
        //     'type' => 'text',
        //     'name' => 'mail_body',
        //     'id' => 'mail_body',
        //     'placeholder' => 'Enter your mail_body',
        //     'errorClass' => $errorClass,
        //     'wrapper' => [
        //         'class' => $wrapper,
        //     ],
        //     'attributes' => [
        //         'class' => $inputAttributeClass,
        //     ],
        // ],
        [
            'type' => 'text',
            'name' => 'schedule_time',
            'id' => 'schedule_time',
            'placeholder' => 'Enter your schedule time',
            'errorClass' => $errorClass,
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
            <select name="mail_form" id="mail_form"
                class="px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border outline-[#007bff] rounded transition-all dark:focus:text-white">
                <option disabled selected value="">No Select Sending mail_form</option>
                @foreach ($userSetupEmails as $emails)
                    <option value="{{ $emails }}" class="text-black">{{ $emails }}</option>
                @endforeach
            </select>
            @error('mail_form')
                <p class="text-red-500 text-start">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-4">
        @error('mail_body')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
        @error('mail_files')
            <p class="text-red-500">{{ $message }}</p>
        @enderror

            <div>
                <x-texteditor name="mail_body" rows="25" cols="40" class="w-full border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-9 py-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"> Submit </button>
            </div>
        </div>
    </x-form>
</x-app-layout>



<script>
    document.getElementById('schedule_time').addEventListener('focus', function() {
        if (!document.getElementById('timeInfo')) {
            var newElement = document.createElement('span');
            newElement.id = 'timeInfo';
            newElement.className =
                'dark:text-white text-sm absolute top-[-4rem] left-6 max-w-full bg-gray-700 rounded-md shadow-lg shadow-fuchsia-600 text-center py-1 px-2';
            newElement.innerHTML =
                'input only use time <b>number</b> no space<br> If you want random time, then use <span class="font-bold text-blue-400">|</span> add minute';

            this.parentNode.appendChild(newElement);
        }
    });
    document.getElementById('schedule_time').addEventListener('blur', function() {
        var infoElement = document.getElementById('timeInfo');
        if (infoElement) {
            infoElement.remove();
        }
    });
</script>
