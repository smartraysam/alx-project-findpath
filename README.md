<div align="center">

![Alt text](public/assets/logo.svg)

# FindPath Project

</div>


**An ALX Profolio project**

Welcome to the FindPath project! FindPath is a navigation application designed to simplify your journeys, providing efficient routes and local exploration. This repository contains the source code and development setup instructions for local deployment.
![image](https://github.com/smartraysam/findpath/assets/6819477/1e7e3e3b-6f31-4506-b876-8165f1456c5c)

## Stack Used

- **Laravel:** A powerful PHP framework for building web applications.
- **Tailwind CSS:** A utility-first CSS framework for rapidly building custom designs.
- **HTML, jQuery, JavaScript:** Essential web technologies for dynamic and interactive user experiences.
- **MySQL:** A robust relational database for storing and managing data.

## Local Development Setup

### Using Laragon

1. **Install Laragon:**
   Download and install [Laragon](https://laragon.org/download/index.html) for a hassle-free local development environment.

2. **Clone the Repository:**
   ```bash
   git clone https://github.com/smartraysam/findpath.git
   ```

3. **Navigate to Project:**
   ```bash
   cd findpath
   ```

4. **Install Dependencies:**
   ```bash
   composer install
   ```

5. **Create Environment File:**
   Duplicate `.env.example` to `.env` and configure your database settings.

6. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

7. **Run Migrations and Seed Database:**
   ```bash
   php artisan migrate --seed
   ```

8. **Start the Development Server:**
   ```bash
   php artisan serve
   ```

9. **Open in Browser:**
   Visit [http://localhost:8000](http://localhost:8000) to see FindPath in action!

### Using Docker

1. **Install Docker:**
   Download and install [Docker](https://www.docker.com/get-started) on your machine.

2. **Clone the Repository:**
   ```bash
   git clone https://github.com/smartraysam/findpath.git
   ```

3. **Navigate to Project:**
   ```bash
   cd findpath
   ```

4. **Create Environment File:**
   Duplicate `.env.example` to `.env` and configure your database settings.

5. **Build and Run Docker Containers:**
   ```bash
   docker-compose up -d --build
   ```

6. **Run Migrations and Seed Database:**
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

7. **Open in Browser:**
   Visit [http://localhost:8000](http://localhost:8000) to see FindPath in action!

## Contributing

We welcome contributions to enhance FindPath. Please follow our [Contribution Guidelines](CONTRIBUTING.md) for more details.

🌐 Explore More: [Visit our Profile Landing Page](https://smartraysam.github.io/findpath)

Happy coding! 🚀
