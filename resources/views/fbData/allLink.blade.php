<x-app-layout>
    @section('title', 'All Link')

    <div class="md:flex md:justify-self-stretch gap-4">
        <button onclick="showModal()" type="button"
            class="my-3 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Add Links
        </button>

        <button type="button" onclick="deleteLink" id="deleteLink"
            class="my-3 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-red-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Delete Selected
        </button>

        <a href="{{ route('allData.index') }}"
            class="my-3 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            All Data
        </a>

    </div>

    <x-model>
        <div class="w-full max-w-lg dark:bg-gray-800 shadow-indigo-400 bg-white shadow-lg rounded-lg p-8 relative">
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
                <h4 class="text-3xl text-gray-800 font-extrabold dark:text-white">Add Links </h4>
            </div>
            <x-form action="{{ route('allLink.store') }}" method="POST" :fields="[
                [
                    'type' => 'text',
                    'name' => 'links',
                    'id' => 'links',
                    'placeholder' => 'https://www......',
                    'errorClass' => 'mt-[4rem] text-sm absolute left-0 w-full',
                    'wrapper' => [
                        'class' => 'relative flex items-center',
                    ],
                    'attributes' => [
                        'class' =>
                            'px-4 py-3 bg-[#f0f1f2] focus:bg-transparent w-full text-sm border outline-[#007bff] rounded transition-all dark:focus:text-white',
                        'autocomplete' => 'off',
                    ],
                ],
            ]" :submit="[
                'text' => 'Submit',
                'attributes' => [
                    'class' =>
                        'px-5 py-2.5 !mt-8 w-full bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg tracking-wide',
                ],
            ]"></x-form>
        </div>
    </x-model>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkAll" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkAll" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        SR:
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Check
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Link
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($allLinks as $key => $link)
                    <tr
                        class="{{ $link->check == 'valid' ? 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 dark:border-gray-700' : 'bg-red-500 dark:bg-red-800 dark:hover:bg-red-600 dark:border-red-700' }}  border-b">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input value="{{ $link->id }}" name="linkId[]" type="checkbox"
                                    class="link-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 ">
                                <label class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $link->id }}
                        </th>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $link->status }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $link->check }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $link->link }}
                        </td>
                        <td class="flex items-center px-6 py-4">
                            <x-form method="DELETE" action="{{ route('allLink.destroy', $link->id) }}">
                                <button class="mr-4" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 dark:hover:fill-white fill-red-500 hover:fill-red-700"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z"
                                            data-original="#000000" />
                                        <path
                                            d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z"
                                            data-original="#000000" />
                                    </svg>
                                </button>
                            </x-form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $allLinks->links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')
                .getAttribute('content');

            let allVal = [];
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.link-checkbox');
            checkAll.addEventListener('change', function() {
                allVal = [];
                checkboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                    if (checkbox.checked) {
                        allVal.push(checkbox.value)
                    }
                });
            });

            // Individual checkbox change handler
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        allVal.push(this.value);
                    } else {
                        allVal = allVal.filter(id => id !== this.value);
                    }
                })
            });

            // const deleteLink = () => {
            //     if (allVal.length === 0) {
            //         alert('No links selected');
            //         return;
            //     }

            //     // Convert string IDs to integers
            //     const intIds = allVal.map(id => parseInt(id, 10));

            //     console.log('IDs to delete:', intIds); // Check the IDs

            //     axios.post("{{ route('allData.multiwork') }}", {
            //             ids: intIds
            //         }, {
            //             headers: {
            //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
            //                     'content'),
            //                 'Content-Type': 'application/json'
            //             }
            //         })
            //         .then(response => {
            //             console.log(response.data);
            //             if (response.data.success) {
            //                 alert('Links deleted successfully!');
            //             } else {
            //                 alert('Failed to delete links');
            //             }
            //         })
            //         .catch(error => {
            //             console.error(error);
            //             alert('An error occurred');
            //         });
            // };


            // document.getElementById('deleteLink').addEventListener('click', deleteLink);
        });
    </script>
    @vite(['resources/js/modal.js']);
</x-app-layout>
