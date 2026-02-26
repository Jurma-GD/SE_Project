# Quick Style Reference 🎨

## 📍 Main File Location
```
resources/css/app.css
```

## 🎯 Quick Changes

### Change Main Brand Color
```css
/* Line ~15 in app.css */
--color-primary-600: #4f46e5;  /* Change this hex code */
```

### Change Button Style
```css
/* Line ~60 in app.css */
.btn-primary {
    @apply bg-indigo-600 text-white px-4 py-2 rounded-md;
}
```

### Change Card Style
```css
/* Line ~72 in app.css */
.card {
    @apply bg-white rounded-lg shadow-md p-6;
}
```

## 🚀 Apply Changes

```bash
# Start development server (auto-reload)
npm run dev

# Or build for production
npm run build
```

## 🎨 Popular Color Themes

Copy-paste these into your `@theme` section:

### Blue
```css
--color-primary-600: #2563eb;
--color-primary-700: #1d4ed8;
```

### Green
```css
--color-primary-600: #059669;
--color-primary-700: #047857;
```

### Purple
```css
--color-primary-600: #9333ea;
--color-primary-700: #7e22ce;
```

### Orange
```css
--color-primary-600: #ea580c;
--color-primary-700: #c2410c;
```

## 📦 Custom Classes You Can Use

In your Blade templates, use these classes:

```html
<!-- Buttons -->
<button class="btn-primary">Primary Button</button>
<button class="btn-secondary">Secondary Button</button>
<button class="btn-success">Success Button</button>

<!-- Cards -->
<div class="card">Basic Card</div>
<div class="card-hover">Card with Hover</div>

<!-- Badges -->
<span class="badge badge-success">Available</span>
<span class="badge badge-warning">Pending</span>

<!-- Forms -->
<label class="form-label">Email</label>
<input class="form-input" type="email">
<p class="form-error">Error message</p>
```

## ⚡ Pro Tips

1. **Always run `npm run dev`** before making changes
2. **Edit only `resources/css/app.css`** - don't touch view files
3. **Use custom classes** instead of inline Tailwind classes
4. **Test in browser** after each change
5. **Keep a backup** of your original `app.css`

## 🔧 Common Customizations

### Make buttons bigger
```css
.btn-primary {
    @apply bg-indigo-600 text-white px-6 py-3 rounded-md text-lg;
}
```

### Add shadows to cards
```css
.card {
    @apply bg-white rounded-lg shadow-md p-6;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
```

### Change navigation hover color
```css
.nav-link {
    @apply text-gray-700 hover:text-purple-600 px-3 py-2;
}
```

---

**Need more help?** Check `STYLING_GUIDE.md` for detailed instructions!
