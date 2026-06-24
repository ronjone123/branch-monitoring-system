# Deployment Checklist

Use this checklist before deploying the Branch Monitoring and Import System to a server.

## Production environment

- Set `APP_ENV=production`.
- Set `APP_DEBUG=false`.
- Generate and set a valid `APP_KEY`.
- Set `APP_TIMEZONE=Asia/Manila`.
- Set the production `APP_URL`.
- Configure MySQL/MariaDB credentials with the production database name, user, and password.
- Configure mail/log/session/cache settings appropriate for the server.

## Storage and permissions

- Ensure `storage/` and `bootstrap/cache/` are writable by the web server user.
- Back up both the database and uploaded import workbooks before resets, migrations, or deployments.
- Include `storage/app/private` in file backups because uploaded import workbooks are stored there.
- Run `php artisan storage:link` if public storage assets are used by the deployment.

## Optimization commands

Run after installing dependencies and setting the production `.env`:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Run `php artisan optimize:clear` before rebuilding caches if configuration or routes changed.

## Queue worker

Imports can dispatch queued parsing jobs. A queue worker must be supervised in production.

Recommended command:

```bash
php artisan queue:work --tries=3 --timeout=1200
```

Monitor `failed_jobs` and restart workers after deployments.

## Backup and reset safety

- Create a verified full database backup before running any import-data reset.
- Confirm uploaded workbook files are backed up separately from the database.
- Use `php artisan imports:reset --dry-run` before any confirmed reset.
- Never expose reset commands as public web routes.

## Final smoke checks

- Login as each role: viewer, importer, admin, and super_admin.
- Confirm dashboards load.
- Confirm importer workflows can access import batches and conflict review.
- Confirm viewer/importer cannot export sales transactions.
- Confirm admin/super_admin can export sales transactions.
- Confirm the queue worker processes a controlled import job.
