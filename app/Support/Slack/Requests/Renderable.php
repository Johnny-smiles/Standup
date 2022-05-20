<?php

namespace App\Support\Slack\Requests;

interface Renderable
{
    public function render(): array;
}
