import { test, expect } from '@playwright/test';

test.describe('Autenticación', () => {
  test('mostrar formulario de registro', async ({ page }) => {
    await page.goto('/register');
    await expect(page.getByRole('heading', { name: /Crear Cuenta/i })).toBeVisible();
    await expect(page.getByLabel('Nombre de Usuario')).toBeVisible();
    await expect(page.getByLabel('Email')).toBeVisible();
    await expect(page.getByLabel('Contraseña', { exact: true })).toBeVisible();
  });

  test('mostrar formulario de login', async ({ page }) => {
    await page.goto('/login');
    await expect(page.getByRole('heading', { name: /Iniciar Sesión/i })).toBeVisible();
    await expect(page.getByLabel('Email')).toBeVisible();
    await expect(page.getByLabel('Contraseña', { exact: true })).toBeVisible();
  });

  test('mostrar link de recuperación en login', async ({ page }) => {
    await page.goto('/login');
    await expect(page.getByRole('link', { name: /¿Olvidaste/i })).toBeVisible();
  });

  test('redireccionar a forgot-password', async ({ page }) => {
    await page.goto('/login');
    await page.getByRole('link', { name: /¿Olvidaste/i }).click();
    await expect(page).toHaveURL(/forgot-password/);
    await expect(page.getByRole('heading', { name: /Restablecer Contraseña/i })).toBeVisible();
  });

  test('mostrar formulario de reset password', async ({ page }) => {
    await page.goto('/forgot-password');
    await expect(page.getByRole('heading', { name: /Restablecer Contraseña/i })).toBeVisible();
    await expect(page.getByLabel(/Correo/i)).toBeVisible();
    await expect(page.getByRole('button', { name: /Enviar Enlace/i })).toBeVisible();
  });
});