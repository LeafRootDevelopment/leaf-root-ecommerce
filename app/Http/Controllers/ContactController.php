<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     */
    public function create(): View
    {
        // Changed 'contact.index' to 'contacts.index' to match your folder name
        return view('contacts.index');
    }

    /**
     * Store a submitted contact message.
     */
    public function store(StoreContactRequest $request): RedirectResponse
    {
        Contact::create([
            'name'    => $request->validated('name'),
            'email'   => $request->validated('email'),
            'subject' => $request->validated('subject'),
            'message' => $request->validated('message'),
            'status'  => 'unread',
        ]);

        return redirect()
            ->route('contact.create')
            ->with(
                'success',
                'Thank you for contacting Leaf & Root. Your message has been received and we will respond as soon as possible.'
            );
    }
}