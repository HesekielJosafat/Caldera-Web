<?php

namespace App\Mail\Transport;

use Google_Client;
use Google_Service_Gmail;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\AlternativePart;
use Symfony\Component\Mime\Part\TextPart;

class GmailApiTransport extends AbstractTransport
{
    protected $client;

    public function __construct(Google_Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function doSend(SentMessage $message): void
    {
        $gmail = new Google_Service_Gmail($this->client);
        
        // Get the original email message
        $originalMessage = $message->getOriginalMessage();
        
        // Build mime message manually
        $mimeMessage = $this->buildMimeMessage($originalMessage);
        
        // Encode to base64 URL safe
        $raw = rtrim(strtr(base64_encode($mimeMessage), '+/', '-_'), '=');
        
        $email = new \Google_Service_Gmail_Message();
        $email->setRaw($raw);
        
        try {
            $gmail->users_messages->send('me', $email);
        } catch (\Exception $e) {
            throw new \Exception('Gmail API Error: ' . $e->getMessage());
        }
    }

    public function __toString(): string
    {
        return 'gmail-api';
    }
    
    /**
     * Build mime message from Email object
     */
    private function buildMimeMessage(Email $email): string
    {
        $boundary = md5(time());
        $headers = [];
        
        // From header
        $from = $email->getFrom();
        if (!empty($from)) {
            $fromAddress = reset($from);
            $headers[] = 'From: ' . $fromAddress->toString();
        }
        
        // To header
        $to = $email->getTo();
        if (!empty($to)) {
            $toAddresses = [];
            foreach ($to as $address) {
                $toAddresses[] = $address->toString();
            }
            $headers[] = 'To: ' . implode(', ', $toAddresses);
        }
        
        // Subject header
        $headers[] = 'Subject: ' . $email->getSubject();
        
        // Date header
        $headers[] = 'Date: ' . date('r');
        
        // MIME headers
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';
        
        // Build body parts
        $body = '';
        
        // Text part
        $textBody = $email->getTextBody();
        if ($textBody) {
            $body .= '--' . $boundary . "\r\n";
            $body .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
            $body .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
            $body .= chunk_split(base64_encode($textBody)) . "\r\n";
        }
        
        // HTML part
        $htmlBody = $email->getHtmlBody();
        if ($htmlBody) {
            $body .= '--' . $boundary . "\r\n";
            $body .= 'Content-Type: text/html; charset=utf-8' . "\r\n";
            $body .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
            $body .= chunk_split(base64_encode($htmlBody)) . "\r\n";
        }
        
        // Close boundary
        $body .= '--' . $boundary . "--\r\n";
        
        // Combine headers and body
        return implode("\r\n", $headers) . "\r\n\r\n" . $body;
    }
}