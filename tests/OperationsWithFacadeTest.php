<?php

use ToneflixCode\LaravelPayPocket\Facades\LaravelPayPocket;
use ToneflixCode\LaravelPayPocket\Models\WalletsLog;
use ToneflixCode\LaravelPayPocket\Tests\Models\User;

it('can test', function () {
    expect(true)->toBeTrue();
});

test('user can deposit fund', function () {

    $user = User::factory()->create();

    $type = 'wallet_escrow';

    LaravelPayPocket::deposit($user, $type, 234.56);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_escrow'))->toBeFloat(234.56);

    expect(LaravelPayPocket::checkBalance($user))->toBeFloat(234.56);
});

test('user can deposit two times', function () {

    $user = User::factory()->create();

    $type = 'wallet_escrow';

    LaravelPayPocket::deposit($user, $type, 234.56);

    LaravelPayPocket::deposit($user, $type, 789.12);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_escrow'))->toBeFloat(1023.68);

    expect(LaravelPayPocket::checkBalance($user))->toBeFloat(1023.68);
});

test('user can pay order', function () {

    $user = User::factory()->create();

    $type = 'wallet_escrow';

    LaravelPayPocket::deposit($user, $type, 234.56);

    LaravelPayPocket::pay($user, 100.16);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_escrow'))->toBeFloat(134.40);

    expect(LaravelPayPocket::checkBalance($user))->toBeFloat(134.40);
});

test('user can deposit two times and pay an order', function () {

    $user = User::factory()->create();

    $type = 'wallet_main';

    LaravelPayPocket::deposit($user, $type, 234.11);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_main'))->toBeFloat(234.11);

    $type = 'wallet_escrow';
    LaravelPayPocket::deposit($user, $type, 100.12);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_escrow'))->toBeFloat(100.12);

    LaravelPayPocket::pay($user, 100);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_main'))->toBeFloat(134.11);

    expect(LaravelPayPocket::checkBalance($user))->toBeFloat(234.33);
});

test('user pay from two wallets', function () {

    $user = User::factory()->create();

    $type = 'wallet_main';

    LaravelPayPocket::deposit($user, $type, 234.11);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_main'))->toBeFloat(234.11);

    $type = 'wallet_escrow';
    LaravelPayPocket::deposit($user, $type, 100.12);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_escrow'))->toBeFloat(100.12);

    LaravelPayPocket::pay($user, 334.11);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_main'))->toBe(0);

    expect(LaravelPayPocket::walletBalanceByType($user, 'wallet_escrow'))->toBeFloat(0.12);

    expect(LaravelPayPocket::checkBalance($user))->toBeFloat(0.12);
});

test('notes can be added during deposit', function () {
    $user = User::factory()->create();

    $type = 'wallet_escrow';

    $description = \Illuminate\Support\Str::random();
    LaravelPayPocket::deposit($user, $type, 234.56, $description);

    expect(WalletsLog::where('notes', $description)->exists())->toBe(true);
});

test('notes can be added during payment', function () {
    $user = User::factory()->create();

    $type = 'wallet_escrow';

    $description = \Illuminate\Support\Str::random();
    LaravelPayPocket::deposit($user, $type, 234.56);
    LaravelPayPocket::pay($user, 234.56, [$type], $description);

    expect(WalletsLog::where('notes', $description)->exists())->toBe(true);
});

test('transaction reference is added to wallet log', function () {
    $user = User::factory()->create();

    $type = 'wallet_escrow';

    LaravelPayPocket::deposit($user, $type, 234.56);

    expect(WalletsLog::whereNotNull('reference')->exists())->toBe(true);
});

test('Payment returns log', function () {
    $user = User::factory()->create();

    $type = 'wallet_escrow';

    LaravelPayPocket::deposit($user, $type, 234.56);

    $log = LaravelPayPocket::pay($user, 100.16);

    expect($log->sum('value'))->toBe(100.16);
});

test('only the allowed wallets should be charged.', function () {

    $user = User::factory()->create();

    $type = 'wallet_main';

    LaravelPayPocket::deposit($user, $type, 234.56);
    LaravelPayPocket::pay($user, 234.56, [$type]);

    $last = $user->wallets()
        ->where('type', \App\Enums\WalletEnums::WALLET_MAIN)
        ->first()
        ->logs()->latest()->first();

    expect($last->value)->toBeFloat(234.56);
});
