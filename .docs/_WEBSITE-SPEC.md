# Website Specification

## Overview

**Title**: SwimQuest Swimming Holidays
**Live URL**: https://swimquest.uk.com
**Staging URL**: https://swimquest-4btr8.projectbeta.co.uk/
**PHP Version**: 8.3+

<!-- Brief description of the website's purpose and target audience -->
SwimQuest provide quality, friendly, safe swimming holidays for people of all ages and abilities. The target audience
is women in their early 60s, recently retired, solo travellers and swimming enthusiasts from beginner to ex-olympian 
standard.

---

## Required Plugins

<!-- All plugins auto-update. Add/remove as needed. -->

- **ACF Pro** - Custom fields and Gutenberg blocks
- **Extended CPTs** - Custom post type and taxonomy registration helpers
- **Yoast SEO** - SEO management
- **Gravity Forms** - Enquiry and contact forms

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

---

### trip
Core swim holiday product. Each post represents a trip that may run on multiple departure dates. No standard archive — trips are accessed via Destinations, Calendar, and Trip Style taxonomy archives.

- URL: /trips/%postname%/
- Dashicon: dashicons-palmtree
- Supports: title, editor, excerpt, thumbnail
- Taxonomies: trip_style, skill_level, swim_type, country, city

**Fields:**
- **dates** (repeater) - One or more date windows; UI shows date range if single, "Multiple dates" if more than one
  - **start_date** (date_picker, return: Y-m-d)
  - **end_date** (date_picker, return: Y-m-d)
  - **price** (number, min: 0, step: 0.01) - Price for this departure in GBP
  - **status** (select) - Availability: bookable, sold_out, sold_out_private
  - **booking_url** (url) - Booking link shown when status is bookable
  - **enquiry_url** (url) - Enquiry link for that departure
- **itinerary** (post_object, post_type: itinerary, allow_null: true) - Linked reusable itinerary
- **accommodation** (post_object, post_type: accommodation, allow_null: true) - Linked accommodation post
- **highlights** (repeater, max: 4) - Highlight cards used in the locked Highlights section
  - **image** (image, return: array)
  - **heading** (text)
  - **description** (textarea)
- **included_items** (repeater) - Single-line items for "What's included"
  - **label** (text)
- **not_included_items** (repeater) - Single-line items for "Not included"
  - **label** (text)
- **getting_there_stages** (repeater) - Structured travel stages
  - **title** (text)
  - **steps** (repeater)
    - **icon** (select: plane, ferry, car, bus, train)
    - **title** (text)
    - **description** (wysiwyg)
- **reviews_embed_code** (textarea) - Raw embed code for the Reviews section
- **related_stories** (relationship, post_type: story, max: 2) - Manual story selection
- **related_trips** (relationship, post_type: trip, max: 3) - Manual trip selection

**Single Template**
- Template: Hard-coded PHP single
- Route: single:trip
- Editor model: classic admin screen with Gutenberg disabled and no main content editor
- Layout order: Trip Page Header, Section Nav, Highlights, Itinerary, Accommodation, What's Included, Getting There, Reviews, FAQs, Dates & Book, Related Stories, Related Trips
- Render rule: any section with no content must not render on the front end, and its jump link must also be hidden

---

### accommodation
Accommodation pages linked from trips.

- URL: /accommodation/%postname%/
- Dashicon: dashicons-building
- Supports: title, editor, thumbnail
- Taxonomies: none

**Fields:**
- **star_rating** (number, min: 1, max: 5) - Summary rating used on trip teaser and accommodation single
- **tags** (repeater) - Short facility labels
  - **label** (text)
- **description** (wysiwyg) - Accommodation summary copy
- **summary_gallery** (gallery, min: 1, max: 3) - Square-cropped gallery used in the trip teaser
- **rooms_intro** (textarea) - Intro copy above the "View accommodation" CTA

---

### event
Swimming events. Mirrors the trip post type in structure and purpose — events may also have multiple departures. The distinction is editorial/content rather than structural.

- URL: /events/%postname%/
- Dashicon: dashicons-calendar-alt
- Supports: title, editor, excerpt, thumbnail
- Taxonomies: trip_style, skill_level, swim_type, country, city

**Archive** (/events/)
- Template: Listing
- Route: decorate:post_type:event

**Fields:**
- **dates** (repeater) - One or more date windows
  - **start_date** (date_picker, return: Y-m-d)
  - **end_date** (date_picker, return: Y-m-d)
  - **price** (number, min: 0, step: 0.01) - Price in GBP
- **status** (select) - Availability: bookable, sold_out, sold_out_private
- **booking_url** (url) - Booking link shown when status is bookable
- Guides are standalone pages linked editorially — no ACF relationship field on event

---

### itinerary
Reusable day-by-day itinerary documents. Assigned to trips via post_object field. One-to-one relationship with trip in practice, but designed to be reused across multiple trips with the same route. Publicly accessible and intended to be print-friendly — print stylesheet is a future requirement, not needed for scaffolding.

- URL: /itineraries/%postname%/
- Dashicon: dashicons-list-view
- Supports: title, editor, thumbnail
- Taxonomies: none

Current scaffold still uses Gutenberg editor content.
Target model: locked structured day blocks, with day numbering derived from order and optional standalone gallery blocks inserted between day sections. Trip teaser should eventually pull the first 3 day entries only, without images.

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
- Supports: title, editor, thumbnail
- Taxonomies: none

**Fields:**
- **role** (text) - e.g. "Head Guide", "Swimming Coach"
- Full biography authored via Gutenberg editor

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
- Rewrite slug: cities

> **TBD:** Should the public-facing slug be `/cities/`, `/locations/`, or something else? `country` uses "destinations" as its editorial label — does `city` need similar treatment? Current implementation uses `/cities/` pending a decision.

**Archive** (/cities/%slug%/) — per-city listing
- Template: Listing
- Route: decorate:taxonomy:city

---

### swim_type
Type of swimming environment. Used to filter trips and events by the water context.

- Post types: trip, event
- Hierarchical: no
- Rewrite slug: swim-type
- Terms: Sea, Pool, Open Water, Lake, River

No archive (filter use only).

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
Owned route scaffolded for a destination index page. Controller currently returns an empty string; intended output is an alphabetical index of country terms linking to /destinations/%slug%/.
- Template: Default
- Route: owned

### Trip Styles (/trip-styles/)
Overview/wayfinding page linking into all Trip Style taxonomy archives. Not a taxonomy archive itself — a static editorial page.
- Template: Default
- Route: owned

### Calendar (/calendar/)
Owned route scaffolded for a calendar page. Controller currently returns an empty string; intended output is a chronological listing of trips grouped by year and month.
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

Full-width hero that auto-populates from the current page, post, term, or router page, with optional custom heading, subheading, CTA, and image.

**Fields:**
- **heading** (text) - Overrides the default title
- **subheading** (wysiwyg) - Supporting text
- **primary_call_to_action** (link) - Primary button link
- **image** (image, return: array) - Optional override image for the current object

### Trip Page Header [Partial]

Hard-coded trip hero section. Replaces `Page Header` on `trip` singles and combines editorial trip fields with derived trip metadata.

**Render rule:**
- Always present in the hard-coded `trip` template

**Auto-population logic:**
- Heading defaults to post title
- Date summary uses `Multiple dates` when more than one departure exists
- Location is built from `city` + `country`
- Price is derived from the cheapest `dates` row
- Ability level and swim type come from taxonomies
- Image falls back to featured image unless overridden

**Data source:**
- Post-level ACF and taxonomies on `trip`

**Fields:**
- **trip_heading** (text) - Optional title override
- **trip_description** (textarea) - Hero summary paragraph
- **trip_header_image** (image, return: array) - Optional hero image override
- **duration_nights** (number)
- **distance_min_km** (number)
- **distance_max_km** (number)
- **water_temp_min_c** (number)
- **water_temp_max_c** (number)
- **max_group_size** (number)
- **welcome_text** (text)
- **technique_coaching_text** (text)

### Trip Section Nav [Partial]

Sticky trip-only section navigation under the hero. Jump links are generated dynamically based on which hard-coded sections actually have content.

**Render rule:**
- Do not render if no eligible locked sections have content

**Auto-population logic:**
- Links appear only for populated sections
- Primary CTA opens the first available departure `enquiry_url`
- Secondary CTA links to `Dates & book` for multiple dates, or directly to the single departure `booking_url`

**Fields:**
- No block fields. Derived from trip data and relationships.

### Trip Highlights [Partial]

Locked Highlights section for the trip single page.

**Render rule:**
- Do not render if `highlights` is empty

**Data source:**
- Post-level ACF: `highlights`

### Trip Itinerary Preview [Partial]

Locked itinerary teaser on the trip page.

**Render rule:**
- Do not render if `itinerary` is not selected

**Data source:**
- Related post: `itinerary`
- Current scaffold uses related post title/excerpt/content summary and a CTA
- Target behaviour is a first-3-days teaser once the itinerary post type is restructured

### Trip Accommodation Preview [Partial]

Locked accommodation teaser on the trip page.

**Render rule:**
- Do not render if `accommodation` is not selected

**Data source:**
- Related post: `accommodation`
- Pulls summary fields, tags, star rating, square gallery, rooms intro, and CTA

### Trip Includes [Partial]

Locked "What's included" section.

**Render rule:**
- Do not render if both `included_items` and `not_included_items` are empty

**Data source:**
- Post-level ACF: `included_items`, `not_included_items`

### Trip Getting There [Partial]

Locked structured travel-information section.

**Render rule:**
- Do not render if `getting_there_stages` is empty

**Data source:**
- Post-level ACF: `getting_there_stages`

### Trip Reviews [Partial]

Locked reviews embed section.

**Render rule:**
- Do not render if `reviews_embed_code` is empty

**Data source:**
- Post-level ACF: `reviews_embed_code`

### Trip Related Stories [Partial]

Manual related-story section at the end of the trip page.

**Render rule:**
- Do not render if `related_stories` is empty

**Data source:**
- Post-level ACF relationship: `related_stories`

### Trip Related Trips [Partial]

Manual related-trip section at the end of the trip page.

**Render rule:**
- Do not render if `related_trips` is empty

**Data source:**
- Post-level ACF relationship: `related_trips`

### Cards [Block]

Responsive card grid for taxonomy terms, editorial posts, and custom content. Does **not** handle Trip posts — use `TripCards` for those.

**Fields:**
- **heading** (text) - Section heading
- **subheading** (wysiwyg) - Supporting text
- **button** (link) - Optional footer link
- **card_source** (button_group: recent, selected, trip_styles, destinations, custom) - Source for the cards
- **custom_cards** (repeater) - Manual card content shown when `card_source` is `custom`
  - **heading** (text)
  - **image** (image, return: array)
  - **text** (wysiwyg)
  - **meta** (wysiwyg)
  - **link** (link)
- **post_type** (button_group: story) - Post type used when `card_source` is `recent`
- **limit** (button_group: 2, 3, 4, 6) - Number of recent posts to query
- **selected** (relationship, post_type: page, story, events, guide) - Selected posts when `card_source` is `selected` (excludes `trip`)
- **selected_trip_styles** (taxonomy, trip_style, multi_select) - Specific trip styles when `card_source` is `trip_styles`; empty = all
- **selected_destinations** (taxonomy, country, multi_select, min: 2, max: 6) - Specific destinations when `card_source` is `destinations`; empty = all
- **type** (button_group: default, horizontal) - Switches card layout
- **card_background_color** (select: default, none) - Background color for cards
- **card_image_fit** (select: default, contain, cover) - Image fit mode
- **columns** (select: 2, 3, 4) - Grid column count
- **slider_on_mobile** (true_false) - Enable horizontal scroll on smaller screens

### Card [Partial]

Single card renderer used by the `Cards` block and archive grids.

**Fields:**
- No editor fields. Consumes either a `WP_Post`, a `WP_Term`, or a prepared `content` array at runtime.

### TripCards [Block]

3-column grid of trip cards. Used as an editor block (with heading/subheading and source options) and also rendered programmatically on `trip_style` and `country` taxonomy archives.

**Fields:**
- **heading** (text) - Section heading
- **subheading** (wysiwyg) - Supporting text
- **card_source** (button_group: recent, selected) - Trip source
- **limit** (button_group: 3, 6) - Number of recent trips to query (max 6)
- **selected** (relationship, post_type: trip, max: 6) - Manual trip selection when `card_source` is `selected`
- **button** (link) - Optional footer CTA

**Archive usage:**
- `trip_style` and `country` taxonomy archives render TripCards with the queried trips (no block fields, populated from the archive query)

### TripCard [Partial]

Single trip card renderer used by `TripCards`. Consumes a `WP_Post` of type `trip` and derives all display data from post-level ACF fields and taxonomies.

**Layout (top to bottom):**
1. Image (featured image, landscape crop)
2. Title (trip name)
3. Meta list with icons:
   - Dates: single range or "Multiple dates"
   - Location: `city` + `country` taxonomy terms
   - Skill levels: `skill_level` taxonomy terms, comma-separated
4. Price: "FROM £X,XXX" (cheapest departure from `dates` repeater)
5. CTA button: "VIEW TRIP & BOOK" (filled gold style)

**Fields:**
- No editor fields. Runtime input is a `WP_Post` of type `trip`.

### Accordion [Block]

Expandable content list for FAQs or rich text sections.

**Fields:**
- **heading** (text) - Optional section heading
- **accordion_items** (repeater)
  - **title** (text)
  - **content** (wysiwyg)

### Banner [Block]

Compact banner with inline image and message.

**Fields:**
- **image** (image, return: array) - Icon, logo, or image displayed inline with the banner message
- **message** (wysiwyg) - Required banner text
- **image_height** (range) - Inline image height in pixels

### Logo Grid [Block]

Grid of logos with optional links and a selectable aspect ratio.

**Fields:**
- **heading** (text) - Optional section heading
- **subheading** (wysiwyg) - Supporting text
- **logos** (repeater)
  - **image** (image, return: array)
  - **link** (link)
- **image_aspect_ratio** (button_group: default, square) - Logo image ratio

### Media & Content [Block]

Split layout combining text content with either an image or a video.

**Fields:**
- **heading** (text) - Main heading
- **subheading** (text) - Secondary heading
- **content** (wysiwyg) - Body content
- **button_1** (link) - Optional CTA button
- **media_type** (button_group: image, video) - Media source type
- **video** (oembed) - Video embed URL when `media_type` is `video`
- **image** (image, return: array) - Required cover image / fallback media image
- **media_side** (button_group: left, right) - Which side the media appears on

### Quote [Block]

Pull quote with optional credit and role.

**Fields:**
- **quote** (textarea) - Quote text
- **credit** (text) - Person or source name
- **role** (text) - Role or title

### Trip Dates [Block]

Server-rendered departure list for the current trip.

**Fields:**
- No block fields. Reads the current trip's `dates` repeater field.

### Taxonomy Filters [Partial]

Derived filter bar that renders term links for the current taxonomy or object context.

**Fields:**
- No editor fields. Runtime inputs include `taxonomy`, `object`, `current_item`, `label`, and `show`.

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
