@extends('layouts.admin')

@section('title', 'Contact Inquiries - Leaf & Root Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Contact Inquiries</h1>
            <p class="text-sm text-slate-600">Manage and respond to customer messages submitted through Leaf & Root.</p>
        </div>

        {{-- Status Filter Tabs --}}
        <div class="inline-flex rounded-lg border border-slate-200 bg-white p-1 shadow-sm">
            <a href="{{ route('admin.contacts.index') }}" 
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ !request('status') ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:text-slate-900' }}">
                All
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" 
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ request('status') === 'unread' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:text-slate-900' }}">
                Unread
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" 
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ request('status') === 'read' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:text-slate-900' }}">
                Read
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'replied']) }}" 
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ request('status') === 'replied' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:text-slate-900' }}">
                Replied
            </a>
        </div>
    </div>

    {{-- Success Flash Alert --}}
    @if (session('success'))
        <div class="mb-6 rounded-md bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Inquiries Table --}}
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">Received</th>
                        <th scope="col" class="px-6 py-3">Sender</th>
                        <th scope="col" class="px-6 py-3">Subject</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($contacts as $contact)
                        <tr class="hover:bg-slate-50 transition-colors {{ $contact->status === 'unread' ? 'font-semibold bg-emerald-50/30' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                {{ $contact->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-slate-900">{{ $contact->name }}</div>
                                <div class="text-xs text-slate-500 font-normal">{{ $contact->email }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate text-slate-800">
                                {{ $contact->subject }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($contact->status === 'unread')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        Unread
                                    </span>
                                @elseif ($contact->status === 'read')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                        Read
                                    </span>
                                @elseif ($contact->status === 'replied')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Replied
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium space-x-2">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="text-emerald-600 hover:text-emerald-900">View</a>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                No contact messages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($contacts->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection