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



# ---------------------------------------------------------------------------
# Swipe-stack cards on the web development page
#
# Six drawings for six promises, from the same primitives as everything above
# so they read as one system. Each states its promise literally rather than
# decoratively: a quote that is sealed, a bench with no junior row behind it,
# keys handed over with the history, a budget with a ceiling, blocks that can
# be rearranged, and a signal that gets an answer.
# ---------------------------------------------------------------------------

def why_price(rng):
    """A quote, sealed - the fixed price."""
    s = [grid_bg()]
    x, y, w, h = W/2 - 150, 96, 300, 250
    s.append(f'<rect x="{x}" y="{y}" width="{w}" height="{h}" rx="16" '
             f'fill="url(#g)" fill-opacity=".07" stroke="url(#g)" stroke-opacity=".55" stroke-width="1.6"/>')
    for i in range(4):
        lw = w - 64 - (i % 2) * 56
        s.append(f'<rect x="{x+32}" y="{y+42+i*30}" width="{lw:.0f}" height="8" rx="4" '
                 f'fill="#fff" fill-opacity="{.16 - i*.02:.2f}"/>')
    s.append(f'<path d="M{x+32} {y+178}H{x+w-32}" stroke="url(#g)" stroke-opacity=".5" stroke-width="1.4"/>')
    s.append(f'<rect x="{x+32}" y="{y+196}" width="96" height="14" rx="7" fill="url(#g)" fill-opacity=".85"/>')
    s.append(f'<circle cx="{x+w-58}" cy="{y+200}" r="30" fill="url(#g)" fill-opacity=".14" '
             f'stroke="url(#g)" stroke-opacity=".7" stroke-width="1.6"/>')
    s.append(f'<path d="M{x+w-72} {y+200}l10 11 20-23" stroke="url(#g)" stroke-width="3.4" '
             f'stroke-linecap="round" stroke-linejoin="round"/>')
    return ''.join(s)


def why_senior(rng):
    """Three figures at the same height - no junior bench behind them."""
    s = [grid_bg()]
    for i, cx in enumerate((W/2 - 132, W/2, W/2 + 132)):
        op = .85 if i == 1 else .58
        s.append(f'<circle cx="{cx}" cy="168" r="34" fill="url(#g)" fill-opacity="{op*.22:.2f}" '
                 f'stroke="url(#g)" stroke-opacity="{op:.2f}" stroke-width="1.8"/>')
        s.append(f'<path d="M{cx-56} 300c0-31 25-56 56-56s56 25 56 56" '
                 f'stroke="url(#g)" stroke-opacity="{op:.2f}" stroke-width="1.8" fill="none"/>')
        s.append(f'<rect x="{cx-30}" y="322" width="60" height="8" rx="4" fill="url(#g)" fill-opacity="{op*.8:.2f}"/>')
    return ''.join(s)


def why_ownership(rng):
    """A key beside a repository with its history - everything handed over."""
    s = [grid_bg()]
    x, y = W/2 - 140, 120
    s.append(f'<rect x="{x}" y="{y}" width="280" height="200" rx="14" '
             f'fill="url(#g)" fill-opacity=".07" stroke="url(#g)" stroke-opacity=".5" stroke-width="1.6"/>')
    s.append(f'<path d="M{x} {y+44}H{x+280}" stroke="url(#g)" stroke-opacity=".4" stroke-width="1.3"/>')
    for i in range(3):
        s.append(f'<circle cx="{x+26+i*20}" cy="{y+22}" r="5" fill="url(#g)" fill-opacity=".55"/>')
    s.append(f'<path d="M{x+56} {y+96}v92M{x+56} {y+130}h72a24 24 0 0 1 24 24v34" '
             f'stroke="url(#g)" stroke-opacity=".62" stroke-width="1.8" fill="none"/>')
    for cx, cy in ((x+56, y+96), (x+56, y+188), (x+152, y+188)):
        s.append(f'<circle cx="{cx}" cy="{cy}" r="9" fill="#0B0F17" stroke="url(#g)" stroke-width="2.2"/>')
    s.append(f'<circle cx="{x+232}" cy="{y+150}" r="24" fill="none" stroke="url(#g)" stroke-width="3"/>')
    s.append(f'<path d="M{x+232} {y+174}v40m0-18h16" stroke="url(#g)" stroke-width="3" stroke-linecap="round"/>')
    return ''.join(s)


def why_speed(rng):
    """A gauge filled to a written ceiling - speed as a contract term."""
    s = [grid_bg()]
    cx, cy, r = W/2, 262, 128
    s.append(f'<path d="M{cx-r} {cy}a{r} {r} 0 0 1 {r*2} 0" stroke="#fff" stroke-opacity=".12" '
             f'stroke-width="14" stroke-linecap="round" fill="none"/>')
    s.append(f'<path d="M{cx-r} {cy}a{r} {r} 0 0 1 {r*1.62:.0f} -{r*.78:.0f}" stroke="url(#g)" '
             f'stroke-width="14" stroke-linecap="round" fill="none"/>')
    for i in range(9):
        a = math.pi + (i / 8) * math.pi
        x1, y1 = cx + math.cos(a)*(r-30), cy + math.sin(a)*(r-30)
        x2, y2 = cx + math.cos(a)*(r-18), cy + math.sin(a)*(r-18)
        s.append(f'<path d="M{x1:.1f} {y1:.1f}L{x2:.1f} {y2:.1f}" stroke="#fff" stroke-opacity=".22" stroke-width="2"/>')
    a = math.pi + .78 * math.pi
    s.append(f'<path d="M{cx} {cy}L{cx + math.cos(a)*(r-42):.1f} {cy + math.sin(a)*(r-42):.1f}" '
             f'stroke="url(#g)" stroke-width="4" stroke-linecap="round"/>')
    s.append(f'<circle cx="{cx}" cy="{cy}" r="9" fill="url(#g)"/>')
    s.append(f'<rect x="{cx-58}" y="{cy+34}" width="116" height="12" rx="6" fill="url(#g)" fill-opacity=".5"/>')
    return ''.join(s)


def why_editable(rng):
    """Blocks with drag handles - a site the client's team can rearrange."""
    s = [grid_bg()]
    x, y = W/2 - 150, 108
    heights = (52, 84, 52)
    for i, h in enumerate(heights):
        yy = y + sum(heights[:i]) + i * 18
        s.append(f'<rect x="{x}" y="{yy}" width="300" height="{h}" rx="12" '
                 f'fill="url(#g)" fill-opacity="{.10 if i == 1 else .06:.2f}" '
                 f'stroke="url(#g)" stroke-opacity="{.66 if i == 1 else .38:.2f}" stroke-width="1.6"/>')
        for d in range(3):
            s.append(f'<rect x="{x+18}" y="{yy + h/2 - 7 + d*6:.0f}" width="14" height="2.4" rx="1.2" '
                     f'fill="url(#g)" fill-opacity=".6"/>')
        s.append(f'<rect x="{x+48}" y="{yy + h/2 - 4:.0f}" width="{150 - i*28}" height="8" rx="4" '
                 f'fill="#fff" fill-opacity=".16"/>')
    s.append(f'<rect x="{x+206}" y="{y+150}" width="118" height="46" rx="10" fill="#0B0F17" '
             f'stroke="url(#g)" stroke-width="2" stroke-dasharray="6 5"/>')
    return ''.join(s)


def why_support(rng):
    """A signal, answered - a named engineer rather than a queue."""
    s = [grid_bg()]
    cx, cy = W/2, 236
    for i, r in enumerate((52, 92, 132)):
        s.append(f'<circle cx="{cx}" cy="{cy}" r="{r}" fill="none" stroke="url(#g)" '
                 f'stroke-opacity="{.5 - i*.14:.2f}" stroke-width="1.6"/>')
    s.append(f'<circle cx="{cx}" cy="{cy}" r="26" fill="url(#g)" fill-opacity=".2" '
             f'stroke="url(#g)" stroke-opacity=".8" stroke-width="2"/>')
    s.append(f'<path d="M{cx-11} {cy-4}a15 15 0 0 1 22 0" stroke="url(#g)" stroke-width="2.6" '
             f'stroke-linecap="round" fill="none"/>')
    s.append(f'<circle cx="{cx}" cy="{cy+8}" r="4.5" fill="url(#g)"/>')
    s.append(f'<rect x="{cx+96}" y="{cy-120}" width="140" height="52" rx="14" fill="#0B0F17" '
             f'stroke="url(#g)" stroke-opacity=".6" stroke-width="1.6"/>')
    s.append(f'<rect x="{cx+114}" y="{cy-104}" width="82" height="7" rx="3.5" fill="#fff" fill-opacity=".22"/>')
    s.append(f'<rect x="{cx+114}" y="{cy-89}" width="54" height="7" rx="3.5" fill="url(#g)" fill-opacity=".6"/>')
    return ''.join(s)



# ---------------------------------------------------------------------------
# Section marks
#
# Small drawings for the recurring section types that had no imagery at all:
# commitments, testimonials, a stats glance, the service catalogue, engagement
# shapes, capabilities, the delivery stack, open roles, solved patterns and the
# contact lines. Same primitives and palette as everything above, so a page that
# now carries four of these still reads as one system.
# ---------------------------------------------------------------------------

def sec_commitments(rng):
    """Four ticked promises against a ruled sheet."""
    s = [grid_bg()]
    x, y = W/2 - 160, 92
    s.append(f'<rect x="{x}" y="{y}" width="320" height="248" rx="16" fill="url(#g)" fill-opacity=".06" '
             f'stroke="url(#g)" stroke-opacity=".5" stroke-width="1.6"/>')
    for i in range(4):
        yy = y + 40 + i * 52
        s.append(f'<circle cx="{x+44}" cy="{yy}" r="15" fill="url(#g)" fill-opacity=".16" '
                 f'stroke="url(#g)" stroke-opacity=".7" stroke-width="1.6"/>')
        s.append(f'<path d="M{x+37} {yy}l6 6 12-13" stroke="url(#g)" stroke-width="2.6" '
                 f'stroke-linecap="round" stroke-linejoin="round"/>')
        s.append(f'<rect x="{x+74}" y="{yy-5}" width="{190 - i*26}" height="9" rx="4.5" '
                 f'fill="#fff" fill-opacity="{.20 - i*.03:.2f}"/>')
    return ''.join(s)


def sec_testimonial(rng):
    """A quote mark over two speech panels."""
    s = [grid_bg()]
    s.append(f'<path d="M{W/2-118} 150c0-32 24-56 56-58v22c-20 3-32 16-32 34h32v58h-56Z" '
             f'fill="url(#g)" fill-opacity=".7"/>')
    s.append(f'<path d="M{W/2+6} 150c0-32 24-56 56-58v22c-20 3-32 16-32 34h32v58h-56Z" '
             f'fill="url(#g)" fill-opacity=".38"/>')
    for i in range(3):
        s.append(f'<rect x="{W/2-140}" y="{262+i*26}" width="{280 - i*62}" height="9" rx="4.5" '
                 f'fill="#fff" fill-opacity="{.18 - i*.04:.2f}"/>')
    return ''.join(s)


def sec_glance(rng):
    """Four counters - the at-a-glance numbers."""
    s = [grid_bg()]
    for i in range(4):
        cx = W/2 - 168 + i * 112
        h = 44 + rng.uniform(0, 46)
        s.append(f'<rect x="{cx-42}" y="{250-h:.0f}" width="84" height="{h+56:.0f}" rx="12" '
                 f'fill="url(#gv)" fill-opacity=".5" stroke="url(#g)" stroke-opacity=".45" stroke-width="1.4"/>')
        s.append(f'<rect x="{cx-26}" y="{262-h:.0f}" width="52" height="13" rx="6.5" fill="url(#g)" fill-opacity=".85"/>')
        s.append(f'<rect x="{cx-30}" y="322" width="60" height="7" rx="3.5" fill="#fff" fill-opacity=".16"/>')
    return ''.join(s)


def sec_catalogue(rng):
    """A grid of service tiles - the full catalogue."""
    s = [grid_bg()]
    for r in range(3):
        for c in range(4):
            x, y = W/2 - 214 + c * 112, 106 + r * 78
            lit = (r * 4 + c) in (1, 6, 9)
            s.append(f'<rect x="{x}" y="{y}" width="96" height="62" rx="11" '
                     f'fill="url(#g)" fill-opacity="{.16 if lit else .05:.2f}" '
                     f'stroke="url(#g)" stroke-opacity="{.7 if lit else .3:.2f}" stroke-width="1.4"/>')
            s.append(f'<rect x="{x+14}" y="{y+38}" width="{58 if lit else 44}" height="7" rx="3.5" '
                     f'fill="#fff" fill-opacity="{.22 if lit else .12:.2f}"/>')
    return ''.join(s)


def sec_engagement(rng):
    """Three columns of different height - the engagement shapes."""
    s = [grid_bg()]
    for i, h in enumerate((116, 178, 146)):
        x = W/2 - 150 + i * 108
        s.append(f'<rect x="{x}" y="{300-h}" width="84" height="{h}" rx="12" '
                 f'fill="url(#gv)" fill-opacity="{.65 if i == 1 else .4:.2f}" '
                 f'stroke="url(#g)" stroke-opacity="{.75 if i == 1 else .4:.2f}" stroke-width="1.5"/>')
        for k in range(3):
            s.append(f'<rect x="{x+16}" y="{318-h+k*20}" width="{52 - k*10}" height="6" rx="3" '
                     f'fill="#fff" fill-opacity=".16"/>')
        s.append(f'<circle cx="{x+42}" cy="{330}" r="7" fill="url(#g)" fill-opacity="{.9 if i == 1 else .45:.2f}"/>')
    return ''.join(s)


def sec_capabilities(rng):
    """A checklist branching off a spine - capabilities spelled out."""
    s = [grid_bg()]
    x = W/2 - 150
    s.append(f'<path d="M{x} 96V330" stroke="url(#g)" stroke-opacity=".55" stroke-width="2"/>')
    for i in range(5):
        y = 118 + i * 48
        s.append(f'<path d="M{x} {y}h44" stroke="url(#g)" stroke-opacity=".45" stroke-width="1.6"/>')
        s.append(f'<circle cx="{x}" cy="{y}" r="7" fill="#0B0F17" stroke="url(#g)" stroke-width="2.2"/>')
        s.append(f'<rect x="{x+56}" y="{y-11}" width="{210 - i*22}" height="22" rx="8" '
                 f'fill="url(#g)" fill-opacity="{.13 - i*.015:.3f}" stroke="url(#g)" stroke-opacity=".3" stroke-width="1"/>')
    return ''.join(s)


def sec_delivery(rng):
    """Stacked platform layers - what we deliver it on."""
    s = [grid_bg()]
    for i in range(4):
        w = 300 - i * 48
        y = 288 - i * 52
        s.append(f'<path d="M{W/2} {y-26}l{w/2} 26-{w/2} 26-{w/2}-26Z" '
                 f'fill="url(#g)" fill-opacity="{.10 + i*.07:.2f}" '
                 f'stroke="url(#g)" stroke-opacity="{.35 + i*.12:.2f}" stroke-width="1.5"/>')
    s.append(f'<circle cx="{W/2}" cy="118" r="9" fill="url(#g)"/>')
    return ''.join(s)


def sec_roles(rng):
    """Open seats at a table - the roles being filled."""
    s = [grid_bg()]
    s.append(f'<ellipse cx="{W/2}" cy="250" rx="158" ry="52" fill="url(#g)" fill-opacity=".07" '
             f'stroke="url(#g)" stroke-opacity=".45" stroke-width="1.6"/>')
    for i, a in enumerate((-2.5, -1.75, -1.0, -0.25)):
        cx = W/2 + math.cos(a) * 176
        cy = 250 + math.sin(a) * 92
        open_seat = i in (1, 3)
        s.append(f'<circle cx="{cx:.0f}" cy="{cy:.0f}" r="26" '
                 f'fill="url(#g)" fill-opacity="{.05 if open_seat else .22:.2f}" '
                 f'stroke="url(#g)" stroke-opacity="{.85 if open_seat else .4:.2f}" stroke-width="1.8" '
                 f'{"stroke-dasharray=\"5 5\"" if open_seat else ""}/>')
        if not open_seat:
            s.append(f'<circle cx="{cx:.0f}" cy="{cy-6:.0f}" r="9" fill="url(#g)" fill-opacity=".6"/>')
    return ''.join(s)


def sec_patterns(rng):
    """Repeating motifs, one solved - patterns we have already met."""
    s = [grid_bg()]
    for r in range(3):
        for c in range(5):
            cx, cy = W/2 - 168 + c * 84, 138 + r * 72
            solved = (r == 1 and c == 2)
            if solved:
                s.append(f'<circle cx="{cx}" cy="{cy}" r="26" fill="url(#g)" fill-opacity=".22" '
                         f'stroke="url(#g)" stroke-opacity=".9" stroke-width="2"/>')
                s.append(f'<path d="M{cx-11} {cy}l8 9 16-18" stroke="url(#g)" stroke-width="3" '
                         f'stroke-linecap="round" stroke-linejoin="round"/>')
            else:
                s.append(f'<circle cx="{cx}" cy="{cy}" r="20" fill="none" stroke="url(#g)" '
                         f'stroke-opacity=".26" stroke-width="1.5"/>')
    return ''.join(s)


def sec_lines(rng):
    """Three channels converging - the direct lines."""
    s = [grid_bg()]
    cx, cy = W/2, 250
    for i, a in enumerate((-2.3, -1.57, -0.84)):
        x = cx + math.cos(a) * 150
        y = cy + math.sin(a) * 130
        s.append(f'<path d="M{x:.0f} {y:.0f}Q{(x+cx)/2:.0f} {(y+cy)/2 - 30:.0f} {cx} {cy}" '
                 f'stroke="url(#g)" stroke-opacity=".45" stroke-width="1.6" fill="none"/>')
        s.append(f'<rect x="{x-34:.0f}" y="{y-24:.0f}" width="68" height="48" rx="12" fill="#0B0F17" '
                 f'stroke="url(#g)" stroke-opacity=".7" stroke-width="1.6"/>')
        s.append(f'<rect x="{x-18:.0f}" y="{y-6:.0f}" width="36" height="7" rx="3.5" fill="url(#g)" fill-opacity=".6"/>')
    s.append(f'<circle cx="{cx}" cy="{cy}" r="30" fill="url(#g)" fill-opacity=".2" '
             f'stroke="url(#g)" stroke-opacity=".85" stroke-width="2"/>')
    s.append(f'<path d="M{cx-13} {cy-5}l13 10 13-10" stroke="url(#g)" stroke-width="2.6" '
             f'stroke-linecap="round" stroke-linejoin="round" fill="none"/>')
    return ''.join(s)


RECIPES = {
    # recurring section marks
    'sec-commitments':  sec_commitments,
    'sec-testimonial':  sec_testimonial,
    'sec-glance':       sec_glance,
    'sec-catalogue':    sec_catalogue,
    'sec-engagement':   sec_engagement,
    'sec-capabilities': sec_capabilities,
    'sec-delivery':     sec_delivery,
    'sec-roles':        sec_roles,
    'sec-patterns':     sec_patterns,
    'sec-lines':        sec_lines,

    # swipe-stack cards, web development page
    'why-price':     why_price,
    'why-senior':    why_senior,
    'why-ownership': why_ownership,
    'why-speed':     why_speed,
    'why-editable':  why_editable,
    'why-support':   why_support,

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
