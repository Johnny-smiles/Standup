<?php

namespace Tests\Unit\SlackModal;

trait MockBuilder
{
    public function mockBuilder($arg, string $methodName): void
    {
        $mock = \Mockery::mock($arg);

        $mock->shouldReceive($methodName)->once();

        app()->bind($arg, fn () => $mock);
    }
}
