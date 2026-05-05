# Navigation Bug Fix Tracking

Reference pages — verify each fix on **desktop** and **mobile** before marking ✅:

| # | Page | URL |
|---|------|-----|
| A | Trip | https://swimquest.ddev.site/trip/the-isle-of-scilly/#trip-dates |
| B | Trip Styles term | https://swimquest.ddev.site/trip-styles/ |
| C | Homepage | https://swimquest.ddev.site/ |
| D | About Us | https://swimquest.ddev.site/events-2/about-us/ |
| E | Guide | https://swimquest.ddev.site/guide/nick-ayers/ |

## Bugs

### 1. Desktop sticky-on-scroll inconsistent across pages — DONE

- **Symptom:** On hero pages (A, C, D) the header was fixed and reveal-on-scroll-up worked; on non-hero pages (B, E) the header was `position: static` and just scrolled away with the page. Reveal behaviour was therefore only visible on some pages.
- **Expected:** Same sticky-scroll behaviour everywhere — bar fixed at top, hides on scroll-down, reveals on scroll-up.
- **Root cause:** `position: fixed` was only applied via `.site-header--hero`. Non-hero pages got the default static positioning.
- **Fix:** Applied `.site-header--positioned { position: fixed }` for all desktop widths and added `margin-top: var(--site-header--height)` to `.site-main` on non-hero pages. Stacked `.trip-section-nav` below the bar with `top: var(--site-header--height)` so the bar and the sticky trip nav don't collide. (`components/site-header/styles.pcss`, `components/trip-section-nav/styles.pcss`)
- **Verified:** A✅d B✅d C✅d D✅d E✅d (all five report `position: fixed`, `barTop: 0` at start, `-74` after scroll-down, `0` after scroll-up)

### 2. Mobile: logo missing on Trip page — DONE

- **Symptom:** On page A (and other hero pages) the SwimQuest logo was invisible at the top of the bar.
- **Expected:** Logo visible at top-left of every mobile bar.
- **Root cause:** `.site-header--hero` swapped the dark logo for `.logo-white` and forced `--link--color: var(--color-white)`. White logo over a light/swim-pool hero image disappeared.
- **Fix:** Removed the colour inversion in hero mode entirely. Brand colours retained over heroes per the spec ("no automatic colour inversion"). The white logo SVG is no longer rendered. (`components/site-header/styles.pcss`)
- **Verified:** A✅m B✅m C✅m D✅m E✅m (logo `.logo-default` visible on every page)

### 3. Mobile sub-nav: sub-menu link text invisible — DONE

- **Symptom:** When the mobile menu panel was open and a top-level item expanded, sub-item links were unreadable (white on white).
- **Expected:** Sub-menu links navy on the white panel.
- **Root cause:** The hero `--link--color: var(--color-white)` cascaded down into the menu panel; sub-menu items inherited white text against the panel's white background.
- **Fix:** Same removal of hero colour inversion (Bug 2). Links now inherit the brand navy colour everywhere. (`components/site-header/styles.pcss`)
- **Verified:** A✅m B✅m C✅m D✅m E✅m (sub-link colour reports `rgb(39, 68, 114)` navy)

### 4. Mobile nav: invisible X — impossible to close — DONE

- **Symptom:** When the mobile menu panel opened, no visible X / close button was rendered. The burger button transformed correctly in CSS but was hidden behind the panel.
- **Expected:** Bar with logo + close button stays visible above the menu panel.
- **Root cause:** `.site-header__panel` was `position: absolute; top: var(--site-header--top); height: 100% - top` — it covered the entire viewport including the bar. The bar had `z-index: 10` but no `position`, so its z-index was a no-op and it stacked beneath the panel (panel z:1).
- **Fix:** Made the panel start *below* the bar (`top: calc(--site-header--top + --site-header--height)` with matching height), so the bar (logo + burger/X) is always visible while the menu is open. Removed the now-redundant `padding-top` reservations inside the panel. (`components/site-header/styles.pcss`)
- **Verified:** A✅m B✅m C✅m D✅m E✅m (bar at y=0–70, panel at y=70–844; "✕ CLOSE" visible top-right with logo top-left)

## Process

1. Investigate each bug in the source.
2. Apply fix.
3. Reload page in Chrome MCP at desktop (1440×900) and mobile (390×844) widths.
4. Confirm the bug is gone on each reference page; tick the corresponding checkbox.
5. Only then mark the bug "Done".

> Note: Chrome DevTools MCP `resize_page` does not always honour mobile pixel widths exactly — the verified runs above were performed at the smallest size the runtime allowed (≈500px CSS pixels), which is well below the `screens.site-header` breakpoint (1150px), so the mobile layout was active for all tests.
