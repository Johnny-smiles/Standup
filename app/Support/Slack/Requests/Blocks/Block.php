<?php

namespace App\Support\Slack\Requests\Blocks;

use Illuminate\Support\Collection;

abstract class Block
{
    protected int $id = 0;
    protected string $text = '';
    protected ?array $accessory = null;
    protected ?string $image = null;
    protected ?string $time = null;
    protected ?string $status = null;
    protected ?string $placeholder = null;
    protected ?string $initialValue = null;
    protected ?Collection $gitHubIssues = null;

    public function setId(int $id): Block
    {
        $this->id = $id;

        return $this;
    }

    public function setText(string $text): Block
    {
        $this->text = $text;

        return $this;
    }

    public function setAccessory(array|null $accessory): Block
    {
        $this->accessory = $accessory;

        return $this;
    }

    public function setImage(string|null $image): Block
    {
        $this->image = $image;

        return $this;
    }

    public function setTime(string|null $time): Block
    {
        $this->time = $time;

        return $this;
    }

    public function setStatus(string|null $status): Block
    {
        $this->status = $status;

        return $this;
    }

    public function setPlaceholder(string|null $placeholder): Block
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function setInitialValue(string|null $initialValue): Block
    {
        $this->initialValue = $initialValue;

        return $this;
    }

    public function setGitHubIssues(Collection|null $gitHubIssues): Block
    {
        $this->gitHubIssues = $gitHubIssues;

        return $this;
    }
}
