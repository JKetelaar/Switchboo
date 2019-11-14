<?php
/**
 * @author JKetelaar
 */

namespace App\Service;


class SwitchException extends \Exception
{
    /**
     * @var string[]
     */
    private $errors;

    /**
     * SwitchException constructor.
     * @param string[] $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct(implode(', ', $this->errors));
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
