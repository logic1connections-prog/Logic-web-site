# Mini-handover — Logic Connections Hub (20/09/2026)

**Werkbron:** `/home/birger/Bureaublad/logic-web-site` · uitvoerder: Hermes

## Gedaan

| # | Actie |
|---|---|
| 1 | Nieuwe pagina **Speelplaats** (`#demos`): 7 speelbare apps + demoversie Logic Connections |
| 2 | Nieuwe pagina **Video** (`#video`): 3 films met Madness Juice |
| 3 | **Jobs**-pagina uitgebreid: kennismaking voor jongeren + 4 vakgebieden + 5 sectoren in/rond Oostende |
| 4 | **Shop** uitgebreid: 6 digitale producten (lessen, bundels, apps, assets) boven het fysieke materiaal |
| 5 | **Portfolio** uitgebreid met diensten, lokale AI uitgelicht |
| 6 | **Home**: hub-sectie met 6 ingangen naar alle onderdelen |
| 7 | **3D-scroll**: dieptelagen, kantelende kaarten, muis-parallax, voortgangsbalk — zonder externe bibliotheek |
| 8 | Navigatie herbouwd: compacte labels + "Meer"-dropdown, volledig mobiel menu, deeplinks (`#demos`, `#video`, …) |

## Beslist

1. **Apps zijn meegekopieerd** naar `apps/` (7 × self-contained HTML, 18 MB). Bron blijft `/home/birger/Downloads/gamefiction af/apps` — daar is niets gewijzigd.
2. **Supabase-verzending uitgeschakeld in de publieke kopieën.** 4 apps stuurden naam + klas + score naar `quiz_results` met een publieke schrijfsleutel. In `apps/` is `submitResult()` geneutraliseerd én zijn sleutel + project-URL verwijderd. Sluit aan bij de afspraak: geen anonieme Supabase-sync.
3. **Video's gecomprimeerd**: `madness-en-vrienden.mp4` 38 MB → 6,3 MB. Drie extra films toegevoegd met posterbeeld. Originelen onaangeroerd in Factory / LOGIC_AI_SYSTEM.
4. **Kat-video verwijderd.** `fienoes-wc.mp4` bleek een AI-clip met een kat op een wc (Veo-watermerk), geen Fien-materiaal. Niet geplaatst — er is geen omschrijving bij verzonnen.
5. **Neon als accent**, niet als basis: `#B100FF`, `#FF2EB3`, `#00AFFF` als tokens, dikkere outlines (2 px) op de kaarten. Bestaande vorm, kleuren en opbouw zijn behouden.

## Bestanden

| Wat | Pad |
|---|---|
| Site | `index.html` (1356 → 2687 regels, 288 KB) |
| Speelbare apps | `apps/` — 7 bestanden, 18 MB |
| Video's + posters | `videos/` — 3 mp4 + 3 jpg, 16 MB |
| Deploy-config | `vercel.json` (apps/ toegevoegd) |
| Veiligstelling vooraf | `.backup-20260920/` (origineel index.html + videos, 37 MB, gegitignored) |

**Totaal deploybaar: 39 MB** — klaar voor `public_html` of Vercel.

## Gecontroleerd

- Headless Chrome op alle 9 pagina's: geen JS-fouten, elke deeplink opent de juiste pagina.
- Alle 7 apps laden standalone (DOM 260 KB – 6,9 MB).
- Alle lokale verwijzingen bestaan; div/section-balans klopt; visuele controle desktop + mobiel (414 px).
- **Twee fouten gevonden en hersteld tijdens de controle:** `starsPaused` in de temporal dead zone (brak het hele script na de starfield), en `#appStage` stond ná het script (`null` bij init).

## Nagekomen op 20-21/09

- **Gecommit en gepusht** (`ff6c07e`). Beide Vercel-projecten deployden automatisch; live op `logic-web-site.vercel.app` en `logic-web-site-qat7.vercel.app`. Live gecontroleerd: Supabase-sleutel en project-URL komen 0 keer voor.
- **`PROJECTREGISTER.md` rechtgezet** naar `Bureaublad/logic-web-site`; hash en datum bijgewerkt in `CONTEXT_VERSIE.md`.
- **Twee stale git-locks uit 17/09 verwijderd** (`index.lock`, `HEAD.lock`, beide 0 bytes, geen git-proces actief). `refs/heads/main.lock.stale` staat er nog en blokkeert niets.
- **Eigen domein: `logic-connections.be`** bij Hostinger. Gekozen richting: Hostinger wordt de echte site, Vercel blijft testomgeving.
- **Contactformulier werkt nu echt** via `contact.php` → `birger@logic-connections.be`.
- **`.htaccess`** toegevoegd: compressie, cache, beveiligingsheaders.
- **Uploadpakket:** `Bureaublad/logic-connections-be_public_html.zip` (34 MB).

## Open

1. **Afzenderadres van de mail.** `contact.php` verstuurt met `From: website@logic-connections.be`. Komt er niets aan, maak dan die mailbox aan in hPanel of zet `AFZENDER` op `birger@logic-connections.be`.
2. **Twee Vercel-projecten** hangen aan dezelfde repo (`logic-web-site` en `logic-web-site-qat7`); elke push deployt dubbel. Opruimen is nog niet beslist.
3. **Vercel-testversie kan het formulier niet versturen** (geen PHP). Toont daar netjes een foutmelding met mailto-terugval.
4. Meer Madness Juice-video's kunnen erbij; de sectie is daarop gebouwd.
5. Bij elke wijziging moet je nu handmatig uploaden naar Hostinger. Een deploy-script kan dat later in één commando doen.
