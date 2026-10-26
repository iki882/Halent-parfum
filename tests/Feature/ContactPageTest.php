<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactPageTest extends TestCase
{
    public function test_contact_page_opens_the_whatsapp_business_link_for_guests(): void
    {
        $response = $this->get(route('contact'));

        $response->assertOk()
            ->assertViewIs('pages.contact')
            ->assertSee('Hubungi Halent Parfum')
            ->assertSee('Nama lengkap')
            ->assertSee('ID pesanan')
            ->assertSee('Pesan, kritik, saran, atau masukan')
            ->assertSee('action="'.route('contact.whatsapp').'"', false)
            ->assertSee('href="'.route('contact').'"', false);
    }

    public function test_contact_form_redirects_to_whatsapp_with_submitted_details(): void
    {
        config()->set('services.whatsapp.business_phone', '6283131604835');

        $response = $this->post(route('contact.whatsapp'), [
            'name' => 'Rizqi',
            'order_id' => 'ORD-12345',
            'message' => 'Saya ingin bertanya tentang pesanan.',
        ]);

        $response->assertRedirect();

        $destination = parse_url($response->headers->get('Location'));
        parse_str($destination['query'], $query);

        $this->assertSame('api.whatsapp.com', $destination['host']);
        $this->assertSame('/send', $destination['path']);
        $this->assertSame('6283131604835', $query['phone']);
        $this->assertSame(
            "Halo Halent Parfum,\n\nSaya ingin menghubungi Halent Parfum.\n\n*Nama:* Rizqi\n*ID Pesanan:* #ORD-12345\n*Pesan:*\nSaya ingin bertanya tentang pesanan.",
            $query['text']
        );
    }

    public function test_contact_form_returns_validation_errors_when_required_fields_are_missing(): void
    {
        $response = $this->from(route('contact'))->post(route('contact.whatsapp'), []);

        $response->assertRedirect(route('contact'))
            ->assertSessionHasErrors(['name', 'message']);
    }
}
