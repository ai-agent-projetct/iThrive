#!/usr/bin/env python3
"""
Generates the site's section artwork as SVG.

Every illustration is drawn from the same primitives — nodes, planes, orbits,
pipelines, bars — so eighteen different pictures still read as one system.
Each is seeded by its own name, so the composition is distinctive but stable:
re-running this produces byte-identical files.

    python .tools/make-artwork.py

Output: assets/img/art/<name>.svg
"""

import math
import os
import random

OUT = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))),
                   'assets', 'img', 'art')

W, H = 560, 420
CYAN, PURPLE, BLUE = '#00F2FE', '#9D4EDD', '#4EA8FF'


def head(extra=''):
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" '
        f'fill="none" role="img" aria-hidden="true">'
        f'<defs>'
        f'<linearGradient id="g" x1="0" y1="0" x2="{W}" y2="{H}" gradientUnits="userSpaceOnUse">'
        f'<stop stop-color="{CYAN}"/><stop offset=".55" stop-color="{BLUE}"/>'
        f'<stop offset="1" stop-color="{PURPLE}"/></linearGradient>'
        f'<linearGradient id="gv" x1="0" y1="0" x2="0" y2="{H}" gradientUnits="userSpaceOnUse">'
        f'<stop stop-color="{CYAN}" stop-opacity=".55"/>'
        f'<stop offset="1" stop-color="{PURPLE}" stop-opacity=".08"/></linearGradient>'
        f'<radialGradient id="glow" cx="50%" cy="45%" r="55%">'
        f'<stop stop-color="{CYAN}" stop-opacity=".20"/>'
        f'<stop offset="1" stop-color="{CYAN}" stop-opacity="0"/></radialGradient>'
        f'{extra}</defs>'
        f'<rect width="{W}" height="{H}" rx="22" fill="#0C1220"/>'
        f'<rect width="{W}" height="{H}" rx="22" fill="url(#glow)"/>'
    )


TAIL = '</svg>'


def grid_bg(step=40, op=.05):
    """The faint field that sits behind every composition."""
    out = [f'<g stroke="#fff" stroke-opacity="{op}" stroke-width="1">']
    for x in range(step, W, step):
        out.append(f'<path d="M{x} 0V{H}"/>')
    for y in range(step, H, step):
        out.append(f'<path d="M0 {y}H{W}"/>')
    out.append('</g>')
    return ''.join(out)


def neural(rng, nodes=15):
    """Connected node graph — the AI practices."""
    pts = []
    for i in range(nodes):
        a = (i / nodes) * math.tau + rng.uniform(-.16, .16)
        r = rng.uniform(88, 168)
        pts.append((W/2 + math.cos(a)*r*1.28, H/2 + math.sin(a)*r*.82))
    s = [grid_bg()]
    s.append('<g stroke="url(#g)" stroke-opacity=".42" stroke-width="1.3">')
    for i, p in enumerate(pts):
        for q in pts[i+1:]:
            if math.dist(p, q) < 132:
                s.append(f'<path d="M{p[0]:.0f} {p[1]:.0f}L{q[0]:.0f} {q[1]:.0f}"/>')
    s.append('</g>')
    s.append(f'<circle cx="{W/2}" cy="{H/2}" r="46" fill="url(#g)" fill-opacity=".14" '
             f'stroke="url(#g)" stroke-opacity=".5"/>')
    for i, p in enumerate(pts):
        r = 5.5 if i % 3 else 8
        s.append(f'<circle cx="{p[0]:.0f}" cy="{p[1]:.0f}" r="{r}" fill="url(#g)"/>')
        if i % 3 == 0:
            s.append(f'<circle cx="{p[0]:.0f}" cy="{p[1]:.0f}" r="{r+7}" '
                     f'stroke="url(#g)" stroke-opacity=".3"/>')
    return ''.join(s)


def layers(rng, n=4):
    """Stacked isometric planes — product engineering."""
    s = [grid_bg()]
    cx, cy, w, h = W/2, 128, 178, 62
    for i in range(n):
        y = cy + i*74
        op = .5 - i*.09
        s.append(
            f'<path d="M{cx} {y-h/2}L{cx+w} {y}L{cx} {y+h/2}L{cx-w} {y}Z" '
            f'fill="url(#g)" fill-opacity="{op*.22:.2f}" stroke="url(#g)" '
            f'stroke-opacity="{op:.2f}" stroke-width="1.4"/>')
        for k in range(3):
            px = cx + rng.uniform(-w*.55, w*.55)
            s.append(f'<circle cx="{px:.0f}" cy="{y + rng.uniform(-9, 9):.0f}" r="3.4" '
                     f'fill="{CYAN}" fill-opacity="{op:.2f}"/>')
    s.append(f'<g stroke="url(#g)" stroke-opacity=".38" stroke-dasharray="4 6">'
             f'<path d="M{cx} {cy}V{cy + (n-1)*74}"/></g>')
    return ''.join(s)


def orbit(rng, rings=3):
    """Concentric orbits with satellites — teams and engagement."""
    s = [grid_bg()]
    cx, cy = W/2, H/2
    for i in range(rings):
        rx, ry = 90 + i*62, 52 + i*34
        s.append(f'<ellipse cx="{cx}" cy="{cy}" rx="{rx}" ry="{ry}" '
                 f'stroke="url(#g)" stroke-opacity="{.5 - i*.11:.2f}" stroke-width="1.3"/>')
        for k in range(i + 2):
            a = rng.uniform(0, math.tau)
            s.append(f'<circle cx="{cx + math.cos(a)*rx:.0f}" cy="{cy + math.sin(a)*ry:.0f}" '
                     f'r="{6 - i}" fill="url(#g)"/>')
    s.append(f'<circle cx="{cx}" cy="{cy}" r="30" fill="url(#g)" fill-opacity=".2" '
             f'stroke="url(#g)" stroke-opacity=".65"/>')
    return ''.join(s)


def devices(rng):
    """Browser plus phone frame — the core web/mobile services."""
    s = [grid_bg()]
    s.append('<g stroke="url(#g)" stroke-opacity=".55" stroke-width="1.4">'
             '<rect x="62" y="92" width="308" height="212" rx="12" '
             'fill="url(#g)" fill-opacity=".05"/>'
             '<path d="M62 128h308"/></g>')
    for i, c in enumerate([CYAN, BLUE, PURPLE]):
        s.append(f'<circle cx="{82 + i*15}" cy="110" r="4" fill="{c}" fill-opacity=".8"/>')
    for i in range(4):
        s.append(f'<rect x="84" y="{150 + i*32}" width="{232 - i*38}" height="10" rx="5" '
                 f'fill="url(#g)" fill-opacity="{.36 - i*.06:.2f}"/>')
    s.append('<g stroke="url(#g)" stroke-opacity=".65" stroke-width="1.4">'
             '<rect x="352" y="150" width="126" height="216" rx="20" fill="#0A0F1B"/></g>')
    s.append('<rect x="396" y="163" width="38" height="5" rx="2.5" fill="#fff" fill-opacity=".2"/>')
    s.append('<rect x="366" y="182" width="98" height="58" rx="10" fill="url(#gv)"/>')
    for i in range(3):
        s.append(f'<rect x="366" y="{252 + i*26}" width="98" height="15" rx="7.5" '
                 f'fill="url(#g)" fill-opacity="{.3 - i*.07:.2f}"/>')
    s.append(f'<rect x="366" y="332" width="98" height="20" rx="10" fill="url(#g)" fill-opacity=".7"/>')
    return ''.join(s)


def pipeline(rng, steps=3):
    """Three linked stages — the delivery process."""
    s = [grid_bg()]
    y = H/2
    for i in range(steps):
        x = 96 + i * 184
        s.append(f'<circle cx="{x}" cy="{y}" r="46" fill="url(#g)" fill-opacity=".12" '
                 f'stroke="url(#g)" stroke-opacity=".6" stroke-width="1.5"/>')
        s.append(f'<circle cx="{x}" cy="{y}" r="15" fill="url(#g)" fill-opacity=".85"/>')
        s.append(f'<text x="{x}" y="{y - 70}" fill="{CYAN}" fill-opacity=".75" '
                 f'font-family="monospace" font-size="17" text-anchor="middle">0{i+1}</text>')
        if i < steps - 1:
            s.append(f'<path d="M{x+52} {y}H{x+130}" stroke="url(#g)" stroke-opacity=".45" '
                     f'stroke-width="1.4" stroke-dasharray="5 6"/>')
            s.append(f'<path d="M{x+124} {y-5}l7 5-7 5" stroke="{CYAN}" stroke-opacity=".8" '
                     f'stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>')
    return ''.join(s)


def bars(rng, n=9):
    """Chart with a trend line — analytics and insights."""
    s = [grid_bg()]
    base, bw = 344, 34
    pts = []
    for i in range(n):
        h = rng.uniform(52, 210)
        x = 62 + i * (bw + 14)
        s.append(f'<rect x="{x}" y="{base-h:.0f}" width="{bw}" height="{h:.0f}" rx="6" '
                 f'fill="url(#gv)" stroke="url(#g)" stroke-opacity=".3"/>')
        pts.append((x + bw/2, base - h - 16))
    s.append('<path d="M' + ' L'.join(f'{p[0]:.0f} {p[1]:.0f}' for p in pts) +
             f'" stroke="url(#g)" stroke-opacity=".85" stroke-width="2.2" '
             f'stroke-linecap="round" stroke-linejoin="round"/>')
    for p in pts:
        s.append(f'<circle cx="{p[0]:.0f}" cy="{p[1]:.0f}" r="4.2" fill="{CYAN}"/>')
    s.append(f'<path d="M50 {base}H510" stroke="#fff" stroke-opacity=".16"/>')
    return ''.join(s)


def chat(rng):
    """Conversation bubbles with an intent meter — AIChat."""
    s = [grid_bg()]
    rows = [(70, 250, 0), (168, 200, 1), (70, 300, 0), (206, 162, 1)]
    y = 96
    for x, w, mine in rows:
        h = 56
        r = '18 18 18 5' if mine else '18 18 5 18'
        op = .7 if mine else .16
        s.append(f'<rect x="{x}" y="{y}" width="{w}" height="{h}" rx="18" '
                 f'fill="url(#g)" fill-opacity="{op}" stroke="url(#g)" stroke-opacity=".4"/>')
        for i in range(2):
            s.append(f'<rect x="{x+18}" y="{y+16+i*15}" width="{w-(46 if i else 36)}" height="7" '
                     f'rx="3.5" fill="#fff" fill-opacity="{.5 if mine else .22}"/>')
        y += h + 18
    return ''.join(s)


def globe(rng, lines=7):
    """Meridian sphere — reach and infrastructure."""
    s = [grid_bg()]
    cx, cy, r = W/2, H/2, 138
    s.append(f'<circle cx="{cx}" cy="{cy}" r="{r}" fill="url(#g)" fill-opacity=".06" '
             f'stroke="url(#g)" stroke-opacity=".55"/>')
    for i in range(1, lines):
        rx = r * abs(math.cos(math.pi * i / lines))
        s.append(f'<ellipse cx="{cx}" cy="{cy}" rx="{rx:.0f}" ry="{r}" '
                 f'stroke="url(#g)" stroke-opacity=".28"/>')
        yy = cy - r + (2*r) * i / lines
        hw = math.sqrt(max(r*r - (yy-cy)**2, 0))
        s.append(f'<path d="M{cx-hw:.0f} {yy:.0f}H{cx+hw:.0f}" '
                 f'stroke="url(#g)" stroke-opacity=".28"/>')
    for _ in range(7):
        a, rr = rng.uniform(0, math.tau), rng.uniform(.25, .92) * r
        px, py = cx + math.cos(a)*rr, cy + math.sin(a)*rr*.86
        s.append(f'<circle cx="{px:.0f}" cy="{py:.0f}" r="5" fill="{CYAN}"/>')
        s.append(f'<circle cx="{px:.0f}" cy="{py:.0f}" r="11" stroke="{CYAN}" stroke-opacity=".4"/>')
    return ''.join(s)


def shield(rng):
    """Shield over a code block — cloud, security, modernisation."""
    s = [grid_bg()]
    cx = W/2
    s.append(f'<path d="M{cx} 78L{cx+108} 122v96c0 68-46 122-108 148-62-26-108-80-108-148v-96Z" '
             f'fill="url(#g)" fill-opacity=".09" stroke="url(#g)" stroke-opacity=".6" stroke-width="1.6"/>')
    s.append(f'<path d="M{cx-40} 214l30 30 58-64" stroke="url(#g)" stroke-width="4" '
             f'stroke-linecap="round" stroke-linejoin="round"/>')
    for i in range(3):
        w = 120 - i*26
        s.append(f'<rect x="{cx-w/2:.0f}" y="{286+i*22}" width="{w}" height="9" rx="4.5" '
                 f'fill="url(#g)" fill-opacity="{.32-i*.08:.2f}"/>')
    return ''.join(s)


RECIPES = {
    # service groups
    'ai-first':            neural,
    'product-engineering': layers,
    'engagement':          orbit,
    'core':                devices,
    # solutions
    'insights':            bars,
    'aichat':              chat,
    # company + site sections
    'process':             pipeline,
    'about':               globe,
    'careers':             orbit,
    'blog':                layers,
    'contact':             chat,
    'notfound':            neural,
    'why':                 shield,
    'cloud':               shield,
    'mobile':              devices,
    'web':                 globe,
    'data':                bars,
    'proof':               pipeline,
}


def main():
    os.makedirs(OUT, exist_ok=True)
    total = 0
    for name, fn in RECIPES.items():
        rng = random.Random(name)          # seeded by name → stable output
        svg = head() + fn(rng) + TAIL
        path = os.path.join(OUT, f'{name}.svg')
        with open(path, 'w', encoding='utf-8') as fh:
            fh.write(svg)
        total += len(svg)
        print(f'{name:22} {len(svg):>6} bytes')
    print(f'\n{len(RECIPES)} files, {total/1024:.1f} KB total')


if __name__ == '__main__':
    main()
