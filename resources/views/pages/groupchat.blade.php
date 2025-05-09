@extends('layouts.Layout_groupchat')

@section('title', 'Group Chat')

@section('content')
    @include('components.groupchat.header')

    <!-- Chat Container -->
    <main id="chatContainer" class="flex-grow overflow-y-auto p-4 space-y-4 bg-white">
        @foreach ($messages as $msg)
            <div class="flex {{ $msg->user_id === auth()->id() ? 'justify-end' : 'items-start space-x-3' }}">
                @if ($msg->user_id !== auth()->id())
                    <img src="https://via.placeholder.com/40" alt="User Avatar" class="w-8 h-8 rounded-full">
                @endif
                <div class="{{ $msg->user_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black' }} rounded-lg p-3 max-w-xs">
                    <p class="text-sm font-medium">
                        {{ optional($msg->user->profile)->nama ?? 'Anonymous' }}
                    </p>
                    <p class="break-words text-sm mt-1">{!! e($msg->message) !!}</p>
                    @if ($msg->media_path)
                        @if ($msg->media_type === 'image')
                            <img src="{{ asset('storage/'.$msg->media_path) }}" class="mt-2 rounded-lg max-w-full">
                        @elseif ($msg->media_type === 'video')
                            <video src="{{ asset('storage/'.$msg->media_path) }}" controls class="mt-2 rounded-lg max-w-full"></video>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </main>

    @include('components.groupchat.footer')
@endsection

