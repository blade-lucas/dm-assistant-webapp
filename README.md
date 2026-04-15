# DM Assistant WebApp

A comprehensive Laravel-based web application for Dungeon Masters to manage and generate D&D encounters, characters, items, and dungeons with AI-powered assistance.

## Overview

DM Assistant is a full-featured RPG management tool designed to streamline campaign preparation and encounter management. It combines PHP/Laravel backend with modern JavaScript frontend technologies to provide an intuitive, responsive interface for dungeon masters and game enthusiasts.

**Technology Stack:**
- **Backend:** Laravel 12 with Fortify authentication
- **Frontend:** Blade templating (50.5%), PHP (48.5%)
- **Styling:** Tailwind CSS with custom forms
- **JavaScript:** Alpine.js, Axios, Vite
- **Testing:** PestPHP with Laravel plugin

## Key Features

### 🗺️ Dungeon & Map Generation
- Automated dungeon generation with customizable parameters
- AI-powered map generation with external Python service integration
- Integration with MapGen service for advanced map rendering

### ⚔️ Encounter Management
- Roll and build combat encounters with randomized monster selection
- AI-powered encounter generation using OpenAI GPT models
- Save and load encounter configurations
- Monster database and selection tools

### 👤 Character Management
- Complete character sheet system with multiple editing views:
  - Basic information (stats, details)
  - Equipment management and purchasing
  - Spell management with toggle functionality
  - NPC traits and customization
  - Custom notes system
- Character saves and load functionality

### 📚 Game Databases & Tools
- **Monster Database:** Browse and search monsters
- **Item Library:** Comprehensive item catalog with filtering
- **Spell Database:** Complete spell reference
- **Rules Reference:** Game rules and mechanics documentation

### 👥 User System
- User authentication and authorization
- Admin dashboard for management
- User account management
- Personalized dashboard

## Installation

### Prerequisites
- PHP 8.3+
- Node.js
- Composer
- SQLite (default) or MySQL/PostgreSQL

### Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/blade-lucas/dm-assistant-webapp.git
   cd dm-assistant-webapp
   ```

2. **Install dependencies and setup environment**
   ```bash
   composer run setup
   ```
   This command automatically:
   - Installs PHP dependencies via Composer
   - Copies `.env.example` to `.env`
   - Generates application key
   - Runs database migrations
   - Installs Node dependencies
   - Builds frontend assets

3. **Manual setup (if needed)**
   ```bash
   # Copy environment file
   cp .env.example .env

   # Install PHP dependencies
   composer install

   # Generate application key
   php artisan key:generate

   # Run migrations
   php artisan migrate

   # Install JavaScript dependencies
   npm install

   # Build frontend assets
   npm run build
   ```

## Configuration

### Environment Variables

Key configuration options in `.env`:

```env
# Application Settings
APP_NAME=DM Assistant
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database (SQLite by default)
DB_CONNECTION=sqlite

# Authentication
FORTIFY_GUARD=web

# OpenAI Integration (for AI-powered features)
OPENAI_ENDPOINT=https://api.openai.com/v1/chat/completions
OPENAI_MODEL=gpt-4-mini
OPENAI_API_KEY=your_api_key_here

# External Services
MAPGEN_URL=https://your-python-service.up.railway.app
```

See `.env.example` for all available configuration options.

## Development

### Start Development Server
```bash
composer run dev
```

This runs concurrently:
- Laravel development server
- Queue listener
- Log viewer (pail)
- Vite development server for asset compilation

### Run Tests
```bash
composer test
```

Uses PestPHP for testing with Laravel integration.

### Build for Production
```bash
npm run build
```

## Project Structure

```
dm-assistant-webapp/
├── app/
│   ├── Actions/          # Business logic actions
│   ├── Http/
│   │   ├── Controllers/  # Route controllers
│   │   ├── Middleware/   # Custom middleware
│   │   ├── Requests/     # Form request validation
│   │   └── Responses/    # HTTP responses
│   ├── Models/           # Eloquent models
│   ├── Repositories/     # Data access layer
│   ├── Services/         # Business services
│   └── View/             # View composers
├── resources/
│   ├── css/             # Tailwind CSS files
│   ├── js/              # Alpine.js and app scripts
│   ├── views/           # Blade templates
│   └── data/            # Static data files
├── routes/
│   ├── web.php          # Web routes
│   ├── auth.php         # Authentication routes
│   └── console.php      # CLI commands
├── database/
│   ├── migrations/      # Database migrations
│   ├── factories/       # Model factories
│   └── seeders/         # Database seeders
├── config/              # Configuration files
├── tests/               # Test suite
└── public/              # Public assets
```

## Routes Overview

### Public Routes
- `/` - Home page
- `/rules` - Rules and mechanics
- `/databases` - Database browser (monsters, spells)
- `/monsters` - Monster database
- `/items` - Item library
- `/encounters` - Encounter roller
- `/maps` - Map generation
- `/dungeons/generate` - Dungeon generation

### Authenticated Routes
- `/dashboard` - User dashboard
- `/account` - Account settings
- `/characters` - Character management
- `/saves` - Save management
- `/encounters/saved` - Saved encounters

### Admin Routes
- `/admin` - Admin dashboard

## External Integrations

### OpenAI Integration
The app uses OpenAI's GPT models for:
- AI-powered encounter generation
- Creative suggestions and descriptions

Configure your API key in `.env`:
```env
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4-mini
```

## Database

The application uses PostgreSQL by default for ease of development. For production, configure MySQL or PostgreSQL in `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dm_assistant
DB_USERNAME=root
DB_PASSWORD=secret
```

Run migrations: `php artisan migrate`

## Deployment

The project includes `nixpacks.toml` for cloud deployment support (Railway, Heroku, etc.).

### Build for Deployment
1. Ensure all environment variables are set
2. Build frontend: `npm run build`
3. Run migrations: `php artisan migrate --force`
4. Cache configuration: `php artisan config:cache`

## License

This project is licensed under the MIT License.

## Support

For issues, questions, or suggestions, please open an issue on GitHub.
