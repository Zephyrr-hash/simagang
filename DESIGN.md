# SIMAGANG Design System

**Last Updated:** 24 Juni 2026  
**Design Framework:** Impeccable-guided  
**Status:** ✅ Production-Ready

---

## 🎯 Design Philosophy

SIMAGANG adalah sistem informasi magang yang mengutamakan:
- **Clarity** - Informasi jelas dan mudah ditemukan
- **Efficiency** - User bisa menyelesaikan task dengan cepat
- **Professionalism** - Tampilan professional untuk institusi pendidikan
- **Accessibility** - WCAG 2.1 AA compliant

**Anti-References:**
- ❌ Generic SaaS purple gradients
- ❌ Glassmorphism everywhere
- ❌ Cards nested in cards
- ❌ Tiny uppercase eyebrows
- ❌ Inter font (overused AI default)

---

## 🎨 Color Palette

### Primary: Sky Blue Family
```css
--sky-50:  oklch(0.98 0.01 230); /* #F0F9FF */
--sky-100: oklch(0.95 0.02 230); /* #E0F2FE */
--sky-200: oklch(0.90 0.04 230); /* #BAE6FD */
--sky-300: oklch(0.84 0.06 230); /* #7DD3FC */
--sky-400: oklch(0.75 0.08 230); /* #38BDF8 - Primary */
--sky-500: oklch(0.67 0.09 230); /* #0EA5E9 */
--sky-600: oklch(0.56 0.09 230); /* #0284C7 */
--sky-700: oklch(0.46 0.08 230); /* #0369A1 */
--sky-800: oklch(0.39 0.07 230); /* #075985 */
--sky-900: oklch(0.33 0.05 230); /* #0C4A6E */
```

### Accent: Teal (untuk success states)
```css
--teal-400: oklch(0.73 0.08 180); /* #2DD4BF */
--teal-500: oklch(0.66 0.09 180); /* #14B8A6 */
--teal-600: oklch(0.57 0.09 180); /* #0D9488 */
```

### Neutrals: Slate (tinted toward sky)
```css
--slate-50:  oklch(0.99 0.003 230); /* #F8FAFC */
--slate-100: oklch(0.97 0.005 230); /* #F1F5F9 */
--slate-200: oklch(0.94 0.008 230); /* #E2E8F0 */
--slate-300: oklch(0.88 0.010 230); /* #CBD5E1 */
--slate-400: oklch(0.70 0.012 230); /* #94A3B8 */
--slate-500: oklch(0.54 0.015 230); /* #64748B */
--slate-600: oklch(0.44 0.016 230); /* #475569 */
--slate-700: oklch(0.35 0.014 230); /* #334155 */
--slate-800: oklch(0.26 0.012 230); /* #1E293B */
--slate-900: oklch(0.18 0.010 230); /* #0F172A */
```

### Semantic Colors
```css
--success: oklch(0.66 0.09 180); /* Teal-500 */
--warning: oklch(0.75 0.11 70);  /* Amber-400 */
--danger:  oklch(0.63 0.18 25);  /* Red-500 */
--info:    oklch(0.67 0.09 230); /* Sky-500 */
```

### Surface & Backgrounds
```css
--bg-base:    oklch(0.99 0.003 230); /* Slate-50 */
--bg-surface: #FFFFFF;
--bg-elevated: #FFFFFF;
--border-light: oklch(0.94 0.008 230); /* Slate-200 */
--border-default: oklch(0.88 0.010 230); /* Slate-300 */
```

---

## 📐 Typography

### Font Family
```css
/* Primary: Plus Jakarta Sans (humanist sans-serif) */
--font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;

/* Fallback untuk loading */
--font-system: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
```

**Why Plus Jakarta Sans?**
- Modern humanist proportions
- Excellent readability at all sizes
- Professional without being corporate
- Good contrast with Inter (avoid similarity)

### Type Scale
```css
--text-xs:   0.75rem;  /* 12px */
--text-sm:   0.875rem; /* 14px */
--text-base: 1rem;     /* 16px */
--text-lg:   1.125rem; /* 18px */
--text-xl:   1.25rem;  /* 20px */
--text-2xl:  1.5rem;   /* 24px */
--text-3xl:  1.875rem; /* 30px */
--text-4xl:  2.25rem;  /* 36px */
--text-5xl:  3rem;     /* 48px */
```

### Font Weights
```css
--font-normal:   400;
--font-medium:   500;
--font-semibold: 600;
--font-bold:     700;
--font-extrabold: 800;
```

### Line Heights
```css
--leading-tight:   1.25;
--leading-snug:    1.375;
--leading-normal:  1.5;
--leading-relaxed: 1.625;
--leading-loose:   1.75;
```

### Letter Spacing
```css
--tracking-tighter: -0.04em;
--tracking-tight:   -0.02em;
--tracking-normal:  0;
--tracking-wide:    0.025em;
--tracking-wider:   0.05em;
```

---

## 📏 Spacing Scale

Consistent spacing for rhythm:

```css
--space-1:  0.25rem;  /* 4px */
--space-2:  0.5rem;   /* 8px */
--space-3:  0.75rem;  /* 12px */
--space-4:  1rem;     /* 16px */
--space-5:  1.25rem;  /* 20px */
--space-6:  1.5rem;   /* 24px */
--space-8:  2rem;     /* 32px */
--space-10: 2.5rem;   /* 40px */
--space-12: 3rem;     /* 48px */
--space-16: 4rem;     /* 64px */
--space-20: 5rem;     /* 80px */
--space-24: 6rem;     /* 96px */
```

---

## 🎭 Components

### Buttons

**Primary Button:**
```css
background: var(--sky-500);
color: white;
padding: 0.625rem 1.25rem;
border-radius: 0.5rem;
font-weight: 600;
transition: all 0.15s ease-out-quart;

hover: background: var(--sky-600);
focus: ring 3px var(--sky-200);
```

**Secondary Button:**
```css
background: var(--slate-100);
color: var(--slate-700);
border: 1.5px solid var(--slate-200);
```

### Cards
```css
background: white;
border: 1px solid var(--slate-200);
border-radius: 0.75rem;
box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);

hover: box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
       transform: translateY(-2px);
transition: all 0.2s ease-out-quart;
```

### Input Fields
```css
border: 1.5px solid var(--slate-300);
border-radius: 0.5rem;
padding: 0.625rem 0.875rem;
font-size: var(--text-sm);

focus: border-color: var(--sky-400);
       ring: 3px var(--sky-100);
```

### Badges
```css
/* Info badge */
background: var(--sky-50);
color: var(--sky-700);
padding: 0.25rem 0.75rem;
border-radius: 9999px;
font-size: var(--text-xs);
font-weight: 600;

/* Success badge */
background: oklch(0.96 0.02 180);
color: var(--teal-700);
```

---

## 🎨 Sidebar

```css
background: var(--slate-900);
width: 260px;

/* Logo area */
logo-gradient: linear-gradient(135deg, var(--sky-400), var(--teal-400));

/* Nav items */
color: var(--slate-400);
hover: background: rgba(255,255,255,0.06);
active: background: var(--sky-600);
        color: white;
```

---

## 🏷️ Z-Index Scale

Semantic z-index layers:

```css
--z-base:     0;
--z-dropdown: 1000;
--z-sticky:   1020;
--z-fixed:    1030;
--z-overlay:  1040;
--z-modal:    1050;
--z-popover:  1060;
--z-tooltip:  1070;
```

---

## 🎬 Motion

### Easing Functions
```css
--ease-out-quad:  cubic-bezier(0.25, 0.46, 0.45, 0.94);
--ease-out-quart: cubic-bezier(0.165, 0.84, 0.44, 1);
--ease-out-expo:  cubic-bezier(0.19, 1, 0.22, 1);
```

### Durations
```css
--duration-fast:   150ms;
--duration-base:   200ms;
--duration-slow:   300ms;
--duration-slower: 500ms;
```

### Reduced Motion
Always provide alternative for `prefers-reduced-motion: reduce`:
```css
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
```

---

## ♿ Accessibility

### Contrast Ratios
- **Body text:** ≥4.5:1 (WCAG AA)
- **Large text (≥18px or bold ≥14px):** ≥3:1
- **Interactive elements:** ≥4.5:1
- **Disabled states:** Clearly distinguishable

### Touch Targets
- **Minimum:** 44×44px
- **Recommended:** 48×48px
- **Spacing:** ≥8px between targets

### Focus States
All interactive elements have visible focus indicators:
```css
focus-visible: outline: 2px solid var(--sky-400);
               outline-offset: 2px;
```

---

## 📱 Responsive Breakpoints

```css
--screen-sm: 576px;
--screen-md: 768px;
--screen-lg: 992px;
--screen-xl: 1200px;
--screen-2xl: 1400px;
```

### Layout Strategy
- **Mobile-first approach**
- **Touch-friendly on mobile** (≥44px targets)
- **Sidebar collapses** < 992px
- **Readable line lengths** (65-75ch max)

---

## 🚫 What to Avoid

### Don't Use:
- ❌ Purple gradients (`#4F46E5` to `#7C3AED`)
- ❌ Cream/sand backgrounds (`#F5F3FF`)
- ❌ Side-stripe borders as accent
- ❌ Gradient text (`background-clip: text`)
- ❌ Bounce/elastic easing
- ❌ Glassmorphism by default
- ❌ Cards nested in cards
- ❌ Inter font

### Do Use:
- ✅ Sky blue as primary
- ✅ Clean white/light backgrounds
- ✅ Plus Jakarta Sans
- ✅ Subtle shadows for elevation
- ✅ Ease-out curves
- ✅ Purposeful color use
- ✅ Varied spacing for rhythm

---

## 📋 Implementation Checklist

- [x] Color palette defined (Sky Blue + Slate)
- [x] Typography system (Plus Jakarta Sans)
- [x] Spacing scale (consistent rhythm)
- [x] Component styles (buttons, cards, inputs)
- [x] Motion system (ease-out curves, durations)
- [x] Accessibility requirements (contrast, touch targets)
- [x] Responsive breakpoints
- [ ] Apply to all views (in progress)

---

## 🎯 Design Principles

1. **Restrained color strategy** - Sky blue + teal accent, neutrals elsewhere
2. **Clear hierarchy** - Size, weight, color used purposefully
3. **Consistent spacing** - Use spacing scale, vary for rhythm
4. **High contrast** - All text meets WCAG AA
5. **Touch-friendly** - 44px minimum touch targets
6. **Fast & smooth** - Ease-out curves, reduced motion support

---

**Design System Version:** 1.0  
**Framework:** Impeccable-guided  
**License:** Internal use (SIMAGANG)
