<x-app-layout>
    @section('title', 'Collect All Data')

    <div class="md:flex md:justify-self-stretch gap-4">
        <a href="{{ route('allLink.index') }}"
            class="my-3 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Add Links
        </a>

        <a href="{{ route('allData.index') }}"
            class="my-3 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            All Data
        </a>

        <a href="{{ route('allData.export') }}" target="_blank"
            class="my-3 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-green-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Downlaod All Data
        </a>

        <a href="{{ route('allData.multiwork') }}"
            class="my-3 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-red-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Delete Selected
        </a>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkAll" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkAll" class="sr-only">Select All</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">SR:</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Time</th>
                    <th scope="col" class="px-6 py-3">URL</th>
                    <th scope="col" class="px-6 py-3">Website</th>
                    <th scope="col" class="px-6 py-3">Address</th>
                    <th scope="col" class="px-6 py-3">Mobile</th>
                    <th scope="col" class="px-6 py-3">WhatsApp</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <form action="{{ route('allData.multiwork') }}" method="post">
                    @csrf
                    <div class="flex gap-4 my-4">
                        <select name="action" id="" class="">
                            <option value="complete" class="capitalize">complete</option>
                            <option value="delete" class="capitalize">delete</option>
                        </select>
                        <button type="submit"
                            class="capitalize dark:text-white font-bold text-3xl bg-gray-500 px-5 py-1 rounded-md my-2 hover:bg-gray-900 cursor-pointer">Submit</button>
                    </div>
                    @foreach ($allData as $key => $data)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input name="multiData[]" value="{{ $data->id }}"
                                        id="checkbox-table-search-{{ $data['id'] }}" type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 link-checkbox">
                                    <label for="checkbox-table-search-{{ $data['id'] }}"
                                        class="sr-only">Select</label>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer">
                                {{ $key + 1 }}
                            </td>
                            <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer"
                                onclick="selectAndCopy(this)">
                                {{ $data['allInfo']['postDetails']['name'] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer"
                                onclick="selectAndCopy(this)">
                                {{ $data['allInfo']['postDetails']['timeText'] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer"
                                onclick="selectAndCopy(this)">
                                @if (!empty($data['allInfo']['postDetails']['url']))
                                    {{-- <a href="{{ $data['allInfo']['postDetails']['url'] }}" class="text-blue-600 dark:text-blue-500" target="_blank" rel="noopener noreferrer"></a> --}}
                                    {{ $data['allInfo']['postDetails']['url'] }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer"
                                onclick="selectAndCopy(this)">
                                {{ $data['allInfo']['contactDetails']['Website'] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer"
                                onclick="selectAndCopy(this)">
                                {{ $data['allInfo']['contactDetails']['Address'] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer"
                                onclick="selectAndCopy(this)">
                                @php
                                    $mobile = $data['allInfo']['contactDetails']['Mobile'] ?? 'N/A';
                                    if (Str::startsWith($mobile, '+')) {
                                        $mobile = substr($mobile, 1);
                                    }
                                @endphp
                                {{ $mobile }}
                            </td>
                            <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer"
                                onclick="selectAndCopy(this)">
                                @php
                                    $WA = $data['allInfo']['contactDetails']['Mobile'] ?? 'N/A';
                                    if ($WA != 'N/A') {
                                        $WA = preg_replace('/[^\d+]/', '', $mobile);
                                        $WA = 'https://wa.me/+' . $WA;
                                    }
                                @endphp
                                {{ $WA }}
                            </td>

                            <td class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer"
                                onclick="selectAndCopy(this)">
                                {{ $data['allInfo']['contactDetails']['Email'] ?? 'N/A' }}
                            </td>
                            <td
                                class="px-6 py-4 max-w-[100px] overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer">
                                {{ $data->status }}
                            </td>
                        </tr>
                    @endforeach

                </form>
            </tbody>
        </table>
        {{ $allData->links() }}
    </div>

    <script>
        function selectAndCopy(element) {
            const text = element.textContent.trim();
            const range = document.createRange();
            const selection = window.getSelection();
            selection.removeAllRanges();
            range.selectNodeContents(element);
            selection.addRange(range);

            navigator.clipboard.writeText(text).then(() => {
                console.log('Text copied to clipboard: ', text);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }

        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.link-checkbox');

        checkAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkAll.checked;
            });
        });
    </script>
</x-app-layout>
