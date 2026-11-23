<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_guests_cannot_access_user_management(): void
    {
        $this->get(route('users.index'))->assertRedirect(route('login'));
    }

    public function test_users_without_permission_cannot_access_user_management(): void
    {
        $user = User::query()->where('email', 'demo@example.com')->firstOrFail();

        $this->actingAs($user)->get(route('users.index'))->assertForbidden();
    }

    public function test_admins_can_see_the_users_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('users.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Users/Index')
                ->has('users.data')
                ->has('roles'));
    }

    public function test_admins_can_create_users_with_roles(): void
    {
        $this->actingAs($this->admin)
            ->post(route('users.store'), [
                'name' => 'Nuevo Usuario',
                'email' => 'nuevo@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'roles' => ['user'],
            ])
            ->assertRedirect(route('users.index'));

        $user = User::query()->where('email', 'nuevo@example.com')->firstOrFail();

        $this->assertTrue($user->hasRole('user'));
    }

    public function test_admins_can_update_users(): void
    {
        $user = User::factory()->create();
        $adminRole = Role::findByName('admin');

        $this->actingAs($this->admin)
            ->put(route('users.update', $user), [
                'name' => 'Usuario Actualizado',
                'email' => $user->email,
                'roles' => [$adminRole->name],
            ])
            ->assertRedirect(route('users.index'));

        $user->refresh();

        $this->assertSame('Usuario Actualizado', $user->name);
        $this->assertTrue($user->hasRole('admin'));
    }

    public function test_admins_can_delete_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('users.destroy', $user))
            ->assertRedirect(route('users.index'));

        $this->assertModelMissing($user);
    }

    public function test_admins_cannot_delete_their_own_account(): void
    {
        $this->actingAs($this->admin)
            ->delete(route('users.destroy', $this->admin))
            ->assertForbidden();

        $this->assertModelExists($this->admin);
    }

    public function test_new_users_receive_the_user_role_when_registering(): void
    {
        Role::findOrCreate('user', 'web');

        $this->post('/register', [
            'name' => 'Registrado',
            'email' => 'registrado@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $user = User::query()->where('email', 'registrado@example.com')->firstOrFail();

        $this->assertTrue($user->hasRole('user'));
    }
}
