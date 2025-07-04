<?php

use ToneflixCode\LaravelPayPocket\Exceptions\InsufficientBalanceException;
use ToneflixCode\LaravelPayPocket\Exceptions\InvalidValueException;
use ToneflixCode\LaravelPayPocket\Exceptions\InvalidWalletTypeException;
use ToneflixCode\LaravelPayPocket\Exceptions\WalletNotFoundException;
use ToneflixCode\LaravelPayPocket\Tests\Models\User;

test('deposit invalid value (0) should throw exception', function () {
    $user = User::factory()->create();

    $type = 'wallet_main';

    $user->deposit($type, 0);
})->throws(InvalidValueException::class);

test('deposit invalid value (-1)  should throw exception', function () {
    $user = User::factory()->create();

    $type = 'wallet_main';

    $user->deposit($type, -1);
})->throws(InvalidValueException::class);

test('deposit to invalid wallet type should throw exception', function () {
    $user = User::factory()->create();

    $type = 'wallet_invalid';

    $user->deposit($type, 100);
})->throws(InvalidWalletTypeException::class);

test('deposit two times, the second time to invalid wallet type should throw exception', function () {
    $user = User::factory()->create();

    $type = 'wallet_main';

    $user->deposit($type, 100);

    $type = 'wallet_invalid';

    $user->deposit($type, 100);
})->throws(InvalidWalletTypeException::class);

test('insufficent balance should throw exception', function () {

    $user = User::factory()->create();

    $type = 'wallet_main';

    $user->deposit($type, 234.56);

    $user->pay(234.57);
})->throws(InsufficientBalanceException::class);

test('User does not have such wallet should throw exception', function () {

    $user = User::factory()->create();

    $user->getWalletBalanceByType('wallet_escrow');
})->throws(WalletNotFoundException::class);
