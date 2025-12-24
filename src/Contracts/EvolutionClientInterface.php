<?php
namespace EvolutionPHP\Contracts;

interface EvolutionClientInterface {
    public function createInstance(string $name): object;
    public function getInstanceStatus(string $name): array;
}