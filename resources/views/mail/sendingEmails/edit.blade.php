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
    ]"
        class="space-y-6 font-[sans-serif] text-[#333] max-w-full mx-auto submitForm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6" enctype="multipart/form-data">

        <div class="relative flex items-center">
            <button  onclick="showModal()" type="button" class="px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border outline-[#007bff] rounded transition-all dark:focus:text-white" title="Upload Files">Upload Files</button>
        </div>

        <x-model>
            <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-8 relative">
                <div class="flex justify-between">
                    <input type="file" name="mail_files[]" id="mail_files" multiple="multiple" placeholder="Enter your mail_files" class="px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-1/2 text-sm border outline-[#007bff] rounded transition-all dark:focus:text-black">
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
                </div>
                <div class="my-8 text-center">
                    <h4 class="text-3xl text-gray-800 font-extrabold capitalize">upload and select file</h4>
                </div>
                <input type="hidden" id="mail_previse_file" name="mail_previse_file" class="mail_previse_file" value="{{ implode(',', $sendingEmailEdit->mail_content[0]->mail_files)  }}">
                <div class="relative grid grid-cols-3 gap-2">
                    @if (count($allFiles) <= 0)
                       <h3 clas="text-3xl font-bold text-center">No Added Files</h3>
                    @else
                    @foreach ($allFiles as $file)
                        <div class="selectImage cursor-pointer relative">
                           {{-- <a href="{{ route('sendingemails.uploadFileDelete', $file) }}">
                            <i class="fa-solid fa-trash text-3xl top-4 right-4 absolute text-red-500 cursor-pointer"></i>
                           </a> --}}
                           <img class="h-auto max-w-full rounded-lg" onclick="selectImage(event)" name="{{ $file }}" src="{{ asset('mailFile/' . $file) }}" alt="">
                            {{-- <img class="h-auto max-w-full rounded-lg" onclick="selectImage(event)" name="{{ $files }}" src="{{ asset('mailFile/' . $files) }}" alt=""> --}}
                        </div>
                    @endforeach
                    @endif
                </div>

                <button onclick="hideModal()" type="button"
                    class="px-5 py-2.5 !mt-8 w-full bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg tracking-wide">Add</button>
            </div>
        </x-model>


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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mail_previse_file = document.querySelector('.mail_previse_file');
        const selectedImages = mail_previse_file.value.split(',');

        document.querySelectorAll('img').forEach(image => {
            const imageName = image.name;
            if (selectedImages.includes(imageName)) {
                image.classList.add('p-1', 'rounded', 'border-4', 'border-sky-500');
            }
        });
    });

    function selectImage(event) {
        const mail_previse_file = document.querySelector('.mail_previse_file');
        const imageName = event.target.name;
        const selectImage = event.currentTarget;

        // Check if the image is already selected
        const isSelected = selectImage.classList.contains('p-1') &&
            selectImage.classList.contains('rounded') &&
            selectImage.classList.contains('border-4') &&
            selectImage.classList.contains('border-sky-500');

        if (isSelected) {
            // If the image is selected, remove its name from the input value
            const selectedImages = mail_previse_file.value.split(',').filter(name => name !== imageName);
            mail_previse_file.value = selectedImages.join(',');
            selectImage.classList.remove('p-1', 'rounded', 'border-4', 'border-sky-500');
        } else {
            // If the image is not selected, add its name to the input value
            const selectedImages = mail_previse_file.value ? mail_previse_file.value.split(',') : [];
            selectedImages.push(imageName);
            mail_previse_file.value = selectedImages.join(',');
            selectImage.classList.add('p-1', 'rounded', 'border-4', 'border-sky-500');
        }

        // console.log(mail_previse_file.value);
    }
</script>
@vite(['resources/js/modal.js']);
