<?php

/*
 * This file is part of the animal-api package.
 *
 * (c) Benjamin Georgeault
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

/**
 * Class GlobalStatDecorator
 *
 * @author Benjamin Georgeault
 */
class GlobalStatDecorator implements OpenApiFactoryInterface
{
    public function __construct(
        private OpenApiFactoryInterface $decorated
    ) {}

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['GlobalStat'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'total_animals' => [
                    'type' => 'number',
                    'readOnly' => true,
                ],
                'total_animals_without_owner' => [
                    'type' => 'number',
                    'readOnly' => true,
                ],
            ],
        ]);

        $pathItem = new Model\PathItem(
            ref: 'GlobalStat',
            get: new Model\Operation(
                operationId: 'getGlobalStat',
                tags: ['GlobalStat'],
                responses: [
                    '200' => [
                        'description' => 'Global Stat object.',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/GlobalStat',
                                ],
                            ],
                        ],
                    ],
                ],
                summary: 'Get some global stat about the app.',
                requestBody: new Model\RequestBody(
                    description: 'Get global stat data.',
                ),
            ),
        );
        $openApi->getPaths()->addPath('/api/global-stat', $pathItem);

        return $openApi;
    }
}
