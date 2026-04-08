<?php

namespace App\Enum;

enum OrderStatus: string
{
    case PENDING    = 'pending';
    case PAID       = 'paid';
    case PROCESSING = 'processing';
    case SHIPPED    = 'shipped';
    case DELIVERED  = 'delivered';
    case CANCELLED  = 'cancelled';
    case REFUNDED   = 'refunded';

    public function label(): string
    {
        return match($this) {
            self::PENDING    => 'En attente de paiement',
            self::PAID       => 'Payée',
            self::PROCESSING => 'En préparation',
            self::SHIPPED    => 'Expédiée',
            self::DELIVERED  => 'Livrée',
            self::CANCELLED  => 'Annulée',
            self::REFUNDED   => 'Remboursée',
        };
    }
}
