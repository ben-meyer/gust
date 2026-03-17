# Website Specification

## Overview

**Title**: SwimQuest Swimming Holidays
**Live URL**: https://swimquest.uk.com
**Staging URL**: https://swimquest-4btr8.projectbeta.co.uk/
**PHP Version**: 8.3+

<!-- Brief description of the website's purpose and target audience -->
SwimQuest provide quality, friendly, safe swimming holidays for people of all ages and abilities. The target audience
is women in their early 60s, recently retired, solo travellers and swimming enthusiats from beginner to ex-olympian 
standard.

---

## Required Plugins

<!-- All plugins auto-update. Add/remove as needed. -->

- **ACF Pro** - Custom fields and Gutenberg blocks
- **Yoast SEO** - SEO management

---

## Content Types

<!--
  Each content type includes:
  - Basic config (URL, dashicon, supports, taxonomies)
  - Archive routing (if applicable)
  - Custom fields (if any)

  Format:
  ### slug
  Description.

  - URL: /url-structure/%postname%/
  - Dashicon: dashicons-xxx
  - Supports: title, editor, thumbnail, excerpt, etc.
  - Taxonomies: category, post_tag, custom-tax

  **Archive** (/archive-url/)
  - Template: Listing
  - Route: decorate:post_type:slug

  **Fields:**
  - **field_name** (type) - Description
-->

### page
Static pages.

- URL: /%pagename%/
- Dashicon: dashicons-admin-page
- Supports: title, editor, thumbnail
- Taxonomies: none
- Has archive: no

---

### trip
Core swim holiday product. Each post represents a trip that may run on multiple departure dates.

- URL: /trips/%postname%/
- Dashicon: dashicons-palmtree
- Supports: title, thumbnail, excerpt
- Taxonomies: trip_style, skill_level, country, city
- Has archive: no (accessed via Destinations, Calendar, and Trip Style taxonomy archives)

**Fields:**
- **dates** (repeater) - One or more date windows; UI shows date range if single, "Multiple dates" if more than one
  - **start_date** (date_picker)
  - **end_date** (date_picker)
  - **price** (number) - Price for this departure in GBP to two decimal places
- **itinerary** (post_object, post_type: itinerary) - Linked reusable itinerary
- **guides** (relationship, post_type: guide) - One or more assigned guides

---

### event
Swimming events. Mirrors the trip post type in structure and purpose — events may also have multiple departures. The distinction is editorial/content rather than structural.

- URL: /events/%postname%/
- Dashicon: dashicons-calendar-alt
- Supports: title, thumbnail, excerpt
- Taxonomies: trip_style, skill_level, country, city

**Archive** (/events/)
- Template: Listing
- Route: decorate:post_type:event

**Fields:**
- **dates** (repeater) - Same as trip
  - **start_date** (date_picker)
  - **end_date** (date_picker)
  - **price** (number)
- **itinerary** (post_object, post_type: itinerary)
- **guides** (relationship, post_type: guide)

---

### itinerary
Reusable day-by-day itinerary documents. Assigned to trips via post_object field. One-to-one relationship with trip in practice, but designed to be reused across multiple trips with the same route.

- URL: /itineraries/%postname%/
- Dashicon: dashicons-list-view
- Supports: title, thumbnail
- Taxonomies: none
- Has archive: no
- Note: publicly accessible and print-friendly — print stylesheet is a future requirement, not needed for scaffolding

**Fields:**
- **days** (repeater)
  - **label** (text) - e.g. "Day 1", "Arrival day"
  - **description** (wysiwyg)
  - **images** (gallery)

---

### story
Guest stories and reviews. Used in the Stories & Reviews section under About Us.

- URL: /stories/%postname%/
- Dashicon: dashicons-format-quote
- Supports: title, editor, thumbnail, excerpt
- Taxonomies: none

**Archive** (/stories/)
- Template: Listing
- Route: decorate:post_type:story

---

### guide
Guide and coach biographies. Used in "Meet our team" section under About Us.

- URL: /guides/%postname%/
- Dashicon: dashicons-id-alt
- Supports: title, thumbnail
- Taxonomies: none
- Has archive: no

**Fields:**
- **role** (text) - e.g. "Head Guide", "Swimming Coach"
- **biography** (wysiwyg)
- **gallery** (gallery)

---

## Taxonomies

<!--
  Each taxonomy includes:
  - Basic config (post types, hierarchical)
  - Archive routing (if applicable)
-->

### trip_style
Trip style categories used in primary navigation. 

- Post types: trip, event
- Hierarchical: no
- Rewrite slug: trip-styles
- Terms:
  - Short Swims & Dips
  - Relax & Explore
  - Technique & Improvement
  - Challenge & Distance
  - Groups & Bespoke
  - Family

**Archive** (/trip-styles/%slug%/) — one archive per term, e.g. /trip-styles/family/, /trip-styles/short-swims-dips/. WordPress generates these automatically from taxonomy registration; the single route below handles all terms with the same template.
- Template: Listing
- Route: decorate:taxonomy:trip_style

---

### skill_level
Swimmer ability level. Multi-select — a trip can suit more than one level.

- Post types: trip, event
- Hierarchical: no
- Terms: Dipper, Beginner, Intermediate, Advanced, Challenger, All Abilities

No archive (used as a filter only).

---

### country
Country-level taxonomy. Flat — country names only. Labeled "Destinations" in navigation and archive pages; slug `country` is the internal term.

- Post types: trip, event
- Hierarchical: no
- Rewrite slug: destinations

**Archive** (/destinations/%slug%/) — per-country listing
- Template: Listing
- Route: decorate:taxonomy:country

---

### city
City or location name. Used alongside `country` to form the display location string (e.g. "Mathraki, Greece").

- Post types: trip, event
- Hierarchical: no

No archive (display/filter use only).

---

## Standalone Routes

<!--
  Pages and routes not tied to content type archives.
-->

### Homepage (/)
- Template: Default

### Search Results (/search/)
- Template: Default
- Route: decorate:search

### 404
- Template: Default
- Route: decorate:404

### Destinations (/destinations/)
Index page listing all destination terms (countries) alphabetically with trip counts. Links into per-country taxonomy archives (/destinations/%slug%/).
- Template: Default
- Route: owned

### Trip Styles (/trip-styles/)
Overview/wayfinding page linking into all Trip Style taxonomy archives. Not a taxonomy archive itself — a static editorial page.
- Template: Default

### Calendar (/calendar/)
Chronological listing of all trips ordered by nearest departure date. Grouped first by year (e.g. 2026, 2027), then by month within each year (e.g. January, February). Queries the `dates` repeater field across all trip posts and renders cards.
- Template: Default
- Route: owned

---

## Site Settings

<!--
  Global settings stored in ACF options page.

  Format:
  - **field_name** (type) - Description
  - **field_name** (type, option: value) - With options
  - **field_name** (group)
    - **nested_field** (type)

  Common types: text, textarea, wysiwyg, image, file, gallery, select,
  checkbox, radio, true_false, link, page_link, post_object, relationship,
  taxonomy, user, google_map, date_picker, color_picker, group, repeater
-->

- **logo** (image, return: array) - Site logo
- **logo_alt** (image, return: array) - Alternative logo (e.g., white version)
- **footer_text** (textarea) - Footer copyright text
- **social_links** (repeater)
  - **platform** (select: facebook, twitter, instagram, linkedin, youtube)
  - **url** (url)

---

## Menus

<!--
  Format:
  - **menu_location** - Description of where it appears
-->

- **primary** - Main navigation in site header
- **footer** - Footer navigation links

<!-- Example:
- **mobile** - Mobile-specific navigation menu
- **social** - Social media links in footer
-->

---

## Components

<!--
  Each component includes:
  - Name and block status
  - Description
  - Full ACF field group definition

  Block status: [Block] = ACF Gutenberg block, [Partial] = PHP partial only
-->

### Page Header [Block]

Full-width hero section with heading, optional background image, and CTA.

**Fields:**
- **heading** (text) - Main heading
- **subheading** (textarea) - Supporting text
- **background_image** (image, return: array)
- **background_overlay** (true_false, default: true) - Dark overlay on image
- **cta** (group)
  - **link** (link) - Button link
  - **style** (select: primary, secondary, default: primary)
  - Conditional: show if `link` is not empty

### Card [Block]

Content card with image, title, excerpt, and link.

**Fields:**
- **image** (image, return: array)
- **title** (text)
- **excerpt** (textarea)
- **link** (link)
- **style** (select: default, featured, minimal)

<!-- Add more components following the same format -->

---

## Integrations

<!-- Third-party services and APIs -->

- **Feefo** - Customer reviews embedded on trip single pages
  - Integrated via custom HTML snippet in site header (Settings > Theme Options)
  - Review widgets dropped in as a Custom HTML block named "Feefo" within trip page content

---

## Other Functionality

<!-- Custom features, cron jobs, CLI commands, special behaviors -->

<!-- Example:
- **Event expiry** - Events automatically unpublished 24h after end date (wp-cron)
- **Import CLI** - `wp import-events` pulls events from external API
- **Member area** - Password-protected pages for logged-in users
-->
