<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Symfony\Component\HttpFoundation\Response;

class TestRoutes extends Command
{
    protected $signature = 'app:test-routes';

    protected $description = 'Ручная проверка 3 роутов (по одному тест-методу на роут).';

    public function handle(): int
    {
        //$this->testTelegramConnectRoute();
        $this->testOrderStoreRoute();
        //$this->testTelegramStatusRoute();

        return self::SUCCESS;
    }

    private function testTelegramConnectRoute(): void
    {
        $shopId = 1;
        $payload = [
            'botToken' => env('TELEGRAM_API_KEY'),
            'chatId' => '-4991574250',
            'enabled' => true,
        ];

        $this->runRouteCall(
            routeName: 'shops.telegram.connect',
            method: 'POST',
            uri: "/shops/{$shopId}/telegram/connect",
            payload: $payload,
        );
    }

    private function testOrderStoreRoute(): void
    {
        $shopId = 1;
        $payload = [
            'number' => 'A-1005',
            'total' => 2490,
            'customerName' => 'Test Customer',
        ];

        $this->runRouteCall(
            routeName: 'shops.orders.store',
            method: 'POST',
            uri: "/shops/{$shopId}/orders",
            payload: $payload,
        );
    }

    private function testTelegramStatusRoute(): void
    {
        $shopId = 1;

        $this->runRouteCall(
            routeName: 'shops.telegram.status',
            method: 'GET',
            uri: "/shops/{$shopId}/telegram/status",
            payload: [],
        );
    }

    /** @param array<string, mixed> $payload */
    private function runRouteCall(string $routeName, string $method, string $uri, array $payload): void
    {
        $response = $this->sendRequest(method: $method, uri: $uri, payload: $payload);
        $content = trim((string) $response->getContent());

        $this->newLine();
        $this->line("[$routeName] $method $uri");
        $this->line('HTTP: '.$response->getStatusCode());
        $this->line('Response:');
        $this->line($content !== '' ? $content : '<empty>');
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function sendRequest(string $method, string $uri, array $payload): Response
    {
        $server = [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json',
        ];

        /** @var SessionManager $sessionManager */
        $sessionManager = app('session');
        $session = $sessionManager->driver();
        $session->start();

        if ($method !== 'GET') {
            $payload['_token'] = $session->token();
            $server['HTTP_X_CSRF_TOKEN'] = $session->token();
        }

        $content = $method === 'GET' ? null : json_encode($payload, JSON_THROW_ON_ERROR);
        $request = Request::create($uri, $method, [], [], [], $server, $content);
        $request->cookies->set($session->getName(), $session->getId());
        $request->setLaravelSession($session);

        /** @var Kernel $kernel */
        $kernel = app(Kernel::class);
        $response = $kernel->handle($request);
        $kernel->terminate($request, $response);

        return $response;
    }
}
