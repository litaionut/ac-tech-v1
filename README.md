# AC-Tech — temă WordPress

Temă custom pentru [ac-tech.ro](https://ac-tech.ro): homepage, servicii, blog, contact, programare și șabloane articol.

**Versiune curentă:** `1.10.4` (`_S_VERSION` în `functions.php`)

## Cerințe

- WordPress 6.x+
- [Advanced Custom Fields](https://www.advancedcustomfields.com/) (grupuri locale în `inc/*-acf-fields.php`)
- Pagini: Acasă (static front), Blog (`page_for_posts`), șabloane Contact / Programare

## Dezvoltare locală

- **Local:** `http://ac-tech.local` — tema în `wp-content/themes/ac-tech`
- **Repo Git (sursă):** acest folder

## Deploy live

```powershell
.\deploy.ps1
```

Necesită `.env.deploy` (copie din `.env.deploy.example`). După deploy: purge cache Cloudflare pentru `assets/`.

## Git & GitHub

Remote:

```text
https://github.com/litaionut/ac-tech.git
```

Prima dată pe GitHub: creează repo gol **ac-tech** (privat recomandat), fără README, apoi:

```powershell
git remote add origin https://github.com/litaionut/ac-tech.git   # dacă lipsește
git push -u origin master
git push origin v1.10.4
```

Sau rulează `.\scripts\setup-github.ps1` (deschide pagina de creare repo + încearcă push).

### Revenire la o versiune

```powershell
git tag -l
git checkout v1.10.4
```

## Structură relevantă

| Zonă | Fișiere |
|------|---------|
| Homepage ACF | `inc/home-editable.php`, `inc/home-acf-fields.php` |
| Contact ACF | `inc/contact-editable.php`, `inc/contact-acf-fields.php` |
| Blog ACF | `inc/blog-editable.php`, `inc/blog-acf-fields.php` |
| Articole (3 șabloane) | `inc/post-template-*`, `single-post-template-*.php` |
| Programare (UI demo) | `template-booking.php`, `js/booking.js` |

## Licență

GPLv2 or later (bază `_s` / Underscores).
