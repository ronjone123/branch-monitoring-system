<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RouteAccessPolicyTest extends TestCase
{
    public function test_viewer_access_policy_routes_are_read_only(): void
    {
        $this->assertRouteRoles('executive.dashboard', ['super_admin', 'admin', 'importer', 'viewer']);
        $this->assertRouteRoles('dashboard', ['super_admin', 'admin', 'importer', 'viewer']);
        $this->assertRouteRoles('sales-transactions.index', ['super_admin', 'admin', 'importer', 'viewer']);
        $this->assertRouteRoles('sales-transactions.show', ['super_admin', 'admin', 'importer', 'viewer']);
        $this->assertRouteRoles('sales-transactions.export', ['super_admin', 'admin']);
    }

    public function test_importer_can_use_imports_and_conflict_review_but_not_destructive_admin_routes(): void
    {
        foreach ([
            'import-batches.index',
            'import-batches.create',
            'import-batches.store',
            'import-batches.show',
            'import-batches.sheets.preview',
            'import-batches.sheets.parse',
            'import-batches.parse-all',
            'import-batches.check-missing-from-latest',
        ] as $routeName) {
            $this->assertRouteRoles($routeName, ['super_admin', 'admin', 'importer']);
        }

        foreach ([
            'import-conflicts.index',
            'import-conflicts.show',
            'import-conflicts.mark-reviewed',
            'import-conflicts.mark-ignored',
            'import-conflicts.mark-resolved',
            'import-conflicts.accept-update',
            'import-conflicts.import-separate',
        ] as $routeName) {
            $this->assertRouteRoles($routeName, ['super_admin', 'admin', 'importer']);
        }

        $this->assertRouteRoles('import-conflicts.destroy', ['super_admin', 'admin']);
        $this->assertRouteRoles('import-batch-sheets.reset', ['super_admin', 'admin']);
    }

    public function test_admin_can_access_master_data_but_user_management_is_super_admin_only(): void
    {
        foreach ([
            'branches.index',
            'branches.create',
            'branches.store',
            'branches.show',
            'branches.edit',
            'branches.update',
            'branches.destroy',
            'business-units.index',
            'business-units.create',
            'business-units.store',
            'business-units.show',
            'business-units.edit',
            'business-units.update',
            'locations.index',
            'locations.create',
            'locations.store',
            'locations.show',
            'locations.edit',
            'locations.update',
            'product-lines.index',
            'product-lines.create',
            'product-lines.store',
            'product-lines.show',
            'product-lines.edit',
            'product-lines.update',
            'categories.index',
            'categories.create',
            'categories.store',
            'categories.show',
            'categories.edit',
            'categories.update',
            'brands.index',
            'brands.create',
            'brands.store',
            'brands.show',
            'brands.edit',
            'brands.update',
        ] as $routeName) {
            $this->assertRouteRoles($routeName, ['super_admin', 'admin']);
        }

        foreach ([
            'users.index',
            'users.create',
            'users.store',
            'users.show',
            'users.edit',
            'users.update',
        ] as $routeName) {
            $this->assertRouteRoles($routeName, ['super_admin']);
        }
    }

    private function assertRouteRoles(string $routeName, array $expectedRoles): void
    {
        $route = Route::getRoutes()->getByName($routeName);

        $this->assertNotNull($route, "Route [{$routeName}] does not exist.");

        $roleMiddleware = collect($route->gatherMiddleware())
            ->first(fn (string $middleware): bool => str_starts_with($middleware, 'role:'));

        $this->assertNotNull($roleMiddleware, "Route [{$routeName}] has no role middleware.");
        $this->assertSame('role:' . implode(',', $expectedRoles), $roleMiddleware);
    }
}
