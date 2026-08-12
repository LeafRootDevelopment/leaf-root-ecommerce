<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the contact page loads successfully and renders the correct view.
     */
    public function test_contact_page_loads_successfully(): void
    {
        $response = $this->get(route('contact.create'));

        $response->assertStatus(200);
        $response->assertViewIs('contacts.index');
        $response->assertSee('Contact Us');
    }

    /**
     * Test that a valid contact form submission persists a record and redirects with success.
     */
    public function test_valid_contact_submission_creates_contact_record(): void
    {
        $payload = [
            'name'    => 'Jane Doe',
            'email'   => 'jane@example.com',
            'subject' => 'Order Inquiry',
            'message' => 'I would like to check the status of my recent order delivery.',
        ];

        $response = $this->post(route('contact.store'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('contacts', 1);
        $this->assertDatabaseHas('contacts', [
            'name'    => 'Jane Doe',
            'email'   => 'jane@example.com',
            'subject' => 'Order Inquiry',
            'message' => 'I would like to check the status of my recent order delivery.',
            'status'  => 'unread',
        ]);
    }

    /**
     * Test that newly created contact messages default to an 'unread' status.
     */
    public function test_new_contact_defaults_to_unread_status(): void
    {
        $payload = [
            'name'    => 'John Smith',
            'email'   => 'john@example.com',
            'subject' => 'Plant Care Question',
            'message' => 'How frequently should I water my indoor Monstera plant during winter?',
        ];

        $this->post(route('contact.store'), $payload);

        $contact = Contact::first();

        $this->assertNotNull($contact);
        $this->assertEquals('unread', $contact->status);
    }

    /**
     * Test that submitting the form with missing required fields fails validation.
     */
    public function test_contact_submission_fails_when_required_fields_missing(): void
    {
        $payload = [
            'name'    => '',
            'email'   => '',
            'subject' => '',
            'message' => '',
        ];

        $response = $this->post(route('contact.store'), $payload);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        $this->assertDatabaseCount('contacts', 0);
    }

    /**
     * Test that submitting an improperly formatted email address fails validation.
     */
    public function test_contact_submission_requires_valid_email(): void
    {
        $payload = [
            'name'    => 'Jane Doe',
            'email'   => 'not-an-email-address',
            'subject' => 'General Inquiry',
            'message' => 'This message contains valid content length.',
        ];

        $response = $this->post(route('contact.store'), $payload);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('contacts', 0);
    }

    /**
     * Test that submitting a message below the minimum character length fails validation.
     */
    public function test_contact_submission_requires_minimum_message_length(): void
    {
        $payload = [
            'name'    => 'Jane Doe',
            'email'   => 'jane@example.com',
            'subject' => 'General Inquiry',
            'message' => 'Short',
        ];

        $response = $this->post(route('contact.store'), $payload);

        $response->assertSessionHasErrors(['message']);
        $this->assertDatabaseCount('contacts', 0);
    }
}