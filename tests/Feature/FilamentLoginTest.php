<?php

use App\Models\User;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

describe('Filament Login', function () {

    it('can access the admin login page', function () {
        get('/admin/login')
            ->assertSuccessful()
            ->assertSee('Sign in')
            ->assertSee('Email address')
            ->assertSee('Password');
    });

    it('can render login component', function () {
        livewire(Login::class)
            ->assertOk();
    });

    it('allows admin users to login successfully', function () {
        $adminUser = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'password',
            'is_admin' => true,
        ]);

        livewire(Login::class)
            ->fillForm([
                'email' => 'admin@example.com',
                'password' => 'password',
            ])
            ->call('authenticate')
            ->assertRedirect('/admin');

        // Verify user is authenticated and can access admin panel
        actingAs($adminUser)
            ->get('/admin')
            ->assertSuccessful();
    });

    it('prevents non-admin users from accessing admin panel', function () {
        $regularUser = User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'password',
            'is_admin' => false,
        ]);

        // Non-admin user should not be able to access admin panel even when authenticated
        actingAs($regularUser)
            ->get('/admin')
            ->assertForbidden();
    });

    it('rejects non-admin users during login', function () {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'password',
            'is_admin' => false,
        ]);

        livewire(Login::class)
            ->fillForm([
                'email' => 'user@example.com',
                'password' => 'password',
            ])
            ->call('authenticate')
            ->assertHasFormErrors(['email']);
    });

    it('shows validation errors for invalid credentials', function () {
        livewire(Login::class)
            ->fillForm([
                'email' => 'invalid@example.com',
                'password' => 'wrongpassword',
            ])
            ->call('authenticate')
            ->assertHasFormErrors(['email']);
    });

    it('validates required fields on login form', function () {
        livewire(Login::class)
            ->fillForm([])
            ->call('authenticate')
            ->assertHasFormErrors(['email', 'password']);
    });

    it('validates email format on login form', function () {
        livewire(Login::class)
            ->fillForm([
                'email' => 'invalid-email',
                'password' => 'password',
            ])
            ->call('authenticate')
            ->assertHasFormErrors(['email']);
    });
});
