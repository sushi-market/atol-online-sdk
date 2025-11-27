<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

use DF\AtolOnline\V5\Enums\AgentType;

final readonly class AgentInfoDTO
{
    public function __construct(
        public AgentType $type,
        public ?PayingAgentDTO $paying_agent = null,
        public ?ReceivePaymentsOperatorDTO $receive_payments_operator = null,
        public ?MoneyTransferOperatorDTO $money_transfer_operator = null,
    ) {}
}
