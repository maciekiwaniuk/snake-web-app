<?php

namespace Tests\Feature\GuestTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Message;

class GuestHandlesActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_handle_actions_secured_by_user_middleware()
    {
        $this->post(route('password.confirm'))->assertRedirect(route('login'));
        $this->post(route('verification.send'))->assertRedirect(route('login'));
        $this->put(route('options.password-change'))->assertRedirect(route('login'));
        $this->put(route('options.email-change'))->assertRedirect(route('login'));
//        $this->post(route('options.avatar-change'))->assertRedirect(route('login'));
//        $this->post(route('options.avatar-change'))->assertRedirect(route('login'));
        $this->delete(route('options.account-delete'))->assertRedirect(route('login'));
        $this->delete(route('options.account-delete'))->assertRedirect(route('login'));
        $this->post(route('options.logout-from-game'))->assertRedirect(route('login'));
        $this->post(route('options.logout-from-website'))->assertRedirect(route('login'));
        $this->post(route('profile.options.change-profile-visibility-status'))->assertRedirect(route('login'));
        $this->post(route('logout'))->assertRedirect(route('login'));
    }

//    public function test_guest_can_send_messages()
//    {
//        $this->post(
//            route('message.store'),
//            [
//                'subject' => 'contact',
//                'sender' => 'Joe',
//                'email' => 'test@example.com',
//                'content' => 'Lorem ipsum...',
//                'sent_as_user' => false
//            ]
//        );
//
//        try {
//            $message = Message::firstOrFail();
//            $this->assertTrue(true);
//        } catch (\Exception $e) {
//            $this->assertTrue(false);
//        }
//    }
//
//    public function test_guest_can_send_ajax_messages()
//    {
//        $this->post(
//            route('message.store-AJAX'),
//            [
//                'subject' => 'contact',
//                'sender' => 'Joe',
//                'email' => 'test@example.com',
//                'content' => 'Lorem ipsum...',
//                'sent_as_user' => false
//            ]
//        );
//
//        try {
//            $message = Message::firstOrFail();
//            $this->assertTrue(true);
//        } catch (\Exception $e) {
//            $this->assertTrue(false);
//        }
//    }
//
//    public function test_guest_cant_spam_send_messages()
//    {
//        for ($i = 0; $i <= 10; $i++) {
//            $this->post(
//                route('message.store-AJAX'),
//                [
//                    'subject' => 'contact',
//                    'sender' => 'Joe',
//                    'email' => 'test@example.com',
//                    'content' => 'Lorem ipsum...',
//                    'sent_as_user' => false
//                ]
//            );
//        }
//
//        try {
//            $amount_of_messages = Message::all()->count();
//
//            if ($amount_of_messages > 10) $this->assertTrue(false);
//
//            $this->assertTrue(true);
//        } catch (\Exception $e) {
//            $this->assertTrue(false);
//        }
//    }

}
