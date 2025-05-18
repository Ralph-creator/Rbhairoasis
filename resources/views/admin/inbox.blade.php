@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Inbox</h1>

        <div class="space-x-3">
            <!-- Back to Dashboard -->
            <a href="{{ route('admin.index') }}"
               class="inline-block bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded shadow text-sm font-semibold">
                Dashboard
            </a>

            <!-- View Archived Messages -->
            <a href="{{ route('admin.archived') }}"
               class="inline-block bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded shadow text-sm font-semibold">
                View Archived Messages
            </a>
        </div>
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
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                                    </form>

                                    <form action="{{ route('admin.messages.archive', $message->id) }}" method="POST" onsubmit="return confirm('Archive this message?');">
                                        @csrf
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Archive</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-gray-600 mt-10">No messages in your inbox.</p>
    @endif
</div>
@endsection
