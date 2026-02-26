# NPM Installation & Setup Guide for Windows

## ✅ Good News!
You already have Node.js v24.13.1 installed! However, PowerShell is blocking npm from running.

## 🔧 Quick Fix - Enable npm in PowerShell

### Option 1: Run as Administrator (Recommended)

1. **Open PowerShell as Administrator**
   - Press `Windows + X`
   - Select "Windows PowerShell (Admin)" or "Terminal (Admin)"

2. **Run this command:**
   ```powershell
   Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
   ```

3. **Type `Y` and press Enter** when prompted

4. **Test npm:**
   ```powershell
   npm --version
   ```

### Option 2: Use CMD Instead (Easier)

If you don't want to change PowerShell settings, just use Command Prompt (CMD):

1. **Open Command Prompt**
   - Press `Windows + R`
   - Type `cmd`
   - Press Enter

2. **Navigate to your project:**
   ```cmd
   cd C:\xampp\htdocs\SE_Project
   ```

3. **Run npm commands:**
   ```cmd
   npm --version
   npm install
   npm run dev
   ```

### Option 3: Bypass for Single Command

In PowerShell, prefix commands with:
```powershell
powershell -ExecutionPolicy Bypass -Command "npm --version"
```

## 📦 Install Project Dependencies

Once npm is working, run these commands in your project directory:

### 1. Install Dependencies
```bash
npm install
```

This installs all packages listed in `package.json`.

### 2. Build CSS (Development Mode)
```bash
npm run dev
```

This starts Vite dev server with hot reload - your CSS changes will appear instantly!

### 3. Build CSS (Production Mode)
```bash
npm run build
```

This creates optimized production assets.

## 🚀 Quick Start Commands

```bash
# Install everything
npm install

# Start development server (auto-reload)
npm run dev

# In another terminal, start Laravel
php artisan serve
```

Then visit: http://localhost:8000

## ⚠️ Common Issues & Solutions

### Issue 1: "npm: command not found"
**Solution:** Add Node.js to PATH
1. Search for "Environment Variables" in Windows
2. Edit "Path" under System Variables
3. Add: `C:\Program Files\nodejs\`
4. Restart terminal

### Issue 2: "EACCES: permission denied"
**Solution:** Run as Administrator or use CMD

### Issue 3: "Cannot find module"
**Solution:** Delete and reinstall
```bash
rmdir /s /q node_modules
del package-lock.json
npm install
```

### Issue 4: Port already in use
**Solution:** Kill the process
```bash
# Find process using port 5173 (Vite default)
netstat -ano | findstr :5173

# Kill it (replace PID with actual number)
taskkill /PID <PID> /F
```

## 📝 What npm Does for CampusEats

When you run `npm run dev`, it:
1. ✅ Compiles `resources/css/app.css` with all your custom styles
2. ✅ Processes Tailwind CSS classes
3. ✅ Bundles JavaScript from `resources/js/app.js`
4. ✅ Watches for file changes and auto-reloads
5. ✅ Outputs compiled files to `public/build/`

## 🎯 Recommended Workflow

### Terminal 1 (npm):
```bash
npm run dev
```
Leave this running - it watches for CSS/JS changes

### Terminal 2 (Laravel):
```bash
php artisan serve
```
Your Laravel development server

### Terminal 3 (Commands):
Use this for other commands like:
```bash
php artisan migrate
php artisan test
composer install
```

## 📦 Package.json Overview

Your project uses these npm packages:
- **Vite** - Fast build tool
- **Laravel Vite Plugin** - Laravel integration
- **Tailwind CSS** - Utility-first CSS framework
- **Axios** - HTTP client

## 🔍 Verify Installation

Run these commands to verify everything works:

```bash
# Check Node.js version
node --version
# Should show: v24.13.1

# Check npm version
npm --version
# Should show: 10.x.x or higher

# Check if packages are installed
npm list --depth=0

# Test build
npm run build
```

## 💡 Pro Tips

1. **Always run `npm install` after pulling code** - Dependencies might have changed

2. **Use `npm run dev` during development** - Hot reload saves time

3. **Use `npm run build` before deploying** - Creates optimized files

4. **Check `package.json` for available scripts:**
   ```bash
   npm run
   ```

5. **Update packages:**
   ```bash
   npm update
   ```

## 🆘 Still Having Issues?

### Try these in order:

1. **Restart your terminal**
2. **Use CMD instead of PowerShell**
3. **Run as Administrator**
4. **Reinstall Node.js** from https://nodejs.org/
5. **Clear npm cache:**
   ```bash
   npm cache clean --force
   ```

## 📚 Useful npm Commands

```bash
# Install a new package
npm install package-name

# Install as dev dependency
npm install --save-dev package-name

# Uninstall a package
npm uninstall package-name

# Update all packages
npm update

# Check for outdated packages
npm outdated

# Run a script from package.json
npm run script-name

# View package info
npm info package-name

# List installed packages
npm list

# Clear cache
npm cache clean --force
```

## ✅ Next Steps

Once npm is working:

1. ✅ Run `npm install` to install dependencies
2. ✅ Run `npm run dev` to start development server
3. ✅ Visit http://localhost:8000 to see CampusEats
4. ✅ Edit `resources/css/app.css` and see changes instantly!

---

**Need more help?** Check the official docs:
- Node.js: https://nodejs.org/
- npm: https://docs.npmjs.com/
- Vite: https://vitejs.dev/
