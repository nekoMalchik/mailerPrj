<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EmailFormType;

class MailController extends AbstractController
{
    /**
     * @Route("/send-email", name="send_email", methods={"GET", "POST"})
     */
    public function sendEmail(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(EmailFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $recipientEmail = $data['recipient_email'];
            $subject = $data['subject'];
            $message = $data['message'];
            $senderEmail = $data['sender_email'];

            $email = (new Email())
                ->from($senderEmail)
                ->to($recipientEmail)
                ->subject($subject)
                ->text($message);

            $mailer->send($email);

            return $this->redirectToRoute('send_email_success');
        }

        return $this->render('mail/send_email.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/send-email/success", name="send_email_success")
     */
    public function sendEmailSuccess(): Response
    {
        return new Response('Email sent successfully!');
    }
}
