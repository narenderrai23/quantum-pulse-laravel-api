<?php

define('LARAVEL_START', microtime(true));
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$history = [];

function chat(string $message, array &$history): string
{
    // Normalize history roles for the agent
    $normalized = array_map(fn($m) => [
        'role'    => $m['role'] === 'model' ? 'assistant' : $m['role'],
        'content' => $m['content'],
    ], $history);

    $response = (new App\Ai\Agents\ChatAgent($normalized))->prompt($message);
    $reply = $response->text;

    // Append to history
    $history[] = ['role' => 'user',  'content' => $message];
    $history[] = ['role' => 'model', 'content' => $reply];

    return $reply;
}

$turns = [
    "Hi, I need a website for my restaurant.",
    "My name is John Doe.",
    "My email is john@example.com",
    "My phone is +1-555-123-4567",
    "I'm based in New York City.",
    "I want a modern online ordering website with a menu and reservations.",
];

echo str_repeat("=", 60) . PHP_EOL;
echo "  CHAT AGENT - FULL LEAD COLLECTION TEST" . PHP_EOL;
echo str_repeat("=", 60) . PHP_EOL . PHP_EOL;

foreach ($turns as $userMessage) {
    echo "USER: {$userMessage}" . PHP_EOL;
    $reply = chat($userMessage, $history);
    echo "AGENT: {$reply}" . PHP_EOL;
    echo str_repeat("-", 60) . PHP_EOL;
}

// Check if lead was saved
$lead = App\Models\Lead::latest()->first();
echo PHP_EOL . "LEAD SAVED IN DB:" . PHP_EOL;
if ($lead) {
    echo "  Name:    {$lead->name}" . PHP_EOL;
    echo "  Email:   {$lead->email}" . PHP_EOL;
    echo "  Phone:   {$lead->phone}" . PHP_EOL;
    echo "  City:    {$lead->city}" . PHP_EOL;
    echo "  Project: {$lead->project}" . PHP_EOL;
    echo "  Status:  {$lead->status}" . PHP_EOL;
} else {
    echo "  No lead found yet (agent may need more turns to trigger save_lead tool)." . PHP_EOL;
}
