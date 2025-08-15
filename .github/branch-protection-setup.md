# Branch Protection Setup

To ensure PRs to `dev` cannot be merged until all CI checks pass, you need to configure branch protection rules in GitHub.

## Setup Instructions

1. **Go to your repository on GitHub**
2. **Navigate to Settings → Branches**
3. **Click "Add rule" for the `dev` branch**
4. **Configure the following settings:**

### Required Settings:
✅ **Require a pull request before merging**
   - ✅ Require approvals: 1 (optional, adjust as needed)
   - ✅ Dismiss stale PR approvals when new commits are pushed
   - ✅ Require review from code owners (if you have CODEOWNERS file)

✅ **Require status checks to pass before merging**
   - ✅ Require branches to be up to date before merging
   - **Required status checks:** (Add these as they appear after first CI run)
     - `tests (8.3, prefer-stable)`
     - `tests (8.4, prefer-stable)` 
     - `Security Audit`

✅ **Require conversation resolution before merging**

✅ **Restrict pushes that create merge commits**

### Optional Settings (Recommended):
- ✅ **Require linear history** (forces rebase/squash merging)
- ✅ **Do not allow bypassing the above settings** (applies to admins too)

## Alternative: GitHub CLI Setup

You can also set this up via GitHub CLI:

```bash
# Install GitHub CLI if you haven't already
# brew install gh (macOS) or visit https://cli.github.com/

# Login to GitHub
gh auth login

# Set up branch protection for dev branch
gh api repos/:owner/:repo/branches/dev/protection \
  --method PUT \
  --field required_status_checks='{"strict":true,"contexts":["tests (8.3, prefer-stable)","tests (8.4, prefer-stable)","Security Audit"]}' \
  --field enforce_admins=true \
  --field required_pull_request_reviews='{"required_approving_review_count":1,"dismiss_stale_reviews":true}' \
  --field restrictions=null
```

## What This Ensures:

1. **No direct pushes to `dev`** - All changes must go through PRs
2. **All CI checks must pass** - Tests, linting, PHPStan, security audit
3. **Branch must be up-to-date** - Prevents merge conflicts
4. **Code review required** - At least 1 approval needed
5. **Conversations resolved** - All PR comments must be addressed

## CI Status Checks:

The following checks must pass before merge:
- ✅ **PHP 8.3 Tests** - Full test suite on PHP 8.3
- ✅ **PHP 8.4 Tests** - Full test suite on PHP 8.4  
- ✅ **Security Audit** - Composer & NPM security checks

Each test includes:
- Application setup & migrations
- IDE Helper generation
- Code style validation (Pint)
- Static analysis (PHPStan)
- Test execution (Pest)

## Workflow Summary:

```
feature-branch → PR to dev → CI checks → Review → Merge to dev
dev → PR to main → CI checks → Review → Merge to main
```