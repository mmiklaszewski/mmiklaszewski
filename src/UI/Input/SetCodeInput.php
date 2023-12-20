<?php

namespace App\UI\Input;

final class SetCodeInput
{
    public function __construct(
        #[Assert\NotBlank]
        public string $code,
    ) {
    }
}
