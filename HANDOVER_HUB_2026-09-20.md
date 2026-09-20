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

## Open

1. **Niet gecommit, niet gepusht, niet gedeployed** — wacht op akkoord van Birger. Aandachtspunt: 18 MB apps in Git-historie is moeilijk terug te draaien.
2. `PROJECTREGISTER.md` noemt `/home/birger/Downloads/logic-web-site` als werkbron; die map bestaat niet meer. Rechtzetten naar `Bureaublad/logic-web-site`.
3. Contactformulier verstuurt nog niets (toont enkel een bevestiging) — dat was al zo.
4. Meer Madness Juice-video's kunnen erbij; de sectie is daarop gebouwd.
