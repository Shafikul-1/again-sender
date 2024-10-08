<x-app-layout>
    @section('title', 'Your All Emails')
    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4 mt-5">
        <div>
            <a href="{{ route('mailsetup.create') }}" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Add Mails</a>
        </div>
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div
                class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <x-search-form action="{{ route('mailsetup.index') }}" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="search" />
        </div>
    </div>

    <div class="overflow-x-auto font-[sans-serif] bg-gray-900 text-gray-200 ">
        <table class="min-w-full bg-gray-800 border border-gray-700">
            <thead class="whitespace-nowrap">
                <tr>
                    <th class="pl-4 bg-blue-900">
                        <input id="allSelected" type="allSelected" class="hidden peer" />
                        <label for="allSelected"
                            class="relative flex items-center justify-center p-0.5 peer-checked:before:hidden before:block before:absolute before:w-full before:h-full before:bg-gray-600 w-5 h-5 cursor-pointer bg-blue-800 border border-gray-600 rounded overflow-hidden transition-transform duration-300 transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-full fill-white" viewBox="0 0 520 520">
                                <path
                                    d="M79.423 240.755a47.529 47.529 0 0 0-36.737 77.522l120.73 147.894a43.136 43.136 0 0 0 36.066 16.009c14.654-.787 27.884-8.626 36.319-21.515L486.588 56.773a6.13 6.13 0 0 1 .128-.2c2.353-3.613 1.59-10.773-3.267-15.271a13.321 13.321 0 0 0-19.362 1.343q-.135.166-.278.327L210.887 328.736a10.961 10.961 0 0 1-15.585.843l-83.94-76.386a47.319 47.319 0 0 0-31.939-12.438z"
                                    data-name="7-Check" data-original="#000000" />
                            </svg>
                        </label>
                    </th>
                    <th class="p-4 text-sm font-semibold bg-blue-900 text-white text-center">
                        Email
                    </th>
                    <th class="p-4 text-sm font-semibold bg-red-700 text-white text-center">
                        Error
                    </th>
                    <th class="p-4 text-sm font-semibold bg-green-700 text-white text-center">
                        Success
                    </th>
                    <th class="p-4 text-sm font-semibold bg-yellow-700 text-white text-center">
                        Pending
                    </th>
                    <th class="p-4 text-sm font-semibold  text-center animate-pulse bg-gradient-to-r from-pink-500 via-green-500 to-violet-500  text-black">
                        Processing
                    </th>
                    <th class="p-4 text-sm font-semibold bg-blue-100 text-black text-center">
                        No Action
                    </th>
                    <th class="p-4 text-sm font-semibold bg-red-400 text-black text-center">
                        Net Disable
                    </th>
                    <th class="p-4 text-sm font-semibold bg-amber-400 text-black text-center">
                        Total
                    </th>
                    <th class="p-4 text-sm font-semibold bg-purple-700 text-white text-center">
                        Average
                    </th>
                    <th class="p-4 text-sm font-semibold bg-cyan-600 text-white text-center ">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="whitespace-nowrap divide-y divide-gray-700">
                @foreach ($allEmail as $mails)
                    <tr class="hover:bg-gray-700 transition-colors duration-300">
                        <td class="pl-4 w-8">
                            <input id="emailContentCheckBox" type="checkbox" class="hidden peer" />
                            <label for="emailContentCheckBox"
                                class="relative flex items-center justify-center p-0.5 peer-checked:before:hidden before:block before:absolute before:w-full before:h-full before:bg-gray-600 w-5 h-5 cursor-pointer bg-blue-800 border border-gray-600 rounded overflow-hidden transition-transform duration-300 transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-full fill-white" viewBox="0 0 520 520">
                                    <path
                                        d="M79.423 240.755a47.529 47.529 0 0 0-36.737 77.522l120.73 147.894a43.136 43.136 0 0 0 36.066 16.009c14.654-.787 27.884-8.626 36.319-21.515L486.588 56.773a6.13 6.13 0 0 1 .128-.2c2.353-3.613 1.59-10.773-3.267-15.271a13.321 13.321 0 0 0-19.362 1.343q-.135.166-.278.327L210.887 328.736a10.961 10.961 0 0 1-15.585.843l-83.94-76.386a47.319 47.319 0 0 0-31.939-12.438z"
                                        data-name="7-Check" data-original="#000000" />
                                </svg>
                            </label>
                        </td>
                        <td class="text-gray-300 text-center p-4 text-sm">
                            {{ $mails->mail_from }}
                        </td>
                        <td class="text-gray-300 text-center p-4 text-sm">
                            <a href="{{ route('sendingemails.index') . '?email=' . $mails->mail_from . '&status=fail' }}">
                                <div class="mx-auto px-3 py-1 bg-red-700 w-max text-white rounded">{{ $mails->fail_count }}</div>
                            </a>
                        </td>
                        <td class="text-center p-4 text-xs">
                            <a href="{{ route('sendingemails.index') . '?email=' . $mails->mail_from . '&status=success' }}">
                                <div class="mx-auto px-3 py-1 bg-green-700 w-max text-white rounded">{{ $mails->success_count }}</div>
                            </a>
                        </td>
                        <td class="text-center p-4 text-xs">
                            <a href="{{ route('sendingemails.index') . '?email=' . $mails->mail_from . '&status=pending' }}">
                                <div class="mx-auto px-3 py-1 bg-yellow-700 w-max text-white rounded">{{ $mails->pending_count }}</div>
                            </a>
                        </td>
                        <td class="text-center p-4 text-xs">
                            <a href="{{ route('sendingemails.index') . '?email=' . $mails->mail_from . '&status=procesing' }}">
                                <div class="mx-auto px-3 py-1 font-bold bg-[#8cf827da] w-max text-black rounded ">{{ $mails->pending_count }}</div>
                            </a>
                        </td>
                        <td class="text-center p-4 text-xs">
                            <a href="{{ route('sendingemails.index') . '?email=' . $mails->mail_from . '&status=noaction' }}">
                                <div class="mx-auto px-3 py-1 bg-blue-100 w-max text-black rounded">{{ $mails->noaction_count }}</div>
                            </a>
                        </td>
                        <td class="text-center p-4 text-xs">
                            <a href="{{ route('sendingemails.index') . '?email=' . $mails->mail_from . '&status=netdisable' }}">
                                <div class="mx-auto px-3 py-1 bg-red-400 w-max text-black rounded">{{ $mails->netdisable_count }}</div>
                            </a>
                        </td>

                        @php
                        // Get the counts
                        $failCount = $mails->fail_count;
                        $successCount = $mails->success_count;
                        $pendingCount = $mails->pending_count;
                        $noActionCount = $mails->noaction_count;
                        $netDisableCount = $mails->netdisable_count;

                        // Calculate the total
                        $totalSum = $failCount + $successCount + $pendingCount + $noActionCount + $netDisableCount;

                        // Calculate the percentage for each category
                        $failPercentage = ($totalSum > 0) ? (($failCount / $totalSum) * 100) : 0;
                        $successPercentage = ($totalSum > 0) ? (($successCount / $totalSum) * 100) : 0;
                        $pendingPercentage = ($totalSum > 0) ? (($pendingCount / $totalSum) * 100) : 0;
                        $noActionPercentage = ($totalSum > 0) ? (($noActionCount / $totalSum) * 100) : 0;
                        $netDisablePercentage = ($totalSum > 0) ? (($netDisableCount / $totalSum) * 100) : 0;
                    @endphp

                    <td class="text-center p-4 text-xs">
                        <p class="text-xs text-gray-400 ml-2">{{ $totalSum }}</p>
                    </td>
                    <td class="text-center p-4 flex items-center">
                        <div class="bg-gray-600 rounded-full w-full h-4 min-w-[50px] relative">
                            <!-- Fail -->
                            <div class="absolute left-0 h-full rounded-full bg-red-600" style="width: {{ $failPercentage }}%;"></div>
                            <!-- Success -->
                            <div class="absolute left-0 h-full rounded-full bg-green-600" style="width: {{ $successPercentage }}%; margin-left: {{ $failPercentage }}%;"></div>
                            <!-- Pending -->
                            <div class="absolute left-0 h-full rounded-full bg-yellow-600" style="width: {{ $pendingPercentage }}%; margin-left: {{ $failPercentage + $successPercentage }}%;"></div>
                            <!-- No Action -->
                            <div class="absolute left-0 h-full rounded-full bg-blue-100" style="width: {{ $noActionPercentage }}%; margin-left: {{ $failPercentage + $successPercentage + $pendingPercentage }}%;"></div>
                            <!-- Net Disable -->
                            <div class="absolute left-0 h-full rounded-full bg-red-400" style="width: {{ $netDisablePercentage }}%; margin-left: {{ $failPercentage + $successPercentage + $pendingPercentage + $noActionPercentage }}%;"></div>
                        </div>
                    </td>

                        {{-- <p class="text-xs text-gray-400 ml-2">{{ number_format($averagePercentage, 2) }}%</p> --}}

                        {{-- Action --}}
                        <td class="">
                            <div class="flex gap-4 justify-center">
                                <a href="{{ route('mailsetup.edit', $mails->id) }}" class="mr-4" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 fill-blue-500 hover:fill-blue-700" viewBox="0 0 348.882 348.882">
                                        <path
                                            d="m333.988 11.758-.42-.383A43.363 43.363 0 0 0 304.258 0a43.579 43.579 0 0 0-32.104 14.153L116.803 184.231a14.993 14.993 0 0 0-3.154 5.37l-18.267 54.762c-2.112 6.331-1.052 13.333 2.835 18.729 3.918 5.438 10.23 8.685 16.886 8.685h.001c2.879 0 5.693-.592 8.362-1.76l52.89-23.138a14.985 14.985 0 0 0 5.063-3.626L336.771 73.176c16.166-17.697 14.919-45.247-2.783-61.418zM130.381 234.247l10.719-32.134.904-.99 20.316 18.556-.904.99-31.035 13.578zm184.24-181.304L182.553 197.53l-20.316-18.556L294.305 34.386c2.583-2.828 6.118-4.386 9.954-4.386 3.365 0 6.588 1.252 9.082 3.53l.419.383c5.484 5.009 5.87 13.546.861 19.03z"
                                            data-original="#000000" />
                                        <path
                                            d="M303.85 138.388c-8.284 0-15 6.716-15 15v127.347c0 21.034-17.113 38.147-38.147 38.147H68.904c-21.035 0-38.147-17.113-38.147-38.147V100.413c0-21.034 17.113-38.147 38.147-38.147h131.587c8.284 0 15-6.716 15-15s-6.716-15-15-15H68.904C31.327 32.266.757 62.837.757 100.413v180.321c0 37.576 30.571 68.147 68.147 68.147h181.798c37.576 0 68.147-30.571 68.147-68.147V153.388c.001-8.284-6.715-15-14.999-15z"
                                            data-original="#000000" />
                                    </svg>
                                </a>
                                <x-form method="DELETE" action="{{ route('mailsetup.destroy', $mails->id) }}">
                                    <button class="mr-4" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 fill-red-500 hover:fill-red-700" viewBox="0 0 24 24">
                                            <path
                                                d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z"
                                                data-original="#000000" />
                                            <path
                                                d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z"
                                                data-original="#000000" />
                                        </svg>
                                    </button>
                                </x-form>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{ $allEmail->links() }}
    </div>
</x-app-layout>
