@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Archived Messages</h1>
        <a href="{{ route('admin.inbox') }}" class="text-sm text-violet-600 hover:underline">
            Back to Inbox
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($messages->count())
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Message</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach ($messages as $message)
                        <tr class="border-t">
                            <td class="py-3 px-4">{{ $message->name }}</td>
                            <td class="py-3 px-4">{{ $message->email }}</td>
                            <td class="py-3 px-4">{{ $message->message }}</td>
                            <td class="py-3 px-4">{{ $message->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Permanently delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-gray-600 mt-10">No archived messages.</p>
    @endif
</div>
@endsection
