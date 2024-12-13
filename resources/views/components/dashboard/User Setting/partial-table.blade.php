@foreach ($users as $user)
    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" data-id="{{ $user->id }}">
        <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-900 dark:text-white text-center">{{ $user->id }}</td>
        <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-900 dark:text-white text-center">{{ $user->email }}</td>
        <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-900 dark:text-white text-center">{{ $user->role }}</td>
        <td class="px-5 py-4 border-b border-gray-200 text-sm text-center">
            @switch($user->status)
                @case('approved')
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-500">
                        <i class="fas fa-check text-white"></i>
                    </span>
                    @break
                @case('rejected')
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-500">
                        <i class="fas fa-times text-white"></i>
                    </span>
                    @break
                @default
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-gray-500">
                        <i class="fas fa-clock text-white"></i>
                    </span>
            @endswitch
        </td>
        <td class="px-5 py-4 border-b border-gray-200 text-sm text-center space-x-2">
            <button onclick="showDetail({{ $user->id }})" class="text-blue-500 hover:text-blue-700 font-semibold">View</button>
            <button onclick="showEditModal({{ $user->id }})" class="text-yellow-500 hover:text-yellow-700 font-semibold">Edit</button>
            <button onclick="deleteDetail({{ $user->id }})" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
        </td>
    </tr>
@endforeach
