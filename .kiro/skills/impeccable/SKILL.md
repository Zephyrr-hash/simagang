---
name: impeccable
description: Use when the user wants to design, redesign, shape, critique, audit, polish, clarify, distill, harden, optimize, adapt, animate, colorize, extract, or otherwise improve a frontend interface. Covers websites, landing pages, dashboards, product UI, app shells, components, forms, settings, onboarding, and empty states. Handles UX review, visual hierarchy, information architecture, cognitive load, accessibility, performance, responsive behavior, theming, anti-patterns, typography, fonts, spacing, layout, alignment, color, motion, micro-interactions, UX copy, error states, edge cases, i18n, and reusable design systems or tokens. Also use for bland designs that need to become bolder or more delightful, loud designs that should become quieter, live browser iteration on UI elements, or ambitious visual effects that should feel technically extraordinary. Not for backend-only or non-UI tasks.
version: 3.8.0
license: Apache 2.0
---

# Impeccable Design Skill

**Production-grade frontend design guidance for AI coding agents.**

Impeccable helps create intentional, craft-quality interfaces that avoid generic "AI-generated" aesthetics.

## ✨ Quick Start

Most common commands untuk project PHP/Laravel seperti SIMAGANG:

```
/impeccable audit                    # Check accessibility, performance, responsive
/impeccable critique landing         # UX review untuk homepage
/impeccable polish dashboard         # Final touch sebelum ship
/impeccable typeset forms            # Fix typography di forms
/impeccable adapt mobile             # Improve responsive design
```

## 🎯 Core Commands

### Build & Document
- `/impeccable init` - Setup project context (PRODUCT.md, DESIGN.md)
- `/impeccable document` - Generate DESIGN.md dari existing code
- `/impeccable shape [feature]` - Plan UX/UI before coding
- `/impeccable craft [feature]` - Full build flow: shape → build → iterate

### Evaluate & Review
- `/impeccable critique [target]` - UX design review dengan scoring
- `/impeccable audit [target]` - Technical quality (a11y, perf, responsive)

### Refine & Polish
- `/impeccable polish [target]` - Final pass sebelum shipping
- `/impeccable distill [target]` - Remove complexity, strip to essence
- `/impeccable harden [target]` - Add error handling, i18n, edge cases
- `/impeccable onboard [target]` - Design first-run flows, empty states

### Enhancement
- `/impeccable bolder [target]` - Amplify bland designs
- `/impeccable quieter [target]` - Tone down aggressive designs
- `/impeccable animate [target]` - Add purposeful motion
- `/impeccable colorize [target]` - Add strategic color
- `/impeccable typeset [target]` - Fix typography & hierarchy
- `/impeccable layout [target]` - Fix spacing & visual rhythm
- `/impeccable delight [target]` - Add memorable touches

### Fix & Optimize
- `/impeccable clarify [target]` - Improve UX copy & labels
- `/impeccable adapt [target]` - Responsive for different devices
- `/impeccable optimize [target]` - Performance improvements

### Iteration
- `/impeccable live` - Visual variant mode: iterate in browser

## 🚫 Anti-Patterns (Banned)

Impeccable explicitly blocks these AI-slop patterns:

### Generic UI Tells
- ❌ Side-stripe borders (`border-left: 4px solid purple`)
- ❌ Gradient text (`background-clip: text`)
- ❌ Glassmorphism as default
- ❌ Hero-metric template (big number, gradient accent)
- ❌ Identical card grids everywhere
- ❌ Tiny uppercase eyebrows above every section
- ❌ Numbered section markers (01/02/03) everywhere

### Typography Mistakes
- ❌ Inter font by default
- ❌ Gray text on colored backgrounds
- ❌ Line length > 75ch
- ❌ Display headings > 6rem
- ❌ Letter-spacing < -0.04em

### Color Mistakes
- ❌ Purple-to-blue gradients everywhere
- ❌ Cream/sand/beige body backgrounds by default
- ❌ Pure black/gray (always tint)
- ❌ Low contrast text (<4.5:1 body, <3:1 large text)

### Layout Mistakes
- ❌ Cards nested in cards
- ❌ No spacing variation
- ❌ Text overflow on mobile

### Motion Mistakes
- ❌ Bounce/elastic easing (feels dated)
- ❌ No reduced-motion support
- ❌ Uniform reveal animations everywhere

## 📋 Usage for SIMAGANG Project

### Recommended First Steps

1. **Setup project context:**
   ```
   /impeccable init
   ```
   This will create PRODUCT.md (audience, voice, anti-references) and offer DESIGN.md.

2. **Audit existing UI:**
   ```
   /impeccable audit resources/views
   ```
   Check all Blade templates for accessibility, contrast, responsive issues.

3. **Critique key pages:**
   ```
   /impeccable critique resources/views/welcome.blade.php
   /impeccable critique resources/views/mhs/home.blade.php
   /impeccable critique resources/views/mitra/home.blade.php
   ```

4. **Polish before shipping:**
   ```
   /impeccable polish resources/views/lowongan
   /impeccable polish resources/views/auth
   ```

### Role-Specific Reviews

**Mahasiswa (Student) Interface:**
```
/impeccable critique resources/views/mhs
/impeccable adapt resources/views/mhs  # Mobile-first mahasiswa
/impeccable clarify resources/views/mhs/logbook
```

**Mitra (Partner) Interface:**
```
/impeccable audit resources/views/mitra
/impeccable typeset resources/views/mitra/lowongan
```

**Forms & Validation:**
```
/impeccable harden resources/views/profile
/impeccable clarify resources/views/errors
```

## 🎨 Design Principles

### Color Strategy
1. **Restrained**: tinted neutrals + one accent ≤10% (Product default)
2. **Committed**: one saturated color 30–60% of surface (Brand default)
3. **Full palette**: 3–4 named roles (Brand campaigns)
4. **Drenched**: surface IS the color (Brand heroes)

### Typography Hierarchy
- Body: 65–75ch line length max
- Display headings: ≤6rem max
- Letter-spacing: ≥-0.04em min
- Use `text-wrap: balance` on h1–h3
- Use `text-wrap: pretty` on prose

### Layout Best Practices
- Vary spacing for rhythm
- Flexbox for 1D, Grid for 2D
- Responsive grids: `repeat(auto-fit, minmax(280px, 1fr))`
- Semantic z-index scale (not arbitrary 999)

### Motion Guidelines
- Ease out with exponential curves (ease-out-quart/quint/expo)
- No bounce, no elastic
- Always provide reduced-motion alternative
- Don't animate layout properties unless needed

### Accessibility Requirements
- Body text: ≥4.5:1 contrast
- Large text (≥18px or bold ≥14px): ≥3:1 contrast
- Placeholder text: 4.5:1 (not muted gray default)
- Touch targets: ≥44×44px
- Semantic HTML structure

## 🔧 Management Commands

### Pin/Unpin Commands
Create shortcuts untuk sering dipakai:
```
/impeccable pin audit      # Creates /audit shortcut
/impeccable pin critique   # Creates /critique shortcut
/impeccable unpin audit    # Removes /audit shortcut
```

### Hook Management
```
/impeccable hooks status         # Check hook status
/impeccable hooks on             # Enable design detector
/impeccable hooks off            # Disable design detector
/impeccable hooks ignore-rule    # Ignore specific rule
/impeccable hooks ignore-file    # Ignore specific file
/impeccable hooks reset          # Reset hook config
```

## 📚 Context Files

Impeccable reads project context from:

- **PRODUCT.md** - Audience, brand lane, voice, anti-references
- **DESIGN.md** - Colors, typography, components, spacing scale
- **Existing code** - CSS tokens, themes, components

These provide context so AI doesn't start from zero.

## 🎯 For Laravel/Bootstrap Projects

Impeccable works great with Laravel + Bootstrap 4 projects like SIMAGANG:

1. **Respects existing Bootstrap conventions**
2. **Enhances rather than replaces**
3. **Focuses on**:
   - Custom color beyond Bootstrap defaults
   - Typography hierarchy improvements
   - Spacing consistency
   - Custom components
   - Accessibility fixes
   - Responsive improvements

## 💡 Examples

### Example 1: Audit All Views
```
/impeccable audit resources/views
```
Finds: contrast issues, missing alt text, small touch targets, heading skip, etc.

### Example 2: Polish Login Page
```
/impeccable polish resources/views/auth/login.blade.php
```
Final pass: spacing, hierarchy, copy, responsive, error states.

### Example 3: Make Dashboard Bolder
```
/impeccable bolder resources/views/mhs/home.blade.php
```
Adds: stronger color, better hierarchy, memorable touches.

### Example 4: Fix Form UX Copy
```
/impeccable clarify resources/views/profile/edit.blade.php
```
Improves: labels, placeholders, error messages, help text.

### Example 5: Responsive Mobile
```
/impeccable adapt resources/views/lowongan/index.blade.php
```
Improves: mobile layout, touch targets, readability.

## 🚀 Getting Started with SIMAGANG

1. **Run init** to create context files
2. **Audit existing views** to find issues
3. **Critique key user flows** (apply, logbook, bimbingan)
4. **Polish before production** deploy

Impeccable akan membantu membuat SIMAGANG terlihat professional, accessible, dan production-ready!

---

**Note:** This is a simplified skill file for Kiro. Full Impeccable includes 23 reference files, detector rules, CLI tools, and browser integration. Visit [impeccable.style](https://impeccable.style/) for complete docs.

**License:** Apache 2.0 | **Version:** 3.8.0 | **Author:** Paul Bakaus
