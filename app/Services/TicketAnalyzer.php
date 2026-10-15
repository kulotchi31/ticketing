<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use RuntimeException;

class TicketAnalyzer
{
    public function analyze(
        string $remarks,
        string $serviceType = 'IT'
    ): array {
        if (trim($remarks) === '') {
            throw new RuntimeException(
                'Ticket remarks cannot be empty.'
            );
        }

        $serviceType = strtolower(trim($serviceType));

        $serviceContext = match ($serviceType) {
            'general', 'general services', 'general_services', 'gs' =>
                'You analyze General Services tickets, including
                facilities maintenance, electrical work, plumbing,
                cleaning, repairs, air conditioning, furniture,
                building maintenance, transportation, and other
                administrative support services.',

            default =>
                'You analyze IT helpdesk tickets, including computers,
                software, network connectivity, servers, printers,
                accounts, information systems, and technical support.',
        };

        $systemPrompt = '
            You are a university service desk ticket priority analyzer.

            ' . $serviceContext . '

            Analyze the actual issue based on:

            1. Operational impact on university operations
            2. Number of affected users, offices, or facilities
            3. Urgency and consequences of delaying the response
            4. Availability of a workaround or alternative
            5. Safety risks, security risks, and potential property damage
            6. Impact on classes, offices, essential services, and
               university activities

            Priority levels:

            High:
            Critical service disruption, widespread operational impact,
            immediate safety or security risks, serious property damage
            risks, or an issue that prevents essential university
            activities from continuing.

            Medium:
            Significant issue affecting a person, office, facility,
            or service where operations can partially continue and
            a reasonable workaround may exist.

            Low:
            Minor issue, routine maintenance, nonurgent repair,
            standard service request, or problem with minimal
            operational impact and no immediate safety concern.

            Classification rules:

            - Understand English, Filipino, and Taglish.
            - Do not classify based on keywords alone.
            - Consider the actual severity and operational consequences.
            - Do not automatically classify every repair or maintenance
              request as High.
            - A safety hazard may warrant High even if only one person
              or one location is affected.
            - If important information is missing, avoid assuming
              widespread impact or an emergency.
            - Assess the issue using the selected service context.
            - Return only valid JSON.

            Required JSON structure:
            {
                "classification": "High, Medium, or Low",
                "reason": "Brief explanation of the classification",
                "confidence": 0.0
            }

            Confidence must be a number between 0 and 1.
        ';

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4.1-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt,
                ],
                [
                    'role' => 'user',
                    'content' => $remarks,
                ],
            ],
            'response_format' => [
                'type' => 'json_object',
            ],
            'temperature' => 0,
        ]);

        $content = $response->choices[0]->message->content;

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

        $classification = $result['classification'] ?? null;

        if (!in_array(
            $classification,
            ['High', 'Medium', 'Low'],
            true
        )) {
            throw new RuntimeException(
                'OpenAI returned an invalid classification.'
            );
        }

        $confidence = $result['confidence'] ?? null;

        if (
            !is_numeric($confidence) ||
            $confidence < 0 ||
            $confidence > 1
        ) {
            $confidence = null;
        }

        return [
            'classification' => $classification,
            'reason' => is_string($result['reason'] ?? null)
                ? $result['reason']
                : '',
            'confidence' => $confidence,
        ];
    }
}
