# Mutabadil.com - Project Documentation

Urdu language news/opinion platform built on WordPress with the Publisher theme.

**URL:** https://mutabadil.com  
**Hosting:** WebSupport.sk (shared hosting)  
**SSH:** `ssh uid5179277@shell.r103.websupport.se -p 26879`  
**WordPress Path:** `/data/4/0/40b4caae-3ac8-469c-97dd-38325e95a8fc/mutabadil.com/web/`  
**WP-CLI:** Available at site root as `php wp-cli.phar`

---

## Tech Stack

| Component | Version | Notes |
|-----------|---------|-------|
| WordPress | 6.9.4 | Auto-updates recommended |
| PHP | 8.5.5 | Server-managed |
| Theme | Publisher 7.11.0 | By BetterStudio |
| Database | MariaDB 10.5 | mariadb105.r103.websupport.sk:3312 |
| SSL | Active | Via hosting provider |
| CDN | None (Cloudflare planned) | |

## Users

| Username | Email | Role |
|----------|-------|------|
| admin | talat@rafilm.se | Administrator |
| Atif | tauqeer.atif@gmail.com | Administrator |
| Mahnaz | mhzakhter@gmail.com | Editor |

## Active Plugins

| Plugin | Purpose |
|--------|---------|
| Wordfence 8.2.1 | Security firewall, login protection, malware scanning |
| Akismet 5.7 | Spam comment filtering |
| All-in-One WP Migration 7.105 | Backup/migration |
| Disable Comments 2.7.0 | Site-wide comment disabling |

All plugins have auto-updates enabled.

## Content Structure

- **982 posts** - All Urdu language articles
- **10 categories** - All in Urdu (see Categories section)
- **4 tags** - Minimal tagging
- **Navigation menu** - "Header" menu with 8 Urdu category links

### Categories

| Category | Slug | Description |
|----------|------|-------------|
| سب متبادل | سب-متبادل | All Mutabadil |
| متبادل | متبادل | Mutabadil |
| متبادل-آئینہ-بلاگز | متبادل-آئینہ-بلاگز | Mirror Blogs (947 posts) |
| متبادل-چہرہ-وی-لاگز | متبادل-چہرہ-وی-لاگز | Face V-Logs (36 posts) |
| متبادل-خبر | متبادل-خبر | News |
| متبادل-سے-رابطہ | متبادل-سے-رابطہ | Contact |
| متبادل-لوگ | متبادل-لوگ | People |
| مددگار | مددگار | Helpful |

---

## Font Configuration

### Jameel Noori Nastaleeq (Primary Font)

Self-hosted WOFF2 file at:
```
wp-content/themes/publisher/fonts/JameelNooriNastaleeq.woff2
```

Font stack (in order of priority):
1. Jameel Noori Nastaleeq (self-hosted)
2. Noto Nastaliq Urdu (Google Fonts)
3. Gulzar (Google Fonts)
4. Urdu Typesetting (system fallback)

### Custom CSS File

All typography and RTL customizations are in:
```
wp-content/themes/publisher/custom-nastaleeq.css
```

This file controls:
- @font-face declaration for Jameel Noori Nastaleeq
- Font-family applied to all text elements
- RTL direction
- Font sizes (body: 16px, h1: 1.8em, h2: 1.5em, h3: 1.3em)
- Line-height (body: 2.4, headings: 2.2)

### How to Change the Font

1. **To change font sizes:** Edit `custom-nastaleeq.css`, modify `font-size` values
2. **To change line spacing:** Edit `custom-nastaleeq.css`, modify `line-height` values
3. **To add a new font:** Upload WOFF2 to `wp-content/themes/publisher/fonts/`, add @font-face in CSS
4. **To switch primary font:** Change the order in the `font-family` declarations

### Font Loading

Fonts are enqueued via `functions.php` (at the bottom of the file):
```php
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_style("google-nastaleeq", "https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&family=Gulzar&display=swap", array(), null);
    wp_enqueue_style("custom-nastaleeq", get_template_directory_uri() . "/custom-nastaleeq.css", array("google-nastaleeq"), "1.0");
}, 999);
```

---

## RTL Configuration

- WordPress language set to Urdu (`ur`)
- HTML has `dir="rtl" lang="ur"`
- Publisher theme has built-in RTL support (`rtl.css`)
- Additional RTL rules in `custom-nastaleeq.css`
- All user admin dashboards set to Urdu locale

---

## Security Hardening (May 2026)

### Hack Incident & Cleanup

The site was hacked sometime in late 2024/early 2025. Damage found and cleaned:

| Item | Count | Action |
|------|-------|--------|
| Casino spam posts | ~1,970 | Deleted |
| Spam categories | 172 | Deleted |
| Backdoor: wp-best-feed.php | 1 | Deleted (obfuscated PHP with file upload + RCE) |
| Backdoor: hellos plugin | 1 | Deleted (fake "Hello Joy" plugin with eval + remote code fetch) |
| Spam menu items | 3 | Deleted (ghostwriting links) |
| Spam sidebar widget | 1 | Deleted (hidden casino links) |
| Hello World posts | 2 | Deleted |

### Security Measures Applied

1. **Passwords** - All 3 user passwords changed to strong passwords
2. **HTTPS** - Site URL updated from http:// to https:// in wp-config.php
3. **File permissions** - wp-config.php set to 640 (owner read/write, group read only)
4. **XML-RPC blocked** - Disabled via .htaccess to prevent brute force attacks
5. **Unused themes deleted** - Removed 7 themes, kept only publisher + twentytwentyfive (fallback)
6. **Plugin auto-updates** - Enabled for all 4 plugins
7. **Wordfence configured:**
   - Login lockout: 5 failed attempts = 30 min lockout
   - Firewall enabled
   - Fake bot blocking enabled
   - Scanner auto-blocking enabled
   - Author scan protection enabled
   - WordPress version hidden
8. **Security headers** (.htaccess):
   - X-Content-Type-Options: nosniff
   - X-Frame-Options: SAMEORIGIN
   - X-XSS-Protection: 1; mode=block
   - Referrer-Policy: strict-origin-when-cross-origin
9. **Directory browsing disabled** - Options -Indexes

### .htaccess Security Rules

```apache
# Block XML-RPC
<Files xmlrpc.php>
Order Deny,Allow
Deny from all
</Files>

# Block wp-config.php access
<Files wp-config.php>
Order Deny,Allow
Deny from all
</Files>

# Block directory browsing
Options -Indexes

# Security headers
<IfModule mod_headers.c>
Header set X-Content-Type-Options nosniff
Header set X-Frame-Options SAMEORIGIN
Header set X-XSS-Protection "1; mode=block"
Header set Referrer-Policy strict-origin-when-cross-origin
</IfModule>
```

---

## Database

| Setting | Value |
|---------|-------|
| DB Name | tbpzzi8itexf5w |
| DB User | 6nphxrgp0vz0f1 |
| DB Host | mariadb105.r103.websupport.sk:3312 |
| Table Prefix | aahvyh_ |

Non-standard table prefix is good for security (not the default `wp_`).

---

## Theme Customization

### Footer Credit

Footer shows "Website designed by Bergmancoding.se" - configured in theme options:
```
bs_publisher_theme_options -> footer_copy2
```

### Sidebar Widget

Primary sidebar has `bs-thumbnail-listing-1` widget showing recent posts with Urdu title "تازہ ترین مضامین".

---

## Maintenance Checklist

### Monthly
- [ ] Check Wordfence scan results (wp-admin > Wordfence > Scan)
- [ ] Review login attempt logs (Wordfence > Tools > Live Traffic)
- [ ] Verify all plugins are up-to-date

### Quarterly
- [ ] Full backup via All-in-One WP Migration
- [ ] Review user accounts - remove any unknown users
- [ ] Check for WordPress core updates
- [ ] Review .htaccess for unauthorized changes

### After Any Hack
1. Change all user passwords immediately
2. Run Wordfence full scan
3. Check for new files: `find . -name "*.php" -mtime -7`
4. Review wp-content/plugins for unknown plugins
5. Check .htaccess for injected rules
6. Review database for spam posts/pages

---

## Future Recommendations

1. **Cloudflare** - Add Cloudflare free tier for DDoS protection, WAF, and CDN caching
2. **Backup Schedule** - Set up automated backups (All-in-One WP Migration or server-level)
3. **Two-Factor Auth** - Enable 2FA via Wordfence for admin accounts
4. **Content Delivery** - Optimize images with a plugin like ShortPixel or Imagify
5. **SEO** - Consider adding Yoast SEO or Rank Math for better search rankings
6. **Analytics** - Add Google Analytics to track visitor statistics
