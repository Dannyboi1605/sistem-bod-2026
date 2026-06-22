import { test, expect } from '@playwright/test';

test('Pastikan komponen utama UI nampak di skrin iPhone 14', async ({ page }) => {
  // 1. Paksa pelayar web menyamar sebagai resolusi skrin iPhone 14
  await page.setViewportSize({ width: 390, height: 844 });
  
  // 2. Halakan pelayar web ke halaman log masuk localhost kau
  await page.goto('http://localhost:8080/login');
  
  // 3. Playwright akan menyemak sama ada butang submit wujud dan tidak terlindung
  const loginButton = page.locator('button[type="submit"]');
  await expect(loginButton).toBeVisible();
});