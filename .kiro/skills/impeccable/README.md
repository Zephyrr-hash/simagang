# Impeccable Design Skill - Installed for SIMAGANG

✅ **Successfully installed** Impeccable design skill untuk project SIMAGANG!

## 🎯 What is Impeccable?

Impeccable adalah **design skill framework** untuk AI coding agents yang membantu membuat UI/UX production-grade dan menghindari tampilan "AI-generated" yang generik.

Created by: **Paul Bakaus**  
GitHub: https://github.com/pbakaus/impeccable  
Website: https://impeccable.style/

## ✨ Key Features

1. **23 Commands** - Design vocabulary untuk AI (audit, critique, polish, animate, dll)
2. **44 Detector Rules** - Auto-detect anti-patterns
3. **Context-Aware** - Membaca PRODUCT.md & DESIGN.md
4. **Production-Ready** - Fokus ke code siap production, bukan prototype

## 🚀 Quick Start

### Most Useful Commands untuk SIMAGANG:

```bash
# Setup (Run once)
/impeccable init

# Daily use
/impeccable audit                      # Check all quality issues
/impeccable critique mhs/home          # UX review mahasiswa dashboard
/impeccable polish auth/login          # Final touch login page
/impeccable adapt lowongan/index       # Improve responsive design
/impeccable clarify profile/edit       # Fix form labels & errors
```

## 📋 All Commands

### 🏗️ Build & Setup
- `/impeccable init` - Setup project context (one-time)
- `/impeccable document` - Generate design docs dari existing code
- `/impeccable shape [feature]` - Plan UX sebelum coding
- `/impeccable craft [feature]` - Full build flow

### 🔍 Evaluate & Review
- `/impeccable audit [target]` - Technical quality check
- `/impeccable critique [target]` - UX design review

### ✨ Refine & Polish
- `/impeccable polish [target]` - Final pass before shipping
- `/impeccable distill [target]` - Remove complexity
- `/impeccable harden [target]` - Error handling & edge cases
- `/impeccable onboard [target]` - First-run flows

### 🎨 Enhancement
- `/impeccable bolder [target]` - Amplify bland designs
- `/impeccable quieter [target]` - Tone down loud designs
- `/impeccable animate [target]` - Add motion
- `/impeccable colorize [target]` - Add strategic color
- `/impeccable typeset [target]` - Fix typography
- `/impeccable layout [target]` - Fix spacing & rhythm
- `/impeccable delight [target]` - Add memorable touches
- `/impeccable overdrive [target]` - Push technical limits

### 🔧 Fix & Optimize
- `/impeccable clarify [target]` - Improve UX copy
- `/impeccable adapt [target]` - Responsive improvements
- `/impeccable optimize [target]` - Performance fixes

### 🎭 Iteration
- `/impeccable live` - Visual variant mode (browser)

## 🎯 SIMAGANG-Specific Usage

### Workflow Recommendation:

#### 1. Initial Setup (One-time)
```bash
/impeccable init
# Answer questions about SIMAGANG:
# - Audience: Mahasiswa, Mitra, Dosen, Supervisor, Departemen
# - Type: Product (app UI untuk internship management)
# - Voice: Professional, helpful, Indonesian
```

#### 2. Audit Existing Views
```bash
# Check semua views
/impeccable audit resources/views

# Specific role views
/impeccable audit resources/views/mhs
/impeccable audit resources/views/mitra
/impeccable audit resources/views/auth
```

#### 3. Critique Key Flows
```bash
# Homepage & listing
/impeccable critique resources/views/welcome.blade.php
/impeccable critique resources/views/lowongan/index.blade.php

# User flows
/impeccable critique resources/views/mhs/home.blade.php
/impeccable critique resources/views/mitra/home.blade.php
/impeccable critique resources/views/project/show.blade.php
```

#### 4. Polish Before Production
```bash
# Forms
/impeccable polish resources/views/profile/edit.blade.php
/impeccable polish resources/views/lowongan/create.blade.php

# Authentication
/impeccable polish resources/views/auth/login.blade.php
/impeccable polish resources/views/auth/register.blade.php

# Critical pages
/impeccable polish resources/views/mhs/apply.blade.php
/impeccable polish resources/views/project/logbook
```

### Role-Specific Reviews:

#### Mahasiswa Interface
```bash
/impeccable audit resources/views/mhs
/impeccable adapt resources/views/mhs          # Mobile-first
/impeccable clarify resources/views/mhs/logbook
/impeccable typeset resources/views/mhs/home
```

#### Mitra Interface
```bash
/impeccable critique resources/views/mitra
/impeccable polish resources/views/mitra/lowongan
/impeccable harden resources/views/mitra/pendaftar
```

#### Dosen Interface
```bash
/impeccable audit resources/views/dosen
/impeccable clarify resources/views/dosen/bimbingan
```

#### Supervisor Interface
```bash
/impeccable audit resources/views/spv
/impeccable polish resources/views/spv/penilaian
```

#### Departemen Interface
```bash
/impeccable critique resources/views/depart
/impeccable polish resources/views/depart/user
```

## 🚫 What Impeccable Blocks

Anti-patterns yang akan di-detect dan di-block:

### Generic AI Tells
- ❌ Side-stripe colored borders
- ❌ Gradient text
- ❌ Purple-blue gradients
- ❌ Cards nested in cards
- ❌ Tiny uppercase eyebrows everywhere
- ❌ Numbered markers (01/02/03) as default

### Typography Issues
- ❌ Inter font by default
- ❌ Gray text on colored backgrounds
- ❌ Lines > 75ch
- ❌ Display headings > 6rem
- ❌ Too-tight letter-spacing

### Color Issues
- ❌ Cream/sand/beige backgrounds by default
- ❌ Pure black/gray (no tint)
- ❌ Low contrast (<4.5:1)

### Layout Issues
- ❌ No spacing variation
- ❌ Text overflow
- ❌ Touch targets <44px

### Motion Issues
- ❌ Bounce/elastic easing
- ❌ No reduced-motion support

## 📊 What Gets Checked

### Accessibility
- Contrast ratios (4.5:1 body, 3:1 large text)
- Touch target sizes (44×44px min)
- Semantic HTML
- Alt text on images
- Form labels
- Heading hierarchy
- ARIA attributes

### Performance
- Large images
- Unused CSS
- JavaScript bundle size
- Render-blocking resources

### Responsive
- Mobile breakpoints
- Touch-friendly controls
- Readable text sizes
- Horizontal scroll prevention

### UX
- Clear hierarchy
- Consistent spacing
- Meaningful color use
- Helpful error messages
- Loading states
- Empty states

## 💡 Pro Tips

### 1. Pin Frequently Used Commands
```bash
/impeccable pin audit      # Creates /audit shortcut
/impeccable pin polish     # Creates /polish shortcut
/impeccable pin critique   # Creates /critique shortcut
```

### 2. Target Specific Files
```bash
# Instead of whole folder
/impeccable audit resources/views/mhs/home.blade.php

# Multiple files
/impeccable polish login.blade.php register.blade.php
```

### 3. Use Hooks (Auto-detect on save)
```bash
/impeccable hooks on       # Enable auto-detection
/impeccable hooks status   # Check status
```

### 4. Progressive Enhancement
```bash
# Start minimal
/impeccable audit          # Find issues
/impeccable polish         # Fix critical
/impeccable bolder         # Add personality
/impeccable delight        # Add memorable touches
```

## 🎨 Design Principles

### Color Strategy (Pick One)
1. **Restrained**: Neutrals + 1 accent ≤10% (product default)
2. **Committed**: 1 color 30–60% surface (brand default)
3. **Full palette**: 3–4 colors deliberate use
4. **Drenched**: Surface IS the color

### Typography Rules
- Line length: 65–75ch max
- Display headings: ≤6rem
- Letter-spacing: ≥-0.04em
- Use `text-wrap: balance` on headings
- Use `text-wrap: pretty` on prose

### Layout Best Practices
- Vary spacing (not uniform)
- Flexbox 1D, Grid 2D
- Semantic z-index scale
- No arbitrary values (999, 9999)

### Motion Guidelines
- Ease-out curves (quart/quint/expo)
- No bounce/elastic
- Reduced-motion support required
- Don't animate layout props

## 🔧 Integration with Laravel/Bootstrap

Impeccable works dengan Laravel + Bootstrap 4:

✅ **Respects Bootstrap conventions**
✅ **Enhances rather than replaces**
✅ **Adds custom touches** beyond Bootstrap defaults

Focus areas:
- Custom color palette
- Typography enhancements
- Spacing refinements
- Custom components
- Accessibility improvements
- Responsive enhancements

## 📚 Context Files

Impeccable reads these files (created by `/impeccable init`):

### PRODUCT.md
Defines:
- Target audience (Mahasiswa, Mitra, dll)
- Product type (app UI vs marketing)
- Voice & tone (professional, helpful, Indonesian)
- Anti-references (what NOT to look like)

### DESIGN.md
Defines:
- Color palette (primary, accent, neutrals)
- Typography (fonts, sizes, weights)
- Component library
- Spacing scale
- Iconography

## 🎯 Expected Results

After using Impeccable on SIMAGANG:

✅ **Better accessibility** - WCAG 2.1 AA compliance
✅ **Clearer hierarchy** - Users find what they need faster
✅ **Consistent spacing** - Professional polish
✅ **Better mobile UX** - Touch-friendly, readable
✅ **Helpful copy** - Clear labels, errors, help text
✅ **Production-ready** - No generic AI tells
✅ **Performance** - Fast, optimized assets

## 📖 Documentation

Full Impeccable documentation:
- Website: https://impeccable.style/
- GitHub: https://github.com/pbakaus/impeccable
- Examples: https://impeccable.style/#casestudies

## 🆘 Support

If you need help:
1. Read `SKILL.md` for command details
2. Visit impeccable.style for full docs
3. Check GitHub issues
4. Ask in Kiro Discord

## 📝 Notes

- This is a **simplified installation** for Kiro
- Full Impeccable includes 44 detector rules, CLI tools, browser extension
- For full features, install via `npx impeccable install` (requires Node.js)

---

**Installed:** 24 Juni 2026  
**Version:** 3.8.0  
**License:** Apache 2.0  
**Project:** SIMAGANG (Sistem Informasi Magang)
