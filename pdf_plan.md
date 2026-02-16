# Plan: Fix new_pedido.blade.php for DOMPDF Compatibility

## Problem

DOMPDF does **not support CSS flexbox** (`display: flex`). It silently downgrades `flex` to `block`, so all flex-based layouts collapse into stacked block elements instead of side-by-side columns. The template currently uses `display: flex` in 5 places.

## Affected Sections (all `display: flex` usages)

1. **Line 7 — Header row** (`gap: 24px; align-items: flex-end`): Two-column layout with the order number/title (60%) on the left and the company logo+info (40%) on the right.

2. **Line 12 — Logo + company info** (`justify-content: space-between; align-items: center`): Logo image on the left, company name/address text block on the right.

3. **Line 33 — "DATOS DEL CLIENTE" section header** (`justify-content: space-between; align-items: center`): Title on the left, date on the right.

4. **Line 65 — "DATOS ADICIONALES" section header** (`justify-content: space-between; align-items: center`): Title on the left (no right content currently, but keeps the flex pattern).

5. **Line 151 — Bottom section** (`justify-content: space-between; align-items: center`): Two-column layout with "CONDICIONES DE VENTA" (40%) on the left and the totals table (40%) on the right.

6. **Line 163 — Totals wrapper** (`display: flex; justify-content: flex-end`): Aligns the totals table to the right.

## Strategy

Replace every `display: flex` with **HTML `<table>` elements** for layout. This is the most reliable approach in DOMPDF (CSS 2.1 renderer). Floats are partially supported but buggy; CSS `display: table-cell` is partially supported but less reliable than real `<table>` tags.

## Changes

### 1. Header row (lines 7–32)
**Current:** `<div style="display: flex; gap: 24px; align-items: flex-end">` containing two child divs (60% and 40%).
**Replace with:** A `<table>` with one row and two cells. First `<td>` gets `width: 60%; vertical-align: bottom;`, second `<td>` gets `width: 40%; vertical-align: bottom;`.

### 2. Logo + company info (line 12)
**Current:** `<div style="display: flex; justify-content: space-between; align-items: center">` containing `<img>` and `<div>`.
**Replace with:** A nested `<table>` with one row. First `<td>` holds the logo with `vertical-align: middle`, second `<td>` holds the company text with `vertical-align: middle`.

### 3. "DATOS DEL CLIENTE" header (line 33)
**Current:** `<div style="display: flex; justify-content: space-between; align-items: center">` with `<h1>` and `<p>`.
**Replace with:** A `<table width="100%">` with one row. First `<td>` has the title (left-aligned), second `<td>` has the date (right-aligned via `text-align: right`).

### 4. "DATOS ADICIONALES" header (line 65)
**Current:** `<div style="display: flex; justify-content: space-between; align-items: center">` with just `<h1>`.
**Replace with:** Same pattern as #3 — a `<table width="100%">` with one row. Only one cell needed here, but using the same pattern for consistency. Can simplify to just a `<div>` without flex since there's only one child.

### 5. Bottom two-column section (lines 151–192)
**Current:** `<div style="display: flex; justify-content: space-between; align-items: center">` with two child divs (40% each).
**Replace with:** A `<table width="100%">` with one row. First `<td width="50%">` has "CONDICIONES DE VENTA", second `<td width="50%">` has the totals table (right-aligned content).

### 6. Totals wrapper (line 163)
**Current:** `<div style="display: flex; justify-content: flex-end">`.
**Replace with:** Remove the wrapper div entirely; the `<td>` from change #5 already positions this content. Use `text-align: right` on the cell if needed.

## Non-flex issues to also address

- **Line 3:** `<meta charset="UTF-8">>` has a double `>` — fix the typo.

## Files to modify

- `resources/views/attach/new_pedido.blade.php` — the only file that needs changes.

## Testing

After changes, regenerate a PDF via the existing `download_pdf` endpoint or `send_email` flow and verify the layout visually matches the intended design (two-column header, side-by-side bottom section, etc.).
