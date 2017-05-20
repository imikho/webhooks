<?php


namespace Webhook\Domain\Infrastructure\Strategy;


/**
 * Class ExponentialStrategy.
 */
final class ExponentialStrategy extends AbstractStrategy
{
    const ALIAS = 'exponential';

    /** @var int */
    protected $interval;

    /** @var float */
    protected $base;

    /**
     * @param int $interval
     * @param float $base
     */
    public function __construct(int $interval = 5, float $base = 2.0)
    {
        if ($interval < 0 || $base < 0) {
            throw new \InvalidArgumentException('Interval and base should be positive numbers.');
        }

        $this->interval = $interval;
        $this->base = $base;
    }

    /**
     *
     * @param int $attempt
     *
     * @return int
     */
    public function process(int $attempt): int
    {
        return (int)ceil($this->interval + pow($this->base, $attempt));
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'alias' => static::ALIAS,
            'interval' => $this->interval,
            'base' => $this->base,
        ];
    }
}