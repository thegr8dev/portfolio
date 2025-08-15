<?php

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\ListUsers;

use function Pest\Livewire\livewire;

it('should have user resource URLs', function () {
    livewire(ListUsers::class)
        ->assertStatus(200);
    livewire(CreateUser::class)
        ->assertStatus(200);
});

it('validates user form inputs', function ($form, $expectedError) {
    livewire(CreateUser::class)
        ->fillForm($form)
        ->call('create')
        ->assertHasFormErrors([$expectedError]);
})->with([
    function () {
        $user = \Database\Factories\UserFactory::new()->make();

        return [
            ['name' => '', 'email' => $user->email, 'password' => 'password123'], 'name'];
    },
    function () {
        $user = \Database\Factories\UserFactory::new()->make();

        return [
            ['name' => $user->name, 'email' => '', 'password' => 'password123'], 'email'];
    },
    function () {
        $user = \Database\Factories\UserFactory::new()->make();

        return [
            ['name' => $user->name, 'email' => 'not-an-email', 'password' => 'password123'], 'email'];
    },
    function () {
        $user = \Database\Factories\UserFactory::new()->make();

        return [
            ['name' => $user->name, 'email' => $user->email, 'password' => ''], 'password'];
    },
]);
