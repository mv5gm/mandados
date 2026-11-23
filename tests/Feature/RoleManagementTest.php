<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RoleManagementTest extends TestCase
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

    public function test_guests_cannot_access_role_management(): void
    {
        $this->get(route('roles.index'))->assertRedirect(route('login'));
    }

    public function test_users_without_permission_cannot_access_role_management(): void
    {
        $user = User::query()->where('email', 'demo@example.com')->firstOrFail();

        $this->actingAs($user)->get(route('roles.index'))->assertForbidden();
    }

    public function test_admins_can_see_the_roles_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('roles.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Roles/Index')
                ->has('roles')
                ->has('permissions'));
    }

    public function test_admins_can_create_roles_with_permissions(): void
    {
        $this->actingAs($this->admin)
            ->post(route('roles.store'), [
                'name' => 'editor',
                'permissions' => ['users.view', 'users.update'],
            ])
            ->assertRedirect(route('roles.index'));

        $role = Role::findByName('editor');

        $this->assertTrue($role->hasPermissionTo('users.view'));
        $this->assertTrue($role->hasPermissionTo('users.update'));
    }

    public function test_admins_can_update_roles(): void
    {
        $role = Role::create(['name' => 'soporte', 'guard_name' => 'web']);

        $this->actingAs($this->admin)
            ->put(route('roles.update', $role), [
                'name' => 'soporte-tecnico',
                'permissions' => ['users.view'],
            ])
            ->assertRedirect(route('roles.index'));

        $role->refresh();

        $this->assertSame('soporte-tecnico', $role->name);
        $this->assertTrue($role->hasPermissionTo('users.view'));
    }

    public function test_the_admin_role_cannot_be_modified(): void
    {
        $adminRole = Role::findByName('admin');

        $this->actingAs($this->admin)
            ->put(route('roles.update', $adminRole), [
                'name' => 'super-admin',
                'permissions' => [],
            ])
            ->assertForbidden();
    }

    public function test_the_admin_role_cannot_be_deleted(): void
    {
        $adminRole = Role::findByName('admin');

        $this->actingAs($this->admin)
            ->delete(route('roles.destroy', $adminRole))
            ->assertForbidden();

        $this->assertModelExists($adminRole);
    }

    public function test_admins_can_delete_other_roles(): void
    {
        $role = Role::create(['name' => 'temporal', 'guard_name' => 'web']);

        $this->actingAs($this->admin)
            ->delete(route('roles.destroy', $role))
            ->assertRedirect(route('roles.index'));

        $this->assertModelMissing($role);
    }
}
