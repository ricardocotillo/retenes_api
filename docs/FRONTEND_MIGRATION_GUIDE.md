# Frontend Migration Guide: `mcla_prod` → Many-to-Many

`articulo_famdfa.mcla_prod` (scalar string) has been replaced by a many-to-many relationship with `tipo_de_descuentos` via a pivot table.

## What Changed

| Before | After |
|---|---|
| `"mcla_prod": "001"` | `"tipos_de_descuento": [{ ... }]` |
| One discount → one group | One discount → **many** groups |

## New `tipo_de_descuento` Object Shape

```json
{
  "id": 1,
  "nombre": "Willy Busch",
  "mcla_prod": "001",
  "created_at": "2025-09-04T12:00:00Z",
  "updated_at": "2025-09-04T12:00:00Z",
  "pivot": {
    "articulo_famdfa_id": 42,
    "tipo_de_descuento_id": 1,
    "created_at": "2026-04-13T22:31:00Z",
    "updated_at": "2026-04-13T22:31:00Z"
  }
}
```

---

## Affected Routes

### 1. `POST /api/dfa/` — Item discounts

**Request:** Unchanged (`mcodart`, `mcodcli`).

**Before:**
```json
{
  "id": 42, "mcodart": "ART001", "mcoddfa": "001",
  "mcla_prod": "001",
  "famdfa": { "id": 10, "MCODDFA": "001", "MDESCRIP": "5%", "MPOR_DFA": 5.0 }
}
```

**After:**
```json
{
  "id": 42, "mcodart": "ART001", "mcoddfa": "001",
  "tipos_de_descuento": [
    { "id": 1, "nombre": "Willy Busch", "mcla_prod": "001", "pivot": { "articulo_famdfa_id": 42, "tipo_de_descuento_id": 1 } }
  ],
  "famdfa": { "id": 10, "MCODDFA": "001", "MDESCRIP": "5%", "MPOR_DFA": 5.0 }
}
```

**Key diff:** `mcla_prod` (string) → `tipos_de_descuento` (array of objects).

---

### 2. `GET /api/descuento_general/{code}/` — General discounts

**Request params:** Unchanged (`impneto`, `mcodcadi`, `mcondpago`, `mcodcli`, `mindcred`, `mcla_prod`, `mcodzon`, `mcodven`).

> `mcla_prod` is still accepted as a **query filter** — it now filters discounts that have a matching `tipo_de_descuento` via the relationship, not a direct column.

**Response change:** Same as route 1 — `mcla_prod` field replaced by `tipos_de_descuento` array.

---

### 3. `GET /api/tipo_de_descuentos/` — Catalog (unchanged)

Returns all discount types. **No structural change**, but now more useful as the source of truth for `tipo_de_descuento_id` values.

```json
[
  { "id": 1, "nombre": "Willy Busch", "mcla_prod": "001", "created_at": "...", "updated_at": "..." },
  { "id": 2, "nombre": "Importados", "mcla_prod": "002", "created_at": "...", "updated_at": "..." }
]
```

---

## Routes NOT Changed (but may need frontend attention)

These routes still use `mcla_prod` in the `detpe` / `detpe_famdfa` domain (applied discounts on order lines). Their **schemas are unchanged**, but if the frontend previously derived the `mcla_prod` value from `articulo_famdfa.mcla_prod`, you'll need to read it from `tipos_de_descuento[0].mcla_prod` or from `articulo.MCLA_PROD` instead.

| Route | Usage |
|---|---|
| `POST /api/cabped/` | Writes `mcla_prod` into `detpe` from `articulo.MCLA_PROD` |
| `POST /api/cabpe/{mnserie}/{mnroped}/add_famdfa/` | Attaches `mcla_prod` on `detpe_famdfa` pivot |
| `DELETE /api/cabpe/{id}/remove_famdfa/` | Filters `detpe_famdfa` by pivot `mcla_prod` |
| `PATCH /api/cabpe/{id}/update_famdfa/` | Filters & attaches `mcla_prod` on `detpe_famdfa` pivot |

---

## Frontend Action Items

1. **Replace all reads of `item.mcla_prod`** with `item.tipos_de_descuento` (array). If you need the code(s), map over `tipos_de_descuento.map(t => t.mcla_prod)`.

2. **Filtering by `mcla_prod`** in `descuento_general` still works — pass `mcla_prod` as a query param as before. The backend now resolves it through the relationship.

3. **Any create/edit form** for `articulo_famdfa` should switch from a single `mcla_prod` dropdown to a **multi-select** of `tipo_de_descuento` entries (from the `/api/tipo_de_descuentos/` catalog).

4. **Order-line (`detpe`) flows** that send `mcla_prod` to Cabpe/Detpe endpoints are unchanged on the backend, but verify the frontend still has access to the source value (e.g. from `articulo.MCLA_PROD` or from the first element of `tipos_de_descuento`).
