import { test, expect } from '@playwright/test';

test.describe('Mascotas', () => {
  test('mostrar listado de mascotas', async ({ page }) => {
    await page.goto('/pets');
    await expect(page.getByRole('heading', { name: /Mascotas en Adopción/i })).toBeVisible();
  });

  test('mostrar formulario de crear mascota (redirect a login)', async ({ page }) => {
    await page.goto('/pets/create');
    await expect(page).toHaveURL(/login/);
  });

  test('mostrar página about', async ({ page }) => {
    await page.goto('/about');
    await expect(page.getByRole('heading', { name: /Acerca de Petbook/i })).toBeVisible();
  });

  test('mostrar página contactos', async ({ page }) => {
    await page.goto('/contactos');
    await expect(page.getByRole('heading', { name: /Contactos/i })).toBeVisible();
  });

  test('mostrar página donaciones', async ({ page }) => {
    await page.goto('/donations');
    await expect(page.getByRole('heading', { name: /donación/i })).toBeVisible();
  });

  test('mostrar blog/posts', async ({ page }) => {
    await page.goto('/posts');
    await expect(page.locator('main h1, main h2').first()).toBeVisible();
  });

  test('mostrar mascotas perdidas', async ({ page }) => {
    await page.goto('/lostpets');
    await expect(page.getByRole('heading', { name: /Mascotas Perdidas/i })).toBeVisible();
  });

  test('mostrar formulario de reportar mascota perdida (redirect a login)', async ({ page }) => {
    await page.goto('/lostpets/create');
    await expect(page).toHaveURL(/login/);
  });
});