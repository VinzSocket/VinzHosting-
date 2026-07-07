<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\SourceCode;

class SourceCodesController extends ClientApiController
{
    /**
     * Returns all active source code entries for display on the client dashboard.
     *
     * @return array{object: string, data: array<int, array<string, mixed>>}
     */
    public function index(): array
    {
        $sourceCodes = SourceCode::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->get();

        return [
            'object' => 'list',
            'data' => $sourceCodes->map(fn (SourceCode $sourceCode) => [
                'id' => $sourceCode->id,
                'title' => $sourceCode->title,
                'description' => $sourceCode->description,
                'link' => $sourceCode->link,
                'category' => $sourceCode->category,
                'thumbnail' => $sourceCode->thumbnail,
            ])->all(),
        ];
    }
}
