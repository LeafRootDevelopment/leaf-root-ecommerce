@extends('layouts.admin')

@section('title', 'View Contact Message - Leaf & Root Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Back Link --}}
    <div class="mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center text-sm font-medium text-slate-600 hover:text-slate-900">
            &larr; Back to Inquiries
        </a>
    </div>

    {{-- Success Flash Alert --}}
    @if (session('success'))
        <div class="mb-6 rounded-md bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Message Details --}}
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-6">
                <div class="flex items-start justify-between border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">{{ $contact->subject }}</h1>
                        <p class="text-xs text-slate-500 mt-1">Received on {{ $contact->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                    <div>
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
                    </div>
                </div>

                {{-- Sender Information --}}
                <div class="mb-6 bg-slate-50 rounded-md p-4 border border-slate-100">
                    <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Sender Information</div>
                    <div class="text-sm font-semibold text-slate-900">{{ $contact->name }}</div>
                    <div class="text-sm text-slate-600">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" class="text-emerald-600 hover:underline">
                            {{ $contact->email }}
                        </a>
                    </div>
                </div>

                {{-- Message Body --}}
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Message Body</div>
                    <div class="text-sm text-slate-800 whitespace-pre-line leading-relaxed bg-white border border-slate-100 rounded-md p-4">
                        {{ $contact->message }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Management Controls --}}
        <div class="space-y-6">
            {{-- Status Management Form --}}
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-6">
                <h2 class="text-base font-semibold text-slate-900 mb-4">Manage Status</h2>
                
                <form action="{{ route('admin.contacts.update-status', $contact) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="block text-xs font-medium text-slate-700 mb-1">Current Status</label>
                        <select id="status" name="status" class="w-full rounded-md border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="unread" {{ old('status', $contact->status) === 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ old('status', $contact->status) === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ old('status', $contact->status) === 'replied' ? 'selected' : '' }}>Replied</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-2 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md transition-colors">
                        Update Status
                    </button>
                </form>
            </div>

            {{-- Communication & Deletion Actions --}}
            <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-6 space-y-3">
                <h2 class="text-base font-semibold text-slate-900 mb-2">Quick Actions</h2>
                
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}" 
                   class="w-full block text-center py-2 px-4 border border-slate-300 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                    Reply via Email
                </a>

                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 px-4 border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-md text-sm font-medium transition-colors">
                        Delete Inquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection