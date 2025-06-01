# MoodFood Pro - Railway Deployment Guide

## 🚀 Quick Deploy to Railway

### Prerequisites
- Railway account (https://railway.app)
- GitHub repository with this code

### One-Click Deploy
1. **Fork or clone this repository to your GitHub account**

2. **Deploy to Railway:**
   - Visit [Railway](https://railway.app)
   - Click "Deploy from GitHub repo"
   - Select this repository
   - Railway will automatically detect it's a Laravel project

3. **Add MySQL Database:**
   - In your Railway project dashboard
   - Click "+ New Service"
   - Select "MySQL"
   - Railway will automatically inject database environment variables

4. **Set Environment Variables:**
   Railway auto-injects most variables, but you may want to set:
   ```
   APP_NAME=MoodFood Pro
   APP_ENV=production
   APP_DEBUG=false
   OPENAI_API_KEY=your_openai_api_key_here (optional)
   ```

### ✅ Deployment Checklist

**Pre-deployment:**
- [ ] Repository is pushed to GitHub
- [ ] `.env` file contains production settings
- [ ] Database migrations are up to date
- [ ] Frontend assets build successfully (`npm run build`)

**During deployment:**
- [ ] Railway detects the project as PHP/Laravel
- [ ] MySQL service is added and connected
- [ ] Build completes without errors
- [ ] Database migrations run successfully
- [ ] Health check endpoint responds (`/health`)

**Post-deployment verification:**
- [ ] App loads at Railway URL
- [ ] Database connection works (check `/health`)
- [ ] Homepage displays correctly
- [ ] Mood selection functionality works
- [ ] Food recommendations appear
- [ ] Meal planner is accessible

### Manual Setup Steps

1. **Clone Repository:**
   ```bash
   git clone <your-repo-url>
   cd MoodFood
   ```

2. **Railway CLI Setup:**
   ```bash
   npm install -g @railway/cli
   railway login
   railway init
   ```

3. **Deploy:**
   ```bash
   railway up
   ```

### Environment Variables

Railway automatically provides these when you add a MySQL service:
- `DATABASE_URL`
- `MYSQLHOST`
- `MYSQLPORT` 
- `MYSQLDATABASE`
- `MYSQLUSER`
- `MYSQLPASSWORD`
- `RAILWAY_STATIC_URL`

### Key Features

✅ **Auto Database Detection**: Automatically uses MySQL when available, falls back to SQLite
✅ **Asset Building**: Frontend assets are built during deployment
✅ **Smart Database Seeding**: Only seeds database if empty (prevents duplicate data)
✅ **Production Optimized**: Caching and optimization enabled
✅ **Session Management**: Database-based sessions for scaling
✅ **Health Monitoring**: Built-in health check endpoint
✅ **HTTPS Ready**: Automatic HTTPS configuration for production

### Troubleshooting

**Database Connection Issues:**
- Ensure MySQL service is added to your Railway project
- Check that environment variables are properly injected
- Visit `/health` endpoint to check database status

**Build Failures:**
- Check Railway build logs
- Ensure all dependencies are listed in composer.json and package.json
- Verify PHP version compatibility (requires PHP 8.2+)

**Storage Issues:**
- The app automatically creates storage links during deployment
- File uploads are handled via Laravel's storage system

**Session Problems:**
- Sessions are stored in database for better scalability
- Clear browser cookies if experiencing session issues

### Local Development

1. **Install Dependencies:**
   ```bash
   composer install
   npm install
   ```

2. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Build Assets:**
   ```bash
   npm run dev
   ```

5. **Start Server:**
   ```bash
   php artisan serve
   ```

### Production URLs

After deployment, your app will be available at:
- `https://your-app-name.up.railway.app`
- Health check: `https://your-app-name.up.railway.app/health`

### Monitoring

- **Health Check**: Visit `/health` to verify app status
- **Railway Logs**: Check Railway dashboard for deployment and runtime logs
- **Database Status**: Health endpoint includes database connectivity status

### Support

For deployment issues:
1. Check Railway logs in the dashboard
2. Verify environment variables are set correctly
3. Ensure database service is properly connected
4. Test health endpoint for diagnostic information

## 🎯 Features

- **Mood-based Food Recommendations**
- **Meal Planning System** 
- **Dietary Preference Tracking**
- **Recipe Management**
- **Nutrition Analytics**
- **Session-based User Management**
- **Mobile-Responsive Design**
- **Production-Ready Architecture**
