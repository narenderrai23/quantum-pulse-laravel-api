<?php

namespace App\Ai\Tools;

use App\Models\Lead;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Illuminate\Support\Str;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class SaveLeadTool implements Tool
{
    public function description(): Stringable|string
    {
        return 'Save a collected lead to the database. Use this when you have collected all five pieces of information: name, email, phone, city, and project.';
    }

    public function handle(Request $request): Stringable|string
    {
        Lead::create([
            'lead_id' => Str::random(9),
            'name'    => $request->string('name'),
            'email'   => $request->string('email'),
            'phone'   => $request->string('phone'),
            'city'    => $request->string('city'),
            'project' => $request->string('project'),
            'status'  => 'new',
        ]);

        return 'Lead saved successfully.';
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'name'    => $schema->string('Full name of the visitor'),
            'email'   => $schema->string('Email address'),
            'phone'   => $schema->string('Phone or mobile number'),
            'city'    => $schema->string('City of the visitor'),
            'project' => $schema->string('Brief description of their project or interest'),
        ];
    }
}
