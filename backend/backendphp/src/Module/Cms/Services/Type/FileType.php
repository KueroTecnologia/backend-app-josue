<?php


declare(strict_types=1);

namespace KED\Module\Cms\Services\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use function KED\dispatch_event;
use KED\Services\Di\Container;


class FileType extends ObjectType
{
    public function __construct(Container $container)
    {
        $config = [
            'name' => 'File type',
            'fields' => function () use ($container) {
                $fields = [
                    'name' => [
                        'type' => Type::nonNull(Type::string())
                    ],
                    'type' => [
                        'type' => Type::nonNull(Type::string())
                    ],
                    'size' => [
                        'type' => Type::nonNull(Type::id())
                    ],
                    'path' => [
                        'type' => Type::nonNull(Type::string())
                    ],
                    'url' => [
                        'type' => Type::nonNull(Type::string())
                    ]
                ];

                dispatch_event('filter.file.type', [&$fields]);

                return $fields;
            },
            'resolveField' => function ($value, $args, Container $container, ResolveInfo $info) {
                return isset($value[$info->fieldName]) ? $value[$info->fieldName] : null;
            }
        ];
        parent::__construct($config);
    }
}