# MarketHub

A custom WordPress multi-vendor marketplace theme with modern architecture.

## Tech Stack
- WordPress 6.4+
- PHP 8.1+ (OOP)
- Bootstrap 5.3 (npm-managed)
- SCSS (7-1 Architecture)
- ES6+ JavaScript
- WooCommerce Integration

## Local Setup
1. Install dependencies: `npm install` and `composer install`
2. Build assets: `npm run build`
3. Activate theme in WordPress admin

## Folder Structure
- `inc/Core/` - Framework bootstrap (Theme, Assets, Autoloader)
- `inc/Setup/` - Business logic (Vendors, WooCommerce, Taxonomies)
- `inc/Utils/` - Cross-cutting utilities (Security, Template Tags)
- `assets/src/` - Source SCSS and JS
- `assets/dist/` - Compiled assets (gitignored)
- `template-parts/` - Reusable template components

## Features
- Custom Vendor CPT and Dashboard
- AJAX Product Filtering
- Dynamic Cart Updates
- Bootstrap 5 Responsive Design
- Secure Form Handling with Nonces
