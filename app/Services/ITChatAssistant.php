<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use RuntimeException;

class ITChatAssistant
{
    public function reply(array $messages): array
    {
        if (empty($messages)) {
            throw new RuntimeException(
                'Chat messages cannot be empty.'
            );
        }

        $systemPrompt = <<<'PROMPT'
You are the Basic IT Services Assistant for a university.

YOUR RESPONSIBILITIES

Help users troubleshoot:
- Internet, Wi-Fi, and LAN connectivity
- Printers and scanners
- Computers, laptops, and peripherals
- University email and account access
- Software installation and application errors
- Servers, network services, and information systems
- Other common IT support concerns

LANGUAGE
- Understand English, Filipino,Cebuano, and Taglish.
- Respond in the language used by the user.
- Use simple, professional, friendly language.

TROUBLESHOOTING
- Identify the actual problem before suggesting a solution.
- Ask clarifying questions when important details are missing.
- Provide clear, numbered troubleshooting instructions.
- Start with safe, simple checks before advanced procedures.
- Ask whether the issue has been resolved.
- If the issue persists, recommend submitting an IT support ticket.
- Do not claim that a technician has been notified.

TICKET INTEGRATION
- You cannot create, update, or check tickets directly.
- If a problem remains unresolved, set ticket_required to true.
- Provide a concise suggested ticket description based on the
  information supplied by the user.
- Never claim that a ticket was created.
- Do not invent department IDs, category IDs, ticket numbers,
  system status, or university policies.

SECURITY
- Never request passwords, OTPs, or authentication tokens.
- Never instruct users to bypass security controls.
- Do not recommend disabling antivirus or firewalls.
- For suspected malware, phishing, compromised accounts,
  or serious security incidents, advise prompt contact with
  authorized IT personnel.
- Do not invent access to internal systems or records.

RESPONSE FORMAT

Return only valid JSON with this structure:

{
    "reply": "Your response to the user",
    "issue_type": "Network, Printer, Hardware, Software, Account, Security, Other, or Unknown",
    "resolved": false,
    "ticket_required": false,
    "suggested_ticket_description": ""
}

RULES FOR THE RESPONSE

- resolved must be true only when the user confirms the issue
  is resolved.
- ticket_required must be true when the issue remains unresolved
  and ticket submission is appropriate.
- Do not automatically mark an issue unresolved merely because
  the user has not answered a troubleshooting question.
- When more information is needed, ask a question in reply.
- suggested_ticket_description should summarize the known issue.
- Do not invent facts to complete the description.
- Keep replies concise and useful.
PROMPT;

        $normalizedMessages = [];

        foreach (array_slice($messages, -12) as $message) {
            if (
                !is_array($message) ||
                !in_array(
                    $message['role'] ?? null,
                    ['user', 'assistant'],
                    true
                ) ||
                !is_string($message['content'] ?? null) ||
                trim($message['content']) === ''
            ) {
                throw new RuntimeException(
                    'Invalid chat message format.'
                );
            }

            $normalizedMessages[] = [
                'role' => $message['role'],
                'content' => trim($message['content']),
            ];
        }

        if (empty($normalizedMessages)) {
            throw new RuntimeException(
                'No valid chat messages were provided.'
            );
        }

        $response = OpenAI::chat()->create([
            'model' => config(
                'services.openai.model',
                'gpt-4.1-mini'
            ),
            'messages' => array_merge(
                [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt,
                    ],
                ],
                $normalizedMessages
            ),
            'response_format' => [
                'type' => 'json_object',
            ],
            'temperature' => 0,
        ]);

        $content = $response->choices[0]->message->content
            ?? null;

        if (!is_string($content) || trim($content) === '') {
            throw new RuntimeException(
                'OpenAI returned an empty response.'
            );
        }

        $result = json_decode(
            $content,
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if (
            !is_array($result) ||
            !is_string($result['reply'] ?? null) ||
            trim($result['reply']) === ''
        ) {
            throw new RuntimeException(
                'OpenAI returned an invalid chat response.'
            );
        }

        $allowedIssueTypes = [
            'Network',
            'Printer',
            'Hardware',
            'Software',
            'Account',
            'Security',
            'Other',
            'Unknown',
        ];

        $issueType = $result['issue_type'] ?? 'Unknown';

        if (!in_array($issueType, $allowedIssueTypes, true)) {
            $issueType = 'Unknown';
        }

        return [
            'reply' => $result['reply'],
            'issue_type' => $issueType,
            'resolved' => ($result['resolved'] ?? false) === true,
            'ticket_required' =>
                ($result['ticket_required'] ?? false) === true,
            'suggested_ticket_description' =>
                is_string(
                    $result['suggested_ticket_description'] ?? null
                )
                    ? $result['suggested_ticket_description']
                    : '',
        ];
    }
}


?>
