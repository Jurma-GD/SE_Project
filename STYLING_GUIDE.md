# Styling Guide - Vendor Menu System

## 📁 Where to Edit Styles

### Main CSS File
**Location:** `resources/css/app.css`

This is your main stylesheet where you can customize the entire application's appearance without breaking functionality.

## 🎨 How to Customize Styles

### Option 1: Change Color Theme (Easiest)

Edit the color variables in `resources/css/app.css`:

```css
@theme {
    /* Change these hex values to your preferred colors */
    --color-primary-600: #4f46e5;  /* Main brand color */
    --color-primary-700: #4338ca;  /* Darker shade for hovers */
    
    /* Example: Change to blue theme */
    --color-primary-600: #2563eb;
    --color-primary-700: #1d4ed8;
    
    /* Example: Change to green theme */
    --color-primary-600: #059669;
    --color-primary-700: #047857;
}
```

### Option 2: Modify Custom Classes

The app uses custom CSS classes that you can modify:

```css
/* Button Styles */
.btn-primary {
    @apply bg-indigo-600 text-white px-4 py-2 rounded-md;
    /* Add your custom styles here */
    font-size: 16px;
    letter-spacing: 0.5px;
}

/* Card Styles */
.card {
    @apply bg-white rounded-lg shadow-md p-6;
    /* Customize cards */
    border: 2px solid #e5e7eb;
}

/* Navigation Links */
.nav-link {
    @apply text-gray-700 hover:text-indigo-600;
    /* Customize navigation */
    text-transform: uppercase;
}
```

### Option 3: Add New Custom Classes

Add your own classes at the bottom of `resources/css/app.css`:

```css
/* Your Custom Styles */
.my-custom-button {
    @apply bg-purple-600 text-white px-6 py-3 rounded-full;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.my-custom-card {
    @apply bg-gradient-to-br from-blue-50 to-indigo-100;
    border-radius: 20px;
}
```

## 🔧 Available Custom Classes

### Buttons
- `.btn-primary` - Primary action button (indigo)
- `.btn-secondary` - Secondary button (gray)
- `.btn-success` - Success button (green)
- `.btn-danger` - Danger button (red)

### Cards
- `.card` - Basic card
- `.card-hover` - Card with hover effect
- `.vendor-card` - Vendor listing card
- `.stat-card` - Dashboard stat card
- `.menu-item-card` - Menu item card

### Navigation
- `.nav-link` - Navigation link
- `.nav-link-active` - Active navigation link

### Forms
- `.form-input` - Form input field
- `.form-label` - Form label
- `.form-error` - Error message

### Badges
- `.badge` - Base badge
- `.badge-success` - Green badge
- `.badge-warning` - Yellow badge
- `.badge-danger` - Red badge
- `.badge-info` - Blue badge

### Status Indicators
- `.order-status-pending` - Pending order style
- `.order-status-ready` - Ready order style
- `.order-status-completed` - Completed order style

## 🚀 How to Apply Changes

### Step 1: Edit the CSS
Open `resources/css/app.css` and make your changes.

### Step 2: Build the Assets
Run one of these commands:

```bash
# For development (with hot reload)
npm run dev

# For production (optimized)
npm run build
```

### Step 3: Refresh Your Browser
Your changes will appear immediately if using `npm run dev`.

## 📝 Example Customizations

### Example 1: Change Primary Color to Purple

```css
@theme {
    --color-primary-600: #9333ea;
    --color-primary-700: #7e22ce;
}
```

### Example 2: Make Buttons Rounded

```css
.btn-primary {
    @apply bg-indigo-600 text-white px-4 py-2 rounded-full;
    /* Changed from rounded-md to rounded-full */
}
```

### Example 3: Add Custom Vendor Card Style

```css
.vendor-card {
    @apply bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden;
    /* Add custom styles */
    border-left: 4px solid #4f46e5;
    transform: translateY(0);
    transition: all 0.3s ease;
}

.vendor-card:hover {
    transform: translateY(-5px);
}
```

### Example 4: Custom Hero Section

```css
.hero-gradient {
    @apply bg-gradient-to-r from-indigo-600 to-purple-600;
    /* Change to your custom gradient */
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

## 🎯 Quick Color Scheme Changes

### Blue Theme
```css
--color-primary-600: #2563eb;
--color-primary-700: #1d4ed8;
```

### Green Theme
```css
--color-primary-600: #059669;
--color-primary-700: #047857;
```

### Red Theme
```css
--color-primary-600: #dc2626;
--color-primary-700: #b91c1c;
```

### Orange Theme
```css
--color-primary-600: #ea580c;
--color-primary-700: #c2410c;
```

### Pink Theme
```css
--color-primary-600: #db2777;
--color-primary-700: #be185d;
```

## 🔍 Finding What to Change

### To change button colors:
Look for `.btn-primary`, `.btn-secondary`, etc.

### To change card styles:
Look for `.card`, `.vendor-card`, `.stat-card`

### To change navigation:
Look for `.nav-link`, `.nav-link-active`

### To change the hero section:
Look for `.hero-gradient`

### To change form inputs:
Look for `.form-input`, `.form-label`

## ⚠️ Important Notes

1. **Don't edit Tailwind classes directly** - They're generated automatically
2. **Use custom classes** - Modify the custom classes in `app.css`
3. **Test after changes** - Always run `npm run dev` to see your changes
4. **Keep backups** - Save a copy of `app.css` before major changes

## 🆘 Troubleshooting

### Changes not showing?
1. Make sure `npm run dev` is running
2. Clear browser cache (Ctrl+Shift+R)
3. Check browser console for errors

### Styles look broken?
1. Check for syntax errors in `app.css`
2. Make sure you didn't remove the `@apply` directives
3. Restart `npm run dev`

### Want to reset?
Keep a backup of the original `app.css` file to restore if needed.

## 📚 Additional Resources

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Tailwind Color Palette](https://tailwindcss.com/docs/customizing-colors)
- [CSS Gradient Generator](https://cssgradient.io/)

---

**Pro Tip:** Start with small changes to the color variables, then move on to customizing individual components once you're comfortable!
