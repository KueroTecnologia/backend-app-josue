<?php


declare(strict_types=1);

namespace KED\Module\Order\Services\Type;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use function KED\dispatch_event;
use KED\Module\Catalog\Services\Type\Price;
use KED\Services\Di\Container;

class PaymentTransactionType extends ObjectType
{
    public function __construct(Container $container)
    {
        $config = [
            'name' => 'Payment transaction',
            'fields' => function () use ($container) {
                $fields = [
                    'id' => [
                        'type' => Type::nonNull(Type::id()),
                        'resolve' => function ($value, $args, Container $container, ResolveInfo $info) {
                            return isset($value['payment_transaction_id']) ? $value['payment_transaction_id'] : null;
                        }
                    ],
                    'order_id' => [
                        'type' => Type::nonNull(Type::int()),
                        'resolve' => function ($value, $args, Container $container, ResolveInfo $info) {
                            return isset($value['payment_transaction_order_id']) ? $value['payment_transaction_order_id'] : null;
                        }
                    ],
                    'transaction_id' => [
                        'type' => Type::string()
                    ],
                    'transaction_type' => [
                        'type' => Type::string()
                    ],
                    'amount' => [
                        'type' => Type::float()
                    ],
                    'parent_transaction_id' => [
                        'type' => Type::string()
                    ],
                    'payment_action' => [
                        'type' => Type::nonNull(Type::string())
                    ],
                    'additional_information' => [
                        'type' => Type::string()
                    ],
                    'created_at' => [
                        'type' => Type::string()
                    ]
                ];

                dispatch_event('filter.payment_transaction.type', [&$fields]);

                return $fields;
            },
            'resolveField' => function ($value, $args, Container $container, ResolveInfo $info) {
                return isset($value[$info->fieldName]) ? $value[$info->fieldName] : null;
            }
        ];
        parent::__construct($config);
    }
}