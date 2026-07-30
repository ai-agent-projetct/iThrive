#!/usr/bin/env python3
"""
Generates 1200x630 Open Graph share images.

One per top-level page, service group, solution and case study, so a link to
any route unfurls with something branded instead of a blank card.

    python .tools/make-og-images.py

Output: assets/img/og/<slug>.png
"""

import os
import re

from PIL import Image, ImageDraw, ImageFont

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
OUT = os.path.join(ROOT, 'assets', 'img', 'og')

W, H = 1200, 630
INK = (11, 15, 23)
CYAN = (0, 242, 254)
PURPLE = (157, 78, 221)
TEXT = (234, 240, 250)
DIM = (154, 167, 189)


def font(size, bold=True):
    for p in ('C:/Windows/Fonts/seguisb.ttf' if not bold else 'C:/Windows/Fonts/seguibl.ttf',
              'C:/Windows/Fonts/arialbd.ttf', 'C:/Windows/Fonts/arial.ttf'):
        if os.path.isfile(p):
            return ImageFont.truetype(p, size)
    return ImageFont.load_default()


def lerp(a, b, t):
    return tuple(round(x + (y - x) * t) for x, y in zip(a, b))


def canvas():
    im = Image.new('RGB', (W, H), INK)
    d = ImageDraw.Draw(im, 'RGBA')

    # Corner blooms, matching the site's background treatment.
    for cx, cy, col, rad in ((150, 40, CYAN, 620), (1080, 90, PURPLE, 660)):
        for r in range(rad, 0, -14):
            t = r / rad
            d.ellipse([cx - r, cy - r, cx + r, cy + r],
                      fill=(*col, max(1, int(16 * (1 - t)))))

    for x in range(0, W, 48):
        d.line([(x, 0), (x, H)], fill=(255, 255, 255, 8))
    for y in range(0, H, 48):
        d.line([(0, y), (W, y)], fill=(255, 255, 255, 8))

    # Gradient rule along the top edge.
    for x in range(W):
        d.line([(x, 0), (x, 7)], fill=lerp(CYAN, PURPLE, x / W))
    return im, d


def wrap(d, text, fnt, max_w):
    words, lines, cur = text.split(), [], ''
    for w in words:
        trial = (cur + ' ' + w).strip()
        if d.textlength(trial, font=fnt) <= max_w:
            cur = trial
        else:
            if cur:
                lines.append(cur)
            cur = w
    if cur:
        lines.append(cur)
    return lines


def build(slug, eyebrow, title, footer=''):
    im, d = canvas()
    x = 82

    d.text((x, 92), eyebrow.upper(), font=font(25), fill=CYAN)

    fnt = font(63)
    lines = wrap(d, title, fnt, W - 2 * x)
    if len(lines) > 3:
        lines = lines[:3]
        lines[-1] = lines[-1].rstrip('.,') + '…'
    y = 158
    for ln in lines:
        d.text((x, y), ln, font=fnt, fill=TEXT)
        y += 78

    d.line([(x, H - 132), (W - x, H - 132)], fill=(255, 255, 255, 34))
    d.text((x, H - 104), 'Ithrive Software Solutions', font=font(34), fill=TEXT)
    if footer:
        d.text((x, H - 60), footer, font=font(25, bold=False), fill=DIM)

    # Accent block, bottom right.
    for i, col in enumerate((CYAN, PURPLE)):
        d.rounded_rectangle([W - 82 - 116 + i * 58, H - 108, W - 82 - 62 + i * 58, H - 54],
                            radius=14, fill=(*col, 190))

    # These are flat brand graphics, not photographs — a 256-colour palette is
    # visually identical here and roughly a quarter of the bytes.
    path = os.path.join(OUT, f'{slug}.png')
    im.quantize(colors=256, method=Image.MEDIANCUT, dither=Image.FLOYDSTEINBERG) \
      .save(path, optimize=True)
    return os.path.getsize(path)


def php_list(pattern, path):
    """Pull simple 'key' => 'value' pairs out of content.php."""
    src = open(os.path.join(ROOT, path), encoding='utf-8').read()
    return re.findall(pattern, src)


def main():
    os.makedirs(OUT, exist_ok=True)
    total = n = 0

    pages = [
        ('default',      'AI-First Product Engineering', 'We build intelligent apps and AI platforms that scale your business.', 'Python · Agentic AI · Cloud Architecture'),
        ('services',     'Services',      'Engineering practices, not a menu of deliverables.', 'Fifteen services across four groups'),
        ('solutions',    'Solutions',     'Products we built, and the industries we built them in.', 'Ithrive Insights · Ithrive AIChat'),
        ('case-studies', 'Case Studies',  'Ten platforms, each closing a gap someone was living with.', 'Healthcare · Mobility · Manufacturing · Retail'),
        ('blog',         'Blog',          'Field notes from the builds, not thought leadership.', ''),
        ('company',      'Company',       'Incubating a culture of innovation and AI-first excellence.', ''),
        ('home',         'AI-First Product Engineering', 'We build intelligent apps and AI platforms that scale your business.', ''),
    ]
    for slug, eyebrow, title, footer in pages:
        total += build(slug, eyebrow, title, footer); n += 1

    groups = {
        'ai-first': 'AI-First Product Development',
        'product-engineering': 'Digital Product Engineering',
        'engagement': 'Engagement Models',
        'core': 'Core Services',
    }
    for slug, name in groups.items():
        total += build(f'service-{slug}', 'Services', name,
                       'Senior engineers, Python end to end'); n += 1

    for slug, name, tag in (
        ('ithrive-insights', 'Ithrive Insights',
         'Turn scattered data into growth-driving AI decisions.'),
        ('ithrive-aichat', 'Ithrive AIChat',
         'Turn every visitor into a customer with real-time intent mapping.'),
    ):
        total += build(f'solution-{slug}', 'Proprietary AI Product', name, tag); n += 1

    # Case studies, read straight from the content layer so these stay in sync.
    # Scope the search to the CASE_STUDIES block: matching from the top of the
    # file lets a SERVICES slug pair up with the first case study's fields.
    src = open(os.path.join(ROOT, 'includes', 'content.php'), encoding='utf-8').read()
    src = src.split('const CASE_STUDIES', 1)[1]
    studies = re.findall(
        r"'slug'\s*=> '([a-z0-9-]+)',.*?'client'\s*=> '([^']+)',.*?'headline'\s*=> '([^']+)',"
        r".*?'industry'\s*=> '([^']+)'", src, re.S)
    for slug, client, headline, industry in studies:
        total += build(f'case-{slug}', 'Case Study',
                       headline.replace("\\'", "'"),
                       f"{client} · {industry}".replace("\\'", "'")); n += 1

    print(f'{n} OG images, {total/1024:.0f} KB total -> assets/img/og/')


if __name__ == '__main__':
    main()
