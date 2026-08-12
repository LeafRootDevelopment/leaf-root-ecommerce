<?php

namespace Tests\Feature\Admin;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Admin user using the application's actual 'role' column
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Non-admin user using the application's actual 'role' column
        $this->regularUser = User::factory()->create([
            'role' => 'customer',
        ]);
    }

    /**
     * Test guest users are redirected to the login route by 'auth' middleware.
     */
    public function test_guest_cannot_access_admin_contacts(): void
    {
        $response = $this->get(route('admin.contacts.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test non-admin authenticated users are redirected with an error message by AdminMiddleware.
     */
    public function test_non_admin_user_cannot_access_admin_contacts(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->get(route('admin.contacts.index'));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('error', 'Unauthorized access. Admin privileges required.');
    }

    /**
     * Test authenticated admins can view the paginated contact messages list.
     */
    public function test_admin_can_view_contact_messages_list(): void
    {
        Contact::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.contacts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.contacts.index');
        $response->assertViewHas('contacts');
    }

    /**
     * Test admins can filter the contact list by status query parameter.
     */
    public function test_admin_can_filter_contact_messages_by_status(): void
    {
        Contact::factory()->create(['status' => 'unread', 'subject' => 'Unread Enquiry']);
        Contact::factory()->create(['status' => 'replied', 'subject' => 'Replied Enquiry']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.contacts.index', ['status' => 'unread']));

        $response->assertStatus(200);
        $response->assertSee('Unread Enquiry');
        $response->assertDontSee('Replied Enquiry');
    }

    /**
     * Test viewing an unread message renders the detail view and transitions status to read.
     */
    public function test_admin_can_view_single_contact_and_unread_status_becomes_read(): void
    {
        $contact = Contact::factory()->create([
            'status' => 'unread',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.contacts.show', $contact));

        $response->assertStatus(200);
        $response->assertViewIs('admin.contacts.show');
        $response->assertViewHas('contact');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'status' => 'read',
        ]);
    }

    /**
     * Test admins can update contact message status via PATCH.
     */
    public function test_admin_can_update_contact_status(): void
    {
        $contact = Contact::factory()->create([
            'status' => 'read',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.contacts.update-status', $contact), [
                'status' => 'replied',
            ]);

        $response->assertRedirect(route('admin.contacts.show', $contact));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'status' => 'replied',
        ]);
    }

    /**
     * Test status update fails when given invalid status input.
     */
    public function test_contact_status_update_fails_with_invalid_status(): void
    {
        $contact = Contact::factory()->create([
            'status' => 'read',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.contacts.update-status', $contact), [
                'status' => 'invalid_status_value',
            ]);

        $response->assertSessionHasErrors(['status']);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'status' => 'read',
        ]);
    }

    /**
     * Test admins can delete contact submission records.
     */
    public function test_admin_can_delete_contact_message(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.contacts.destroy', $contact));

        $response->assertRedirect(route('admin.contacts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }
}