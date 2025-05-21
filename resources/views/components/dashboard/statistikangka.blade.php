<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 p-4 gap-4">
    <div class="card flex items-center justify-between border-b-4 border-amber-500 shadow-md">
        <div class="flex justify-center items-center w-14 h-14 bg-amber-100 rounded-full">
            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-amber-500">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-black">{{ $jumlahPenggunaDisetujui }}</p>
            <p class="text-sm text-gray-500">Users</p>
        </div>
    </div>
    <a href="/dashboard/user/setting?search=pending" class="card flex items-center justify-between border-b-4 border-amber-500 shadow-md">
        <div class="flex justify-center items-center w-14 h-14 bg-amber-100 rounded-full">
            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-amber-500">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-black">{{ $jumlahPenggunaPending }}</p>
            <p class="text-sm text-gray-500">Awaiting Verification</p>
        </div>
    </a>
    <div class="card flex items-center justify-between border-b-4 border-amber-500 shadow-md">
        <div class="flex justify-center items-center w-14 h-14 bg-amber-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" viewBox="0 0 493.474 493.474" xml:space="preserve" style="width: 30px; height: 30px;">
                <g>
                    <g>
                        <path style="fill:#010002;" d="M314.284,314.029c-30.563,23.814-55.479,53.227-80.686,82.352 c-10.786-11.428-20.596-23.559-26.917-38.184c-7.154-16.676-34.342,7.584-27.895,22.598c8.817,20.387,24.519,36.965,39.977,52.584 c6.305,6.416,17.138-0.832,21.491-5.793c27.652-31.398,53.448-64.443,86.638-90.305 C342.816,324.894,333.261,299.242,314.284,314.029z" />
                        <path style="fill:#010002;" d="M402.266,35.399h-76.354c-5.358-5.895-13.04-9.679-21.632-9.679h-29.412v-4.984 C274.867,9.946,260.415,0,246.738,0c-13.678,0-28.13,9.946-28.13,20.736v4.984h-29.413c-8.592,0-16.273,3.784-21.632,9.679H91.176 c-8.099,0-14.594,6.554-14.594,14.619v428.829c0,8.049,6.479,14.627,14.594,14.627h311.091c8.081,0,14.626-6.527,14.626-14.627 V50.018C416.891,41.953,410.346,35.399,402.266,35.399z M387.607,464.238H105.787V64.636h42.285v0.003h13.47 c3.971,11.538,14.772,19.892,27.668,19.892h57.528h57.528c12.896,0,23.697-8.354,27.668-19.892h13.47v-0.003h42.204 L387.607,464.238L387.607,464.238z" />
                        <rect x="133.1" y="114.818" style="fill:#010002;" width="227.273" height="22.729" />
                        <rect x="133.1" y="164.818" style="fill:#010002;" width="227.273" height="22.729" />
                        <rect x="133.1" y="214.818" style="fill:#010002;" width="227.273" height="22.729" />
                        <rect x="133.1" y="264.818" style="fill:#010002;" width="227.273" height="22.729" />
                    </g>
                </g>
            </svg>
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-black">{{ number_format($persentaseRespondenKeseluruhan, 2) }}%</p>
            <p class="text-sm text-gray-500">Response rate</p>
        </div>
    </div>
    <div class="card flex items-center justify-between border-b-4 border-amber-500 shadow-md">
        <div class="flex justify-center items-center w-14 h-14 bg-amber-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" viewBox="0 0 493.474 493.474" xml:space="preserve" style="width: 30px; height: 30px;">
                <g>
                    <g>
                        <path style="fill:#010002;" d="M314.284,314.029c-30.563,23.814-55.479,53.227-80.686,82.352 c-10.786-11.428-20.596-23.559-26.917-38.184c-7.154-16.676-34.342,7.584-27.895,22.598c8.817,20.387,24.519,36.965,39.977,52.584 c6.305,6.416,17.138-0.832,21.491-5.793c27.652-31.398,53.448-64.443,86.638-90.305 C342.816,324.894,333.261,299.242,314.284,314.029z" />
                        <path style="fill:#010002;" d="M402.266,35.399h-76.354c-5.358-5.895-13.04-9.679-21.632-9.679h-29.412v-4.984 C274.867,9.946,260.415,0,246.738,0c-13.678,0-28.13,9.946-28.13,20.736v4.984h-29.413c-8.592,0-16.273,3.784-21.632,9.679H91.176 c-8.099,0-14.594,6.554-14.594,14.619v428.829c0,8.049,6.479,14.627,14.594,14.627h311.091c8.081,0,14.626-6.527,14.626-14.627 V50.018C416.891,41.953,410.346,35.399,402.266,35.399z M387.607,464.238H105.787V64.636h42.285v0.003h13.47 c3.971,11.538,14.772,19.892,27.668,19.892h57.528h57.528c12.896,0,23.697-8.354,27.668-19.892h13.47v-0.003h42.204 L387.607,464.238L387.607,464.238z" />
                        <rect x="133.1" y="114.818" style="fill:#010002;" width="227.273" height="22.729" />
                        <rect x="133.1" y="164.818" style="fill:#010002;" width="227.273" height="22.729" />
                        <rect x="133.1" y="214.818" style="fill:#010002;" width="227.273" height="22.729" />
                        <rect x="133.1" y="264.818" style="fill:#010002;" width="227.273" height="22.729" />
                    </g>
                </g>
            </svg>
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-black">{{ $totalResponden }}</p>
            <p class="text-sm text-gray-500">total Response</p>
        </div>
    </div>
</div>
