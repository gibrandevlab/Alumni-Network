@extends('layouts.Dashboard.dashboard')

@section('title', 'Admin - SITRA BSI')

@section('content')
    @if ($peranPengguna == 'admin')
        <div
            class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-800 text-black dark:text-white">
            @include('layouts.Dashboard.navbaratas')
            @include('layouts.Dashboard.sidebarkiri')

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64 p-6">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    @include('components.dashboard.Event Setting.table-event')
                </div>
            </div>
        </div>
    @include('components.dashboard.Event Setting.edit-event')

    @endif
    @include('components.dashboard.Event Setting.create-event')
@endsection
<script>
document.addEventListener('DOMContentLoaded', () => {
    const showCreateModalButton = document.querySelector('button[onclick="showCreateModal()"]');
    const createEventModal = document.getElementById('createEventModal');
    const closeModalButton = document.querySelector('button[onclick="closeModal(\'createEventModal\')"]');

    showCreateModalButton.addEventListener('click', () => {
        createEventModal.classList.remove('hidden');
    });

    closeModalButton.addEventListener('click', () => {
        createEventModal.classList.add('hidden');
    });
});
</script>