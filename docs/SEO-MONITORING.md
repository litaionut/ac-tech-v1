# Monitorizare SEO — AC-tech

Ghid pentru configurarea Google Search Console și KPI lunar. Documentație operațională (nu cod).

## 1. Google Search Console

1. Mergi la [Google Search Console](https://search.google.com/search-console).
2. Adaugă proprietatea **URL prefix**: `https://ac-tech.ro`
3. Alege verificare **Meta tag HTML**.
4. Copiază valoarea atributului `content` din meta tag.
5. În WordPress: **Aspect → Personalizare → AC-tech — SEO & Search Console** → lipește codul.
6. Publică și apasă **Verifică** în Search Console.
7. Trimite sitemap: `https://ac-tech.ro/wp-sitemap.xml`

## 2. Google Analytics 4 (recomandat)

- Creează proprietate GA4 pentru `ac-tech.ro`.
- Instalează tag-ul via plugin ușor sau Google Site Kit (opțional).
- Marchează conversii: click pe `tel:`, trimitere formular contact, finalizare programare.

## 3. Google Business Profile

În **Aspect → Personalizare → AC-tech — Date firmă (NAP / SEO)** completează:

- Telefon, adresă, program (identic cu profilul Maps)
- **Link solicitare recenzie Google** — folosit pe site pentru campania de recenzii
- **Rating Google** — afișat doar dacă ai link recenzie valid

Campanie recenzii (manual):

- După fiecare intervenție finalizată, trimite SMS/email cu linkul de recenzie.
- Țintă 90 zile: **15–25 recenzii** (vezi plan SEO).

## 4. KPI lunar (raport simplu)

| Metric | Unde verifici | Notă baseline |
|--------|---------------|---------------|
| Impresii organice | Search Console → Performanță | Salvează luna 1 |
| Click-uri organice | Search Console | |
| CTR mediu | Search Console | Țintă > 3% |
| Poziții keywords | Search Console → filtre query | montaj aer condiționat bucurești, igienizare aer condiționat bucurești |
| Recenzii Google | Google Business | Număr + rating mediu |
| Apeluri site | GA4 evenimente `tel:` | |
| Programări | Booking / email confirmări | |

## 5. Verificări tehnice trimestriale

- [ ] PageSpeed Insights pe homepage și `/montaj-aer-conditionat-bucuresti/`
- [ ] NAP identic pe site, GBP, Facebook, directoare
- [ ] Pagini indexate fără erori în Search Console
- [ ] Meta title/description unice pe paginile principale
- [ ] Purge cache Cloudflare după deploy temă

## 6. Pagini SEO cheie (indexare)

- `/` — homepage
- `/servicii/` — catalog
- `/montaj-aer-conditionat-bucuresti/` — montaj local
- `/igienizare-ac/` — igienizare local
- `/programare/` — conversie
- `/contact/`

Creează pagina **Montaj AC** în WordPress cu șablonul *Montaj AC București* și slug `montaj-aer-conditionat-bucuresti`.
