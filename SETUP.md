# Repository Setup Guide

## 🚀 Quick Setup

After pushing this code to GitHub, you need to configure branch protection to prevent merging PRs until CI passes.

### 1. **Push to GitHub**
```bash
git add .
git commit -m "feat: Add comprehensive CI pipeline with PHPStan custom rules"
git push origin dev
```

### 2. **Set up Branch Protection**

**Via GitHub Web Interface:**
1. Go to your repo → **Settings** → **Branches**
2. Click **"Add rule"** for the `dev` branch
3. Enable:
   - ✅ **Require a pull request before merging**
   - ✅ **Require status checks to pass before merging**
   - ✅ **Require branches to be up to date before merging**
4. Add these **Required status checks** (after first CI run):
   - `Tests (PHP 8.3)`
   - `Tests (PHP 8.4)`
   - `Security Audit`

**Via GitHub CLI:**
```bash
gh api repos/:owner/:repo/branches/dev/protection \
  --method PUT \
  --field required_status_checks='{"strict":true,"contexts":["Tests (PHP 8.3)","Tests (PHP 8.4)","Security Audit"]}' \
  --field enforce_admins=true \
  --field required_pull_request_reviews='{"required_approving_review_count":1}' \
  --field restrictions=null
```

## 📋 CI Pipeline Overview

### **What Gets Checked:**
- ✅ **Application Setup** - Installs dependencies, builds assets
- ✅ **Database** - Runs migrations successfully  
- ✅ **IDE Helper** - Generates model type definitions
- ✅ **Code Style** - Laravel Pint formatting validation
- ✅ **Static Analysis** - PHPStan with custom Eloquent property rules
- ✅ **Tests** - Full Pest test suite
- ✅ **Security** - Composer & NPM vulnerability audit

### **Matrix Testing:**
- PHP 8.3 & PHP 8.4
- MySQL 8.0 database
- Latest stable dependencies

## 🔄 Development Workflow

```
feature-branch → PR to dev → All CI checks pass → Merge
                            ↑
                  🚫 Cannot merge if any check fails
```

### **Local Testing:**
```bash
# Test everything locally before pushing
composer ci-full

# Or test individual components
composer quality  # IDE Helper + Rector + Pint + PHPStan  
composer test      # Pest tests
```

## 🛠️ Available Commands

```bash
composer lint         # Fix code style
composer lint:test    # Check code style  
composer phpstan      # Static analysis
composer ide-helper   # Update model types
composer rector       # Clean DocBlocks
composer quality      # All quality tools
composer test         # Run tests
composer ci           # Local CI simulation
composer ci-full      # Quality + tests
```

## ✨ Custom Features

### **PHPStan Eloquent Property Validation**
Your pipeline includes custom PHPStan rules that catch undefined model properties:
- When you add `$this->role` to a model
- If `role` isn't in the IDE Helper file  
- PHPStan throws: *"Property $role is not defined in IDE Helper"*
- Run `composer ide-helper` to fix

This ensures your type definitions always match your database schema!

## 🔐 Branch Protection Result

Once configured, PRs to `dev` will show:
- ❌ **Merge blocked** until all checks pass
- ✅ **Ready to merge** when all CI passes
- 🔄 **Checks running** during CI execution

Your code quality is now guaranteed before any merge! 🎉