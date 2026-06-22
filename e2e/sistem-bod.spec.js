import { test, expect } from '@playwright/test';

const BASE_URL = 'http://localhost:8080';

// ════════════════════════════════════════════════════════════════
//  TEST SUITE 1: Halaman Log Masuk Peserta (Participant Login)
// ════════════════════════════════════════════════════════════════

test.describe('Halaman Log Masuk Peserta', () => {

  test('Paparkan halaman login dengan betul', async ({ page }) => {
    await page.goto(`${BASE_URL}/login`);

    // Check the page title
    await expect(page).toHaveTitle(/Log Masuk/);

    // Check main heading is visible
    await expect(page.locator('h1')).toContainText('Log Masuk Portal');

    // Check the agency dropdown label exists
    await expect(page.locator('text=Pilih Agensi')).toBeVisible();

    // Check the participant name dropdown label exists
    await expect(page.locator('text=Nama Peserta')).toBeVisible();

    // Check the submit button exists and shows correct text
    const submitBtn = page.locator('button[type="submit"]');
    await expect(submitBtn).toBeVisible();
    await expect(submitBtn).toContainText('Log Masuk Ke Portal');
  });

  test('Butang submit dilumpuhkan sebelum pilih nama', async ({ page }) => {
    await page.goto(`${BASE_URL}/login`);

    // The submit button should be disabled until a user is selected
    const submitBtn = page.locator('button[type="submit"]');
    await expect(submitBtn).toBeDisabled();
  });

  test('Dropdown agensi boleh dibuka dan ada pilihan', async ({ page }) => {
    await page.goto(`${BASE_URL}/login`);

    // Click on the agency dropdown trigger
    const agencyDropdown = page.locator('text=-- Sila Pilih Agensi --');
    await agencyDropdown.click();

    // Wait for dropdown list to appear — look for the search input
    const searchInput = page.locator('input[placeholder="Cari Agensi..."]');
    await expect(searchInput).toBeVisible();

    // There should be at least one agency listed
    const agencyItems = page.locator('ul > li').first();
    await expect(agencyItems).toBeVisible();
  });

  test('Carian agensi berfungsi dengan betul', async ({ page }) => {
    await page.goto(`${BASE_URL}/login`);

    // Open agency dropdown
    await page.locator('text=-- Sila Pilih Agensi --').click();

    // Type a search query that likely won't match anything
    const searchInput = page.locator('input[placeholder="Cari Agensi..."]');
    await searchInput.fill('xyznonexistent');

    // Should show "Tiada Padanan Dijumpai"
    await expect(page.locator('text=Tiada Padanan Dijumpai')).toBeVisible();
  });

  test('Aliran penuh log masuk peserta: pilih agensi → pilih nama → log masuk', async ({ page }) => {
    await page.goto(`${BASE_URL}/login`);

    // 1. Open agency dropdown and pick the first agency
    await page.locator('text=-- Sila Pilih Agensi --').click();
    await page.waitForSelector('input[placeholder="Cari Agensi..."]');

    // Click the first agency in the list
    const firstAgency = page.locator('ul > li').first();
    await expect(firstAgency).toBeVisible();
    const agencyName = await firstAgency.textContent();
    await firstAgency.click();

    // 2. Open participant name dropdown and pick the first name
    // After selecting agency, the name dropdown should be enabled
    const nameDropdown = page.locator('text=-- Sila Pilih Nama --');
    await nameDropdown.click();
    await page.waitForSelector('input[placeholder="Cari Nama..."]');

    const firstName = page.locator('ul > li').first();
    await expect(firstName).toBeVisible();
    await firstName.click();

    // 3. Submit button should now be enabled
    const submitBtn = page.locator('button[type="submit"]');
    await expect(submitBtn).toBeEnabled();

    // 4. Click submit to login
    await submitBtn.click();

    // 5. Should redirect to the dashboard
    await page.waitForURL(/\/dashboard/);
    await expect(page).toHaveURL(/\/dashboard/);
  });

  test('Pautan ke log masuk admin wujud', async ({ page }) => {
    await page.goto(`${BASE_URL}/login`);

    // Check the admin login link exists
    const adminLink = page.locator('a[href*="admin/login"]');
    await expect(adminLink).toBeVisible();
    await expect(adminLink).toContainText('Log Masuk Urus Setia');
  });
});

// ════════════════════════════════════════════════════════════════
//  TEST SUITE 2: Halaman Log Masuk Admin
// ════════════════════════════════════════════════════════════════

test.describe('Halaman Log Masuk Admin', () => {

  test('Paparkan halaman admin login dengan betul', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/login`);

    // Page title check
    await expect(page).toHaveTitle(/Log Masuk Pentadbir/);

    // Main heading
    await expect(page.locator('h1')).toContainText('Log Masuk Admin');

    // "Zon Pentadbir Tertutup" badge
    await expect(page.locator('text=Zon Pentadbir Tertutup')).toBeVisible();

    // Email and password fields should exist
    await expect(page.locator('#email')).toBeVisible();
    await expect(page.locator('#password')).toBeVisible();

    // Submit button with correct text
    const submitBtn = page.locator('button[type="submit"]');
    await expect(submitBtn).toContainText('Akses Panel Pentadbir');
  });

  test('Validasi e-mel dan kata laluan kosong', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/login`);

    // Click submit with empty fields — HTML5 validation should prevent submission
    // We check that the email field has the 'required' attribute
    const emailField = page.locator('#email');
    await expect(emailField).toHaveAttribute('required', '');

    const passwordField = page.locator('#password');
    await expect(passwordField).toHaveAttribute('required', '');
  });

  test('Paparkan ralat untuk e-mel atau kata laluan tidak sah', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/login`);

    // Fill in wrong credentials
    await page.locator('#email').fill('wrong@email.com');
    await page.locator('#password').fill('wrongpassword');

    // Submit the form
    await page.locator('button[type="submit"]').click();

    // Should stay on admin login page and show error message
    await expect(page).toHaveURL(/admin\/login/);
    await expect(page.locator('text=E-mel atau kata laluan tidak sah')).toBeVisible();
  });

  test('Pautan kembali ke log masuk peserta wujud', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/login`);

    const backLink = page.locator('text=Kembali ke Log Masuk Peserta');
    await expect(backLink).toBeVisible();

    // Click and verify navigation
    await backLink.click();
    await expect(page).toHaveURL(/\/login/);
  });
});

// ════════════════════════════════════════════════════════════════
//  TEST SUITE 3: Dashboard Peserta (selepas log masuk)
// ════════════════════════════════════════════════════════════════

test.describe('Dashboard Peserta', () => {

  // Helper: log in as the first available participant
  async function loginAsParticipant(page) {
    await page.goto(`${BASE_URL}/login`);

    // Select agency
    await page.locator('text=-- Sila Pilih Agensi --').click();
    await page.waitForSelector('input[placeholder="Cari Agensi..."]');
    await page.locator('ul > li').first().click();

    // Select name
    await page.locator('text=-- Sila Pilih Nama --').click();
    await page.waitForSelector('input[placeholder="Cari Nama..."]');
    await page.locator('ul > li').first().click();

    // Submit
    await page.locator('button[type="submit"]').click();
    await page.waitForURL(/\/dashboard/);
  }

  test('Dashboard dipaparkan selepas log masuk berjaya', async ({ page }) => {
    await loginAsParticipant(page);

    // Title should contain the course name
    await expect(page).toHaveTitle(/Utama/);

    // Profile section should be visible
    await expect(page.locator('#section-profile')).toBeVisible();
  });

  test('Profil peserta dipaparkan dengan betul', async ({ page }) => {
    await loginAsParticipant(page);

    // The profile card should show "Peserta Berdaftar" label
    await expect(page.locator('text=Peserta Berdaftar')).toBeVisible();

    // Should show Jawatan and Agensi labels
    await expect(page.locator('text=Jawatan')).toBeVisible();
    await expect(page.locator('text=Agensi / Syarikat')).toBeVisible();
  });

  test('Kad QR kehadiran dipaparkan', async ({ page }) => {
    await loginAsParticipant(page);

    // QR section should be visible
    await expect(page.locator('#section-qr')).toBeVisible();

    // "Kod QR Kehadiran" heading should be visible
    await expect(page.locator('text=Kod QR Kehadiran')).toBeVisible();

    // Session display should show either "Hari 1" or "Hari 2"
    const sessionText = page.locator('#session-display-text');
    await expect(sessionText).toBeVisible();
  });

  test('Status kehadiran Hari 1 dan Hari 2 dipaparkan', async ({ page }) => {
    await loginAsParticipant(page);

    // Attendance status section
    await expect(page.locator('#section-attendance-status')).toBeVisible();

    // Should show "Hari 1" and "Hari 2" labels
    await expect(page.locator('text=Hari 1')).toBeVisible();
    await expect(page.locator('text=Hari 2')).toBeVisible();
  });

  test('Kad doorgift dipaparkan', async ({ page }) => {
    await loginAsParticipant(page);

    await expect(page.locator('#section-doorgift-status')).toBeVisible();
    await expect(page.locator('text=Doorgift')).toBeVisible();
  });

  test('Seksyen sijil dipaparkan', async ({ page }) => {
    await loginAsParticipant(page);

    await expect(page.locator('#section-certificate')).toBeVisible();
    await expect(page.locator('text=Sijil Penyertaan')).toBeVisible();
  });

  test('Butang Atur Cara (Itinerary) wujud dan boleh ditekan', async ({ page }) => {
    await loginAsParticipant(page);

    const itinerarySection = page.locator('#section-itinerary');
    await expect(itinerarySection).toBeVisible();
    await expect(page.locator('text=Atur Cara')).toBeVisible();

    // Click the "Lihat" button
    const lihatBtn = itinerarySection.locator('a:has-text("Lihat")');
    await expect(lihatBtn).toBeVisible();
    await lihatBtn.click();

    // Should navigate to itinerary page
    await expect(page).toHaveURL(/\/itinerary/);
  });

  test('Butang log keluar berfungsi', async ({ page }) => {
    await loginAsParticipant(page);

    // Click the logout button
    const logoutBtn = page.locator('#logout-btn');
    await expect(logoutBtn).toBeVisible();
    await logoutBtn.click();

    // Should redirect back to login page
    await page.waitForURL(/\/login/);
    await expect(page).toHaveURL(/\/login/);
  });
});

// ════════════════════════════════════════════════════════════════
//  TEST SUITE 4: Perlindungan Laluan (Route Guards)
// ════════════════════════════════════════════════════════════════

test.describe('Perlindungan Laluan (Route Guards)', () => {

  test('Halaman utama (/) redirect ke login jika belum log masuk', async ({ page }) => {
    await page.goto(`${BASE_URL}/`);
    await expect(page).toHaveURL(/\/login/);
  });

  test('Dashboard redirect ke login jika belum log masuk', async ({ page }) => {
    await page.goto(`${BASE_URL}/dashboard`);
    await expect(page).toHaveURL(/\/login/);
  });

  test('Admin dashboard redirect ke login jika belum log masuk', async ({ page }) => {
    await page.goto(`${BASE_URL}/admin/dashboard`);
    await expect(page).toHaveURL(/\/login/);
  });

  test('Secretariat dashboard redirect ke login jika belum log masuk', async ({ page }) => {
    await page.goto(`${BASE_URL}/secretariat/dashboard`);
    await expect(page).toHaveURL(/\/login/);
  });

  test('Evaluation page redirect ke login jika belum log masuk', async ({ page }) => {
    await page.goto(`${BASE_URL}/evaluation`);
    await expect(page).toHaveURL(/\/login/);
  });
});

// ════════════════════════════════════════════════════════════════
//  TEST SUITE 5: Responsif (Mobile & Desktop)
// ════════════════════════════════════════════════════════════════

test.describe('Responsif - Paparan Mobile', () => {

  test('Login page renders correctly on iPhone 14 viewport', async ({ page }) => {
    await page.setViewportSize({ width: 390, height: 844 });
    await page.goto(`${BASE_URL}/login`);

    // All key elements should be visible
    await expect(page.locator('h1')).toBeVisible();
    await expect(page.locator('button[type="submit"]')).toBeVisible();

    // The form card should not overflow the viewport
    const card = page.locator('.max-w-md').first();
    const box = await card.boundingBox();
    expect(box.width).toBeLessThanOrEqual(390);
  });

  test('Admin login page renders correctly on mobile', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto(`${BASE_URL}/admin/login`);

    await expect(page.locator('h1')).toBeVisible();
    await expect(page.locator('#email')).toBeVisible();
    await expect(page.locator('#password')).toBeVisible();
    await expect(page.locator('button[type="submit"]')).toBeVisible();
  });
});
