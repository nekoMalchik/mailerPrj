<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class MailerTest extends TestCase
{
    public function testSendEmail()
    {
        $transport = Transport::fromDsn(getenv('MAILER_DSN'));
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from('from@example.com')
            ->to('to@example.com')
            ->subject('Test Email')
            ->text('This is a test email.');

        try {
            $mailer->send($email);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('Failed to send email: ' . $e->getMessage());
        }
    }
}