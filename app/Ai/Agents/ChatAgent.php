<?php

namespace App\Ai\Agents;

use App\Ai\Tools\SaveLeadTool;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class ChatAgent implements Agent, Conversational, HasTools
{
    use Promptable;

    public function __construct(private array $history = []) {}

    public function instructions(): Stringable|string
    {
        return <<<PROMPT
            You are the Quantum Digital Assistant. Your goal is to help visitors and collect their contact information for our sales team.

            BEHAVIOR:
            1. Be professional, futuristic, and helpful.
            2. You need to collect: Name, Email, Mobile/Phone Number, City, and a brief description of their Project/Interest.
            3. Do not ask for everything at once. Be conversational — ask one or two things at a time.
            4. Once you have all FIVE pieces of information (name, email, phone, city, project), call the save_lead tool with the collected data.
            5. After saving, thank them warmly and mention a specialist from Quantum Digital will reach out within 24 hours.
            6. Keep responses concise (under 3 sentences if possible).
            7. Never ask for information you already have from the conversation history.
            PROMPT;
    }

    /**
     * @return Message[]
     */
    public function messages(): iterable
    {
        return array_map(
            fn($msg) => new Message($msg['role'], $msg['content']),
            $this->history
        );
    }

    /**
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new SaveLeadTool
        ];
    }
}
