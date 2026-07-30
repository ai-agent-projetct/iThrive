#!/usr/bin/env python3
"""
Vendors the tech-stack brand logos.

Pulls SVGs from Simple Icons (CC0) and writes them to assets/img/tech/ recoloured
to each brand's official hex, so nothing is fetched from a CDN at runtime.

Two marks are not in Simple Icons — Microsoft removed theirs over trademark
policy, and UPI has none — so those get a generated lettermark instead.

    python .tools/fetch-tech-logos.py
"""

import json
import unicodedata
import os
import re
import urllib.request

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
OUT = os.path.join(ROOT, 'assets', 'img', 'tech')
CDN = 'https://cdn.jsdelivr.net/npm/simple-icons@13/icons/{}.svg'
DATA = 'https://cdn.jsdelivr.net/npm/simple-icons@13/_data/simple-icons.json'

# Slugs we need, deduplicated across categories.
SLUGS = [
    'python', 'langchain', 'pytorch', 'tensorflow', 'scikitlearn', 'openai',
    'postgresql', 'opensearch', 'fastapi', 'django', 'nodedotjs', 'express',
    'laravel', 'php', 'openjdk', 'dotnet', 'celery', 'graphql', 'react',
    'nextdotjs', 'typescript', 'angular', 'vuedotjs', 'threedotjs',
    'tailwindcss', 'vite', 'flutter', 'kotlin', 'swift', 'firebase', 'mysql',
    'mongodb', 'redis', 'apacheairflow', 'dbt', 'pandas', 'amazonwebservices',
    'googlecloud', 'docker', 'kubernetes', 'terraform', 'githubactions',
    'jenkins', 'grafana', 'shopify', 'woocommerce', 'razorpay', 'stripe',
]

# Brand hex is often near-black, which disappears even on a light tile. Lift
# those to something that still reads as the brand.
LIFT = {
    'express':    '2F2F2F',
    'nextdotjs':  '1A1A1A',
    'threedotjs': '2A2A2A',
    'openjdk':    '2B2B2B',
    'angular':    'DD0031',   # Angular's own red, not the near-black wordmark hex
    'django':     '0C4B33',
    'pandas':     '2B0A63',
    'amazonwebservices': 'FF9900',
    'razorpay':   '1F4B99',
    'apachekafka': '3A3A3A',
    'langchain':  '2C6E6E',
}


def fetch(url):
    req = urllib.request.Request(url, headers={'User-Agent': 'ithrive-build'})
    with urllib.request.urlopen(req, timeout=45) as r:
        return r.read()


def lettermark(slug, text, hexcolour):
    """Fallback mark for brands with no permissively licensed icon."""
    svg = (
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">'
        f'<rect width="24" height="24" rx="5" fill="#{hexcolour}"/>'
        f'<text x="12" y="16.4" text-anchor="middle" fill="#fff" '
        f'font-family="Segoe UI,Arial,sans-serif" font-size="{9 if len(text) > 2 else 11}" '
        f'font-weight="700">{text}</text></svg>'
    )
    open(os.path.join(OUT, f'{slug}.svg'), 'w', encoding='utf-8').write(svg)
    return len(svg)


def slugify(title):
    """Simple Icons only carries an explicit `slug` when it differs from the
    title, so most brands have to be slugified the same way upstream does."""
    t = title.lower().replace('+', 'plus').replace('.', 'dot').replace('&', 'and')
    t = unicodedata.normalize('NFKD', t).encode('ascii', 'ignore').decode()
    return re.sub(r'[^a-z0-9]', '', t)


def main():
    os.makedirs(OUT, exist_ok=True)
    hexes = {}
    for i in json.loads(fetch(DATA).decode('utf-8'))['icons']:
        hexes[i.get('slug') or slugify(i['title'])] = i['hex']

    total = ok = 0
    for slug in SLUGS:
        try:
            svg = fetch(CDN.format(slug)).decode('utf-8')
        except Exception as exc:
            print(f'  MISS {slug}: {exc}')
            continue

        colour = LIFT.get(slug) or hexes.get(slug, '888888')
        # Simple Icons ship a single monochrome path; paint it the brand colour.
        svg = re.sub(r'<svg([^>]*)>', r'<svg\1 fill="#' + colour + '">', svg, count=1)
        svg = svg.replace('<title>', '<title>').replace(' role="img"', '')
        open(os.path.join(OUT, f'{slug}.svg'), 'w', encoding='utf-8').write(svg)
        total += len(svg)
        ok += 1

    # No permissively licensed mark exists for these two.
    total += lettermark('azure', 'Az', '0078D4')
    total += lettermark('upi', 'UPI', '097939')
    ok += 2

    print(f'{ok} logos, {total/1024:.0f} KB -> assets/img/tech/')


if __name__ == '__main__':
    main()
