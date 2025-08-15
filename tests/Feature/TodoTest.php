
<?php
    use App\Filament\Resources\Todos\Pages\CreateTodo;
use App\Models\Todo;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

it('can create a todo', function () {
    $user = User::factory()->create();
    actingAs($user);

    $data = [
        'title' => 'Test Todo',
        'description' => 'Test description',
        'assigned_to' => $user->id,
        'created_by' => $user->id,
        'due_date' => now()->addDay()->format('Y-m-d'),
    ];

    $todo = Todo::create($data);

    assertDatabaseHas('todos', [
        'title' => 'Test Todo',
        'description' => 'Test description',
        'assigned_to' => $user->id,
        'created_by' => $user->id,
    ]);
});

it('validates required fields for todo', function ($field, $value, $expectedError) {
    $user = User::factory()->create();
    actingAs($user);

    $form = [
        'title' => 'Test Todo',
        'description' => 'Test description',
        'assigned_to' => $user->id,
        'created_by' => $user->id,
        'due_date' => now()->addDay()->format('Y-m-d'),
    ];
    $form[$field] = $value;

    livewire(CreateTodo::class)
        ->fillForm($form)
        ->call('create')
        ->assertHasFormErrors([$expectedError])
        ->assertNotNotified()
        ->assertNoRedirect();
})->with([
    ['title', '', 'title'],
    ['assigned_to', null, 'assigned_to'],
    ['created_by', null, 'created_by'],
]);
