# 🌐 ORBIXUP Branding

> A modern branding and web application project that provides a professional digital identity for businesses.

---

## 📖 Table of Contents

-   [About](#📌-about)
-   [Features](#✨-features)
-   [Tech Stack](#🛠-tech-stack)
-   [Getting Started](#🚀-getting-started)
    -   [Prerequisites](#prerequisites)
    -   [Installation](#installation)
    -   [Running Locally](#running-locally)
-   [Project Structure](#📂-project-structure)
-   [Configuration](#⚙️-configuration)
-   [API Documentation](#📖-api-documentation)
-   [Testing](#🧪-testing)
-   [Contributing](#🤝-contributing)

---

## 📌 About

This project delivers a **complete branding solution** including:

-   🎨 **Visual Identity** (logo, colors, style guide)
-   🖥 **Responsive Website** with SEO best practices
-   💳 **Payment Integration** (CyberSource)
-   🔐 **Security features** (JWT authentication)

The goal is to give businesses a **strong digital presence** with a scalable and maintainable application.

---

## ✨ Features

-   ✅ Branding assets (logo, guidelines, colors)
-   ✅ Payment gateway support
-   ✅ User authentication & client portal
-   ✅ API with rate limiting
-   ✅ Admin dashboard (CMS features)
-   ✅ Multi-language support (i18n)

---

## 🛠 Tech Stack

-   **Frontend:** React + Vite + Tailwind CSS
-   **Backend:** Symfony (API Platform) / Node.js (alternative)
-   **Database:** PostgreSQL
-   **Authentication:** JWT
-   **Payments:** Stripe
-   **Deployment:** Docker, Nginx
-   **Version Control:** Git + GitHub

---

## 🚀 Getting Started

### Prerequisites

-   Node.js >= 18
-   PHP >= 8.2
-   Composer
-   Docker & Docker Compose
-   Git

### Installation

```bash
# Clone the repository
git clone https://github.com/STAGE-ETECH-EQUIPE1/backend.git
cd backend

# Install dependencies (backend)
make init
```

### Running Locally

```bash
# Start Docker containers
make docker-up

# Initialize the project to development
make init
```

# Start frontend dev server

The application should now be running at:
👉 Frontend: http://localhost:5173
👉 Backend API: http://localhost:8000/api

## 📂 Project Structure

```bash
branding-app/
│── backend/ # Symfony API
│ ├── src/ # PHP source code
│ └── config/ # API & DB configs
│── frontend/ # React + Vite
│ ├── src/ # Components & pages
│ └── public/ # Static assets
│── docs/ # Documentation & brand guidelines
│── docker-compose.yml
│── README.md
```

## ⚙️ Configuration

Environment variables are stored in .env (backend)  
You can create an environment variable called `.env.local` to store it locally

Example:

```env
DATABASE_URL=postgresql://user:password@db:5432/branding_app
JWT_PASSPHRASE=your_jwt_secret

GEMINI_API_KEY=
GEMINI_API_URL=

FRONTEND_URL=
```

## 📖 API Documentation

The API is documented using OpenAPI/Swagger.

Local: http://localhost:8000/api

## 🧪 Testing

```bash
make test
```

## 🤝 Contributing

**1.** Fork the repo

**2.** Create a new branch (git checkout -b feature/your-feature)

**3.** Commit changes (git commit -m 'Add new feature')

**4.** Push to branch (git push origin feature/your-feature)

**5.** Create Pull Request
