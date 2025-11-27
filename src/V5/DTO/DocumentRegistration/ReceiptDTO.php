<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

use DF\AtolOnline\V5\Enums\Timezone;

final readonly class ReceiptDTO
{
    public function __construct(
        public ClientDTO $client,
        public CompanyDTO $company,

        /** @var ReceiptItemDTO[] */
        public array $items,

        /** @var PaymentDTO[] $payments */
        public array $payments,
        public float $total,

        /** @var VatDTO[] $vats */
        public ?array $vats = null,
        public ?string $cashier_inn = null,
        public ?string $additional_check_props = null,
        public ?AdditionalUserPropsDTO $additional_user_props = null,
        public ?OperatingCheckPropsDTO $operating_check_props = null,

        /** @var SectoralCheckPropDTO[] $vats */
        public ?array $sectoral_check_props = null,
        public ?string $device_number = null,
        public ?bool $internet = null,

        /** @var CashlessPaymentDTO[] $cashless_payments */
        public ?array $cashless_payments = null,
        public ?Timezone $timezone = null,
    ) {}
}
